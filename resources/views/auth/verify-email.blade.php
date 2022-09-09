@extends('layouts.guest')

@section('content')
<div class="d-flex flex-column flex-center text-center p-10">
    <!--begin::Wrapper-->
    <div class="card card-flush w-lg-650px py-5">
        <div class="card-body py-15 py-lg-20">
            <!--begin::Logo-->
            <div class="mb-14">
                <a href="{{ route('home') }}" class="">
                    <img alt="Logo" src="/assets/media/logos/custom-2.svg" class="h-40px">
                </a>
            </div>
            <!--end::Logo-->
            <!--begin::Title-->
            <h1 class="fw-bolder text-gray-900 mb-5">{{ __('Verify Your Email Address') }}</h1>
            <!--end::Title-->

            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    <h3 class="text-success">{{ __('A fresh verification link has been sent to your email address.') }}</h3>
                </div>
            @endif
            
            <!--begin::Action-->
            <div class="fs-6 mb-8">
                <p class="fw-semibold text-gray-900">{{ __('Before proceeding, please check your email for a verification link.') }}</p>
                <p class="fw-semibold text-gray-900">{{ __('If you did not receive the email') }},
                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-primary">{{ __('click here to request another') }}</button>
                </form>
                </p>
            </div>
            <!--end::Action-->
            <!--begin::Illustration-->
            <div class="mb-0">
                <img src="/assets/media/auth/please-verify-your-email.png" class="mw-100 mh-300px theme-light-show" alt="">
                <img src="/assets/media/auth/please-verify-your-email-dark.png" class="mw-100 mh-300px theme-dark-show" alt="">
            </div>
            <!--end::Illustration-->
        </div>
    </div>
    <!--end::Wrapper-->
</div>
@endsection