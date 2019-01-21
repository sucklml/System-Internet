<?php
/**
 * Created by PhpStorm.
 * User: Jose Arias
 * Date: 22/05/2017
 * Time: 14:53
 */

namespace App\Repositories;
use App\Usuario;

class UserRepository
{
    private $UserModel;
    public  function __construct(Usuario $UserModel)
    {
        $this->UserModel = $UserModel;
    }

    public function fls_Proveedores(){
        return Usuario::where("Estado",'=',1)
            ->get();

    }
    public function Actualizar(Usuario $data)
    {
        return  $data->save();
    }
    public function Guardar(Usuario $data)
    {
        $primarykey = $this->UserModel->getKeyName();
        $maxKey = Usuario::all()->max($primarykey);
        $data->$primarykey = $maxKey+1;
        return  $data->save();
    }
}