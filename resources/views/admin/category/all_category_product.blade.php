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
        Liệt kê danh mục sản phẩm ({{$count}})
    </div>
    <div class="panel-heading1">
      <div class="row w3-res-tb">
          <div class="col-sm-5 m-b-xs  ">
            
          </div>
        <div class="col-sm-4">
        
        </div>
        <div class="col-sm-3">
          <form action="{{route('import-category')}}" method="POST" enctype="multipart/form-data" class="form-search">
            @csrf
            <label class="custom-file-upload btn" >
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
              <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
                <li><a href="/download-cate"><i class="fa fa-download"></i> Lấy mẫu csv</a></li>
                <li><a href="/export-category"><i class="fa fa-download"></i> Export csv</a></li>
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
          <input type="submit" value="import CSV" name="import_category" class="custom-file-upload">
          </form>
           
        
        </div>
      </div>
      </div>
    <div class="table-responsive">
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            
            <th>STT</th>
             
            <th>Mã</th>
            <th>Tên danh mục</th>
            <th>Phân loại</th>
            <th>Hiển thị</th>
            <th>Thao tác</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
            <?php 
           
            $i = 1;
        ?>
            @foreach($all_category as $key => $cate)
          <tr>
           
            
            <td><?php
              echo $i;
               $i++;
               ?>
            </td>
            <td><?php
              if($cate->danhmuc_id < 10) echo 'DM00';
              else if($cate->danhmuc_id < 100) echo 'DM0'; 
              else echo 'DM';           
            ?>{{$cate->danhmuc_id}}</td>
            <td>{{$cate->danhmuc_ten}}</td>
            <td>{{$cate->phanloai_ten}}</td>
            <td><span class="text-ellipsis">
            <?php 
            if ($cate->danhmuc_trangthai == 0) {
              //  echo "Đang ẩn  ";
                echo "<a href=\"" . route('active-category', ['category_id' => $cate->danhmuc_id]) . "\"><span class=\"fa-thumbs-style fa fa-square-o\"></span></a>";
            } else {
               // echo "Đang hiển thị   ";
                echo "<a href=\"" . route('unactive-category', ['category_id' => $cate->danhmuc_id]) . "\"><span class=\"fa-thumbs-style fa fa-check-square-o\"></span></a>";
            }
            ?>
            </span></td>

            <td>
              <a href="{{route('edit-category', ['category_id' => $cate->danhmuc_id])}}" class="active" ui-toggle-class=""><i class="fa fa-pencil-square-o text-success text-active"></i>  </a>
              <a onclick="return confirm('Bạn có chắc muốn xóa ?')" class="active"  href="{{route('delete-category', ['category_id' => $cate->danhmuc_id])}}"> <i class="fa fa-times text-danger text"></i></a>
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
