<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #007bff;
            color: #ffffff;
            padding: 20px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }

        .content {
            padding: 30px;
            text-align: center;
            line-height: 1.6;
        }

        .otp-box {
            display: inline-block;
            padding: 15px 25px;
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 3px;
            background-color: #f0f8ff;
            border: 2px dashed #007bff;
            border-radius: 8px;
            color: #007bff;
            margin: 20px 0;
        }

        .footer {
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #888;
            background-color: #f9f9f9;
            border-top: 1px solid #eee;
        }

        .note {
            font-size: 14px;
            color: #d9534f;
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            Verify Your Account
        </div>

        <!-- Content -->
        <div class="content">
            <h2>Enter the OTP below to verify your account</h2>
            <p>We received a request to register your account. Use the one-time password (OTP) below to complete the
                process.</p>

            <!-- OTP Code -->
            <div class="otp-box">
                {{ $otp }}
            </div>

            <p>This code is valid for <strong>10 minutes</strong>. Do not share it with anyone.</p>

            <div class="note">
                <strong>Note:</strong> If you didn’t request this, please ignore this email.
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name', 'YourApp') }}. All rights reserved.
        </div>
    </div>
</body>

</html>
