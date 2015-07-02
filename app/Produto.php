<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
	use SoftDeletes;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
                            'descricao',
                            'nome',
                            'user_id_created',
                            'fornecedor_id',
                            'produto_tipo_id',
                            'valor',
                            'parcelas',
                            'imagem'
                        ];


	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function tipo()
    {
        return $this->belongsTo('App\ProdutoTipo');
    }

    public function fornecedor()
    {
        return $this->belongsTo('App\Fornecedor');
    }

    public function imagens()
    {
        return $this->hasMany('App\ProdutoImagem');
    }

    public function setFornecedorIdAttribute($value){
            $this->attributes['fornecedor_id'] = $value == ""||$value == "0" ? null : $value;
    }

    public function setValorAttribute($value){
            $this->attributes['valor'] = $value ?  str_replace(',', '.', str_replace('.', '',  $value)) : '';
    }

    public function getValorAttribute($value){
            return number_format( doubleval($value) ,2,',','.');
    }



}
