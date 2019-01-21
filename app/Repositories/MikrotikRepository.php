<?php namespace App\Repositories;

use App\Microtik;
use App\Dispositivo;

class MikrotikRepository extends BaseRepository
{
    public function __construct(Microtik $model)
    {
        $this->model = $model;
    }

    public function getUltimateDataHora(){
        return $this->model->all()->last();
    }
    public function getDataForHora(){
       $data = $this->model->all();
        foreach ($data as $d){
            $d->area_interface;
        }
        return $data;
    }
    public function getDataforDay(){
        $datetime = array();
        $date0="";$TX_lec=array();
        $data = $this->model->all();
        foreach ($data as $d){
            $fecha = explode(" ",$d->Fecha);$date = explode("-",$fecha[0]);
            // $fecha[1] -> hora // $date[0] -> año // $date[1] -> Mes // $date[2] -> Dia
            if ($date0 == ""){$date0 = $date[2];}
            if($date0 == $date[2]){//comparando el registro anterior // DIA
                $TX_lec[]=$d->Bajada;
            }else{
                $date0 = $date[2];
                $datetime[] = ["dia"=>$date[2],"Bajada"=>array_sum($TX_lec)/count($TX_lec)];
                unset($TX_lec);

            }

        }
        return $datetime;
    }
    public function fls_Mikrotik(){
        return Dispositivo::where("Estado",'=',1)
            ->get();
    }


}