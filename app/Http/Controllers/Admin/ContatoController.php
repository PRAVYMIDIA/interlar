<?php namespace App\Http\Controllers\Admin;
use Log;
use App\Http\Controllers\AdminController;
use App\Contato;
use App\ContatoResposta;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\Admin\ContatoRespostaRequest;
use App\Http\Requests\Admin\DeleteRequest;
use App\Http\Requests\Admin\ReorderRequest;
use Illuminate\Support\Facades\Auth;
use Datatables;
use DB;
use Mail;

class ContatoController extends AdminController {

    /*
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        // Show the page
        return view('admin.contato.index');
    }



    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate(ContatoRespostaRequest $request)
    {
        $contatoResposta = new ContatoResposta();
        $contatoResposta -> user_id_created = Auth::id();
        $contatoResposta -> mensagem    = $request->mensagem;
        $contatoResposta -> contato_id  = $request->contato_id;
        $contatoResposta -> tipo        = $request->tipo;
        $contatoResposta->save();
        
        if($contatoResposta->tipo=='EMAIL')
        {
            $contato_array = array(
                'nome'      => $contatoResposta->usuario->name,
                'email'     => $contatoResposta->usuario->email,
                'mensagem'  => $contatoResposta->mensagem,
                'mensagem_recebida'  => $contatoResposta->contato->mensagem,
            );
            $contato = $contatoResposta->contato;
            $subject = 'RE: Site Interlar - Contato';

            if($contato->produto_id){
                $subject = 'RE: Site Interlar - Interesse pelo produto '.$contato->produto->nome;
                $contato_array['mensagem_recebida'] .= $contato->produto->nome;
            }

            $envio = Mail::send('emails.contato_resposta', $contato_array, function($m) use ($contato,$subject){
                $m->to($contato->email,$contato->nome)->subject($subject);
            });
            if($envio){
                $contatoResposta->enviada = 1;
                $contatoResposta->save();
            }
        }else{
            // @TODO Integração Zenvia
        }
        

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function getVisualizar($id)
    {
        $contato = Contato::find($id);


        $respostas = $contato->respostas;

        $title = 'Exibir Contato';

        return view('admin.contato.view',compact('contato','title','respostas'));
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */

    public function getDelete($id)
    {
        $contato = Contato::find($id);
        $title = "Remover Contato";
        // Show the page
        return view('admin.contato.delete', compact('contato','title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function postDelete(DeleteRequest $request,$id)
    {
        $contato = Contato::find($id);
        $contato->delete();
    }


    /**
     * Show a list of all the languages posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data(\Illuminate\Http\Request $request)
    {
        $contato = Contato::select(array('contatos.id',
                                        'contatos.nome',
                                        DB::raw('(SELECT COUNT(1) FROM contato_respostas WHERE contato_respostas.contato_id = contatos.id) as qtd_respostas'),
                                        'contatos.produto_id',
                                        'contatos.created_at'));

        $dt = Datatables::of($contato)
            ->editColumn('created_at', function ($contato) {
                return $contato->created_at ? with(new \Carbon\Carbon($contato->created_at))->format('d/m/Y H:i') : '';
            })
            ->edit_column('produto_id','{{ $produto_id ? \'PRODUTO\':\'CONTATO\' }}')
            ->add_column('actions', '<a href="{{{ URL::to(\'admin/contato/\' . $id . \'/visualizar\' ) }}}" class="btn btn-success btn-xs iframe" title="Visualizar/Responder" ><span class="fa fa-eye"></span></a>
                    <a href="{{{ URL::to(\'admin/contato/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe" title="{{ trans("admin/modal.delete") }}"><span class="glyphicon glyphicon-trash"></span></a>')
            ->remove_column('id');

        $dt->filter(function ($q) use ($request) {
            if ( $term = strtolower($request['search']['value']) ) {
                $q->where('contatos.nome', 'like', "%{$term}%");

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
                                $q->orWhere(DB::raw("DATE_FORMAT(contatos.created_at,'".$formato_db."')"), '=', $date->format('Y-m-d'.$format_time));
                            } catch (Exception $e) {
                                // \_(''/)_/
                            }
                        }else{
                            $q->orWhere( 'contatos.created_at' , 'LIKE', '%'. $term. '%');
                        }
                        
                    }else{
                        $q->orWhere( 'contatos.created_at' , 'LIKE', '%'. $data_array[0].isset($data_array[1])?'-'.$data_array[1]:null. '%');
                    }
                }else{
                    $q->orWhere( 'contatos.created_at' , 'LIKE', '%'. $term. '%');
                }
                
            }
        });

        return $dt->make();
    }

    
}
