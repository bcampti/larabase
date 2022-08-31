<?php

namespace App\Exceptions;

use Bcampti\Larabase\Exceptions\GenericMessage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        \Bcampti\Larabase\Exceptions\GenericMessage::class,
    ];
    
	/**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

	/**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
	{
        if ( $exception instanceof GenericMessage )
		{
			if ($request->ajax())
			{
    			$msg['mensagem']['tipo'] = 'erro';
    			$msg['mensagem']['titulo'] = 'Atenção!';
                $msg['mensagem']['mensagem'] = $exception->getMessage();
				return response()->json($msg);
    		}
			else
			{
				$request->sesion()->put('mensagem.tipo', GenericMessage::TIPO_ERRO);
				$request->sesion()->put('mensagem.titulo', 'Atenção');
				$request->sesion()->put('mensagem.mensagem', $exception->getMessage());
    	    
				return back()->with('retorno_handler',$request->except($this->dontFlash));
			}
		}

		if( $exception instanceof ValidationException )
		{
			return parent::render($request, $exception);
        }

		if( config("app.debug") && auth()->check() )
		{
			return parent::render($request, $exception);
		}
        
    	if( $exception instanceof ModelNotFoundException )
		{
            if ($request->ajax()){
                $msg['mensagem']['tipo'] = 'erro';
                $msg['mensagem']['titulo'] = 'Atenção!';
                $msg['mensagem']['mensagem'] = 'Não foi possível localizar o registro solicitado, verifique os parametros e tente novamente.';
                return response()->json($msg);
            }
			else
			{
                $request->sesion()->put('mensagem.tipo', 'erro');
                $request->sesion()->put('mensagem.titulo', 'Atenção');
                $request->sesion()->put('mensagem.mensagem', 'Não foi possível localizar o registro solicitado, verifique os parametros e tente novamente.');
                return back();
            }
        }

        if ($exception instanceof QueryException || $exception instanceof \PDOException)
		{
    		if ($request->ajax())
			{
				$mensagem = 'Ocorreu um erro inesperado, recarregue a página e tente novamente!';
				if( str_contains($exception->getMessage(), "Foreign key violation") )
				{
					$mensagem = "Este registro não pode ser excluido, ele está vinculado a outros registros do sistema.";
				}
				if( str_contains($exception->getMessage(), "duplicate key value violates unique constraint") )
				{
					$mensagem = "Já existe um registro com estes dados.";
				}
				
    			$msg['mensagem']['tipo'] = 'erro';
    			$msg['mensagem']['titulo'] = 'Atenção!';
    			$msg['mensagem']['mensagem'] = $mensagem;
    			return response()->json($msg);
    		}
			else
			{
				if( str_contains($exception->getMessage(), "Foreign key violation") )
				{
					$mensagem = "Este registro não pode ser excluido, ele está vinculado a outros registros do sistema.";
					$request->sesion()->put('mensagem.tipo', 'erro');
					$request->sesion()->put('mensagem.titulo', 'Atenção');
					$request->sesion()->put('mensagem.mensagem', $mensagem);

					return back();
				}
				if( str_contains($exception->getMessage(), "duplicate key value violates unique constraint") )
				{
					$mensagem = "Já existe um registro com estes dados.";
					$request->sesion()->put('mensagem.tipo', 'erro');
					$request->sesion()->put('mensagem.titulo', 'Atenção');
					$request->sesion()->put('mensagem.mensagem', $mensagem);

					return back();
				}
    			$request->sesion()->put('mensagem.tipo', 'erro');
    			$request->sesion()->put('mensagem.titulo', '<p>Ocorreu um erro inesperado, recarregue a página e tente novamente!</p><p>Caso o problema persista, entre em contate com o suporte.</p>');
    			$request->sesion()->put('mensagem.mensagem', '<p>Ocorreu um erro inesperado, recarregue a página e tente novamente!</p><p>Caso o problema persista, entre em contate com o suporte.</p>');
    			
    			return response(view('errors.erro'));
    		}
        }
        
        return parent::render($request, $exception);
    }
}