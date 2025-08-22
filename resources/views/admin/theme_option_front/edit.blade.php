@extends('admin.layout.master')

@section('content')

<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">

        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">General Options</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Options</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('admin.theme_option_front.index') }}" class="btn btn-warning px-4 raised d-flex gap-2">
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
                    <div class="card-body">
                        <div class="card-body p-4">
                            <h5 class="mb-4">Update Option</h5>
                            <form action="{{ route('admin.theme_option_front.update', $themeOptionFront->id) }}" method="POST" enctype="multipart/form-data" class="row g-3" id="optionEditForm">
                                @csrf
                                @method('PUT')

                                <div class="col-md-6">
                                    <label for="input1" class="form-label">Option Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="material-icons-outlined fs-5">build</i></span>
                                        <input type="text" class="form-control" id="input1" placeholder="Option Name" name="option_name" value="{{ old('option_name', $themeOptionFront->option_name) }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="input2" class="form-label">Option Value</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="material-icons-outlined fs-5">build</i></span>
                                        <input type="text" class="form-control" id="input2" placeholder="Option Value" name="option_value" value="{{ old('option_value', $themeOptionFront->option_value) }}">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <label for="input2" class="form-label">Option Image</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="material-icons-outlined fs-5">image</i></span>
                                        <input type="file" name="option_image" class="form-control">
                                    </div>
                                    @if($themeOptionFront->option_image)
                                        <div class="mt-2">
                                            <img src="{{ asset('uploads/option_image/'.$themeOptionFront->option_image) }}" alt="Option Image" width="100">
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-12">
                                    <div class="d-md-flex d-grid align-items-center gap-3">
                                        <button type="submit" class="btn btn-info px-4 d-flex align-items-center">
                                            <i class="material-icons-outlined me-2" style="font-size:18px;">update</i>
                                            <span>Update</span>
                                        </button>

                                        <button type="reset" class="btn btn-light px-4 d-flex align-items-center">
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
        <!-- end of content -->

    </div>
</main>
<!--end main wrapper--> 

@endsection

@push('scripts')
<script>
$(document).ready(function () {

    $("#optionEditForm").validate({
        rules: {
            option_name: { required: true, minlength: 2 },
            option_value: { required: true, minlength: 2 },
            option_image: { extension: "jpg|jpeg|png|gif" } // not required on update
        },
        messages: {
            option_name: { required:"Please enter Option name" },
            option_value: { required:"Please enter Option Value" },
            option_image: { extension: "Only JPG, JPEG, PNG, or GIF files are allowed" }
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
                        text: response.message || "Option Updated Successfully!"
                    }).then(() => {
                        window.location.href = response.redirect || "{{ route('admin.theme_option_front.index') }}";
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