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
            <div  class="col-lg-4"></div>
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
                            <label>Địa chỉ cụ thể</label>
                            <textarea name="diachi" class="form-control"  style="width: 100%; height: 200px;">{{$khachhang->khachhang_diachi}}</textarea>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Ghi chú gửi hàng</label>
                            <textarea name="ghichu" class="form-control" placeholder="Đường 3/2, P.Xuân Khánh. Q.Ninh Kiều, TP.Cần Thơ" style="width: 100%; height: 200px;"></textarea>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Số điện thoại</label>
                            <input name="sdt" class="form-control" type="text" placeholder="0123 456 789"  value="{{$khachhang->khachhang_sdt}}">
                        </div>
                        <div class="col-md-6 form-group">
                        <label>&nbsp;</label>
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
                            <input name="nguoinhan" class="form-control" type="text" value="">
                        </div>
             
                        <div class="col-md-6 form-group">
                            <label>E-mail</label>
                            <input name="email" class="form-control" type="text" placeholder="example@email.com" value="">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Địa chỉ cụ thể</label>
                            <textarea name="diachi" class="form-control"  style="width: 100%; height: 200px;"></textarea>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Ghi chú gửi hàng</label>
                            <textarea name="ghichu" class="form-control" placeholder="Đường 3/2, P.Xuân Khánh. Q.Ninh Kiều, TP.Cần Thơ" style="width: 100%; height: 200px;"></textarea>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Số điện thoại</label>
                            <input name="sdt" class="form-control" type="text" placeholder="0123 456 789"  value="">
                        </div>
                        <div class="col-md-6 form-group">
                        <label>&nbsp;</label>
                        <input class="form-control btn btn-primary" type="submit" value="xác nhận">
                        </div>
           
                
                    </div>
                    </form>
                </div>
                
            </div>
         

        </div>
    </div>
    <!-- Checkout End -->
@endsection
