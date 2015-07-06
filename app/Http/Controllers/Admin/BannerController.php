<?php namespace App\Http\Controllers\Admin;
use Log;
use App\Http\Controllers\AdminController;
use App\Banner;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\Admin\BannerRequest;
use App\Http\Requests\Admin\DeleteRequest;
use App\Http\Requests\Admin\ReorderRequest;
use Illuminate\Support\Facades\Auth;
use Datatables;
use DB;
use Carbon\Carbon;

class BannerController extends AdminController {

    /*
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        // Show the page
        return view('admin.banner.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
		$title = "Novo Banner";
        // Show the page
        return view('admin.banner.create_edit', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate(BannerRequest $request)
    {

        $data_inicio_array = explode('/', $request->dtinicio);
        $dtinicio = Carbon::createFromDate($data_inicio_array[2], $data_inicio_array[1],$data_inicio_array[0]);
        
        $data_fim_array = explode('/', $request->dtfim);
        $dtfim = Carbon::createFromDate($data_fim_array[2], $data_fim_array[1],$data_fim_array[0]);

        $banner = new Banner();
        $banner -> user_id_created = Auth::id();
        $banner -> nome = $request->nome;
        $banner -> url = $request->url;
        $banner -> dtinicio = $dtinicio;
        $banner -> dtfim = $dtfim;
        $banner -> html = $request->html;

        $imagem = "";
        if(Input::hasFile('imagem'))
        {
            $file = Input::file('imagem');
            $filename = $file->getClientOriginalName();
            $extension = $file -> getClientOriginalExtension();
            $imagem = sha1($filename . time()) . '.' . $extension;
        }
        $banner -> imagem = $imagem;
        $banner -> save();

        if(Input::hasFile('imagem'))
        {
            $destinationPath = public_path() . '/images/banner/'.$banner->id.'/';
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
        $banner = Banner::find($id);

        $title = 'Editar Banner';

        return view('admin.banner.create_edit',compact('banner','title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function postEdit(BannerRequest $request, $id)
    {
        $data_inicio_array = explode('/', $request->dtinicio);
        $data_fim_array = explode('/', $request->dtfim);
        
        $dtinicio   = Carbon::createFromDate($data_inicio_array[2], $data_inicio_array[1],$data_inicio_array[0]);
        $dtfim      = Carbon::createFromDate($data_fim_array[2], $data_fim_array[1],$data_fim_array[0]);
        
        $banner = Banner::find($id);
        $banner -> user_id_updated  = Auth::id();
        $banner -> nome             = $request->nome;
        $banner -> url              = $request->url;
        $banner -> dtinicio         = $dtinicio;
        $banner -> dtfim            = $dtfim;
        $banner -> html             = $request->html;

        if(Input::hasFile('imagem'))
        {
            $file = Input::file('imagem');
            $destinationPath = public_path() . '/images/banner/'.$banner->id.'/';
            $filename = $file->getClientOriginalName();
            $extension = $file -> getClientOriginalExtension();
            $imagem = sha1($filename . time()) . '.' . $extension;

            if($file->move($destinationPath, $imagem)){
                $banner -> imagem = $imagem;
            }            
        }
        $banner -> save();

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */

    public function getDelete($id)
    {
        $banner = Banner::find($id);
        $title = "Remover Banner";
        // Show the page
        return view('admin.banner.delete', compact('banner','title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function postDelete(DeleteRequest $request,$id)
    {
        $banner = Banner::find($id);
        $banner->delete();
    }


    /**
     * Show a list of all the languages posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data()
    {
        $banner = Banner::select(array('banners.id','banners.nome', DB::raw('DATE_FORMAT(banners.dtinicio,\'%d/%m/%Y\') as vigencia_inicio'), DB::raw('DATE_FORMAT(banners.dtfim,\'%d/%m/%Y\') as vigencia_termino'), DB::raw('DATE_FORMAT(banners.created_at,\'%d/%m/%Y %H:%i\') as criado_em')))
            ->orderBy('banners.nome', 'ASC');

        return Datatables::of($banner)
            ->add_column('actions', '<a href="{{{ URL::to(\'admin/banner/\' . $id . \'/edit\' ) }}}" class="btn btn-success btn-xs iframe" title="{{ trans("admin/modal.edit") }}" ><span class="glyphicon glyphicon-pencil"></span></a>
                    <a href="{{{ URL::to(\'admin/banner/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe" title="{{ trans("admin/modal.delete") }}"><span class="glyphicon glyphicon-trash"></span></a>
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
                Banner::where('id', '=', $value) -> update(array('position' => $order));
                $order++;
            }
        }
        return $list;
    }
}
