<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contato extends Model
{
    protected $table = "contato_respostas";
	use SoftDeletes;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
                            'user_id_created',
                            'tipo',
                            'enviada',
                            'mensagem',
                            'contato_id'
                        ];


	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];


    public function contato()
    {
        return $this->belongsTo('App\Contato');
    }

    public function usuario()
    {
        return $this->belongsTo('App\User','user_id_created');
    }
}
