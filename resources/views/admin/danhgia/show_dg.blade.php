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
        Đánh giá sản phẩm {{$product->sanpham_ten}}
    </div>
    <div class = "panel-heading1">
      <div class="row w3-res-tb ">
        <div class="col-sm-5 m-b-xs">    
            <form class="form-fillter" action="{{route('show-dg', ['product_id' => $product->sanpham_id,'xephang'=> 'all'])}}" method="get">
                <select name="sao" class="input-sm form-control w-sm inline v-middle">
                   
                    <option value="all">Tất cả</option>
                    @for ($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}"  {{ $i == $sao ? 'selected' : '' }}>
                            @for ($j = $i; $j >= 1; $j--)
                                ★
                            @endfor
                        </option>
                    @endfor
                </select>
                <button class="btn btn-sm btn-default">Lọc</button>
            </form>
        </div>
        <div class="col-sm-4">
        </div>
        <div class="col-sm-3">
          {{-- <div class="input-group">
            <a  class="custom-button" href="{{ route('add-sales')}}">Thêm khuyến mãi</a> 
          </div> --}}
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
            <th>Tên khách hàng</th>
            <th>Xếp hạng</th>
            <th>Nội dung</th>
            <th>Thời gian</th>
            <th>Thao tác</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          
        <?php $i=1;?>
            @foreach($dg as $key => $value)
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td>
              <?php
             echo $i;
              $i++;
              ?>
             </td>
           
            <?php
            $gia = $value->km_gia;;
            if(strtoupper($value->km_donvi) == 'VND') {
                $gia = number_format(preg_replace('/\D/', '',$gia), 0, ',', '.');
            }
            ?>
            <td>{{$value->khachhang_ten}}  </td>
            <td>
            <?php
            $n = $value->dg_xephang; // Số lần lặp lại
            for ($i = 0; $i < $n; $i++) { 
            ?>
                <i class="fa fa-star"></i>

            <?php
            }
            ?>
           </td>
            <td>{{$value->dg_noidung}}</td>
            <td>{{$value->dg_ngay}}</td>
          

            <td>
                <div class="input-group">
                    <a onclick="return confirm('Bạn có chắc muốn xóa ?')" class=" custom-button"  id="deleteProductBtn" 
                    href="{{route('delete-dg', ['dg_id' => $value->dg_id])}} " class="active" ui-toggle-class=""> 
                       Xóa
                      </a>
                  </div>
               
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
