<div id="kt_app_header" class="app-header">
    <!-- begin:: Header Container -->
    <div class="app-container container-fluid d-flex align-items-stretch justify-content-between">

        <!-- begin::sidebar mobile -->
        <div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show sidebar menu">
            <div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
                <span class="svg-icon svg-icon-1">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="currentColor"></path>
                        <path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="currentColor"></path>
                    </svg>
                </span>
            </div>
        </div>
        <!-- end::sidebar mobile -->
        <!-- begin:: Logo mobile -->
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <a href="{{ route('home') }}" class="d-lg-none">
                <img alt="Logo" src="/assets/media/logos/default-small.svg" class="h-30px">
            </a>
        </div>
        <!-- end:: Logo mobile -->
        <!-- begin:: Header Menu -->
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
            <!--begin::Menu wrapper-->
            <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="{default: 'append', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
                
            </div>
            <!--end::Menu wrapper-->
            <!-- begin:: Navbar -->
            <div class="app-navbar flex-shrink-0">

                <div class="app-navbar-item ms-1 ms-lg-3" id="kt_header_user_menu_toggle">

                    <div class="cursor-pointer symbol symbol-35px symbol-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                        <img alt="Logo" src="https://ui-avatars.com/api/?background=1c63a0&color=fff&name={{auth()->user()->name}}">
                    </div>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3">
                                <div class="symbol symbol-50px me-5">
                                    <img alt="Logo" src="https://ui-avatars.com/api/?background=1c63a0&color=fff&name={{auth()->user()->name}}">
                                </div>
                                <div class="d-flex flex-column">
                                    <div class="fw-bold d-flex align-items-center fs-5">
                                        {{ auth()->user()->name }}
                                    </div>
                                    <a href="{{route('usuario.perfil')}}" class="fw-semibold text-muted text-hover-primary fs-7">{{ auth()->user()->email }}</a>
                                </div>
                            </div>
                        </div>

                        <div class="separator my-2"></div>

                        <div class="menu-item px-5">
                            <a href="{{route('usuario.perfil')}}" class="menu-link px-5">Meu Usuário</a>
                        </div>

                        <div class="separator my-2"></div>

                        <div class="menu-item px-5">
                            <a href="{{route('auth.account.organizacao.index')}}" class="menu-link px-5">Organizações</a>
                        </div>

                        @hasSuporte
                        <div class="menu-item px-5">
                            <a href="{{route('account.index')}}" class="menu-link px-5">Accounts</a>
                        </div>
                        @endhasSuporte

                        <div class="separator my-2"></div>

                        <div class="menu-item px-5">
                            <form id="formLogout" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <a onclick="document.getElementById('formLogout').submit()" type="submit" class="menu-link px-5">Sair</a>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="app-navbar-item d-lg-none ms-2 me-n3" title="Show header menu">
                </div>
            </div>
            <!-- end:: Navbar -->
        </div>
        <!-- end:: Header Menu -->
    </div>
</div>