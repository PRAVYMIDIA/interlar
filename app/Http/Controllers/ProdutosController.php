<?php namespace App\Http\Controllers;

use App\Ambiente;
use App\ProdutoTipo;
use App\Produto;
use App\Loja;
// use App\Fornecedor;
use App\Banner;
use Illuminate\Database\Eloquent;
use Illuminate\Support\Facades\DB;

class ProdutosController extends Controller {


	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function data()
	{

		$produtos      	= new Produto();
		$produtos 		= $produtos->with('fornecedor')->paginate(9);

		$produtos_array = array();
		foreach ($produtos as $produto) {
			$produto->produto_slug = str_slug($produto->nome, '-');
			$produto->mini = "/images/produto/".$produto->id.'/'.$produto->thumb(255,255,90);
			if($produto->parcelas <= 1){
				$produto->parcelas = null;
			}
			$produto->fornecedor_nome = null;
			if($produto->fornecedor){
				$produto->fornecedor_nome = $produto->fornecedor->nome;
			}
            
		}

		return $produtos;
	}

}