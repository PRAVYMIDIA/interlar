<?php namespace App\Http\Controllers\Admin;
use Log;
use App\Http\Controllers\AdminController;
use App\LojaTipo;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\Admin\LojaTipoRequest;
use App\Http\Requests\Admin\DeleteRequest;
use App\Http\Requests\Admin\ReorderRequest;
use Illuminate\Support\Facades\Auth;
use Datatables;
use DB;

class LojaTipoController extends AdminController {

    /*
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        // Show the page
        return view('admin.lojatipo.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
		$title = "Novo Tipo de Loja - Segmento";
        // Show the page
        return view('admin.lojatipo.create_edit', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate(LojaTipoRequest $request)
    {
        $lojatipo = new LojaTipo();
        $lojatipo -> user_id_created = Auth::id();
        $lojatipo -> nome = $request->nome;
        $lojatipo -> descricao = $request->descricao;
        $lojatipo -> ativo = $request->ativo;

        $lojatipo -> save();
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function getEdit($id)
    {
        $lojatipo = LojaTipo::find($id);

        $title = 'Editar Tipo de Loja - Segmento';

        return view('admin.lojatipo.create_edit',compact('lojatipo','title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function postEdit(LojaTipoRequest $request, $id)
    {
        $lojatipo = LojaTipo::find($id);
        $lojatipo -> user_id_updated = Auth::id();
        $lojatipo -> nome = $request->nome;
        $lojatipo -> descricao = $request->descricao;
        $lojatipo -> ativo = $request->ativo;

        $lojatipo -> save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */

    public function getDelete($id)
    {
        $lojatipo = LojaTipo::find($id);
        $title = "Remover Tipo de Loja";
        // Show the page
        return view('admin.lojatipo.delete', compact('lojatipo','title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function postDelete(DeleteRequest $request,$id)
    {
        $lojatipo = LojaTipo::find($id);
        $lojatipo->delete();
    }


    /**
     * Show a list of all the languages posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data()
    {
        $lojatipo = LojaTipo::select(array('lojas_tipos.id','lojas_tipos.nome', 'lojas_tipos.ativo',  DB::raw('DATE_FORMAT(lojas_tipos.created_at,\'%d/%m/%Y %H:%i\') as criado_em')))
            ->orderBy('lojas_tipos.nome', 'ASC');

        return Datatables::of($lojatipo)
            ->add_column('actions', '<a href="{{{ URL::to(\'admin/lojatipo/\' . $id . \'/edit\' ) }}}" class="btn btn-success btn-xs iframe" title="{{ trans("admin/modal.edit") }}" ><span class="glyphicon glyphicon-pencil"></span></a>
                    <a href="{{{ URL::to(\'admin/lojatipo/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe" title="{{ trans("admin/modal.delete") }}"><span class="glyphicon glyphicon-trash"></span></a>
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
                LojaTipo::where('id', '=', $value) -> update(array('position' => $order));
                $order++;
            }
        }
        return $list;
    }
}
