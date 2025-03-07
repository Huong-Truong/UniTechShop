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
                            <div class="position-center">
                                <form role="form" action="{{route('save-nhacungcap')}}" method="post" >
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên nhà cung cấp</label>
                                    <input name="ncc_ten" class="form-control" id="exampleInputEmail1"   required>      
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">SDT</label>
                                    <input name="ncc_sdt" class="form-control" id="exampleInputEmail1"   required>      
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">EMAIL</label>
                                    <input type="email" name="ncc_mail" class="form-control" id="exampleInputEmail1"   required>      
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Địa chỉ</label>
                                    <input name="ncc_diachi" class="form-control" id="exampleInputEmail1"   required>      
                                </div>
                            {{----}}
                            
                                <button type="submit" name="add_nhacungcap" class="btn btn-info">Xác nhận</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
           
@endsection
