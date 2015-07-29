<?php namespace App\Http\Controllers;

use App\Contato;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent;
use Illuminate\Support\Facades\DB;

class ContatosController extends Controller {
	/**
	 * Salvar o email enviado pelo visitante à respeito de algum produto
	 *
	 * @return Response json
	 */
	public function vendedor(Request $request)
	{
		$contato      		= new Contato();
		$contato->nome	 	= $request->input('nome');
		$contato->celular	= $request->input('celular');
		$contato->email	 	= $request->input('email');
		$contato->mensagem	= $request->input('mensagem');
		$contato->produto_id= $request->input('produto_id');
		$contato->loja_id	= $request->input('loja_id');
		$contato->aceita_receber_mensagens	= $request->input('aceita_receber_mensagens');


		if(!$contato->save()){
			return response()->json(['erro' => 'Erro ao salvar']);
		}else{
			$contato_array = array(
				'nome'		=> $contato->nome,
				'celular'	=> $contato->celular,
				'email'		=> $contato->email,
				'mensagem'	=> $contato->mensagem,
				'produto'	=> $contato->produto->nome
			);
			if($contato->loja_id){
				$contato_array['loja'] = $contato->loja->nome;
			}
			Mail::send('emails.contato_vendedor', $contato_array, function($m){
				$m->to(env('MAIL_TO_VENDEDOR'),'INTERLAR')->subject('Visitante interessado em produto');
			});
			return response()->json(['erro' => null]);
		}
	}

	/**
	 * Salvar o email enviado pelo visitante
	 *
	 * @return Response json
	 */
	public function contato(Request $request)
	{
		$contato      		= new Contato();
		$contato->nome	 	= $request->input('nome');
		$contato->celular	= $request->input('celular');
		$contato->email	 	= $request->input('email');
		$contato->mensagem	= $request->input('mensagem');
		$contato->aceita_receber_mensagens	= $request->input('aceita_receber_mensagens');


		if(!$contato->save()){
			return response()->json(['erro' => 'Erro ao salvar']);
		}else{
			$contato_array = array(
				'nome'		=> $contato->nome,
				'celular'	=> $contato->celular,
				'email'		=> $contato->email,
				'mensagem'	=> $contato->mensagem
			);
			Mail::send('emails.contato', $contato_array, function($m){
				$m->to(env('MAIL_TO_CONTATO'),'INTERLAR')->subject('Visitante enviou um contato');
			});
			return response()->json(['erro' => null]);
		}
	}

}