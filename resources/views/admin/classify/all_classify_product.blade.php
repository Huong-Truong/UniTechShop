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
        Liệt kê phân loại ({{$count}})
    </div>
    <div class="panel-heading1">
      <div class="row w3-res-tb">
          <div class="col-sm-5 m-b-xs  ">
            
          </div>
        <div class="col-sm-4">
        
        </div>
        <div class="col-sm-3">
          <form action="{{route('import-classify')}}" method="POST" enctype="multipart/form-data" class="form-search">
            @csrf
            <label class="custom-file-upload btn" >
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
              <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
                <li><a href="/download-classify"><i class="fa fa-download"></i> Lấy mẫu </a></li>
                <li><a href="/export-classify"><i class="fa fa-download"></i> Export csv</a></li>
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
          <input type="submit" value="import CSV" name="import_classify" class="custom-file-upload">
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
            <th>Tên phân loại</th>
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
          $i = 1;
      ?>
            @foreach($all_classify as $key => $pl)
          <tr>
          
            
            <td><?php
              echo $i;
               $i++;
               ?>
            </td>
            <td><?php
              if($pl->phanloai_id < 10) echo 'PL00';
              else if($pl->phanloai_id < 100) echo 'PL0'; 
              else echo 'PL';           
            ?>{{$pl->phanloai_id}}</td>
            <td>{{$pl->phanloai_ten}}</td>

            <td>
              <a href="{{route('edit-classify', ['classify_id' => $pl->phanloai_id])}}" class="active" ui-toggle-class=""><i class="fa fa-pencil-square-o text-success text-active"></i>  </a>
              <a onclick="return confirm('Bạn có chắc muốn xóa ?')" class="active"  href="{{route('delete-classify', ['classify_id' => $pl->phanloai_id])}}"> <i class="fa fa-times text-danger text"></i></a>
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
