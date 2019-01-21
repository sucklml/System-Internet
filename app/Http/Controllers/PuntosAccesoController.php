<?php

namespace App\Http\Controllers;

use App\Area;
use App\Consumo;
use App\Dispositivo;
use App\Repositories\DispositivoRepository;
use App\Repositories\UsuarioRepository;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\ContratoRepository;
use App\Repositories\AreaRepository;
use App\Repositories\ConsumoRepository;
use Excel;
class PuntosAccesoController extends Controller
{
    private $ContratoRepo;
    private $AreaRepo;
    private $ConsumoRepo;
    private $UsuarioRepo;
    private $DispositivoRepo;
    public  function __construct(UsuarioRepository $UsuarioRepo,ContratoRepository $ContratoRepo, AreaRepository $AreaRepo, ConsumoRepository $ConsumoRepo, DispositivoRepository $DispositivoRepo )
    {
        $this->UsuarioRepo = $UsuarioRepo;
        $this->ContratoRepo = $ContratoRepo;
        $this->AreaRepo = $AreaRepo;
        $this->ConsumoRepo = $ConsumoRepo;
        $this->DispositivoRepo = $DispositivoRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        //Validar que tanto el usuarioid que se encuentra en la secion tenga asigando el el areaId que viene del request
        $mint_EntidadId = (int)$request->v;
        if(is_int($mint_EntidadId) && $mint_EntidadId != null) {
            $Usuario = (string)$request->session()->get('user', 'default');
            $Password =   (string)$request->session()->get('pws', 'default');
            $user = $this->UsuarioRepo->validateUser($Usuario,$Password);
            if(count($user)== 0 ){
                return redirect('/');
            }
            $item = $this->f_castAccesos($user);
            //Guardar en la secion a la entidad;
            $request->session()->put('EntidadId',$mint_EntidadId);
            //Funcion para resaltar el acceso
            $item = $this->f_accesoresaltado($item, $request);
            //////////////Pasar datos a la vista ///////////
            //return $this->ContratoRepo->flst_Listar($mint_EntidadId);
            $mobj_data = new \stdClass();
            $mobj_data->AreasSinAsig = $this->AreaRepo->flst_ListarAreaSinAsing($mint_EntidadId);
            $mobj_data->Contratos = $this->ContratoRepo->flst_Listar($mint_EntidadId);
            $mobj_data->Dispositivo = $this->DispositivoRepo->flst_Listar();
            $mobj_data->Dispositivos = Dispositivo::all();

            $itemContrato = $this->ContratoRepo->flst_Obtener(1);
            $mobj_data->Dispositivos = json_encode(collect(Dispositivo::where('Estado',1)->get())->toArray());
            return view('modulos.crearPuntosAcceso.puntosAcceso', ['item' => $item],['data' => $mobj_data]);
            //
        }else{
            return redirect('/pagCliente');
        }
    }

    public function fint_guardarArea(Request $request)
    {
        $mint_idAreaedit = $request->input("idAreaEdit");
        $mstr_nombre = $request->input("nombre");
        $mstr_interface = $request->input("interface");
        $mstr_ctr = $request->input("ctr");
        $mstr_dep = $request->input("dependencia");
        $mstr_obs = $request->input("obs");
        $mstr_ctw = $request->input("ctw");
        $mint_ParentAreaId = (int)$request->input("idCodPadre");
        $mint_idDispositivo = (int)$request->input("idDispositivo");
        if($mint_idDispositivo == 0)
        {
            $mint_idDispositivo = null;
        }
        $mint_EntidadId = (int)$request->session()->get('EntidadId','default');
        $mint_Nivel = 0;
        $mint_ParentArea = null;
        //Si tiene id se crea la Sub Area Area
        if($mint_ParentAreaId > 0)
        {
            $mdat_Area = $this->AreaRepo->flst_Obtener($mint_ParentAreaId);
            if(count($mdat_Area) > 0)
            {
                $mint_Nivel = (int)$mdat_Area->Nivel + 1;
                $mint_ParentArea = $mint_ParentAreaId;
            }
            else
            {
                return json_encode(false);
            }
        }
        $mdat_Area = new Area();
        $mdat_Area->idAREA = $mint_idAreaedit;
        $mdat_Area->CTAS_CTR =  $mstr_ctr;
        $mdat_Area->Dependencia =  $mstr_dep;
        $mdat_Area->Obs =  $mstr_obs;
        $mdat_Area->CTW =  $mstr_ctw;
        $mdat_Area->idEntidad =  $mint_EntidadId;
        $mdat_Area->Interface =  $mstr_interface;
        $mdat_Area->Nivel =  $mint_Nivel;
        $mdat_Area->Nom_Area =  $mstr_nombre;
        $mdat_Area->Cod_Padre = $mint_ParentArea;
        $mdat_Area->idDispositivo =  $mint_idDispositivo;
        $mdat_Area->Estado = 1;
        $mbol_Area = $this->AreaRepo->flst_Guardar($mdat_Area);

        $mbol_Area->dispositivo = Dispositivo::find($mbol_Area->idDispositivo);
        return json_encode($mbol_Area);
        //$this->index($request);
    }

    public function fbol_guardarConsumo(Request $request)
    {
        $mlst_Consumo = (array)$request->lstConsumo;


        foreach($mlst_Consumo as $item)
        {
            $mint_AreaId = (int)$item["idArea"];
            $this->ConsumoRepo->flst_Desabiltar($mint_AreaId);
        }

        foreach($mlst_Consumo as $item)
        {
            $mint_AreaId = (int)$item["idArea"];
            $mdat_Consumo = new Consumo();
            $mdat_Consumo->idArea = $mint_AreaId;
            $mdat_Consumo->num_comp =$item["num_comp"];
            $mdat_Consumo->Mbps_Asignado = $item["Mbps_Asignado"];
            $mdat_Consumo->Porc_Mbps = $item["Porc_Mbps"];
            $mdat_Consumo->SubTotal = $item["SubTotal"];
            $mdat_Consumo->Fecha = DateTime::date();
            $mdat_Consumo->Estado = 1;
            $mbol_data = $this->ConsumoRepo->flst_Guardar($mdat_Consumo);

        }
        return json_encode(true);
    }

    public function fobj_obtenerArea(Request $request){
        $mint_idArea = $request->input("idArea");
        $mobj_Area = $this->AreaRepo->flst_Obtener($mint_idArea);
        $mobj_Area->dispositivo = Dispositivo::find($mobj_Area->idDispositivo);
        return json_encode($mobj_Area);
    }

    public function fbol_Eliminar(Request $request){
        $idArea = $request->input("idArea");
        return json_encode($this->AreaRepo->fbol_Eliminar($idArea));
    }

    public function fbol_GuardarDocumento(){


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
