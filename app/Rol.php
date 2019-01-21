<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'rol';
    protected $primaryKey = 'idROL';
    protected $fillable = ['Estado','Rol'];
    public $timestamps = false;
    public function accesos()
    {
        return $this->belongsToMany('App\Acceso','rol_has_acceso','idROL','idACCESO');
    }
}
