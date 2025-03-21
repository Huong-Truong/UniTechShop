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
        body{
               background-color: #f0f2f4!important; 
        }
.container{
    padding-top: 25px;
    padding-bottom: 50px;
}
 .dn, .login-form, .signup-form {
 
	border-radius: 5px;
	padding: 15px;
    background-color:rgb(255, 255, 255) !important;
}

form label{
	padding: 45px;
    font-weight: bold !important;
   
}
.dn .form-control{
    border: 1px  rgb(130, 130, 130)  solid ;
}
h2{
    padding: 40px;
    text-align: center;
}
.login-form{
    width: 700px;
}
</style>
</head>
<?php
    $message = Session::get('message');
    if($message){?>
    <div id="errorBox" class="error-box">
        {{$message}}
    </div>
<?php
    Session::forget('message');
    }
?>
<body>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row bg-secondary py-2 px-xl-5">
            <div class="col-lg-4 d-none d-lg-block">
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
     
                <div class="login-form dn">
                    <h2>Thông tin tài khoản</h2>
                    <form action="{{route('review-user')}}" method="POST">
                        @csrf
                        
                       
                        <input name="email" type="text"   class="form-control border-3-dark px-6" name="email_account" placeholder="Email tài khoản" />
                        <br>
                        
                
                        {{-- <input name="khachhang_matkhau"  type="password" class="form-control border-3 " name="password_account" placeholder="Mật khẩu" /> --}}
                        
                        
                        <small class=" py-2 " for=""><a href="{{route('login-checkout')}}">Quay lại đăng nhập</a></small>
                        <hr>
                        <small>
                   
                <div class="clearfix"></div>
                        <button type="submit" class="btn btn-primary btn-block border-0 py-3">Cấp lại mật khẩu</button>
                    </form>
             
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