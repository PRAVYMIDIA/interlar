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
            $this->attributes['fornecedor_id'] = $value == ""||$value == "0" ? null : $value;
    }

    public function setValorAttribute($value){
            $this->attributes['valor'] = $value ?  str_replace(',', '.', str_replace('.', '',  $value)) : '';
    }

    public function getValorAttribute($value){
            return number_format( doubleval($value) ,2,',','.');
    }
    /**
    *   Mutator para remover a imagem antiga (caso houver)
    */
    public function setImagemAttribute($value){
        $image_path = public_path() . '/images/produto/'.$this->attributes['id'].'/';
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
        $this->attributes['imagem'] = $value;
    }

    public function thumb(){
        $image_path = public_path() . '/images/produto/'.$this->attributes['id'].'/';
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
