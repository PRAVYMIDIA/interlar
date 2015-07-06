<?php namespace App\Http\Controllers;

use App\Ambiente;
use App\ProdutoTipo;
use App\Produto;
use App\Loja;
// use App\Fornecedor;
use App\Banner;
use Illuminate\Database\Eloquent;
use Illuminate\Support\Facades\DB;

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
	public function index()
	{

		$ambientes      = new Ambiente();
		$ambientes 		= $ambientes->lists('nome','id')->all();

		$tipos      	= new ProdutoTipo();
		$tipos 			= $tipos->lists('nome','id')->all();

		$produtos      	= new Produto();
		$produtos 		= $produtos->all();

		// $fornecedores   = new Fornecedor();
		// $fornecedores	= $fornecedores->lists('nome','id')->all();

		$lojas			= new Loja();
		$lojas			= $lojas->lists('nome','id')->all();

		$banners		= new Banner();
		$banners		= $banners->lists('nome','id')->all();

		return view('pages.home', compact('ambientes','tipos','produtos','lojas','banners')); //'fornecedores',

		//return view('pages.welcome');
	}

}