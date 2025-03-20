@extends('admin_layout')
@section('admin-content')
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
<button class="styled-button">
    <a href="{{route('thongke-don-thang')}}">Tháng này bán được <p class="red">{{$soluongdon}}</p> đơn</a>
</button>
<button class="styled-button">
    <a href="{{route('thongke-sp')}}">Thống kê sản phẩm</a>
</button>

@endsection
