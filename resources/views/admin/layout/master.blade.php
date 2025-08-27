<!-- Start of Masterpage -->
<!doctype html>
<html lang="en" data-bs-theme="light">

    <!-- Head Starting -->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel Demo</title>

        <!--favicon-->
	    <ink rel="icon" href="{{ asset('admin_assets/images/favicon-32x32.png')}}" type="image/png">

        <!--plugins-->
        <link href="{{ asset('admin_assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet" />
        <link href="{{ asset('admin_assets/plugins/metismenu/metisMenu.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{ asset('admin_assets/plugins/metismenu/mm-vertical.css')}}" rel="stylesheet" type="text/css">
        <link href="{{ asset('admin_assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" type="text/css">

        <!--bootstrap css-->
        <link href="{{ asset('admin_assets/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">

        <!--main css-->
        <link href="{{ asset('admin_assets/css/bootstrap-extended.css') }}" rel="stylesheet">
        <link href="{{ asset('admin_assets/sass/main.css')}}" rel="stylesheet">
        <link href="{{ asset('admin_assets/sass/dark-theme.css') }}" rel="stylesheet">
        <link href="{{ asset('admin_assets/sass/semi-dark.css') }}" rel="stylesheet">
        <link href="{{ asset('admin_assets/sass/bordered-theme.css') }}" rel="stylesheet">
        <link href="{{ asset('admin_assets/sass/responsive.css') }}" rel="stylesheet">

    </head>
    <!-- Head Ending -->
    <body>

        <!-- Header Start -->
        @include('admin.partials.header');
        <!-- Header End -->

        <!-- Siderbar Start -->
        @include('admin.partials.sidebar')
        <!-- Sidebar End -->

        <!-- Content Start -->
        @yield('content')
        <!-- Content Start -->

         <!--start overlay-->
        <div class="overlay btn-toggle"></div>
        <!--end overlay-->

        <!-- Footer Start -->
        @include('admin.partials.footer');
        <!-- Footer End -->


        <!--start cart-->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCart">
            <div class="offcanvas-header border-bottom h-70 justify-content-between">
                <h5 class="mb-0" id="offcanvasRightLabel">8 New Orders</h5>
                <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="offcanvas">
                    <i class="material-icons-outlined">close</i>
                </a>
            </div>
            <div class="offcanvas-body p-0">
                <div class="order-list">
                    <div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
                        <div class="order-img">
                            <img src="{{ asset('admin_assets/images/orders/01.png')}}" class="img-fluid rounded-3" width="75" alt="">
                        </div>
                        <div class="order-info flex-grow-1">
                            <h5 class="mb-1 order-title">White Men Shoes</h5>
                            <p class="mb-0 order-price">$289</p>
                        </div>
                        <div class="d-flex">
                            <a class="order-delete"><span class="material-icons-outlined">delete</span></a>
                            <a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
                        </div>
                    </div>

                    <div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
                        <div class="order-img">
                            <img src="{{ asset('admin_assets/images/orders/02.png')}}" class="img-fluid rounded-3" width="75" alt="">
                        </div>
                        <div class="order-info flex-grow-1">
                            <h5 class="mb-1 order-title">Red Airpods</h5>
                            <p class="mb-0 order-price">$149</p>
                        </div>
                        <div class="d-flex">
                            <a class="order-delete"><span class="material-icons-outlined">delete</span></a>
                            <a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
                        </div>
                    </div>

                    <div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
                        <div class="order-img">
                            <img src="{{ asset('admin_assets/images/orders/03.png')}}" class="img-fluid rounded-3" width="75" alt="">
                        </div>
                        <div class="order-info flex-grow-1">
                            <h5 class="mb-1 order-title">Men Polo Tshirt</h5>
                            <p class="mb-0 order-price">$139</p>
                        </div>
                        <div class="d-flex">
                            <a class="order-delete"><span class="material-icons-outlined">delete</span></a>
                            <a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
                        </div>
                    </div>

                    <div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
                        <div class="order-img">
                            <img src="{{ asset('admin_assets/images/orders/04.png')}}" class="img-fluid rounded-3" width="75" alt="">
                        </div>
                        <div class="order-info flex-grow-1">
                            <h5 class="mb-1 order-title">Blue Jeans Casual</h5>
                            <p class="mb-0 order-price">$485</p>
                        </div>
                        <div class="d-flex">
                            <a class="order-delete"><span class="material-icons-outlined">delete</span></a>
                            <a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
                        </div>
                    </div>

                    <div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
                        <div class="order-img">
                            <img src="{{ asset('admin_assets/images/orders/05.png')}}" class="img-fluid rounded-3" width="75" alt="">
                        </div>
                        <div class="order-info flex-grow-1">
                            <h5 class="mb-1 order-title">Fancy Shirts</h5>
                            <p class="mb-0 order-price">$758</p>
                        </div>
                        <div class="d-flex">
                            <a class="order-delete"><span class="material-icons-outlined">delete</span></a>
                            <a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
                        </div>
                    </div>

                    <div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
                        <div class="order-img">
                            <img src="{{ asset('admin_assets/images/orders/06.png')}}" class="img-fluid rounded-3" width="75" alt="">
                        </div>
                        <div class="order-info flex-grow-1">
                            <h5 class="mb-1 order-title">Home Sofa Set </h5>
                            <p class="mb-0 order-price">$546</p>
                        </div>
                        <div class="d-flex">
                            <a class="order-delete"><span class="material-icons-outlined">delete</span></a>
                            <a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
                        </div>
                    </div>

                    <div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
                        <div class="order-img">
                            <img src="{{ asset('admin_assets/images/orders/07.png')}}" class="img-fluid rounded-3" width="75" alt="">
                        </div>
                        <div class="order-info flex-grow-1">
                            <h5 class="mb-1 order-title">Black iPhone</h5>
                            <p class="mb-0 order-price">$1049</p>
                        </div>
                        <div class="d-flex">
                            <a class="order-delete"><span class="material-icons-outlined">delete</span></a>
                            <a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
                        </div>
                    </div>

                    <div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
                        <div class="order-img">
                            <img src="{{ asset('admin_assets/images/orders/08.png')}}" class="img-fluid rounded-3" width="75" alt="">
                        </div>
                        <div class="order-info flex-grow-1">
                            <h5 class="mb-1 order-title">Goldan Watch</h5>
                            <p class="mb-0 order-price">$689</p>
                        </div>
                        <div class="d-flex">
                            <a class="order-delete"><span class="material-icons-outlined">delete</span></a>
                            <a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="offcanvas-footer h-70 p-3 border-top">
                <div class="d-grid">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="offcanvas">View Products</button>
                </div>
            </div>
        </div>
        <!--end cart-->

        <!--start switcher-->
        <button class="btn btn-primary position-fixed bottom-0 end-0 m-3 d-flex align-items-center gap-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop">
            <i class="material-icons-outlined">tune</i>Customize
        </button>
        
        <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="staticBackdrop">
            <div class="offcanvas-header border-bottom h-70 justify-content-between">
                <div class="">
                    <h5 class="mb-0">Theme Customizer</h5>
                    <p class="mb-0">Customize your theme</p>
                </div>
                <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="offcanvas">
                    <i class="material-icons-outlined">close</i>
                </a>
            </div>
            <div class="offcanvas-body">
                <div>
                    <p>Theme variation</p>
                    <div class="row g-3">
                        <div class="col-12 col-xl-6">
                            <input type="radio" class="btn-check" name="theme-options" id="LightTheme" checked>
                            <label class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4" for="LightTheme">
                                <span class="material-icons-outlined">light_mode</span>
                                <span>Light</span>
                            </label>
                        </div>
                        <div class="col-12 col-xl-6">
                            <input type="radio" class="btn-check" name="theme-options" id="DarkTheme">
                            <label class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4" for="DarkTheme">
                                <span class="material-icons-outlined">dark_mode</span>
                                <span>Dark</span>
                            </label>
                        </div>
                        <div class="col-12 col-xl-6">
                            <input type="radio" class="btn-check" name="theme-options" id="SemiDarkTheme">
                            <label class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4" for="SemiDarkTheme">
                                <span class="material-icons-outlined">contrast</span>
                                <span>Semi Dark</span>
                            </label>
                        </div>
                        <div class="col-12 col-xl-6">
                            <input type="radio" class="btn-check" name="theme-options" id="BoderedTheme">
                            <label class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4" for="BoderedTheme">
                                <span class="material-icons-outlined">border_style</span>
                                <span>Bordered</span>
                            </label>
                        </div>
                    </div><!--end row-->
                </div>
            </div>
        </div>
        <!--start switcher-->



        <!--bootstrap js-->
        <script src="{{ asset('admin_assets/js/bootstrap.bundle.min.js') }}"></script>

        <!--plugins-->
        <script src="{{ asset('admin_assets/js/jquery.min.js')}}"></script>

        <!--plugins-->
        <script src="{{ asset('admin_assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
        <script src="{{ asset('admin_assets/plugins/metismenu/metisMenu.min.js')}}"></script>
        <script src="{{ asset('admin_assets/plugins/apexchart/apexcharts.min.js')}}"></script>
        <script src="{{ asset('admin_assets/js/index.js')}}"></script>
        <script src="{{ asset('admin_assets/plugins/peity/jquery.peity.min.js')}}"></script>
        <script>
            $(".data-attributes span").peity("donut")
        </script>
        <script src="{{ asset('admin_assets/plugins/simplebar/js/simplebar.min.js') }}"></script>

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	    <script src="{{ asset('admin_assets/plugins/select2/js/select2-custom.js') }}"></script>

        <script src="{{ asset('admin_assets/js/main.js') }}"></script>


        <!-- JQuery Validation -->
        <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>

        <!-- Sweet Alret -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @stack('scripts')
        
        
    </body>
</html>
<!-- End of Masterpage -->