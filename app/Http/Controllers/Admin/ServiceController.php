<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Service::withTrashed()
                ->select(['id','service_name','service_image','feature_image','service_description','deleted_at']);

            return DataTables::of($data)
                ->editColumn('feature_image', function($row) {
                    return $row->feature_image
                        ? '<img src="'.asset('uploads/services/feature/'.$row->feature_image).'" width="50" style="object-fit:cover;">'
                        : '';
                })
                ->editColumn('service_image', function($row) {
                    return $row->service_image
                        ? '<img src="'.asset('uploads/services/icon/'.$row->service_image).'" width="50" style="object-fit:cover;">'
                        : '';
                })
                ->editColumn('service_description', function($row){
                    // Strip HTML and limit to 50 characters
                    return Str::limit(strip_tags($row->service_description), 50, '...');
                })
                ->addColumn('action', function ($row) {
                    $buttons = '';
                    if ($row->deleted_at) {
                        $buttons .= '<form action="'.route('admin.services.restore', $row->id).'" method="POST" style="display:inline-block;">'
                            .csrf_field().'<button type="submit" class="btn btn-warning btn-sm">Restore</button></form> ';
                        $buttons .= '<form action="'.route('admin.services.forceDelete', $row->id).'" method="POST" style="display:inline-block;">'
                            .csrf_field().method_field('DELETE').'<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Permanently delete?\')" >Delete</button></form>';
                    } else {
                        $buttons .= '<a href="'.route('admin.services.edit', $row->id).'" class="btn btn-info btn-sm">Edit</a> ';
                        $buttons .= '<form action="'.route('admin.services.destroy', $row->id).'" method="POST" style="display:inline-block;">'
                            .csrf_field().method_field('DELETE').'<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Soft delete this?\')">Delete</button></form>';
                    }
                    return $buttons;
                })
                ->rawColumns(['feature_image','service_image','action'])
                ->make(true);
        }

        return view('admin.services.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_name'=>'required|string|max:255',
            'feature_image'=>'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'service_image'=>'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'service_description'=>'nullable|string',
        ]);

        $filename = null;
        if($request->hasFile('feature_image')){
            $image = $request->file('feature_image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/services/feature'), $filename);
        }

        $filename1 = null;
        if($request->hasFile('service_image')){
            $image_service = $request->file('service_image');
            $filename1 = time().'.'.$image_service->getClientOriginalExtension();
            $image_service->move(public_path('uploads/services/icon'), $filename1);
        }

        Service::create([
            'service_name'=>$request->service_name,
            'feature_image'=>$filename,
            'service_image'=>$filename1,
            'service_description'=>$request->service_description,
        ]);

        return redirect()->route('admin.services.index')->with('success','Service created successfully.');
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
    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'service_name'=>'required|string|max:255',
            'feature_image'=>'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'service_image'=>'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'service_description'=>'nullable|string',
        ]);

        $filename = $service->feature_image;
        if ($request->hasFile('feature_image')) {
            if ($service->feature_image && file_exists(public_path('uploads/services/feature/'.$service->feature_image))) {
                unlink(public_path('uploads/services/feature/'.$service->feature_image));
            }

            $image = $request->file('feature_image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/services/feature'), $filename);
        }
        
        $filename1 = $service->service_image;
        if ($request->hasFile('service_image')) {
            if ($service->feature_image && file_exists(public_path('uploads/services/icon/'.$service->service_image))) {
                unlink(public_path('uploads/services/icon/'.$service->service_image));
            }

            $image1 = $request->file('service_image');
            $filename1 = time().'.'.$image->getClientOriginalExtension();
            $image1->move(public_path('uploads/services/icon'), $filename1);
        }

        $service->update([
            'service_name'=>$request->service_name,
            'feature_image'=>$filename,
            'service_image'=>$filename1,
            'service_description'=>$request->service_description,
        ]);

        return redirect()->route('admin.services.index')->with('success','Service updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')->with('success','Service soft deleted.');
    }

    /**
     * Restore the soft deleted category.
     */
    public function restore($id)
    {
        $service = Service::onlyTrashed()->findOrFail($id);
        $service->restore();
        return redirect()->route('admin.services.index')->with('success','Service restored successfully.');
    }

    /**
     * Permanently delete the category.
     */
    public function forceDelete($id)
    {
        $service = Service::onlyTrashed()->findOrFail($id);
        if ($service->service_image && file_exists(public_path('uploads/services/icon/'.$service->service_image))) {
            unlink(public_path('uploads/services/icon/'.$service->service_image));
        }
        if ($service->feature_image && file_exists(public_path('uploads/services/feature/'.$service->feature_image))) {
            unlink(public_path('uploads/services/feature/'.$service->feature_image));
        }
        $service->forceDelete();
        return redirect()->route('admin.services.index')->with('success','Services permanently deleted.');
    }

    /**
     * Bulk soft delete.
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if (!empty($ids)) {
            Service::whereIn('id', $ids)->delete();
        }
        return response()->json(['success' => 'Selected services deleted successfully.']);
    }
}
