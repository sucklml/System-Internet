<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'area';
    protected $primaryKey = 'idAREA';
    protected $fillable = ['Cod_Padre','CTAS_CTR',"IdEntidad","CTAS_CTR","Dependencia","Obs","CTW","Interface","Nivel","Nom_Area","idDispositivo"];
    public $timestamps = false;
    // Relación

    public function area()
    {
        return $this->hasMany('App\Area','Cod_Padre')->where('Estado','=',1);
    }

    public function consumo()
    {
        return $this->hasOne('App\Consumo','idArea')->where('Estado','!=',0);
    }

    public function microtik()
    {
        return $this->hasMany('App\Microtik','AREA_idSECTOR');
    }
}
