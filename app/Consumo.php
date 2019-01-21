<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consumo extends Model
{
    protected $table = 'consumo';
    protected $primaryKey = 'idConsumo';
    protected $fillable = ['num_comp','Mbts_Asignado','Porc_Mbts','Costo_Mbps','Fecha','Porc_Acum','SubTotal','Fecha','Estado','idArea'];
    public $timestamps = false;
    public function area()
    {
        return $this->hasOne('App\Area','idAREA');
    }
}
