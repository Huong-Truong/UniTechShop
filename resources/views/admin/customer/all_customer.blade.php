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
       Danh sách khách hàng ({{$count}})
    </div>
    <div class="panel-heading1">
      <div class="row w3-res-tb">
          <div class="col-sm-5 m-b-xs  ">
            <div class="custom-o btn" >
              <br>
              <br>
           
              <form action="{{route('loc-kh')}}" method="GET" enctype="multipart/form-data" class="form-search">
                @csrf
                <div class="btn">
                  <select name="trangthai" class="form-control input-sm m-bot15">
                   <option value="1"  {{ $t == 1 ? 'selected' : '' }}>Lượt mua</option>
                   <option value="2" {{ $t == 2 ? 'selected' : '' }}>Tổng tiền</option> 
                  </select>
              </div>
              <div class="btn">
                <select name="month" class="form-control input-sm m-bot15">
                  <option value="0" {{ $m == 0 ? 'selected' : '' }}>Tất cả</option>
                  @for ($i = 1; $i <= 12; $i++)
                      <option value="{{ $i }}" {{ $i == (int)$m ? 'selected' : '' }}>Tháng {{ $i }}</option>
                  @endfor
              </select>
            </div>
            <div class="btn">
              <select name="year" class="form-control input-sm m-bot15">
               
                <option value="0">Tất cả</option>
                <?php $nam = date('Y');?>
                @for ($i = $nam - 5; $i <= $nam + 5; $i ++)
                <option value="{{$i}}" {{ $i == $y ? 'selected' : '' }} >{{$i}}</option>
                @endfor
            </select>
          </div>
                
                <p id="fileName"></p>
            
                <br>
                <input type="submit" value="Lọc" name="import_hdn" class="custom-file-upload">
              </form>
            <br>
            
          </div>
             
          </div>
        <div class="col-sm-4">
        
        </div>
      
        <div class="col-sm-3">
          <form  action="{{route('search-customer')}}" method="get" class="form-search" >

            <input type="text" name="key" class="input-sm form-control" placeholder="Search" >
            <button class="btn btn-sm btn-default " type="submit" >Go!</button>
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
            <th>Họ tên</th>
            <th>Số điện thoại</th>
            <th>Email</th>
            <th>Sô lần mua hàng</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th>Thao  tác</th>
          
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1;?>
            @foreach($all_customer as $key => $value)
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            
            <td><?php
              echo $i;
               $i++;
               ?>
            </td>
          
            <td>{{$value->khachhang_ten}}</td>
            <td>{{$value->khachhang_sdt}}</td>

            <td>{{$value->khachhang_email}}</td>

            <td>{{$value->total}}</td>
           
            <td> <?php
              if((int)$value->total_amount != 0){
                $formattedVND = number_format(preg_replace('/\D/', '',$value->total_amount), 0, ',', '.') . ' VND';
                echo $formattedVND;
              }
              
            ?></td>
          
              <td><span class="text-ellipsis">
                <?php 
                if ($value->khachhang_trangthai == 0) {
                  //  echo "Đang ẩn  ";
                    echo "<a href=\"" . route('active-customer', ['customer_id' => $value->khachhang_id]) . "\"><span class=\"fa-thumbs-style fa fa-square-o\"></span></a>";
                } else {
                  //  echo "Đang hiển thị   ";
                    echo "<a href=\"" . route('unactive-customer', ['customer_id' => $value->khachhang_id]) . "\"><span class=\"fa-thumbs-style fa fa-check-square-o\"></span></a>";
                }
                ?>
                </span></td>
         

            <td >
              <a href="{{route('edit-customer', ['customer_id' => $value->khachhang_id])}}" class="active" ui-toggle-class="">
                <i class="fa fa-pencil-square-o text-success text-active"></i>
              </a>
                {{-- <a onclick="return confirm('Bạn có chắc muốn xóa ?')" class="active"  href="{{route('delete-customer', ['customer_id' => $value->khachhang_id])}}">
                 <i class="fa fa-times text-danger text"></i>
                </a>   --}}
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
