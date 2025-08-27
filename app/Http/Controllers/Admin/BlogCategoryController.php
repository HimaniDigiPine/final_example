<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = BlogCategory::withTrashed()->select(['id','category_name','category_image','category_small_description','deleted_at']);

            return DataTables::of($data)
                ->addColumn('category_small_description', function($row){
                    // Strip HTML and limit to 50 characters
                    return Str::limit(strip_tags($row->category_small_description), 50, '...');
                })
                ->addColumn('image', function ($row) {
                    if ($row->category_image) {
                        return '<img src="'.asset('uploads/blog_category/'.$row->category_image).'" 
                                    alt="Category Image" class="img-thumbnail" style="max-height:50px;object-fit:cover;"/>';
                    }
                    return '<img src="'.asset('admin_assets/images/avatars/01.png').'" 
                                    alt="Default Image" width="50" height="50" style="object-fit:cover;"/>';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '';
                    if ($row->deleted_at) {
                        $buttons .= '
                            <div class="d-flex gap-2">
                                <form action="'.route('admin.blog-categories.restore', $row->id).'" method="POST">
                                    '.csrf_field().'
                                    <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm(\'Restore this?\')">Restore</button>
                                </form>
                                <form action="'.route('admin.blog-categories.forceDelete', $row->id).'" method="POST">
                                    '.csrf_field().method_field('DELETE').'
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Permanently delete?\')">Delete</button>
                                </form>
                            </div>
                        ';
                    } else {
                        $buttons .= '
                            <div class="d-flex gap-2">
                                <a href="'.route('admin.blog-categories.edit', $row->id).'" class="btn btn-sm btn-info">Edit</a>
                                <form action="'.route('admin.blog-categories.destroy', $row->id).'" method="POST">
                                    '.csrf_field().method_field('DELETE').'
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Soft delete this?\')">Delete</button>
                                </form>
                            </div>
                        ';
                    }
                    return $buttons;
                })
                ->rawColumns(['image','action'])
                ->make(true);
        }
        return view('admin.blog_categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blog_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|min:3|max:255',
            'category_small_description' => 'nullable|string|max:255',
            'category_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        $filename = null;
        if ($request->hasFile('category_image')) {
            $image = $request->file('category_image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/blog_category'), $filename);
        }

        BlogCategory::create([
            'category_name' => $request->category_name,
            'category_small_description' => $request->category_small_description,
            'category_image' => $filename,
        ]);

        return redirect()->route('admin.blog-categories.index')->with('success','Category created successfully.');
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
    public function edit(BlogCategory $blogCategory)
    {
        return view('admin.blog_categories.edit', compact('blogCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlogCategory $blogCategory)
    {
        $request->validate([
            'category_name' => 'required|string|min:3|max:255',
            'category_small_description' => 'nullable|string|max:255',
            'category_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        $filename = $blogCategory->category_image;

        if ($request->hasFile('category_image')) {
            if ($blogCategory->category_image && file_exists(public_path('uploads/blog_category/'.$blogCategory->category_image))) {
                unlink(public_path('uploads/blog_category/'.$blogCategory->category_image));
            }

            $image = $request->file('category_image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/blog_category'), $filename);
        }

        $blogCategory->update([
            'category_name' => $request->category_name,
            'category_small_description' => $request->category_small_description,
            'category_image' => $filename,
        ]);

        return redirect()->route('admin.blog-categories.index')->with('success','Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogCategory $blogCategory)
    {
        $blogCategory->delete();
        return redirect()->route('admin.blog-categories.index')->with('success','Category soft deleted.');
    }

    /**
     * Restore the soft deleted category.
     */
    public function restore($id)
    {
        $category = BlogCategory::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('admin.blog-categories.index')->with('success','Category restored successfully.');
    }

    /**
     * Permanently delete the category.
     */
    public function forceDelete($id)
    {
        $category = BlogCategory::onlyTrashed()->findOrFail($id);
        if ($category->category_image && file_exists(public_path('uploads/blog_category/'.$category->category_image))) {
            unlink(public_path('uploads/blog_category/'.$category->category_image));
        }
        $category->forceDelete();
        return redirect()->route('admin.blog-categories.index')->with('success','Category permanently deleted.');
    }

    /**
     * Bulk soft delete.
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        if (empty($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'No options selected.'
            ]);
        }

        // Soft delete the selected categories
        BlogCategory::whereIn('id', $ids)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Selected Blog Categories have been deleted successfully.'
        ]);
    }
}
