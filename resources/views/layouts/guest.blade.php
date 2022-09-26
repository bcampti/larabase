<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="/assets/media/logos/favicon.ico" />
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    
    @include('layouts.partials.theme.styles')
    <style>
        .form-control:disabled, .form-control[readonly] {
        color: var(--kt-input-disabled-color)!important;
        background-color: var(--kt-input-disabled-bg)!important;
        border-color: var(--kt-input-disabled-border-color)!important;
        }
    </style>
    @yield('css')

</head>
<body data-kt-name="metronic" id="kt_body" class="app-blank app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
    <!--begin::Theme mode setup on page load-->
    <script>
        if ( document.documentElement ) { const defaultThemeMode = "system"; const name = document.body.getAttribute("data-kt-name"); let themeMode = localStorage.getItem("kt_" + ( name !== null ? name + "_" : "" ) + "theme_mode_value"); if ( themeMode === null ) { if ( defaultThemeMode === "system" ) { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } else { themeMode = defaultThemeMode; } } document.documentElement.setAttribute("data-theme", themeMode); }
    </script>
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <style>body {background-image: url('/assets/media/auth/bg4.jpg');}[data-theme="dark"] body {background-image: url('/assets/media/auth/bg4-dark.jpg');}
        </style>
        <div class="d-flex flex-column flex-center flex-column-fluid">
            @yield('content')
        </div>
    </div>

    @include('layouts.partials.theme.scripts')
    
    @yield('scripts')

</body>
</html>
