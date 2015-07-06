<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Image;

class Banner extends Model
{
	use SoftDeletes;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['url',
                            'dtinicio',
                            'dtfim',
                            'html',
                            'imagem',
                            'user_id_created'
                            ];


	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at','dtinicio','dtfim'];

    public function getDtinicioAttribute(){
        $dt_array = explode('-', $this->attributes['dtinicio']);
        return $dt_array[2].'/'.$dt_array[1].'/'.$dt_array[0];
    }

    public function getDtfimAttribute(){
        $dt_array = explode('-', $this->attributes['dtfim']);
        return $dt_array[2].'/'.$dt_array[1].'/'.$dt_array[0];
    }

    /**
    *   Mutator para remover a imagem antiga (caso houver)
    */
    public function setImagemAttribute($value){
        if(isset($this->attributes['id'])){
            $image_path = public_path() . '/images/banner/'.$this->attributes['id'].'/';
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
            if($value!=''){
                $this->thumb();
            }
        }
    }

    public function thumb(){
        $image_path = public_path() . '/images/banner/'.$this->attributes['id'].'/';
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
