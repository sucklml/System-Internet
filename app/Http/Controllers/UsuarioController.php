<?php
/**
 * Created by PhpStorm.
 * User: Jose Arias
 * Date: 4/06/2017
 * Time: 18:24
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsuarioController
{
    public function f_castAccesos(Request$request){
        $Usuario = $request->session()->get('user', 'default');
        $Password =   $request->session()->get('pws', 'default');
        $user = $this->UserRepo->validateUser($Usuario,$Password);
        if(count($user)== 0){
            return redirect('/');
        }
        $mlstaccesos = array();
        foreach($user as $item){
            $item->roles;
            foreach($item->roles as $itemRol)
            {
                $itemRol->accesos;

                foreach($itemRol->accesos as $itemAcceso)
                {
                    $listsubacceso = array();
                    $itemAcceso->subacceso;
                    foreach($itemAcceso->subacceso as $itemsubacceso)
                    {
                        $subacceso= $this->f_SubAcceso($itemsubacceso->Descripcion,$itemsubacceso->URL);
                        array_push($listsubacceso,$subacceso);
                    }
                    $acceso= $this->f_Acceso($itemAcceso->idACCESO,$itemAcceso->URL,$itemAcceso->Descripcion,$itemAcceso->icono,$listsubacceso,$itemAcceso->Entidad);
                    array_push($mlstaccesos,$acceso);
                }
            }
            return $mlstaccesos;
        }
        return $mlstaccesos;
    }

}