@extends('admin_layout')
@section('admin-content')
<button class="styled-button">
    <a href="{{route('thongke-don-thang')}}">Thống kê đơn hàng</a>
</button>
{{-- <button class="styled-button">
    <a href="{{route('thongke-sp')}}">Thống kê sản phẩm</a>
</button> --}}

@endsection
