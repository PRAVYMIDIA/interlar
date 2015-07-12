<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends Model
{
	use SoftDeletes;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['email'];

	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function setProdutoTipoIdAttribute($value){
            $this->attributes['produto_tipo_id'] = ($value != "" && $value != "0" && !empty($value) ) ? $value  : NULL;
    }
    public function setAmbienteIdAttribute($value){
            $this->attributes['ambiente_id'] = ($value != "" && $value != "0" && !empty($value) ) ? $value  : NULL;
    }
}
