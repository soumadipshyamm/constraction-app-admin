<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('Frontend.layouts.partials.header')

<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        {{-- @include('layouts.flash') --}}
        @include('Frontend.layouts.partials.navbar')
        <div class="app-main">
            @yield('content')
        </div>
    </div>
    @include('Frontend.layouts.partials.footer')
    @include('Frontend.layouts.partials._footer')
    @include('Frontend.layouts.include')
</body>

</html>
