
@extends('layout')
@section('content')
    <!-- Cart Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-9 table-responsive mb-5">
            <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Chi tiết giỏ hàng</span></h2>
        </div>
                <table class="table table-bordered text-center mb-0">
                    <?php 
                    $content = Cart::content();
                    ?>
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Hình ảnh</th>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tổng tiền</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($content as $v_content)
                        <tr>
                            <td><img src="{{ asset('img/sp' . $v_content->id . '/' . $v_content->options->image) }}" alt="" style="width: 50px;"></td>
                            <td class="align-middle"> {{$v_content->name}}</td>
                            <td class="align-middle">{{ number_format($v_content->price). ' VNĐ' }}</td>
                            <td class="align-middle">
                                <form action="{{route('update-cart-qty')}}" method="post">
                                    @csrf
                                <div class="input-group quantity mx-auto" style="width: 100px;">

                                    <input type="text" class="form-control form-control-sm bg-secondary text-center" name="cart_qty" value="{{$v_content->qty}}">
                                    <input type="hidden" class="form-control form-control-sm bg-secondary text-center" name ="rowID_cart" value="{{$v_content->rowId}}">
                                     <input type="submit" class="btn btn-sm btn-primary text-center" value="CN">
                                </div>
                                </form>
                            </td>
                            <td class="align-middle"><?php 
                                $sub = $v_content->price * $v_content->qty;
                                echo number_format($sub) . ' VNĐ';
                            ?></td>
                            <td class="align-middle"><a href="{{route('delete-to-cart', ['rowID'=> $v_content->rowId])}}" class="btn btn-sm btn-primary"><i class="fa fa-times"></i></a></td>
                        </tr>
                       @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-3">
                <form class="mb-5" action="">
                    <div class="input-group">
                        <input type="text" class="form-control p-4" placeholder="Coupon Code">
                        <div class="input-group-append">
                            <button class="btn btn-primary">Nhập mã giảm giá</button>
                        </div>
                    </div>
                </form>
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Đơn giá giỏ hàng</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Tổng tiền</h6>
                            <h6 class="font-weight-medium">{{Cart::priceTotal()}}</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Thuế</h6>
                            <h6 class="font-weight-medium">{{Cart::tax()}}</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Phí ship</h6>
                            <h6 class="font-weight-medium">Free</h6>
                        </div>
                       
                        <!-- <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Thành tiền</h6>
                            <h6 class="font-weight-medium">{{Cart::subtotal()}}</h6>
                        </div> -->
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Thành tiền</h5>
                            <h5 class="font-weight-bold">{{Cart::total()}}</h5>
                        </div>
                        <?php
                            $khachhang_id = Session::get('khachhang_id');
                            if($khachhang_id!= NULL){
                            ?>
                          <a href="{{route('checkout')}}" class="btn btn-block btn-primary my-3 py-3">Thanh toán đơn hàng</a>
                        <?php }else{  ?>
                            <a href="{{route('login-checkout')}}" class="btn btn-block btn-primary my-3 py-3">Thanh toán đơn hàng</a>
                    
                        <?php  }?>
                
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
    @endsection

    
@section('slide')
    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Giỏ Hàng</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Giỏ Hàng</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->
@endsection