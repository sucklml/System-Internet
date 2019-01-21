<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area_has_Contrato extends Model
{
    protected $table = 'area_has_contrato';
    protected $primaryKey = 'idAREA_HAS_CONTRATO';
    public $fillable = ['idCONTRATO','idAREA'];
    public $timestamps = false;
}
