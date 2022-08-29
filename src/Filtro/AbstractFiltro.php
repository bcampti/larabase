<?php namespace Bcampti\Larabase\Filtro;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\URL;

abstract class AbstractFiltro {

	public $filtroAtivo = false;

	protected $keepOnSession = true;
	
	public $pagina = 1;
	public $paginas = 1;
	public $temMais = false;
	public $index = 0;
	
	public $search = null;
	public $status = 'Ativo';
	
	public $inicio = 0;
	public $limit = 10;
	public $orderBy;
	public $direcao;
	
	public $filtrados = 0;
	public $total = 0;

	public $items = [];
	
	public function __construct(Request $request){

		$this->init();
		
		$clazz = get_class($this);
		
		$filtro = $this->getFiltroSessao();

		/* Recupera dados do filtro da sessao */
		if( $filtro instanceof $clazz )
		{
			$campos = get_object_vars($this);
			foreach ( $campos as $key => $valor)
			{
				if( $this->{$key} instanceof Model ){
					if( !is_null($filtro->{$key}) ){
						$this->{$key}->fill( $filtro->{$key}->getAttributes() );
					}
				}else{
					$this->{$key} = $filtro->{$key};
				}
			}
		}
		/* Atualiza os parametros com as novas informações */
		foreach ($this as $key => $valor){
			if( $request->has($key) ){
				if( $this->{$key} instanceof Model){
					$this->{$key}->fill( $request->get($key) );
				}else{
					$this->{$key} = $request->get($key);
				}
			}else{
				if( $request->has('filtroAtivo') && $key!="keepOnSession" )
					$this->{$key} = null; 
			}
		}
		
		if( is_null($this->limit) ){
			$this->limit = 10;
		}else{
			$this->limit = in_array($this->limit, [5,10,25,50,100])?$this->limit:10;
		}
		
		if( $request->has('pagina') || $request->has('page') ){
			$this->setPagina($request->get('pagina')??$request->get('page'));
		}
		
		if( empty($this->orderBy) ){
			$this->orderBy = $this->getOrderBy();
		}
		if( empty($this->direcao) ){
			$this->direcao = $this->getDirecao();
		}
		if( is_null($this->pagina) ){
			$this->pagina = 1;
		}
		if( is_null($this->inicio) ){
			$this->inicio = 0;
		}
		
		$this->setFiltroSessao();
		
		$this->index = $this->inicio;
		
	}
	
	protected abstract function init();
	protected abstract function getOrderBy();
	protected abstract function getDirecao();
	
	public function getFiltroSessao(){
		return $this->keepOnSession?session('filtro'):null;
	}
	
	/**
	 *  PARA NÃO MANTER O FILTRO NA SESSAO SOBRESCREVER ESTA function  
	 **/
	public function setFiltroSessao(){
		if( $this->keepOnSession ){
			session()->put('filtro', clone $this);
		}
	}
	
	public function setItems( $items ){
		$this->items = $items instanceof Collection ? $items : Collection::make($items);
		$this->filtrados = $this->items->count();
	}
	
	public function setTotal( $total ){
		$this->total = $total;
		
		if( $this->total > $this->limit ){
			$this->temMais = true;
			$this->paginas = (int) ceil($this->total/ $this->limit);
		}else if( $this->total > 0 ){
			$this->paginas = 1;
			$this->temMais = false;
		}
	}
	
	public function firstItem(){
		return $this->filtrados > 0 ? ($this->pagina - 1) * $this->limit + 1 : null;
	}
	
	public function lastItem(){
		return $this->filtrados > 0 ? $this->firstItem() + $this->items->count() - 1 : null;
	}
	
	public function total(){
		return $this->total;
	}
	
	public function setPagina($pagina){
		$this->pagina = $pagina;
		if( $this->pagina > 1)
			$this->inicio = (int)($pagina-1)*$this->limit;
		else 
			$this->inicio = 0;
	}
	
	public function onFirstPage(){
		return $this->pagina <= 1;
	}
	
	public function hasPages(){
		return $this->pagina != 1 || $this->temMais;
	}
	
	public function previousPageUrl(){
		if($this->pagina > 1) {
			return $this->urlPage($this->pagina - 1);
		}
	}
	
	public function nextPageUrl(){
		if($this->temMais) {
			return $this->urlPage($this->pagina + 1);
		}
	}
	
	public function urlPage( $pagina ){
	    return  $this->url('?pagina='.$pagina);
	}
	
	public function url( $uri ){
	    return  URL::current().$uri;
	}
	
	public function numeros () {
		
		$page = $this->pagina;
		$pages = $this->paginas;
		$numbers= [];
		$buttons = 7;
		$half = 3;
		
		if ( $pages <= $buttons ) {

			$numbers = $this->tamanho( 1, $pages );
			
		} else if ( $page <= $half ) {
			
			$numbers = $this->tamanho( 1, $buttons-2 );
			array_push( $numbers, '...', $pages );
			
		} else if ( $page >= $pages - $half ) {
			
			array_push( $numbers, 1, '...' );
			$numbers = array_merge( $numbers, $this->tamanho( $pages-($buttons-2), $pages ) );
			
		} else {
			
			array_push( $numbers, 1, '...' );
			$numbers = array_merge( $numbers, $this->tamanho( $page-$half+2, $page+$half-2 ) );
			array_push( $numbers, '...', $pages );
			
		}
		
		return $numbers;
	}
	
	public function tamanho( $len, $start ){
		$out = [];
		$end = 0;
		
		if( empty($start) ) {
			$start = 0;
			$end = $len;
		} else {
			$end = $start;
			$start = $len;
		}
		
		for( $i=$start ; $i<=$end ; $i++ ) {
			array_push( $out, $i );
		}
		
		return $out;
	}
	
	public function getIndex(){
	    $this->index++;
	    return $this->index;
	}
	
	public function coluna( $label, $atributo ){
		
		$url = URL::current();
		$urlColuna = $url;
		$direcao = ($this->direcao=='asc'?'desc':'asc');
		
		if( $this->orderBy == $atributo ){
			if( str_contains($url, '?'))
				$urlColuna = $url.'&orderBy='.$this->orderBy.'&direcao='.$direcao;
			else 
				$urlColuna = $url.'?orderBy='.$this->orderBy.'&direcao='.$direcao;
			return '<a class="text-primary" href="'.$urlColuna.'"> '.$label.' <i class="sorting_'.strLower($this->direcao).'"></i></a>';
		}else{
			$urlColuna = $url.'?orderBy='.$atributo.'&direcao=asc';
			return '<a class="text-primary" href="'.$urlColuna.'"> '.$label.' </a>';
		}
		
	}
	
}