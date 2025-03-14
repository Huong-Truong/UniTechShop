@extends('layout')
@section('content')




    <!-- Shop Detail Start -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 pb-5">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner border">
                        <div class="carousel-item active">
                            <img class="w-100 h-100" src="{{ asset('img/sp' . $sanpham->sanpham_id . '/' . $sanpham->sanpham_hinhanh) }}" alt="Image">
                        </div>
                        @foreach ($hinhanh as $v_hinhanh)
                        <div class="carousel-item">
                            <img class="w-100 h-100" src="{{ asset('img/sp' . $sanpham->sanpham_id . '/' . $v_hinhanh->hinhanh_ten) }}" alt="Image">
                        </div>
                       
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-7 pb-5">
                <h3 class="font-weight-semi-bold">{{$sanpham->sanpham_ten}}</h3>
                <div class="d-flex mb-3">
                    <div class="text-primary mr-2">
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star-half-alt"></small>
                        <small class="far fa-star"></small>
                    </div>
                    <small class="pt-1">(50 Reviews)</small>
                </div>
         
                <?php 
                if(isset($price_update) && $price_update ){
                    ?>
                <h3 class="font-weight-semi-bold mb-4">       <s>{{number_format($sanpham->sanpham_gia) . ' VNĐ'}}</s></h3>
                <h3 class="font-weight-semi-bold mb-4">Giá khuyến mãi: {{number_format($price_update) . ' VNĐ'}}</h3>
                <?php }else{ ?>
                    <h3 class="font-weight-semi-bold mb-4">{{number_format($sanpham->sanpham_gia) . ' VNĐ'}}</h3>

                <?php }?>
                
                <p class="mb-4">{{$sanpham->sanpham_mota}}</p>
                <div class="d-flex mb-3">
                    <p class="text-dark font-weight-medium mb-0 mr-3">Thương hiệu: {{$sanpham->hang_ten}}</p>
                   
                </div>
                <div class="d-flex mb-4">
                    <p class="text-dark font-weight-medium mb-0 mr-3">Danh mục: {{$sanpham->danhmuc_ten}}</p>
                   
                </div>
                <div class="d-flex align-items-center mb-4 pt-2">
                <form action="{{route('save-cart')}}" method="post" id="cartForm">
             @csrf
    <div class="d-flex justify-content-between align-items-center">
        <div class="input-group quantity" style="width: 100px;">
            <div class="input-group-btn">
                <button class="btn btn-sm btn-primary btn-minus" type="button">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
            <input type="text" name="qty" class="form-control form-control-sm bg-secondary text-center" value="1">
            <input type="hidden" name="sanpham_id_hidden" value="{{$sanpham->sanpham_id}}">
            <div class="input-group-btn">
                <button class="btn btn-sm btn-primary btn-plus" type="button">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
        <button id="sendButton" type="submit" class="btn btn-primary px-3 ml-3"><i class="fa fa-shopping-cart mr-1"></i> Thêm vào giỏ hàng</button>
        <script>
                                            document.getElementById('sendButton').addEventListener('click', function() {
                                alert('Đã thêm sản phẩm vào giỏ hàng');
                                document.getElementById('cartForm').submit(); // Gửi form sau khi hiện thông báo
                            });

        </script>

        
    </div>
  
</form>
<a href="#dv" class="btn btn-primary px-3 ml-3"><i class="fa fa-file mr-1"></i> Dịch vụ đính kèm</a>
<script>
    document.querySelector('.btn-minus').addEventListener('click', function() {
        let qtyInput = document.querySelector('input[name="qty"]');
        let qty = parseInt(qtyInput.value);
        if(qty > 1) {
            qtyInput.value = qty - 1;
        }
    });

    document.querySelector('.btn-plus').addEventListener('click', function() {
        let qtyInput = document.querySelector('input[name="qty"]');
        let qty = parseInt(qtyInput.value);
        qtyInput.value = qty + 1;
    });
