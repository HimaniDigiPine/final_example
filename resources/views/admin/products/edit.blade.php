@extends('admin.layout.master')

@section('content')

<main class="main-wrapper">
    <div class="main-content">

        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Products</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-warning px-4 raised d-flex gap-2">
                        <i class="material-icons-outlined">arrow_back</i>
                        Back
                    </a>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="row">
            <div class="col-xl-12">
                <hr>
                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Edit Product</h5>
                        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="row g-3" id="productEditForm">
                            @csrf
                            @method('PUT')

                            <!-- Category -->
                            <div class="col-md-4">
                                <label for="category_id" class="form-label">Product Category</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="material-icons-outlined fs-5">category</i></span>
                                    <select name="category_id" id="category_id" class="form-select">
                                        <option value="">Select Category</option>
                                        @foreach(App\Models\ProductCategory::where('status','active')->get() as $category)
                                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Product Name -->
                            <div class="col-md-4">
                                <label for="product_name" class="form-label">Product Name</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="material-icons-outlined fs-5">inventory_2</i></span>
                                    <input type="text" class="form-control" id="product_name" name="product_name" value="{{ old('product_name', $product->product_name) }}">
                                </div>
                            </div>

                            <!-- Product Status -->
                            <div class="col-md-4">
                                <label for="product_status" class="form-label">Status</label>
                                <div class="input-group">
                                    <select class="form-select" id="product_status" name="product_status">
                                        <option value="draft" {{ $product->product_status == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="publish" {{ $product->product_status == 'publish' ? 'selected' : '' }}>Publish</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Short Description -->
                            <div class="col-md-12">
                                <label for="product_short_description" class="form-label">Short Description</label>
                                <textarea class="form-control" id="product_short_description" name="product_short_description" rows="3">{{ old('product_short_description', $product->product_short_description) }}</textarea>
                            </div>

                            <!-- Description -->
                            <div class="col-md-12">
                                <label for="product_description" class="form-label">Description</label>
                                <textarea class="form-control summernote" id="product_description" name="product_description">{{ old('product_description', $product->product_description) }}</textarea>
                            </div>

                            <!-- Price -->
                            <div class="col-md-3">
                                <label for="price" class="form-label">Price</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="material-icons-outlined fs-5">attach_money</i></span>
                                    <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $product->price) }}">
                                </div>
                            </div>

                            <!-- Sale Price -->
                            <div class="col-md-3">
                                <label for="sale_price" class="form-label">Sale Price</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="material-icons-outlined fs-5">sell</i></span>
                                    <input type="number" class="form-control" id="sale_price" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}">
                                </div>
                            </div>

                            <!-- Feature Image -->
                            <div class="col-md-3">
                                <label for="feature_image" class="form-label">Feature Image</label>
                                <input type="file" class="form-control" id="feature_image" name="feature_image" accept="image/*">
                                @if($product->feature_image)
                                    <div class="mt-2">
                                        <img src="{{ asset('uploads/products/feature_images/'.$product->feature_image) }}" alt="Feature Image" class="img-thumbnail" style="max-width: 120px;">
                                    </div>
                                @endif
                            </div>

                            <!-- Gallery Images -->
                            <div class="col-md-3">
                                <label for="gallery_images" class="form-label">Gallery Images</label>
                                <input type="file" class="form-control" id="gallery_images" name="gallery_images[]" accept="image/*" multiple>
                            </div>

                            <!-- Existing Gallery -->
                            <div class="col-md-12">
                                <div class="row mt-2">
                                    @foreach($product->galleries as $gallery)
                                        <div class="col-md-2 text-center" id="gallery-image-{{ $gallery->id }}">
                                            <img src="{{ asset('uploads/products/gallery/' . $gallery->image) }}" class="img-fluid rounded mb-2">
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="deleteGalleryImage({{ $gallery->id }})">Delete</button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3 mt-3">
                                    <button type="submit" class="btn btn-primary px-4 d-flex align-items-center">
                                        <i class="material-icons-outlined me-2" style="font-size:18px;">save</i>
                                        <span>Update</span>
                                    </button>

                                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary px-4 d-flex align-items-center">
                                        <i class="material-icons-outlined me-2" style="font-size:18px;">cancel</i>
                                        <span>Cancel</span>
                                    </a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.js"></script>

<script>

function deleteGalleryImage(id) {
    if(!confirm("Delete this image?")) return;

    fetch(`/admin/products/gallery/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById('gallery-image-' + id).remove();
        } else {
            alert('Failed to delete image');
        }
    });
}

$(document).ready(function () {

    $('.summernote').summernote({ height: 200 });

    $("#productEditForm").validate({
        rules: {
            product_name: { required: true, minlength: 2 },
            category_id: { required: true },
            price: { required: true, number: true },
            product_short_description:{ required: true },
            product_description:{ required: true },
            feature_image: { extension: "jpg|jpeg|png|gif" }
        },
        messages: {
            product_name: { required: "Please enter product name" },
            category_id: { required: "Please select category" },
            price: { required: "Please enter price", number: "Enter a valid number" },
            product_short_description:{ required: "Please enter product Short Description" },
            product_description:{ required: "Please enter product Description" },
            feature_image: { extension: "Only JPG, JPEG, PNG, or GIF files are allowed" }
        },
        errorClass: "text-danger",
        errorElement: "span",
        highlight: function (el)   { $(el).addClass("is-invalid"); },
        unhighlight: function (el) { $(el).removeClass("is-invalid"); },
        errorPlacement: function (error, element) {
            if (element.closest('.input-group').length) {
                error.insertAfter(element.closest('.input-group'));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            let formData = new FormData(form);

            $.ajax({
                url: $(form).attr('action'),
                type: $(form).attr('method'),
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: response.message || "Product Updated Successfully!"
                    }).then(() => {
                        window.location.href = response.redirect || "{{ route('admin.products.index') }}";
                    });
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: xhr.responseJSON?.message || "Something went wrong!"
                    });
                }
            });
            return false;
        }
    });

});
</script>
@endpush
