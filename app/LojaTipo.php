<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LojaTipo extends Model
{
	protected $table = 'lojas_tipos';
	use SoftDeletes;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['nome','descricao','ativo','user_id_created'];


    public function visitas()
    {
        return $this->morphMany('App\Visita', 'recurso');
    }
    
	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function lojas(){
        return $this->hasMany('App\Loja','loja_tipo_id');
    }

    public function produtos(){
        return $this->belongsToMany('App\Produto','produtos_lojas_tipos');
    }

}
