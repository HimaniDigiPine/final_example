<!-- start header section here -->
<div class="header header--headerpage3">
    <div class="header__top header__top--toppage2 header__top--toppage3">
        <div class="container-xl container-fluid">
            <div class="header__topcontent header__topcontent--topcontentpage2">
                <div class="left">
                    <ul>
                        <li>
                            <div class="icon">                                                       
                                <i class="fa-solid fa-square-phone"></i>                              
                            </div>
                            <div class="text">
                                <p>{{ theme_option('phone_number', '+000-000-0000') }}</p>                            
                            </div>
                        </li>
                        <li>
                            <div class="icon">                                                       
                                <i class="fa-sharp fa-regular fa-envelope-open"></i>                              
                            </div>
                            <div class="text">
                                <p>{{ theme_option('email_id', 'info@gmail.com') }}</p>                            
                            </div>
                        </li>
                        <li>
                            <div class="icon">                                                       
                                <i class="fa-sharp fa-solid fa-location-dot"></i>                             
                            </div>
                            <div class="text">
                                <p>{{ theme_option('address', '22 Vokte Street Building Melborn City') }}</p>                            
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="right">
                    <ul>
                        <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                        <li><a href="#"><i class="fa-sharp fa-regular fa-basketball"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                    </ul>                        
                </div>
            </div>
        </div>
    </div>
    <div class="header__bottom header__bottom--bottompage3 bg-white">
        <div class="container-xl container-fluid">
            <div class="row align-items-center">
                <div class="col-6 col-xl-2">
                    <div class="left">
                        <div class="header__logo">
                            <a href="index.html"><img src="{{ asset(theme_option('header_logo', 'images/default-logo.png')) }}" alt="logo"></a>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-xl-10">
                    <div class="right">                            
                        <div class="header__nav target"> 
                            <div class="mobilelogo d-xl-none d-block">
                                <a href="index.html"><img src="{{ asset('front_assets/img/logo/whiteloog.png') }}" alt="logo"></a>
                            </div>
                            <div class="mainactive activescroll">                           
                                <ul>
                                    <li><a href="#0">Home</a>
                                        <ul>
                                            <li><a href="index.html">home-1</a></li>
                                            <li><a href="index-2.html">home-2</a></li> 
                                            <li><a href="index-3.html" class="active">home-3</a> </li>
                                        </ul>
                                    </li>                                    
                                    <li><a href="about.html">About</a></li>
                                    <li><a href="#0">Pages</a>
                                        <ul>
                                            <li><a href="#0">portfolio</a>
                                                <ul>
                                                    <li><a href="project.html">Portfolio</a></li>                                                            
                                                    <li><a href="project-mas.html">Portfolio Masonary</a></li> 
                                                    <li><a href="project-details.html">Project Details</a></li>                                                                                                   
                                                </ul>
                                            </li>
                                            <li><a href="#0">Service</a>
                                                <ul>
                                                    <li><a href="service.html">Service</a></li>                                                            
                                                    <li><a href="service-details.html">Service Single</a></li>                                                                                                   
                                                </ul>
                                            </li>
                                            <li><a href="#0">Team</a>
                                                <ul>
                                                    <li><a href="team.html">Team</a></li>                                                            
                                                    <li><a href="team-single.html">Team Single</a></li>                                                                                                   
                                                </ul>
                                            </li>
                                            <li><a href="history.html">history</a></li>
                                            <li><a href="faq.html">FAQ</a></li>                                              
                                            <li><a href="404.html">404</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#0">shop</a>
                                        <ul>
                                            <li><a href="cart.html">Cart</a></li>                                                
                                            <li><a href="shop.html">Shop</a></li>
                                            <li><a href="product-details.html">Product Details</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#0">Blog</a>
                                        <ul>
                                            <li><a href="blog.html">Blog</a></li>                                                
                                            <li><a href="blog-single.html">Blog Single</a></li>                                                
                                        </ul>
                                    </li>
                                    <li><a href="contact.html">Contact</a></li>
                                </ul>
                            </div>                                
                        </div> 
                        <div class="header__cart">                            
                            <div class="carticon">
                            <a href="#"><i class="fa-light fa-basket-shopping"></i></a>
                            </div>
                            <div class="cart-details">
                                <div class="close d-sm-none d-block">
                                    <i class="fa-sharp fa-solid fa-square-xmark"></i>
                                </div>
                                <div class="item">
                                    <div class="thumb">
                                        <img src="assets/img/cart/img1.jpg" alt="img">
                                    </div>
                                    <div class="right">
                                        <div class="text">
                                            <h6><a href="#">Product title here</a></h6>
                                            <p>$20.00</p>
                                            <span>In Stock</span>
                                        </div>
                                        <div class="cros">
                                            <i class="fa-sharp fa-solid fa-square-xmark"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="thumb">
                                        <img src="{{ asset('front_assets/img/cart/img2.png') }}" alt="img">
                                    </div>
                                    <div class="right">
                                        <div class="text">
                                            <h6><a href="#">Product title here</a></h6>
                                            <p>$20.00</p>
                                            <span>In Stock</span>
                                        </div>
                                        <div class="cros">
                                            <i class="fa-sharp fa-solid fa-square-xmark"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="total">
                                    <div class="subtotal">
                                        <p>Subtotal :<span> $40.00</span></p>
                                    </div>
                                    <div class="checkout">
                                        <a href="#">Checkout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="header__bottombtn d-xl-block d-none">
                                <a href="contact.html" class="custom-btn">Explore Garden</a>
                        </div>
                        <div class="ellepsis d-xl-none">
                            <i class="fa-solid fa-circle-info"></i>
                        </div>
                        <div class="bar d-xl-none d-block">
                            <i class="fa-solid fa-bars"></i>
                        </div>                            
                    </div>
                </div>                    
            </div>
        </div>
    </div>
</div>  
<!--  header section here -->