<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        {
            if ($request->ajax()) {
                $data = Product::with(['category'])->withTrashed()
                    ->select(['id','category_id','product_name','price','sale_price','product_status','feature_image','deleted_at']);

                return DataTables::of($data)
                    ->addColumn('category', function ($row) {
                        return $row->category ? $row->category->name : '<span class="text-muted">No Category</span>';
                    })
                    ->editColumn('product_status', function ($row) {
                        if ($row->deleted_at) {
                            return '<span class="badge bg-secondary">Deleted</span>';
                        }
                        return $row->product_status == 'publish'
                            ? '<span class="badge bg-success">Published</span>'
                            : '<span class="badge bg-warning">Draft</span>';
                    })
                    ->editColumn('price', function ($row) {
                        return '₹' . number_format($row->price, 2);
                    })
                    ->editColumn('sale_price', function ($row) {
                        return $row->sale_price ? '₹' . number_format($row->sale_price, 2) : '-';
                    })
                    ->addColumn('feature_image', function ($row) {
                        if ($row->feature_image) {
                            $url = asset('uploads/products/feature_images/'.$row->feature_image);
                            return '<img src="'.$url.'" alt="Feature" width="50" height="50" class="rounded">';
                        }
                        return '<span class="text-muted">No Image</span>';
                    })
                    ->addColumn('action', function ($row) {
                        $buttons = '';
                        if ($row->deleted_at) {
                            $buttons .= '
                                <div class="d-flex gap-2">
                                    <form action="'.route('admin.products.restore', $row->id).'" method="POST">
                                        '.csrf_field().'
                                        <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm(\'Restore this product?\')">
                                            Restore
                                        </button>
                                    </form>
                                    <form action="'.route('admin.products.forceDelete', $row->id).'" method="POST">
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
                                    <a href="'.route('admin.products.edit', $row->id).'" class="btn btn-sm btn-info">
                                        Edit
                                    </a>
                                    <form action="'.route('admin.products.destroy', $row->id).'" method="POST">
                                        '.csrf_field().method_field('DELETE').'
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Soft delete this product?\')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            ';
                        }
                        return $buttons;
                    })
                ->rawColumns(['category','product_status','feature_image','action'])
                ->make(true);
            }

            return view('admin.products.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'               => 'required|exists:product_categories,id',
            'product_name'              => 'required|string|min:2|max:255',
            'product_short_description' => 'nullable|string|max:500',
            'product_description'       => 'nullable|string',
            'product_status'            => 'required|in:draft,publish',
            'price'                     => 'required|numeric|min:0',
            'sale_price'                => 'nullable|numeric|min:0|lte:price',
            'feature_image'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery_images.*'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // --- Feature Image Upload ---
        $featureImageName = null;
        if ($request->hasFile('feature_image')) {
            $image = $request->file('feature_image');
            $featureImageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/products/feature_images'), $featureImageName);
        }

        // --- Save Product ---
        $product = Product::create([
            'category_id'               => $validated['category_id'],
            'product_name'              => $validated['product_name'],
            'product_short_description' => $validated['product_short_description'] ,
            'product_description'       => $validated['product_description'],
            'product_status'            => $validated['product_status'],
            'price'                     => $validated['price'],
            'sale_price'                => $validated['sale_price'] ?? null,
            'feature_image'             => $featureImageName,
        ]);

        // --- Gallery Uploads ---
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $galleryName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/products/gallery'), $galleryName);

                ProductGallery::create([
                    'product_id' => $product->id,
                    'image'      => $galleryName,
                ]);
            }
        }

        // --- Response for AJAX ---
        return response()->json([
            'success'  => true,
            'message'  => 'Product created successfully!',
            'redirect' => route('admin.products.index'),
        ]);
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
    public function edit(Product $product)
    {
        // Eager load gallery images for the edit view
        $product->load('galleries', 'category');
        return view('admin.products.edit', compact('product'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id'               => 'required|exists:product_categories,id',
            'product_name'              => 'required|string|min:2|max:255',
            'product_short_description' => 'nullable|string|max:500',
            'product_description'       => 'nullable|string',
            'product_status'            => 'required|in:draft,publish',
            'price'                     => 'required|numeric|min:0',
            'sale_price'                => 'nullable|numeric|min:0|lte:price',
            'feature_image'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery_images.*'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        /** -------------------------
         * Handle Feature Image
         * ------------------------- */
        $featureImageName = $product->feature_image; // keep old image if no new one uploaded
        if ($request->hasFile('feature_image')) {
            // delete old
            if ($featureImageName && file_exists(public_path('uploads/products/feature_images/' . $featureImageName))) {
                unlink(public_path('uploads/products/feature_images/' . $featureImageName));
            }
            $image = $request->file('feature_image');
            $featureImageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/products/feature_images'), $featureImageName);
        }

        /** -------------------------
         * Update product fields
         * ------------------------- */
        $product->update([
            'category_id'               => $validated['category_id'],
            'product_name'              => $validated['product_name'],
            'product_short_description' => $validated['product_short_description'],
            'product_description'       => $validated['product_description'],
            'product_status'            => $validated['product_status'],
            'price'                     => $validated['price'],
            'sale_price'                => $validated['sale_price'] ?? null,
            'feature_image'             => $featureImageName,
        ]);

        /** -------------------------
         * Handle Gallery Uploads
         * ------------------------- */
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $galleryName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/products/gallery'), $galleryName);

                ProductGallery::create([
                    'product_id' => $product->id,
                    'image'      => $galleryName,
                ]);
            }
        }

        /** -------------------------
         * Response
         * ------------------------- */
        if ($request->ajax()) {
            return response()->json([
                'success'  => true,
                'message'  => 'Product updated successfully!',
                'redirect' => route('admin.products.index'),
            ]);
        }

        return redirect()->route('admin.products.index')
                        ->with('success', 'Product updated successfully.');
    }


    public function deleteGallery($id)
    {
        $gallery = ProductGallery::findOrFail($id);

        // Delete file
        if ($gallery->image && file_exists(public_path('uploads/products/gallery/' . $gallery->image))) {
            unlink(public_path('uploads/products/gallery/' . $gallery->image));
        }

        $gallery->delete();

        return response()->json([
            'success' => true,
            'message' => 'Gallery image deleted successfully.'
        ]);
    }

   /**
     * Soft delete a product.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')
                        ->with('success', 'Product soft deleted.');
    }

    /**
     * Restore a soft-deleted product.
     */
    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('admin.products.index')
                        ->with('success', 'Product restored successfully.');
    }

    /**
     * Permanently delete a product.
     */
    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->with('galleries')->findOrFail($id);

        // ✅ Delete feature image if exists
        if ($product->feature_image && Storage::exists('public/products/' . $product->feature_image)) {
            Storage::delete('public/products/' . $product->feature_image);
        }

        // ✅ Delete gallery images
        foreach ($product->galleries as $gallery) {
            if ($gallery->image && Storage::exists('public/products/gallery/' . $gallery->image)) {
                Storage::delete('public/products/gallery/' . $gallery->image);
            }
            $gallery->forceDelete(); // remove record
        }

        // ✅ Permanently delete product
        $product->forceDelete();

        return redirect()->route('admin.products.index')
                        ->with('success', 'Product and related images permanently deleted.');
    }

    /**
     * Bulk soft delete products.
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        if (empty($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'No products selected.'
            ]);
        }

        Product::whereIn('id', $ids)->delete(); // soft delete

        return response()->json([
            'success' => true,
            'message' => 'Selected products deleted successfully.'
        ]);
    }
}
