<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<?php 
    // session_start();
?> 
<!DOCTYPE html>
<head>
<title>UniTech - Trang quản lý</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
 <!-- Favicon -->
 <link rel="shortcut icon" href="https://assets.pngwing.com/public/css/favicon.ico" style="filter: hue-rotate(90deg);">
 {{-- <link rel="shortcut icon" href="{{asset('images/logo.png')}}"> --}}
 {{-- <link href="{{asset('images/logo1.png')}}" rel="icon"  type="image/png"> --}}
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- bootstrap-css -->
<link rel="stylesheet" href="{{asset('admin_css/bootstrap.min.css')}}" >
<!-- //bootstrap-css -->
<!-- Custom CSS -->
<link href="{{asset('admin_css/style.css')}}" rel='stylesheet' type='text/css' />
<link href="{{asset('admin_css/style-responsive.css')}}" rel="stylesheet"/>
<!-- font CSS -->
<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<!-- font-awesome icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{asset('admin_css/font.css')}}" type="text/css"/>
<link href="{{asset('admin_css/font-awesome.css')}}" rel="stylesheet"> 
<link rel="stylesheet" href="{{asset('admin_css/morris.css')}}" type="text/css"/>
<!-- calendar -->
<link rel="stylesheet" href="{{asset('admin_css/monthly.css')}}">
<!-- //calendar -->
<!-- //font-awesome icons -->
<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
<script src="{{asset('admin_js/jquery2.0.3.min.js')}}"></script>
<script src="{{asset('admin_js/raphael-min.js')}}"></script>
<script src="{{asset('admin_js/morris.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



<script type="text/javascript">
    $(document).ready(function(){
        // gọi hàm
        load_gallery();
        // viết hàm
        function load_gallery(){
            var pro_id = $('.pro_id').val();
            var _token = $('input[name="_token"]').val();

           // alert(pro_id);
            $.ajax({
              url:" {{ route('select-gallery') }}",
                method : "POST",
                data:{pro_id: pro_id,_token: _token},
                success: function(data){
                    $('#gallery_load').html(data);
                }
            });
        }

        $('#file').change(function(){
            var error = false;
            var files = $('#file')[0].files;
           ;
            if(files.length > 5){
                alert('Chỉ được chọn tối đa 5 ảnh ');
                error=true;
                // error += '<p id="messageStyle">Bạn chỉ được chọn tối đa 10 ảnh</p>';
            // } else if(files.length == ''){
            //     alert('Bạn không được bỏ trống ảnh ');
            //     // error += '<p  id="messageStyle">Bạn không được bỏ trống ảnh</p>';
            } else if(files.size > 1000){
                error=true;
                alert('Kích thước của anh không được lớn hơn 8MB');
                // error += '<p id="messageStyle">Kích thước của anh không được lớn hơn 8MB</p>';
            }

            if(error==false){

            } else {
                $('#file').val('');
               // $('#error_gallery').html('<span class="text-danger">'+error+'</span>');
                return false;
            }
        });

        $(document).on('blur','.edit_gallery_name',function(){
            var gal_id = $(this).data('gal_id');
            var gal_text = $(this).text();
            var _token = $('input[name="_token"]').val();
            $.ajax({
              url:" {{ route('update-gallery') }}",
                method : "POST",
                data:{gal_id:gal_id,gal_text: gal_text,_token: _token},
                success: function(data){
                    load_gallery();
                }
            });

        });

        $(document).on('click','.delete-gallery',function(){
            var gal_id = $(this).data('gal_id');
            var gal_text = $(this).text();
            var _token = $('input[name="_token"]').val();
            if(confirm('Ảnh trong thư mục gốc cũng sẽ bị xóa ?')){
                $.ajax({
                url:" {{ route('delete-gallery') }}",
                    method : "POST",
                    data:{gal_id:gal_id,gal_text: gal_text,_token: _token},
                    success: function(data){
                        load_gallery();
                    }
                });
            }
        });

    });
</script>
<style>
     
     
   
    p#messageStyle{
    color:rgb(79, 78, 78);
    font-size: 15px;
    width:100%;
    text-align: center;
    padding: 15px;
    background-color:#FFFF; 
   
    }
    .fa-thumb-style {
    font-size: 20px;
    color: gray;
}

</style>
</head>
<body>
<section id="container">
<!--header start-->
<header class="header fixed-top clearfix">
<!--logo start-->
<div class="brand">
    <a href="{{route('dashboard')}}" class="logo">
        UniTech
    </a>
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars"></div>
    </div>
