<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntidadUsuario extends Model
{
    protected $table = 'entidad_has_usuario';
    protected $primaryKey = 'idEntidad_has_Usuario';
    public $timestamps = false;
    public function usuario()
    {
        return $this->hasMany('App\Usuario','idUSUARIO');
    }
    public function entidad()
    {
        return $this->hasMany('App\Entidad','idEntidad');
    }

}
