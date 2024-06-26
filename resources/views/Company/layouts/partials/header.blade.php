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
    <meta name="description" content="ArchitectUI">
    <meta name="msapplication-tap-highlight" content="no">

    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"> --}}

    <link rel="stylesheet" href="{{ asset('company_assets/css/bootstrap.min.css') }}">
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}

    <!-- animation css -->
    <link rel="stylesheet" href="{{ asset('company_assets/css/animate.css') }}">
    <!-- stellarnav css -->
    <link rel="stylesheet" href="{{ asset('company_assets/css/stellarnav.css') }}">
    <!-- owl carousel css -->
    <link rel="stylesheet" href="{{ asset('company_assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('company_assets/css/owl.theme.default.min.css') }}">
    <!-- dashboard css -->
    <link rel="stylesheet" href="{{ asset('company_assets/css/main.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('company_assets/css/dhtmlxgantt.css') }}"> --}}
    <!-- handsontable -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" />
    <!-- font family -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <!-- custom css -->
    <link rel="stylesheet" href="{{ asset('company_assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('company_assets/css/responsive.css') }}">
    <!-- fav icon -->
    <link rel="shortcut icon" href="{{ asset('company_assets/images/fav-icon.ico') }}">
    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" />

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Include Bootstrap CSS -->

    <!-- Include Select2 CSS -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"> --}}

    @stack('styles')
</head>
