@extends('admin_layout')
@section('admin-content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
       Chương trình khuyến mãi
    </div>
    <div class = "panel-heading1">
      <div class="row w3-res-tb ">
        <div class="col-sm-5 m-b-xs">    
              
        </div>
        <div class="col-sm-4">
        </div>
        <div class="col-sm-3">
          <div class="input-group">
            <a  class="custom-button" href="{{ route('add-sales')}}">Thêm khuyến mãi</a> 
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
            <th>Mô tả</th>
            <th>Khuyến mãi</th>
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
            @foreach($all_sales as $key => $value)
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td>{{$value->km_mota}}</td>
            <?php
            $gia = $value->km_gia;;
            if(strtoupper($value->km_donvi) == 'VND') {
                $gia = number_format(preg_replace('/\D/', '',$gia), 0, ',', '.');
            }
            ?>
            <td>{{$gia}} {{$value->km_donvi}}  </td>
           

            <td>
               <a onclick="return confirm('Bạn có chắc muốn xóa ?')" href="{{route('delete-sales', ['sale_id' => $value->km_id])}}"> <i class="fa fa-times text-danger text"></i></a> 
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