</div>
{{-- Lỗi --}}


<!--logo end-->
{{-- <div class="nav notify-row" id="top_menu">
    <!--  notification start -->
    <ul class="nav top-menu">
        <!-- settings start -->
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <i class="fa fa-tasks"></i>
                <span class="badge bg-success">8</span>
            </a>
            <ul class="dropdown-menu extended tasks-bar">
                <li>
                    <p class="">You have 8 pending tasks</p>
                </li>
                <li>
                    <a href="#">
                        <div class="task-info clearfix">
                            <div class="desc pull-left">
                                <h5>Target Sell</h5>
                                <p>25% , Deadline  12 June’13</p>
                            </div>
                                    <span class="notification-pie-chart pull-right" data-percent="45">
                            <span class="percent"></span>
                            </span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="task-info clearfix">
                            <div class="desc pull-left">
                                <h5>Product Delivery</h5>
                                <p>45% , Deadline  12 June’13</p>
                            </div>
                                    <span class="notification-pie-chart pull-right" data-percent="78">
                            <span class="percent"></span>
                            </span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="task-info clearfix">
                            <div class="desc pull-left">
                                <h5>Payment collection</h5>
                                <p>87% , Deadline  12 June’13</p>
                            </div>
                                    <span class="notification-pie-chart pull-right" data-percent="60">
                            <span class="percent"></span>
                            </span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="task-info clearfix">
                            <div class="desc pull-left">
                                <h5>Target Sell</h5>
                                <p>33% , Deadline  12 June’13</p>
                            </div>
                                    <span class="notification-pie-chart pull-right" data-percent="90">
                            <span class="percent"></span>
                            </span>
                        </div>
                    </a>
                </li>

                <li class="external">
                    <a href="#">See All Tasks</a>
                </li>
            </ul>
        </li> --}}
        <!-- settings end -->
        {{-- <!-- inbox dropdown start-->
        <li id="header_inbox_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <i class="fa fa-envelope-o"></i>
                <span class="badge bg-important">4</span>
            </a>
            <ul class="dropdown-menu extended inbox">
                <li>
                    <p class="red">You have 4 Mails</p>
                </li>
                <li>
                    <a href="#">
                        <span class="photo"><img alt="avatar" src="images/3.png"></span>
                                <span class="subject">
                                <span class="from">Jonathan Smith</span>
                                <span class="time">Just now</span>
                                </span>
                                <span class="message">
                                    Hello, this is an example msg.
                                </span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="photo"><img alt="avatar" src="images/1.png"></span>
                                <span class="subject">
                                <span class="from">Jane Doe</span>
                                <span class="time">2 min ago</span>
                                </span>
                                <span class="message">
                                    Nice admin template
                                </span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="photo"><img alt="avatar" src="images/3.png"></span>
                                <span class="subject">
                                <span class="from">Tasi sam</span>
                                <span class="time">2 days ago</span>
                                </span>
                                <span class="message">
                                    This is an example msg.
                                </span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="photo"><img alt="avatar" src="images/2.png"></span>
                                <span class="subject">
                                <span class="from">Mr. Perfect</span>
                                <span class="time">2 hour ago</span>
                                </span>
                                <span class="message">
                                    Hi there, its a test
                                </span>
                    </a>
                </li>
                <li>
                    <a href="#">See all messages</a>
                </li>
            </ul>
        </li>
        <!-- inbox dropdown end --> --}}
        <!-- notification dropdown start-->
        {{-- <li id="header_notification_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                <i class="fa fa-bell-o"></i>
                <span class="badge bg-warning">3</span>
            </a>
            <ul class="dropdown-menu extended notification">
                <li>
                    <p>Notifications</p>
                </li>
                <li>
                    <div class="alert alert-info clearfix">
                        <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                        <div class="noti-info">
                            <a href="#"> Server #1 overloaded.</a>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="alert alert-danger clearfix">
                        <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                        <div class="noti-info">
                            <a href="#"> Server #2 overloaded.</a>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="alert alert-success clearfix">
                        <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                        <div class="noti-info">
                            <a href="#"> Server #3 overloaded.</a>
                        </div>
                    </div>
                </li>

            </ul>
        </li>
        <!-- notification dropdown end -->
    </ul> --}}
    <!--  notification end -->
