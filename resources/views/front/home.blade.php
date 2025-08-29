@extends('front.layout.master')



@section('content')

    <!-- banner section start here -->
    <div class="banner banner--bannertwo">
        <div class="hostbanner overflow-hidden">
            <div class="swiper-wrapper">
                @foreach($banners as $banner)
                    <div class="swiper-slide" style="background:url('{{ asset('uploads/banners/' .$banner->background_image) }}'); background-repeat: no-repeat; background-size: cover;">
                        <div class="container">
                            <div class="banner__content banner__content--contentpage3">   
                                <div class="col-lg-7 col-xl-7 col-xxl-6">
                                    <h3>{{ $banner->title }}</h3>                                    
                                    <p>{{ $banner->description }}</p>
                                    <div class="bannerbtn">
                                        @if($banner->button1_text && $banner->button1_link)
                                            <a href="{{ $banner->button1_link }}" class="custom-btn">{{ $banner->button1_text }}</a> 
                                        @endif
                                        @if($banner->button2_text && $banner->button2_link)
                                            <a href="{{ $banner->button2_link }}" class="custom-btn">{{ $banner->button2_text }}</a>   
                                        @endif                            
                                    </div>  
                                </div>                                  
                            </div>
                        </div>                         
                    </div>
                @endforeach
            </div>           
        </div>        
    </div> 
    <!-- banner section start here -->

@endsection