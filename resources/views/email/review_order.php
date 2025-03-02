<?php
    $vc = Session::get('shipping_order');
    $vanchuyen = DB::table('vanchuyen')->where('vanchuyen_id', $vc)->first();
     
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: lightgray;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            /* background: #ffffff; */
            padding: 5px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border: 1px solid #d3d3d3; /* Thêm viền xám nhạt 1px */
           
        }
        .header {
            text-align: center;
            background: darkgray;
            padding: 20px;
            /* border-radius: 8px 8px 0 0; */
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
        }
        .content {
            padding: 20px;
            background: #ffffff; /* Đặt màu nền của content thành trắng */
            border-radius: 8px;
        }
        .content h4 {
            color: darkgray;
        }
        .footer {
            text-align: center;
            padding: 10px;
            background: #f1f1f1;
            /* border-radius: 0 0 8px 8px; */
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2><?php echo Session::get('subject_order')?></h2>
        </div>
        <div class="content">
            <!-- Xong thông tin giao hàng -->
            <h3>Thông tin giao hàng</h3>
            <h4>Tên người nhận:</h4> <p><?php echo $vanchuyen->vanchuyen_nguoinhan ?></p>
            <h4>Số điện thoại</h4> <p><?php echo $vanchuyen->vanchuyen_sdt ?></p>
            <h4>Email người nhận:</h4> <p><?php echo $vanchuyen->vanchuyen_email ?></p>
            <h4>Địa chỉ: </h4> <p><?php echo $vanchuyen->vanchuyen_diachi ?></p>
            <h4>Ghi chú đơn hàng: </h4> <p><?php echo $vanchuyen->vanchuyen_ghichu ?></p>
            <h4>Ngày tạo đơn hàng: </h4> <p><?php echo $vanchuyen->vanchuyen_ngaytao ?></p>

            <!-- Giỏ hàng + sản phẩm -->
            <?php 
                $content = Cart::content();
            ?>

                <table border="1">
                    <thead>
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($content as $v_content): ?>
                        <tr>
                            <td><?php echo $v_content->name; ?></td>
                            <td><?php echo number_format($v_content->price) . ' VNĐ'; ?></td>
                            <td><?php echo $v_content->qty; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            <h4>Tổng tiền:</h4> <p><?php echo Cart::priceTotal(); ?></p>
            <h4>Thuế:</h4> <p><?php echo Cart::tax(); ?></p>
            <h4>Thành tiền:</h4> <p><?php echo Cart::total(); ?></p>
            <h4>Phương thức thanh toán: </h4> <p><?php echo Session::get('payment_order') ?></p>
            <h4>Trạng thái đơn hàng </h4> <p> Đang được xử lý</p>
        </div>
        <div class="footer">
           <p>Cảm ơn đã đặt hàng, chúng tôi sẽ giao đến bạn trong thời gian sớm nhất</p>
        </div>
    </div>
</body>
</html>


<?php 

        Session()->forget('shipping_order');
        Session()->forget('subject_order');
        Session()->forget('payment_order');
        Cart::destroy();
        Session()->forget('dichvu');
?>