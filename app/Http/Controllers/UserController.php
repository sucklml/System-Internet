<?php

namespace App\Http\Controllers;

use App\Dispositivo;
use App\Proveedor;
use App\Repositories\UsuarioRepository;
use App\Repositories\UserRepository;
use App\Usuario;
use Illuminate\Http\Request;
use Log;
use App\Http\Requests;
use App\Repositories\ProveedorRepository;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $ProveedorRep;
    private $UsuarioRepo;
    private $UserRepo;
    public function __construct(UsuarioRepository $UsuarioRepo,ProveedorRepository $ProveedorRep,UserRepository $UserRepo)
    {
        $this->UsuarioRepo = $UsuarioRepo;
        $this->ProveedorRep = $ProveedorRep;
        $this->UserRepo = $UserRepo;
    }

    public function index(Request $request)
    {
        $Usuario = (string)$request->session()->get('user', 'default');
        $Password =   (string)$request->session()->get('pws', 'default');
        $user = $this->UsuarioRepo->validateUser($Usuario,$Password);
        if(count($user)== 0 ){
            return redirect('/');
        }
        $item = $this->f_castAccesos($user);

        //Yordy del user traes el id XD y listas los proveedores;

        //Funcion para resaltar el acceso
        $item = $this->f_accesoresaltado($item,$request);
        $mobj_data = new \stdClass();
        $mobj_data->Usuario = $this->UserRepo->fls_Proveedores();
        $mobj_data->Dispositivos = json_encode(collect(Dispositivo::where('Estado',1)->get())->toArray());
        return view('modulos.realizarContrato.usuario',['item'=>$item],['data'=>$mobj_data]);
        //return $this->ProveedorRep->fls_Proveedores();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = new Usuario();
        $user->Nombre = $request->input('nombre');
        $user->Apellido = $request->input('apellido');
        $user->Telefono = $request->input('tel');
        $user->Direccion = $request->input('direc');
        $user->Usuario = $request->input('user');
        $user->password = $request->input('pass');
        $user->Correo = $request->input('url');
        $user->Estado = 1;
        $this->UserRepo->Guardar($user);
        return redirect('/pagUsuario');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $mint_idUsuario = (int)$request->idUSUARIO;
        $proveedor = Usuario::find($mint_idUsuario);
        $proveedor->Estado = null;
        $this->UserRepo->Actualizar($proveedor);
        return redirect('/pagUsuario');
    }
}