</div>
<div class="top-nav clearfix ">
    <!--search & user info start-->
    <ul class="nav pull-right top-menu">
        
        <!-- user login dropdown start-->
        <li class="dropdown" class="profile" >
            <a data-toggle="dropdown" class="dropdown-toggle" href="#" >
                {{-- <i class="fa fa-user-tie"></i> --}}
                {{-- <img alt=" " src="images/huongtruong.jpg"> --}}
                <i class="fa fa-user" style="padding: 7px; font-size: 20px;"></i>
                <span class="username">
                    <?php 
                        $name = Session::get('admin_name');
                        if($name){
                            echo $name;
                        }
                        $id = Session::get('admin_id');
                    ?>
                </span>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
                {{-- <li><a href="#"><i class=" fa fa-suitcase"></i>Profile</a></li> --}}
                <li><a href="{{ route('admin-change-pass',['id'=> $id ]) }}"><i class="fa fa-lock"></i></i></i> Đổi mật khẩu</a></li>
                <li><a href="{{ route('logout') }}"><i class="fa fa-key"></i> Đăng xuất</a></li>
            </ul>
        </li>
        <!-- user login dropdown end -->
       
    </ul>
    <!--search & user info end-->
</div>
</header>
<!--header end-->
<!--sidebar start-->
<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a class="active" href="{{ route('dashboard') }}">
                        <i class="fa fa-pie-chart"></i>
                        <span>Tổng quan</span>
                    </a>
                </li>
                
                 <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Quản lý phân loại</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{ route('add-classify') }}">Thêm phân loại sản phẩm</a></li>
						<li><a href="{{route('all-classify') }}">Liệt kê phân loại sản phẩm</a></li>
                    </ul>
                </li> 
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-clipboard"></i>
                       
                        <span>Quản lý danh mục</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{ route('add-category') }}">Thêm danh mục sản phẩm</a></li>
						<li><a href="{{route('all-category') }}">Liệt kê danh mục sản phẩm</a></li>
                       
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="	fa fa-chrome"></i>
                        
                        <span>Quản lý thương hiệu</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{ route('add-brand') }}">Thêm thương hiệu </a></li>
						<li><a href="{{route('all-brand') }}">Liệt kê thương hiệu</a></li>
                       
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                         <i class="fa fa-tasks"></i>
                        <span> Quản lý sản phẩm</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{ route('add-product') }}">Thêm sản phẩm</a></li>
						<li><a href="{{route('all-product') }}">Liệt kê sản phẩm</a></li>
                       
                    </ul>
                </li>
               
                    <li>
                        <a href="{{ route('manage-orders') }}">
                            <i class=" fa fa-bar-chart-o"></i>
                            Quản lý đơn hàng
                        </a>
    
                    </li>
                    
               
                <li>
                    <a href="{{ route('all-sales') }}">
                        <i class="fa fa-bullhorn"></i>
                      Khuyến mãi
                    </a>

                </li>
                <li>
                    <a href="{{ route('all-service') }}">
                        <i class="fa fa-glass"></i>
                       Dịch vụ
                    </a>

                </li>

                <li>
                    <a href="{{ route('all-baohanh') }}">
                        <i class="fa fa-code"></i>
                    Bảo hành
                    </a>

                </li>
                
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-th"></i>
                        <span>Quản lý kho</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{route('all-nhacungcap')}}">Quản lý nhà cung cấp</a></li>
                        <li><a href="{{route('store-product')}}">Quản lý kho hàng</a></li>
                        
                    </ul>
                </li>
                {{-- <li>
                    <a href="fontawesome.html">
                        <i class="fa fa-bullhorn"></i>
                        <span>Font awesome </span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-th"></i>
                        <span>Data Tables</span>
                    </a>
                    <ul class="sub">
                        <li><a href="basic_table.html">Basic Table</a></li>
                        <li><a href="responsive_table.html">Responsive Table</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-tasks"></i>
                        <span>Form Components</span>
                    </a>
                    <ul class="sub">
                        <li><a href="form_component.html">Form Elements</a></li>
                        <li><a href="form_validation.html">Form Validation</a></li>
						<li><a href="dropzone.html">Dropzone</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-envelope"></i>
                        <span>Mail </span>
                    </a>
                    <ul class="sub">
                        <li><a href="mail.html">Inbox</a></li>
                        <li><a href="mail_compose.html">Compose Mail</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class=" fa fa-bar-chart-o"></i>
                        <span>Charts</span>
                    </a>
                    <ul class="sub">
                        <li><a href="chartjs.html">Chart js</a></li>
                        <li><a href="flot_chart.html">Flot Charts</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class=" fa fa-bar-chart-o"></i>
                        <span>Maps</span>
                    </a>
                    <ul class="sub">
                        <li><a href="google_map.html">Google Map</a></li>
                        <li><a href="vector_map.html">Vector Map</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-glass"></i>
                        <span>Extra</span>
                    </a>
                    <ul class="sub">
                        <li><a href="gallery.html">Gallery</a></li>
						<li><a href="404.html">404 Error</a></li>
                        <li><a href="registration.html">Registration</a></li>
                    </ul>
                 </li> --}}
                <li> 
                    <a href="{{route('all-customer')}}">
                        <i class="fa fa-user"></i>
                       Khách hàng
                    </a>

                </li>
            </ul>            </div>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
	<section class="wrapper">
    @yield('admin-content')
