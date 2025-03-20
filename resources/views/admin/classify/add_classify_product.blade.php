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
                            Thêm phân loại
                        </header>
                       
                        <div class="panel-body">
                            {{--Tên --}}
                            <div class="position-center">
                                <form role="form" action="{{route('save-classify')}}" method="post" >
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên loại</label>
                                    <input name="classify_name" class="form-control" id="exampleInputEmail1" placeholder="Tên loại">
                                </div>
                                <button type="submit" name="add_classify_product" class="btn btn-info">Thêm </button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
           
@endsection
