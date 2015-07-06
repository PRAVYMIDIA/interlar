<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index');
// Route::get('sobre', 'PaginasController@about');
// Route::get('contato', 'PaginasController@contact');
Route::get('loja', 'LojaController@index');

Route::pattern('id', '[0-9]+');
// Route::get('produto/{id}', 'ProdutoController@show');


Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'namespace' => 'Admin'], function() {
    Route::pattern('id', '[0-9]+');
    Route::pattern('id2', '[0-9]+');

    # Rota default para /admin
    Route::get('/', 'DashboardController@index');

    # Admin Dashboard
    Route::get('dashboard', 'DashboardController@index');

    # Ambientes
    Route::get('ambiente', 'AmbienteController@index');
    Route::get('ambiente/create', 'AmbienteController@getCreate');
    Route::post('ambiente/create', 'AmbienteController@postCreate');
    Route::get('ambiente/{id}/edit', 'AmbienteController@getEdit');
    Route::post('ambiente/{id}/edit', 'AmbienteController@postEdit');
    Route::get('ambiente/{id}/delete', 'AmbienteController@getDelete');
    Route::post('ambiente/{id}/delete', 'AmbienteController@postDelete');
    Route::get('ambiente/data', 'AmbienteController@data');
    Route::get('ambiente/reorder', 'AmbienteController@getReorder');

    # ProdutoTipos
    Route::get('produtotipo', 'ProdutoTipoController@index');
    Route::get('produtotipo/create', 'ProdutoTipoController@getCreate');
    Route::post('produtotipo/create', 'ProdutoTipoController@postCreate');
    Route::get('produtotipo/{id}/edit', 'ProdutoTipoController@getEdit');
    Route::post('produtotipo/{id}/edit', 'ProdutoTipoController@postEdit');
    Route::get('produtotipo/{id}/delete', 'ProdutoTipoController@getDelete');
    Route::post('produtotipo/{id}/delete', 'ProdutoTipoController@postDelete');
    Route::get('produtotipo/data', 'ProdutoTipoController@data');
    Route::get('produtotipo/reorder', 'ProdutoTipoController@getReorder');

    # Fornecedores
    Route::get('fornecedor', 'FornecedorController@index');
    Route::get('fornecedor/create', 'FornecedorController@getCreate');
    Route::post('fornecedor/create', 'FornecedorController@postCreate');
    Route::get('fornecedor/{id}/edit', 'FornecedorController@getEdit');
    Route::post('fornecedor/{id}/edit', 'FornecedorController@postEdit');
    Route::get('fornecedor/{id}/delete', 'FornecedorController@getDelete');
    Route::post('fornecedor/{id}/delete', 'FornecedorController@postDelete');
    Route::get('fornecedor/data', 'FornecedorController@data');
    Route::get('fornecedor/reorder', 'FornecedorController@getReorder');

    # Produtos
    Route::get('produto', 'ProdutoController@index');
    Route::get('produto/create', 'ProdutoController@getCreate');
    Route::post('produto/create', 'ProdutoController@postCreate');
    Route::get('produto/{id}/edit', 'ProdutoController@getEdit');
    Route::post('produto/{id}/edit', 'ProdutoController@postEdit');
    Route::get('produto/{id}/delete', 'ProdutoController@getDelete');
    Route::post('produto/{id}/delete', 'ProdutoController@postDelete');
    Route::get('produto/removerimagem/{id}', 'ProdutoController@getRemoverImagem');
    Route::get('produto/data', 'ProdutoController@data');
    Route::get('produto/reorder', 'ProdutoController@getReorder');

    # Lojas
    Route::get('loja', 'LojaController@index');
    Route::get('loja/create', 'LojaController@getCreate');
    Route::post('loja/create', 'LojaController@postCreate');
    Route::get('loja/{id}/edit', 'LojaController@getEdit');
    Route::post('loja/{id}/edit', 'LojaController@postEdit');
    Route::get('loja/{id}/delete', 'LojaController@getDelete');
    Route::post('loja/{id}/delete', 'LojaController@postDelete');
    Route::get('loja/data', 'LojaController@data');
    Route::get('loja/reorder', 'LojaController@getReorder');    

    # Ambientes
    Route::get('banner', 'BannerController@index');
    Route::get('banner/create', 'BannerController@getCreate');
    Route::post('banner/create', 'BannerController@postCreate');
    Route::get('banner/{id}/edit', 'BannerController@getEdit');
    Route::post('banner/{id}/edit', 'BannerController@postEdit');
    Route::get('banner/{id}/delete', 'BannerController@getDelete');
    Route::post('banner/{id}/delete', 'BannerController@postDelete');
    Route::get('banner/data', 'BannerController@data');
    Route::get('banner/reorder', 'BannerController@getReorder');

    # Users
    Route::get('users/', 'UserController@index');
    Route::get('users/create', 'UserController@getCreate');
    Route::post('users/create', 'UserController@postCreate');
    Route::get('users/{id}/edit', 'UserController@getEdit');
    Route::post('users/{id}/edit', 'UserController@postEdit');
    Route::get('users/{id}/delete', 'UserController@getDelete');
    Route::post('users/{id}/delete', 'UserController@postDelete');
    Route::get('users/data', 'UserController@data');

});
