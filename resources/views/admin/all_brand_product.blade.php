@extends('admin_layout')
@section('admin-content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
        Liệt kê thương hiệu
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
            <th>Tên danh mục</th>
            <th>Mô tả</th>
            <th>Hiển thị</th>
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
            @foreach($all_brand as $key => $brand)
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td>{{$brand->hang_ten}}</td>
            <td>{{$brand->hang_mota}}</td>
            <td><span class="text-ellipsis">
            <?php 
            if ($brand->hang_trangthai == 0) {
              //  echo "Đang ẩn  ";
                echo "<a href=\"" . route('active-brand', ['brand_id' => $brand->hang_id]) . "\"><span class=\"fa-thumbs-style fa fa-thumbs-down\"></span></a>";
            } else {
              //  echo "Đang hiển thị   ";
                echo "<a href=\"" . route('unactive-brand', ['brand_id' => $brand->hang_id]) . "\"><span class=\"fa-thumbs-style fa fa-thumbs-up\"></span></a>";
            }
            ?>


            </span></td>

            <td>
              <a href="{{route('edit-brand', ['brand_id' => $brand->hang_id])}}" class="active" ui-toggle-class=""><i class="fa fa-pencil-square-o text-success text-active"></i>  </a>
              <a onclick="return confirm('Bạn có chắc muốn xóa ?')" href="{{route('delete-brand', ['brand_id' => $brand->hang_id])}}"> <i class="fa fa-times text-danger text"></i></a>
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
