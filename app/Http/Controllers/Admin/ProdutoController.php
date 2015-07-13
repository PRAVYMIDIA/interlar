<?php namespace App\Http\Controllers\Admin;
use Log;
use App\Http\Controllers\AdminController;
use App\Produto;
use App\ProdutoTipo;
use App\ProdutoImagem;
use App\Fornecedor;
use App\Ambiente;
use App\LojaTipo;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\Admin\ProdutoRequest;
use App\Http\Requests\Admin\DeleteRequest;
use App\Http\Requests\Admin\ReorderRequest;
use Illuminate\Support\Facades\Auth;
use Datatables;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;


class ProdutoController extends AdminController {

    /*
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        // Show the page
        return view('admin.produto.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
		$title = "Novo Produto";
        $produtos_tipos = ProdutoTipo::lists('nome','id')->all();
        $fornecedores = Fornecedor::lists('nome','id')->all();

        $ambientes = new Ambiente();
        $ambientes = $ambientes->lists('nome','id')->all();

        $lojastipos = new LojaTipo();
        $lojastipos = $lojastipos->lists('nome','id')->all();
        // Show the page
        return view('admin.produto.create_edit', compact('title','produtos_tipos','fornecedores','lojastipos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate(ProdutoRequest $request)
    {
        $produto = new Produto();
        $produto -> user_id_created = Auth::id();
        $produto -> nome = $request->nome;
        $produto -> produto_tipo_id = $request->produto_tipo_id;
        $produto -> fornecedor_id = $request->fornecedor_id;
        $produto -> valor = $request->valor;
        $produto -> valor_promocional = $request->valor_promocional;
        $produto -> parcelas = $request->parcelas;
        $produto -> descricao = $request->descricao;

        $imagem = "";
        if(Input::hasFile('imagem'))
        {
            $file = Input::file('imagem');
            $filename = $file->getClientOriginalName();
            $extension = $file -> getClientOriginalExtension();
            $imagem = sha1($filename . time()) . '.' . $extension;
            $produto -> imagem = $imagem;
        }
        
        $produto -> save();
        
        $destinationPath = public_path() . '/images/produto/'.$produto->id.'/';
        if(Input::hasFile('imagem'))
        {
            Input::file('imagem')->move($destinationPath, $imagem);
            # Gera miniatura
            $produto->thumb();
        }

        # Salva o relacionamento muitos pra muitos do produtos->ambientes
        if($request->produto_ambiente){
            $produto->ambientes()->sync($request->produto_ambiente);
        }

        # Salva o relacionamento muitos pra muitos do produtos->lojasTipos
        if($request->produto_lojatipo){
            $produto->lojasTipos()->sync($request->produto_lojatipo);
        }

        // Demais imagens do produto
        $imagens = $request->produto_imagem;

        if( count($imagens) ){
            foreach ($imagens as $file) {
                if($file){
                    $filename = $file->getClientOriginalName();
                    $extension = $file -> getClientOriginalExtension();
                    $imagem = sha1($filename . time()) . '.' . $extension;
                    $produto_imagem = new ProdutoImagem(['imagem'=>$imagem,'user_id_created'=>Auth::id()]);
                    $produto->imagens()->save($produto_imagem);
                    # Copia a imagem pra pasta do produto
                    
                    $file->move($destinationPath, $imagem);    
                }
            }
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
        $produto = Produto::find($id);
        $produtos_tipos = ProdutoTipo::lists('nome','id')->all();
        $fornecedores = Fornecedor::lists('nome','id')->all();
        $ambientes = new Ambiente();
        $ambientes = $ambientes->lists('nome','id')->all();

        $lojastipos = new LojaTipo();
        $lojastipos = $lojastipos->lists('nome','id')->all();

        $produtos_ambientes = array();
        if( $produto->ambientes ){
            foreach ($produto->ambientes as $ambiente) {
                $produtos_ambientes[$ambiente->id] = $ambiente->nome;
            }
        }

        $produtos_lojastipos = array();
        if( $produto->lojasTipos ){
            foreach ($produto->lojasTipos as $lojatipo) {
                $produtos_lojastipos[$lojatipo->id] = $lojatipo->nome;
            }
        }

        $title = 'Editar Produto';

        return view('admin.produto.create_edit',compact('produto','title','produtos_tipos','fornecedores','ambientes','lojastipos','produtos_lojastipos','produtos_ambientes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function postEdit(ProdutoRequest $request, $id)
    {
        $produto = Produto::find($id);
        $produto -> user_id_updated     = Auth::id();
        $produto -> nome                = $request->nome;
        $produto -> produto_tipo_id     = $request->produto_tipo_id;
        $produto -> fornecedor_id       = $request->fornecedor_id;
        $produto -> valor               = $request->valor;
        $produto -> valor_promocional   = $request->valor_promocional;
        $produto -> parcelas            = $request->parcelas;
        $produto -> descricao           = $request->descricao;

        $destinationPath = public_path() . '/images/produto/'.$produto->id.'/';
        if(Input::hasFile('imagem'))
        {
            $file = Input::file('imagem');
            $filename = $file->getClientOriginalName();
            $extension = $file -> getClientOriginalExtension();
            $imagem = sha1($filename . time()) . '.' . $extension;
            Input::file('imagem')->move($destinationPath, $imagem);
            $produto -> imagem = $imagem;
        }
        $produto -> save();

        # Salva o relacionamento muitos pra muitos do produtos->ambientes
        $produto_ambiente = array();
        if($request->produto_ambiente){
            $produto_ambiente = $request->produto_ambiente;
        }    
        // $produto->ambientes()->attach($ambiente_id,['user_id_created' => Auth::id()]);
        $produto->ambientes()->sync($produto_ambiente);
        


        # Salva o relacionamento muitos pra muitos do produtos->lojasTipos

        $produto_lojatipo = ($request->produto_lojatipo? $request->produto_lojatipo: array());
        
        $produto->lojasTipos()->sync($produto_lojatipo);
        

        // Demais imagens do produto
        $imagens = $request->produto_imagem;

        if( count($imagens) ){
            foreach ($imagens as $file) {
                if($file){
                    $filename = $file->getClientOriginalName();
                    $extension = $file -> getClientOriginalExtension();
                    $imagem = sha1($filename . time()) . '.' . $extension;
                    $produto_imagem = new ProdutoImagem(['imagem'=>$imagem,'user_id_created'=>Auth::id()]);
                    $produto->imagens()->save($produto_imagem);
                    # Copia a imagem pra pasta do produto
                    
                    $file->move($destinationPath, $imagem);
                }
                
            }
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
        $produto = Produto::find($id);
        $title = "Remover Produto";
        // Show the page
        return view('admin.produto.delete', compact('produto','title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function postDelete(DeleteRequest $request,$id)
    {
        $produto = Produto::find($id);
        $produto->delete();
    }


    /**
     * Show a list of all the languages posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data(Request $request)
    {
        $produto = Produto::leftJoin('produtos_tipos','produtos_tipos.id','=','produtos.produto_tipo_id')
            // ->leftJoin('fornecedores','fornecedores.id','=','produtos.fornecedor_id')
            ->select(array(
                                        'produtos.id',
                                        'produtos.nome', 
                                        'produtos_tipos.nome as nometipo', 
                                        'produtos.valor',
                                        'produtos.valor_promocional',
                                        'produtos.parcelas',
                                        'produtos.imagem',
                                        'produtos.created_at'
                                        )
                                    )
            ->orderBy('produtos.nome', 'ASC');

        $dt = Datatables::of($produto);

        $dt->edit_column('valor_promocional','{!! $valor_promocional!=\'\'? \'<span class="label label-danger">\'.  $valor_promocional. \'</span>\' : \'\' !!}')
            ->edit_column('imagem','{!! strlen($imagem)? \'<img src="/images/produto/\' . $id . \'/thumb_200x200_\' . $imagem . \'" width="100" />\':\'\' !!}')
            ->editColumn('created_at', function ($produto) {
                return $produto->created_at ? with(new Carbon($produto->created_at))->format('d/m/Y H:i') : '';

            })
            ->add_column('actions', '<a href="{{{ URL::to(\'admin/produto/\' . $id . \'/edit\' ) }}}" class="btn btn-success btn-xs iframe" title="{{ trans("admin/modal.edit") }}" ><span class="glyphicon glyphicon-pencil"></span></a>
                    <a href="{{{ URL::to(\'admin/produto/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe" title="{{ trans("admin/modal.delete") }}"><span class="glyphicon glyphicon-trash"></span></a>
                    <input type="hidden" name="row" value="{{$id}}" id="row">')
            ->remove_column('id');

        $dt->filter(function ($q) use ($request) {
            if ( $term = strtolower($request['search']['value']) ) {
                $q->where('produtos.nome', 'like', "%{$term}%");
                $q->Orwhere('produtos_tipos.nome', 'like', "%{$term}%");
                $q->Orwhere('produtos.valor', 'like', "%{$term}%");
                $q->Orwhere('produtos.valor_promocional', 'like', "%{$term}%");
                $q->Orwhere('produtos.parcelas', 'like', "%{$term}%");
                try {
                    $date = new \Carbon\Carbon($term);
                    $q->orWhere(DB::raw('DATE(produtos.created_at)'), '=', $date->format('Y-m-d'));
                } catch (Exception $e) {
                    // \_(''/)_/
                }
            }
        });
        return     $dt->make();
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
                Produto::where('id', '=', $value) -> update(array('position' => $order));
                $order++;
            }
        }
        return $list;
    }


    /**
     * Remove a imagem extra
     *
     * @param $id
     * @return Response
     */

    public function getRemoverImagem($id)
    {
        $produto_imagem = ProdutoImagem::find($id);
        # Remove o arquivo fisíco
        $destinationPath = public_path() . '/images/produto/'.$produto_imagem->produto_id.'/';

        if(file_exists( $destinationPath.$produto_imagem->imagem )){
            unlink( $destinationPath.$produto_imagem->imagem );
            if(file_exists( $destinationPath.'thumb_'.$produto_imagem->imagem )){
                unlink( $destinationPath.'thumb_'.$produto_imagem->imagem );
            }
        }
        $produto_imagem->delete();
        
    }
}
