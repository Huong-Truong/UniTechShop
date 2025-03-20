<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thông báo vi phạm tiêu chuẩn bình luận</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 2px solid #dddddd;
            background-color:#ffffff;
        }

        .header h2 {
            margin: 0;
            color: #333333;
            font-size: 24px;
        }
        .content {
            padding: 20px;
        }
        .footer {
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Thông báo vi phạm tiêu chuẩn bình luận</h2>
        </div>
        <div class="content">
            <p>Xin chào,</p>
            <p>Chúng tôi muốn thông báo rằng người dùng <strong> <?php echo Session::get('ten');?></strong> đã vi phạm tiêu chuẩn khi bình luận:</p>
            <blockquote>
            "<?php echo Session::get('nd');?>" <br> Thời gian: <?php echo Session::get('ngay');?>
            </blockquote>
            <p>Chúng tôi xin phép được xóa bình luận của bạn vì nhận thấy từ ngữ không phù hợp.</p>
            <p>Trân trọng,</p>
            <p>Đội ngũ quản trị</p>
        </div>
        <div class="footer">
            <p>Email này được gửi tự động, vui lòng không trả lời email này.</p>
        </div>
    </div>
</body>
</html>