<?php
/**
 * Created by PhpStorm.
 * User: Jose Arias
 * Date: 22/05/2017
 * Time: 14:53
 */

namespace App\Repositories;
use App\Proveedor;

class ProveedorRepository
{
    private $ProveedorModel;
    public  function __construct(Proveedor $ProveedorModel)
    {
        $this->ProveedorModel = $ProveedorModel;
    }

    public function fls_Proveedores(){
        return Proveedor::where("Estado",'=',1)
                ->get();

    }
    public function Actualizar(Proveedor $data)
    {
        return  $data->save();
    }
    public function Guardar(Proveedor $data)
    {
        $primarykey = $this->ProveedorModel->getKeyName();
        $maxKey = Proveedor::all()->max($primarykey);
        $data->$primarykey = $maxKey+1;
        return  $data->save();
    }
}