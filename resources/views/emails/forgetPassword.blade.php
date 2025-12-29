<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
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
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #dc3545;
            color: #ffffff;
            padding: 25px;
            text-align: center;
            font-size: 26px;
            font-weight: bold;
        }

        .content {
            padding: 30px;
            text-align: center;
        }

        .content p {
            margin: 15px 0;
            font-size: 16px;
        }

        .btn {
            display: inline-block;
            padding: 14px 30px;
            margin: 20px 0;
            font-size: 18px;
            font-weight: bold;
            color: #ffffff;
            background-color: #28a745;
            text-decoration: none;
            border-radius: 6px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn:hover {
            background-color: #218838;
        }

        .note {
            font-size: 14px;
            color: #6c757d;
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }

        .footer {
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #888;
            background-color: #f9f9f9;
            border-top: 1px solid #eee;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            Reset Your Password
        </div>

        <!-- Content -->
        <div class="content">
            <h2>Forgot Your Password?</h2>
            <p>We received a request to reset your password. No worries — you can set a new one using the link below.
            </p>

            <!-- Reset Password Button -->
            <a href="{{ route('company.reset.password.get', $token) }}" class="btn">
                Reset Password
            </a>

            <p><strong>Note:</strong> This link will expire in <strong>10 minutes</strong>. If you didn’t request a
                password reset, please ignore this email.</p>

            <div class="note">
                For security reasons, do not share this email or link with anyone.
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name', 'YourApp') }}. All rights reserved.
        </div>
    </div>
</body>

</html>
