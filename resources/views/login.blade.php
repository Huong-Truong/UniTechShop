@extends('layout')
@section('slide')
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

<section id="form">
    <div class="container">
        <div class="row">
		
            <div class="col-sm-6 col-sm-offset-2">
                <div class="login-form dn">
                    <h2>Đăng nhập</h2>
                    <form action="{{route('login-khachhang')}}" method="POST">
                        @csrf
                        <input name="khachhang_email" type="text" class="form-control border-0 py-4" name="email_account" placeholder="Email tài khoản" />
                        <input name="khachhang_matkhau" type="password" class="form-control border-0 py-4" name="password_account" placeholder="Mật khẩu" />
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
                    <form action="{{route('dangky-khachhang')}}" method="POST">
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
</section>
@endsection


<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->


