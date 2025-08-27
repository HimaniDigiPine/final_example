<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ThemeOptionFront;
use Yajra\DataTables\Facades\DataTables;

class ThemeOptionFrontController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) 
        {
            $data = ThemeOptionFront::withTrashed()->select(['id','option_name', 'option_value', 'option_image', 'deleted_at']);

            return DataTables::of($data)
                ->addColumn('image', function ($row) {
                    if ($row->option_image) {
                        return '<img src="'.asset('uploads/option_image/'.$row->option_image).'" 
                                    alt="Option Image" class="img-thumbnail" style="max-height:50px;" style="object-fit:cover;"/>';
                    }
                    return '<img src="'.asset('admin_assets/images/avatars/01.png').'" 
                                    alt="Default Image" width="50" height="50" style="object-fit:cover;"/>';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '';
                    if ($row->deleted_at) {
                        $buttons .= '
                            <div class="d-flex gap-2">
                                <form action="'.route('admin.theme_option_front.restore', $row->id).'" method="POST">
                                    '.csrf_field().'
                                    <button type="submit" class="btn btn-sm btn-warning d-flex align-items-center" onclick="return confirm(\'Restore this option?\')">
                                        <i class="material-icons-outlined me-1" style="font-size:16px;">restore</i> 
                                        <span style="font-size:14px;">Restore</span>
                                    </button>
                                </form>
                                <form action="'.route('admin.theme_option_front.forceDelete', $row->id).'" method="POST">
                                    '.csrf_field().method_field('DELETE').'
                                    <button type="submit" class="btn btn-sm btn-danger d-flex align-items-center" onclick="return confirm(\'Permanently delete?\')">
                                        <i class="material-icons-outlined me-1" style="font-size:16px;">delete</i> 
                                        <span style="font-size:14px;">Delete</span>
                                    </button>
                                </form>
                            </div>
                        ';
                    } else {
                        $buttons .= '
                            <div class="d-flex gap-2">
                                <a href="'.route('admin.theme_option_front.edit', $row->id).'" class="btn btn-sm btn-info d-flex align-items-center">
                                    <i class="material-icons-outlined me-1" style="font-size:16px;">edit</i> 
                                    <span style="font-size:14px;">Edit</span>
                                </a>
                                <form action="'.route('admin.theme_option_front.destroy', $row->id).'" method="POST">
                                    '.csrf_field().method_field('DELETE').'
                                    <button type="submit" class="btn btn-sm btn-danger d-flex align-items-center" onclick="return confirm(\'Soft delete this?\')">
                                        <i class="material-icons-outlined me-1" style="font-size:16px;">delete</i> 
                                        <span style="font-size:14px;">Delete</span>
                                    </button>
                                </form>
                            </div>
                        ';
                    }
                    return $buttons;
                })
                ->addColumn('status', function ($row) {
                    if ($row->deleted_at) {
                        return '<span class="badge bg-secondary">Deleted</span>';
                    }

                    $badgeClass = $row->status === 'inactive' ? 'bg-danger' : 'bg-success';
                    return '<span class="badge '.$badgeClass.'">'.ucfirst($row->status).'</span>';
                })
                ->rawColumns(['image','action', 'status'])
                ->make(true);
        }
        return view('admin.theme_option_front.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.theme_option_front.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'option_name' => 'required|string|min:3|max:255',
        'option_value' => 'required|string|min:3|max:255',
        'option_image' => 'nullable|image|mimes:jpg,jpeg,png'
        ]);

        $filename = null; // default value

        if ($request->hasFile('option_image')) {
            $image = $request->file('option_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/option_image'), $filename);
        }

        ThemeOptionFront::create([
            'option_name' => $request->option_name,
            'option_value' => $request->option_value,
            'option_image' => $filename,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Option created successfully.',
                'redirect' => route('admin.theme_option_front.index')
            ]);
        }

        return redirect()->route('admin.theme_option_front.index')->with('success', 'Option created successfully.');

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
    public function edit(ThemeOptionFront $themeOptionFront)
    {
        return view('admin.theme_option_front.edit', compact('themeOptionFront'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ThemeOptionFront $themeOptionFront)
    {
        $request->validate([
            'option_name' => 'required|string|min:3|max:255',
            'option_value' => 'required|string|min:3|max:255',
            'option_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $filename = $themeOptionFront->option_image; // keep old image by default

        if ($request->hasFile('option_image')) {
            // Delete old image if exists
            if ($themeOptionFront->option_image && file_exists(public_path('uploads/option_image/' . $themeOptionFront->option_image))) {
                unlink(public_path('uploads/option_image/' . $themeOptionFront->option_image));
            }

            // Upload new image
            $image = $request->file('option_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/option_image'), $filename);
        }

        $themeOptionFront->update([
            'option_name' => $request->option_name,
            'option_value' => $request->option_value,
            'option_image' => $filename,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Option updated successfully.',
                'redirect' => route('admin.theme_option_front.index')
            ]);
        }

        return redirect()->route('admin.theme_option_front.index')->with('success', 'Option updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ThemeOptionFront $themeOptionFront)
    {
        $themeOptionFront->delete();
        return redirect()->route('admin.theme_option_front.index')->with('success', 'Option soft deleted.');
    }

    /**
     * Restore the specified resource.
     */
    public function restore($id)
    {
        $option = ThemeOptionFront::onlyTrashed()->findOrFail($id);
        $option->restore();
        return redirect()->route('admin.theme_option_front.index')->with('success', 'Option restored successfully.');
    }

    /**
     * Permanently delete the specified resource.
     */
    public function forceDelete($id)
    {
        $option = ThemeOptionFront::onlyTrashed()->findOrFail($id);
        // Delete old image if exists
        if ($option->option_image && file_exists(public_path('uploads/option_image/' . $option->option_image))) {
            unlink(public_path('uploads/option_image/' . $option->option_image));
        }
        $option->forceDelete();
        return redirect()->route('admin.theme_option_front.index')->with('success', 'Option permanently deleted.');
    }

    /**
     * Bulk soft delete options.
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if (empty($ids)) {
            return response()->json(['success' => 'No options selected.']);
        }
        ThemeOptionFront::whereIn('id', $ids)->delete();
        return response()->json(['success' => 'Selected options have been deleted successfully.']);
    }

}
