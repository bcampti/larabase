@extends('layouts.app') 

@section('title', ' - Usuários')

@section('css')
@endsection

@section('content')
<!--begin::Content-->
<div id="kt_app_content" class="app-content flex-column-fluid pt-10">
	<!--begin::Content container-->
	<div id="kt_app_content_container" class="app-container container-fluid">

		<div class="col-xs-12 col-sm-6 col-md-6 col-xl-6 col-xxl-6">

		<div class="card card-shadow" id="kt_usuarioOrganizacao_main">

			<div class="card-header">
				<h3 class="card-title">Usuários</h3>
				<div class="card-toolbar">
				</div>
			</div>
		@hasPermission('PROPRIETARIO')
			<form id="kt_usuarioOrganizacao_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('usuario.organizacao.update', $usuarioOrganizacao->id)}}" method="post">
				@method("PUT")
				@csrf
		@endhasPermission

				<div class="card-body">
					
					<div class="row">

						<div class="fv-row">
							<label class="fs-6 fw-semibold form-label mt-3">
								<span class="required">Nome</span>
							</label>
							<input type="text" class="form-control form-control-sm" name="name" value="{{ $usuarioOrganizacao->usuario->name }}" required>
							@error('name')
							<div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="fv-row">
							<label class="fs-6 fw-semibold form-label mt-3">
								<span class="required">E-mail</span>
							</label>
							<input type="email" class="form-control form-control-sm" value="{{ $usuarioOrganizacao->usuario->email }}" disabled>
						</div>

						<div class="fv-row">
							<label class="fs-6 fw-semibold form-label mt-3">
								<span class="required">Cargo</span>
							</label>
							
							<div class="d-flex fv-row">
								<!--begin::Radio-->
								<div class="form-check form-check-custom form-check-solid">
									<input class="form-check-input me-3" name="cargo" type="radio" id="role_option_1" 
										value="{{App\Enums\CargoUsuarioEnum::USUARIO->name}}" 
										{{App\Enums\CargoUsuarioEnum::USUARIO->equals($usuarioOrganizacao->cargo->name)? 'checked="checked"':''}}>
									<label class="form-check-label" for="role_option_1">
										<div class="fw-bold text-gray-800">{{App\Enums\CargoUsuarioEnum::USUARIO->value}}</div>
										<div class="text-gray-600">Possui acesso para realizar cadastros, alterações e exclusão de registros do sistema.</div>
									</label>
								</div>
								<!--end::Radio-->
							</div>

							<div class="separator separator-dashed my-5"></div>

							<div class="d-flex fv-row">
								<!--begin::Radio-->
								<div class="form-check form-check-custom form-check-solid">
									<input class="form-check-input me-3" name="cargo" type="radio" id="role_option_2"
										value="{{App\Enums\CargoUsuarioEnum::ADMIN->name}}"
										{{App\Enums\CargoUsuarioEnum::ADMIN->equals($usuarioOrganizacao->cargo->name)? 'checked="checked"':''}}>
									<label class="form-check-label" for="role_option_2">
										<div class="fw-bold text-gray-800">{{App\Enums\CargoUsuarioEnum::ADMIN->value}}</div>
										<div class="text-gray-600">Possui acesso para realizar cadastros, alterações e exclusão de registros do sistema.</div>
										<div class="text-gray-600">Possui acesso a todos os recursos do sistema.</div>
										<div class="text-gray-600">Pode genrenciar usuários, convidar, excluir e alterar cargo.</div>
									</label>
								</div>
								<!--end::Radio-->
							</div>

							<div class="separator separator-dashed my-5"></div>

							@error('status')
							<div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					
					</div>

				</div>
				<div class="card-footer">
					<div class="d-flex justify-content-end">
					@hasPermission('PROPRIETARIO')
						@if( !empty($usuarioOrganizacao->id) )
						<a href="#" class="btn btn-sm btn-danger me-3" data-bs-toggle="modal" data-bs-target="#modaldelete" title="Excluir Registro"><i class="fa fa-trash-can"></i> Excluir</a>
						@endif
						<button type="submit" data-kt-contacts-type="submit" class="btn btn-primary btn-sm me-3">
							<i class="fa fa-check"></i> 
							<span class="indicator-label">Enviar</span>
							<span class="indicator-progress">Aguarde...
								<span class="spinner-border spinner-border-sm align-middle ms-2"></span>
							</span>
						</button>
					@endhasPermission
						<a href="{{ route('usuario.organizacao.index') }}" class="btn btn-secondary btn-sm"><i class="fa fa-chevron-left"></i> Voltar</a>
					</div>
				</div>

			</form>

		</div>

	</div>
	<!--end::Content container-->
</div>
<!--end::Content-->

@hasPermission('PROPRIETARIO')
@if( !empty($usuarioOrganizacao->id) )
<!--begin::ModalDelete-->
<div class="modal fade" id="modaldelete" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content rounded">
			<div class="modal-body pb-15 px-5 px-xl-20">
				<form action="{{ route('usuario.organizacao.destroy', $usuarioOrganizacao->id)}}" method="post">
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
@endhasPermission
@endsection