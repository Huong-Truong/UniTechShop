@extends('admin_layout')
@section('admin-content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
       Danh sách khách hàng
    </div>
    <div class="panel-heading1">
      <div class="row w3-res-tb">
          <div class="col-sm-5 m-b-xs  ">
            
          </div>
        <div class="col-sm-4">
        
        </div>
        <div class="col-sm-3">
         
            
        </div>
      </div>
      </div>
    <div class="table-responsive">
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:20px;">
              <label class="i-checks m-b-none">
                <input type="checkbox"><i></i>
              </label>
            </th>
            <th>STT</th>
            <th>Họ tên</th>
            <th>Số điện thoại</th>
            <th>Email</th>
            <th>Địa chỉ</th>
            <th>Thao tác</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $message = Session::get('message'); ## lấy tin nhắn có tên là message
          if($message){
          echo "<p id='messageStyle'> $message </p>" ;
              Session::put('message',null); ## in ra xong set lại null
          }
          $i = 1;
      ?>
            @foreach($all_customer as $key => $value)
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            
            <td><?php
              echo $i;
               $i++;
               ?>
            </td>
          
            <td>{{$value->khachhang_ten}}</td>
            <td>{{$value->khachhang_sdt}}</td>

            <td>{{$value->khachhang_email}}</td>

            <td>{{$value->khachhang_diachi}}</td>


            <td class = "icon-size">
              <a href="{{route('edit-customer', ['customer_id' => $value->khachhang_id])}}" class="active" ui-toggle-class="">
                <i class="fa fa-pencil-square-o text-success text-active"></i>
              </a>
              <a onclick="return confirm('Bạn có chắc muốn xóa ?')" class="active"  href="{{route('delete-customer', ['customer_id' => $value->khachhang_id])}}">
                 <i class="fa fa-times text-danger text"></i>
                </a>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
     
    </footer>
  </div>
</div>
           
@endsection
