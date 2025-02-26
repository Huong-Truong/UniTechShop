<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cấp Lại Mật Khẩu</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
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
        }
        .header h1 {
            margin: 0;
            color: #333333;
            font-size: 24px;
        }
        .content {
            padding: 20px;
        }
        .content p {
            margin: 0 0 15px;
            color: #555555;
            line-height: 1.6;
        }
        .content .password {
            font-size: 20px;
            font-weight: bold;
            color: #333333;
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }
        .footer {
            text-align: center;
            padding: 20px 0;
            border-top: 2px solid #dddddd;
            color: #777777;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Cấp Lại Mật Khẩu</h1>
        </div>
        <div class="content">
            <p>Chào bạn,
            </p>
            <p>Mật khẩu của bạn đã được cấp lại. Đây là mật khẩu mới của bạn:</p>
            <p class="password">
            <?php 
                echo Session::get("new_pass");
                Session::put('new_pass',null);
            ?>
            </p>
            <p>Vui lòng sử dụng mật khẩu mới này để đăng nhập và nhớ thay đổi mật khẩu sau khi đăng nhập.</p>
            <p>Cảm ơn bạn,</p>
            <p>Đội ngũ UniTechShop</p>
        </div>
        <div class="footer">
            <p>&copy; 2025 UniTechShop. Bảo lưu mọi quyền.</p>
        </div>
    </div>
</body>
</html>