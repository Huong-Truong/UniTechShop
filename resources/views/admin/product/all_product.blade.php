@extends('admin_layout')
@section('admin-content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
        Liệt kê sản phẩm
    </div>
    <div class="panel-heading1">
    <div class="row w3-res-tb">
      <div class="col-sm-5 m-b-xs ">
        <select class="input-sm form-control w-sm inline v-middle">
          <option value="0">Bulk action</option>
          <option value="1">Delete selected</option>
          <option value="2">Bulk edit</option>
          <option value="3">Export</option>
        </select>
        <button class="btn btn-sm btn-default">Apply</button>                
      </div>
      <div class="col-sm-4">
      </div>
      <div class="col-sm-3">
        <div class="input-group">
          <input type="text" class="input-sm form-control" placeholder="Search">
          <span class="input-group-btn">
            <button class="btn btn-sm btn-default" type="button">Go!</button>
          </span>
        </div>
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
          <?php 
          $message = Session::get('message'); ## lấy tin nhắn có tên là message
          if($message){
          echo "<p id='messageStyle'> $message </p>" ;
              Session::put('message',null); ## in ra xong set lại null
          }
      ?>
        @foreach($all as $key => $pro)
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td>{{$pro->sanpham_ten}}</td>
           
            <td>
              <?php
          echo  $formattedVND = number_format(preg_replace('/\D/', '',$pro->sanpham_gia), 0, ',', '.') . ' VND';
            ?>
            </td>
            {{-- <td><img src="{{asset('img/sp'.$pro->sanpham_id.'/'.$pro->sanpham_hinhanh)}}" height="100" width="100" alt="Lỗi ảnh"></td> --}}
            <td><img src="{{asset('img/sp'.$pro->sanpham_id.'/'.$pro->sanpham_hinhanh)}}" height="100" width="100" alt="Lỗi ảnh"></td>
            <td>{{$pro->danhmuc_ten}}</td>
            <td>{{$pro->hang_ten}}</td>
            <td><span class="text-ellipsis">
            <?php 
            if ($pro->sanpham_trangthai == 0) {
                echo "<a href=\"" . route('active-product', ['product_id' => $pro->sanpham_id]) . "\"><span class=\"fa-thumbs-style fa fa-thumbs-down\"></span></a>";
            } else {
                echo "<a href=\"" . route('unactive-product', ['product_id' => $pro->sanpham_id]) . "\"><span class=\"fa-thumbs-style fa fa-thumbs-up\"></span></a>";
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
              <a onclick="return confirm('Bạn có chắc muốn xóa ?')" href="{{route('delete-product', ['product_id' => $pro->sanpham_id])}} " class="active" ui-toggle-class=""> 
                <i class="fa fa-times text-danger text"></i>
              </a>
              <a href="{{route('edit-other-info-product', ['product_id' => $pro->sanpham_id])}}" class="active" ui-toggle-class="">
                <i class="fa fa-info-circle text-danger text"></i> 
              </a>
              <a href="{{route('set-sale', ['product_id' => $pro->sanpham_id])}}" class="active" ui-toggle-class="">
                <i class="fa fa-solid fa-ticket"></i>
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