</script>

                </div>
                <div class="d-flex pt-2">
                    <p class="text-dark font-weight-medium mb-0 mr-2">Chia sẻ tới: </p>
                    <div class="d-inline-flex">
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-pinterest"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                <a class="nav-item nav-link  active" data-toggle="tab" href="#tab-pane-1" id="dv" >Dịch vụ</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-4">Hướng dẫn sử dụng & Video</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-2">Các thông số</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Đánh giá (10)</a>
                
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-5"  >Bảo hành</a>
                </div>
                <div class="tab-content">
                   
                    <div class="tab-pane fade" id="tab-pane-2">
                        <h4 class="mb-3">Thông số kỹ thuật</h4>
                                <?php echo "{$sanpham->sanpham_thongso}" ?>
                            
                           
                        
                    </div>
                    <div class="tab-pane fade" id="tab-pane-3">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="mb-4">1 review for "Colorful Stylish Shirt"</h4>
                                <div class="media mb-4">
                                    <img src="img/user.jpg" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                                    <div class="media-body">
                                        <h6>John Doe<small> - <i>01 Jan 2045</i></small></h6>
                                        <div class="text-primary mb-2">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                            <i class="far fa-star"></i>
                                        </div>
                                        <p>Diam amet duo labore stet elitr ea clita ipsum, tempor labore accusam ipsum et no at. Kasd diam tempor rebum magna dolores sed sed eirmod ipsum.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4 class="mb-4">Leave a review</h4>
                                <small>Your email address will not be published. Required fields are marked *</small>
                                <div class="d-flex my-3">
                                    <p class="mb-0 mr-2">Your Rating * :</p>
                                    <div class="text-primary">
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                </div>
                                <form>
                                    <div class="form-group">
                                        <label for="message">Your Review *</label>
                                        <textarea id="message" cols="30" rows="5" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Your Name *</label>
                                        <input type="text" class="form-control" id="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Your Email *</label>
                                        <input type="email" class="form-control" id="email">
                                    </div>
                                    <div class="form-group mb-0">
                                        <input type="submit" value="Leave Your Review" class="btn btn-primary px-3">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade " id="tab-pane-4">
                  
                  <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                      @foreach($hdsd as $v_hdsd)
                  <h4 class="mb-3">Hướng dẫn sử dụng</h4>
                  <h5>Documents</h5>
                  <a href="{{$v_hdsd->HDSD_mota}}">Nhấn vào đây </a>
                  <div class="form-group">
                              <h5 for="exampleInputEmail1">Video</h5><br>
                              <iframe width="700" height="400" src="https://www.youtube.com/embed/{{$v_hdsd->HDSD_video}}" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen></iframe>
                              <br>
                              
                          </div>
                          @endforeach
                      </div>
              </div>
               <div class="tab-pane fade " id="tab-pane-4">
                  
    
              </div> <div class="tab-pane fade " id="tab-pane-5">
                  
                  <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                  <h4>Thông tin bảo hành sản phẩm</h4>
                  <h5>{{$baohanh->baohanh_mota}}</h5>
                    </div>
                 
                 
              </div>
                    <div class="tab-pane fade show active" id="tab-pane-1">
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-md-6">
                                <h4 class="mb-4">Dịch vụ đính kèm</h4>
                                <div class="card-body border-left border-right text-center p-0 pt-4 pb-3"">
                              
                                    <form action="{{ route('add-service-cart') }}" method="post">
                                        @csrf
                                        <table class="table table-bordered text-center mb-0">
                                            <thead class="bg-secondary text-dark">
                                                <tr>
                                                    <th>Chọn</th>
                                                    <th>Dịch vụ</th>
                                                    <th>Giá dịch vụ</th>
                                                </tr>
                                            </thead>
                                            <tbody class="align-middle">
                                                @foreach($dichvu as $key => $value)
                                                <tr>
                                                    <td class="align-middle">
                                                        <input type="checkbox" name="dichvu_chon[]" value="{{ $value->dv_id }}">
                                                    </td>
                                                    <td class="align-middle">{{ $value->dv_ten }}</td>
                                                    <td class="align-middle">{{ number_format($value->giadichvu) }} VNĐ</td>
                                                    <input type="hidden" name="sanpham_id_hidden" value="{{ $sanpham->sanpham_id }}">
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="text-center mt-4">
                                            <button type="submit" class="btn btn-primary">Thêm dịch vụ đã chọn</button>
                                        </div>
                                    </form>
                             
                          
                            </div>
                           
                            </div>
                        </div>
                     </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->


    <!-- Products Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Sản phẩm tương tự</span></h2>
        </div>
    
        <div class="row px-xl-5 pb-3">
            @foreach($sanpham_tuongtu as $key =>$value)
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
           
                <div class="card product-item border-0 mb-4">
                   <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                   <a href="{{route('xem-san-pham', ['sanpham_id' => $value->sanpham_id])}}"><img class="img-fluid w-100" src="{{ asset('img/sp' . $value->sanpham_id . '/' . $value->sanpham_hinhanh) }}" alt=""></a> 
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">{{$value->sanpham_ten}}</h6>
                        <div class="d-flex justify-content-center">
                        <h6>{{number_format($value->sanpham_gia) . ' VNĐ'}}</h6>
                            <!-- <h6>$123.00</h6><h6 class="text-muted ml-2"><del>$123.00</del></h6> -->
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">

                        <a href="{{route('xem-san-pham', ['sanpham_id' => $value->sanpham_id])}}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>Xem chi tiết</a>
                        <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Thêm vào giỏ hàng</a>
                        
         
                    </div>
                 
                </div>
          
            
            </div>
            
            @endforeach
        </div>
    
    </div>
    <!-- Products End -->
@endsection

@section('slide')
    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Shop Detail</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Shop Detail</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->
@endsection
