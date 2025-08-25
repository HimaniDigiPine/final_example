@extends('admin.layout.master')

@section('content')

<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">

        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Services</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Service</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('admin.services.index') }}" class="btn btn-warning px-4 raised d-flex gap-2">
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
                        <h5 class="mb-4">Services Insert</h5>
                        <form action="{{ route('admin.services.update', $service->id) }}" method="POST" enctype="multipart/form-data" class="row g-3" id="serviceEditForm">
                            @csrf
                            @method('PUT')
                            <div class="col-md-12">
                                <label for="park" class="form-label">Service Name</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="material-icons-outlined fs-5">park</i></span>
                                    <input type="text" class="form-control" id="service_name" placeholder="Service Name" name="service_name" value="{{ old('service_name', $service->service_name) }}">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label for="service_description" class="form-label">Service Description</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="material-icons-outlined fs-5">description</i></span>
                                    <textarea class="form-control" id="service_description" name="service_description" placeholder="Service Description" rows="4">{{ old('service_description', $service->service_description) }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label for="service_image" class="form-label">Service Icon</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="material-icons-outlined fs-5">image</i></span>
                                    <input type="file" name="service_image" class="form-control" id="service_image">
                                </div>
                                 @if($service->service_image)
                                    <div class="mt-2">
                                        <img src="{{ asset('uploads/services/icon/'.$service->service_image) }}" alt="Feature Image" width="120">
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-12">
                                <label for="feature_image" class="form-label">Feature Image</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="material-icons-outlined fs-5">image</i></span>
                                    <input type="file" name="feature_image" class="form-control" id="feature_image">
                                </div>
                                 @if($service->feature_image)
                                    <div class="mt-2">
                                        <img src="{{ asset('uploads/services/feature/'.$service->feature_image) }}" alt="Feature Image" width="120">
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3 mt-3">
                                    <button type="submit" class="btn btn-info px-4 d-flex align-items-center">
                                        <i class="material-icons-outlined me-2" style="font-size:18px;">update</i>
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

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.js"></script>

<script>
$(document).ready(function () {

    $('#service_description').summernote({
        height: 250
    });

    $("#serviceEditForm").validate({
        rules: {
            service_name: { 
                required: true, 
                minlength: 2 
            },
            service_image: { 
                extension: "jpg|jpeg|png|gif" 
            },
            feature_image: { 
                extension: "jpg|jpeg|png|gif" 
            }
        },
        messages:{
            service_name: { 
                required: "Please enter Service Title" 
            },
            service_image: { 
                extension: "Only JPG, JPEG, PNG, or GIF files are allowed" 
            },
            feature_image: {  
                extension: "Only JPG, JPEG, PNG, or GIF files are allowed" 
            }
        },
        errorClass: "text-danger",
        errorElement: "span",
        highlight: function (el) { $(el).addClass("is-invalid"); },
        unhighlight: function (el) { $(el).removeClass("is-invalid"); },

        // place errors correctly when inside .input-group
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
                beforeSend: function () {
                    // optional loader
                },
                success: function (response) {
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: response.message || "Services Updated Successfully!"
                    }).then(() => {
                        window.location.href = response.redirect || "{{ route('admin.services.index') }}";
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