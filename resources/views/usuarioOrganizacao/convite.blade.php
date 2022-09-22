@extends('layouts.auth')

@section('content')
<div class="card rounded-3 w-md-550px">

    <div class="card-body p-10 p-lg-20">

        <form method="POST" action="{{ route('usuario.convite.add.usuario') }}" class="form w-100" novalidate="novalidate">
            @csrf
            <input type="hidden" name="invitation" value="{{$userInvitation->id}}">

            <div class="text-center mb-11">
                <h1 class="text-dark fw-bolder mb-3">Dados de Acesso</h1>
                <div class="text-gray-500 fw-semibold fs-6">Defina suas credencias para acessar o sistema</div>
            </div>

            <div class="fv-row mb-8">
                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                    <span class="required">Nome</span>
                </label>
                <input type="text" placeholder="Nome" name="name" value="{{ old('name', $userInvitation->name) }}" required autocomplete="nome" autofocus class="form-control">
                @error('name')
                <div class="fv-plugins-message-container invalid-feedback">
                    <div>{{ $message }}</div>
                </div>
                @enderror
            </div>

            <div class="fv-row mb-8">
                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                    <span class="required">E-mail</span>
                </label>
                <input type="email" placeholder="E-mail" value="{{ $userInvitation->email }}" autocomplete="off" class="form-control" disabled/>
                @error('email')
                <div class="fv-plugins-message-container invalid-feedback">
                    <div>{{ $message }}</div>
                </div>
                @enderror
            </div>

            <div class="fv-row mb-8">
                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                    <span class="required">Senha</span>
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
                <input type="password" placeholder="Confirmação de senha" name="password_confirmation" type="password" autocomplete="off" class="form-control" />
            </div>

            <div class="fv-row mb-8">
                <label class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="terms" value="1" />
                    <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">Eu aceito os <a href="#" class="ms-1 link-primary">Termos e condições</a></span>
                </label>
                @error('terms')
                <div class="fv-plugins-message-container invalid-feedback">
                    <div>{{ $message }}</div>
                </div>
                @enderror
            </div>

            <div class="d-grid mb-10">
                <button type="submit" id="kt_sign_up_submit" class="btn btn-primary">
                    <span class="indicator-label">Criar conta</span>
                    <span class="indicator-progress">Aguarde...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
            <div class="text-gray-500 text-center fw-semibold fs-6">
                Já possui uma conta? <a href="{{ route('login') }}" class="link-primary fw-semibold">Fazer Login</a>
            </div>

        </form>

    </div>

</div>
@endsection
