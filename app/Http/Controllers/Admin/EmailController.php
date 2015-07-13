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
        $email = Email::select(array('emails.id','emails.email','emails.pagina','ambientes.nome','produtos_tipos.nome as tipo',DB::raw('DATE_FORMAT(emails.created_at,\'%d/%m/%Y %H:%i\') as criado_em')))
            ->leftJoin('ambientes','ambientes.id','=','emails.ambiente_id')
            ->leftJoin('produtos_tipos','produtos_tipos.id','=','emails.produto_tipo_id')
            ->orderBy('emails.id', 'DESC');

        $datatables = Datatables::of($email)
            ->add_column('actions', '<a href="{{{ URL::to(\'admin/email/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe" title="{{ trans("admin/modal.delete") }}"><span class="glyphicon glyphicon-trash"></span></a>')
            ->remove_column('id');
        

        // Global search function
        /*if ($keyword = $request->input('search')) {
            $datatables->filterColumn('tipo', 'whereRaw', "produtos_tipos.nome IS NOT NULL");
            // $datatables->filterColumn('tipo', 'whereRaw', "produtos_tipos.nome like ?", ["%{$keyword}%"]);
        }*/

        return    $datatables->make();
    }

    
}
