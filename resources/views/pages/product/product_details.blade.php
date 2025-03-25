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
                <?php 
                if(count($danhgia) >= 1){
                    $avg_star = 0;
                    foreach($danhgia as $v_danhgia){
                        $avg_star = $avg_star + $v_danhgia->dg_xephang;
                    }
                    $avg_star =  $avg_star/count($danhgia);
                }else{
                    $avg_star = 0;
                }
                   
                
                ?>
                <div class="d-flex mb-3">
                <div class="text-primary mb-2">
                                        {{-- Display stars based on dg_xephang --}}
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= floor( $avg_star)) 
                                                <small class="fas fa-star"></small> {{-- Full star --}}
                                            @elseif ($i == ceil( $avg_star) &&  $avg_star - floor( $avg_star) > 0)
                                                <small class="fas fa-star-half-alt"></small> {{-- Half star --}}
                                            @else
                                                <small class="far fa-star"></small> {{-- Empty star --}}
                                            @endif
                                        @endfor
                                    </div>
                    <small class="pt-1">({{count($danhgia)}} Đánh giá)</small>
                </div>
         
                <?php 
                if(isset($price_update) && $price_update ){
                    ?>
                <h5 class="font-weight-semi-bold mb-4">       <s>{{number_format($sanpham->sanpham_gia) . ' VNĐ'}}</s></h5>
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
                <div class="d-flex mb-4">
                    <p class="text-dark font-weight-medium mb-0 mr-3">Xuất xứ: {{$sanpham->sanpham_xuatxu}}</p>
                   
                </div>
                <div class="d-flex mb-4">
                    <small class="text-dark font-weight-small mb-0 mr-3">Kho: {{$kho}} </small>
                </div>
                <div class="d-flex align-items-center mb-4 pt-2">
                <form action="{{route('save-cart')}}" method="post" id="cartForm">
             @csrf
    <div class="d-flex justify-content-between align-items-center">
        <div class="input-group quantity" style="width: 100px;">
            <div class="input-group-btn">
                <button class="btn btn-sm btn-primary btn-minus" type="button" onclick="decrementQty(this)" >
                    <i class="fa fa-minus"></i>
                </button>
            </div>
            <input type="text" name="qty" class="form-control form-control-sm bg-secondary text-center" value="1">
            <input type="hidden" name="sanpham_id_hidden" value="{{$sanpham->sanpham_id}}">
            <?php 
                if(isset($price_update) && $price_update ){
                    ?>
            <input type="hidden" name="gia_update" value="{{$price_update}}">
            <?php }?>
            <div class="input-group-btn">
                <button class="btn btn-sm btn-primary btn-plus" type="button" onclick="incrementQty(this)">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
        <button id="sendButton" type="submit" class="btn btn-primary px-3 ml-3"><i class="fa fa-shopping-cart mr-1"></i> Thêm vào giỏ hàng</button>
        <script>
            const maxQty = <?= $kho; ?>;
function incrementQty(button) {
    let input = button.closest('.quantity').querySelector('input[name="qty"]');
    let currentValue = parseInt(input.value) || 0;

    // if (currentValue < maxQty-1) { // Limit to 5
    //     input.value = currentValue + 1;
    // }

    // Disable the button if the value is 5
    if (currentValue + 1 >= maxQty) {
        button.disabled = true;
    } else {
        button.disabled = false;
    }

    // Ensure the minus button is always enabled
    let minusButton = button.closest('.quantity').querySelector('.btn-minus');
    minusButton.disabled = false;
}

function decrementQty(button) {
    let input = button.closest('.quantity').querySelector('input[name="qty"]');
    let currentValue = parseInt(input.value) || 0;

    if (currentValue > 1) { // Prevent going below 1
      

        // Re-enable the "plus" button if the value drops below 5
        let plusButton = button.closest('.quantity').querySelector('.btn-plus');
        if (currentValue - 1 < maxQty) {
            plusButton.disabled = false;
        }
    } else {
        alert("Bạn không thể giảm số lượng nhỏ hơn 1.");
    }
}



                document.getElementById('sendButton').addEventListener('click', function() {
                    // Gửi form
                    document.getElementById('cartForm').submit();

                    // Lưu trạng thái vào localStorage
                    localStorage.setItem('formSubmitted', true);

                    // Hiện thông báo
                    // alert('Đã thêm sản phẩm vào giỏ hàng, bạn có muốn xem các dịch vụ ?');
                });
                // Kiểm tra trạng thái khi tải lại trang
                window.addEventListener('load', function() {
                    if (localStorage.getItem('formSubmitted')) {
                        // Hiện thông báo khác
                        alert('Đã thêm sản phẩm vào giỏ hàng, bạn có muốn xem các dịch vụ?');
                        document.getElementById('dv').scrollIntoView({ behavior: 'smooth' });
                        // Xóa trạng thái để không hiện thông báo nữa
                        localStorage.removeItem('formSubmitted');
                    }
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
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Đánh giá  ({{ count($danhgia) }})</a>
                
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-5"  >Bảo hành</a>
                </div>
                <div class="tab-content">
                   
                    <div class="tab-pane fade" id="tab-pane-2">
                        <h4 class="mb-3">Thông số kỹ thuật</h4>
                                <?php echo "{$sanpham->sanpham_thongso}" ?>
                            
                           
                        
                    </div>
                    <div class="tab-pane fade" id="tab-pane-3">
                     
           
            
                        <div class="row">
                        <div class="col" >
                        <h4 class="mb-4">Các đánh giá ({{ count($danhgia) }})</h4>
                        <div style="max-height: 300px; overflow-y: auto;"  >
                            @foreach($danhgia as $key => $value)
                            <div class="media mb-4" >
                                <img src="{{ asset('img/profile.jpg') }}" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                                <div class="media-body">
                                    <h6>{{$value->khachhang_ten}}<small> - <i>{{$value->dg_ngay}}</i></small></h6>
                                    <div class="text-primary mb-2">
                                        {{-- Display stars based on dg_xephang --}}
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= floor($value->dg_xephang)) 
                                                <i class="fas fa-star"></i> {{-- Full star --}}
                                            @elseif ($i == ceil($value->dg_xephang) && $value->dg_xephang - floor($value->dg_xephang) > 0)
                                                <i class="fas fa-star-half-alt"></i> {{-- Half star --}}
                                            @else
                                                <i class="far fa-star"></i> {{-- Empty star --}}
                                            @endif
                                        @endfor
                                    </div>
                                    <p>{{$value->dg_noidung}}</p>
                                </div>
                                </div>
                            @endforeach
                            </div>
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
                                <div class="card-body border-left borderz-right text-center p-0 pt-4 pb-3"">
                              
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
                    <form action="{{route('save-cart')}}" method="post">
                @csrf
                <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                <input type="hidden" name="sanpham_id_hidden" value="{{$value->sanpham_id}}">
                <input type="hidden" name="qty" value="1">
                    <h6 class="text-truncate mb-3">{{$value->sanpham_ten}}</h6>
                    <?php 
                    $price_update = null; // Default value if no discount is applied
                    ?>

                    @foreach($khuyenmai as $key => $value2)
                        @if($value2->sanpham_id == $value->sanpham_id)
                            <?php 
                            if ($value2->km_donvi == '%') {
                                $price_update = $value->sanpham_gia - ($value->sanpham_gia * $value2->km_gia) / 100;
                            } else if ($value2->km_donvi == 'VND') {
                                $price_update = $value->sanpham_gia - $value2->km_gia;
                            }
                            ?>
                            @break {{-- Exit the loop once a matching discount is found --}}
                        @endif
                    @endforeach

                    @if($price_update!== null)
                    <div class="d-flex justify-content-center">
                        <s style="font-size: 12px;">{{ number_format($value->sanpham_gia) . ' VNĐ' }}</s> &nbsp; 
                        <h6>{{ number_format($price_update) . ' VNĐ' }}</h6>
                        </div>
                    @else
                    <div class="d-flex justify-content-center">
                        <h6>{{ number_format($value->sanpham_gia) . ' VNĐ' }}</h6>
                    </div>
                    @endif
                </div>
                <?php 
                    if(isset($price_update) && $price_update ){
                        ?>
                   <input type="hidden" name="gia_update" value="{{$price_update}}">
                     <?php }?>
                <div class="card-footer d-flex justify-content-between bg-light border">
                    <a href="{{route('xem-san-pham', ['sanpham_id' => $value->sanpham_id])}}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>Xem chi tiết</a>
                   
                    <button type="submit" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Thêm vào giỏ hàng</button>
                   
                </div>
                </form>
                 
                </div>
          
            
            </div>
            
            @endforeach
        </div>
    
    </div>
    <!-- Products End -->
@endsection

@section('slide')
    <!-- Page Header Start -->
    <div class="container-fluid mb-5" style="background-image: url('../img/bgu4.jpg'); background-size: cover; background-position: center;">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3" style="color: white; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">Shop Detail</h1>
        <div class="d-inline-flex">
            <p class="m-0" style="color: white; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);"><a href="" style="color: white; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">Home</a></p>
            <p class="m-0 px-2" style="color: white; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">-</p>
            <p class="m-0" style="color: white; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">Shop Detail</p>
        </div>
    </div>
</div>
    <!-- Page Header End -->
@endsection
