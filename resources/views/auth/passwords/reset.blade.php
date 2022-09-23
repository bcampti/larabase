@extends('layouts.auth')

@section('content')
<div class="card rounded-3 w-md-550px">

    <div class="card-body p-10 p-lg-20">

        <form class="form w-100" novalidate="novalidate" method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="text-center mb-10">
                <h1 class="text-dark fw-bolder mb-3">Criar nova senha</h1>
                <div class="text-gray-500 fw-semibold fs-6">Já criou um senha nova ? <a href="{{ route('login') }}" class="link-primary fw-bold">Fazer Login</a></div>
            </div>

            <div class="fv-row mb-8">
                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                    <span class="required">E-mail</span>
                </label>
                <input type="email" name="email" value="{{ $email }}" autocomplete="off" class="form-control" readonly/>
                @error('email')
                <div class="fv-plugins-message-container invalid-feedback">
                    <div>{{ $message }}</div>
                </div>
                @enderror
            </div>

            <div class="fv-row mb-8">
                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                    <span class="required">Confirmação de senha</span>
                </label>
                <input class="form-control" type="password" placeholder="Senha" name="password" autocomplete="off" />
                <div class="text-muted">Utilize uma senha com pelo menos 8 caracteres.</div>
                @error('password')
                <div class="fv-plugins-message-container invalid-feedback">
                    <div>{{ $message }}</div>
                </div>
                @enderror
            </div>

            <div class="fv-row mb-8">
                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                    <span class="required">Confirmação de senha</span>
                </label>
                <input type="password" placeholder="Confirmação de senha" name="password_confirmation" autocomplete="off" class="form-control" />
            </div>
            
            <div class="d-grid mb-10">
                <button type="submit" class="btn btn-primary">
                    <span class="indicator-label">Alterar senha</span>
                    <span class="indicator-progress">Aguarde...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>

        </form>

    </div>

</div>
@endsection
