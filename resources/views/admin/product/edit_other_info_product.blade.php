@extends('admin_layout')
@section('admin-content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                          Hướng dẫn sử dụng
                          
                            {{$product->sanpham_ten}}
                          
                        </header>
                        <?php 
                        $message = Session::get('message'); ## lấy tin nhắn có tên là message
                        if($message){
                        echo "<p id='messageStyle'> $message </p>" ;
                            Session::put('message',null); ## in ra xong set lại null
                        }
                        ?>
                        <div class="panel-body">
                            @foreach ($hdsd as $key => $hdsd)
                            <div class="position-center">
                                <form role="form" action="{{route('update-other-info-product', ['product_id' => $hdsd->sanpham_id])}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mô tả</label>
                                    <input value="{{ $hdsd->HDSD_mota}}"name="hdsd_mota" class="form-control" id="exampleInputEmail1" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Video</label><br>
                                    <iframe width="700" height="400" src="https://www.youtube.com/embed/{{$hdsd->HDSD_video}}" 
                                      frameborder="0" 
                                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                      allowfullscreen></iframe>
                                    <br>
                                    <label for="exampleInputEmail1">ID video</label>
                                    <input value="{{$hdsd->HDSD_video}}"name="hdsd_video" class="form-control" id="exampleInputEmail1" >
                                </div>
                                <button type="submit" name="update_other_info_product" class="btn btn-info">Cập nhật</button>
                            </form>
                            </div>
                            <br><br>
                    
                            @endforeach
                            {{-- Dịch Vụ --}}
                            <header class="panel-heading_1">
                             Bảng giá dịch vụ của {{$product->sanpham_ten}}                       
                            </header>
                      <div class="panel-body">
              
                        <div class="position-center">
                       
                          <form role="form" 
                          action="{{route('save-set-service',['product_id' => $product->sanpham_id])}}" 
                          method="post" enctype="multipart/form-data">
                            @csrf
                            @foreach ($service as $srv) 
                                <div class="form-group">
                                     <label >{{$srv->dv_ten}}</label> 
                                     <input type="hidden" name="dv_id[]" value="{{$srv->dv_id}}">
                                     <?php   $gia = '';
                                             $last_gia = "Chưa thiết lập" ?>
                                     @foreach ($priceSrv as $p) 
                                     <?php 
                                   
                                      if($srv->dv_id == $p->dv_id){
                                        $gia = $p->giadichvu; 
                                      }
                                      if((int)$gia != 0){
                                        $last_gia = number_format((int)$gia, 0, ',', '.') . ' VND';
                                      }
                                     ?>
                                    @endforeach
                                    <input value="{{$last_gia}}"name="giadichvu[]" class="form-control" id="exampleInputEmail1" >
                                </div>
                            @endforeach 
                            <button type="submit" name="update_other_info_product" class="btn btn-info">Cập nhật</button>
                        </form>
                        </div>
                      
                        </div>
                    </section>
                    <section class="panel">
                      
                    
                  </section>

            </div>
           
@endsection
