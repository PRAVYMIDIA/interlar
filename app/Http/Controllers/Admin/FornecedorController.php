<?php namespace App\Http\Controllers\Admin;
use Log;
use App\Http\Controllers\AdminController;
use App\Fornecedor;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\Admin\FornecedorRequest;
use App\Http\Requests\Admin\DeleteRequest;
use App\Http\Requests\Admin\ReorderRequest;
use Illuminate\Support\Facades\Auth;
use Datatables;
use DB;

class FornecedorController extends AdminController {

    /*
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        // Show the page
        return view('admin.fornecedor.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
		$title = "Novo Fornecedor";
        // Show the page
        return view('admin.fornecedor.create_edit', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate(FornecedorRequest $request)
    {
        $fornecedor = new Fornecedor();
        $fornecedor -> user_id_created = Auth::id();
        $fornecedor -> nome = $request->nome;
        $fornecedor -> descricao = $request->descricao;

        $fornecedor -> save();
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function getEdit($id)
    {
        $fornecedor = Fornecedor::find($id);

        $title = 'Editar Fornecedor';

        return view('admin.fornecedor.create_edit',compact('fornecedor','title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function postEdit(FornecedorRequest $request, $id)
    {
        $fornecedor = Fornecedor::find($id);
        $fornecedor -> user_id_updated = Auth::id();
        $fornecedor -> nome = $request->nome;
        $fornecedor -> descricao = $request->descricao;
        $fornecedor -> save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */

    public function getDelete($id)
    {
        $fornecedor = Fornecedor::find($id);
        $title = "Remover Fornecedor";
        // Show the page
        return view('admin.fornecedor.delete', compact('fornecedor','title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function postDelete(DeleteRequest $request,$id)
    {
        $fornecedor = Fornecedor::find($id);
        $fornecedor->delete();
    }


    /**
     * Show a list of all the languages posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data()
    {
        $fornecedor = Fornecedor::select(array('fornecedores.id','fornecedores.nome', DB::raw('DATE_FORMAT(fornecedores.created_at,\'%d/%m/%Y %H:%i\') as criado_em')))
            ->orderBy('fornecedores.nome', 'ASC');

        return Datatables::of($fornecedor)
            ->add_column('actions', '<a href="{{{ URL::to(\'admin/fornecedor/\' . $id . \'/edit\' ) }}}" class="btn btn-success btn-xs iframe" title="{{ trans("admin/modal.edit") }}" ><span class="glyphicon glyphicon-pencil"></span></a>
                    <a href="{{{ URL::to(\'admin/fornecedor/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe" title="{{ trans("admin/modal.delete") }}"><span class="glyphicon glyphicon-trash"></span></a>
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
                Fornecedor::where('id', '=', $value) -> update(array('position' => $order));
                $order++;
            }
        }
        return $list;
    }
}
