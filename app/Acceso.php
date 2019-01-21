<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acceso extends Model
{
    protected $table = 'acceso';
    protected $primaryKey = 'idACCESO';
    protected $fillable = ['COD_Padre','Descripcion','Estado','URL','icono'];
    public $timestamps = false;
    public function subacceso()
    {
        return $this->hasMany('App\Acceso','Cod_Padre');
    }
}
