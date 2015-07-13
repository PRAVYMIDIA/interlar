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
		$lojas			= $lojas->lists('nome','id')->all();

		$tipo_id = null;
		if(!empty($request->input('tipo'))){
			$tipo_id = $request->input('tipo');
		}
		$loja_tipo_id = null;
		if(!empty($request->input('lojatipo'))){
			$loja_tipo_id = $request->input('lojatipo');
		}
		$ambiente_id = null;
		if(!empty($request->input('ambiente'))){
			$ambiente_id = $request->input('ambiente');
		}

		if(!empty($request->input('ordenacao'))){
			$ordenacao = $request->input('ordenacao');
		}

		$produto_grade = 1;

		return view('pages.home', compact('lojas','produto_grade','tipo_id','loja_tipo_id','ambiente_id','ordenacao')); 
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