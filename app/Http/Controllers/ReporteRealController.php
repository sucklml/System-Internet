<?php

namespace App\Http\Controllers;

use App\Contrato;
use App\Dispositivo;
use App\Entidad;
use App\Microtik;
use App\Proveedor;
use App\Repositories\AreaRepository;
use App\Repositories\ContratoRepository;
use App\Repositories\UsuarioRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class ReporteRealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $UsuarioRepo;
    private $ContratoRepo;
    private $AreaRepo;
    public  function __construct(UsuarioRepository $UsuarioRepo,ContratoRepository $ContratoRepo,AreaRepository $AreaRepo)
    {
        $this->UsuarioRepo = $UsuarioRepo;
        $this->ContratoRepo = $ContratoRepo;
        $this->AreaRepo = $AreaRepo;
    }

    public function index(Request $request) //Dashboard
    {
        $Usuario = (string)$request->session()->get('user', 'default');
        $Password = (string)$request->session()->get('pws', 'default');
        $user = $this->UsuarioRepo->validateUser($Usuario, $Password);
        if (count($user) == 0) {
            return redirect('/');
        }
        $request->session()->put('entidadId',(int)$request->v);
        $item = $this->f_castAccesos($user);

        //Funcion para resaltar el acceso
        $item = $this->f_accesoresaltado($item,$request);
        $mobj_data = new \stdClass();
        $mobj_data->Contrato = $this->ContratoRepo->flst_ListarSimple((int)$request->v);
        $mobj_data->Dispositivos = json_encode(collect(Dispositivo::where('Estado',1)->get())->toArray());
        return view('modulos.consultarConsumo.real.consumoReal', ['item' => $item], ['data' => $mobj_data]);
    }

    public function gerenerarReporte()
    {
        $jose = 'joseleeafsaf';
        $view =  \View('modulos.consultarConsumo.solicitado.reporte.Consumo',["data"=>$jose])->render();
        $mobj_pdf = \App::make('dompdf.wrapper')
            ->setPaper('a4');
        $mobj_pdf->loadHTML(utf8_decode($view));
        $mstr_pdf64 = base64_encode($mobj_pdf->output());
        ////data:application/pdf;base64
        //<img alt="Embedded Image" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIA..." />
        //download="
        //file_put_contents('jose.pdf',$pf);
        //return $pdf->stream('invoice',array("Attachment" => false));
        //return $pdf->download('invoice.pdf');
        // <a href="data:image/png;base64,{{$pf}}" download="jose.pdf">jse</a>
    }

    public function fls_areas(Request $request){
        $area = $this->AreaRepo->flst_ObtenerAreasMikrotik($request->microtikId);
        return json_encode($area);
    }

    public function view_Reporte(Request $request)
    {
        $mstr_fechaDesde = trim((string)$request->fechaDesde);
        $mstr_fechaHasta = trim((string)$request->fechaHasta);
        $idMicrotik = (int)$request->idMicrotik;

        $mobj_data = new \stdClass();
        $mobj_data->Dispo = Dispositivo::find($idMicrotik);
        $mdat_Entidad = Entidad::find((int)$request->session()->get('entidadId',0));
        $mobj_data->entidad = $mdat_Entidad;
        $mobj_data->fechaDesde = $mstr_fechaDesde;
        $mobj_data->fechaHasta = $mstr_fechaHasta;
        $mstr_fechaDesde = str_replace('-','/',$mstr_fechaDesde);
        $mstr_fechaHasta = str_replace('-','/',$mstr_fechaHasta);
        if($mstr_fechaDesde==""){
            $mstr_fechaDesde ='11/06/1990';
        }
        if($mstr_fechaHasta ==""){
            $mstr_fechaHasta = new \DateTime();
            $mstr_fechaHasta  = $mstr_fechaHasta->format("d/m/Y");

        }

        $format = 'd/m/Y';

        $consumoGlobal = Microtik::select(DB::raw('(SUM(microtik.Subida)/COUNT(microtik.Subida)) AS subida,(SUM(microtik.Bajada)/COUNT(microtik.Bajada)) AS bajada'))
            ->join('area', 'microtik.AREA_idSECTOR', '=', 'area.idAREA')
            ->where("microtik.Fecha",">=",Carbon::createFromFormat($format, $mstr_fechaDesde))
            ->where("microtik.Fecha","<",Carbon::createFromFormat($format, $mstr_fechaHasta))
            ->where("area.idDispositivo","=",$idMicrotik)
            ->where("microtik.Bajada","!=",0)
            ->where("microtik.Subida","!=",0)
            ->groupBy('microtik.AREA_idSECTOR')
            ->get();
        $mint_subida=0;
        $mint_bajada=0;
        foreach ($consumoGlobal as $itemGlobal){
            $mint_subida += $itemGlobal->subida;
            $mint_bajada += $itemGlobal->bajada;
        }
        $mobj_data->consumoGlobal = new \stdClass();
        $mobj_data->consumoGlobal->subida=$mint_subida;
        $mobj_data->consumoGlobal->bajada=$mint_bajada;



        $mobj_data->consumoTop5 = Microtik::select(DB::raw('(SUM(microtik.Subida)/COUNT(microtik.Subida)) AS subida,(SUM(microtik.Bajada)/COUNT(microtik.Bajada)) AS bajada, area.*'))
            ->join('area', 'microtik.AREA_idSECTOR', '=', 'area.idAREA')
            ->where("microtik.Fecha",">=",Carbon::createFromFormat($format, $mstr_fechaDesde))
            ->where("microtik.Fecha","<",Carbon::createFromFormat($format, $mstr_fechaHasta))
            ->where("area.idDispositivo","=",$idMicrotik)
            ->where("microtik.Bajada","!=",0)
            ->where("microtik.Subida","!=",0)
            ->groupBy('microtik.AREA_idSECTOR')
//            ->having('account_id', '>', 100)
            ->orderBy('microtik.Bajada', 'asc')
            ->take(5)
            ->get();

        $mobj_data->consumoArea = Microtik::select(DB::raw('STDDEV_SAMP(microtik.Bajada) as desvSTR,(SUM(microtik.Subida)/COUNT(microtik.Subida)) AS subida,(SUM(microtik.Bajada)/COUNT(microtik.Bajada)) AS bajada, area.*'))
            ->join('area', 'microtik.AREA_idSECTOR', '=', 'area.idAREA')
            ->where("microtik.Fecha",">=",Carbon::createFromFormat($format, $mstr_fechaDesde))
            ->where("microtik.Fecha","<",Carbon::createFromFormat($format, $mstr_fechaHasta))
            ->where("area.idDispositivo","=",$idMicrotik)
            ->where("microtik.Bajada","!=",0)
            ->where("microtik.Subida","!=",0)
            ->groupBy('microtik.AREA_idSECTOR')
//            ->having('account_id', '>', 100)
            ->orderBy('microtik.Bajada', 'asc')
            ->get();


        return $view = $this->fobj_RenderHtml($mobj_data);
    }

    public function fobj_RenderHtml($mobj_data){
        return View('modulos.consultarConsumo.real.reporte.Consumo',["data"=>$mobj_data])->render();
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
