<?php namespace App\Http\Controllers;

use App\Contato;
use App\Produto;
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
		$produto = Produto::find($request->input('produto_id'));
		if(!$produto){
			return response()->json(['erro' => 'Produto inexistente']);
		}
		$contato      		= new Contato();
		$contato->nome	 	= $request->input('nome');
		$contato->celular	= $request->input('celular');
		$contato->email	 	= $request->input('email');
		$contato->mensagem	= $request->input('mensagem');
		$contato->produto_id= $request->input('produto_id');
		$contato->loja_id	= $produto->loja_id;
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

			$celular =  null;
			## SMS
			if($contato->loja_id){
				$celular = $contato->loja->celular;
			}
			if($celular){

	            $celular = preg_replace("/[^0-9]+/", "", $celular);
	            $celular_cliente = preg_replace("/[^0-9]+/", "", $contato->celular);

	            $mensagem_sms = "Site Interlar - Prod:".$contato->produto->nome." - ".$contato->mensagem." - de:".$contato->nome;
	            if(strlen($mensagem_sms)>147){
	            	$mensagem_sms = "Site Interlar - Prod:".str_limit($contato->produto->nome,15)." - ".$contato->mensagem." - de:".$contato->nome;
	            	if(strlen($mensagem_sms)>147){
	            		$mensagem_sms = "Site Interlar - Prod:".str_limit($contato->produto->nome,15)." - ".$contato->mensagem." - de:".substr($contato->nome, 0, strpos($contato->nome, ' ') );

	            		if(strlen($mensagem_sms)>147){
		            		$mensagem_sms = "Interlar|Prd:".str_limit($contato->produto->nome,15)." - ".$contato->mensagem." - de:".str_limit($contato->nome,15) ;
							if(strlen($mensagem_sms)>147){
								$mensagem_sms = substr($mensagem_sms, 0, 147);
							}
		            	}
	            	}
	            	
	            }

	            // Integração Zenvia
	            $ch = curl_init();

	            curl_setopt($ch, CURLOPT_URL, "https://api-rest.zenvia360.com.br/services/send-sms");
	            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	            curl_setopt($ch, CURLOPT_HEADER, FALSE);

	            curl_setopt($ch, CURLOPT_POST, TRUE);

	            curl_setopt($ch, CURLOPT_POSTFIELDS, "{
	              \"sendSmsRequest\": {
	                \"from\": \"".$celular_cliente."\",
	                \"to\": \"55".$celular."\",
	                \"msg\": \"".$mensagem_sms."\",
	                \"callbackOption\": \"ALL\",
	                \"id\": \"".$contato->id."\"
	              }
	            }");

	            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	              "Content-Type: application/json",
	              "Authorization: Basic ". base64_encode('raemp.corp:IqEPsgtp6G'),
	              "Accept: application/json"
	            ));

	            $response = curl_exec($ch);
	            curl_close($ch);
	            /*$response = '{
	              "sendSmsResponse" : {
	                "statusCode" : "00",
	                "statusDescription" : "Ok",
	                "detailCode" : "000",
	                "detailDescription" : "Message Sent"
	              }
	            }';*/
	            $response = json_decode($response);
	            
	            if($response->sendSmsResponse){
	                if($response->sendSmsResponse->statusCode == '00'){
	                    $envio = 1;
	                }else{
	                    $envio = 0;
	                }
	            }else{
	                $envio = 0;
	            }
			}

			if($envio==0){
				return response()->json(['erro' => 'Não foi possível enviar o SMS. Erro: '.$response->sendSmsResponse->detailDescription]);
			}

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