<!-- MasterPage Start -->
<!DOCTYPE html>
<html lang="en">

    <!-- Head Start -->
    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <title>Laravel Demo</title>
        <link rel="icon" type="image/png" href="{{ asset('front_assets/img/logo/favicon.png') }}" sizes="16x16">
        <link rel="stylesheet" href="{{ asset('front_assets/css/fontawasome.css') }}">
        <link rel="stylesheet" href="{{ asset('front_assets/css/swiper-bundle.min.css') }}">
        <link rel="stylesheet" href="{{ asset('front_assets/css/odometer.css') }}">
        <link rel="stylesheet" href="{{ asset('front_assets/css/lightcase.css') }}">
        <link rel="stylesheet" href="{{ asset('front_assets/css/bootstrap.min.css') }}">    
        <link rel="stylesheet" href="{{ asset('front_assets/css/style.css') }}">

    </head>
    <!-- Head End -->

    <!-- Body Start -->
    <body>

        <!-- Preloader Start -->
        <div class="preloader"></div>  
        <!-- Preloader End -->  

        <!-- Header Start -->
        @include('front.partials.header');
        <!-- Header End -->

        <!-- Content Start -->
        @yield('content')
        <!-- Content Start -->

        <!-- Footer Start -->
        @include('front.partials.footer');
        <!-- Footer End -->


        <!-- scrollToTop start here -->
        <a href="#" class="scrollToTop">
            <i class="fa-solid fa-arrow-up-long"></i>
            <span class="pluse_1"></span>
            <span class="pluse_2"></span>
        </a>
        <!-- scrollToTop ending here -->

        <!-- vendor js -->
        <script src="{{ asset('front_assets/js/jquery.js') }}"></script>
        <script src="{{ asset('front_assets/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('front_assets/js/swiper-bundle.min.js') }}"></script>    
        <script src="{{ asset('front_assets/js/odometer.js') }}"></script>
        <script src="{{ asset('front_assets/js/isotope.pkgd.min.js') }}"></script>
        <script src="{{ asset('front_assets/js/lightcase.js') }}"></script>    
        <script src="{{ asset('front_assets/js/viewport.jquery.js') }}"></script>    
    
        
        <!-- custome js here -->
        <script src="{{  asset('front_assets/js/custom.js') }}"></script>    
        
        <script>
            $(window).scroll(function () {
                var hT = $('.skill-bar-wrapper').offset().top,
                    hH = $('.skill-bar-wrapper').outerHeight(),
                    wH = $(window).height(),
                    wS = $(this).scrollTop();
                if (wS > (hT + hH - 1.4 * wH)) {
                    jQuery(document).ready(function () {
                        jQuery('.skillbar-container').each(function () {
                            jQuery(this).find('.skills').animate({
                                width: jQuery(this).attr('data-percent')
                            }, 5000); // 5 seconds
                        });
                    });
                }
            });
        </script>

    </body>
    <!-- Body End -->

</html>
<!-- MasterPage End -->