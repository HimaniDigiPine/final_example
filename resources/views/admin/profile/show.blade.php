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
            <div class="col-12 col-lg-8 col-xl-12">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="position-relative">
                            <img src="{{ asset('admin_assets/images/carousels/22.png') }}" class="img-fluid rounded" alt="">
                            <div class="position-absolute top-100 start-50 translate-middle">
                                 @if($user->profile_image)
                                    <p><img src="{{ asset('uploads/profile_images/'.$user->profile_image) }}" 
                                            alt="Profile Image" 
                                            width="120" class="rounded-circle raised p-1 bg-white"></p>
                                @endif
                            </div>
                        </div>
                        <div class="mt-5 d-flex align-items-start justify-content-between">
                            <div class="">
                                <h3 class="mb-2">{{ $user->name }}</h3>
                                <p><strong>Email:</strong> {{ $user->email }}</p>
                                <p><strong>Phone:</strong> {{ $user->phonenumber }}</p>
                                <div class="">
                                <span class="badge rounded-pill bg-primary">{{ $user->birthdate }}</span>
                                <span class="badge rounded-pill bg-primary"> {{ ucfirst($user->gender) }}</span>
                                <span class="badge rounded-pill bg-primary">{{ ucfirst($user->user_type) }}</span>
                                </div>
                            </div>
                            <div class="">
                                <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary"><i class="bi bi-chat me-2"></i>Edit Profile</a>
                            </div>
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