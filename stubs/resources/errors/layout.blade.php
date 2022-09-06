<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>{{ config('app.name', 'Laravel') }}@yield('title')</title>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="/assets/metronic/media/logos/favicon.ico" />
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    
    <link href="{{ asset('assets/metronic/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/metronic/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />

    @yield('css')

</head>
<body data-kt-name="metronic" id="kt_body" class="app-blank app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
    <!--begin::Theme mode setup on page load-->
    <script>if ( document.documentElement ) { const defaultThemeMode = "system"; const name = document.body.getAttribute("data-kt-name"); let themeMode = localStorage.getItem("kt_" + ( name !== null ? name + "_" : "" ) + "theme_mode_value"); if ( themeMode === null ) { if ( defaultThemeMode === "system" ) { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } else { themeMode = defaultThemeMode; } } document.documentElement.setAttribute("data-theme", themeMode); }</script>
    <!--end::Theme mode setup on page load-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Page bg image-->
        <style>body { background-image: url('/assets/metronic/media/auth/bg9.jpg'); } [data-theme="dark"] body { background-image: url('/assets/metronic/media/auth/bg9-dark.jpg'); }</style>
        <!--end::Page bg image-->
        <!--begin::container -->
        <div class="d-flex flex-column flex-center flex-column-fluid">

            @yield('content')

        </div>
        <!--end::container -->
    </div>
    <!--begin::Root -->

    <script src="{{ asset('/assets/metronic/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('/assets/metronic/js/scripts.bundle.js') }}"></script>
    
    @yield('scripts')
</body>
</html>
