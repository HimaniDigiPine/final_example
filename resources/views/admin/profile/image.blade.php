@extends('admin.layout.master')


@section('content')

<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">

        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Components</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                    </ol>
                </nav>
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
                            <h5 class="mb-4">User Profile Image Update</h5>
                            <form action="{{ route('admin.profile.image.update') }}" method="POST" enctype="multipart/form-data" class="row g-3" id="userProfileImageForm">
                                @csrf
                                <div class="mb-3">
                                    <label>Current Image</label><br>
                                    <img src="{{ $user->profile_image 
                                                ? asset('uploads/profile_images/'.$user->profile_image) 
                                                : asset('admin_assets/images/avatars/01.png') }}" 
                                            class="rounded-circle" width="100" height="100" alt="Profile">
                                </div>

                                <div class="mb-3">
                                    <label for="profile_image">New Profile Image</label>
                                    <input type="file" name="profile_image" class="form-control">
                                </div>

                                <div class="col-md-12">
                                    <div class="d-md-flex d-grid align-items-center gap-3">
                                        <button type="submit" class="btn btn-primary px-4">Update</button>
                                        <button type="reset" class="btn btn-light px-4">Reset</button>
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


    // validate form
    $("#userProfileImageForm").validate({
        rules: {
            profile_image: {
                required: true,
                extension: "jpg|jpeg|png|gif"
            }
        },
        messages: {
            profile_image: {
                required: "Please select a profile image",
                extension: "Only JPG, JPEG, PNG, or GIF files are allowed"
            }
        },
        errorClass: "text-danger",
        errorElement: "span",
        highlight: function (el)   { $(el).addClass("is-invalid"); },
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
                    $('.indicator-label').hide();
                    $('.indicator-progress').show();
                },
                success: function (response) {
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: response.message || "Profile Image Updated Successfully!"
                    }).then(() => {
                        // Redirect to index
                        window.location.href = response.redirect || "/home";
                    });
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: xhr.responseJSON?.message || "Something went wrong!"
                    });
                },
                complete: function () {
                    $('.indicator-label').show();                                                                                                                   
                }
            });
            return false; // Prevent default submit
        } 
    });
});
</script>
@endpush