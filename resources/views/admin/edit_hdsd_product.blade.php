@extends('admin_layout')
@section('admin-content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                          Hướng dẫn sử dụng
                          @foreach ($product as $key => $pro)
                            {{$pro->sanpham_ten}}
                          @endforeach
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
                                <form role="form" action="{{route('update-hdsd-product', ['product_id' => $hdsd->sanpham_id])}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mô tả</label>
                                    <input value="{{ $hdsd->HDSD_mota}}"name="hdsd_mota" class="form-control" id="exampleInputEmail1" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Video</label><br>

                                      <video width="640" height="360" controls>
                                        <source src="{{$hdsd->HDSD_video}}" type="video/mp4">
                                        <source src="{{ $hdsd->HDSD_video}}" type="video/ogg">
                                        <source src="{{ $hdsd->HDSD_video}}" type="video/webm">
                                        Trình duyệt của bạn không hỗ trợ thẻ video.
                                    </video>

                                    <label class="custom-file-upload">
                                        <input type="file" id="exampleInputAddVideo" name="hdsd_video" accept="video/*"/>
                                      </label>

                                </div>
                                <button type="submit" name="update_hdsd_product" class="btn btn-info">Cập nhật</button>
                            </form>
                            </div>
                            @endforeach
                        </div>
                    </section>

            </div>
           
@endsection
