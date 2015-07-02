<?php namespace App\Http\Controllers\Admin;
use Log;
use App\Http\Controllers\AdminController;
use App\Ambiente;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\Admin\AmbienteRequest;
use App\Http\Requests\Admin\DeleteRequest;
use App\Http\Requests\Admin\ReorderRequest;
use Illuminate\Support\Facades\Auth;
use Datatables;
use DB;

class AmbienteController extends AdminController {

    /*
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        // Show the page
        return view('admin.ambiente.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
		$title = "Novo Ambiente";
        // Show the page
        return view('admin.ambiente.create_edit', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate(AmbienteRequest $request)
    {
        $ambiente = new Ambiente();
        $ambiente -> user_id_created = Auth::id();
        $ambiente -> nome = $request->nome;
        $ambiente -> descricao = $request->descricao;

        $imagem = "";
        if(Input::hasFile('imagem'))
        {
            $file = Input::file('imagem');
            $filename = $file->getClientOriginalName();
            $extension = $file -> getClientOriginalExtension();
            $imagem = sha1($filename . time()) . '.' . $extension;
        }
        $ambiente -> imagem = $imagem;
        $ambiente -> save();

        if(Input::hasFile('imagem'))
        {
            $destinationPath = public_path() . '/images/ambiente/'.$ambiente->id.'/';
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
        $ambiente = Ambiente::find($id);

        $title = 'Editar Ambiente';

        return view('admin.ambiente.create_edit',compact('ambiente','title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function postEdit(AmbienteRequest $request, $id)
    {
        $ambiente = Ambiente::find($id);
        $ambiente -> user_id_updated = Auth::id();
        $ambiente -> nome = $request->nome;
        $ambiente -> descricao = $request->descricao;

        if(Input::hasFile('imagem'))
        {
            $file = Input::file('imagem');
            $filename = $file->getClientOriginalName();
            $extension = $file -> getClientOriginalExtension();
            $imagem = sha1($filename . time()) . '.' . $extension;
            $ambiente -> imagem = $imagem;
        }
        $ambiente -> save();

        if(Input::hasFile('imagem'))
        {
            $destinationPath = public_path() . '/images/ambiente/'.$ambiente->id.'/';
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
        $ambiente = Ambiente::find($id);
        $title = "Remover Ambiente";
        // Show the page
        return view('admin.ambiente.delete', compact('ambiente','title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function postDelete(DeleteRequest $request,$id)
    {
        $ambiente = Ambiente::find($id);
        $ambiente->delete();
    }


    /**
     * Show a list of all the languages posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data()
    {
        $ambiente = Ambiente::select(array('ambientes.id','ambientes.nome', DB::raw('DATE_FORMAT(ambientes.created_at,\'%d/%m/%Y %H:%i\') as criado_em')))
            ->orderBy('ambientes.nome', 'ASC');

        return Datatables::of($ambiente)
            ->add_column('actions', '<a href="{{{ URL::to(\'admin/ambiente/\' . $id . \'/edit\' ) }}}" class="btn btn-success btn-xs iframe" title="{{ trans("admin/modal.edit") }}" ><span class="glyphicon glyphicon-pencil"></span></a>
                    <a href="{{{ URL::to(\'admin/ambiente/\' . $id . \'/addprodutos\' ) }}}" class="btn btn-info btn-xs iframe" title="Adicionar Produtos" ><span class="fa fa-diamond"></span></a>
                    <a href="{{{ URL::to(\'admin/ambiente/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe" title="{{ trans("admin/modal.delete") }}"><span class="glyphicon glyphicon-trash"></span></a>
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
                Ambiente::where('id', '=', $value) -> update(array('position' => $order));
                $order++;
            }
        }
        return $list;
    }
}
