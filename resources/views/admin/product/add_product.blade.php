@extends('admin_layout')
@section('admin-content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm sản phẩm
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
                                <form role="form" action="{{route('save-product')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên Sản phẩm</label>
                                    <input name="product_name" class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Giá</label>
                                    <input name="product_price" class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hình ảnh</label>
                                    <input type="file" name="product_image" class="form-control" id="exampleInputEmail1" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả Sản phẩm</label>
                                    <textarea name="product_content" style="resize: none" rows="8" placeholder="Mô tả sản phẩm" class="form-control" id="noidung1"></textarea>
                                    <script>
                                    console.log("CKEditor script loaded");
                                    CKEDITOR.replace("noidung1");
                                </script>

                                </div>


                                <div class="form-group">
                                <label for="exampleInputPassword1">Danh mục</label>
                                <select name="category" class="form-control input-sm m-bot15">
                                     @foreach ($cate_product as $key=>$value)
                                        <option value = "{{$value->danhmuc_id}}">{{$value->danhmuc_ten}}</option>
                                    @endforeach 
                                </select>
                                </div>
                              
                                <div class="form-group">
                                <label for="exampleInputPassword1">Thương hiệu</label>
                                <select name="brand" class="form-control input-sm m-bot15">
                                 @foreach ($brand_product as $key=>$value)
                                        <option value = "{{$value->hang_id}}">{{$value->hang_ten}}</option>
                                @endforeach
                                 
                             
                                </select>
                                </div>

                                <div class="form-group">
                                <label for="exampleInputPassword1">Hiển thị</label>
                                <select name="product_status" class="form-control input-sm m-bot15">
                                <option value = "0">Ẩn</option>
                                <option value = "1">Hiển thị</option>
                             
                                </select>
                                </div>
                                <button type="submit" name="add_product" class="btn btn-info">Thêm sản phẩm</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
           
@endsection
