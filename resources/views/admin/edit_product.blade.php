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
                        echo "<p id='messageStyle'> $message </p>" ;
                            Session::put('message',null); ## in ra xong set lại null
                        }
                        ?>
                        <div class="panel-body">
                           
                            <div class="position-center">
                                <form role="form" action="{{route('update-product', ['product_id' => $edit_product->sanpham_id])}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên Sản phẩm</label>
                                    <input value="{{ $edit_product->sanpham_ten}}"name="product_name" class="form-control" id="exampleInputEmail1">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Giá</label>
                                    <input value="{{ $edit_product->sanpham_gia}}"name="product_price" class="form-control" id="exampleInputEmail1">
                                </div>
                                <div class="form-group">

                                    <label for="exampleInputEmail1">Hình ảnh</label>

                                  <img src="{{asset('img/sp'.$edit_product->sanpham_id.'/'.$edit_product->sanpham_hinhanh)}}" height="100" width="100" alt="">
                                    <input type="file" name="product_image" class="form-control" id="exampleInputEmail1" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nội dung sản phẩm</label>
                                        <textarea  name="product_content" style="resize: none" rows = "8"  placeholder="Mô tả danh mục" class="form-control" name="" id="exampleInputPassword1">
                                            {{ $edit_product->sanpham_mota}}
                                        </textarea>
                                </div>
                                <div class="form-group">
                                <label for="exampleInputPassword1">Danh mục sản phẩm</label>
                                <select name="category" class="form-control input-sm m-bot15">
                                    @foreach ($cate_product as $key=>$value)
                                        <option value = "{{$value->danhmuc_id}}" {{ $value->danhmuc_id == $edit_product->danhmuc_id ? 'selected' : '' }}>
                                            {{$value->danhmuc_ten}}
                                        </option>
                                    @endforeach
                                </select>
                                </div>
                                <div class="form-group">
                                <label for="exampleInputPassword1">Thương hiệu sản phẩm</label>
                                <select  name="brand" class="form-control input-sm m-bot15">
                                @foreach ($brand_product as $key=>$value)
                                        <option value = "{{$value->hang_id}}" {{ $value->hang_id == $edit_product->hang_id ? 'selected' : '' }}>
                                            {{$value->hang_ten}}
                                        </option>
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
