<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
            'nome' => 'required|min:3',
            'url' => 'required',
            'dtinicio' => 'required|date_format:d/m/Y',
            'dtfim' => 'required|date_format:d/m/Y|after:dtinicio',
		];
	}

	public function messages(){
		return [
			'dtinicio.required' => 'É necessário uma data inicial de exibição',
			'dtfim.required' => 'É necessário uma data inicial de exibição',
			'dtfim.after' => 'É necessário que a data de fim de exibição seja maior que data inicial de exibição.',
			
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
