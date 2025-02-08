@extends('admin_layout')
@section('admin-content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm danh mục sản phẩm
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
                                <form role="form" action="{{route('save-category')}}" method="post">
                                @csrf
                                 {{-- Tên danh mục --}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên danh mục</label>
                                    <input name="danhmuc_ten" class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục">
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
