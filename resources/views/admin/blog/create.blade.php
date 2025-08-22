@extends('admin.layout.master')

@section('content')

<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">

        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Blogs</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Blog</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('admin.blog.index') }}" class="btn btn-warning px-4 raised d-flex gap-2">
                        <i class="material-icons-outlined">arrow_back</i>
                        Back
                    </a>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->

        <!-- start of content -->
        <div class="row">
            <div class="col-xl-12">
                <hr>
                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Add Blog</h5>
                        <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data" class="row g-3" id="blogAddForm">
                            @csrf

                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                            <div class="col-md-12">
                                <label for="blog_name" class="form-label">Blog Title</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="material-icons-outlined fs-5">title</i></span>
                                    <input type="text" class="form-control" id="blog_name" placeholder="Blog Title" name="blog_name">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label for="blog_category_id" class="form-label">Blog Category</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="material-icons-outlined fs-5">category</i></span>
                                    <select name="blog_category_id" id="blog_category_id" class="form-control">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label for="feature_image" class="form-label">Feature Image</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="material-icons-outlined fs-5">image</i></span>
                                    <input type="file" name="feature_image" class="form-control" id="feature_image">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label for="blog_description" class="form-label">Blog Description</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="material-icons-outlined fs-5">description</i></span>
                                    <textarea class="form-control" id="blog_description" name="blog_description" placeholder="Write blog here..." rows="6"></textarea>
                                </div>
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
        <!-- end of content -->

    </div>
</main>
<!--end main wrapper-->

@endsection

@push('scripts')

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.js"></script>

<script>
$(document).ready(function () {

    $('#blog_description').summernote({
        height: 250
    });

    $("#blogAddForm").validate({
        rules: {
            blog_name: { required: true, minlength: 2 },
            blog_category_id: { required: true },
            feature_image: { required: true, extension: "jpg|jpeg|png|gif" }
        },
        messages: {
            blog_name: { required: "Please enter blog title" },
            blog_category_id: { required: "Please select blog category" },
            feature_image: { required: "Please select a feature image", extension: "Only JPG, JPEG, PNG, or GIF files are allowed" }
        },
        errorClass: "text-danger",
        errorElement: "span",
        highlight: function (el) { $(el).addClass("is-invalid"); },
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
                        text: response.message || "Blog Added Successfully!"
                    }).then(() => {
                        window.location.href = response.redirect || "{{ route('admin.blog.index') }}";
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