<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Image;
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
                            'valor_promocional',
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
            $this->attributes['fornecedor_id'] = ($value != "" && $value != "0" && !empty($value) ) ? $value  : NULL;
    }

    public function setValorAttribute($value){
            $this->attributes['valor'] = $value ?  str_replace(',', '.', str_replace('.', '',  $value)) : NULL;
    }

    public function getValorAttribute($value){
            return $value ? number_format( doubleval($value) ,2,',','.') : NULL;
    }

    public function setValorPromocionalAttribute($value){
            $this->attributes['valor_promocional'] = $value ?  str_replace(',', '.', str_replace('.', '',  $value)) : NULL;
    }

    public function getValorPromocionalAttribute($value){
            return $value ? number_format( doubleval($value) ,2,',','.') : NULL;
    }
    /**
    *   Mutator para remover a imagem antiga (caso houver)
    */
    public function setImagemAttribute($value){
        if(isset($this->attributes['id'])){
            $image_path = public_path() . '/images/produto/'.$this->attributes['id'].'/';
            if( strlen($this->attributes['imagem']) ){
                if($this->attributes['imagem'] != $value){
                    if(file_exists( $image_path.$this->attributes['imagem'] )){
                        unlink( $image_path.$this->attributes['imagem'] );
                        if(file_exists( $image_path.'thumb_200x200_'.$this->attributes['imagem'] )){
                            unlink( $image_path.'thumb_200x200_'.$this->attributes['imagem'] );
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

    public function thumb($largura=200, $altura=200,$qualidade = 60){
        
        $image_path = public_path() . '/images/produto/'.$this->attributes['id'].'/';

        if(file_exists( $image_path.$this->attributes['imagem'] )){
            # Verifica se existe a miniatura
            if(!file_exists( $image_path.'thumb_'.$largura.'x'.$altura.'_'.$this->attributes['imagem'] )){

                $img_thumb = Image::make($image_path.$this->attributes['imagem'])->fit($largura, $altura, function($constraint){
                    $constraint->upsize();
                });
                $img_thumb->save($image_path.'thumb_'.$largura.'x'.$altura.'_'.$this->attributes['imagem'],$qualidade);
            }
            return 'thumb_'.$largura.'x'.$altura.'_'.$this->attributes['imagem'];
        }
    }

    public function imagemResize($largura=null, $altura=null,$qualidade = 60){
        
        $image_path = public_path() . '/images/produto/'.$this->attributes['id'].'/';

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

    public function ambientes(){
        return $this->belongsToMany('App\Ambiente');
    }

    public function lojasTipos(){
        return $this->belongsToMany('App\LojaTipo','produtos_lojas_tipos');
    }



}
