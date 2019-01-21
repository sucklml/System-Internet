<?php
/**
 * Created by PhpStorm.
 * User: nik_1
 * Date: 04/06/2017
 * Time: 12:44 PM
 */

namespace App\Repositories;


use App\Usuario;

class UsuarioRepository extends BaseRepository
{
    protected $model;
    public function __construct(Usuario $user)
    {
        $this->model = $user;
    }
    public function validateUser($user,$pass){
       $query= $this->model->where('Usuario','=',$user)->where('password','=',$pass)->get();
        return $query;
    }


}