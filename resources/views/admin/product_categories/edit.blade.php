@extends('admin.layout.master')

@section('content')

<main class="main-wrapper">
    <div class="main-content">

        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Product Categories</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Product Category</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('admin.productscategories.index') }}" class="btn btn-warning px-4 raised d-flex gap-2">
                        <i class="material-icons-outlined">arrow_back</i>
                        Back
                    </a>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->

        <!-- content -->
        <div class="row">
            <div class="col-xl-12">
                <hr>
                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Edit Product Category</h5>
                        
                        <form action="{{ route('admin.productscategories.update', $productscategory->id) }}" method="POST" enctype="multipart/form-data" class="row g-3" id="productCategoryEditForm">
                            @csrf
                            @method('PUT')

                            <div class="col-md-4">
                                <label for="product_category_name" class="form-label">Product Category Name</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="material-icons-outlined fs-5">category</i></span>
                                    <input type="text" class="form-control" id="product_category_name" name="product_category_name"
                                        value="{{ old('product_category_name', $productscategory->name) }}" placeholder="Product Category Name">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="product_category_slug" class="form-label">Product Category Slug</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="material-icons-outlined fs-5">description</i></span>
                                    <input type="text" class="form-control" id="product_category_slug" name="product_category_slug"
                                        value="{{ old('product_category_slug', $productscategory->slug) }}" placeholder="Product Category Slug">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="product_category_status" class="form-label">Product Category Status</label>
                                <div class="input-group">   
                                    <select class="form-select" id="product_category_status" name="product_category_status">
                                        <option value="active" {{ $productscategory->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ $productscategory->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3 mt-3">
                                    <button type="submit" class="btn btn-primary px-4 d-flex align-items-center">
                                        <i class="material-icons-outlined me-2" style="font-size:18px;">save</i>
                                        <span>Update</span>
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
        <!-- end content -->

    </div>
</main>

@endsection

@push('scripts')

<script>
$(document).ready(function () {

    // Auto-generate slug from name
    $('#product_category_name').on('keyup', function () {
        let slug = $(this).val().toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/(^-|-$)+/g, '');
        $('#product_category_slug').val(slug);
    });

    // validate + ajax submit
    $("#productCategoryEditForm").validate({
        rules: {
            product_category_name: { required: true, minlength: 2 },
            product_category_slug: { required: true, minlength: 2 },
        },
        messages: {
            product_category_name: { required:"Please enter Product Category Name" },
            product_category_slug: { required:"Please enter Product Category Slug" },
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
                        text: response.message || "Product Category Updated Successfully!"
                    }).then(() => {
                        window.location.href = response.redirect || "{{ route('admin.productscategories.index') }}"; // ✅ fixed route
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
