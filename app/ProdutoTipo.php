<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProdutoTipo extends Model
{
    protected $table = "produtos_tipos";
	use SoftDeletes;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['descricao','nome','user_id_created'];

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

    public function produtos()
    {
        return $this->hasMany('App\Produto');
    }

}
