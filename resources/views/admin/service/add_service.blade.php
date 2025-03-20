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
                            Thêm dịch vụ
                        </header>
                        
                        <div class="panel-body">
                            {{----}}
                            <div class="position-center">
                                <form role="form" action="{{route('save-service')}}" method="post" >
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên dịch vụ</label>
                                    <input name="service_name" class="form-control" id="exampleInputEmail1" required>
                                </div>
                                <button type="submit" name="add_service" class="btn btn-info">Thêm dịch vụ</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
           
@endsection
