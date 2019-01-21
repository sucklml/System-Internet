<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Dispositivo extends Model
{
    protected $table = 'dispositivo';
    protected $primaryKey = 'idDispositivo';
    protected $fillable = ['Ip','Nombre','Password','Puerto','User','Estado'];
    public $timestamps = false;
}
