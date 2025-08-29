<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Banner::withTrashed()->select([
                'id', 
                'title', 
                'description', 
                'background_image', 
                'button1_text', 
                'button1_link', 
                'button2_text', 
                'button2_link', 
                'sequence_number', 
                'deleted_at'
            ]);

            return DataTables::of($data)
                ->addColumn('description', function($row){
                    return Str::limit(strip_tags($row->description), 50, '...');
                })
                ->addColumn('background_image', function($row){
                    if ($row->background_image) {
                        return '<img src="'.asset('uploads/banners/'.$row->background_image).'" 
                                    alt="Banner Image" class="img-thumbnail" style="max-height:50px;object-fit:cover;"/>';
                    }
                    return '<img src="'.asset('admin_assets/images/avatars/01.png').'" 
                                    alt="Default Image" width="50" height="50" style="object-fit:cover;"/>';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '';
                    if ($row->deleted_at) {
                        $buttons .= '
                            <div class="d-flex gap-2">
                                <form action="'.route('admin.banners.restore', $row->id).'" method="POST">
                                    '.csrf_field().'
                                    <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm(\'Restore this banner?\')">Restore</button>
                                </form>
                                <form action="'.route('admin.banners.forceDelete', $row->id).'" method="POST">
                                    '.csrf_field().method_field('DELETE').'
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Permanently delete?\')">Delete</button>
                                </form>
                            </div>
                        ';
                    } else {
                        $buttons .= '
                            <div class="d-flex gap-2">
                                <a href="'.route('admin.banners.edit', $row->id).'" class="btn btn-sm btn-info">Edit</a>
                                <form action="'.route('admin.banners.destroy', $row->id).'" method="POST">
                                    '.csrf_field().method_field('DELETE').'
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Soft delete this banner?\')">Delete</button>
                                </form>
                            </div>
                        ';
                    }
                    return $buttons;
                })
                ->rawColumns(['background_image','action'])
                ->make(true);
        }
        return view('admin.banners.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        // Validate input
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'background_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'button1_text' => 'required|string|max:255',
            'button1_link' => 'required|url|max:255',
            'button2_text' => 'required|string|max:255',
            'button2_link' => 'required|url|max:255',
            'sequence_number' => 'required|integer',
        ]);

        // Handle background image upload
        $filename = null;
        if ($request->hasFile('background_image')) {
            $image = $request->file('background_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/banners'), $filename);
        }

        // Create Banner
        Banner::create([
            'title' => $request->title,
            'description' => $request->description,
            'background_image' => $filename,
            'button1_text' => $request->button1_text,
            'button1_link' => $request->button1_link,
            'button2_text' => $request->button2_text,
            'button2_link' => $request->button2_link,
            'sequence_number' => $request->sequence_number,
        ]);

        return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified banner.
     */
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        // Validate input
        $request->validate([
            'title' => 'required|string|min:2|max:255',
            'description' => 'required|string|max:1000',
            'background_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'button1_text' => 'required|string|max:255',
            'button1_link' => 'required|url|max:255',
            'button2_text' => 'required|string|max:255',
            'button2_link' => 'required|url|max:255',
            'sequence_number' => 'required|integer',
        ]);

        // Keep current image by default
        $filename = $banner->background_image;

        // Handle new background image upload
        if ($request->hasFile('background_image')) {
            if ($banner->background_image && file_exists(public_path($banner->background_image))) {
                unlink(public_path($banner->background_image));
            }

            $image = $request->file('background_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/banners'), $filename);

            // Save relative path
            $banner->background_image = 'uploads/banners/' . $filename;
        }

        // Update banner
        $banner->update([
            'title' => $request->title,
            'description' => $request->description,
            'background_image' => $filename,
            'button1_text' => $request->button1_text,
            'button1_link' => $request->button1_link,
            'button2_text' => $request->button2_text,
            'button2_link' => $request->button2_link,
            'sequence_number' => $request->sequence_number,
        ]);

        return redirect()->route('admin.banners.index')->with('success', 'Banner updated successfully.');
    }

    /**
     * Soft delete a banner.
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();
        return redirect()->route('admin.banners.index')->with('success', 'Banner soft deleted.');
    }

    /**
     * Restore a soft deleted banner.
     */
    public function restore($id)
    {
        $banner = Banner::onlyTrashed()->findOrFail($id);
        $banner->restore();
        return redirect()->route('admin.banners.index')->with('success', 'Banner restored successfully.');
    }

    /**
     * Permanently delete a banner.
     */
    public function forceDelete($id)
    {
        $banner = Banner::onlyTrashed()->findOrFail($id);

        // Delete background image if exists
        if ($banner->background_image && file_exists(public_path('uploads/banners/'.$banner->background_image))) {
            unlink(public_path('uploads/banners/'.$banner->background_image));
        }

        $banner->forceDelete();

        return redirect()->route('admin.banners.index')->with('success', 'Banner permanently deleted.');
    }

    /**
     * Bulk soft delete banners.
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        if (empty($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'No banners selected.'
            ]);
        }

        Banner::whereIn('id', $ids)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Selected banners have been deleted successfully.'
        ]);
    }
}
