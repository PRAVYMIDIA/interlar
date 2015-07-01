<?php namespace App\Http\Controllers\Admin;
use Log;
use App\Http\Controllers\AdminController;
use App\Produto;
use App\ProdutoTipo;
use App\Fornecedor;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\Admin\ProdutoRequest;
use App\Http\Requests\Admin\DeleteRequest;
use App\Http\Requests\Admin\ReorderRequest;
use Illuminate\Support\Facades\Auth;
use Datatables;
use DB;

class ProdutoController extends AdminController {

    /*
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        // Show the page
        return view('admin.produto.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
		$title = "Novo Produto";
        $produtos_tipos = ProdutoTipo::lists('nome','id')->all();
        $fornecedores = Fornecedor::lists('nome','id')->all();
        // Show the page
        return view('admin.produto.create_edit', compact('title','produtos_tipos','fornecedores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate(ProdutoRequest $request)
    {
        $produto = new Produto();
        $produto -> user_id_created = Auth::id();
        $produto -> nome = $request->nome;
        $produto -> produto_tipo_id = $request->produto_tipo_id;
        $produto -> fornecedor_id = $request->fornecedor_id;
        $produto -> valor = $request->valor;
        $produto -> parcelas = $request->parcelas;
        $produto -> descricao = $request->descricao;

        $imagem = "";
        if(Input::hasFile('imagem'))
        {
            $file = Input::file('imagem');
            $filename = $file->getClientOriginalName();
            $extension = $file -> getClientOriginalExtension();
            $imagem = sha1($filename . time()) . '.' . $extension;
        }
        $produto -> imagem = $imagem;
        $produto -> save();

        if(Input::hasFile('imagem'))
        {
            $destinationPath = public_path() . '/images/produto/'.$produto->id.'/';
            Input::file('imagem')->move($destinationPath, $imagem);
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function getEdit($id)
    {
        $produto = Produto::find($id);
        $produtos_tipos = ProdutoTipo::lists('nome','id')->all();
        $fornecedores = Fornecedor::lists('nome','id')->all();

        $title = 'Editar Produto';

        return view('admin.produto.create_edit',compact('produto','title','produtos_tipos','fornecedores'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function postEdit(ProdutoRequest $request, $id)
    {
        $produto = Produto::find($id);
        $produto -> user_id_updated = Auth::id();
        $produto -> nome = $request->nome;
        $produto -> produto_tipo_id = $request->produto_tipo_id;
        $produto -> fornecedor_id = $request->fornecedor_id;
        $produto -> valor = $request->valor;
        $produto -> parcelas = $request->parcelas;
        $produto -> descricao = $request->descricao;

        if(Input::hasFile('imagem'))
        {
            $file = Input::file('imagem');
            $filename = $file->getClientOriginalName();
            $extension = $file -> getClientOriginalExtension();
            $imagem = sha1($filename . time()) . '.' . $extension;
            $produto -> imagem = $imagem;
        }
        $produto -> save();

        if(Input::hasFile('imagem'))
        {
            $destinationPath = public_path() . '/images/produto/'.$produto->id.'/';
            Input::file('imagem')->move($destinationPath, $imagem);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */

    public function getDelete($id)
    {
        $produto = Produto::find($id);
        $title = "Remover Produto";
        // Show the page
        return view('admin.produto.delete', compact('produto','title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function postDelete(DeleteRequest $request,$id)
    {
        $produto = Produto::find($id);
        $produto->delete();
    }


    /**
     * Show a list of all the languages posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data()
    {
        $produto = Produto::leftJoin('produtos_tipos','produtos_tipos.id','=','produtos.produto_tipo_id')
            // ->leftJoin('fornecedores','fornecedores.id','=','produtos.fornecedor_id')
            ->select(array(
                                        'produtos.id',
                                        'produtos.nome', 
                                        'produtos_tipos.nome as tipo', 
                                        'produtos.valor',
                                        'produtos.parcelas',
                                        'produtos.imagem',
                                        DB::raw('DATE_FORMAT(produtos.created_at,\'%d/%m/%Y %H:%i\') as criado_em')
                                        )
                                    )
            ->orderBy('produtos.nome', 'ASC');

        return Datatables::of($produto)
            ->edit_column('valor','{{ number_format( doubleval($valor), 2,\',\',\'.\') }}')
            ->edit_column('imagem','{!! strlen($imagem)? \'<img src="/images/produto/\' . $id . \'/\' . $imagem . \'" width="100" />\':\'\' !!}')
            ->add_column('actions', '<a href="{{{ URL::to(\'admin/produto/\' . $id . \'/edit\' ) }}}" class="btn btn-success btn-xs iframe" title="{{ trans("admin/modal.edit") }}" ><span class="glyphicon glyphicon-pencil"></span></a>
                    <a href="{{{ URL::to(\'admin/produto/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe" title="{{ trans("admin/modal.delete") }}"><span class="glyphicon glyphicon-trash"></span></a>
                    <input type="hidden" name="row" value="{{$id}}" id="row">')
            ->remove_column('id')

            ->make();
    }

    /**
     * Reorder items
     *
     * @param items list
     * @return items from @param
     */
    public function getReorder(ReorderRequest $request) {
        $list = $request->list;
        $items = explode(",", $list);
        $order = 1;
        foreach ($items as $value) {
            if ($value != '') {
                Produto::where('id', '=', $value) -> update(array('position' => $order));
                $order++;
            }
        }
        return $list;
    }
}
