@extends('layouts.auth')

@section('content')
<div class="card rounded-3 w-md-550px">

    <div class="card-body p-10 p-lg-20">

        <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="text-center mb-11">
                <h1 class="text-dark fw-bolder mb-3">Confirmação de senha</h1>
                <div class="text-gray-500 fw-semibold fs-6">Informe a sua senha antes de continuar</div>
            </div>

            <div class="fv-row mb-3">
                <input type="password" placeholder="Senha" name="password" required autocomplete="off" class="form-control" />
                @error('password')
                <div class="fv-plugins-message-container invalid-feedback">
                    <div>{{ $message }}</div>
                </div>
                @enderror
            </div>

            <div class="d-grid mb-10">
                <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                    <span class="indicator-label">Acessar</span>
                    <span class="indicator-progress">Aguarde...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>

            <div class="text-gray-500 text-center fw-semibold fs-6">
                <a href="{{ route('register') }}" class="link-primary">Esqueceu a senha?</a>
            </div>

        </form>

    </div>

</div>
@endsection
