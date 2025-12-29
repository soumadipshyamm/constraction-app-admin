<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('Company.layouts.partials.header')

<body>
    @include('Company.layouts.partials.navbar')
    <section class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <div class="app-main">

            @include('Company.layouts.partials.sidebar')
            @yield('content')
        </div>
    </section>
    {{-- @include('Company.layouts.partials.footer') --}}
    @include('Company.layouts.partials._footer')
    @include('Company.layouts.include')
</body>

</html>
