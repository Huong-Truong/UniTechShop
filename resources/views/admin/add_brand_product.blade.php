@extends('admin_layout')
@section('admin-content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm thương hiệu
                        </header>
                        <?php 
                        $message = Session::get('message'); ## lấy tin nhắn có tên là message
                        if($message){
                        echo "<p id='messageStyle'> $message </p>" ;
                            Session::put('message',null); ## in ra xong set lại null
                        }
                        ?>
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
