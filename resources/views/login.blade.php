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
    <style>
.container{
    padding: 100px;
}
 .dn, .login-form, .signup-form {
    border: 1px dashed #000000; /* 2px wide black border */
	border-radius: 5px;
	padding: 25px;
    border-color: lightgray;
    background-color:rgba(194, 194, 194, 0.2) !important;
}

form label{

    font-weight: bold !important;
}
h2{
    padding: 10px;
    text-align: center;
}
</style>
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
            <!-- <form action="{{route('Search')}}" method="post">
							@csrf
						<div class="search_box pull-right">
							<input type="text" name="keywords_submit" placeholder="Tìm kiếm sản phẩm"/> 
							<input type="submit" style="margin-top: 0;color:black" name="search-items"class="btn btn-success btn-sm" value="Tìm kiếm" >
						</div>
	
						</form> -->
                        <!-- <div class="col-sm-5">
						<form action="{{route('Search')}}" method="post">
							@csrf
						<div class="search_box pull-right">
							<input type="text" name="keywords" placeholder="Tìm kiếm sản phẩm"/> 
							<input type="submit" style="margin-top: 0;color:black" name="search-items" class="btn btn-success btn-sm" value="Tìm kiếm" >
						</div>
	
						</form>
					</div> -->

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

    <!-- Navbar End -->
    <section id="form" >
    <div class="container ">
        <div class="row justify-content-center align-items-center">
            <div class=" col-sm-7 col-sm-offset-2 form border-3">
                <div class="login-form dn">
                    <h2>Đăng nhập</h2>
                    <form action="{{route('login-khachhang')}}" method="POST">
                        @csrf
                        
                        <label for="" class=" px-2"  style="margin: -8px;" >Email</label>
                        <input name="khachhang_email" style="margin-bottom: 15px;" type="text" class="form-control border-1 px-4" name="email_account" placeholder="Email tài khoản" />
                        <br>
                        
                        <label for="" class=" px-2"  style="margin: -8px;">Mật Khẩu</label>
                        <input name="khachhang_matkhau"  style="margin-bottom: 15px;" type="password" class="form-control border-1 " name="password_account" placeholder="Mật khẩu" />
                        <label  class=" py-2 " for=""></label>
                        <span>
                            <input type="checkbox" class="checkbox"> 
                            Ghi nhớ
                        </span>
                        <br>
                        <hr>
                        <span>
                     Bằng cách tiếp tục, bạn đồng ý với  <a href=""> Điều khoản và Điều kiện</a>  <a href=" ">Chính sách Quyền riêng tư</a>, và  <a href="">Điều khoản Chương trình UniTech™</a>.
                     của chúng tôi.   
                    </span>
                        <hr>
                        <span>
                         <b> Chưa có tài khoản?  </b> <a href="{{route('signup')}}">Đăng ký tại đây</a>
                        </span>
                        <hr>
                        <div class="px-3"></div>
                     
                   
                <div class="clearfix"></div>
                        <button type="submit" class="btn btn-primary btn-block border-0 py-3">Đăng nhập</button>
                    </form>
                </div>
            </div>
            <!-- <div class="col-sm-1">
				<h5>Hoặc</h5>
			</div> -->
            <!-- <div class="col-sm-5">
                <div class="signup-form dn">
                    <h2>Đăng ký</h2>
                    <form action="{{route('dangky-khachhang')}}" method="POST">
                        @csrf
                        <label  class=" py-2  "  for="">Tên tài khoản</label>
                        <input name="name" class="form-control border-1 py-4" type="text" placeholder=""/>
                        <label  class=" py-2  " for="">Địa chỉ email</label>
                        <input name="email" class="form-control border-1 py-4" type="email" placeholder=""/>
                        <label  class=" py-2  " for="">Địa chỉ</label>
                        <input name="address" class="form-control border-1 py-4" type="text" placeholder=""/>
                        <label   class=" py-2  " for="">Mật khẩu</label>
                        <input name="pass" class="form-control border-1 py-4" type="password" placeholder=""/>
                        <label  class=" py-2 " for="">Số điện thoại</label>
                        <input name="phone" class="form-control border-1 py-4" type="text" placeholder=""/>
                        <label  class=" py-2 " for=""></label>
                        <button name="submit" type="submit" class="btn btn-primary btn-block border-0 py-3">Đăng ký</button>
                    </form>
                </div>
            </div> -->
        </div>
    </div>
</section>




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