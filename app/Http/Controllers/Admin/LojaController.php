<?php namespace App\Http\Controllers\Admin;
use Log;
use App\Http\Controllers\AdminController;
use App\Loja;
use App\LojaTipo;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\Admin\LojaRequest;
use App\Http\Requests\Admin\DeleteRequest;
use App\Http\Requests\Admin\ReorderRequest;
use Illuminate\Support\Facades\Auth;
use Datatables;
use DB;

class LojaController extends AdminController {

    /*
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        // Show the page
        return view('admin.loja.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
		$title = "Nova Loja";
        $lojastipos = LojaTipo::lists('nome','id')->all();
        // Show the page
        return view('admin.loja.create_edit', compact('title', 'lojastipos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate(LojaRequest $request)
    {
        $loja = new Loja();
        $loja -> user_id_created = Auth::id();
        $loja -> nome = $request->nome;
        $loja -> descricao = $request->descricao;
        $loja -> localizacao = $request->localizacao;
        $loja -> loja_tipo = $request->loja_tipo;
        $loja -> ativo = $request->ativo;

        $imagem = "";
        if(Input::hasFile('imagem'))
        {
            $file = Input::file('imagem');
            $filename = $file->getClientOriginalName();
            $extension = $file -> getClientOriginalExtension();
            $imagem = sha1($filename . time()) . '.' . $extension;
        }
        $loja -> imagem = $imagem;
        $loja -> save();

        if(Input::hasFile('imagem'))
        {
            $destinationPath = public_path() . '/images/loja/'.$loja->id.'/';
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
        $loja = Loja::find($id);
        $lojastipos = LojaTipo::lists('nome','id')->all();

        $title = 'Editar Loja';

        return view('admin.loja.create_edit',compact('loja','title', 'lojastipos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function postEdit(LojaRequest $request, $id)
    {
        $loja = Loja::find($id);
        $loja -> user_id_updated = Auth::id();
        $loja -> nome = $request->nome;
        $loja -> descricao = $request->descricao;
        $loja -> localizacao = $request->localizacao;
        $loja -> loja_tipo = $request->loja_tipo;
        $loja -> ativo = $request->ativo;

        if(Input::hasFile('imagem'))
        {
            $file = Input::file('imagem');
            $filename = $file->getClientOriginalName();
            $extension = $file -> getClientOriginalExtension();
            $imagem = sha1($filename . time()) . '.' . $extension;
            $loja -> imagem = $imagem;
        }
        $loja -> save();

        if(Input::hasFile('imagem'))
        {
            $destinationPath = public_path() . '/images/loja/'.$loja->id.'/';
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
        $loja = Loja::find($id);
        $title = "Remover Loja";
        // Show the page
        return view('admin.loja.delete', compact('loja','title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function postDelete(DeleteRequest $request,$id)
    {
        $loja = Loja::find($id);
        $loja->delete();
    }


    /**
     * Show a list of all the languages posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data()
    {
        $loja = Loja::select(array('lojas.id','lojas.nome', 'lojas.localizacao', 'lojas.ativo',  DB::raw('DATE_FORMAT(lojas.created_at,\'%d/%m/%Y %H:%i\') as criado_em')))
            ->orderBy('lojas.nome', 'ASC');

        return Datatables::of($loja)
            ->add_column('actions', '<a href="{{{ URL::to(\'admin/loja/\' . $id . \'/edit\' ) }}}" class="btn btn-success btn-xs iframe" title="{{ trans("admin/modal.edit") }}" ><span class="glyphicon glyphicon-pencil"></span></a>
                    <a href="{{{ URL::to(\'admin/loja/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe" title="{{ trans("admin/modal.delete") }}"><span class="glyphicon glyphicon-trash"></span></a>
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
                Loja::where('id', '=', $value) -> update(array('position' => $order));
                $order++;
            }
        }
        return $list;
    }
}
