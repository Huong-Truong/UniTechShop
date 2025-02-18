 <!-- Page Header Start -->
  @extends('layout')
  @section('slide')
 <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Thanh Toán</h1>
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
            <div class="col-lg-8">
                <div class="mb-4">
                <div class="col-md-12 form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="newaccount">
                                <label class="custom-control-label" for="newaccount">Bạn chưa có tài khoản để thanh toán? Tạo tài khoản</label>
                            </div>
                        </div>
                    <h4 class="font-weight-semi-bold mb-4">Địa chỉ giao hàng (mặc định)</h4>
                    <form action="{{route('save-checkout')}}" method="post">
                        @csrf
                    <div class="row">
              
                        <div class="col-md-6 form-group">
                            <label>Họ tên</label>
                            <input name="nguoinhan" class="form-control" type="text" value="{{$khachhang->khachhang_ten}}">
                        </div>
             
                        <div class="col-md-6 form-group">
                            <label>E-mail</label>
                            <input name="email" class="form-control" type="text" placeholder="example@email.com" value="{{$khachhang->khachhang_email}}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Số điện thoại</label>
                            <input name="sdt" class="form-control" type="text" placeholder="0123 456 789"  value="{{$khachhang->khachhang_sdt}}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Thành phố</label>
                            <input class="form-control" type="text" placeholder="HCM">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Địa chỉ cụ thể</label>
                            <textarea name="diachi" class="form-control"  style="width: 100%; height: 200px;">{{$khachhang->khachhang_diachi}}</textarea>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Ghi chú gửi hàng</label>
                            <textarea name="ghichu" class="form-control" placeholder="Đường 3/2, P.Xuân Khánh. Q.Ninh Kiều, TP.Cần Thơ" style="width: 100%; height: 200px;"></textarea>
                        </div>
                        <div class="col-md-6 form-group">
                      
                            <input class="form-control btn btn-primary" type="submit" value="xác nhận">
                        </div>
                
                    </div>
                    </form>
    
                        <div class="col-md-12 form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="shipto">
                                <label class="custom-control-label" for="shipto"  data-toggle="collapse" data-target="#shipping-address">Giao đến một địa chỉ khác</label>
                            </div>
                        </div>
                    
                </div>
                <div class="collapse mb-4" id="shipping-address">
                    <h4 class="font-weight-semi-bold mb-4">Địa chỉ giao hàng</h4>
                    <form action="{{route('save-checkout')}}" method="post">
                    @csrf
                    <div class="row">
                       <div class="col-md-6 form-group">
                            <label>Họ tên</label>
                            <input class="form-control" type="text" placeholder="Truong Thi Da Huong">
                        </div>
             
                        <div class="col-md-6 form-group">
                            <label>E-mail</label>
                            <input class="form-control" type="text" placeholder="example@email.com">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Số điện thoại</label>
                            <input class="form-control" type="text" placeholder="0123 456 789">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Thành phố</label>
                            <input class="form-control" type="text" placeholder="0123 456 789">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Địa chỉ cụ thể</label>
                            <textarea class="form-control" placeholder="Đường 3/2, P.Xuân Khánh. Q.Ninh Kiều, TP.Cần Thơ" style="width: 100%; height: 200px;"></textarea>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Ghi chú gửi hàng</label>
                            <textarea class="form-control" placeholder="Đường 3/2, P.Xuân Khánh. Q.Ninh Kiều, TP.Cần Thơ" style="width: 100%; height: 200px;"></textarea>
                        </div>
                        <div class="col-md-6 form-group">
                      
                      <input class="form-control btn btn-primary" type="submit" value="xác nhận">
                  </div>
          
                    </div>
                </form>
                </div>
                
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
