<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    protected $table = "visitas";

    public function recurso()
    {
        return $this->morphTo();
    }

}
