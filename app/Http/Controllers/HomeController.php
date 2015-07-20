<?php namespace App\Http\Controllers;

use App\Loja;
// use App\Fornecedor;

use Illuminate\Database\Eloquent;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

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
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{

		$lojas			= new Loja();

		$tipo_id = null;
		if(!empty($request->input('tipo'))){
			$tipo_id = $request->input('tipo');
		}
		$loja_id = null;
		if(!empty($request->input('loja'))){
			$loja_id = $request->input('loja');
		}
		$ambiente_id = null;
		if(!empty($request->input('ambiente'))){
			$ambiente_id = $request->input('ambiente');
		}

		if(!empty($request->input('ordenacao'))){
			$ordenacao = $request->input('ordenacao');
		}
		// if($ambiente_id || $tipo_id){
		// 	$lojas			= $lojas->whereHas('produtos',function ($query) use ($ambiente_id,$tipo_id){
		// 		if($tipo_id){
		// 			$query->where('produto_tipo_id','=',$tipo_id);
		// 		}
		// 		if($ambiente_id){
		// 			$query->join('ambiente_produto','produtos.id','=','ambiente_produto.produto_id')
		// 					->where('ambiente_id','=',$ambiente_id);
		// 		}
		// 	})->lists('nome','id')->all();
		// }else{
			$lojas			= $lojas->has('produtos')->lists('nome','id')->all();
		// }

		$produto_grade = 1;

		return view('pages.home', compact('lojas','produto_grade','tipo_id','loja_id','ambiente_id','ordenacao')); 
	}

	public function localizacao(){
		return view('pages.localizacao');
	}

	/**
	 * Busca de produtos
	 *
	 * @return Response
	 */
	public function busca(Request $request)
	{

		$lojas			= new Loja();
		$lojas			= $lojas->lists('nome','id')->all();

		$produto_grade = 1;

		$termo = $request->input('termo');
		return view('pages.home', compact('lojas','termo','produto_grade')); 
	}

}