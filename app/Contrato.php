<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    protected $table = 'contrato';
    protected $primaryKey = 'idCONTRATO';
    protected $fillable = ['Cod_Contrato','Descripcion','Estado','Fech_Emision','Fech_Vencimiento','idEntidad','idProveedor','Img_url','Importe','Num_Recibo','Velocidad_Mb'];
    public $timestamps = false;
    public function areas()
    {
        return $this->belongsToMany('App\Area','area_has_contrato','idCONTRATO','idAREA');
    }
   /* public function proveedor() {
        return $this->hasOne('App\Proveedor', 'idProveedor');
    }*/
    public function detalle() {
        return $this->hasMany('App\Det_contrato', 'idCONTRATO');
    }
    public function documento() {
        return $this->hasMany('App\Documento', 'idCONTRATO');
    }

}
