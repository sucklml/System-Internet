<?php

namespace App\Http\Controllers;

use App\Dispositivo;
use App\Proveedor;
use App\Repositories\UsuarioRepository;
use Illuminate\Http\Request;
use Log;
use App\Http\Requests;
use App\Repositories\ProveedorRepository;
class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $ProveedorRep;
    private $UsuarioRepo;
    public function __construct(UsuarioRepository $UsuarioRepo,ProveedorRepository $ProveedorRep)
    {
        $this->UsuarioRepo = $UsuarioRepo;
        $this->ProveedorRep = $ProveedorRep;
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
        $mobj_data->Proveedor = $this->ProveedorRep->fls_Proveedores();
        $mobj_data->Dispositivos = json_encode(collect(Dispositivo::where('Estado',1)->get())->toArray());
        return view('modulos.realizarContrato.proveedor',['item'=>$item],['data'=>$mobj_data]);
        //return $this->ProveedorRep->fls_Proveedores();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $proveedor = new Proveedor();
        $proveedor->Nom_Empresa = $request->input('nombre');
        $proveedor->RUC = $request->input('ruc');
        $proveedor->Direccion = $request->input('direccion');
        $proveedor->Telefono = $request->input('telef');
        $proveedor->Url = $request->input('url');
        $proveedor->Estado = 1;
        Log::info('jaaaaa'+$proveedor+'proveedor');
        $this->ProveedorRep->Guardar($proveedor);
        return redirect('/pagProveedor');
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
        $mint_idProveedor = (int)$request->idProveedor;
        $proveedor = Proveedor::find($mint_idProveedor);
        $proveedor->Estado = null;
        $this->ProveedorRep->Actualizar($proveedor);
        return redirect('/pagProveedor');
    }
}
