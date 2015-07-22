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
		if(!Email::where('email','like',$request->input('email'))->first()){

			$email->email 	= $request->input('email');
			$email->pagina	= $request->input('pagina');
			$email->ambiente_id	= $request->input('ambiente');
			$email->produto_tipo_id	= $request->input('tipo');
			if(!$email->save()){
				Log::error('Erro ao salvar E-Mail',$email);
				return response()->json(['erro' => 'Erro ao salvar']);
			}else{
				return response()->json(['erro' => null]);
			}
		}else{
			return response()->json(['erro' => 'E-Mail já cadastrado']);
		}
	}

}