@extends('admin_layout')
@section('admin-content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
       Chi tiết của hóa đơn nhập 
          {{$hdn_id}}
        
    </div>
    <div class="panel-heading1">
    <div class="row w3-res-tb">
        <div class="col-sm-5 m-b-xs ">
          
           
       
         
        </div>
      <div class="col-sm-4">
      </div>
      <div class="col-sm-3">
        {{-- <div class="input-group"> --}}
          {{-- <form  action="{{route('search-kho')}}" method="get" class="form-search" >
            <input type="hidden" name="id_kho" value="{{$kho->kho_id}}">
            <input type="text" name="key" class="input-sm form-control" placeholder="Search" >
            <button class="btn btn-sm btn-default " type="submit" >Go!</button>
          </form> --}}
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
            <th>Đơn giá</th>
            <th>Số lượng</th>
            <th>Tổng tiền</th>
            

            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
       <?php $i = 1?>
             @foreach ($chitiet as $key => $value )
           
            <tr>
                  <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                  <td>
                    <?php
                   echo $i;
                   $i++;
                    ?>
                   </td>

                   <td> {{$value->sanpham_ten}}</td> 
                 
                   <td>
                    <?php
                 $formattedVND = number_format(preg_replace('/\D/', '',$value->dongia), 0, ',', '.') . ' VND';
                 echo $formattedVND;
                     ?>
                </td> 

                   <td> {{$value->hdn_soluong}}</td> 

                   <td> 
                    
                    <?php
                    $tongtien = $value->dongia*$value->hdn_soluong;
                    $formattedVND = number_format(preg_replace('/\D/', '',$tongtien ), 0, ',', '.') . ' VND';
                    echo $formattedVND;
                        ?>
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
