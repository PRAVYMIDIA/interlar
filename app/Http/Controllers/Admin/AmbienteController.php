<?php namespace App\Http\Controllers\Admin;
use Log;
use App\Http\Controllers\AdminController;
use App\Ambiente;
use App\Produto;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        $produtos = new Produto();
        $produtos = $produtos->lists('nome','id')->all();
        // Show the page
        return view('admin.ambiente.create_edit', compact('title','produtos'));
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

        # Salva o relacionamento muitos pra muitos do produtos->ambientes
        if($request->produto_ambiente){
            $ambiente->produtos()->sync($request->produto_ambiente);
        }

        if(Input::hasFile('imagem'))
        {
            $destinationPath = public_path() . '/images/ambiente/'.$ambiente->id.'/';
            $file->move($destinationPath, $imagem);
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

        $produtos = new Produto();
        $produtos = $produtos->lists('nome','id')->all();

        $produtos_ambientes = array();
        if( $ambiente->produtos ){
            foreach ($ambiente->produtos as $produto) {
                $produtos_ambientes[$produto->id] = $produto->nome;
            }
        }

        $title = 'Editar Ambiente';

        return view('admin.ambiente.create_edit',compact('ambiente','title','produtos_ambientes','produtos'));
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
            $destinationPath = public_path() . '/images/ambiente/'.$ambiente->id.'/';
            $filename = $file->getClientOriginalName();
            $extension = $file -> getClientOriginalExtension();
            $imagem = sha1($filename . time()) . '.' . $extension;

            if($file->move($destinationPath, $imagem)){
                $ambiente -> imagem = $imagem;
            }            
        }
        $ambiente -> save();

        # Salva o relacionamento muitos pra muitos do produtos->ambientes
        if($request->produto_ambiente){
            $ambiente->produtos()->sync($request->produto_ambiente);
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
    public function data(Request $request)
    {
        $ambiente = Ambiente::select(array('ambientes.nome',DB::raw('(SELECT COUNT(1) FROM ambiente_produto WHERE ambiente_produto.ambiente_id = ambientes.id)') ,'ambientes.created_at','ambientes.id'));

        $dt = Datatables::of($ambiente)
            ->editColumn('created_at', function ($produto) {
                return $produto->created_at ? with(new \Carbon\Carbon($produto->created_at))->format('d/m/Y H:i') : '';

            })
            ->add_column('actions', '<a href="{{{ URL::to(\'admin/ambiente/\' . $id . \'/edit\' ) }}}" class="btn btn-success btn-xs iframe" title="{{ trans("admin/modal.edit") }}" ><span class="glyphicon glyphicon-pencil"></span></a>
                    <a href="{{{ URL::to(\'admin/ambiente/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe" title="{{ trans("admin/modal.delete") }}"><span class="glyphicon glyphicon-trash"></span></a>
                    <input type="hidden" name="row" value="{{$id}}" id="row">')
            ->remove_column('id');

        $dt->filter(function ($q) use ($request) {
            if ( $term = strtolower($request['search']['value']) ) {
                $q->where('ambientes.nome', 'like', "%{$term}%");

                // verifica se é uma data
                if(strpos($term, '/')){
                    $data_array = explode('/', $term);
                    if(count($data_array)==3){
                        $formato_db = '%Y-%m-%d';
                        if( strlen( $data_array[2] ) == 4  ){
                            $format = 'd/m/Y';
                        }elseif( strlen( $data_array[2] ) == 2  ){
                            $format = 'd/m/y';
                        }else{
                            $format = null;
                        }
                        // se existe espaço logo busca o horário
                        $format_time = '';
                        if(strpos($term, ' ')){
                            $data_hora_array = explode(' ', $term);
                            $horario_array = explode(':', $data_hora_array[1]);
                            if(count($horario_array)==3){
                                if( strlen($horario_array[2])==2 ){
                                    $format_time = ' H:i:s';
                                    $formato_db = '%Y-%m-%d %H:%i:%s';
                                    $format = 'd/m/Y'.$format_time;
                                }else{
                                    $format = null;
                                }
                            }elseif(count($horario_array)==2){
                                if( strlen($horario_array[1])==2 ){
                                    $format_time = ' H:i';
                                    $formato_db = '%Y-%m-%d %H:%i';
                                    $format = 'd/m/Y'.$format_time;
                                }else{
                                    $format = null;
                                }
                            }elseif(count($horario_array)==1){
                                if( strlen($horario_array[0])==2 ){
                                    $format_time = ' H';
                                    $formato_db = '%Y-%m-%d %H';
                                    $format = 'd/m/Y'.$format_time;
                                }else{
                                    $format = null;
                                }
                            }else{
                                $format = null;
                            }
                        }
                        if($format){
                            try {
                                $date =  \Carbon\Carbon::createFromFormat($format ,$term);
                                $q->orWhere(DB::raw("DATE_FORMAT(ambientes.created_at,'".$formato_db."')"), '=', $date->format('Y-m-d'.$format_time));
                            } catch (Exception $e) {
                                // \_(''/)_/
                            }
                        }
                        
                    }else{
                        $q->orWhere( 'ambientes.created_at' , 'LIKE', '%'. $data_array[0].isset($data_array[1])?'-'.$data_array[1]:null. '%');
                    }
                }
                
            }
        });

        return    $dt->make();
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
