<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order - {{ $orderNo }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .email-wrapper {
            width: 100%;
            background-color: #ffffff;
            margin: 0 auto;
            padding: 20px;
            box-sizing: border-box;
            max-width: 600px;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            text-align: center;
            padding: 15px;
            background-color: #28a745;
            color: #ffffff;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .email-header h1 {
            font-size: 22px;
            margin: 0;
        }

        .email-body {
            padding: 20px;
        }

        .email-body p {
            font-size: 16px;
            margin: 15px 0;
            line-height: 1.5;
        }

        .order-info {
            margin-top: 20px;
            width: 100%;
            border-collapse: collapse;
            font-size: 15px;
        }

        .order-info th, .order-info td {
            padding: 10px 15px;
            text-align: left;
        }

        .order-info th {
            background-color: #f5f5f5;
            color: #555;
        }

        .order-info td {
            background-color: #fcfcfc;
            color: #333;
        }

        .btn {
            display: inline-block;
            padding: 12px 25px;
            background-color: #28a745;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
            text-align: center;
        }

        .btn:hover {
            background-color: #218838;
        }

        .email-footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            padding: 20px;
            border-top: 1px solid #e0e0e0;
        }

        .email-footer p {
            margin: 5px 0;
        }

        .icon {
            color: #28a745;
            margin-right: 8px;
        }
    </style>
    <!-- Link to Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

<div class="email-wrapper">
    <div class="email-header">
        <h1><i class="fas fa-file-alt"></i> Purchase Order - {{ $orderNo }}</h1>
    </div>

    <div class="email-body">
        <p><i class="fas fa-user icon"></i>Hello <strong>{{ $supplierName }}</strong>,</p>

        <p><i class="fas fa-info-circle icon"></i>We are pleased to inform you that your Purchase Order has been processed. Below are the details:</p>

        <table class="order-info">
            <tr>
                <th><i class="fas fa-hashtag icon"></i>Order Number</th>
                <td>{{ $orderNo }}</td>
            </tr>
            <tr>
                <th><i class="fas fa-calendar-alt icon"></i>Order Date</th>
                <td>{{ \Carbon\Carbon::parse($orderDate)->translatedFormat('d F Y') }}</td>
            </tr>
        </table>

        <p><i class="fas fa-download icon"></i>You can download the full Purchase Order details by clicking the button below:</p>

        <a href="{{ $downloadLink }}" class="btn"><i class="fas fa-file-pdf"></i> Download PO PDF</a>

        <p>If you have any questions, feel free to contact us.</p>

        <p>Best regards,<br>
        <strong>The Purchase Team</strong></p>
    </div>

    <div class="email-footer">
        <p><i class="fas fa-envelope icon"></i>This is an automated email. Please do not reply.</p>
        <p>© {{ date('Y') }} Your Company Name. All rights reserved.</p>
    </div>
</div>

</body>
</html>
