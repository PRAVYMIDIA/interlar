<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Image;

class ProdutoImagem extends Model
{
    protected $table = "produto_imagens";
	use SoftDeletes;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
                            'user_id_created',
                            'produto_id',
                            'imagem'
                        ];


	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function produto()
    {
        return $this->belongsTo('App\Produto');
    }

    public function thumb(){
        $image_path = public_path() . '/images/produto/'.$this->attributes['produto_id'].'/';
        if(file_exists( $image_path.$this->attributes['imagem'] )){
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

    public function imagemResize($largura=null, $altura=null,$qualidade = 60){
        
        $image_path = public_path() . '/images/produto/'.$this->attributes['produto_id'].'/';

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
