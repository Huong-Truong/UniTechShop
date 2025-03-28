<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<head>
<title>Quên mật khẩu</title>
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
 <!-- Favicon -->
 <link href="{{asset('img/favicon.ico')}}" rel="icon">
 <style>
   
    #messageStyle{
    color: rgb(230, 230, 230);
    width: 100%;
    text-align: center;
    }
    
  

    

</style>
</head>
<body>
 
<div class="log-w3"><br><br>
<div class="w3layouts-main for-got">
    <h2>ĐỔI MẬT KHẨU</h2>
    <?php 
    $message = Session::get('message'); ## lấy tin nhắn có tên là message
    if($message){
       echo "<span id='messageStyle'> $message </span>" ;
        Session::put('message',null); ## in ra xong set lại null
    }
?>
        <form action="{{route('confirm-change-pass')}}" method="post">
            @csrf
            <input type="hidden" name="id" value="{{$id}}">
            <input type="password" class="ggg" name="old" placeholder="MẬT KHẨU CŨ" required="">
            <input type="password" class="ggg" name="new" placeholder="MẬT KHẨU MỚI" required="">
            <input type="password" class="ggg" name="confirm" placeholder="XÁC NHẬN MẬT KHẨU MỚI" required="">
            <h6><a href="{{route('admin')}}">ĐĂNG NHẬP</a></h6>
                <div class="clearfix"></div>
                <input type="submit" value="Đổi mật khẩu">
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
