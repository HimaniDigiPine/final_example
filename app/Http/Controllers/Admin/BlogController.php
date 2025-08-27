<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;


class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Blog::with(['category', 'user'])->withTrashed()->select('blogs.*');

            return DataTables::of($data)
                ->addColumn('feature_image', function($row) {
                    return $row->feature_image
                        ? '<img src="'.asset('uploads/blog/'.$row->feature_image).'" width="50" style="object-fit:cover;">'
                        : '';
                })
                ->addColumn('category_name', function($row) {
                    return $row->category?->category_name ?? '';
                })
                ->addColumn('user_name', function($row) {
                    return $row->user?->name ?? '';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '';
                    if ($row->deleted_at) {
                        $buttons .= '<div class="d-flex gap-2"><form action="'.route('admin.blog.restore', $row->id).'" method="POST">'.csrf_field().'<button type="submit" class="btn btn-warning btn-sm" onclick="return confirm(\'Restore this?\')">Restore</button></form>';
                        $buttons .= '<form action="'.route('admin.blog.forceDelete', $row->id).'" method="POST">'.csrf_field().method_field('DELETE').'<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Permanently delete?\')">Delete</button></form></div>';
                    } else {
                        $buttons .= '<div class="d-flex gap-2"><a href="'.route('admin.blog.edit', $row->id).'" class="btn btn-info btn-sm">Edit</a>';
                        $buttons .= '<form action="'.route('admin.blog.destroy', $row->id).'" method="POST">'.csrf_field().method_field('DELETE').'<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Soft delete this?\')">Delete</button></form></div>';
                    }
                    return $buttons;
                })
                ->rawColumns(['feature_image','action'])
                ->make(true);
        }

        return view('admin.blog.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = BlogCategory::all();
        return view('admin.blog.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'blog_name'=>'required|string|max:255',
            'blog_category_id'=>'required|exists:blog_categories,id',
            'feature_image'=>'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'blog_description'=>'nullable|string',
        ]);

        $filename = null;
        if($request->hasFile('feature_image')){
            $image = $request->file('feature_image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/blog'), $filename);
        }

        Blog::create([
            'blog_name'=>$request->blog_name,
            'blog_category_id'=>$request->blog_category_id,
            'feature_image'=>$filename,
            'blog_description'=>$request->blog_description,
            'user_id'=>auth()->id(),
        ]);

        return redirect()->route('admin.blog.index')->with('success','Blog created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        $categories = BlogCategory::all();
        return view('admin.blog.edit', compact('blog','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'blog_name'=>'required|string|max:255',
            'blog_category_id'=>'required|exists:blog_categories,id',
            'feature_image'=>'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'blog_description'=>'nullable|string',
        ]);

        $filename = $blog->feature_image;

        if($request->hasFile('feature_image')){
            if($blog->feature_image && file_exists(public_path('uploads/blog/'.$blog->feature_image))){
                unlink(public_path('uploads/blog/'.$blog->feature_image));
            }
            $image = $request->file('feature_image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/blog'), $filename);
        }

        $blog->update([
            'blog_name'=>$request->blog_name,
            'blog_category_id'=>$request->blog_category_id,
            'feature_image'=>$filename,
            'blog_description'=>$request->blog_description,
        ]);

        return redirect()->route('admin.blog.index')->with('success','Blog updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect()->route('admin.blog.index')->with('success','Blog soft deleted.');
    }

    /**
     * Restore the soft deleted blog.
     */
    public function restore($id)
    {
        $blog = Blog::onlyTrashed()->findOrFail($id);
        $blog->restore();
        return redirect()->route('admin.blog.index')->with('success','Blog restored.');
    }

    /**
     * Permanently delete the blog.
     */
    public function forceDelete($id)
    {
        $blog = Blog::onlyTrashed()->findOrFail($id);
        if($blog->feature_image && file_exists(public_path('uploads/blog/'.$blog->feature_image))){
            unlink(public_path('uploads/blog/'.$blog->feature_image));
        }
        $blog->forceDelete();
        return redirect()->route('admin.blog.index')->with('success','Blog permanently deleted.');
    }

    /**
     * Bulk soft delete.
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if (!empty($ids)) {
            Blog::whereIn('id', $ids)->delete();
        }
        return response()->json(['success' => 'Selected blogs deleted successfully.']);
    }
}
