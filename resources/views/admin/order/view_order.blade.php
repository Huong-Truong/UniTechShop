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
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
        Liệt kê chi tiết đơn hàng
    </div>
{{--     
    <div class="row w3-res-tb">
      <div class="col-sm-5 m-b-xs">
        <select class="input-sm form-control w-sm inline v-middle">
          <option value="0">Bulk action</option>
          <option value="1">Delete selected</option>
          <option value="2">Bulk edit</option>
          <option value="3">Export</option>
        </select>
        <button class="btn btn-sm btn-default">Apply</button>                
      </div>
      <div class="col-sm-4">
      </div>
      <div class="col-sm-3">
        <div class="input-group">
          <input type="text" class="input-sm form-control" placeholder="Search">
          <span class="input-group-btn">
            <button class="btn btn-sm btn-default" type="button">Go!</button>
          </span>
        </div>
      </div>
    </div> --}}
    <div class="table-responsive">
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
      
            <th>Mã đơn hàng</th>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Tổng tiền</th>
            <!-- <th>Thao tác</th> -->
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
            <?php 
            $message = Session::get('message'); ## lấy tin nhắn có tên là message
            if($message){
            echo "<span id='messageStyle'> $message </span>" ;
                Session::put('message',null); ## in ra xong set lại null
            }
        ?>
            @foreach($all_details as $key => $cate_pro)
          <tr>
        
            <td>{{$cate_pro->donhang_id}}</td>
            <td>{{$cate_pro->sanpham_ten}}</td>
            <td>{{$cate_pro->sanpham_gia}}</td>
            <td>{{$cate_pro->ctdh_soluong}}</td>
            <td>{{$cate_pro->sanpham_gia*$cate_pro->ctdh_soluong}}</td>
            
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
     
    </footer>
  </div>
</div>


<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
        Liệt kê thông tin người mua và vận chuyển
    </div>
    {{-- <div class="row w3-res-tb">
      <div class="col-sm-5 m-b-xs">
        <select class="input-sm form-control w-sm inline v-middle">
          <option value="0">Bulk action</option>
          <option value="1">Delete selected</option>
          <option value="2">Bulk edit</option>
          <option value="3">Export</option>
        </select>
        <button class="btn btn-sm btn-default">Apply</button>                
      </div>
      <div class="col-sm-4">
      </div>
      <div class="col-sm-3">
        <div class="input-group">
          <input type="text" class="input-sm form-control" placeholder="Search">
          <span class="input-group-btn">
            <button class="btn btn-sm btn-default" type="button">Go!</button>
          </span>
        </div>
      </div>
    </div> --}}
    <div class="table-responsive">
      <table class="table table-striped b-t b-light">
        <thead>
        @foreach($customer as $key => $cate_pro)
          <tr>
            <th>Tên tài khoản người mua</th>
            <td>{{$cate_pro->khachhang_ten}}</td>
            </tr>
            <tr>  <th>Tên người nhận</th>
            <td>{{$cate_pro->vanchuyen_nguoinhan}}</td>
            </tr>
            <tr>
            <th>Số điện thoại</th>
            <td>{{$cate_pro->vanchuyen_sdt}}</td>
            </tr>
            <tr>
            <th>Địa chỉ</th>
            <td>{{$cate_pro->vanchuyen_diachi}}</td>
                </tr>
                <tr>
            <th>Email</th>
            <td>{{$cate_pro->vanchuyen_email}}</td>
                </tr>
                <tr>
                <th>Ghi chú</th>
                <td>{{$cate_pro->vanchuyen_ghichu}}</td>
                </tr>
                <tr>
                <th>Hình thức thanh toán</th>
                <td>{{$cate_pro->pttt_ten}}</td>
                </tr>
                <tr>
                <!-- <th>Trạng thái thanh toán</th>
                <td></td> -->
                </tr>
          
               
    
        </thead>
        <tbody>
           
           
       
        @endforeach
        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
     
    </footer>
  </div>
</div>
           
@endsection
