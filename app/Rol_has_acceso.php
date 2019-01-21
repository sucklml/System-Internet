<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol_has_acceso extends Model
{
    protected $table = 'rol_has_acceso';
    protected $fillable = ['idACCESO','idROL'];
    public $timestamps = false;

}
