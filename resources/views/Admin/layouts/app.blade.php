<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('Admin.layouts.partials.header')

<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        @include('Admin.layouts.partials.navbar')
        <div class="app-main">
            @include('Admin.layouts.partials.sidebar')
            @yield('content')
            <x-modals.admin.update-password/>
        </div>
    </div>
    @include('Admin.layouts.partials._footer')
    @include('Admin.layouts.partials.footer')
    @include('Admin.layouts.include')
</body>

</html>
