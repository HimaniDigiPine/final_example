<!doctype html>
<html lang="en" data-bs-theme="light">
    <head>
	
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel Demo</title>
		
		
        <!--favicon-->
        <link rel="icon" href="{{ asset('admin_assets/images/favicon-32x32.png') }}" type="image/png">
		
        <!--plugins-->
        <link href="{{ asset('admin_assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/plugins/metismenu/metisMenu.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/plugins/metismenu/mm-vertical.css')}}">
		
        <!--bootstrap css-->
        <link href="{{ asset('admin_assets/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">
		
        <!--main css-->
        <link href="{{ asset('admin_assets/css/bootstrap-extended.css') }}" rel="stylesheet">
        <link href="{{ asset('admin_assets/sass/main.css')}}" rel="stylesheet">
        <link href="{{ asset('admin_assets/sass/dark-theme.css') }}" rel="stylesheet">
        <link href="{{ asset('admin_assets/sass/responsive.css') }}" rel="stylesheet">
		
    </head>
    <body>
        <!--authentication-->
        <div class="section-authentication-cover">
            <div class="">
                <div class="row g-0">
                    <div class="col-12 col-xl-7 col-xxl-8 auth-cover-left align-items-center justify-content-center d-none d-xl-flex border-end">
                        <div class="card rounded-0 mb-0 border-0 shadow-none bg-transparent">
                            <div class="card-body">
                                <img src="{{ asset('admin_assets/images/auth/reset-password1.png')}}" class="img-fluid auth-img-cover-login" width="650" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-5 col-xxl-4 auth-cover-right align-items-center justify-content-center">
                        <div class="card rounded-0 m-3 mb-0 border-0 shadow-none">
                            <div class="card-body p-sm-5">
                                <img src="{{ asset('admin_assets/images/logo1.png') }}" class="mb-4" width="145" alt="">
                                <h4 class="fw-bold">Forgot Password?</h4>
                                <p class="mb-0">Enter your registered email ID to reset the password</p>
                                <div class="form-body mt-4">
                                    <form class="row g-3" method="POST" action="{{ route('password.email') }}" id="forgetpassword">
                                        @csrf
                                        <div class="col-12">
                                            <label class="form-label">Email id</label>
                                            <input type="text" class="form-control" name="email" placeholder="example@user.com">
                                        </div>
                                        <div class="col-12">
                                            <div class="d-grid gap-2">

                                                <button type="submit" class="btn btn-primary">Send</button>
                                                <a href="{{ route('login')}}" class="btn btn-light">Back to Login</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>
        </div>
        <!--authentication-->
        <!--plugins-->
        <script src="{{ asset('admin_assets/js/jquery.min.js') }}"></script>


        <!-- JQuery Validation -->
        <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>

        <!-- Sweet Alret -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    </body>
</html>


 <script>
    $(document).ready(function () {

        //For Paswword
        $("#show_hide_password a").on('click', function (event) {
            event.preventDefault();
            if ($('#show_hide_password input').attr("type") == "text") {
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass("bi-eye-slash-fill");
                $('#show_hide_password i').removeClass("bi-eye-fill");
            } else if ($('#show_hide_password input').attr("type") == "password") {
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass("bi-eye-slash-fill");
                $('#show_hide_password i').addClass("bi-eye-fill");
            }
        });

        //Checking For Validation Method Load
        if (typeof $.fn.validate !== "function") {
            console.error("jQuery Validate is not loaded");
            return;
        }

        //JQuery Validation
        $("#forgetpassword").validate({
            // if any fields are hidden by plugins, don't ignore them
            ignore: [],
            rules:{
                email:    { 
                    required: true, 
                    email: true 
                }
            },
            messages:{
                email:    { 
                    required: "Please enter your email", 
                    email: "Enter a valid email address" 
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
                            text: response.message || "Email Send successfully!"
                        }).then(() => {
                            // Redirect to index
                            window.location.href = "/login"; // 
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
                        $('.indicator-progress').hide();
                    }
                });
                //return false; // Prevent default submit
            } 
        });

    });
</script>


