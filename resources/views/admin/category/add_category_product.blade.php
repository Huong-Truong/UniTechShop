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
                            Thêm danh mục sản phẩm
                        </header>
                     
                        <div class="panel-body">
                            <div class="position-center">
                                <form role="form" action="{{route('save-category')}}" method="post">
                                @csrf
                                 {{-- Tên danh mục --}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên danh mục</label>
                                    <input name="danhmuc_ten" class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục">
                                </div>
                                {{-- Phân loại --}}
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Thương hiệu</label>
                                    <select name="classify" class="form-control input-sm m-bot15">
                                     @foreach ($classify_product as $key=> $value)
                                            <option value = "{{$value->phanloai_id}}">{{$value->phanloai_ten}}</option>
                                    @endforeach
                                     
                                 
                                    </select>
                                    </div>
                                {{-- Trạng thái --}}
                                <div class="form-group">
                                <label for="exampleInputPassword1">Hiển thị</label>
                                <select name="danhmuc_trangthai" class="form-control input-sm m-bot15">
                                <option value = "0">Ẩn</option>
                                <option value = "1">Hiển thị</option>
                                </select>
                                </div>
                                <button type="submit" name="add_category_product" class="btn btn-info">Thêm danh mục</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
           
@endsection
