<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="/assets/metronic/media/logos/favicon.ico" />
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    
    <link href="{{ asset('assets/metronic/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/metronic/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />

    @yield('css')

</head>
<body data-kt-name="metronic" id="kt_body" class="app-blank app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
    <!--begin::Theme mode setup on page load-->
    <script>
        if ( document.documentElement ) { const defaultThemeMode = "system"; const name = document.body.getAttribute("data-kt-name"); let themeMode = localStorage.getItem("kt_" + ( name !== null ? name + "_" : "" ) + "theme_mode_value"); if ( themeMode === null ) { if ( defaultThemeMode === "system" ) { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } else { themeMode = defaultThemeMode; } } document.documentElement.setAttribute("data-theme", themeMode); }
    </script>
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <style>body {background-image: url('/assets/metronic/media/auth/bg4.jpg');}[data-theme="dark"] body {background-image: url('/assets/metronic/media/auth/bg4-dark.jpg');}
        </style>
        <div class="d-flex flex-column flex-column-fluid flex-lg-row">
            
            <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">

                <div class="d-flex flex-column">

                    <a href="{{ route('home') }}" class="mb-7">
                        <img alt="Logo" src="/assets/metronic/media/logos/custom-3.svg" />
                    </a>

                    <h2 class="text-white fw-normal m-0">Branding tools designed for your business</h2>

                </div>

            </div>

            <div class="d-flex flex-center w-lg-50 p-10">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="{{ asset('/assets/metronic/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('/assets/metronic/js/scripts.bundle.js') }}"></script>
    
    @yield('scripts')

</body>
</html>
