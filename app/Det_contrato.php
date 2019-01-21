<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Det_contrato extends Model
{
    protected $table = 'det_contrato';
    protected $primaryKey = 'idDET_CONTRATO';
    protected $fillable = ['CD_Req','idCONTRATO','Importe','Oficina','Servicio','Velocidad'];
    public $timestamps = false;
}
