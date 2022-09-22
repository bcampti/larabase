<?php
namespace Bcampti\Larabase\Http\Middleware;

use Closure;
use App\Models\Admin\Companhia;
use App\Models\Admin\TermoPolitica;
use App\Repositories\Sistema\UsuarioAceiteManager;
use Bcampti\Larabase\Enums\UserTypeEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Spatie\Multitenancy\Models\Tenant;

class ChecarAceitesMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$user = Auth::user();
		if( !UserTypeEnum::SUPORTE->equals($user->tipo) && !Session::has('aceites') )
		{
			$usuarioAceiteManager = new UsuarioAceiteManager();
			//VALIDA O ACEITE DO TERMO DE USO
			$aceitarTermo = $usuarioAceiteManager->realizarAceite($user->id, TermoPolitica::TIPO_TERMO_USO);
			if( $aceitarTermo ){
				return redirect(route('termo.uso.aceitar'));
			}
			//VALIDA O ACEITE DAS POLITICAS
			$aceitarTermo = $usuarioAceiteManager->realizarAceite($user->id, TermoPolitica::TIPO_POLITICA);
			if( $aceitarTermo ){
				return redirect(route('politica.aceitar'));
			}
			$companhia = Tenant::current();
			if( $companhia->status == Companhia::STATUS_ATIVO && $companhia->id_usuario_responsavel == $user->id ){
				//VALIDA O ACEITE DO CONTRATO
				$aceitarTermo = $usuarioAceiteManager->realizarAceite($user->id, TermoPolitica::TIPO_TERMO_ADESAO);
				if( $aceitarTermo ){
					return redirect(route('contratar'));
				}
			}
		
		}
		Session::put('aceites','ok');
		
		return $next($request);
	}
}
