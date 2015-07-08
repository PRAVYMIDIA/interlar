<?php namespace App\Http\Controllers;

use App\Email;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent;
use Illuminate\Support\Facades\DB;

class EmailsController extends Controller {
	/**
	 * Salvar o email do visitante
	 *
	 * @return Response json
	 */
	public function salvar(Request $request)
	{
		$email      	= new Email();
		$email->email 	= $request->input('email');
		if(!$email->save()){
			return response()->json(['erro' => 'Erro ao salvar']);
		}else{
			return response()->json(['erro' => null]);
		}
	}

}