@extends('admin_layout')
@section('admin-content')
<div class="row">
            <div class="col-lg-12">
                <section class="panel ">
                    <header class="panel-heading">
                        Thư viện ảnh của sản phẩm
                    </header>
                        <?php 
                            $message = Session::get('message'); ## lấy tin nhắn có tên là message
                            if($message){
                            echo "<p id='messageStyle'> $message </p>" ;
                                Session::put('message',null); ## in ra xong set lại null
                            }
                        ?>
                        <br>
                        <form action="{{route('insert-gallery',['product_id' => $pro_id] )}}"
                             method="post" enctype="multipart/form-data">
                             @csrf
                            <div class="row">

                                <div class="col-md-3">
                                </div>
                                <div class="col-md-6">
                                    <input type="file" class = "form-control" name = "file[]" accept="image/*" id="file" multiple>
                                    <span id="error_gallery"></span>
                                </div>
                                <div class="col-md-3">
                                    <input type="submit" name="upload taianh" class = "custom-button" value ="Tải" >
                                </div>

                            </div>
                        </form>
                        <div class="panel-body">
                           <input type="hidden" value="{{$pro_id}}" name = "pro_id" class = "pro_id">
                           <form >
                                @csrf
                            <div id="gallery_load">

                               </div>
    
                           </form>
                          
                        </div>
                </section>

            </div>
           
@endsection
