<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phiếu Xác Nhận Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            background-color: #fff;
            margin: 0 auto;
            padding: 20px;
            max-width: 600px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #c5ffff;
            text-align: center;
            border: 5px solid green;
            border-radius: 10px;
            padding: 15px;
        }
        .header h4 {
            margin: 0;
            font-size: 18px;
            line-height: 1.5;
        }
        .content {
            margin-top: 20px;
        }
        .content h2 {
            color: #333;
            font-size: 24px;
        }
        .content h2 b {
            border: 1px solid red;
            color: red;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 18px;
        }
        .content p {
            font-size: 16px;
            line-height: 1.6;
            margin: 5px 0;
        }
        .highlight {
            background-color: #ddd;
            margin-top: 8px;
            padding: 10px;
            border-radius: 10px;
        }
        .highlight p {
            margin-left: 8px;
            margin: 5px 0;
        }
        .highlight .important {
            color: red;
            font-weight: bold;
        }
        .footer {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h4>Cảm ơn quý khách đã sử dụng dịch vụ của chúng tôi,<br>Booking của quý khách đã được chúng tôi xác nhận thành công</h4>
    </div>
    <div class="content">
        <h2>Phiếu xác nhận booking <b>CHƯA THANH TOÁN</b></h2>
        <p>Mã tour: <b>{{ $bookTour->b_tour_id }}</b></p>
        <p>Tên tour: <b>{{ $tour->t_title }}</b></p>
        {{-- <p>Ngày đi: <b>{{ $bookTour->b_start_date }}</b></p> --}}
        <p>Điểm khởi hành: <b>{{ $bookTour->b_address }}</b></p>
        <div class="highlight">
            <p>Mã booking: <b class="important">{{ $bookTour->id }}</b></p>
            <p class="important">Xin quý khách vui lòng nhớ số booking để thuận tiện cho giao dịch sau này</p>
            @php
                $totalPrice = ($bookTour->b_number_adults * $bookTour->b_price_adults) + ($bookTour->b_number_children * $bookTour->b_price_children);
            @endphp
            <p>Trị giá booking: <b>{{ number_format($totalPrice, 0, ',', '.') }} vnd</b></p>
            <p>Ngày booking: <b>{{ $bookTour->created_at }}</b></p>
            <p>Ngày xác nhận: <b>{{ $bookTour->updated_at }}</b></p>
            <p>Thời hạn thanh toán: <b>7 ngày sau xác nhận</b></p>
            <p class="important">Nếu quá thời hạn trên, quý khách chưa thanh toán, BamBoo Tour sẽ huỷ booking này</p>
        </div>
        <div class="footer">
            <p>Họ tên: <b>{{ $user->name }}</b></p>
            <p>Email: <b>{{ $user->email }}</b></p>
            <p>Số điện thoại: <b>{{ $user->phone }}</b></p>
            <p>Địa chỉ: <b>{{ $user->address }}</b></p>
        </div>
        <div class="highlight">
            <p>Người lớn: <b>{{ $bookTour->b_number_adults }}</b> Trẻ em: <b>{{ $bookTour->b_number_children }}</b></p>
        </div>
    </div>
</div>
</body>
</html>
