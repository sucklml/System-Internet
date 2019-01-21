<?php
/**
 * Created by PhpStorm.
 * User: Jose Arias
 * Date: 22/05/2017
 * Time: 14:53
 */

namespace App\Repositories;
use App\Contrato;
use App\Documento;
use App\Entidad;
use App\Repositories\ContratoRepository;
use App\Usuario;
use App\Usuario_has_Cliente;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EntidadRepository
{
    private $EntidadModel;
    private $ContratoRepo;
    public  function __construct(Entidad $EntidadModel, ContratoRepository $ContratoRepo)
    {
        $this->EntidadModel = $EntidadModel;
        $this->ContratoRepo = $ContratoRepo;
    }

    public function flst_ObtenerContrato($vint_Entidad)
    {
        $mdat_Entidad = Entidad::find($vint_Entidad);
        if(!is_null($mdat_Entidad))
        {
            //$mdat_Entidad->contrato;
            /*foreach($mdat_Entidad->contrato as $itemContrato)
            {
                $itemContrato->proveedor;
                $itemContrato->areas;
                $totalCantMbts = 0;
                $totalPorcMbts = 0;
                $totalImporMbts = 0;

                foreach($itemContrato->areas as $item)
                {
                    $item->consumo;
                    $totalPorcMbts = $totalPorcMbts + $item->consumo["Porc_Mbps"];
                    $totalCantMbts = $totalCantMbts + $item->consumo["Mbps_Asignado"];
                    $totalImporMbts = $totalImporMbts + $item->consumo["SubTotal"];
                }
                $itemContrato->totalCantMbts = $totalCantMbts;
                $itemContrato->totalPorcMbts = $totalPorcMbts;
                $itemContrato->totalImporMbts = $totalImporMbts;

            }*/
        }
        return $mdat_Entidad;
    }

    public function Obtener($idEntidad){
        return Entidad::find($idEntidad);
    }

    public function Guardar(Entidad $data, $usuarioid)
    {
        $primarykey = $this->EntidadModel->getKeyName();
        $maxKey = Entidad::all()->max($primarykey);
        $data->$primarykey = $maxKey+1;
        $data->save();


        $usuario_has_cliente = new Usuario_has_Cliente();
        $maxsKeys = Usuario_has_Cliente::all()->max('idEntidad_has_Usuario');
        $usuario_has_cliente->idEntidad_has_Usuario = $maxsKeys+1;
        $usuario_has_cliente->idEntidad = $maxsKeys;
        $usuario_has_cliente->idUSUARIO = $usuarioid;
        $usuario_has_cliente->Estado = 1;
        $usuario_has_cliente->save();
    }

    public function flst_ContratoDocumentos($vint_Entidad,$vint_Contrato,$vint_estadoDocumento,$mstr_FecReferencia)
    {
        $Declare = DB::raw("date_format(documentos.FechaDesde,'%m/%Y')");
        $Resul = DB::raw("date_format(documentos.FechaDesde,'%m/%Y')");

        if ($mstr_FecReferencia != "")
        {
            $Resul = $mstr_FecReferencia;
        }

        $mdat_Entidad = Entidad::find($vint_Entidad);
        if($vint_Contrato == 0)
        {

            $mlst_Documentos = Documento::select(DB::raw("count(*) as Cantidad"), DB::raw("date_format(documentos.FechaDesde,'%m/%Y') as FechaRef"),DB::raw("month(documentos.FechaDesde) AS MesRef"),DB::raw("year(documentos.FechaDesde) AS AñoRef"),'documentos.idCONTRATO')
                ->whereIn("idCONTRATO",Contrato::where("idEntidad",$vint_Entidad)
                    ->select("idCONTRATO")
                    ->get()
                )
                ->where('EstadoDoc',$vint_estadoDocumento)
                ->where($Declare,$Resul)
                ->where('Estado',1)
                ->groupBy('idCONTRATO','AñoRef','MesRef')
                ->orderBy('idCONTRATO','asc')
                ->orderBy('AñoRef','desc')
                ->orderBy('MesRef','desc')
                ->get();
        }
        else
        {
            $mlst_Documentos = Documento::select(DB::raw("count(*) as Cantidad"), DB::raw("date_format(documentos.FechaDesde,'%m/%Y') as FechaRef"),DB::raw("month(documentos.FechaDesde) AS MesRef"),DB::raw("year(documentos.FechaDesde) AS AñoRef"),'documentos.idCONTRATO')
                ->where("idCONTRATO",$vint_Contrato)
                ->where('EstadoDoc',$vint_estadoDocumento)
                ->where('Estado',1)
                ->where($Declare,$Resul)
                ->groupBy('idCONTRATO','AñoRef','MesRef')
                ->orderBy('idCONTRATO','asc')
                ->orderBy('AñoRef','desc')
                ->orderBy('MesRef','desc')
                ->get();
        }

        foreach($mlst_Documentos as $itemDocumento)
        {
            $itemDocumento->contrato = Contrato::find($itemDocumento->idCONTRATO);
            $itemDocumento->detalle = Documento::select(DB::raw("month(documentos.FechaDesde) AS MesRef"),DB::raw("year(documentos.FechaDesde) AS AñoRef"),'documentos.*')
                ->where(DB::raw("year(documentos.FechaDesde)"),'=',$itemDocumento->AñoRef)
                ->where(DB::raw("month(documentos.FechaDesde)"),'=',$itemDocumento->MesRef)
                ->where('idCONTRATO','=',$itemDocumento->idCONTRATO)
                ->where('EstadoDoc',$vint_estadoDocumento)
                ->where('Estado',1)
                ->orderBy('Fecha','desc')
                ->get();
            foreach($itemDocumento->detalle as $itemDetalle)
            {
                $itemDetalle->usuario = Usuario::find($itemDetalle->idUSUARIO);
            }
        }
        $mdat_Entidad->Documentos = $mlst_Documentos;
        return $mdat_Entidad;
    }

    public function  f_Eliminar($id){
        $mdat_Entidad = Entidad::find($id);
        $mdat_Entidad->Estado = null;
        return $mdat_Entidad->save();
    }
}