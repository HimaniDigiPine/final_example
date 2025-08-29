@extends('admin.layout.master')

@section('content')

<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">

        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Banners</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Banner</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-warning px-4 raised d-flex gap-2">
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
                        <h5 class="mb-4">Edit Banner</h5>
                        <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data" class="row g-3" id="bannerEditForm">
                            @csrf
                            @method('PUT')

                            <div class="col-md-6">
                                <label for="title" class="form-label">Banner Title</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="material-icons-outlined fs-5">title</i></span>
                                    <input type="text" class="form-control" id="title" placeholder="Banner Title" name="title" value="{{ old('title', $banner->title) }}">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="sequence_number" class="form-label">Sequence Number</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="material-icons-outlined fs-5">format_list_numbered</i></span>
                                    <input type="text" name="sequence_number" class="form-control" id="sequence_number" value="{{ old('sequence_number', $banner->sequence_number) }}">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label for="description" class="form-label">Description</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="material-icons-outlined fs-5">description</i></span>
                                    <textarea class="form-control" id="description" name="description" placeholder="Write description here..." rows="6">{{ old('description', $banner->description) }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="button1_text" class="form-label">Button 1 Text</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="material-icons-outlined">text_fields</i></span>
                                    <input type="text" class="form-control" id="button1_text" placeholder="Button 1 Text" name="button1_text" value="{{ old('button1_text', $banner->button1_text) }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="button1_link" class="form-label">Button 1 Link</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="material-icons-outlined">link</i></span>
                                    <input type="text" class="form-control" id="button1_link" placeholder="Button 1 Link" name="button1_link" value="{{ old('button1_link', $banner->button1_link) }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="button2_text" class="form-label">Button 2 Text</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="material-icons-outlined">text_fields</i></span>
                                    <input type="text" class="form-control" id="button2_text" placeholder="Button 2 Text" name="button2_text" value="{{ old('button2_text', $banner->button2_text) }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="button2_link" class="form-label">Button 2 Link</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="material-icons-outlined">link</i></span>
                                    <input type="text" class="form-control" id="button2_link" placeholder="Button 2 Link" name="button2_link" value="{{ old('button2_link', $banner->button2_link) }}">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label for="background_image" class="form-label">Background Image</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="material-icons-outlined fs-5">image</i></span>
                                    <input type="file" name="background_image" class="form-control" id="background_image">
                                </div>
                                @if($banner->background_image)
                                    <img src="{{ asset('uploads/banners/'.$banner->background_image) }}" alt="Banner Image" class="img-thumbnail mt-2" style="max-height:100px;">
                                @endif
                            </div>

                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3 mt-3">
                                    <button type="submit" class="btn btn-primary px-4 d-flex align-items-center">
                                        <i class="material-icons-outlined me-2" style="font-size:18px;">edit</i>
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
        <!-- end of content -->

    </div>
</main>
<!--end main wrapper-->

@endsection

@push('scripts')

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- jQuery Validation Plugin -->
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>

<script>
$(document).ready(function () {
    $("#bannerEditForm").validate({
        rules: {
            title: { required: true, minlength: 2 },
            sequence_number: { required: true, number: true },
            description: { required: true },
            button1_text: { required: true },
            button1_link: { required: true, url: true },
            button2_text: { required: true },
            button2_link: { required: true, url: true },
        },
        messages: {
            title: { required: "Please enter banner title", minlength: "Title must be at least 2 characters" },
            sequence_number: { required: "Please enter sequence number", number: "Must be numeric" },
            description: { required: "Please enter banner description" },
            button1_text: { required: "Please enter Button 1 text" },
            button1_link: { required: "Please enter Button 1 link", url: "Enter a valid URL" },
            button2_text: { required: "Please enter Button 2 text" },
            button2_link: { required: "Please enter Button 2 link", url: "Enter a valid URL" },
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
                beforeSend: function () {},
                success: function (response) {
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: response.message || "Banner Updated Successfully!"
                    }).then(() => {
                        window.location.href = response.redirect || "{{ route('admin.banners.index') }}";
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
