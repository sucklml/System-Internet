<?php

namespace App\Http\Controllers;

use App\Contrato;
use App\Det_contrato;
use App\Dispositivo;
use App\Repositories\ProveedorRepository;
use App\Repositories\UsuarioRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\ContratoRepository;
class ContratoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $ContratoRepo;
    private $ProveedorRepo;
    private $UsuarioRepo;
    public  function __construct(UsuarioRepository $UsuarioRepo,ContratoRepository $ContratoRepo, ProveedorRepository $ProveedorRepo)
    {
        $this->UsuarioRepo = $UsuarioRepo;
        $this->ContratoRepo = $ContratoRepo;
        $this->ProveedorRepo = $ProveedorRepo;
    }
    public function index(Request $request)
    {
        //Validar que tanto el usuarioid que se encuentra en la secion tenga asigando el el areaId que viene del request
        $mint_EntidadId = (int)$request->v;
        if($mint_EntidadId != null) {

            $Usuario = (string)$request->session()->get('user', 'default');
            $Password =   (string)$request->session()->get('pws', 'default');
            $user = $this->UsuarioRepo->validateUser($Usuario,$Password);
            if(count($user)== 0 ){
                return redirect('/');
            }
            $item = $this->f_castAccesos($user);
            $mint_UsuarioId = $user[0]->idUSUARIO;

            $request->session()->put('EntidadId',$mint_EntidadId);
            //Funcion para resaltar el acceso
            $item = $this->f_accesoresaltado($item, $request);
            $mobj_data = new \stdClass();
            $mobj_data->Contratos = $this->ContratoRepo->flst_Listar($mint_EntidadId);
            $mobj_data->Proveedores = $this->ProveedorRepo->fls_Proveedores();
            $mobj_data->Dispositivos = json_encode(collect(Dispositivo::where('Estado',1)->get())->toArray());
            return view('modulos.realizarContrato.contrato', ['item' => $item],['data'=> $mobj_data]);
            //return $request->id;
        }else{
            return redirect('/pagCliente');
        }
    }

    public function fbol_guardarContrato(Request $request){
        $mint_EntidadId = (int)$request->session()->get('EntidadId', 'default');
        $mobj_data = json_decode($request->Contrato);

        foreach($mobj_data as $item){
            $mobj_Contrato = new Contrato();
            $mlst_DetContrato = array();
            $mobj_Contrato->idEntidad = $mint_EntidadId;
            $mobj_Contrato->idProveedor = $item->idProveedor;
            $mobj_Contrato->Fech_Emision =  $item->Fech_Emision;
            $mobj_Contrato->Fech_Vencimiento =  $item->Fech_Vencimiento;
            $mobj_Contrato->Velocidad_Mb =  $item->Velocidad_Mb;
            $mobj_Contrato->Cod_Contrato =  $item->Cod_Contrato;
            $mobj_Contrato->Descripcion =  $item->Descripcion;
            $mobj_Contrato->Importe =  $item->Importe;
            $mobj_Contrato->Num_Recibo =  $item->Num_Recibo;
            $mobj_Contrato->Img_url = 1;
            foreach($item->detalle as $itemDetalle)
            {
                $mobj_Det_Contrato = new Det_contrato();
                $mobj_Det_Contrato->Servicio=$itemDetalle->Servicio;
                $mobj_Det_Contrato->CD_Req=$itemDetalle->CD_Req;
                $mobj_Det_Contrato->Oficina=$itemDetalle->Oficina;
                $mobj_Det_Contrato->Velocidad=$itemDetalle->Velocidad;
                $mobj_Det_Contrato->Importe=$itemDetalle->Importe;
                array_push($mlst_DetContrato,$mobj_Det_Contrato);
            }
            //return json_encode($mlst_DetContrato);
            return json_encode($this->ContratoRepo->flst_Guardar($mobj_Contrato,$mlst_DetContrato));
        }
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
    public function f_eliminar(Request $request)
    {
        $idContrato = $request->idContrato;
        return json_encode($this->ContratoRepo->fbol_eliminar($idContrato));

    }
}
