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
                        <li class="breadcrumb-item active" aria-current="page">Add Product</li>
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
                        <h5 class="mb-4">Add New Product</h5>
                        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="row g-3" id="productAddForm">
                            @csrf

                            <!-- Category -->
                            <div class="col-md-4">
                                <label for="category_id" class="form-label">Product Category</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="material-icons-outlined fs-5">category</i></span>
                                    <select name="category_id" id="category_id" class="form-select">
                                        <option value="">Select Category</option>
                                        @foreach(App\Models\ProductCategory::where('status','active')->get() as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Product Name -->
                            <div class="col-md-4">
                                <label for="product_name" class="form-label">Product Name</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="material-icons-outlined fs-5">inventory_2</i></span>
                                    <input type="text" class="form-control" id="product_name" placeholder="Product Name" name="product_name">
                                </div>
                            </div>

                            <!-- Product Status -->
                            <div class="col-md-4">
                                <label for="product_status" class="form-label">Status</label>
                                <div class="input-group">   
                                    <select class="form-select" id="product_status" name="product_status">
                                        <option value="draft">Draft</option>
                                        <option value="publish">Publish</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Short Description -->
                            <div class="col-md-12">
                                <label for="product_short_description" class="form-label">Short Description</label>
                                <textarea class="form-control" id="product_short_description" name="product_short_description" rows="3"></textarea>
                            </div>

                            <!-- Description -->
                            <div class="col-md-12">
                                <label for="product_description" class="form-label">Description</label>
                                <textarea class="form-control summernote" id="product_description" name="product_description"></textarea>
                            </div>

                            <!-- Price -->
                            <div class="col-md-3">
                                <label for="price" class="form-label">Price</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="material-icons-outlined fs-5">attach_money</i></span>
                                    <input type="number" class="form-control" id="price" name="price" >
                                </div>
                            </div>

                            <!-- Sale Price -->
                            <div class="col-md-3">
                                <label for="sale_price" class="form-label">Sale Price</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="material-icons-outlined fs-5">sell</i></span>
                                    <input type="number" class="form-control" id="sale_price" name="sale_price">
                                </div>
                            </div>

                            <!-- Feature Image -->
                            <div class="col-md-3">
                                <label for="feature_image" class="form-label">Feature Image</label>
                                <input type="file" class="form-control" id="feature_image" name="feature_image" accept="image/*">
                            </div>

                            <!-- Gallery Images -->
                            <div class="col-md-3">
                                <label for="gallery_images" class="form-label">Gallery Images</label>
                                <input type="file" class="form-control" id="gallery_images" name="gallery_images[]" accept="image/*" multiple>
                            </div>

                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3 mt-3">
                                    <button type="submit" class="btn btn-primary px-4 d-flex align-items-center">
                                        <i class="material-icons-outlined me-2" style="font-size:18px;">add</i>
                                        <span>Insert</span>
                                    </button>

                                    <button type="reset" class="btn btn-secondary px-4 d-flex align-items-center">
                                        <i class="material-icons-outlined me-2" style="font-size:18px;">refresh</i>
                                        <span>Reset</span>
                                    </button>
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
$(document).ready(function () {

    $('.summernote').summernote({
        height: 200
    });

    // validate form
    $("#productAddForm").validate({
        rules: {
            product_name: { 
                required: true, 
                minlength: 2 
            },
            category_id: { 
                required: true 
            },
            price: { 
                required: true, 
                number: true 
            },
            product_short_description:{
                required: true, 
            },
            product_description:{
                required: true, 
            },
            feature_image: { 
                required: true, 
                extension: "jpg|jpeg|png|gif" 
            }
        },
        messages: {
            product_name: { 
                required: "Please enter product name" 
            },
            category_id: { 
                required: "Please select category" 
            },
            price: { 
                required: "Please enter price", 
                number: "Enter a valid number" 
            },
            product_short_description:{
                required: "Please enter product Short Description" , 
            },
            product_description:{
                required: "Please enter product Description" , 
            },
            feature_image: { 
                required: "Please select a feature image", 
                extension: "Only JPG, JPEG, PNG, or GIF files are allowed" 
            }
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
                        text: response.message || "Product Added Successfully!"
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
