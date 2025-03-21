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
                           Chỉnh sửa thương hiệu sản phẩm
                        </header>
                       
                        <div class="panel-body">
                            @foreach($brand as $br)
                            <div class="position-center">
                                <form role="form" action="{{route('update-brand', ['brand_id' => $br->hang_id])}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên hãng</label>
                                    <input value="{{ $br->hang_ten}}"name="brand_name" class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục" required>
                                </div> 
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hình ảnh</label>
                                    <br>
                                  <img class="img_edit"src="{{asset('img/brand/'.$br->hang_hinhanh)}}" height="150" width="150" alt="">
                                    <input type="file" name="brand_image" class="form-control" id="exampleInputEmail1"required >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả Hãng</label>
                                        <textarea  name="brand_content" style="resize: none" rows = "8"  placeholder="Mô tả sản phẩm" class="form-control" name="" id="exampleInputPassword1" required>
                                            {{ $br->hang_mota}}
                                        </textarea>
                                </div>              
                                <button type="submit" name="update_brand_product" class="btn btn-info">Cập nhật hãng</button>
                            </form>
                            </div>
                          @endforeach
                        </div>
                    </section>

            </div>
           
@endsection
