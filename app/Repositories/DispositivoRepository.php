<?php
/**
 * Created by PhpStorm.
 * User: Jose Arias
 * Date: 12/05/2017
 * Time: 12:31
 */

namespace App\Repositories;
use App\Dispositivo;

class DispositivoRepository
{
    private $DispositivoModel;
    public  function __construct(Dispositivo $DispositivoModel)
    {
        $this->DispositivoModel = $DispositivoModel;
    }

    public function flst_Listar()
    {
        return Dispositivo::all();
    }

    public function fobj_Obtner($vint_idDispositivo)
    {
        //$data->name = $req->name;
        //$data->save ();
        return Dispositivo::find($vint_idDispositivo);
       // return Dispositivo::where($vint_idDispositivo)->get();
        //$branch = Branch::where(['columnName' => value]);
    }

    public function flst_Guardar(Dispositivo $data)
    {
        $primarykey = $this->DispositivoModel->getKeyName();
        $maxKey = Dispositivo::all()->max($primarykey);
        $data->$primarykey = $maxKey+1;
        return  $data->save();
    }
    public function flst_ListarDispositivos(){
        return Dispositivo::where("Estado",'=',1)
            ->get();
    }
    public function Actualizar(Dispositivo $data)
    {
        return  $data->save();
    }

}