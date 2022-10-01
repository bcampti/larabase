@extends('layouts.app')

@section('title', ' - Usuários')

@section('content')
<!--begin::Content-->
<div id="kt_app_content" class="app-content flex-column-fluid pt-10">
	<!--begin::Content container-->
	<div id="kt_app_content_container" class="app-container container-fluid">

		<div class="row">

			@hasPermission('ADMIN')
			<div class="col-4">
				
				<div class="card card-shadow" id="kt_usuarioOrganizacao_main">

					<div class="card-header">
						<h3 class="card-title">Convites</h3>
						<div class="card-toolbar">
							<a href="{{ route('usuario.organizacao.invitation') }}" class="btn btn-sm fw-bold btn-primary"><i class="fa fa-plus"></i> Convidar Usuário</a>
						</div>
					</div>

					<div class="card-body">

						<div class="dataTables_wrapper dt-bootstrap4 no-footer">

							<div class="table-responsive">

								<table class="table table-striped border rounded gs-7 dataTable no-footer">

									<thead>
										<tr class="text-start text-gray-600 fw-bold fs-7 text-uppercase gs-0">
											<th class="text-primary">Convites</th>
											<th class="text-primary text-end">#</th>
										</tr>
									</thead>
									<tbody class="fw-semibold">
										@forelse( $userInvitations as $invitation )
										<tr class="{{$loop->odd?'odd':'even'}}">
											<td>
												<div class="fs-5 fw-bold mb-1">{{ $invitation->name }} <x-user.cargo :cargo="$invitation->cargo"/></div>
												<div class="text-gray-700 fs-7">{{ $invitation->email }}</div>
												<div class="text-gray-700 fs-7">Enviado em {{ $invitation->created_at->format('d/m/Y H:i') }}</div>
											</td>
											<td class="text-end">
												<a href="#" class="btn btn-sm btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#modalSendInvitation{{$invitation->id}}" title="Reenviar convite"><i class="fa fa-paper-plane"></i></a>
												<!--begin::ModalSend-->
												<div class="modal fade" id="modalSendInvitation{{$invitation->id}}" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
													<div class="modal-dialog modal-dialog-centered">
														<div class="modal-content rounded">
															<div class="modal-body pb-15 px-5 px-xl-20">
																<form action="{{ route('usuario.organizacao.invitation.send', $invitation) }}" method="post">
																	@csrf
																	<div class="mb-13 text-center">
																		<h1 class="mb-3">Reenviar Convite</h1>
																		<div class="fw-semibold fs-5">
																			Você confirma o reenvio deste convite?
																		</div>
																	</div>
																	<div class="d-flex flex-center flex-row-fluid">
																		<button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Cancelar</button>
																		<button type="submit" class="btn btn-success">Confirmar</button>
																	</div>
																</form>
															</div>
														</div>
													</div>
												</div>
												<!--end::ModalSend-->
												<a href="#" class="btn btn-sm btn-icon btn-danger" data-bs-toggle="modal" data-bs-target="#modaldeleteInvitation{{$invitation->id}}" title="Excluir convite"><i class="fa fa-trash-can"></i></a>
												<!--begin::ModalDelete-->
												<div class="modal fade" id="modaldeleteInvitation{{$invitation->id}}" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
													<div class="modal-dialog modal-dialog-centered">
														<div class="modal-content rounded">
															<div class="modal-body pb-15 px-5 px-xl-20">
																<form action="{{ route('usuario.organizacao.invitation.destroy', $invitation->id)}}" method="post">
																	@method("DELETE") @csrf
																	<div class="mb-13 text-center">
																		<h1 class="mb-3">Excluir Convite</h1>
																		<div class="fw-semibold fs-5">
																			Você confirma a ação para excluir este convite?
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
											</td>
										</tr>
										@empty
										<tr>
											<td colspan="2" style="text-align: center;">
												<div class="card-px text-center py-5 my-10">
													<p class="fs-4 fw-semibold">Nenhum convite pendente.</p>
													<a href="{{ route('usuario.organizacao.invitation') }}" class="btn btn-sm fw-bold btn-primary"><i class="fa fa-plus"></i> Convidar Usuário</a>
												</div>
											</td>
										</tr>
										@endforelse
									</tbody>

								</table>
							
							</div>

						</div>
					
					</div>

				</div>
				
			</div>
			@endhasPermission

			<div class="col-8">
			
				<div class="card card-shadow" id="kt_usuarioOrganizacao_main">

					<div class="card-header">
						<h3 class="card-title">Usuários</h3>
						<div class="card-toolbar">
						</div>
					</div>

					<div class="card-body pt-0 pb-0">

						<form role="form" action="{{ route('usuario.organizacao.index') }}" method="post">
							@csrf
							<input type="hidden" name="pagina" value="{{$filtro->pagina}}">
							<input type="hidden" name="orderBy" value="{{$filtro->orderBy}}">
							<input type="hidden" name="direcao" value="{{$filtro->direcao}}">

							<div class="card-header align-items-center py-5 gap-2 gap-md-5 px-0">

								<div class="d-flex flex-wrap gap-1">

									<div class="d-flex align-items-center position-relative w-300px">
										<span class="svg-icon svg-icon-3 svg-icon-gray-500 position-absolute top-50 translate-middle ms-6">
											<span class="fa fa-search"></span>
										</span>
										<input type="text" class="form-control form-control-sm ps-10" name="search" value="{{$filtro->search}}">
									</div>

								</div>
								<div class="d-flex align-items-center flex-wrap gap-2">

									<div class="d-flex w-75px">
										<select class="form-select form-select-sm" data-control="select2" name="limit">
											<option value="10" {{ $filtro->limit==10?'selected="selected"':'' }}>10</option>
											<option value="25" {{ $filtro->limit==25?'selected="selected"':'' }}>25</option>
											<option value="50" {{ $filtro->limit==50?'selected="selected"':'' }}>50</option>
											<option value="100" {{ $filtro->limit==100?'selected="selected"':'' }}>100</option>
										</select>
									</div>

									<button type="submit" name="filtroAtivo" value="true" class="btn btn-sm btn-primary"><span class="fa fa-search"></span> Filtrar</button>
									<a href="{{route('limpar.filtro')}}" class="btn btn-sm btn-secondary"><span class="fa fa-eraser"></span> Limpar</a>

								</div>

							</div>

						</form>

						<div class="dataTables_wrapper dt-bootstrap4 no-footer">

							<div class="table-responsive">

								<table class="table table-striped border rounded gs-7 dataTable no-footer">

									<thead>
										<tr class="text-start text-gray-600 fw-bold fs-7 text-uppercase gs-0">
											<th class="min-w-125px">{!! $filtro->coluna('Nome', 'usuario.name') !!}</th>
											<th class="min-w-125px">{!! $filtro->coluna('E-mail', 'usuario.email') !!}</th>
											<th class="min-w-125px">{!! $filtro->coluna('Cargo', 'cargo') !!}</th>
											<th class="text-end min-w-70px sorting_disabled">Ações</th>
										</tr>
									</thead>
									<tbody class="fw-semibold">
									@forelse( $filtro->items as $usuarioOrganizacao )
										<tr class="{{$loop->odd?'odd':'even'}}">
											<td>{{ $usuarioOrganizacao->usuario->name }}</td>
											<td>{{ $usuarioOrganizacao->usuario->email }}</td>
											<td><x-user.cargo :cargo="$usuarioOrganizacao->cargo"/></td>
											<td class="text-end pt-0 pb-0">
										@hasPermission('ADMIN')
											@if( auth()->id()==$usuarioOrganizacao->id_usuario )
												<div class="badge badge-secondary fw-bold">Sua conexão</div>
												<a href="{{ route('usuario.organizacao.edit', $usuarioOrganizacao->id) }}" class="btn btn-sm btn-icon btn-warning" title="Alterar Registro"><i class="fa fa-pen-to-square"></i></a>
											@else
												<a href="{{ route('usuario.organizacao.edit', $usuarioOrganizacao->id) }}" class="btn btn-sm btn-icon btn-warning" title="Alterar Registro"><i class="fa fa-pen-to-square"></i></a>
												<a href="#" class="btn btn-sm btn-icon btn-danger" data-bs-toggle="modal" data-bs-target="#modaldelete{{$usuarioOrganizacao->id}}" title="Excluir Registro"><i class="fa fa-trash-can"></i></a>
												<!--begin::ModalDelete-->
												<div class="modal fade" id="modaldelete{{$usuarioOrganizacao->id}}" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
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
											</td>
										</tr>
										@empty
										<tr>
											<td colspan="4" style="text-align: center;">
												<div class="card-px text-center py-20 my-10">
													<p class="fs-4 fw-semibold mb-10">Não existe nenhum registro para esta consulta.</p>
												</div>
											</td>
										</tr>
										@endforelse
									</tbody>

								</table>

							</div>

							<div class="row">
							
								@include('pagination.default')
							
							</div>

						</div>
						
					</div>

				</div>

			</div>

		</div>

	</div>
	<!--end::Content container-->
</div>
<!--end:: Content-->
@endsection

{{-- 
@section('script')
<script type="text/javascript">
$(document).ready(function(){});
</script>
@endsection
--}}