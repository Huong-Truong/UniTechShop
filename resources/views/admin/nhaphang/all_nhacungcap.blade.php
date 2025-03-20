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
       Quản lý nhà cung cấp
    </div>

    <div class = "panel-heading1">
      <div class="row w3-res-tb ">
        <div class="col-sm-5 m-b-xs">    
              
        </div>
        <div class="col-sm-4">
        </div>
        <div class="col-sm-3">
          <div class="input-group">
            <a  class="custom-button" href="{{ route('add-nhacungcap')}}">Thêm nhà cung cấp mới</a> 
          </div>
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
            <th>Tên nhà cung cấp</th>
            <th>Số điện thoại</th>
            <th>Email</th>
            <th>Địa chỉ</th>
            <th>Thao tác</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
            {{-- <?php 
            $message = Session::get('message'); ## lấy tin nhắn có tên là message
            if($message){
            echo "<p id='messageStyle'> $message </p>" ;
                Session::put('message',null); ## in ra xong set lại null
            }
        ?> --}}
        <?php $i=1;?>
            @foreach($all_nhacungcap as $key => $value)
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td>
              <?php
             echo $i;
              $i++;
              ?>
             </td>
           
            <td>{{$value->nhacungcap_ten}} </td>
            <td>{{$value->nhacungcap_sdt}} </td>
            <td>{{$value->nhacungcap_email}} </td>
            <td>{{$value->nhacungcap_diachi}} </td>

            <td>
                <a href="{{route('edit-nhacungcap', ['nhacungcap_id' => $value->nhacungcap_id])}}" class="active" ui-toggle-class=""><i class="fa fa-pencil-square-o text-success text-active"></i>  </a>
               <a onclick="return confirm('Bạn có chắc muốn xóa ?')" href="{{route('delete-nhacungcap', ['nhacungcap_id' => $value->nhacungcap_id])}}"> 
                <i class="fa fa-times text-danger text"></i></a> 
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
