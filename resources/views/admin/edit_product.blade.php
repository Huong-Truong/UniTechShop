@extends('admin_layout')
@section('admin-content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Cập nhật sản phẩm
                        </header>
                        <?php 
                        $message = Session::get('message'); ## lấy tin nhắn có tên là message
                        if($message){
                        echo "<span id='messageStyle'> $message </span>" ;
                            Session::put('message',null); ## in ra xong set lại null
                        }
                        ?>
                        <div class="panel-body">
                           
                            <div class="position-center">
                                <form role="form" action="{{route('update-product', ['product_id' => $edit_product->product_id])}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên Sản phẩm</label>
                                    <input value="{{ $edit_product->product_name}}"name="product_name" class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Giá</label>
                                    <input value="{{ $edit_product->product_price}}"name="product_price" class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục">
                                </div>
                                <div class="form-group">

                                    <label for="exampleInputEmail1">Hình ảnh</label>

                                  <img src="{{ asset('upload/product/' . $edit_product->product_image) }}" height="100" width="100" alt="">
                                    <input type="file" name="product_image" class="form-control" id="exampleInputEmail1" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                                        <textarea  name="product_desc" style="resize: none" rows = "8"  placeholder="Mô tả danh mục" class="form-control" name="" id="exampleInputPassword1">{{ $edit_product->product_desc}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nội dung sản phẩm</label>
                                        <textarea  name="product_content" style="resize: none" rows = "8"  placeholder="Mô tả danh mục" class="form-control" name="" id="exampleInputPassword1">{{ $edit_product->product_desc}}</textarea>
                                </div>
                                <div class="form-group">
                                <label for="exampleInputPassword1">Danh mục sản phẩm</label>
                                <select name="category" class="form-control input-sm m-bot15">
                                    @foreach ($cate_product as $key=>$value)
                                        <option value = "{{$value->category_id}}" {{ $value->category_id == $edit_product->category_id ? 'selected' : '' }}>{{$value->category_name}}</option>
                                    @endforeach
                                </select>
                                </div>
                                <div class="form-group">
                                <label for="exampleInputPassword1">Thương hiệu sản phẩm</label>
                                <select  name="brand" class="form-control input-sm m-bot15">
                                @foreach ($brand_product as $key=>$value)
                                        <option value = "{{$value->brand_id}}" {{ $value->brand_id == $edit_product->brand_id ? 'selected' : '' }}>{{$value->brand_name}}</option>
                                @endforeach
                                
                             
                                </select>
                                </div>
                                <button type="submit" name="update_product" class="btn btn-info">Cập nhật sản phẩm</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
           
@endsection
