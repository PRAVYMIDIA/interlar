<?php namespace App\Http\Controllers;

use App\Loja;
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
		$lojas = Loja::where('ativo', 1)->get();
		return view('loja.index',compact('lojas'));
	}
}
