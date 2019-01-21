<?php
/**
 * Created by PhpStorm.
 * User: Jose Arias
 * Date: 12/05/2017
 * Time: 12:31
 */

namespace App\Repositories;
use App\Det_contrato;

class Det_contratoRepository
{
    private $Det_contratoModel;
    public  function __construct(Det_contrato $Det_contratoModel)
    {
        $this->Det_contratoModel = $Det_contratoModel;
    }
    public function fbol_Guardar(Det_contrato $data)
    {
        $primarykey = $this->Det_contratoModel->getKeyName();
        $maxKey = Det_contrato::all()->max($primarykey);
        $data->$primarykey = $maxKey+1;
        return  $data->save();
    }


}