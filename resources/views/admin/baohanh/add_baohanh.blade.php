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
                    <section class="panel ">
                        <header class="panel-heading">
                            Thêm chương trình bảo hành mới
                        </header>
                        
                        <div class="panel-body">
                            {{----}}
                            <div class="position-center">
                                <form role="form" action="{{route('save-baohanh')}}" method="post" >
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Thời gian (tháng)</label>
                                    <input name="date_bh" class="form-control" id="exampleInputEmail1"   required>      
                                </div>
                            {{----}}
                            <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả</label>
                                        <textarea  name="bh_mota" style="resize: none" rows = "3"  class="form-control" name="" id="exampleInputPassword1" required></textarea>
                            </div>
                                <button type="submit" name="add_sales" class="btn btn-info">Thêm khuyến mãi</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
           
@endsection
