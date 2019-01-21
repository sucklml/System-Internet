<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entidad extends Model
{
    protected $table = 'entidad';
    protected $primaryKey = 'idEntidad';
    protected $fillable = ['Nombre','C_RUC','Cod_Servicio','Dir_FACT','Descripcion','Estado'];
    public $timestamps = false;

    public function contrato()
    {
        return $this->hasMany('App\Contrato','idEntidad')
            ->where('Img_url',1);
    }
}
