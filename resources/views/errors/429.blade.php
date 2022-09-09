@extends('errors.layout')
@section('title', ' - falha na autenticação')

@section('content')
<!--begin::Content-->
<div class="d-flex flex-column flex-center text-center p-10">
    <!--begin::Wrapper-->
    <div class="card card-flush w-lg-650px py-5">
        <div class="card-body py-15 py-lg-20">
            <!--begin::Logo-->
            <div class="mb-13">
                <a href="{{route('home')}}">
                    <img alt="Logo" src="/assets/media/logos/custom-2.svg" class="h-40px" />
                </a>
            </div>
            <!--end::Logo-->
            <!--begin::Title-->
            <h1 class="fw-bolder">Falha na autenticação.</h1>
            <!--end::Title-->
            <!--begin::Text-->
            <div class="fw-semibold fs-4 mb-7">
                Muitas tentativas de autenticação, tente novamente mais tarde.
            </div>
            <!--end::Text-->
            <!--begin::Illustration-->
            <div class="mb-2">
                <img src="/assets/media/illustrations/dozzy-1/19.png" class="mw-100 mh-300px theme-light-show" alt="" />
                <img src="/assets/media/illustrations/dozzy-1/19.png" class="mw-100 mh-300px theme-dark-show" alt="" />
            </div>
            <!--end::Illustration-->
            <!--begin::Link-->
            <div class="mb-0">
                <a href="{{route('home')}}" class="btn btn-sm btn-primary">Voltar ao sistema</a>
            </div>
            <!--end::Link-->
        </div>
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Content-->
@endsection