 <!-- Page Header Start -->
 @extends('layout')
  @section('slide')
 <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Thanh Toán giỏ hàng</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="">Trang Chủ</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Thanh toán</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->
@endsection


@section('content')
    <!-- Checkout Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
           
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
                            <!-- <th>Xóa</th> -->
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
                                     <!-- <input type="submit" class="btn btn-sm btn-primary text-center" value="CN"> -->
                                </div>
                                </form>
                            </td>
                            <td class="align-middle"><?php 
                                $sub = $v_content->price * $v_content->qty;
                                echo number_format($sub) . ' VNĐ';
                            ?></td>
                            <!-- <td class="align-middle"><a href="{{route('delete-to-cart', ['rowID'=> $v_content->rowId])}}" class="btn btn-sm btn-primary"><i class="fa fa-times"></i></a></td> -->
                        </tr>
                       @endforeach
                    </tbody>
                        </table>
                    </div>
        
            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Order Total</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="font-weight-medium mb-3">Products</h5>
                        <div class="d-flex justify-content-between">
                            <p>Colorful Stylish Shirt 1</p>
                            <p>$150</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p>Colorful Stylish Shirt 2</p>
                            <p>$150</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p>Colorful Stylish Shirt 3</p>
                            <p>$150</p>
                        </div>
                        <hr class="mt-0">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Subtotal</h6>
                            <h6 class="font-weight-medium">$150</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium">$10</h6>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold">$160</h5>
                        </div>
                    </div>
                </div>
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Payment</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="paypal">
                                <label class="custom-control-label" for="paypal">Paypal</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="directcheck">
                                <label class="custom-control-label" for="directcheck">Direct Check</label>
                            </div>
                        </div>
                        <div class="">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="banktransfer">
                                <label class="custom-control-label" for="banktransfer">Bank Transfer</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <button class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Place Order</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Checkout End -->
@endsection
