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
                            Thiết lập khuyến mãi cho {{$sp->sanpham_ten}}
                        </header>
                        <?php 
                        $message = Session::get('message'); ## lấy tin nhắn có tên là message
                        if($message){
                        echo "<p id='messageStyle'> $message </p>" ;
                            Session::put('message',null); ## in ra xong set lại null
                        }?>
                        <div class="panel-body">
                            {{----}}
                            @if($info_sale)
                            
                            <div class="position-center">
                                <form role="form" action="{{route('save-set-sale',['product_id' => $product_id])}}" method="post" >
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Chọn khuyến mãi</label>
                                    <select name="sale_id" class="form-control input-sm m-bot15">
                                      @foreach($sales as $key => $value)
                                      <?php
                                      // đổi vnd
                                        $gia = $value->km_gia;;
                                        if(strtoupper($value->km_donvi) == 'VND') {
                                            $gia = number_format(preg_replace('/\D/', '',$gia), 0, ',', '.');
                                        }
                                      
                                        ?>
                                         <option value = "{{$value->km_id}}" {{ $value->km_id == $info_sale->km_id ? 'selected' : '' }}>
                                            {{$value->km_mota.' - '.$gia.$value->km_donvi}}
                                        </option>
                                      {{-- <option value = "{{$value->km_id}}">{{$gia.''.$value->km_donvi.' - '.$value->km_mota}}</option> --}}
                                       @endforeach
                                      </select>
                                      <br>
                                      <label for="exampleInputEmail1">Ngày bắt đầu</label>
                                      <input type="date" name="start_date" class="form-control" 
                                      id="exampleInputEmail1" value = "{{$info_sale->ngaybatdau}}">
                                      <br>
                                      <label for="exampleInputEmail1">Ngày kết thúc</label>
                                      <input type="date" name="end_date" class="form-control"
                                       id="exampleInputEmail1" value = "{{$info_sale->ngayketthuc}}">
                                </div>      
                                <button type="submit" name="add_sales" class="btn btn-info">Thiết lập</button>
                            </form>
                            </div>
                         
                            @else
                            <div class="position-center">
                                <form role="form" action="{{route('save-set-sale',['product_id' => $product_id])}}" method="post" >
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Chọn khuyến mãi</label>
                                    <select name="sale_id" class="form-control input-sm m-bot15">
                                      @foreach($sales as $key => $value)
                                      <?php
                                      // đổi vnd
                                        $gia = $value->km_gia;;
                                        if(strtoupper($value->km_donvi) == 'VND') {
                                            $gia = number_format(preg_replace('/\D/', '',$gia), 0, ',', '.');
                                        }
                                      
                                        ?>
                                        
                                         
                                         
                                         <option value = "{{$value->km_id}}">{{$gia.''.$value->km_donvi.' - '.$value->km_mota}}</option>
                                        
                                       @endforeach
                                      </select>
                                      <br>
                                      <label for="exampleInputEmail1">Ngày bắt đầu</label>
                                      <input type="date" name="start_date" class="form-control" 
                                      id="exampleInputEmail1" value="<?php echo date("Y-m-d")?>" >
                                      <br
                                      <label for="exampleInputEmail1">Ngày kết thúc</label>
                                      <input type="date" name="end_date" class="form-control" id="exampleInputEmail1" >
                                </div>
                            {{----}}
                      
                                <button type="submit" name="add_sales" class="btn btn-info">Thiết lập</button>
                            </form>
                            </div>
                            @endif
                        </div>
                    </section>

            </div>
           
@endsection
