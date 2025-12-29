<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('Admin.auth.layouts.partials.header')

<body>
    <div class="app-container app-theme-white body-tabs-shadow">
        <div class="app-container">
            @yield('content')
        </div>
    </div>
    @include('Admin.auth.layouts.partials._footer')
</body>

</html>
