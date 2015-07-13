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
    public function data(\Illuminate\Http\Request $request)
    {
        $fornecedor = Fornecedor::select(array( 'fornecedores.id',
                                                'fornecedores.nome',
                                                'fornecedores.created_at'))
            ->orderBy('fornecedores.nome','ASC');

        $dt =  Datatables::of($fornecedor)
            ->editColumn('created_at', function ($fornecedor) {
                return $fornecedor->created_at ? with(new \Carbon\Carbon($fornecedor->created_at))->format('d/m/Y H:i') : '';
            })
            ->add_column('actions', '<a href="{{{ URL::to(\'admin/fornecedor/\' . $id . \'/edit\' ) }}}" class="btn btn-success btn-xs iframe" title="{{ trans("admin/modal.edit") }}" ><span class="glyphicon glyphicon-pencil"></span></a>
                    <a href="{{{ URL::to(\'admin/fornecedor/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe" title="{{ trans("admin/modal.delete") }}"><span class="glyphicon glyphicon-trash"></span></a>
                    <input type="hidden" name="row" value="{{$id}}" id="row">')
            ->remove_column('id');

            

        $dt->filter(function ($q) use ($request) {
            if ( $term = strtolower($request['search']['value']) ) {
                $q->where('fornecedores.nome', 'like', "%{$term}%");

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
                                $q->orWhere(DB::raw("DATE_FORMAT(fornecedores.created_at,'".$formato_db."')"), '=', $date->format('Y-m-d'.$format_time));
                            } catch (Exception $e) {
                                // \_(''/)_/
                            }
                        }else{
                            $q->orWhere( 'fornecedores.created_at' , 'LIKE', '%'. $term. '%');
                        }
                        
                    }else{
                        $q->orWhere( 'fornecedores.created_at' , 'LIKE', '%'. $data_array[0].isset($data_array[1])?'-'.$data_array[1]:null. '%');
                    }
                }else{
                    $q->orWhere( 'fornecedores.created_at' , 'LIKE', '%'. $term. '%');
                }
                
            }
        });

        
        return $dt->make();
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
