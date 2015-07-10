<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contato extends Model
{
    protected $table = "contatos";
	use SoftDeletes;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
                            'nome',
                            'email',
                            'celular',
                            'mensagem',
                            'loja_id',
                            'produto_id'
                        ];


	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];


    public function setProdutoIdAttribute($value){
            $this->attributes['produto_id'] = ($value != "" && $value != "0" && !empty($value) ) ? $value  : NULL;
    }


    public function setLojaIdAttribute($value){
            $this->attributes['loja_id'] = ($value != "" && $value != "0" && !empty($value) ) ? $value  : NULL;
    }

    public function produto()
    {
        return $this->belongsTo('App\Produto');
    }

    public function loja()
    {
        return $this->belongsTo('App\Loja');
    }

    public function respostas()
    {
        return $this->hasMany('App\ContatoResposta');
    }
}
