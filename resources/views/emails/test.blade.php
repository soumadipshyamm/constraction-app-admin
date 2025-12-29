   <!-- resources/views/emails/email_template.blade.php -->
   <!DOCTYPE html>
   <html lang="en">

   <head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <title>Email Notification</title>
   </head>

   <body>
       <h1>Hello, {{ $data['name'] ?? 'Konsite' }}</h1>
       <p>{{ $data['message'] ?? 'Messaheeee' }}</p>
       <p>Thank you!</p>
   </body>

   </html>
