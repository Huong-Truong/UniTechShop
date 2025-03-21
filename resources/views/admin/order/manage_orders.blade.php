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
        Liệt kê đơn hàng
    </div>
  <div class="panel-heading1">
    <div class="row w3-res-tb">
      <div class="col-sm-5 m-b-xs">
        {{-- <select class="input-sm form-control w-sm inline v-middle">
          <option value="0">Bulk action</option>
          <option value="1">Delete selected</option>
          <option value="2">Bulk edit</option>
          <option value="3">Export</option>
        </select>
        <button class="btn btn-sm btn-default">Apply</button>                 --}}
      </div>
      <div class="col-sm-4">
      </div>
      <div class="col-sm-3">
        <div class="input-group">
       
          <form  action="{{route('search-order')}}" method="get" class="form-search" >
           
            <input type="text" name="key" class="input-sm form-control" placeholder="Search" >
            <button class="btn btn-sm btn-default " type="submit" >Go!</button>
          </form>
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
            <th>Mã đơn hàng</th>
            <th>Người đặt</th>
            <th>Tổng giá tiền kèm thuế</th>
            <th>Tình trạng</th>
            <th>Ngày tạo</th>
            <th>Chi tiết</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
            <?php 
           
            $i=1;
        ?>
            @foreach($all as $key => $cate_pro)
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td> <a class ="a-black" href="{{route('view-order', ['donhang_id' => $cate_pro->donhang_id])}}">
              <?php
              if($cate_pro->donhang_id< 10) echo 'DH00';
              else if($cate_pro->donhang_id < 100) echo 'DH0'; 
              else echo 'DH';           
            ?>{{$cate_pro->donhang_id}}
            </a>
            </td>
            <td>{{$cate_pro->khachhang_ten}}</td>
            <td>
              <?php
              if((int)$cate_pro->donhang_tongtien != 0){
                $formattedVND = number_format(preg_replace('/\D/', '',$cate_pro->donhang_tongtien), 0, ',', '.') . ' VND';
                echo $formattedVND;
              }
            ?>
            </td>

            <td>
            <form action="{{route('update-status')}}" method="get">
            <div class="form-group">
            <input type="hidden" name="donhang_id" value="{{$cate_pro->donhang_id}}">
              <select name="trangthai_donhang" class="input-sm m-bot15">
                     @foreach ($trangthai as $key=>$value)
                     <option value="{{ $value->trangthai_id }}"
                      {{ $value->trangthai_id < $cate_pro->trangthai_id ? 'disabled' : '' }}
                      {{ $value->trangthai_id == $cate_pro->trangthai_id ? 'selected' : '' }}>
                      {{$value->trangthai_ten}}
                  </option>
                    @endforeach
              </select>
              <input type="submit" class="btn custom-button" name="submit" value="Cập nhật">
            </div>
            </form>
            </td>
            <td>{{$cate_pro->donhang_ngaytao}}</td>
            <td>
              <a href="{{route('view-order', ['donhang_id' => $cate_pro->donhang_id])}}" class="active" ui-toggle-class=""><i class="fa fa-info-circle text-success text-active"></i>  </a>
              {{-- <a onclick="return confirm('Bạn có chắc muốn xóa ?')" class="active"  href="{{route('delete-order', ['donhang_id' => $cate_pro->donhang_id])}}"> <i class="fa fa-times text-danger text"></i></a> --}}
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
