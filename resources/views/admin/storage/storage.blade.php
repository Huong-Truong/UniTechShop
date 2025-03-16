@extends('admin_layout')
@section('admin-content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
        Thông tin @if ($kho->kho_ten)
          {{$kho->kho_ten}}
        @endif
    </div>
    <div class="panel-heading1">
    <div class="row w3-res-tb">
        <div class="col-sm-5 m-b-xs ">
          <form class="form-fillter" action="{{route('fill-kho')}}" method="get">
            <select  name="kho" class="input-sm form-control w-sm inline v-middle ">
              @foreach ($storage as $key => $value )
              @if ($kho->kho_id)
              <option value = "{{$value->kho_id}}" {{ $value->kho_id == $kho->kho_id ? 'selected' : '' }}>
                {{$value->kho_ten}}
             </option>
             @else
             <option value = "{{$value->kho_id}}" >
              {{$value->kho_ten}}
            </option>
             @endif
              @endforeach
            </select>
            <button class="btn btn-sm btn-default">
              Vào
            </button>   
            
          </form>
          <button class="btn btn-sm btn-default">
            <a  href="{{route('nhapkho',['kho_id' => $kho->kho_id])}}">Nhập kho</a> 
           </button>
         
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
            <th>Số lượng</th>
            <th>Thao tác</th>
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
                   <a onclick="return confirm('Bạn có chắc muốn xóa ?')" class="active" 
                    href="{{route('delete-store',['sanpham_id' => $value->sanpham_id,'kho_id' => $value->kho_id])}}"> 
                    <i class="fa fa-times text-danger text"></i>
                  </a> 
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
