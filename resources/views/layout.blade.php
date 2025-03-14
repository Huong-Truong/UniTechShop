<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>UniTech - Vũ Trụ Công Nghệ</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="{{asset('img/favicon.ico')}}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row bg-secondary py-2 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="d-inline-flex align-items-center">
                    <a class="text-dark" href="">FAQs</a>
                    <span class="text-muted px-2">|</span>
                    <a class="text-dark" href="">Help</a>
                    <span class="text-muted px-2">|</span>
                    <a class="text-dark" href="">Support</a>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a class="text-dark pl-2" href="">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
        @if ($message = Session::get('success'))
    <script>
        alert("{{ $message }}"); // Displays a success alert
    </script>
    <?php Session::forget('success'); ?>
@endif

@if ($message = Session::get('error'))
    <script>
        alert("{{ $message }}"); // Displays an error alert
    </script>
    <?php Session::forget('error'); ?>
@endif

                          
        <div class="row align-items-center py-3 px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a href="{{route('trang-chu')}}" class="text-decoration-none">
                    <h2 class="m-0 display-5 font-weight-semi-bold">
                        <span class="text-primary font-weight-bold border px-1 mr-2">UniTech</span>   
                    </h2>
                    <!-- <p class="px-1 mr-2">Vũ trụ công nghệ</p> -->
                    
                </a>
            </div>
            <div class="col-lg-6 col-6 text-left">

                <form action="{{route('Search')}}" method="post" >
                    @csrf
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Tìm kiếm sản phẩm" name="keywords">
                        <div class="input-group-append">
                            <button type="submit" class="input-group-text bg-transparent text-primary">
                                <i   class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 col-6 text-right">
                <a href="{{route('show-cart')}}" class="btn border">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    <?php 
                      $count = Cart::content()->count();
                    ?>
                    <span class="badge"><?php echo $count ?></span>
                </a>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid mb-3">
        <div class="row border-top px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                    <h6 class="m-0">Danh mục sản phẩm</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse show navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0" id="navbar-vertical">
                <div class="navbar-nav w-100 overflow-hidden" style="height: 410px">
                    @foreach($phanloai as $pl)
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link" data-toggle="dropdown">
                                {{$pl->phanloai_ten}}<i class="fa fa-angle-down float-right mt-1"></i>
                            </a>
                          
                                    <div class="dropdown-menu position-absolute bg-secondary border-0 rounded-0 w-100 m-0">
                                    @foreach($danhmuc as $value)
                                        @if($value->phanloai_id == $pl->phanloai_id) 
                                        <a href="{{route('danh-muc',['danhmuc_id' => $value->danhmuc_id])}}" class="dropdown-item">{{$value->danhmuc_ten}}</a>
                                        @endif
                                        @endforeach
                                    </div>
                                    <!-- <a href="" class="nav-item nav-link">{{$pl->phanloai_ten}}</a> -->
                              
                        </div>
                    @endforeach
                </div>

                </nav>
            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</h1>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="{{route('trang-chu')}}" class="nav-item nav-link active">Trang Chủ</a>
                            <a href="{{route('san-pham')}}" class="nav-item nav-link">Sản Phẩm</a>
                            <a href="{{route('show-cart')}}" class="nav-item nav-link">Giỏ Hàng</a>
                            <?php
                            $khachhang_id = Session::get('khachhang_id');
                            $vanchuyen_id = Session::get('vanchuyen_id');
                            
                            if($khachhang_id!= NULL && $vanchuyen_id == NULL  ){
                            ?>
                          <a href="{{route('checkout')}}" class="nav-item nav-link">Thanh Toán</a>
                        <?php }elseif($khachhang_id!= NULL && $vanchuyen_id != NULL ){  ?>

                            <a href="{{route('payment')}}" class="nav-item nav-link">Thanh toán</a>
                    
                        <?php  }else{?>
                            <a href="{{route('login-checkout')}}" class="nav-item nav-link">Thanh toán</a>
                            <?php }?>
                           
                          
                            <!-- <a href="detail.html" class="nav-item nav-link">Tài Khoản</a> -->
                            <!-- <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="cart.html" class="dropdown-item">Tài Khoản</a>
                                    <a href="checkout.html" class="dropdown-item">Thanh Toán</a>
                                </div>
                            </div> -->
                            <a href="{{route('contact')}}" class="nav-item nav-link">Liên Hệ</a>
                        

                        </div>
                        <div class="navbar-nav ml-auto py-0">
                            <?php
                            $khachhang_id = Session::get('khachhang_id');
                            if($khachhang_id!= NULL){
                            ?>

                        <a href="{{route('logout-checkout')}}" class="nav-item nav-link">Tài khoản</a>
                        <a href="{{route('logout-checkout')}}" class="nav-item nav-link">Đăng xuất</a>
                        <!-- Sẽ làm thêm bấm đăng nhập kh thì nó hiện trang chủ, còn đăng nhập từ nút thanh toán thì sau khi đăng nhập qua thanh toán -->
                        <?php }else{  ?>
                            
                            <a href="{{route('login-checkout')}}" class="nav-item nav-link">Đăng Nhập</a>
                        <?php  }?>
                           
                        </div>
                    </div>
                </nav>
            @yield('slide')
            </div>
        </div>
    </div>
    <!-- Navbar End -->


    @yield('content')


    <!-- Footer Start -->
    <div class="container-fluid bg-secondary text-dark mt-5 pt-5">
        <div class="row px-xl-5  pt-6">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <a href="" class="text-decoration-none">
                    <h1 class="mb-4 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border border-white px-3 mr-1">U</span>UniTech</h1>
                </a>
                <p>Điểm đến của những sản phẩm công nghệ tiên tiến, mang đến cho bạn trải nghiệm mua sắm đỉnh cao và chất lượng tuyệt vời.</p>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>Đường 3/2, Phường Hưng Lợi, Quận Ninh Kiều, Thành phố Cần Thơ</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>ctu@gmail.com</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+84 345 67890</p>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Đường dẫn</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-dark mb-2" href="index.html"><i class="fa fa-angle-right mr-2"></i>Trang Chủ</a>
                            <a class="text-dark mb-2" href="shop.html"><i class="fa fa-angle-right mr-2"></i>Sản Phẩm</a>
                            <a class="text-dark mb-2" href="detail.html"><i class="fa fa-angle-right mr-2"></i>Giỏ Hàng</a>
                            <a class="text-dark mb-2" href="cart.html"><i class="fa fa-angle-right mr-2"></i>Thanh Toán</a>
                            <a class="text-dark mb-2" href="{{ route('contact') }}"><i class="fa fa-angle-right mr-2"></i>Liên Hệ</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Về Chúng Tôi</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-dark mb-2" href="index.html"><i class="fa fa-angle-right mr-2"></i>Giới thiệu UniShop</a>
                            <a class="text-dark mb-2" href="shop.html"><i class="fa fa-angle-right mr-2"></i>Hệ thống cửa hàng</a>
                            <a class="text-dark mb-2" href="detail.html"><i class="fa fa-angle-right mr-2"></i>Hướng dẫn đặt hàng</a>
                            <a class="text-dark mb-2" href="cart.html"><i class="fa fa-angle-right mr-2"></i>Chính sách và quy định</a>
                            <a class="text-dark mb-2" href="checkout.html"><i class="fa fa-angle-right mr-2"></i>Thông tin sở hữu</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                            <h5 class="font-weight-bold text-dark mb-4">Follow Us</h5>
                            <div class="d-flex flex-column justify-content-start">
                                <a class="text-dark px-6 mb-2" href=""><i class="fab fa-facebook-f mr-2" ></i>Facebook</a>
                                <a class="text-dark px-6 mb-2" href=""><i class="fab fa-twitter mr-2"></i>Twitter</a>
                                <a class="text-dark px-6 mb-2" href=""><i class="fab fa-linkedin-in mr-2"></i>LinkedIn</a>
                                <a class="text-dark px-6 mb-2" href=""><i class="fab fa-instagram mr-2"></i>Instagram</a>
                                <a class="text-dark pl-6 mb-2" href=""><i class="fab fa-youtube mr-2"></i>Youtube</a>
                            </div>
                    </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>