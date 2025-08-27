<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ProductCategory::withTrashed()->select(['id','name','slug','status','deleted_at']);

            return DataTables::of($data)
                ->editColumn('status', function ($row) {
                    if ($row->deleted_at) {
                        return '<span class="badge bg-secondary">Deleted</span>';
                    }
                    return $row->status == 'active' || $row->status == 1
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '';
                    if ($row->deleted_at) {
                        $buttons .= '
                            <div class="d-flex gap-2">
                                <form action="'.route('admin.productscategories.restore', $row->id).'" method="POST">
                                    '.csrf_field().'
                                    <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm(\'Restore this category?\')">
                                        Restore
                                    </button>
                                </form>
                                <form action="'.route('admin.productscategories.forceDelete', $row->id).'" method="POST">
                                    '.csrf_field().method_field('DELETE').'
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Permanently delete?\')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        ';
                    } else {
                        $buttons .= '
                            <div class="d-flex gap-2">
                                <a href="'.route('admin.productscategories.edit', $row->id).'" class="btn btn-sm btn-info">
                                    Edit
                                </a>
                                <form action="'.route('admin.productscategories.destroy', $row->id).'" method="POST">
                                    '.csrf_field().method_field('DELETE').'
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Soft delete this?\')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        ';
                    }
                    return $buttons;
                })
                ->rawColumns(['status' , 'action'])
                ->make(true);
        }
        
        return view('admin.product_categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_category_name'  => 'required|string|min:3|max:255',
            'product_category_slug'  => 'required|string|min:3|max:255',
            'product_category_status'=> 'required|in:active,inactive',
        ]);

        ProductCategory::create([
            'name'   => $request->product_category_name,
            'slug'   => $request->product_category_slug,
            'status' => $request->product_category_status,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'message'  => 'Product Category created successfully!',
                'redirect' => route('admin.productscategories.index'),
            ]);
        }

        return redirect()->route('admin.productscategories.index')
                        ->with('success','Product Category created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $productscategory) // parameter name should match route model binding
    {
        return view('admin.product_categories.edit', compact('productscategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $productscategory)
    {
        $request->validate([
            'product_category_name'   => 'required|string|min:3|max:255',
            'product_category_slug'   => 'required|string|min:3|max:255',
            'product_category_status' => 'required|in:active,inactive',
        ]);

        $productscategory->update([
            'name'   => $request->product_category_name,
            'slug'   => $request->product_category_slug,
            'status' => $request->product_category_status,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'message'  => 'Product Category updated successfully!',
                'redirect' => route('admin.productscategories.index'), // fixed route name
            ]);
        }

        return redirect()->route('admin.productscategories.index') // fixed route name
                        ->with('success', 'Product Category updated successfully.');
    }

    /**
     * Soft delete.
     */
    public function destroy(ProductCategory $productscategory)
    {
        $productscategory->delete();
        return redirect()->route('admin.productscategories.index')
                        ->with('success','Product Category soft deleted.');
    }

    /**
     * Restore.
     */
    public function restore($id)
    {
        $productCategory = ProductCategory::onlyTrashed()->findOrFail($id);
        $productCategory->restore();
        return redirect()->route('admin.productscategories.index')
                        ->with('success','Product Category restored successfully.');
    }

    /**
     * Permanently delete.
     */
    public function forceDelete($id)
    {
        $productCategory = ProductCategory::onlyTrashed()->findOrFail($id);
        $productCategory->forceDelete();
        return redirect()->route('admin.productscategories.index')
                        ->with('success','Product Category permanently deleted.');
    }

    /**
     * Bulk soft delete.
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'No categories selected.']);
        }

        ProductCategory::whereIn('id', $ids)->delete(); // soft delete

        return response()->json(['success' => true, 'message' => 'Selected categories deleted successfully.']);
    }
}
