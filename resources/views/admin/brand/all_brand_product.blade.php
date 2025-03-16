@extends('admin_layout')
@section('admin-content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
        Liệt kê thương hiệu
    </div>
    <div class="panel-heading1">
      <div class="row w3-res-tb">
          <div class="col-sm-5 m-b-xs  ">
            
          </div>
        <div class="col-sm-4">
        
        </div>
        <div class="col-sm-3">
          <form action="{{route('import-brand')}}" method="POST" enctype="multipart/form-data" class="form-search">
            @csrf
            <label class="custom-file-upload btn" >
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
              <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
                <li><a href="/download-brand"><i class="fa fa-download"></i> Lấy mẫu csv</a></li>
                <li><a href="/export-brand"><i class="fa fa-download"></i> Export csv</a></li>
            </ul>
          </label>
          <label class="custom-file-upload btn" >
            Chọn file
            <input  type="file" name="fileToUpload" id="fileToUpload" accept=".csv" style="display: none;">
            
          </label>

          <p id="fileName"></p>

          <script>
              document.getElementById('fileToUpload').addEventListener('change', function(event) {
                  var fileName = event.target.files[0].name;
                  document.getElementById('fileName').textContent = fileName;
              });
          </script>
          <br>
          <input type="submit" value="import CSV" name="import_brand" class="custom-file-upload">
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
            <th>STT</th>
            <th>Tên thương hiệu</th>
            <th>Hinh ảnh</th>
            <th>Mô tả</th>
            <th>Hiển thị</th>
            <th>Thao tác</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
        <?php $i = 1?>
            @foreach($all_brand as $key => $brand)
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            
            <td><?php
              echo $i;
               $i++;
               ?>
            </td>
          
            <td>{{$brand->hang_ten}}</td>
            <td><img class="img_edit image-show" src="{{asset('img/brand/'.$brand->hang_hinhanh)}}" height="150" width="150" alt=""></td>
            <td>{{$brand->hang_mota}}</td>

            <td><span class="text-ellipsis">
            <?php 
            if ($brand->hang_trangthai == 0) {
              //  echo "Đang ẩn  ";
                echo "<a href=\"" . route('active-brand', ['brand_id' => $brand->hang_id]) . "\"><span class=\"fa-thumbs-style fa fa-square-o\"></span></a>";
            } else {
              //  echo "Đang hiển thị   ";
                echo "<a href=\"" . route('unactive-brand', ['brand_id' => $brand->hang_id]) . "\"><span class=\"fa-thumbs-style fa fa-check-square-o\"></span></a>";
            }
            ?>


            </span></td>

            <td>
              <a href="{{route('edit-brand', ['brand_id' => $brand->hang_id])}}" class="active" ui-toggle-class=""><i class="fa fa-pencil-square-o text-success text-active"></i>  </a>
              <a onclick="return confirm('Bạn có chắc muốn xóa ?')" class="active"  href="{{route('delete-brand', ['brand_id' => $brand->hang_id])}}"> <i class="fa fa-times text-danger text"></i></a>
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
