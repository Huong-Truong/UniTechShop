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
        Liệt kê sản phẩm
        
    </div>
    <div class="panel-heading1">
    <div class="row w3-res-tb">
        <div class="col-sm-5 m-b-xs ">
          <form class="form-fillter" action="{{route('fill-by-cate')}}" method="get">
            <select  name="category" class="input-sm form-control w-sm inline v-middle ">
              <option value="all">Danh mục</option>
              @foreach ($category as $key => $cate )
              <option value="{{$cate->danhmuc_id}}">{{$cate->danhmuc_ten}}</option>
              @endforeach
            </select>
            <button class="btn btn-sm btn-default">
             Apply
            </button>   
          </form>
          
          <form class="form-fillter" action="{{route('fill-by-brand')}}" method="get">
          <select name="brand"  class="input-sm form-control w-sm inline v-middle">
            <option value="all">Thương hiệu</option>
            @foreach ($brand as $key => $br )
            <option value="{{$br->hang_id}}">{{$br->hang_ten}}</option>
            @endforeach
          </select>
          <button class="btn btn-sm btn-default">
            Apply
          </button>
          </form>
        </div>
      <div class="col-sm-4">
        <form  action="{{route('search-product')}}" method="get" class="form-search" >
          <input type="text" name="key" class="input-sm form-control" placeholder="Search" >
          <button class="btn btn-sm btn-default " type="submit" >Go!</button>
        </form>
        <br>
       
      </div>
      <div class="col-sm-3">
          <form action="{{route('import-product')}}" method="POST" enctype="multipart/form-data" class="form-search">
            @csrf
            <label class="btn btn-sm btn-default" >
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
              <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
                <li><a href="/download-product"><i class="fa fa-download"></i> Lấy mẫu csv</a></li>
                <li><a href="/export-product"><i class="fa fa-download"></i> Export csv</a></li>
            </ul>
          </label>
          <label class="btn btn-sm btn-default" >
            Chọn file
            <input  type="file" name="fileToUpload" id="fileToUpload"  accept=".csv" style="display: none;">
            
          </label>

          <p id="fileName"></p>
  
          <script>
              document.getElementById('fileToUpload').addEventListener('change', function(event) {
                  var fileName = event.target.files[0].name;
                  document.getElementById('fileName').textContent = fileName;
              });
          </script>
         
          <input type="submit" value="import CSV" name="import_product" class="btn btn-sm btn-default">
          </form>
        
          <br>
      
      </div>
    </div>
    </div>
    <div class="table-responsive">
      <table class="table table-striped b-t b-light table-striped1">
        <thead>
        
          <tr>
            <th style="width:20px;">
              <label class="i-checks m-b-none">
                <input type="checkbox"><i></i>
              </label>
            </th>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Hình ảnh</th>
            <th>Danh mục</th>
            <th>Thương hiệu</th>
            <th>Hiển thị</th>
            <th>Thư viện</th>
         
            <th>Thao tác</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
      

          @foreach($all as $key => $pro)
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td>{{$pro->sanpham_ten}}</td>

            <td>
              <?php
              if((int)$pro->sanpham_gia != 0){
                $formattedVND = number_format(preg_replace('/\D/', '',$pro->sanpham_gia), 0, ',', '.') . ' VND';
                echo $formattedVND;
              }
              
            ?>
            </td>
            {{-- <td><img src="{{asset('img/sp'.$pro->sanpham_id.'/'.$pro->sanpham_hinhanh)}}" height="100" width="100" alt="Lỗi ảnh"></td> --}}
            <td><img class = "img-show"src="{{asset('img/sp'.$pro->sanpham_id.'/'.$pro->sanpham_hinhanh)}}" height="100" width="100" alt="Chưa có ảnh"></td>
            <td>{{$pro->danhmuc_ten}}</td>
            <td>{{$pro->hang_ten}}</td>
            <td><span class="text-ellipsis">
            <?php 
            if ($pro->sanpham_trangthai == 0) {
                echo "<a href=\"" . route('active-product', ['product_id' => $pro->sanpham_id]) . "\"><span class=\"fa-thumbs-style fa fa-square-o\"></span></a>";
            } else {
                echo "<a href=\"" . route('unactive-product', ['product_id' => $pro->sanpham_id]) . "\"><span class=\"fa-thumbs-style fa fa-check-square-o\"></span></a>";
            }
            ?>


            </span></td>
            <td> 
               
              
              
                <a  class="custom-button" href="{{ route('add-gallery', ['product_id' => $pro->sanpham_id])}}">Xem</a>
              
          
            </td>
           
            <td>
              <a href="{{route('edit-product', ['product_id' => $pro->sanpham_id])}}" class="active" ui-toggle-class="">
                <i class="fa fa-pencil-square-o text-success text-active"></i> 
               </a>
              <a onclick="return confirm('Bạn có chắc muốn xóa ?')" class="active"  id="deleteProductBtn" href="{{route('delete-product', ['product_id' => $pro->sanpham_id])}} " class="active" ui-toggle-class=""> 
                <i class="fa fa-times text-danger text"></i>
              </a>
              <a href="{{route('edit-other-info-product', ['product_id' => $pro->sanpham_id])}}" class="active" ui-toggle-class="">
                <i class="fa fa-info-circle text-danger text"></i> 
              </a>
              <a href="{{route('set-sale', ['product_id' => $pro->sanpham_id])}}" class="active" ui-toggle-class="">
                <i class="fa fa-solid fa-ticket"></i>
              </a>
              <a href="{{route('show-dg', ['product_id' => $pro->sanpham_id,'xephang'=> 'all'])}}" class="active" ui-toggle-class="">
                <i class="fa fa-comment"></i>
              </a>
             
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
