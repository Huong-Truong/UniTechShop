@extends('admin_layout')
@section('admin-content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel ">
                        <header class="panel-heading">
                            Thêm khuyến mãi
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
                                <form role="form" action="{{route('save-sales-brand')}}" method="post" >
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Giá trị</label>
                                    <input name="sale_price" class="form-control" id="exampleInputEmail1" required>
                                    <label for="exampleInputEmail1">Đơn vị</label>
                                    <select name="sale_unit" class="form-control input-sm m-bot15">
                                     
                                      <option value = "%">%</option>
                                      <option value = "VND">VND</option>
                                      </select>

                                      <label for="exampleInputEmail1">Thương hiệu</label>
                                    
                                    <select  name="sale_brand" class="form-control input-sm m-bot15">
                                    @foreach($thuonghieu as $key => $value)
                                      <option value ="{{$value->hang_id}}">{{$value->hang_ten}}</option>

                                      @endforeach
                                      </select>
                               
                                </div>
                            {{----}}
                            <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả</label>
                                        <textarea  name="sale_content" style="resize: none" rows = "3"  class="form-control" name="" id="exampleInputPassword1" required></textarea>
                            </div>
                            <label for="exampleInputEmail1">Ngày bắt đầu</label>
                                      <input type="date" name="start_date" class="form-control" 
                                      id="exampleInputEmail1" value="<?php echo date("Y-m-d")?>" >
                                      <br
                                      <label for="exampleInputEmail1">Ngày kết thúc</label>
                                      <input type="date" name="end_date" class="form-control" id="exampleInputEmail1" >
                                <button type="submit" name="add_sales" class="btn btn-info">Thêm khuyến mãi</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
           
@endsection
