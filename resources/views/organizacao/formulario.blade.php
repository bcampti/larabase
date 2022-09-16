@extends('layouts.admin') 

@section('title', ' - Organizacao')

@section('css')
@endsection

@section('content')
<!--begin::Content-->
<div id="kt_app_content" class="app-content flex-column-fluid pt-10">
	<!--begin::Content container-->
	<div id="kt_app_content_container" class="app-container container-fluid">

		<div class="card card-shadow" id="kt_organizacao_main">

			<div class="card-header">
				<h3 class="card-title">Organizacao</h3>
				<div class="card-toolbar">
					@hasProprietario
					<a href="{{ route('organizacao.create') }}" class="btn btn-sm fw-bold btn-primary"><i class="fa fa-plus"></i> Novo </a>
					@endhasProprietario
				</div>
			</div>
		@hasProprietario
			@if( empty($organizacao->id) )
			<form id="kt_organizacao_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('organizacao.store')}}" method="post">
			@else
			<form id="kt_organizacao_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('organizacao.update', $organizacao->id)}}" method="post">
				@method("PUT")
			@endif
		@endhasProprietario
				@csrf

				<div class="card-body">
					@if ($errors->any())
					<div class="alert alert-danger">
						@foreach ($errors->all() as $error)
						<p>{{ $error }}</p>
						@endforeach
					</div>
					@endif
					<div class="row">

						<div class="col-xs-12 col-sm-6 col-md-6 col-xl-6 col-xxl-6">
							<label class="fs-6 fw-semibold form-label mt-3">
								<span class="required">Nome</span>
							</label>
							<input type="text" class="form-control form-control-sm" name="nome" value="{{ $organizacao->nome }}">
							@error('nome')
							<div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="col-xs-12 col-sm-6 col-md-6 col-xl-6 col-xxl-6">
							<label class="fs-6 fw-semibold form-label mt-3">
								<span class="required">Situação</span>
							</label>
							<select class="form-select form-select-sm" data-control="select2" name="status">
								@foreach ( \Bcampti\Larabase\Enums\StatusEnum::cases() as $status )
									<option value="{{ $status->value }}" {{ optional($organizacao->status)->value!=$status->value?:'selected' }}>{{ $status->value }}</option>
								@endforeach
							</select>
							@error('status')
							<div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					
					</div>

				</div>
				<div class="card-footer">
					<div class="d-flex justify-content-end">
					@hasProprietario
						@if( !empty($organizacao->id) )
						<a href="#" class="btn btn-sm btn-danger me-3" data-bs-toggle="modal" data-bs-target="#modaldelete" title="Excluir Registro"><i class="las la-trash fs-2"></i> Excluir</a>
						@endif
						<button type="submit" data-kt-contacts-type="submit" class="btn btn-primary btn-sm me-3">
							<i class="fa fa-check"></i> 
							<span class="indicator-label">Salvar</span>
							<span class="indicator-progress">Aguarde...
								<span class="spinner-border spinner-border-sm align-middle ms-2"></span>
							</span>
						</button>
					@endhasProprietario
						<a href="{{ route('organizacao.index') }}" class="btn btn-secondary btn-sm"><i class="fa fa-chevron-left"></i> Voltar</a>
					</div>
				</div>

			</form>

		</div>

	</div>
	<!--end::Content container-->
</div>
<!--end::Content-->

@hasProprietario
@if( !empty($organizacao->id) )
<!--begin::ModalDelete-->
<div class="modal fade" id="modaldelete" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content rounded">
			<div class="modal-body pb-15 px-5 px-xl-20">
				<form action="{{ route('organizacao.destroy', $organizacao->id)}}" method="post">
					@method("DELETE") @csrf
					<div class="mb-13 text-center">
						<h1 class="mb-3">Excluir Registro</h1>
						<div class="fw-semibold fs-5">
							Você confirma a ação para excluir este registro?
						</div>
					</div>
					<div class="modal-content">
						<div class="fv-row mb-10 fv-plugins-icon-container">
							<label class="d-flex align-items-center fs-5 fw-semibold mb-2">
								<span class="required">Informe sua senha</span>
							</label>
							<input type="password" class="form-control" name="password" required oninvalid="this.setCustomValidity('Informe a sua senha')" oninput="this.setCustomValidity('')">
							<div class="fv-plugins-message-container invalid-feedback"></div>
						</div>
					</div>
					<div class="d-flex flex-center flex-row-fluid">
						<button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-danger">Confirmar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!--end::ModalDelete-->
@endif
@endhasProprietario
@endsection

{{-- 
@section('script')
<script type="text/javascript">
$(document).ready(function(){});
</script>
@endsection
--}}