<?php

namespace Bcampti\Larabase\Exceptions;

use Exception;

/** Utilizar este exception para retornar mensagens para o front-end **/
class GenericMessage extends Exception
{

	protected $tipo;

	const TIPO_ALERT = "alert";
	const TIPO_ERRO = "erro";
	const TIPO_SUCESSO = "sucesso";

	const INSERT_SUCCESS = [
		"mensagem.tipo" => GenericMessage::TIPO_SUCESSO,
		"mensagem.titulo" => "Sucesso",
		"mensagem.mensagem" => "Registro salvo com sucesso!"
	];

	const UPDATE_SUCCESS = [
		"mensagem.tipo" => GenericMessage::TIPO_SUCESSO,
		"mensagem.titulo" => "Sucesso",
		"mensagem.mensagem" => "Dados atualizados com sucesso!"
	];

	const DELETE_SUCCESS = [
		"mensagem.tipo" => GenericMessage::TIPO_SUCESSO,
		"mensagem.titulo" => "Sucesso",
		"mensagem.mensagem" => "Registro excluido com sucesso"
	];

	const PASSWORD_REQUIRED = [
		"mensagem.tipo" => GenericMessage::TIPO_ALERT,
		"mensagem.titulo" => "Atenção",
		"mensagem.mensagem" => "Para executar esta ação é necessário informar a senha"
	];

	const PASSWORD_BAD = [
		"mensagem.tipo" => GenericMessage::TIPO_ALERT,
		"mensagem.titulo" => "Atenção",
		"mensagem.mensagem" => "A Credencial informada não confere"
	];

	public function __construct($message = null, $tipoMensagem = null, $code = null, $previous = null)
	{
		parent::__construct(null, $code, $previous);

		$this->tipo = empty($tipoMensagem) ? "erro" : $tipoMensagem;
		$this->message = $message;
	}

	final public function getTipo()
	{
		return $this->tipo;
	}

	public static function alertMessage($message){
		return [
			"mensagem.tipo" => GenericMessage::TIPO_ALERT,
			"mensagem.titulo" => "Atenção",
			"mensagem.mensagem" => $message
		];
	}

	public static function errorMessage($message){
		return [
			"mensagem.tipo" => GenericMessage::TIPO_ERRO,
			"mensagem.titulo" => "Atenção",
			"mensagem.mensagem" => $message
		];
	}

	public static function successMessage($message){
		return [
			"mensagem.tipo" => GenericMessage::TIPO_SUCESSO,
			"mensagem.titulo" => "Atenção",
			"mensagem.mensagem" => $message
		];
	}

	public static function notFoundMessage(){
		return new GenericMessage("O registro não existe ou não pode ser localizado!");
	}
}
