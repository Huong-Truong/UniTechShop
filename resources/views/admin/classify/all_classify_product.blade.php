@extends('admin_layout')
@section('admin-content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
        Liệt kê phân loại
    </div>
    <div class="panel-heading1">
      <div class="row w3-res-tb">
          <div class="col-sm-5 m-b-xs  ">
           
          </div>
        <div class="col-sm-4">
        </div>
        <div class="col-sm-3">
          <form action="{{route('import-classify')}}" method="POST" enctype="multipart/form-data" class="form-search">
            @csrf
    <label for="file-upload" class="custom-file-upload btn">
        Chọn tệp
    </label>
    <input id="file-upload" type="file" name="file" accept=".xlsx" style="display: none;">
    <br>
    <input type="submit" value="import CSV" name="import_classify" class="custom-file-upload">
          </form>
  
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
            <th>Tên phân loại</th>
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
        ?>
            @foreach($all_classify as $key => $pl)
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td>{{$pl->phanloai_ten}}</td>

            <td>
              <a href="{{route('edit-classify', ['classify_id' => $pl->phanloai_id])}}" class="active" ui-toggle-class=""><i class="fa fa-pencil-square-o text-success text-active"></i>  </a>
              <a onclick="return confirm('Bạn có chắc muốn xóa ?')" href="{{route('delete-classify', ['classify_id' => $pl->phanloai_id])}}"> <i class="fa fa-times text-danger text"></i></a>
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
