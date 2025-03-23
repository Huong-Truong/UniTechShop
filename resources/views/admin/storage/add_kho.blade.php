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
                            Thêm kho
                        </header>
                       
                        <div class="panel-body">
                            {{--Tên --}}
                            <div class="position-center">
                                <form role="form" action="{{route('save-kho')}}" method="post" >
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên kho</label>
                                    <input name="name_kho" class="form-control" id="exampleInputEmail1" placeholder="Tên loại" required>
                                    <label for="exampleInputEmail1">Địa chỉ</label>
                                    <input name="name_kho" class="form-control" id="exampleInputEmail1" placeholder="Tên loại" required>
                                </div>
                                <button type="submit" class="btn btn-info">Thêm </button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
           
@endsection
