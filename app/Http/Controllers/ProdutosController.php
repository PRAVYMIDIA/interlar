<?php namespace App\Http\Controllers;

use App\Ambiente;
use App\ProdutoTipo;
use App\Produto;
use App\Loja;
// use App\Fornecedor;
use App\Banner;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent;
use Illuminate\Support\Facades\DB;

class ProdutosController extends Controller {


	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function data(Request $request)
	{

		$produtos      	= new Produto();
		$produtos 		= $produtos->with('fornecedor');
		if(!empty($request->input('tipo_id'))){
			$produtos->where('produto_tipo_id','=',$request->input('tipo_id'));
		}

		if(!empty($request->input('ambiente_id'))){
			$produtos->whereHas('ambientes',function($query )use ($request) {
				$query->where('ambiente_id','=',$request->input('ambiente_id'));
			});
		}

		if(!empty($request->input('loja_tipo_id'))){
			$produtos->whereHas('lojasTipos',function($query )use ($request) {
				$query->where('loja_tipo_id','=',$request->input('loja_tipo_id'));
			});
		}
		if(!empty($request->input('termo'))){
			$produtos->where('nome','like','%'.$request->input('termo').'%');
		}

		if(!empty($request->input('ordenacao'))){
			switch ($request->input('ordenacao')) {
				case 'menor_preco':
					$produtos->orderBy('valor_promocional','ASC');
					$produtos->orderBy('valor','ASC');
					break;
				case 'maior_preco':
					$produtos->orderBy('valor_promocional','DESC');
					$produtos->orderBy('valor','DESC');
					break;
				case 'visitas':
					/**
					* @TODO salvar visitas e ordenar
					*/
					$produtos->orderBy('id','DESC');
					break;
				
				default:
					$produtos->orderBy('id','DESC');
					break;
			}

		}else{
			$produtos->orderBy('id','DESC');
		}

		$produtos 		= $produtos->paginate(9);

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

	public function show($slug,$id)
    {
        $produto = Produto::find($id);

        return view('produtos.detalhe', compact('produto'));
    }

}