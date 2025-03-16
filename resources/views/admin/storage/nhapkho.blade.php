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
        Hóa đơn nhập hàng
          {{$kho->kho_ten}}
        
    </div>
    <div class="panel-heading1">
    <div class="row w3-res-tb">
        <div class="col-sm-5 m-b-xs ">
          
            {{-- <select  name="kho" class="input-sm form-control w-sm inline v-middle ">
              @foreach ($ncungcap as $key => $value )
              <option value = "{{$value->nhacungcap_id}}">{{$value->nhacungcap_ten}}</option>
              @endforeach
            </select> --}}
            {{-- <label class="btn" >Tạo hóa đơn nhập</label> --}}
            <div class="custom-o btn" >
              Tạo hóa đơn nhập mới
              <br>
              <br>
           
              <form action="{{ route('import-hdn', ['kho_id' => $kho->kho_id]) }}" method="POST" enctype="multipart/form-data" class="form-search">
                @csrf
            
                <label class="custom-file-upload btn">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu extended logout">
                        <li><a href="/download-hdn"><i class="fa fa-download"></i> Lấy mẫu</a></li>
                    </ul>
                </label>
            
                <label class="btn">
                    <select name="nhacungcap" class="form-control input-sm m-bot15">
                        @foreach ($ncungcap as $key => $value)
                            <option value="{{ $value->nhacungcap_id }}">{{ $value->nhacungcap_ten }}</option>
                        @endforeach
                    </select>
                </label>
            
                <label class="custom-file-upload btn">
                    Chọn file
                    <input type="file" name="fileToUpload" id="fileToUpload" accept=".csv" style="display: none;">
                </label>
            
                <p id="fileName"></p>
            
                <script>
                    document.getElementById('fileToUpload').addEventListener('change', function(event) {
                        var fileName = event.target.files[0].name;
                        document.getElementById('fileName').textContent = fileName;
                    });
                </script>
                <br>
                <input type="submit" value="Tạo" name="import_hdn" class="custom-file-upload">
            </form>
            <?php 
          $message = Session::get('message'); ## lấy tin nhắn có tên là message
          if($message){
          echo "<p > $message </p>" ;
              Session::put('message',null); ## in ra xong set lại null
          }
      ?>
            <br>
            
          </div>
             
             
       
         
        </div>
      <div class="col-sm-4">
      </div>
      <div class="col-sm-3">
    
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
            <th>Mã hóa đơn nhập</th>
            <th>Nhà cung cấp</th>
            <th>Ngày lập</th>
            <th>Tổng tiền</th>
            <th>Chi tiết</th>
            

            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
       <?php $i = 1?>
             @foreach ($hdn as $key => $value )
           
            <tr>
                  <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                  <td>
                    <?php
                   echo $i;
                   $i++;
                    ?>
                   </td>

                   <td> {{$value->hdn_id}}</td> 

                   <td> {{$value->nhacungcap_ten}}</td> 
                 
                   <td> {{$value->hdn_ngay}}</td> 

                   <td> 
                    <?php
                    $formattedVND = number_format(preg_replace('/\D/', '',$value->hdn_tongtien), 0, ',', '.') . ' VND';
                    echo $formattedVND;
                      ?>
                    </td> 
                   <td>
                      <a  class="custom-button" href="{{ route('chitiet-hdn', ['hdn_id' => $value->hdn_id])}}">Xem</a>
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
