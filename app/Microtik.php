<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Microtik extends Model
{
    protected $table = 'microtik';
    protected $primaryKey = 'idMicrotik';
    protected $fillable = ['AREA_idSECTOR','Baja','Fecha','Subida'];
    public $timestamps = false;
}
