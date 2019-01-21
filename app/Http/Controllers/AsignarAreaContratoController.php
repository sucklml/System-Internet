<?php
namespace App\Http\Controllers;
use App\Dispositivo;
use App\Repositories\UsuarioRepository;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Repositories\ContratoRepository;
use App\Repositories\AreaRepository;
use App\Repositories\Area_has_ContratoRepository;
class AsignarAreaContratoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $ContratoRepo;
    private $AreaRepo;
    private $Area_has_ContratoRepo;
    private $UsuarioRepo;
    public  function __construct(UsuarioRepository $UsuarioRepo,ContratoRepository $ContratoRepo, AreaRepository $AreaRepo, Area_has_ContratoRepository $Area_has_ContratoRepo)
    {
        $this->UsuarioRepo = $UsuarioRepo;
        $this->ContratoRepo = $ContratoRepo;
        $this->AreaRepo = $AreaRepo;
        $this->AreaRepo = $AreaRepo;
        $this->Area_has_ContratoRepo = $Area_has_ContratoRepo;
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
        //Falta validar que el usuario tenga permiso de acceder a es entidad
        $mint_EntidadId = (int)$request->session()->get('EntidadId','default');//Se carga la EntidadId al contratolador;
        $mint_ContratoId = (int)$request->input('_contratoid');
        if(is_int($mint_EntidadId) && $mint_EntidadId > 0 && is_int($mint_ContratoId) && $mint_ContratoId > 0)
        {
            $AreaId = (string)$request->session()->get('AreaId',0);
            $Niveles = (array)$request->session()->get('Niveles', '[1]');
            //Guardar en la session el ContratoId;
            $request->session()->put('ContratoId',$mint_ContratoId);
            $vobj_local=new \stdClass();//Objeto creado para pasar objetos a al vista;
            $vobj_local->v = $mint_EntidadId;
            $vobj_local->ContratoAreas = $this->ContratoRepo->flst_Obtener($mint_ContratoId);
            $vobj_local->Areas = $this->AreaRepo->flst_Listar($mint_EntidadId);
            $vobj_local->AreasSinAsig = $this->AreaRepo->flst_ListarAreaSinAsing($mint_EntidadId);
            $vobj_local->Dispositivos = json_encode(collect(Dispositivo::where('Estado',1)->get())->toArray());
            $request->v = $mint_EntidadId;//se le envia en el request para que el menu funcione
            //Funcion para resaltar el acceso
            $item = $this->f_accesoresaltado($item, $request);
            return view('modulos.asignarAreasContrato.asignarAreaContrato', ['item' => $item],['data'=>$vobj_local]);
            //return $request->id
        }
        else
        {
            return redirect('/pagCliente');
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fls_listarSubArea(Request $request)
    {
        $mint_EntidadId = (int)$request->session()->get('EntidadId','default');//Se carga la EntidadId al contratolador;
        $AreaId = (int)$request->input('AreaId',0);
        $Niveles = (array)$request->input('Niveles', '[2]');
        return response()->json($this->AreaRepo->flst_ListarSubAreasSinAsing($mint_EntidadId, $AreaId, $Niveles));
    }
    public function guardar(Request $request)
    {
        $mint_EntidadId = (int)$request->session()->get('EntidadId','default');
        $mlst_AreaId =  (array)$request->input('Asignar');
        $mint_ContratoId = (int)$request->session()->get('ContratoId', 'default');
        $mbol_result = $this->Area_has_ContratoRepo->fbol_Eliminar($mint_ContratoId,$mlst_AreaId);
        if($mbol_result > 0)
        {
            return redirect('/pagContrato/'.$mint_EntidadId);
        }
    }
    public function salir()
    {
        return redirect('/pagCliente');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request->getRequestUri();
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