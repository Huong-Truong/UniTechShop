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
    padding-top: 25px;
    padding-bottom: 100px;
}
 .dn, .login-form, .signup-form {
 
	border-radius: 5px;
	padding: 25px;
    background-color:rgb(255, 255, 255) !important;
}

form label{

    font-weight: bold !important;
   
}
.dn .form-control{
    border: 1px  rgb(130, 130, 130)  solid ;
}
h2{
    padding: 10px;
    text-align: center;
}
</style>
<?php
    $message = Session::get('message');
    if($message){?>
    <div id="errorBox" class="mess-box">
        {{$message}}
    </div>
<?php
    Session::forget('message');
    }
?>
<div class="row px-xl-5">
            <div class="col">
                <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                <a class="nav-item nav-link  active" data-toggle="tab" href="#tab-pane-1" id="dv" >Quản lý tài khoản</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-4">Lịch sử đơn hàng</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-5">Lịch sử đánh giá</a>
                </div>
                <div class="tab-content">

                <div class="tab-pane fade " id="tab-pane-5">
                    <table class="table table-bordered text-center mb-0">
                        <thead class="bg-secondary text-dark">
                            <tr>
                                <th>Hình ảnh</th>
                                <th>Sản phẩm</th>
                                <th >Nội dung đánh giá</th>
                                <th>Số sao</th>
                                <th>Ngày đánh giá</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            @foreach ($danhgia as $key=>$value )
                                <tr>
                                <td><img src="/img/sp{{$value->sanpham_id}}/{{$value->sanpham_hinhanh}}" width="50" /></td>
                                    <td class="align-middle">{{ $value->sanpham_ten}} </td>
                                    <td class="align-middle">{{ $value->dg_noidung}}</td>
                                    <td class="align-middle">
                                    <div class="text-primary mb-2">
                                    {{-- Display stars based on dg_xephang --}}
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $value->dg_xephang)
                                            <i class="fas fa-star"></i> {{-- Full star --}}
                                        @else
                                            <i class="far fa-star"></i> {{-- Empty star --}}
                                        @endif
                                    @endfor
                                </div>


                                    </td>
                                    <td class="align-middle">{{ $value->dg_ngay}}</td>
                                  
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                
            </div>
                    <div class="tab-pane fade " id="tab-pane-4">
                    <table class="table table-bordered text-center mb-0">
        <thead class="bg-secondary text-dark">
            <tr>
                <th>Mã đơn</th>
                <th>Tổng giá trị</th>
                <th>Phương thức thanh toán</th>
                <th>Trạng thái</th>
                <th>Địa chỉ giao hàng</th>
                <th>Ngày đặt</th>
                <th>Chi tiết đơn hàng</th>
                <th>Đánh giá</th>
            </tr>
        </thead>
        <tbody class="align-middle">
            @foreach ($donhang as $key => $value)
                <tr>
                    <td class="align-middle">{{ $value->donhang_id }}</td>
                    <td class="align-middle">{{ $value->donhang_tongtien }}</td>
                    <td class="align-middle">{{ $value->pttt_ten }}</td>
                    <td class="align-middle">{{ $value->trangthai_ten }}</td>
                    <td class="align-middle">{{ $value->vanchuyen_diachi }}</td>
                    <td class="align-middle">{{ $value->donhang_ngaytao }}</td>
                    <td class="align-middle"><a href="#" class="btn btn-info btn-sm" data-id="{{ $value->donhang_id }}">Xem chi tiết</a></td>
                    <td class="align-middle">
                        @if ($value->trangthai_id == 5 && !$value->danhgia)
                            <button class="btn btn-info btn-sm review-btn" data-id="{{ $value->donhang_id }}">Đánh giá</button>
                        @elseif ($value->danhgia)
                        <span class="text-primary" style="font-weight:bold;">Đã đánh giá</span>

                        @else
                            <span class="text-muted">Không khả dụng</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
<!-- Review Modal -->
<!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviewModalLabel">Đánh giá sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10%;">Hình ảnh</th>
                            <th style="width: 25%;">Tên sản phẩm</th>
                            <th style="width: 65%;">Đánh giá</th>
                        </tr>
                    </thead>
                    <tbody id="productReviewBody">
                        <!-- Product rows dynamically inserted here -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <button type="button" class="btn btn-info btn-sm" id="submitReview">Gửi đánh giá</button>
            </div>
        </div>
    </div>
</div>


<script>

