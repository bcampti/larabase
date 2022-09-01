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
    <link href="{{ asset('assets/metronic/css/custom.css') }}" rel="stylesheet" type="text/css" />

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
            @include('layouts.partials.header')
            <!-- end:: Header -->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <!-- begin:: Menu -->
                @include('layouts.partials.menu')
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

    <script type="text/javascript" src="{{ asset('assets/metronic/plugins/global/plugins.bundle.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/metronic/js/scripts.bundle.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/metronic/plugins/maskMoney/jquery.maskMoney.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('components/app-base.js') }}"></script>
    <script type="text/javascript" src="{{ asset('components/app-mensagem.js') }}"></script>
    <script type="text/javascript" src="{{ asset('components/app-controller.js') }}"></script>
    <script type="text/javascript" src="{{ asset('components/bootstrap3-typeahead.js') }}"></script>
    <script type="text/javascript" src="{{ asset('components/app-typeahead.js') }}"></script>
    <script type="text/javascript" src="{{ asset('components/app-mask.js') }}"></script>

    <script type="text/javascript">
    $(document).ready(function(){
        Inputmask({ "mask": "999.999.999-99" }).mask("input.cpf");
        $("input.money").maskMoney({prefix:' R$ ', suffix:'', thousands:'.', decimal:',', precision:2 , allowZero:true, affixesStay:true, allowNegative:false});
        $("input.integer").maskMoney({prefix:'', suffix:'', thousands:'', decimal:',', precision:0 , allowZero:true, affixesStay:true, allowNegative:false});
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
