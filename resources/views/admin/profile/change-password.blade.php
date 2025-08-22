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
                            <h5 class="mb-4">User Profile Password Update</h5>
                            <form action="{{ route('admin.profile.password.update') }}" method="POST" enctype="multipart/form-data" class="row g-3" id="changePassword">
                                @csrf
                                <div class="col-12">
                                    <label class="form-label" for="CurrentPassword">Current Password</label>
                                    <div class="input-group" id="toggle_current_password">
                                        <input type="password" class="form-control" name="current_password" id="CurrentPassword" placeholder="Enter Current password">
                                        <a href="javascript:;" class="input-group-text bg-transparent toggle-password"><i class="bi bi-eye-slash-fill"></i></a>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label" for="NewPassword">New Password</label>
                                    <div class="input-group" id="toggle_new_password">
                                        <input type="password" class="form-control" name="new_password" id="NewPassword" placeholder="Enter new password">
                                        <a href="javascript:;" class="input-group-text bg-transparent toggle-password"><i class="bi bi-eye-slash-fill"></i></a>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label" for="ConfirmPassword">Confirm Password</label>
                                    <div class="input-group" id="toggle_confirm_password">
                                        <input type="password" class="form-control" name="new_password_confirmation" id="ConfirmPassword" placeholder="Confirm password">
                                        <a href="javascript:;" class="input-group-text bg-transparent toggle-password"><i class="bi bi-eye-slash-fill"></i></a>
                                    </div>
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


    //For Password Check
    $(document).on('click', '.toggle-password', function (event) {
        event.preventDefault();
        let input = $(this).siblings("input");
        let icon = $(this).find("i");

        if (input.attr("type") === "password") {
            input.attr("type", "text");
            icon.removeClass("bi-eye-slash-fill").addClass("bi-eye-fill");
        } else {
            input.attr("type", "password");
            icon.removeClass("bi-eye-fill").addClass("bi-eye-slash-fill");
        }
    });


    // validate form
    $("#changePassword").validate({
        rules: {
            current_password:{
                required: true, 
                minlength: 6 
            },
            new_password: { 
                required: true, 
                minlength: 6 
            },
            new_password_confirmation: {
                required: true,
                equalTo: "[name='new_password']"
            }
        },
        messages: {
            current_password:{
                required: "Please enter your password", 
                minlength: "Password must be at least 6 characters long" 
            },
           new_password: { 
                required: "Please enter your password", 
                minlength: "Password must be at least 6 characters long" 
            },
            new_password_confirmation: {
                required: "Please re-enter your password",
                equalTo: "Passwords do not match"
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
                        text: response.message || "Paasword Updated Successfully!"
                    }).then(() => {
                        // Redirect to index
                        window.location.href = response.redirect || "/admin/home";
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