
<style>
.container{
    padding: 100px;
}
 .dn, .login-form, .signup-form {
    border: 1px solid #000000; /* 2px wide black border */
	border-radius: 10px;
	padding: 15px;
}
</style>

<!-- <section id="form">
    <div class="container">
        <div class="row">
		
            <div class="col-sm-6 col-sm-offset-2">
                <div class="login-form dn">
                    <h2>Đăng nhập</h2>
                    <form action="" method="POST">
                        @csrf
                        <input type="text" class="form-control border-0 py-4" name="email_account" placeholder="Tài khoản" />
                        <input type="password" class="form-control border-0 py-4" name="password_account" placeholder="Mật khẩu" />
                        <span>
                            <input type="checkbox" class="checkbox"> 
                            Ghi nhớ
                        </span>
                        <button type="submit" class="btn btn-primary btn-block border-0 py-3">Đăng nhập</button>
                    </form>
                </div>
            </div>
            <div class="col-sm-1">
				<h5>Hoặc</h5>
			</div>
            <div class="col-sm-5">
                <div class="signup-form dn">
                    <h2>Đăng ký</h2>
                    <form action="" method="POST">
                        @csrf
                        <input name="name" class="form-control border-0 py-4" type="text" placeholder="Tên tài khoản"/>
                        <input name="email" class="form-control border-0 py-4" type="email" placeholder="Địa chỉ email"/>
                        <input name="pass" class="form-control border-0 py-4" type="password" placeholder="Mật khẩu"/>
                        <input name="phone" class="form-control border-0 py-4" type="text" placeholder="Số điện thoại"/>
                        <button name="submit" type="submit" class="btn btn-primary btn-block border-0 py-3">Đăng ký</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section> -->


<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<head>
<title>Trang Quản Lý</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- bootstrap-css -->
<link rel="stylesheet" href="{{ asset('admin_css/bootstrap.min.css') }}" >
<!-- //bootstrap-css -->
<!-- Custom CSS -->
<link href="{{ asset('admin_css/style.css') }}" rel='stylesheet' type='text/css' />
<link href="{{ asset('admin_css/style-responsive.css') }}" rel="stylesheet"/>
<!-- font CSS -->
<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<!-- font-awesome icons -->
<link rel="stylesheet" href="{{ asset('admin_css/font.css') }}" type="text/css"/>
<link href="{{ asset('admin_css/font-awesome.css') }}" rel="stylesheet"> 
<!-- //font-awesome icons -->
<script src="{{ asset('admin_js/jquery2.0.3.min.js') }}"></script>
<style>
    #messageStyle{
    color: red;
    width: 100%;
    text-align: center;
    }
    
  
</style>
</head>
<body>
<div class="log-w3"><br><br>
<div class="w3layouts-main">
    <h2>Đăng Nhập</h2>
    
    <?php 
        $message = Session::get('message'); ## lấy tin nhắn có tên là message
        if($message){
           echo "<span id='messageStyle'> $message </span>" ;
            Session::put('message',null); ## in ra xong set lại null
        }
    ?>
        <form action="{{route('admin-dashboard')}}" method="post">
            @csrf
            <input type="email" class="ggg" name="admin_email" placeholder="EMAIL" required="">
            <input type="password" class="ggg" name="admin_password" placeholder="PASSWORD" required="">
            <span><input type="checkbox" />Ghi nhớ</span>
            <h6><a href="#">Quên mật khẩu?</a></h6>
                <div class="clearfix"></div>
                <input type="submit" value="Đăng nhập" name="login">
        </form>
        <!-- <p>Don't Have an Account ?<a href="registration.html">Create an account</a></p> -->
</div>
</div>
<script src="{{ asset('admin_js/bootstrap.js') }}"></script>
<script src="{{ asset('admin_js/jquery.dcjqaccordion.2.7.js') }}"></script>
<script src="{{ asset('admin_js/scripts.js') }}"></script>
<script src="{{ asset('admin_js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('admin_js/jquery.nicescroll.js') }}"></script>
<script src="{{ asset('admin_js/jquery.scrollTo.js') }}"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="admin_js/flot-chart/excanvas.min.js"></script><![endif]-->
</body>
</html>