document.addEventListener('DOMContentLoaded', function () {
    const reviewButtons = document.querySelectorAll('.review-btn');
    const reviewModal = new bootstrap.Modal(document.getElementById('reviewModal'));
    const productReviewBody = document.getElementById('productReviewBody');

    // Add click event listener for all "Đánh giá" buttons
    reviewButtons.forEach(button => {
        button.addEventListener('click', function () {
            const orderId = this.getAttribute('data-id'); // Get the specific order ID
            console.log('Order ID:', orderId);

            // Fetch products dynamically for the specific order
            fetch(`/get-order-products/${orderId}`) // Backend endpoint for fetching products
                .then(response => response.json())
                .then(products => {
                    console.log('Fetched Products for Order:', products);

                    // Clear the modal body
                    productReviewBody.innerHTML = '';

                    // Populate the modal with product details from the fetched data
                    products.forEach(product => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td><img src="/img/sp${product.sanpham_id}/${product.sanpham_hinhanh}" alt="${product.sanpham_ten}" width="50" /></td>
                            <td>${product.sanpham_ten}</td>
                            <td>
                                <div class="stars" data-product-id="${product.sanpham_id}">
                                    ${[1, 2, 3, 4, 5].map(rating => `<i class="far fa-star" data-rating="${rating}"></i>`).join('')}
                                </div>
                                <textarea class="form-control mt-2" placeholder="Nhập đánh giá của bạn" data-product-id="${product.sanpham_id}"></textarea>
                            </td>
                        `;
                        productReviewBody.appendChild(row);
                    });

                    // Attach star rating functionality to each product
                    document.querySelectorAll('.stars').forEach(container => {
                        container.querySelectorAll('i').forEach((star, index) => {
                            star.addEventListener('click', () => {
                                container.querySelectorAll('i').forEach(s => s.classList.remove('fas', 'far'));
                                for (let i = 0; i <= index; i++) {
                                    container.querySelectorAll('i')[i].classList.add('fas');
                                }
                            });
                        });
                    });

                    // Show the modal
                    reviewModal.show();
                })
                .catch(error => {
                    console.error('Error fetching products for order:', error);
                    alert('Có lỗi xảy ra khi lấy thông tin sản phẩm cho đơn hàng này.');
                });
        });
    });

    // Handle "Gửi đánh giá" button click
    document.getElementById('submitReview').addEventListener('click', function () {
        const reviews = [];
        const textareas = document.querySelectorAll('#productReviewBody textarea');
        const khachhangId = document.querySelector('input[name="khachhang_id"]').value;
        const orderId = document.querySelector('.review-btn[data-id]')?.getAttribute('data-id'); // Capture orderId from button

        textareas.forEach(textarea => {
            const productId = textarea.getAttribute('data-product-id');
            const starsContainer = document.querySelector(`.stars[data-product-id="${productId}"]`);
            const rating = starsContainer ? starsContainer.querySelectorAll('.fas').length : 0;
            const content = textarea.value.trim();

            reviews.push({ productId, rating, content, khachhangId });
        });

        console.log('Order ID:', orderId);
        console.log('Collected Reviews:', reviews);

        // Send data to the server
        fetch('/submit-reviews', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ orderId, reviews }) // Include orderId and reviews here
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Đánh giá đã được gửi thành công!');
                    reviewModal.hide();

                    const reviewButton = document.querySelector(`.review-btn[data-id="${data.orderId}"]`);
                    if (reviewButton) {
                        reviewButton.disabled = true;
                        reviewButton.textContent = 'Đã đánh giá';
                        reviewButton.classList.replace('btn-info', 'btn-secondary');
                    }
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error submitting reviews:', error);
                alert('Có lỗi xảy ra khi gửi đánh giá.');
            });
    });
});

</script>




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
                            <div class="col-md-8 d-flex justify-content-center align-items-center" style="padding-left:150px;">

                                <div class="tab-content">
                                    <!-- Tab "Cập nhật thông tin tài khoản" -->
                                    <div class="tab-pane fade show active" id="tab2-pane-3">
                                        <div class="dn card border-left border-right text-center p-4">
                                            <h4>Cập nhật thông tin tài khoản</h4>
                                            <form action="{{ route('update-info') }}" method="POST">
                                                @csrf
                                                <div class="row">
                                                <input type="hidden" name="khachhang_id" value="{{$taikhoan->khachhang_id}}">
                                                <div class="col-md-6 form-group">
                                                    <label>Tên tài khoản</label>
                                                    <input value="{{$taikhoan->khachhang_ten}}" name="name" class="form-control" type="text" placeholder="Nhập tên tài khoản" required>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label>Địa chỉ email</label>
                                                    <input value="{{$taikhoan->khachhang_email}}" name="email" class="form-control" type="email" placeholder="Nhập email"  required>
                                                </div>
                                                <div class="col-md-6 form-group ">
                                                    <label>Số điện thoại</label>
                                                    <input value="{{$taikhoan->khachhang_sdt}}" name="phone" class="form-control" type="text" placeholder="Nhập số điện thoại"  required>
                                                </div>
                                                <div class="col-md-6 form-group ">
                                                    <label>Địa chỉ</label>
                                                    <textarea style="width: 100%; height: 200px;" type="text" class="form-control" name="address" id="" value="{{$taikhoan->khachhang_diachi}}">{{$taikhoan->khachhang_diachi}}</textarea>
                                                </div>
                                                <div class="col-md-6 form-group "> 
                                                </div>
                                                <div class="col-md-6 form-group " >
                                
                                                <button type="submit" class="btn btn-primary btn-block">Cập nhật</button>
                                                </div>
                                                </div>
                                              
                                                
                                                
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Tab "Đổi mật khẩu" -->
                                    <div class="tab-pane fade" id="tab2-pane-2">
                                        <div class=" dn card border-left border-right text-center p-4">
                                            <h4>Đổi mật khẩu</h4>
                                            <form action="{{route('change-pass')}}" method="POST">
                                                @csrf
                                                <div class="row">

                                             
                                                 
                                                        <input name="old_password" class="form-control" type="password" placeholder="Nhập mật khẩu cũ"  required>
                                                    

                                                        <br><br>
                                                
                                                        <input name="new_password" class="form-control" type="password" placeholder="Nhập mật khẩu mới"  required>
                                                        <br><br>
                                                        <input name="confirm_password" class="form-control" type="password" placeholder="Xác nhận mật khẩu mới"  required>
                                                    
                                                    <input type="hidden" name="khachhang_id" value="{{Session::get('khachhang_id')}}">
                                                        <br><br>
                                                     <input type="submit" class="btn btn-primary btn-block" value="Đổi mật khẩu">
                                                  
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                 
            
        </div>

@endsection

