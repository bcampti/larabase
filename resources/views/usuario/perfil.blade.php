@extends('layouts.app')

@section('content')
<!--begin::Content-->
<div id="kt_app_content" class="app-content flex-column-fluid pt-10">
	<!--begin::Content container-->
	<div id="kt_app_content_container" class="app-container container-fluid">

        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6 col-xxl-6">
                
                <div class="card card-shadow">

                    <div class="card-header">
                        <h3 class="card-title fw-bold">Perfil de Usuário</h3>
                    </div>

                    <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="POST" action="{{ route('usuario.perfil.update') }}">
                        @csrf
                        
                        <div class="card-body">

                            <div class="row mb-0">
                                <label class="col-lg-3 col-form-label fw-semibold fs-6">Nome:</label>
                                <div class="col-lg-9 fv-row fv-plugins-icon-container">
                                    <input type="text" class="form-control form-control-sm" name="name" value="{{ $user->name }}">
                                    @error('name')
                                    <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-0">
                                <label class="col-lg-3 col-form-label fw-semibold fs-6">E-mail:</label>
                                <div class="col-lg-9 fv-row fv-plugins-icon-container">
                                    <input type="text" readonly class="form-control form-control-sm" value="{{$user->email}}">
                                </div>
                            </div>

                        </div>

                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <button type="reset" class="btn btn-light btn-active-light-primary me-2">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>

                    </form>

                </div>

            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-xl-6 col-xxl-6">

                <div class="card card-shadow">

                    <div class="card-header">
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0">Segurança</h3>
                        </div>
                    </div>

                    <form class="form fv-plugins-bootstrap5 fv-plugins-framework" method="POST" action="{{ route('usuario.perfil.update.password') }}">
                        @csrf
                        <div class="card-body">
                        
                            <div class="row mb-0">
                                <label class="col-lg-4 col-form-label fw-semibold fs-6 required">Senha Atual:</label>
                                <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                    <input type="password" class="form-control form-control-sm" name="current_password">
                                    @error('current_password')
                                    <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <label class="col-lg-4 col-form-label fw-semibold fs-6 required">Nova Senha:</label>
                                <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                    <input type="password" class="form-control form-control-sm" name="password" autocomplete="off"/>
                                    <div class="text-muted">Utilize uma senha com pelo menos 8 caracteres.</div>
                                    @error('password')
                                    <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <label class="col-lg-4 col-form-label fw-semibold fs-6 required">Confirmação de senha:</label>
                                <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                    <input type="password" class="form-control form-control-sm" name="password_confirmation" autocomplete="off"/>
                                    @error('password_confirmation')
                                    <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <button type="reset" class="btn btn-light btn-active-light-primary me-2">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Atualizar Senha</button>
                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>
@endsection