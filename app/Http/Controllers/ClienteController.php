<?php

namespace App\Http\Controllers;
use App\Dispositivo;
use App\Entidad;
use App\Repositories\EntidadRepository;
use App\Repositories\UsuarioRepository;
use App\Repositories\DispositivoRepository;
use App\Usuario;
use App\Usuario_has_Cliente;
use Illuminate\Http\Request;
use App\Http\Requests;
class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $UsuarioRepo;
    private $EntidadRepo;
    private $DispositivoRepo;
    public  function __construct(UsuarioRepository $UsuarioRepo,EntidadRepository $EntidadRepo,DispositivoRepository $DispositivoRepo)
    {
        $this->UsuarioRepo = $UsuarioRepo;
        $this->EntidadRepo = $EntidadRepo;
        $this->DispositivoRepo = $DispositivoRepo;
    }

    public function index(Request $request)
    {
        $Usuario = (string)$request->session()->get('user', 'default');
        $Password =   (string)$request->session()->get('pws', 'default');
        $user = $this->UsuarioRepo->validateUser($Usuario,$Password);
        if(count($user)== 0){
            return redirect('/');
        }
        $request->session()->put('usid',$user[0]->idUSUARIO);
        $item = $this->f_castAccesos($user);
        //Funcion para resaltar el acceso
        $item = $this->f_accesoresaltado($item,$request);

        $mobj_data = new \stdClass();
        $mobj_data->Usuario = $user[0];
        $mobj_data->CO = $user[0]->CO;
        $mobj_data->CT = $user[0]->CT;
        $mobj_data->PA = $user[0]->PA;

        $mobj_data->rolId = $user[0]->roles[0]->idROL;
        $mobj_data->Dispositivos = json_encode(collect(Dispositivo::where('Estado',1)->get())->toArray());
        return view('modulos.realizarContrato.cliente',['item'=>$item],['data'=> $mobj_data]);
    }

    public function f_guardar(Request $request){

        $usuarioid = $request->session()->get('usid', 'default');
        $entidad = new Entidad();
        $entidad->Nombre=$request->input('nombre');
        $entidad->C_RUC = $request->input('ruc');
        $entidad->Cod_Servicio = $request->input('codservicio');
        $entidad->Dir_FACT = $request->input('factura');
        $entidad->Descripcion = $request->input('descripcion');
        $entidad->Estado = 1;
        $this->EntidadRepo->Guardar($entidad, $usuarioid);
        return redirect('/pagCliente');
    }

    public function eliminar(Request $request){
        $mint_Entidadid = (int)$request->idEntidad;
        return json_encode($this->EntidadRepo->f_Eliminar($mint_Entidadid));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
