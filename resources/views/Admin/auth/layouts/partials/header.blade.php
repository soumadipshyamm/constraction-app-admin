<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @if (config('app.env') !== 'production')
    <meta name="robots" content="noindex, nofollow">
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Koncite - {{ $pageTitle ?? '' }}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="ArchitectUI HTML Bootstrap 4 Dashboard Template">
    <meta name="msapplication-tap-highlight" content="no">
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
    @stack('styles')
</head>
