@extends('admin_layout')
@section('admin-content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel ">
                        <header class="panel-heading">
                            Thêm thương hiệu
                        </header>
                       
                        <div class="panel-body">
                            {{--Tên hãng--}}
                            <div class="position-center">
                                <form role="form" action="{{route('save-brand')}}" method="post" >
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên hãng</label>
                                    <input name="brand_name" class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục">
                                </div>
                            {{--Trạng thái hãng--}}
                            <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả Hãng</label>
                                        <textarea  name="brand_content" style="resize: none" rows = "8"  placeholder="Mô tả sản phẩm" class="form-control" name="" id="exampleInputPassword1"></textarea>
                            </div>
                                <div class="form-group">
                                <label for="exampleInputPassword1">Hiển thị</label>
                                <select name="brand_status" class="form-control input-sm m-bot15">
                                <option value = "0">Ẩn</option>
                                <option value = "1">Hiển thị</option>
                                </select>
                                </div>
                                <button type="submit" name="add_brand_product" class="btn btn-info">Thêm hãng</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
           
@endsection
