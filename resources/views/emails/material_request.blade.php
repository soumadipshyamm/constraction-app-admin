<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Material Request</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 650px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #0056b3;
            color: #ffffff;
            padding: 25px;
            text-align: center;
            font-size: 26px;
            font-weight: bold;
        }

        .content {
            padding: 30px;
            color: #444;
            font-size: 16px;
        }

        .content h3 {
            margin-top: 0;
            color: #0056b3;
            font-size: 18px;
        }

        .details {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            font-size: 15px;
        }

        .details p {
            margin: 8px 0;
        }

        .details strong {
            color: #0056b3;
        }

        .footer {
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #777;
            background-color: #f1f1f1;
            border-top: 1px solid #ddd;
        }

        .action-button {
            display: inline-block;
            margin: 20px 0;
            padding: 12px 25px;
            font-size: 16px;
            color: #fff;
            background-color: #28a745;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }

        .action-button:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            New Material Request
        </div>

        <!-- Content -->
        <div class="content">
            <h3>Hello {{ $data['vendorName'] }},</h3>

            <p>{!! nl2br(e($data['message'])) !!}</p>

            <!-- Request Details -->
            <div class="details">
                <p><strong>Quote ID:</strong> {{ $data['quoteId'] }}</p>
                <p><strong>Material ID:</strong> {{ $data['materialsId'] }}</p>
                <p><strong>Company:</strong> {{ $data['companyName'] }}</p>
                @isset($data['requestedAt'])
                    <p><strong>Requested On:</strong>
                        {{ \Carbon\Carbon::parse($data['requestedAt'])->format('M d, Y \a\t h:i A') }}</p>
                @endisset
            </div>

            <!-- Optional Action Button -->
            @if (isset($data['action_url']) && isset($data['action_text']))
                <p style="text-align: center;">
                    <a href="{{ $data['action_url'] }}" class="action-button">
                        {{ $data['action_text'] }}
                    </a>
                </p>
            @endif

            <p>Thank you,<br><strong>{{ config('app.name', 'Your Company') }}</strong></p>
        </div>

        <!-- Footer -->
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name', 'Your Company') }}. All rights reserved.<br>
            Need help? Contact us at <a href="mailto:support@yourcompany.com"
                style="color: #0056b3; text-decoration: none;">support@yourcompany.com</a>
        </div>
    </div>
</body>

</html>



{{-- <!DOCTYPE html>
<html>

<head>
    <title>New Material Request</title>
</head>

<body>
    <h3>Hello {{ $data['vendorName'] }},</h3>
    <p>{{ $data['message'] }}</p>
    <p><strong>Quote ID:</strong> {{ $data['quoteId'] }}</p>
    <p><strong>Material ID:</strong> {{ $data['materialsId'] }}</p>
    <p><strong>Company:</strong> {{ $data['companyName'] }}</p>
    <br>
    <p>Thank you,</p>
    <p>Your Company</p>
</body>

</html> --}}
