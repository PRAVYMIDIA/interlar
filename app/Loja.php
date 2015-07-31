<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Image;
class Loja extends Model
{
	use SoftDeletes;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['nome','descricao','imagem','localizacao','telefone','celular','ativo','user_id_created'];


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

    public function tipo()
    {
        return $this->belongsTo('App\LojaTipo','loja_tipo_id');
    }

    public function produtos(){
        return $this->hasMany('App\Produto','loja_id');
    }

    public function imagemResize($largura=null, $altura=null,$qualidade = 60){
        
        $image_path = public_path() . '/images/loja/'.$this->attributes['id'].'/';

        if(file_exists( $image_path.$this->attributes['imagem'] )){
            # Verifica se existe a miniatura
            if(!file_exists( $image_path.'thumb_'.$largura.'x'.$altura.'_'.$this->attributes['imagem'] )){

                $img_thumb = Image::make($image_path.$this->attributes['imagem'])->resize($largura, $altura, function($constraint){
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $img_thumb->save($image_path.'thumb_'.$largura.'x'.$altura.'_'.$this->attributes['imagem'],$qualidade);
            }
            return 'thumb_'.$largura.'x'.$altura.'_'.$this->attributes['imagem'];
        }
    }

}
