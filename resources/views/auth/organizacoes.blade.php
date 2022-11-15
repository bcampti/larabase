@extends('layouts.admin')

@section('title', ' - Organizacao')

@section('content')
<!--begin::Content-->
<div id="kt_app_content" class="app-content flex-column-fluid pt-10">
	<!--begin::Content container-->
	<div id="kt_app_content_container" class="app-container container-fluid">

		<div class="card card-shadow" id="kt_organizacao_main">

			<div class="card-header">
				<h3 class="card-title">Organizações</h3>
				<div class="card-toolbar">
					@hasProprietario
					<a href="{{ route('organizacao.create') }}" class="btn btn-sm fw-bold btn-primary"><i class="fa fa-plus"></i>
						Novo </a>
					@endhasProprietario
				</div>
			</div>

			<div class="card-body pt-0 pb-0">

				<form role="form" action="{{ route('auth.account.organizacao.index') }}" method="post">
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
									<th class="min-w-125px">{!! $filtro->coluna('Código', 'id') !!}</th>
									<th class="min-w-125px">{!! $filtro->coluna('Nome', 'nome') !!}</th>
									<th class="min-w-125px">{!! $filtro->coluna('Situação', 'status') !!}</th>
									<th class="text-end min-w-70px sorting_disabled">Ações</th>
								</tr>
							</thead>
							<tbody class="fw-semibold">
							@forelse( $filtro->items as $organizacao )
								<tr class="{{$loop->odd?'odd':'even'}}">
									<td>{{ $organizacao->id }}</td>
									<td>{{ $organizacao->nome }}</td>
									<td><x-model.status :status="$organizacao->status"/></td>
									<td class="text-end pt-0 pb-0">
                                        <a href="{{ route('auth.account.organizacao.select', $organizacao->id) }}" class="btn btn-sm fw-bold btn-info"><i class="bi bi-download"></i> Acessar</a>
                                    @hasSuporte
										<a href="{{ route('organizacao.edit', $organizacao->id) }}" class="btn btn-sm btn-icon btn-warning" title="Alterar Registro"><i class="fa fa-pen-to-square"></i></a>
										<a href="#" class="btn btn-sm btn-icon btn-danger" data-bs-toggle="modal" data-bs-target="#modaldelete{{$organizacao->id}}" title="Excluir Registro"><i class="fa fa-trash-can"></i></a>
										<!--begin::ModalDelete-->
										<div class="modal fade" id="modaldelete{{$organizacao->id}}" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
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
																<button type="submit" class="btn btn-danger">
																	<i class="fa fa-check"></i> 
																	<span class="indicator-label">Confirmar</span>
																	<span class="indicator-progress">Aguarde...
																		<span class="spinner-border spinner-border-sm align-middle ms-2"></span>
																	</span>
																</button>
															</div>
														</form>
													</div>
												</div>
											</div>
										</div>
										<!--end::ModalDelete-->
										@endhasSuporte
									</td>
								</tr>
								@empty
								<tr>
									<td colspan="4" style="text-align: center;">
										<div class="card-px text-center py-20 my-10">
											<p class="fs-4 fw-semibold mb-10">Não existe nenhum registro para esta consulta.</p>
											@hasProprietario
											<a href="{{ route('organizacao.create') }}" class="btn btn-sm fw-bold btn-primary"><i class="fa fa-plus"></i> Adicionar Novo Registro</a>
											@endhasProprietario
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
	<!--end::Content container-->
</div>
<!--end:: Content-->
@endsection