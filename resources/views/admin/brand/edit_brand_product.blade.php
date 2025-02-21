@extends('admin_layout')
@section('admin-content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Chỉnh sửa thương hiệu sản phẩm
                        </header>
                        <?php 
                        $message = Session::get('message'); ## lấy tin nhắn có tên là message
                        if($message){
                        echo "<p id='messageStyle'> $message </p>" ;
                            Session::put('message',null); ## in ra xong set lại null
                        }
                        ?>
                        <div class="panel-body">
                            @foreach ($edit_brand as $key => $edit_value)
                            <div class="position-center">
                                <form role="form" action="{{route('update-brand', ['brand_id' => $edit_value->hang_id])}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên hãng</label>
                                    <input value="{{ $edit_value->hang_ten}}"name="brand_name" class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục">
                                </div> 
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả Hãng</label>
                                        <textarea  name="brand_content" style="resize: none" rows = "8"  placeholder="Mô tả sản phẩm" class="form-control" name="" id="exampleInputPassword1"></textarea>
                                </div>              
                                <button type="submit" name="update_brand_product" class="btn btn-info">Cập nhật hãng</button>
                            </form>
                            </div>
                            @endforeach
                        </div>
                    </section>

            </div>
           
@endsection
