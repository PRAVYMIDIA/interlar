<?php namespace App\Http\Controllers\Admin;
use Log;
use App\Http\Controllers\AdminController;
use App\ProdutoTipo;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\Admin\ProdutoTipoRequest;
use App\Http\Requests\Admin\DeleteRequest;
use App\Http\Requests\Admin\ReorderRequest;
use Illuminate\Support\Facades\Auth;
use Datatables;
use DB;

class ProdutoTipoController extends AdminController {

    /*
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        // Show the page
        return view('admin.produto_tipo.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
		$title = "Novo Tipo de Produto";
        // Show the page
        return view('admin.produto_tipo.create_edit', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate(ProdutoTipoRequest $request)
    {
        $produto_tipo = new ProdutoTipo();
        $produto_tipo -> user_id_created = Auth::id();
        $produto_tipo -> nome = $request->nome;
        $produto_tipo -> descricao = $request->descricao;

        $produto_tipo -> save();
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function getEdit($id)
    {
        $produto_tipo = ProdutoTipo::find($id);

        $title = 'Editar Tipo de Produto';

        return view('admin.produto_tipo.create_edit',compact('produto_tipo','title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function postEdit(ProdutoTipoRequest $request, $id)
    {
        $produto_tipo = ProdutoTipo::find($id);
        $produto_tipo -> user_id_updated = Auth::id();
        $produto_tipo -> nome = $request->nome;
        $produto_tipo -> descricao = $request->descricao;
        $produto_tipo -> save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */

    public function getDelete($id)
    {
        $produto_tipo = ProdutoTipo::find($id);
        $title = "Remover Tipo de Produto";
        // Show the page
        return view('admin.produto_tipo.delete', compact('produto_tipo','title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function postDelete(DeleteRequest $request,$id)
    {
        $produto_tipo = ProdutoTipo::find($id);
        $produto_tipo->delete();
    }


    /**
     * Show a list of all the languages posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data()
    {
        $produto_tipo = ProdutoTipo::select(array('produtos_tipos.id','produtos_tipos.nome', DB::raw('DATE_FORMAT(produtos_tipos.created_at,\'%d/%m/%Y %H:%i\') as criado_em')))
            ->orderBy('produtos_tipos.nome', 'ASC');

        return Datatables::of($produto_tipo)
            ->add_column('actions', '<a href="{{{ URL::to(\'admin/produtotipo/\' . $id . \'/edit\' ) }}}" class="btn btn-success btn-xs iframe" title="{{ trans("admin/modal.edit") }}" ><span class="glyphicon glyphicon-pencil"></span></a>
                    <a href="{{{ URL::to(\'admin/produtotipo/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe" title="{{ trans("admin/modal.delete") }}"><span class="glyphicon glyphicon-trash"></span></a>
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
                ProdutoTipo::where('id', '=', $value) -> update(array('position' => $order));
                $order++;
            }
        }
        return $list;
    }
}