<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:5',
		];
	}

	public function messages(){
		return [
			'name.required' => 'É necessário um nome',
			'name.min' => 'É necessário um nome com no mínimo 3 caracteres',
			'email.required' => 'O campo de e-mail é necessário.',
			'email.email' => 'O campo de e-mail precisa ser válido!',
			'email.unique' => 'O campo de e-mail precisa ser único no sistema, e este já está sendo utilizado!',
			'password.required' => 'É necessário uma senha.',
			'password.confirmed' => 'A senha e a confirmação precisam ser iguais.',
			'password.min' => 'A senha precisa ter no mínimo 5 caracteres.',
		];
	}

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

}