</section>
 <!-- footer -->
		  <div class="footer">
			<div class="wthree-copyright">
			  <p> 2025 | Design by  <a href="https://www.facebook.com/chiienn02/">Nguyen Ngoc Chien</a></p>
			</div>
		  </div>
  <!-- / footer -->
</section>
<!--main content end-->
</section>
<script src="{{asset('admin_js/bootstrap.js')}}"></script>
<script src="{{asset('admin_js/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{asset('admin_js/scripts.js')}}"></script>
<script src="{{asset('admin_js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('admin_js/jquery.nicescroll.js')}}"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
<script src="{{asset('admin_js/jquery.scrollTo.js')}}"></script>
<!-- morris JavaScript -->	
<script>
	$(document).ready(function() {
		//BOX BUTTON SHOW AND CLOSE
	   jQuery('.small-graph-box').hover(function() {
		  jQuery(this).find('.box-button').fadeIn('fast');
	   }, function() {
		  jQuery(this).find('.box-button').fadeOut('fast');
	   });
	   jQuery('.small-graph-box .box-close').click(function() {
		  jQuery(this).closest('.small-graph-box').fadeOut(200);
		  return false;
	   });
	   
	    //CHARTS
	    function gd(year, day, month) {
			return new Date(year, month - 1, day).getTime();
		}
		
		graphArea2 = Morris.Area({
			element: 'hero-area',
			padding: 10,
        behaveLikeLine: true,
        gridEnabled: false,
        gridLineColor: '#dddddd',
        axes: true,
        resize: true,
        smooth:true,
        pointSize: 0,
        lineWidth: 0,
        fillOpacity:0.85,
			data: [
				{period: '2015 Q1', iphone: 2668, ipad: null, itouch: 2649},
				{period: '2015 Q2', iphone: 15780, ipad: 13799, itouch: 12051},
				{period: '2015 Q3', iphone: 12920, ipad: 10975, itouch: 9910},
				{period: '2015 Q4', iphone: 8770, ipad: 6600, itouch: 6695},
				{period: '2016 Q1', iphone: 10820, ipad: 10924, itouch: 12300},
				{period: '2016 Q2', iphone: 9680, ipad: 9010, itouch: 7891},
				{period: '2016 Q3', iphone: 4830, ipad: 3805, itouch: 1598},
				{period: '2016 Q4', iphone: 15083, ipad: 8977, itouch: 5185},
				{period: '2017 Q1', iphone: 10697, ipad: 4470, itouch: 2038},
			
			],
			lineColors:['#eb6f6f','#926383','#eb6f6f'],
			xkey: 'period',
            redraw: true,
            ykeys: ['iphone', 'ipad', 'itouch'],
            labels: ['All Visitors', 'Returning Visitors', 'Unique Visitors'],
			pointSize: 2,
			hideHover: 'auto',
			resize: true
		});
		
	   
	});
	</script>
<!-- calendar -->
	<script type="text/javascript" src="{{asset('admin_js/monthly.js')}}"></script>
	<script type="text/javascript">
		$(window).load( function() {

			$('#mycalendar').monthly({
				mode: 'event',
				
			});

			$('#mycalendar2').monthly({
				mode: 'picker',
				target: '#mytarget',
				setWidth: '250px',
				startHidden: true,
				showTrigger: '#mytarget',
				stylePast: true,
				disablePast: true
			});

		switch(window.location.protocol) {
		case 'http:':
		case 'https:':
		// running on a server, should be good.
		break;
		case 'file:':
		alert('Just a heads-up, events will not work when run locally.');
		}

		});
	</script>
	<!-- //calendar -->
</body>
</html>
