<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedor';
    protected $primaryKey = 'idProveedor';
    protected $fillable = ['Direccion','Nom_Empresa','RUC','Telefono','Url','idUSUARIO'];
    public $timestamps = false;
}
