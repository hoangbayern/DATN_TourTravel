<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên hệ</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #007BFF;
            color: #fff;
            padding: 10px;
            border-radius: 10px 10px 0 0;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
        }
        .content h2 {
            color: #007BFF;
        }
        .content p {
            margin: 10px 0;
        }
        .footer {
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #aaa;
        }
        .footer a {
            color: #007BFF;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            color: #fff;
            background-color: #007BFF;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .field-label {
            font-weight: bold;
            color: #333;
        }
        .field-value {
            margin: 5px 0;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Thông tin liên hệ</h1>
    </div>
    <div class="content">
        <h2>Chi tiết liên hệ</h2>
        <p class="field-label">Họ và tên:</p>
        <p class="field-value">{{ $validatedData['name'] }}</p>
        <p class="field-label">Email:</p>
        <p class="field-value">{{ $validatedData['email'] }}</p>
        <p class="field-label">Số điện thoại:</p>
        <p class="field-value">{{ $validatedData['phone'] }}</p>
        <p class="field-label">Tin nhắn:</p>
        <p class="field-value">{{ $validatedData['message'] }}</p>
        <a href="mailto:{{ $validatedData['email'] }}" class="btn">Trả lời {{ $validatedData['name'] }}</a>
    </div>
    <div class="footer">
        <p>Bạn nhận được email này vì một form liên hệ đã được gửi từ trang web của bạn.</p>
        <p>Nếu bạn không mong đợi email này, bạn có thể bỏ qua nó một cách an toàn.</p>
    </div>
</div>
</body>
</html>
