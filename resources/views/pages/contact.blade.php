@extends ('layout')
@section('content')
<!-- Contact Start -->
<div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Mọi thắc mắc xin liên hệ</span></h2>
        </div>
        <div class="row px-xl-5">
            <div class="col-lg-7 mb-5">
                <div class="contact-form">
                    <div id="success"></div>
                    <!-- name="sentMessage" id="contactForm" -->
                    <form  action="{{route('send-contact')}}" method="post" id="contactForm" >
                        @csrf
                        <div class="control-group">
                            <input type="text" class="form-control" id="name" placeholder="Tên"
                                 required="required" 
                                 name="khachhang_ten"/>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <input type="email" class="form-control" id="email" placeholder="Email" name="email_kh"
                                required="required"  />
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <input type="text" class="form-control" id="subject" placeholder="Tiêu đề" name="subject"
                                required="required"  />
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <textarea class="form-control" rows="6" id="message" placeholder="Nội dung" name="content"
                                required="required"
                             ></textarea>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary py-2 px-4" id="sendButton">Gửi</button>
                        </div>
                        <script>
                            document.getElementById('sendButton').addEventListener('click', function() {
                                alert('Cảm ơn bạn đã gửi ý kiến, chúng tôi sẽ phản hồi sớm nhất có thể.');
                                document.getElementById('contactForm').submit(); // Gửi form sau khi hiện thông báo
                            });
                        </script>

                    </form>

                </div>
            </div>
            <div class="col-lg-5 mb-5">
                <h5 class="font-weight-semi-bold mb-3">Lời cảm ơn</h5>
                <p>Cảm ơn bạn đã đóng góp ý kiến, chúng tôi sẽ ghi nhận và khắc phục. Hãy tiếp tục mua sắm với chúng tôi nhé</p>
                <div class="d-flex flex-column mb-3">
                    <h5 class="font-weight-semi-bold mb-3">Store 1</h5>
                    <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>Đường 3/2, Phường Hưng Lợi, Quận Ninh Kiều, Thành phố Cần Thơ</p>
                    <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>ctu@gmail.com</p>
                    <p class="mb-2"><i class="fa fa-phone-alt text-primary mr-3"></i>+84 345 67890</p>
                </div>
                <!-- <div class="d-flex flex-column">
                    <h5 class="font-weight-semi-bold mb-3">Store 2</h5>
                    <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>123 Street, New York, USA</p>
                    <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@example.com</p>
                    <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+84 345 67890</p>
                </div> -->
            </div>
        </div>
    </div>
    <!-- Contact End -->
@endsection



@section('slide')
<div class="container-fluid mb-5" style="background-image: url('../img/bgu1.jpg'); background-size: cover; background-position: center;">
    <div class="d-flex flex-column align-items-center justify-content-center" style="height: 410px;">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3" style="color: black; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">Liên hệ</h1>
            <div class="d-inline-flex">
                <p class="m-0" style="color: black; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);"><a href="" style="color: black; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">Home</a></p>
                <p class="m-0 px-2" style="color: black; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">-</p>
                <p class="m-0" style="color: black; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">Liên hệ</p>
            </div>
        </div>
    </div>
</div>
@endsection