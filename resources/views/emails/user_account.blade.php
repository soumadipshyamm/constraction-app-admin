<!-- resources/views/emails/email_template.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['subject'] ?? 'Welcome to Your Account' }}</title>
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
            background-color: #007bff;
            color: #ffffff;
            padding: 25px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }

        .content {
            padding: 30px;
            color: #444;
            font-size: 16px;
        }

        .content h1 {
            margin: 0 0 15px 0;
            font-size: 22px;
            color: #007bff;
        }

        .content p {
            margin: 0 0 15px 0;
        }

        .credentials-box {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 20px;
            margin: 20px 0;
        }

        .credentials-item {
            margin: 10px 0;
            padding: 5px 0;
        }

        .credentials-label {
            font-weight: bold;
            color: #495057;
        }

        .app-link {
            background-color: #28a745;
            color: #ffffff;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 6px;
            display: inline-block;
            margin: 20px 0;
            font-weight: bold;
        }

        .footer {
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #999;
            background-color: #f9f9f9;
            border-top: 1px solid #eee;
        }

        .highlight {
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 10px 15px;
            margin: 20px 0;
            font-style: italic;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            {{ config('app.name', 'YourApp') }}
        </div>

        <!-- Content -->
        <div class="content">
            <h1>Welcome, {{ $data['name'] ?? 'User' }}!</h1>

            <p>Your account has been successfully created. Below are your account details:</p>

            <div class="credentials-box">
                <div class="credentials-item">
                    <span class="credentials-label">Name:</span> {{ $data['name'] ?? 'Not provided' }}
                </div>
                <div class="credentials-item">
                    <span class="credentials-label">Username:</span> {{ $data['email'] ?? 'Not provided' }}
                </div>
                <div class="credentials-item">
                    <span class="credentials-label">Password:</span> {{ $data['password'] ?? 'Not provided' }}
                </div>
            </div>

            <p>To access your account, click the button below:</p>

            <p style="text-align: center;">
                <a href="https://play.google.com/store/apps/details?id=com.koncite&pcampaignid=app_share&pli=1"
                    class="app-link">
                    <i class="fa-brands fa-android"></i> android
                </a>
                <a href="https://apps.apple.com/in/app/koncite/id6745020825" class="app-link">
                    <i class="fa-brands fa-apple"></i> iOS
                </a>
            </p>

            <div class="highlight">
                <p>For security reasons, we recommend changing your password after your first login.</p>
                <p>If you have any questions, feel free to contact our support team.</p>
            </div>

            <p>Thank you for joining us!<br><strong>{{ config('app.name') }}</strong></p>
        </div>

        <!-- Footer -->
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name', 'YourApp') }}. All rights reserved.<br>
            Need help? <a href="mailto:info@koncite.com" style="color: #007bff; text-decoration: none;">Contact
                Support</a>
        </div>
    </div>
</body>

</html>
