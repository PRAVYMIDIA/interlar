<?php namespace App\Http\Controllers;

use App\Ambiente;

class AmbientesController extends Controller {

    public function __construct()
    {
        $this->middleware('auth', [ 'except' => [ 'index', 'show' ] ]);
    }

    public function show($id)
    {
        // Get all the blog posts
        $ambiente = Ambiente::find($id);

        dd($ambiente);
        // return view('ambiente.view_ambiente', compact('ambiente'));
    }

}