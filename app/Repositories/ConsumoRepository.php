<?php
/**
 * Created by PhpStorm.
 * User: Jose Arias
 * Date: 22/05/2017
 * Time: 14:53
 */

namespace App\Repositories;
use App\Consumo;

class ConsumoRepository
{
    private $ConsumoModel;
    public  function __construct(Consumo $ConsumoModel)
    {
        $this->ConsumoModel = $ConsumoModel;
    }

    public function flst_Guardar(Consumo $data)
    {
        $primarykey = $this->ConsumoModel->getKeyName();
        $maxKey = Consumo::all()->max($primarykey);
        $data->$primarykey = $maxKey+1;
        return  $data->save();
    }

    public function flst_Desabiltar($vint_AreaId)
    {

        $mlst_Consumo = Consumo::where('idArea','=',$vint_AreaId)->get();
        foreach($mlst_Consumo as $item)
        {
            $item->Estado = null;
            $item->save();
        }


    }


}