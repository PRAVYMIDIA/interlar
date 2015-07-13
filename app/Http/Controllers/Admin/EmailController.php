<?php namespace App\Http\Controllers\Admin;
use Log;
use App\Http\Controllers\AdminController;
use App\Email;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\Admin\EmailRespostaRequest;
use App\Http\Requests\Admin\DeleteRequest;
use App\Http\Requests\Admin\ReorderRequest;
use Illuminate\Support\Facades\Auth;
use Datatables;
use DB;
use Excel;
use Illuminate\Http\Request;

class EmailController extends AdminController {

    /*
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        // Show the page
        return view('admin.email.index');
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */

    public function getDelete($id)
    {
        $email = Email::find($id);
        $title = "Remover Email";
        // Show the page
        return view('admin.email.delete', compact('email','title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function postDelete(DeleteRequest $request,$id)
    {
        $email = Email::find($id);
        $email->delete();
    }

    public function getNewsletter(){

        $emails = Email::select('email','created_at')->get();
 
        $email = Excel::create('newsletter', function($excel) use ($emails) {

            $excel->sheet('Planilha1', function($sheet) use ($emails)  {

                $sheet->fromModel($emails);

            });

        });

        return $email->download('xlsx');
    }


    /**
     * Show a list of all the languages posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data(Request $request)
    {
        $email = Email::select(array('emails.id',
                                        'emails.email',
                                        'emails.pagina',
                                        'ambientes.nome',
                                        'produtos_tipos.nome as tipo',
                                        'emails.created_at'))
            ->leftJoin('ambientes','ambientes.id','=','emails.ambiente_id')
            ->leftJoin('produtos_tipos','produtos_tipos.id','=','emails.produto_tipo_id')
            ->orderBy('emails.id', 'DESC');

        $dt = Datatables::of($email)
            ->editColumn('created_at', function ($email) {
                return $email->created_at ? with(new \Carbon\Carbon($email->created_at))->format('d/m/Y H:i') : '';
            })
            ->add_column('actions', '<a href="{{{ URL::to(\'admin/email/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe" title="{{ trans("admin/modal.delete") }}"><span class="glyphicon glyphicon-trash"></span></a>')
            ->remove_column('id');


        $dt->filter(function ($q) use ($request) {
            if ( $term = strtolower($request['search']['value']) ) {
                $q->where('emails.email', 'like', "%{$term}%");
                $q->orWhere('emails.pagina', 'like', "%{$term}%");
                $q->orWhere('ambientes.nome', 'like', "%{$term}%");
                $q->orWhere('produtos_tipos.nome', 'like', "%{$term}%");

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
                                $q->orWhere(DB::raw("DATE_FORMAT(emails.created_at,'".$formato_db."')"), '=', $date->format('Y-m-d'.$format_time));
                            } catch (Exception $e) {
                                // \_(''/)_/
                            }
                        }else{
                            $q->orWhere( 'emails.created_at' , 'LIKE', '%'. $term. '%');
                        }
                        
                    }else{
                        $q->orWhere( 'emails.created_at' , 'LIKE', '%'. $data_array[0].isset($data_array[1])?'-'.$data_array[1]:null. '%');
                    }
                }else{
                    $q->orWhere( 'emails.created_at' , 'LIKE', '%'. $term. '%');
                }
                
            }
        });
        

        // Global search function
        /*if ($keyword = $request->input('search')) {
            $dt->filterColumn('tipo', 'whereRaw', "produtos_tipos.nome IS NOT NULL");
            // $dt->filterColumn('tipo', 'whereRaw', "produtos_tipos.nome like ?", ["%{$keyword}%"]);
        }*/

        return    $dt->make();
    }

    
}
