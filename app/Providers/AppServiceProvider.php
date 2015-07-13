<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use App\Ambiente;
use App\ProdutoTipo;
use App\Banner;
use App\Visita;
use App\LojaTipo;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        $ambientes      = new Ambiente();
        $ambientes      = $ambientes->lists('nome','id')->all();

        $tipos          = new ProdutoTipo();
        $tipos          = $tipos->lists('nome','id')->all();

        $lojastipos          = new LojaTipo();
        $lojastipos          = $lojastipos->lists('nome','id')->all();

        $banner     = new Banner();
        $banner     = $banner->where('dtinicio','<=',date('Y-m-d'))->where('dtfim','>=',date('Y-m-d'))->orderByRaw("RAND()")->first();


        if($banner){
            $visita = new Visita();
            $visita->ip = $request->ip();
            $banner->visitas()->save($visita);
        }

        view()->share('ambientes', $ambientes);
        view()->share('tipos', $tipos);
        view()->share('lojastipos', $lojastipos);
        view()->share('banner', $banner);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
