@extends('layouts.auth')

@section('content')
<div class="card rounded-3 w-md-550px">

    <div class="card-body p-10 p-lg-20">

        <form class="form w-100" novalidate="novalidate" id="kt_password_reset_form" method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="text-center mb-10">
                <h1 class="text-dark fw-bolder mb-3">Esqueceu a senha ?</h1>
                <div class="text-gray-500 fw-semibold fs-6">Informe o seu e-mail para recuperar o acesso.</div>
            </div>

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
    
            <div class="fv-row mb-8 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                    <span class="required">E-mail</span>
                </label>
                <input type="text" placeholder="E-mail" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus class="form-control" />
                @error('email')
                <div class="fv-plugins-message-container invalid-feedback">
                    <div>{{ $message }}</div>
                </div>
                @enderror
            </div>

            <div class="d-flex flex-wrap justify-content-center pb-lg-0">
                <button type="submit" id="kt_password_reset_submit" class="btn btn-primary me-4">
                    <span class="indicator-label">Enviar</span>
                    <span class="indicator-progress">Aguarde...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <a href="{{ route('login') }}" class="btn btn-light">Cancelar</a>
            </div>

        </form>

    </div>

</div>
@endsection