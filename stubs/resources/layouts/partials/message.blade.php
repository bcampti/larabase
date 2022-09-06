
@if( session()->has('mensagem') )

	@if( session('mensagem.tipo') == 'sucesso' )
		<script type="text/javascript">
			toastr.options = {
				"closeButton": false,
				"debug": false,
				"newestOnTop": true,
				"progressBar": true,
				"positionClass": "toastr-top-right",
				"preventDuplicates": false,
				"onclick": null,
				"showDuration": "300",
				"hideDuration": "1000",
				"timeOut": "5000",
				"extendedTimeOut": "1000",
				"showEasing": "swing",
				"hideEasing": "linear",
				"showMethod": "fadeIn",
				"hideMethod": "fadeOut"
			};
			toastr.success( "{!! tratarCaracteresEspeciais(session('mensagem.mensagem')) !!}", 'Sucesso');
		</script>
	@elseif( session('mensagem.tipo') == 'erro' )
		<script type="text/javascript">
			toastr.options = {
				"closeButton": false,
				"debug": false,
				"newestOnTop": true,
				"progressBar": true,
				"positionClass": "toastr-top-right",
				"preventDuplicates": false,
				"onclick": null,
				"showDuration": "300",
				"hideDuration": "1000",
				"timeOut": "5000",
				"extendedTimeOut": "1000",
				"showEasing": "swing",
				"hideEasing": "linear",
				"showMethod": "fadeIn",
				"hideMethod": "fadeOut"
			};
			toastr.error( "{!! tratarCaracteresEspeciais(session('mensagem.mensagem')) !!}", 'Atenção!');
		</script>
	@elseif( session('mensagem.tipo') == 'alert' )
		<script type="text/javascript">
			Swal.fire({
				text: "{!! tratarCaracteresEspeciais(session('mensagem.mensagem')) !!}",
				icon: "info",
				confirmButtonText: "Fechar!",
			});
		</script>
	@else
		<script type="text/javascript">
			toastr.options = {
				"closeButton": false,
				"debug": false,
				"newestOnTop": true,
				"progressBar": true,
				"positionClass": "toastr-top-right",
				"preventDuplicates": false,
				"onclick": null,
				"showDuration": "300",
				"hideDuration": "1000",
				"timeOut": "5000",
				"extendedTimeOut": "1000",
				"showEasing": "swing",
				"hideEasing": "linear",
				"showMethod": "fadeIn",
				"hideMethod": "fadeOut"
			}
			toastr.info( "{!! tratarCaracteresEspeciais(session('mensagem.mensagem')) !!}", "Atenção" );
		</script>
	@endif
	{{ Session::forget('mensagem') }}
@endif