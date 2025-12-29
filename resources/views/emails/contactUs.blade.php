<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Request for Enquiry</title>
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
{{-- @dd($data) --}}
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            Request for Enquiry
        </div>

        <!-- Content -->
        <div class="content">
            <h3>Hello Admin</h3>


            <!-- Request Details -->
            <div class="details">
                <p><strong>Name:</strong> {{ $data['name'] }}</p>
                <p><strong>email:</strong> {{ $data['email'] }}</p>
                <p><strong>Phone:</strong> {{ $data['phone'] }}</p>
                <p><strong>Subject:</strong> {{ $data['subject'] }}</p>
                <p><strong>Message:</strong> {{ $data['message'] }}</p>
            </div>
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

  {{-- @dd($data) --}}
