<?php namespace App\Http\Controllers;

use App\Loja;
use App\LojaTipo;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class LojaController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('auth');

		//parent::__construct();

		//$this->news = $news;
		//$this->user = $user;
	}

	/**
	 * Exibe a página de Lojas
	 *
	 * @return Response
	 */
	public function index()
	{
		$lojastipos = LojaTipo::where('ativo', 1)->get();

		return view('loja.index', compact('lojastipos'));
	}

	public function data()
	{
		$lojas	= new Loja();
		$lojas 	= Loja::where('ativo', 1)->paginate(12);

		return $lojas;
	}

	/**
	 * Busca Lojas por Nome
	 *
	 * @return Response json
	 */
	public function buscar(Request $request)
	{
		$lojas      	= new Loja();
		$nome 			= $request->input('nome');
		$segmento		= $request->input('segmento');
		$letrainicial	= $request->input('letrainicial');

		if($letrainicial != null){
			if($segmento != '0')
				$lojas 	= Loja::where('ativo', 1)
								->where('nome', 'like', $letrainicial.'%')
								->where('loja_tipo', $segmento)
								->paginate(12);
			else
				$lojas 	= Loja::where('ativo', 1)
								->where('nome', 'like', $letrainicial.'%')
								->paginate(12);				
		}
		else{
			if($segmento != '0'){
				$lojas 	= Loja::where('ativo', 1)
								->where('nome', 'like', $nome.'%')
								->where('loja_tipo', $segmento)
								->paginate(12);
			}
			else
				$lojas 	= Loja::where('ativo', 1)
								->where('nome', 'like', $nome.'%')
								->paginate(12);
		}
		return $lojas;
	}	
}
