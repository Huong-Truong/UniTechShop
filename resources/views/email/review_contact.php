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
            <h2>Ý kiến khách hàng</h2>
        </div>
        <div class="content">
            <h4>Họ và tên:</h4>
            <p><?php echo Session::get('tengui') ?></p>
            <h4>Nội dung góp ý:</h4>
            <p><?php echo Session::get('content') ?></p>
        </div>
        <div class="footer">
            <p>Ý kiến của khách hàng <?php echo Session::get('mailgui') ?></p>
        </div>
    </div>
</body>
</html>


<?php 

        session()->forget('subject');
        session()->forget('content');
        session()->forget('mailgui');
        session()->forget('tengui');
     

?>
