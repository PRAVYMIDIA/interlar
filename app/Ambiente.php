<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Image;

class Ambiente extends Model
{
	use SoftDeletes;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['descricao','imagem','user_id_created'];


	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function produtos(){
        return $this->belongsToMany('App\Produto');
    }

    /**
    *   Mutator para remover a imagem antiga (caso houver)
    */
    public function setImagemAttribute($value){
        if(isset($this->attributes['id'])){
            $image_path = public_path() . '/images/ambiente/'.$this->attributes['id'].'/';
            if( strlen($this->attributes['imagem']) ){
                if($this->attributes['imagem'] != $value){
                    if(file_exists( $image_path.$this->attributes['imagem'] )){
                        unlink( $image_path.$this->attributes['imagem'] );
                        if(file_exists( $image_path.'thumb_'.$this->attributes['imagem'] )){
                            unlink( $image_path.'thumb_'.$this->attributes['imagem'] );
                        }
                    }
                }            
            }
        }
        $this->attributes['imagem'] = $value;
        if(isset($this->attributes['id'])){
            $this->thumb();
        }
    }

    public function thumb(){
        $image_path = public_path() . '/images/ambiente/'.$this->attributes['id'].'/';
        # Verifica se existe a miniatura
        if(!file_exists( $image_path.'thumb_'.$this->attributes['imagem'] )){

            $img_thumb = Image::make($image_path.$this->attributes['imagem'])->resize(200, 200, function($constraint){
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $img_thumb->save($image_path.'thumb_'.$this->attributes['imagem'],60);
        }
        return 'thumb_'.$this->attributes['imagem'];
    }

}
