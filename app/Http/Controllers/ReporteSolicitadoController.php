<?php

namespace App\Http\Controllers;

use App\Dispositivo;
use App\Documento;
use App\Repositories\EntidadRepository;
use App\Repositories\UsuarioRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\ContratoRepository;
use App\Repositories\DocumentoRepository;
use Illuminate\Support\Facades\View;
use Excel;

class ReporteSolicitadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $ContratoRepo;
    private $DocumentoRepo;
    private $EntidadRepo;
    private $UsuarioRepo;
    public  function __construct(UsuarioRepository $UsuarioRepo,ContratoRepository $ContratoRepo,DocumentoRepository $DocumentoRepo, EntidadRepository $EntidadRepo)
    {
        $this->UsuarioRepo = $UsuarioRepo;
        $this->ContratoRepo = $ContratoRepo;
        $this->DocumentoRepo = $DocumentoRepo;
        $this->EntidadRepo = $EntidadRepo;
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
            //Guardar en la secion el entidadid;
            $mint_entidadId = (int)$request->v;
            $request->session()->put('entidadId',$mint_entidadId);
            ///////////////////////////////////
            //Funcion para resaltar el acceso
            $item = $this->f_accesoresaltado($item, $request);
            $mint_estadoReporte = (int)(string)$request->session()->get('Estado', '0');
            $mint_idContrato = (int)$request->session()->get('idContrato', 'default');
            $mstr_FecReferencia = (string)$request->session()->get('FechaReferencia', '');
            if($mint_estadoReporte == 0)
            {
                $mint_estadoReporte = 1;
            }

            if($user[0]->roles[0]->idROL != 1){

            if($user[0]->roles[0]->idROL == 2){
                $mint_estadoReporte = 1;
            }else if($user[0]->roles[0]->idROL == 3){
                $mint_estadoReporte = 2;
            }else if($user[0]->roles[0]->idROL == 4){
                $mint_estadoReporte = 3;
            }

            }
        $mobj_data= $this->ContratoRepo->flst_Listar($mint_entidadId);

        
        return Excel::create(
            'Reporte Excel', function($excel) use($mobj_data)
        {
            foreach($mobj_data as $item)
            {

                $excel->sheet($item->Descripcion, function ($sheet) use($item) {
                    $sheet->fromArray(array(
                        array('', '','','Dependencia ADM','Obs','Nivel CTR','Nivel CTW','Nombre del Nivel','Sub Area','N° de Pcs','N° de Pcs x/Nivel','Mbps/xPC','Mbps/xNivel','% Asignado x PC','% Asignado x Nivel','Costo asignado/PC','Sub Total')
                    ),null, 'A1', false, false);
                    foreach($item->areas  as $item1)
                    {

                        $sheet->fromArray(array(
                            array($item1->Nom_Area,'')
                        ),null, 'A1', false, false);
                        foreach($item1->area  as $item2)
                        {
                            $sheet->fromArray(array(
                                array('',$item2->Nom_Area)
                            ),null, 'A1', false, false);
                            foreach($item2->area  as $item3)
                            {
                                $sheet->setColumnFormat(array(
                                    'L' => '0.000',
                                    'P' => '0.000',
                                    'M' => '0.000',
                                    'Q' => '0.000',
                                    'N' => '0.00%',
                                    'O' => '0.00%',
                                ));
                                $sheet->fromArray(array(
                                    array('','',$item3->Nom_Area)
                                ),null, 'A1', false, false);
                                foreach($item3->area  as $item4)
                                {
                                    $sheet->fromArray(array(
                                        array('','','',$item4->Dependencia,$item4->Obs,$item4->CTAS_CTR,$item4->CTW,$item4->Nom_Area,'','',floatval($item4->consumo["num_comp"]),'',floatval($item4->consumo["Mbps_Asignado"]),'',floatval($item4->consumo["Porc_Mbps"]),'',floatval($item4->consumo["SubTotal"]))
                                    ),null, 'A1', false, false);
                                    foreach($item4->area  as $item5)
                                    {
                                        $sheet->fromArray(array(
                                            array('','','','','','','','',$item5->Nom_Area,floatval($item5->consumo["num_comp"]),'',floatval($item5->consumo["Mbps_Asignado"]),'',floatval($item5->consumo["Porc_Mbps"]),'',floatval($item5->consumo["SubTotal"]))
                                        ),null, 'A1', false, false);

                                    }
                                }

                            }
                        }
                    }

                });
            }
            // Our first sheet


        })->export('xlsx');

    }

    public function flst_Documentos(Request $request){
        return json_encode($this->DocumentoRepo->flst_Listar());
    }

    public function fint_guardarPdf(Request $request)
    {
        $mint_entidadId = (int)$request->session()->get('entidadId','default');
        $mstr_fechaDesde = (string)$request->fechaDesde;
        $mstr_fechaHasta = (string)$request->fechaHasta;

        $mstr_fechaDesde = str_replace('/','-',$mstr_fechaDesde);
        $mstr_fechaHasta = str_replace('/','-',$mstr_fechaHasta);

        $mdat_Entidad = $this->EntidadRepo->Obtener($mint_entidadId);
        if(!is_null($mdat_Entidad))
        {
            $mdat_Entidad->contrato;
            foreach($mdat_Entidad->contrato as $itemContrato)
            {
                /*$itemContrato->areas;
                $mobj_data = new \stdClass();
                $mobj_data->entidad = $mdat_Entidad;
                $mobj_data->contrato = $itemContrato;


                $view =  \View('modulos.consultarConsumo.solicitado.reporte.Consumo',["data"=>$mobj_data])->render();
                $mobj_pdf = \App::make('dompdf.wrapper')
                    ->setPaper('a4');
                $mobj_pdf->loadHTML(utf8_decode($view));

                //return $mobj_pdf->stream();

                /////No tocar XD//////////////////////////////////
                $mstr_pdf64 = base64_encode($mobj_pdf->output());
                $mobj_Documento = new Documento();
                $mobj_Documento->Documento = $mstr_pdf64;
                $mobj_Documento->TypeDocum = "application/pdf";
                $mobj_Documento->Fecha = new \DateTime();
                $mobj_Documento->idCONTRATO = $itemContrato->idCONTRATO;
                $mobj_Documento->idUSUARIO = 1;
                //$mobj_Documento->DocPrueva = null;
                //$mobj_Documento->TypePrue = null;
                $this->DocumentoRepo->flst_Guardar($mobj_Documento);
                */

                $mdat_Contrato = $this->ContratoRepo->flst_Obtener($itemContrato->idCONTRATO);

                $viewDetallado = $this->DocumentoRepo->fobj_RenderHtml($mdat_Entidad,$mdat_Contrato,$mstr_fechaDesde,$mstr_fechaHasta,false,'D');
                $viewSImple = $this->DocumentoRepo->fobj_RenderHtml($mdat_Entidad,$mdat_Contrato,$mstr_fechaDesde,$mstr_fechaHasta,false,'S');

                $viewDocDetallado = $this->DocumentoRepo->fobj_RenderHtml($mdat_Entidad,$mdat_Contrato,$mstr_fechaDesde,$mstr_fechaHasta,true,'D');
                $viewDocSimple = $this->DocumentoRepo->fobj_RenderHtml($mdat_Entidad,$mdat_Contrato,$mstr_fechaDesde,$mstr_fechaHasta,true,'S');

                $mobj_Documento = new Documento();
                $mobj_Documento->PreviewSimple = $viewSImple;
                $mobj_Documento->DocumentoSimple = $viewDocSimple;
                $mobj_Documento->Fecha = new \DateTime();
                $mobj_Documento->idCONTRATO = $mdat_Contrato->idCONTRATO;
                $mobj_Documento->Preview = $viewDetallado;
                $mobj_Documento->Documento = $viewDocDetallado;
                $mobj_Documento->idUSUARIO = 1;
                $mobj_Documento->FechaDesde = Carbon::parse($mstr_fechaDesde);
                $mobj_Documento->FechaHasta = Carbon::parse($mstr_fechaHasta);
                $mobj_Documento->EstadoDoc = 1;
                $mobj_Documento->Estado = 1;
                //$mobj_Documento->DocPrueva = null;
                //$mobj_Documento->TypePrue = null;
                $this->DocumentoRepo->flst_Guardar($mobj_Documento);
            }
        }
        $request->session()->put('Estado',1);
        return response()->json(true);
    }

    public function subirPdf(Request $request)
    {
        $mint_DocumentoId = $request->input('mint_DocumentoId');
        $f = $request->file('images');
        $mobj_Documento = Documento::find($mint_DocumentoId);
        $mobj_Documento->DocPrueba = base64_encode(file_get_contents($f->getRealPath()));
        $mobj_Documento->TypePrue = $f->getMimeType();
        $mobj_Documento->EstadoDoc =  3;
        $this->DocumentoRepo->flst_Guardar($mobj_Documento);
        $request->session()->put('Estado',3);
        return json_encode($mint_DocumentoId);
    }

    public function view_Reporte(Request $request)
    {
        $min_Contratoid = (int)$request->idContrato;
        $mstr_fechaDesde = (string)$request->fechaDesde;
        $mstr_fechaHasta = (string)$request->fechaHasta;
        $itemContrato = $this->ContratoRepo->flst_Obtener($min_Contratoid);
        $mdat_Entidad = $this->EntidadRepo->Obtener($itemContrato->idEntidad);

        return $view = $this->DocumentoRepo->fobj_RenderHtml($mdat_Entidad,$itemContrato,$mstr_fechaDesde,$mstr_fechaHasta,false,'D');
        ///$mobj_pdf = \App::make('dompdf.wrapper');

        //$mobj_pdf->loadHTML(utf8_decode($view));

        //return $mobj_pdf->stream();
    }
    public function view_ReporteExcel(Request $request){
        $min_Contratoid = (int)$request->idContrato;
        $mstr_fechaDesde = (string)$request->fechaDesde;
        $mstr_fechaHasta = (string)$request->fechaHasta;
        $itemContrato = $this->ContratoRepo->flst_Obtener($min_Contratoid);
        $mdat_Entidad = $this->EntidadRepo->Obtener($itemContrato->idEntidad);
        return Excel::create(
            'Filename', function($excel)
        {

            // Our first sheet
            $excel->sheet('First sheet', function ($sheet) {
                $sheet->row(1, array(
                    'test1', 'test2'
                ));
                // Manipulate 2nd row
                $sheet->row(2, array(
                    'test3', 'test4'
                ));
            });

            // Our second sheet
            $excel->sheet('Second sheet', function ($sheet) {
                $sheet->row(1, array(
                    'test1', 'test2'
                ));
                // Manipulate 2nd row
                $sheet->row(2, array(
                    'test3', 'test4'
                ));
            });

        })->export('xlsx');

    }

    public function view_ReporteGenerado(Request $request)
    {
        $min_idDocumento = (int)$request->idDocumentos;
        $min_tipo = (int)$request->tipo;
        $html_Documento = "<h1>8(</h1>";
        if($min_tipo == 1){
            $mdat_Documento = $this->DocumentoRepo->flst_Obtener($min_idDocumento);
            $html_Documento = $mdat_Documento->Preview;
        }
        else if($min_tipo == 2)
        {
            $mdat_Documento = $this->DocumentoRepo->flst_Obtener($min_idDocumento);
            $html_Documento = $mdat_Documento->PreviewSimple;
        }
        return $html_Documento;
    }

    public function fbol_guardarView(Request $request){

        $min_Contratoid = (int)$request->idContrato;
        $mstr_fechaDesde = (string)$request->fechaDesde;
        $mstr_fechaHasta = (string)$request->fechaHasta;
        $itemContrato = $this->ContratoRepo->flst_Obtener($min_Contratoid);
        $mdat_Entidad = $this->EntidadRepo->Obtener($itemContrato->idEntidad);

        $viewDetallado = $this->DocumentoRepo->fobj_RenderHtml($mdat_Entidad,$itemContrato,$mstr_fechaDesde,$mstr_fechaHasta,false,'D');
        $viewSImple = $this->DocumentoRepo->fobj_RenderHtml($mdat_Entidad,$itemContrato,$mstr_fechaDesde,$mstr_fechaHasta,false,'S');

        $viewDocDetallado = $this->DocumentoRepo->fobj_RenderHtml($mdat_Entidad,$itemContrato,$mstr_fechaDesde,$mstr_fechaHasta,true,'D');
        $viewDocSimple = $this->DocumentoRepo->fobj_RenderHtml($mdat_Entidad,$itemContrato,$mstr_fechaDesde,$mstr_fechaHasta,true,'S');

        $mobj_Documento = new Documento();
        $mobj_Documento->PreviewSimple = $viewSImple;
        $mobj_Documento->DocumentoSimple = $viewDocSimple;
        $mobj_Documento->Fecha = new \DateTime();
        $mobj_Documento->idCONTRATO = $itemContrato->idCONTRATO;
        $mobj_Documento->Preview = $viewDetallado;
        $mobj_Documento->Documento = $viewDocDetallado;
        $mobj_Documento->idUSUARIO = 1;
        $mobj_Documento->FechaDesde = Carbon::parse($mstr_fechaDesde)->format('Y-m-d');
        $mobj_Documento->FechaHasta = Carbon::parse($mstr_fechaHasta)->format('Y-m-d');
        $mobj_Documento->EstadoDoc = 1;
        $mobj_Documento->Estado = 1;
        //$mobj_Documento->DocPrueva = null;
        //$mobj_Documento->TypePrue = null;
        $request->session()->put('Estado',1);
        return json_encode($this->DocumentoRepo->flst_Guardar($mobj_Documento));


    }

    public function f_eliminarDoc(Request $request)
    {
        $mint_entidadId = (int)$request->session()->get('entidadId','default');
        $min_idDocumento = (int)$request->idDocumentos;
        $this->DocumentoRepo->flst_Eliminar($min_idDocumento);
        return redirect('/pagConsumoSolicitado/'.$mint_entidadId);
    }

    public function f_aceptarDoc(Request $request)
    {
        $mint_entidadId = (int)$request->session()->get('entidadId','default');
        $min_idDocumentos = (int)$request->idDocumentos;
        $dat_Documentos = Documento::find($min_idDocumentos);
        $dat_Documentos->EstadoDoc = 2;
        if($dat_Documentos->TypeDocum == null)
        {
            $HtmlDocDetallado = $dat_Documentos->Documento;
            $HtmlDocSimple = $dat_Documentos->DocumentoSimple;
            $mobj_pdf = \App::make('dompdf.wrapper');
            $mobj_pdf->loadHTML(utf8_decode($HtmlDocDetallado));
            $mstr_pdf64Detallado = base64_encode($mobj_pdf->output());

            $mobj_pdf2 = \App::make('dompdf.wrapper');
            $mobj_pdf2->loadHTML(utf8_decode($HtmlDocSimple));
            $mstr_pdf64Simple = base64_encode($mobj_pdf2->output());

            $dat_Documentos->TypeDocum = "application/pdf";
            $dat_Documentos->Documento = $mstr_pdf64Detallado;
            $dat_Documentos->DocumentoSimple = $mstr_pdf64Simple;
        }
        $this->DocumentoRepo->flst_Actualizar($dat_Documentos);
        $request->session()->put('Estado',2);
        return redirect('/pagConsumoSolicitado/'.$mint_entidadId);
    }

    public function f_extornarDoc(Request $request)
    {
        $mint_entidadId = (int)$request->session()->get('entidadId','default');
        $min_idDocumentos = (int)$request->idDocumentos;
        $dat_Documentos = Documento::find($min_idDocumentos);
        $newEstado = $dat_Documentos->EstadoDoc - 1;
        $dat_Documentos->EstadoDoc =  $newEstado;
        $this->DocumentoRepo->flst_Actualizar($dat_Documentos);
        $request->session()->put('Estado',$newEstado);
        return redirect('/pagConsumoSolicitado/'.$mint_entidadId);
    }

    public function f_EstadoDoc(Request $request)
    {
        $mint_Estado = (int)$request->Estado;
        $request->session()->put('Estado',$mint_Estado);
        $mint_entidadId = (int)$request->session()->get('entidadId','default');
        return redirect('/pagConsumoSolicitado/'.$mint_entidadId);
    }

    public function Search(Request $request){
        $mint_entidadId = (int)$request->session()->get('entidadId','default');
        $mint_IdContrato = (int)$request->sel_contrato;
        $mstr_FecReferencia= (string)$request->text_fechaDesde;
        $request->session()->put('idContrato',$mint_IdContrato);
        $request->session()->put('FechaReferencia',$mstr_FecReferencia);
        return redirect('/pagConsumoSolicitado/'.$mint_entidadId);
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
