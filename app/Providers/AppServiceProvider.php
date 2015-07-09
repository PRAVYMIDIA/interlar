<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Ambiente;
use App\ProdutoTipo;
use App\Banner;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $ambientes      = new Ambiente();
        $ambientes      = $ambientes->lists('nome','id')->all();

        $tipos          = new ProdutoTipo();
        $tipos          = $tipos->lists('nome','id')->all();

        $banner     = new Banner();
        $banner     = $banner->orderByRaw("RAND()")->first();

        view()->share('ambientes', $ambientes);
        view()->share('tipos', $tipos);
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
