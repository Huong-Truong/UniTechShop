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
        Thông tin 
          {{$kho->kho_ten}}
       
    </div>
    <div class="panel-heading1">
    <div class="row w3-res-tb">
        <div class="col-sm-5 m-b-xs ">
          <form class="form-fillter" action="{{route('fill-kho')}}" method="get">
            
            <select  name="kho" class="input-sm form-control w-sm inline v-middle ">
              <option value="0">Tất cả</option>
              @foreach ($storage as $key => $value )
            
              <option value = "{{$value->kho_id}}" {{ $value->kho_id == $kho->kho_id ? 'selected' : '' }}>
                {{$value->kho_ten}}
             </option>
            
        
              @endforeach
            </select>
            <button class="btn btn-sm btn-default">
              Vào
            </button>   
            
          </form>
          @if ($kho->kho_id != 0)
          <button class="btn btn-sm btn-default">
            <a  href="{{route('nhapkho',['kho_id' => $kho->kho_id])}}">Nhập kho</a> 
           </button>
<<<<<<< HEAD
          @endif
          
=======

         
>>>>>>> 64fd946b7690df810e98decf4a8eeb40bfec6773
         
        </div>
      <div class="col-sm-4">
      </div>
      <div class="col-sm-3">
        {{-- <div class="input-group"> --}}
          <form  action="{{route('search-kho')}}" method="get" class="form-search" >
            <input type="hidden" name="id_kho" value="{{$kho->kho_id}}">
            <input type="text" name="key" class="input-sm form-control" placeholder="Search" >
            <button class="btn btn-sm btn-default " type="submit" >Go!</button>
          </form>
        
       
         
        {{-- </div> --}}
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
            <th>STT</th>
            <th>Tên sản phẩm</th>
            <th>Số lượng tồn</th>
            @if ($kho->kho_id!=0)
            <th>Thao tác</th>
            @endif
            
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1?>
            @foreach ($store as $key => $value )

            <tr>
                <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                <td>
                  <?php
    
                 echo $i;
                  $i++;
                  ?>
                 </td>
               

                 <td> {{$value->sanpham_ten}}  </td> 
                <td>{{$value->tonkho_soluong}}</td>
    
                <td>
                  @if ($kho->kho_id!=0)
                  <a onclick="return confirm('Bạn có chắc muốn xóa 1 sản phẩm trong kho ?')" class="active" 
                  href="{{route('delete-store',['sanpham_id' => $value->sanpham_id,'kho_id' => $kho->kho_id])}}"> 
                  <i class="fa fa-times text-danger text"></i>
                </a> 
                  @endif
                 
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
