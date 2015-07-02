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
Route::get('about', 'PagesController@about');
Route::get('contact', 'PagesController@contact');

Route::pattern('id', '[0-9]+');
Route::get('news/{id}', 'ArticlesController@show');
Route::get('video/{id}', 'VideoController@show');
Route::get('photo/{id}', 'PhotoController@show');

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


    # Language
    Route::get('language', 'LanguageController@index');
    Route::get('language/create', 'LanguageController@getCreate');
    Route::post('language/create', 'LanguageController@postCreate');
    Route::get('language/{id}/edit', 'LanguageController@getEdit');
    Route::post('language/{id}/edit', 'LanguageController@postEdit');
    Route::get('language/{id}/delete', 'LanguageController@getDelete');
    Route::post('language/{id}/delete', 'LanguageController@postDelete');
    Route::get('language/data', 'LanguageController@data');
    Route::get('language/reorder', 'LanguageController@getReorder');

    # News category
    Route::get('newscategory', 'ArticleCategoriesController@index');
    Route::get('newscategory/create', 'ArticleCategoriesController@getCreate');
    Route::post('newscategory/create', 'ArticleCategoriesController@postCreate');
    Route::get('newscategory/{id}/edit', 'ArticleCategoriesController@getEdit');
    Route::post('newscategory/{id}/edit', 'ArticleCategoriesController@postEdit');
    Route::get('newscategory/{id}/delete', 'ArticleCategoriesController@getDelete');
    Route::post('newscategory/{id}/delete', 'ArticleCategoriesController@postDelete');
    Route::get('newscategory/data', 'ArticleCategoriesController@data');
    Route::get('newscategory/reorder', 'ArticleCategoriesController@getReorder');

    # News
    Route::get('news', 'ArticlesController@index');
    Route::get('news/create', 'ArticlesController@getCreate');
    Route::post('news/create', 'ArticlesController@postCreate');
    Route::get('news/{id}/edit', 'ArticlesController@getEdit');
    Route::post('news/{id}/edit', 'ArticlesController@postEdit');
    Route::get('news/{id}/delete', 'ArticlesController@getDelete');
    Route::post('news/{id}/delete', 'ArticlesController@postDelete');
    Route::get('news/data', 'ArticlesController@data');
    Route::get('news/reorder', 'ArticlesController@getReorder');

    # Photo Album
    Route::get('photoalbum', 'PhotoAlbumController@index');
    Route::get('photoalbum/create', 'PhotoAlbumController@getCreate');
    Route::post('photoalbum/create', 'PhotoAlbumController@postCreate');
    Route::get('photoalbum/{id}/edit', 'PhotoAlbumController@getEdit');
    Route::post('photoalbum/{id}/edit', 'PhotoAlbumController@postEdit');
    Route::get('photoalbum/{id}/delete', 'PhotoAlbumController@getDelete');
    Route::post('photoalbum/{id}/delete', 'PhotoAlbumController@postDelete');
    Route::get('photoalbum/data', 'PhotoAlbumController@data');
    Route::get('photoalbum/reorder', 'PhotoAlbumController@getReorder');

    # Photo
    Route::get('photo', 'PhotoController@index');
    Route::get('photo/create', 'PhotoController@getCreate');
    Route::post('photo/create', 'PhotoController@postCreate');
    Route::get('photo/{id}/edit', 'PhotoController@getEdit');
    Route::post('photo/{id}/edit', 'PhotoController@postEdit');
    Route::get('photo/{id}/delete', 'PhotoController@getDelete');
    Route::post('photo/{id}/delete', 'PhotoController@postDelete');
    Route::get('photo/{id}/itemsforalbum', 'PhotoController@itemsForAlbum');
    Route::get('photo/{id}/{id2}/slider', 'PhotoController@getSlider');
    Route::get('photo/{id}/{id2}/albumcover', 'PhotoController@getAlbumCover');
    Route::get('photo/data/{id}', 'PhotoController@data');
    Route::get('photo/reorder', 'PhotoController@getReorder');

    # Video
    Route::get('videoalbum', 'VideoAlbumController@index');
    Route::get('videoalbum/create', 'VideoAlbumController@getCreate');
    Route::post('videoalbum/create', 'VideoAlbumController@postCreate');
    Route::get('videoalbum/{id}/edit', 'VideoAlbumController@getEdit');
    Route::post('videoalbum/{id}/edit', 'VideoAlbumController@postEdit');
    Route::get('videoalbum/{id}/delete', 'VideoAlbumController@getDelete');
    Route::post('videoalbum/{id}/delete', 'VideoAlbumController@postDelete');
    Route::get('videoalbum/data', 'VideoAlbumController@data');
    Route::get('video/reorder', 'VideoAlbumController@getReorder');

    # Video
    Route::get('video', 'VideoController@index');
    Route::get('video/create', 'VideoController@getCreate');
    Route::post('video/create', 'VideoController@postCreate');
    Route::get('video/{id}/edit', 'VideoController@getEdit');
    Route::post('video/{id}/edit', 'VideoController@postEdit');
    Route::get('video/{id}/delete', 'VideoController@getDelete');
    Route::post('video/{id}/delete', 'VideoController@postDelete');
    Route::get('video/{id}/itemsforalbum', 'VideoController@itemsForAlbum');
    Route::get('video/{id}/{id2}/albumcover', 'VideoController@getAlbumCover');
    Route::get('video/data/{id}', 'VideoController@data');
    Route::get('video/reorder', 'VideoController@getReorder');

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
