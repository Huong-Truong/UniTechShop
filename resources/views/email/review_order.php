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
            padding: 5px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border: 1px solid #d3d3d3;
        }
        .header {
            text-align: center;
            background: darkgray;
            padding: 20px;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
        }
        .content {
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            font-size: 14px;
        }
        .content h4 {
            color: darkgray;
            display: inline; /* Hiển thị inline */
        }
        .content span {
            display: inline-block; /* Hiển thị inline-block */
            margin-left: 10px; /* Khoảng cách giữa tiêu đề và nội dung */
        }
        .footer {
            text-align: center;
            padding: 10px;
            background: #f1f1f1;
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
            <div>
                <h4>Tên người nhận:</h4><span><?php echo $vanchuyen->vanchuyen_nguoinhan ?></span>
            </div>
            <div>
                <h4>Số điện thoại:</h4><span><?php echo $vanchuyen->vanchuyen_sdt ?></span>
            </div>
            <div>
                <h4>Email người nhận:</h4><span><?php echo $vanchuyen->vanchuyen_email ?></span>
            </div>
            <div>
                <h4>Địa chỉ:</h4><span><?php echo $vanchuyen->vanchuyen_diachi ?></span>
            </div>
            <div>
                <h4>Ghi chú đơn hàng:</h4><span><?php echo $vanchuyen->vanchuyen_ghichu ?></span>
            </div>
            <div>
                <h4>Ngày tạo đơn hàng:</h4><span><?php echo $vanchuyen->vanchuyen_ngaytao ?></span>
            </div>

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

            <div>
                <h4>Tổng tiền:</h4><span><?php echo Cart::priceTotal(); ?></span>
            </div> 
            <div>
                <h4>Thuế:</h4><span><?php echo Cart::tax(); ?></span>
            </div>
            <div>
                <h4>Thành tiền:</h4><span><?php echo Cart::total(); ?></span>
            </div>
            <div>
                <h4>Phương thức thanh toán:</h4><span><?php echo Session::get('payment_order') ?></span>
            </div>
            <div>
                <h4>Trạng thái đơn hàng:</h4><span>Đang được xử lý</span>
            </div>
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