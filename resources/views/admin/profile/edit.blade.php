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
                            <h5 class="mb-4">User Profile Update</h5>
                            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="row g-3" id="userProfileForm">
                                @csrf
                                @method('PUT')
                                <div class="col-md-4">
                                    <label for="input1" class="form-label">First Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="material-icons-outlined fs-5">person_outline</i></span>
                                        <input type="text" class="form-control" id="input1" placeholder="First Name" name="firstname" value="{{ old('firstname', $user->firstname) }}">
									</div>
								</div>
                                <div class="col-md-4">
                                    <label for="input2" class="form-label">Middle Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="material-icons-outlined fs-5">person_outline</i></span>
                                        <input type="text" class="form-control" id="input2" placeholder="Middle Name" name="middlename" value="{{ old('middlename', $user->middlename) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="input2" class="form-label">Last Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="material-icons-outlined fs-5">person_outline</i></span>
                                        <input type="text" class="form-control" id="input2" placeholder="Last Name" name="lastname" value="{{ old('lastname', $user->lastname) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="input3" class="form-label">Phone</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="material-icons-outlined fs-5">call</i></span>
                                        <input type="text" class="form-control" id="input3" placeholder="Phone" name="phonenumber" value="{{ old('phonenumber', $user->phonenumber) }}">
                                    </div>   
                                </div>
                                <div class="col-md-6">
                                    <label for="input3" class="form-label">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="material-icons-outlined fs-5">email</i></span>
                                        <input type="text" class="form-control" id="input3" readonly placeholder="Email" name="email" value="{{ old('email', $user->email) }}">
                                    </div>   
                                </div>
                                <div class="col-md-6">
                                    <label for="input3" class="form-label">Birthdate</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" id="input6" name="birthdate" value="{{ old('birthdate', $user->birthdate) }}">
                                    </div>   
                                </div>
                                <div class="col-md-6">
                                    <label for="input3" class="form-label">Gender</label>
                                    <div class="form-check">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="gender_male" value="male"
                                                {{ $user->gender == 'male' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="gender_male">Male</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="gender_female" value="female"
                                                {{ $user->gender == 'female' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="gender_female">Female</label>
                                        </div>
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


    // Custom method: no leading/trailing spaces
    $.validator.addMethod("noSpace", function(value, element) {
        return $.trim(value) === value; 
    }, "No leading or trailing spaces allowed");

    // Custom method: no numbers
    $.validator.addMethod("noNumber", function(value, element) {
        return !/\d/.test(value);
    }, "Numbers are not allowed");

    // validate form
    $("#userProfileForm").validate({
        rules: {
            firstname: {
                required: true, 
                minlength: 2,
                noSpace: true, 
                noNumber: true
            },
            middlename:{
                required: true, 
                minlength: 2,
                noSpace: true, 
                noNumber: true
                
            },
            lastname: { 
                required: true, 
                minlength: 2, 
                noSpace: true, 
                noNumber: true
            },
            email: { 
                required: true, 
                email: true 
            },
            phonenumber: { 
                required: true, 
                digits: true, 
                minlength: 10, 
                maxlength: 15 
            },
            birthdate: { 
                required: true, 
                date: true 
            },
            gender: { 
                required: true 
            }
        },
        messages: {
            firstname: {
                required:"Please enter First name"
            },
            lastname:{
                required:"Please enter Middle name"
            } ,
            middlename:{
                required:"Please enter Last name"
            },
            email: {
                required:"Enter a valid Email address"
            },
            phonenumber: {
                required: "Phone number is required",
                digits: "Only digits allowed",
                minlength: "Must be 10 digits",
                maxlength: "Must be 10 digits"
            },
            birthdate:{
                required:"Please select your birthdate"
            } ,
            gender: {
                required:"Please select gender"
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
                        text: response.message || "Profile Updated Successfully!"
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