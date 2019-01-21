<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    protected $table = 'usuario';
    protected $primaryKey = 'idUSUARIO';
    protected $fillable = [
        'Nombre','Apellido','Telefono','Direccion','Usuario','password','Correo','Estado'
    ];
    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function roles()
    {
        return $this->belongsToMany('App\Rol','usuario_has_rol','idROL','idUSUARIO');
    }
    public function entidades()
    {
        return $this->belongsToMany('App\Entidad','entidad_has_usuario','idUSUARIO','idEntidad')
            ->where('entidad.Estado',1);
    }

}
