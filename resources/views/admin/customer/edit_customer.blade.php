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
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Chỉnh sửa thông tin khách hàng
                        </header>
                       
                        <div class="panel-body">
                            @foreach ($edit_customer as $key => $edit_value)
                            <div class="position-center">
                                <form role="form" action="{{route('update-customer', ['customer_id' => $edit_value->khachhang_id])}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Họ tên</label>
                                    <input value="{{ $edit_value->khachhang_ten}}" name="khachhang_ten" class="form-control" id="exampleInputEmail1" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Số điện thoại</label>
                                    <input value="{{ $edit_value->khachhang_sdt}}" name="khachhang_sdt" class="form-control" id="exampleInputEmail1" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email</label>
                                    <input value="{{ $edit_value->khachhang_email}}" name="khachhang_email" class="form-control" id="exampleInputEmail1" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Địa chỉ</label>
                                    <input value="{{ $edit_value->khachhang_diachi}}" name="khachhang_diachi" class="form-control" id="exampleInputEmail1" >
                                </div>

                                <button type="submit" name="update_customer" class="btn btn-info">Cập nhật </button>
                            </form>
                            </div>
                            @endforeach
                        </div>
                    </section>

            </div>
           
@endsection
