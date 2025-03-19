@extends ('layout')
@section('slide')
<div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Tài khoản</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="">Trang Chủ</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Tài khoản</p>
            </div>
        </div>
    </div>
@endsection

@section('content')
<style>
    .container{
        padding-left: 500px;
      
    }
 .dn, .login-form, .signup-form {
    border: 1px dashed #000000; /* 2px wide black border */
	border-radius: 5px;
	padding: 20px;
   
    border-color: lightgray;
    background-color:rgba(194, 194, 194, 0.2) !important;
}
form label{
    margin: 8px;
    font-weight: bold !important;
}
form input{
    margin-bottom: 5px;
  
}
h2{
    padding: 10px;
    text-align: center;
}
</style>
<div class="row px-xl-5">
            <div class="col">
                <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                <a class="nav-item nav-link  active" data-toggle="tab" href="#tab-pane-1" id="dv" >Quản lý tài khoản</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-4">Lịch sử đơn hàng</a>
        
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade " id="tab-pane-4">
                    <table class="table table-bordered text-center mb-0">
                        <thead class="bg-secondary text-dark">
                            <tr>
                                <th>Mã đơn</th>
                                <th>Tổng giá trị</th>
                                <th>Phương thức thanh toán </th>
                                <th>Trạng thái</th>
                                <th>Địa chỉ giao hàng</th>
                                <th>Ngày đặt</th>
                                <th>Chi tiết đơn hàng</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            @foreach ($donhang as $key=>$value )
                                <tr>
                                    
                                    <td class="align-middle">{{ $value->donhang_id }} </td>
                                    <td class="align-middle">{{ $value->donhang_tongtien }}</td>
                                    <td class="align-middle">{{ $value->pttt_ten }}</td>
                                    <td class="align-middle">{{ $value->trangthai_ten }}</td>
                                    <td class="align-middle">{{ $value->vanchuyen_diachi }}</td>
                                    <td class="align-middle">{{ $value->donhang_ngaytao }}</td>
                                    <td class="align-middle">
            <a href="#" class="btn btn-info btn-sm" data-id="{{ $value->donhang_id }}">Xem chi tiết</a>
        </td>                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="orderDetailsLabel">Chi tiết đơn hàng</h5>
                        
                                </div>
                                <div class="modal-body">
                                    <table class="table">
                                    <thead>
                                        <tr>
                                        <th  class="align-middle" >Hình ảnh</th>
                                        <th class="align-middle">Tên sản phẩm</th>
                                        <th class="align-middle">Số lượng</th>
                                        <th class="align-middle">Giá</th>
                                        </tr>
                                    </thead>
                                    <tbody id="orderDetailsBody">
                                        <!-- Thông tin sản phẩm sẽ được thêm vào đây -->
                                    </tbody>
                                    </table>
                                </div>

                                </div>
                            </div>
                        </div>
                    </div> 
                    <script>
    // Tạo mảng từ dữ liệu `$ctdh` được truyền từ PHP
                        const orderDetails = @json($ctdh);
                    </script>

                    <script>
                        // Gắn sự kiện click vào tất cả các thẻ `a` với `href="#"`
                        document.querySelectorAll('a[data-id]').forEach((link) => {
                            link.addEventListener('click', function (e) {
                                e.preventDefault(); // Ngăn chặn hành động mặc định của liên kết

                                // Lấy phần tử tbody trong bảng chi tiết đơn hàng
                                const orderId = this.getAttribute('data-id');
                                const tbody = document.getElementById('orderDetailsBody');
                                tbody.innerHTML = ''; // Làm sạch nội dung cũ trong bảng

                                // Lọc chi tiết đơn hàng theo ID
                                const selectedOrder = orderDetails.filter(item => item.donhang_id == orderId);



                                // Duyệt qua từng sản phẩm trong mảng `orderDetails`
                                selectedOrder.forEach((item) => {
                                    const row = document.createElement('tr');
                                    row.innerHTML = `
<td>
    <img src="/img/sp${item.sanpham_id}/${item.sanpham_hinhanh}" alt="${item.sanpham_ten}" style="width: 50px;">
   
</td>                                      <td>${item.sanpham_ten}</td>
                                        <td>${item.ctdh_soluong}</td>
                                        <td>${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(item.sanpham_gia)}</td>
                                    `;
                                    tbody.appendChild(row);
                                });

                                // Hiển thị modal sử dụng Bootstrap Modal
                                const modal = new bootstrap.Modal(document.getElementById('orderDetailsModal'));
                                modal.show();
                            });
                        });
                    </script>
                    <div class="tab-pane fade show active" id="tab-pane-1">
                         
                 
                        <div class="row">
                            <!-- Tabs bên trái -->
                            <div class="col-md-3">
                                <div class="nav flex-column nav-tabs border-secondary mb-4">
                                    <a class="nav-item nav-link active" data-toggle="tab" href="#tab2-pane-3">Cập nhật thông tin tài khoản</a>
                                    <a class="nav-item nav-link" data-toggle="tab" href="#tab2-pane-2">Đổi mật khẩu</a>
                                </div>
                            </div>

                            <!-- Nội dung tab bên phải -->
                            <div class="col-md-5 d-flex justify-content-center align-items-center" style="padding-left:150px;">

                                <div class="tab-content">
                                    <!-- Tab "Cập nhật thông tin tài khoản" -->
                                    <div class="tab-pane fade show active" id="tab2-pane-3">
                                        <div class="dn card border-left border-right text-center p-4">
                                            <h4>Cập nhật thông tin tài khoản</h4>
                                            <form action="{{ route('update-info') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="khachhang_id" value="{{$taikhoan->khachhang_id}}">
                                                <div class="form-group">
                                                    <label>Tên tài khoản</label>
                                                    <input value="{{$taikhoan->khachhang_ten}}" name="name" class="form-control" type="text" placeholder="Nhập tên tài khoản">
                                                </div>
                                                <div class="form-group">
                                                    <label>Địa chỉ email</label>
                                                    <input value="{{$taikhoan->khachhang_email}}" name="email" class="form-control" type="email" placeholder="Nhập email">
                                                </div>
                                                <div class="form-group">
                                                    <label>Số điện thoại</label>
                                                    <input value="{{$taikhoan->khachhang_sdt}}" name="phone" class="form-control" type="text" placeholder="Nhập số điện thoại">
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-block">Cập nhật</button>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Tab "Đổi mật khẩu" -->
                                    <div class="tab-pane fade" id="tab2-pane-2">
                                        <div class=" dn card border-left border-right text-center p-4">
                                            <h4>Đổi mật khẩu</h4>
                                            <form action="" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label>Nhập mật khẩu cũ</label>
                                                    <input name="old_password" class="form-control" type="password" placeholder="Nhập mật khẩu cũ">
                                                </div>
                                                <div class="form-group">
                                                    <label>Nhập mật khẩu mới</label>
                                                    <input name="new_password" class="form-control" type="password" placeholder="Nhập mật khẩu mới">
                                                </div>
                                                <div class="form-group">
                                                    <label>Xác nhận mật khẩu mới</label>
                                                    <input name="confirm_password" class="form-control" type="password" placeholder="Xác nhận mật khẩu mới">
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-block">Đổi mật khẩu</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                 
            
        </div>

@endsection

