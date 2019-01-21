<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario_has_Cliente extends Model
{
    protected $table = 'entidad_has_usuario';
    protected $primaryKey = 'idEntidad_has_Usuario';
    public $timestamps = false;
}
