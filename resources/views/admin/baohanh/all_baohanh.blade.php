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
       Các chương trình bảo hành có trong hệ thống
    </div>
    <div class = "panel-heading1">
      <div class="row w3-res-tb ">
        <div class="col-sm-5 m-b-xs">    
              
        </div>
        <div class="col-sm-4">
        </div>
        <div class="col-sm-3">
          <div class="input-group">
            <a  class="custom-button" href="{{ route('add-baohanh')}}">Thêm chương trình bảo hành</a> 
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
            <th>Thời gian bảo hành</th>
            <th>Mô tả</th>
            <th>Xóa</th>
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
            @foreach($all_baohanh as $key => $value)
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td>
              <?php
             echo $i;
              $i++;
              ?>
             </td>
           
           
            <td>{{$value->baohanh_thoigian}}  </td>
            <td>{{$value->baohanh_mota}}</td>

            <td>
               <a onclick="return confirm('Bạn có chắc muốn xóa ?')" class="active"  href="{{route('delete-baohanh', ['baohanh_id' => $value->baohanh_id])}}"> <i class="fa fa-times text-danger text"></i></a> 
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
