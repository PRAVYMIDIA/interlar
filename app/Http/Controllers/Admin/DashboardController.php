<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Ambiente;
use App\ProdutoTipo;
use App\Produto;
use App\Loja;
use App\Fornecedor;
use App\Banner;

class DashboardController extends AdminController {

    public function __construct()
    {
        parent::__construct();
    }

	public function index()
	{
        $title = "Painel";

        $ambientes      = Ambiente::count();
        $tipos          = ProdutoTipo::count();
        $produtos       = Produto::count();
        $fornecedores   = Fornecedor::count();
        $lojas          = Loja::count();
        $banners        = Banner::count();
		return view('admin.dashboard.index',  compact('title','ambientes','tipos','produtos','fornecedores','lojas',
            'banners'));
	}
}