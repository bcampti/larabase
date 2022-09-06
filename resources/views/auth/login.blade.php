@extends('layouts.auth')

@section('content')
    <div class="card rounded-3 w-md-550px">

        <div class="card-body p-10 p-lg-20">

            <form method="POST" action="{{ route('login') }}" class="form w-100" novalidate="novalidate" id="kt_sign_in_form">
                @csrf

                <div class="text-center mb-11">
                    <h1 class="text-dark fw-bolder mb-3">Login</h1>
                    <div class="text-gray-500 fw-semibold fs-6">Acessar o sistema</div>
                </div>

                <div class="fv-row mb-8 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                    <input type="email" placeholder="E-mail" name="email" value="{{ old('email') }}" required autocomplete="email" class="form-control">
                    @error('email')
                    <div class="fv-plugins-message-container invalid-feedback">
                        <div>{{ $message }}</div>
                    </div>
                    @enderror
                </div>
        
                <div class="fv-row mb-3">
                    <input type="password" placeholder="Senha" name="password" required autocomplete="off" class="form-control" />
                    @error('password')
                    <div class="fv-plugins-message-container invalid-feedback">
                        <div>{{ $message }}</div>
                    </div>
                    @enderror
                </div>

                <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                    <div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Lembre-me
                            </label>
                        </div>
                    </div>
                    <a href="{{ route('password.request') }}" class="link-primary">
                        Esqueceu sua senha?
                    </a>
                </div>

                <div class="d-grid mb-10">
                    <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                        <span class="indicator-label">Acessar</span>
                        <span class="indicator-progress">Aguarde...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>

            </form>

        </div>

    </div>
@endsection