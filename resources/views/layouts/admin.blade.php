<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>{{ config('app.name', 'Laravel') }}@yield('title')</title>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="/assets/media/logos/favicon.ico" />
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    
    @include('layouts.partials.theme.styles')

    @yield('css')

</head>
<body data-kt-name="metronic" 
    id="kt_app_body" 
    data-kt-app-page-loading-enabled="true" 
    data-kt-app-layout="dark-sidebar" 
    data-kt-app-header-fixed="true" 
    data-kt-app-sidebar-enabled="true" 
    data-kt-app-sidebar-fixed="true" 
    data-kt-app-sidebar-hoverable="true" 
    data-kt-app-sidebar-push-header="true" 
    data-kt-app-sidebar-push-toolbar="true" 
    data-kt-app-sidebar-push-footer="true" 
    class="app-default">

    <script>if ( document.documentElement ) { const defaultThemeMode = "system"; const name = document.body.getAttribute("data-kt-name"); let themeMode = localStorage.getItem("kt_" + ( name !== null ? name + "_" : "" ) + "theme_mode_value"); if ( themeMode === null ) { if ( defaultThemeMode === "system" ) { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } else { themeMode = defaultThemeMode; } } document.documentElement.setAttribute("data-theme", themeMode); }</script>

    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">

        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <!-- begin:: Header -->
            @include('layouts.partials.admin.header')
            <!-- end:: Header -->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                
                <!-- begin:: Menu -->
                @include('layouts.partials.admin.menu')
                <!-- end:: Menu -->
                <!-- begin:: Main -->
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">

                    <!--begin::Content wrapper-->
                    <div class="d-flex flex-column flex-column-fluid">
                        
                        @yield('content')
                        
                    </div>
                    <!--end::Content wrapper-->
                </div>
                <!-- end:: Main -->
            </div>

        </div>

    </div>

    @include('layouts.partials.theme.scripts')

    <script type="text/javascript">
    $(document).ready(function(){
        Inputmask({ "mask": "999.999.999-99" }).mask("input.cpf");
        Array.prototype.filter.call(document.getElementsByClassName('text-uppercase'), function(input) {
            $(input).keyup(function() {
                this.value = this.value.toLocaleUpperCase();
            });
        });
    });
    </script>

    @include('layouts.partials.message')

    @yield('script')

</body>
</html>
