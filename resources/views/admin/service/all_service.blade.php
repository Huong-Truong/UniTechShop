@extends('admin_layout')
@section('admin-content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
       Dịch vụ
    </div>
    <div class = "panel-heading1">
      <div class="row w3-res-tb ">
        <div class="col-sm-5 m-b-xs">    
              
        </div>
        <div class="col-sm-4">
        </div>
        <div class="col-sm-3">
          <div class="input-group">
            <a  class="custom-button" href="{{ route('add-service')}}">Thêm dịch vụ</a> 
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
            <th>Tên dịch vụ</th>
            <th>Thao tác</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1; ?>
            @foreach($all_service as $key => $value)
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td>
              <?php
             echo $i;
              $i++;
              ?>
             </td>
            <td>{{$value->dv_ten}}</td>
            <td>
               <a onclick="return confirm('Bạn có chắc muốn xóa ?')" href="{{route('delete-service', ['service_id' => $value->dv_id])}}"> <i class="fa fa-times text-danger text"></i></a> 
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
