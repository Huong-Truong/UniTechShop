@extends('admin_layout')
@section('admin-content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel ">
                        <header class="panel-heading">
                            Thêm nhà cung cấp mới
                        </header>
                        <?php 
                            $message = Session::get('message'); ## lấy tin nhắn có tên là message
                            if($message){
                            echo "<p id='messageStyle'> $message </p>" ;
                                Session::put('message',null); ## in ra xong set lại null
                            }
                        ?>
                        <div class="panel-body">
                            {{----}}
                            @foreach ($edit_nhacungcap as $key => $value )
                            <div class="position-center">
                                                            
                                <form role="form" action="{{route('update-nhacungcap',['nhacungcap_id' => $value->nhacungcap_id])}}" method="post" >
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên nhà cung cấp</label>
                                    <input value="{{$value->nhacungcap_ten}}" name="nhacungcap_ten" class="form-control" id="exampleInputEmail1"   required>      
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">SDT</label>
                                    <input value="{{$value->nhacungcap_sdt}}" name="nhacungcap_sdt" class="form-control" id="exampleInputEmail1"   required>      
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">EMAIL</label>
                                    <input value="{{$value->nhacungcap_email}}" type="email" name="nhacungcap_email" class="form-control" id="exampleInputEmail1"   required>      
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Địa chỉ</label>
                                    <input value="{{$value->nhacungcap_diachi}}" name="nhacungcap_diachi" class="form-control" id="exampleInputEmail1"   required>      
                                </div>
                            {{----}}
                            
                                <button type="submit" name="add_nhacungcap" class="btn btn-info">Xác nhận</button>
                            </form>
                            @endforeach
                            </div>

                        </div>
                    </section>

            </div>
           
@endsection
