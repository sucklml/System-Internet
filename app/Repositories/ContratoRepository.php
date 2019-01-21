<?php
/**
 * Created by PhpStorm.
 * User: Jose Arias
 * Date: 12/05/2017
 * Time: 12:31
 */

namespace App\Repositories;
use App\Contrato;
use App\Dispositivo;
use App\Documento;
use App\Proveedor;
use Illuminate\Support\Facades\DB;

class ContratoRepository
{
    private $ContratoModel;
    private $Det_contratoRepo;
    public  function __construct(Contrato $ContratoModel, Det_contratoRepository $Det_contratoRepo)
    {
        $this->ContratoModel = $ContratoModel;
        $this->Det_contratoRepo = $Det_contratoRepo;
    }
    public function flst_ListarSimple($vint_entidadId)
    {
        $mdat_contrato = Contrato::where('idEntidad',$vint_entidadId)
            ->where('Img_url',1)
            ->get();
        foreach($mdat_contrato as $item)
        {
            $item->areas;
            $ConsumorealContrato = 0;
            foreach($item->areas as $item1)
            {
                $Consumoreal = 0;
                foreach($item1->microtik as $itemMicrotik)
                {
                    $Consumoreal = ($Consumoreal + $itemMicrotik->Subida);
                }
                if(count($item1->microtik)>0){
                    $Consumoreal = $Consumoreal/count($item1->microtik);
                }
                $ConsumorealContrato = $ConsumorealContrato + $Consumoreal;
                $item1->ConsumoReal = (double)number_format($Consumoreal,2, '.', ',');
            }

            $item->ConsumoReal = (double)number_format($ConsumorealContrato,2, '.', ',');
        }
        return $mdat_contrato;
    }

    public function flst_Listar($vint_entidadId)
    {
        $mdat_contrato = Contrato::where('idEntidad',$vint_entidadId)
            ->where('Img_url','1')
            ->get();

        foreach($mdat_contrato as $item)
        {
            $item->detalle;
            $item->areas;
            $totalNumComp = 0;
            $totalCantMbts = 0;
            $totalPorcMbts = 0;
            $totalImporMbts = 0;

            foreach($item->areas as $item1)
            {
                switch($item1->idAREA)
                {
                    case 212: $item1->Interface = "dgti-Academico"; break;
                    case 152: $item1->Interface = "dgti-Administrativa"; break;
                    case 195: $item1->Interface = "dgti-Finanzas"; break;
                    case 261: $item1->Interface = "dgti-Auditorios"; break;
                    case 257: $item1->Interface = "dgti-Biblioteca"; break;
                    case 140: $item1->Interface = "dgti-Colegio"; break;
                    case 256: $item1->Interface = "dgti-PostGrado"; break;
                    case 264: $item1->Interface = "dgti-Servicios"; break;
                    case 314: $item1->Interface = "dgti-Imprenta"; break;
                    case 217: $item1->Interface = "dgti-Laboratorios"; break;
                    case 104: $item1->Interface = "dgti-ProducUnion"; break;
                }

                $Consumoreal = 0;
                $item1->microtik;
                $item1->dispositivo = Dispositivo::find($item1->idDispositivo);
                foreach($item1->microtik as $itemMicrotik)
                {
                    $Consumoreal = ($Consumoreal + $itemMicrotik->Subida);
                }
                if(count($item1->microtik)>0){
                    $Consumoreal = $Consumoreal/count($item1->microtik);
                }
                $item1->ConsumoReal = (double)number_format($Consumoreal,2, '.', ',');

                $item1->area;
                $item1->consumo;
                $totalNumComp1 = 0;
                $totalCantMbts1 = 0;
                $totalPorcMbts1 = 0;
                $totalImporMbts1 = 0;

                foreach($item1->area as $item2)
                {
                    $item2->area;
                    $item2->consumo;
                    $totalNumComp2 = 0;
                    $totalCantMbts2 = 0;
                    $totalPorcMbts2 = 0;
                    $totalImporMbts2 = 0;
                    foreach($item2->area as $item3)
                    {
                        $item3->area;
                        $item3->consumo;
                        $totalNumComp3 = 0;
                        $totalCantMbts3 = 0;
                        $totalPorcMbts3 = 0;
                        $totalImporMbts3 = 0;
                        foreach($item3->area as $item4)
                        {
                            $item4->area;
                            $item4->consumo;
                            $totalNumComp4 = 0;
                            $totalCantMbts4 = 0;
                            $totalPorcMbts4 = 0;
                            $totalImporMbts4 = 0;
                            foreach($item4->area as $item5)
                            {
                                $item5->area;
                                $item5->consumo;
                                $totalNumComp4 = $totalNumComp4 + $item5->consumo["num_comp"];
                                $totalPorcMbts4 = $totalPorcMbts4 + $item5->consumo["Porc_Mbps"];
                                $totalCantMbts4 = $totalCantMbts4 + $item5->consumo["Mbps_Asignado"];
                                $totalImporMbts4 = $totalImporMbts4 + $item5->consumo["SubTotal"];
                            }
                            $item4->totalCantMbts = $totalCantMbts4;
                            $item4->totalPorcMbts = $totalPorcMbts4;
                            $item4->totalImporMbts = $totalImporMbts4;
                            $item4->totalNumComp = $totalNumComp4;
                            $totalNumComp3 = $totalNumComp3 + $item4->consumo["num_comp"];
                            $totalPorcMbts3 = $totalPorcMbts3 + $item4->consumo["Porc_Mbps"];
                            $totalCantMbts3 = $totalCantMbts3 + $item4->consumo["Mbps_Asignado"];
                            $totalImporMbts3 = $totalImporMbts3 + $item4->consumo["SubTotal"];
                            $totalNumComp = $totalNumComp + $item4->consumo["num_comp"];
                            $totalPorcMbts = $totalPorcMbts + $item4->consumo["Porc_Mbps"];
                            $totalCantMbts = $totalCantMbts + $item4->consumo["Mbps_Asignado"];
                            $totalImporMbts = $totalImporMbts + $item4->consumo["SubTotal"];
                        }
                        $item3->totalCantMbts = $totalCantMbts3;
                        $item3->totalPorcMbts = $totalPorcMbts3;
                        $item3->totalImporMbts = $totalImporMbts3;
                        $item3->totalNumComp = $totalNumComp3;
                        $totalNumComp2 = $totalNumComp2 + $item3->consumo["num_comp"];
                        $totalPorcMbts2 = $totalPorcMbts2 + $item3->consumo["Porc_Mbps"];
                        $totalCantMbts2 = $totalCantMbts2 + $item3->consumo["Mbps_Asignado"];
                        $totalImporMbts2 = $totalImporMbts2 + $item3->consumo["SubTotal"];
                    }
                    $item2->totalCantMbts = $totalCantMbts2;
                    $item2->totalPorcMbts = $totalPorcMbts2;
                    $item2->totalImporMbts = $totalImporMbts2;
                    $item2->totalNumComp = $totalNumComp2;
                    $totalNumComp1 = $totalNumComp1 + $item2->consumo["num_comp"];
                    $totalPorcMbts1 = $totalPorcMbts1 + $item2->consumo["Porc_Mbps"];
                    $totalCantMbts1 = $totalCantMbts1 + $item2->consumo["Mbps_Asignado"];
                    $totalImporMbts1 = $totalImporMbts1 + $item2->consumo["SubTotal"];

                }

                $item1->totalCantMbts = $totalCantMbts1;
                $item1->totalPorcMbts = $totalPorcMbts1;
                $item1->totalImporMbts = $totalImporMbts1;
                $item1->totalNumComp = $totalNumComp1;
            }
            $item->totalNumComp = $totalNumComp;
            $item->totalCantMbts = $totalCantMbts;
            $item->totalPorcMbts = $totalPorcMbts;
            $item->totalImporMbts = $totalImporMbts;

        }
        return $mdat_contrato;
    }

    public function flst_ListarConArea($vint_entidadId)
    {
        $mdat_contrato = Contrato::Select('contrato.*')
            ->join('area_has_contrato','contrato.idCONTRATO','=','area_has_contrato.idCONTRATO')
            ->groupBy($this->ContratoModel->getFillable())
            ->where('idEntidad',$vint_entidadId)
            ->get();

        foreach($mdat_contrato as $item)
        {
            $item->areas;
            foreach($item->areas as $item)
            {
                $item->area;
            }
        }
        return $mdat_contrato;
    }

    public  function  flst_Obtener($vint_id)
    {
        $itemContrato = Contrato::find($vint_id);
        $itemContrato->proveedor = Proveedor::find($itemContrato->idProveedor);
        $itemContrato->areas;
        $itemContrato->idDocumento = Documento::all()->max('idDocumentos') + 1;
        $totalCantMbts = 0;
        $totalPorcMbts = 0;
        $totalImporMbts = 0;

        foreach($itemContrato->areas as $item)
        {
            $item->area;
            $item->consumo;
            $totalPorcMbts = $totalPorcMbts + $item->consumo["Porc_Mbps"];
            $totalCantMbts = $totalCantMbts + $item->consumo["Mbps_Asignado"];
            $totalImporMbts = $totalImporMbts + $item->consumo["SubTotal"];

            $totalCantMbts1 = 0;
            $totalPorcMbts1 = 0;
            $totalImporMbts1 = 0;
            foreach($item->area as $item1)
            {
                $item1->area;
                $item1->consumo;
                $totalPorcMbts1 = $totalPorcMbts1 + $item1->consumo["Porc_Mbps"];
                $totalCantMbts1 = $totalCantMbts1 + $item1->consumo["Mbps_Asignado"];
                $totalImporMbts1 = $totalImporMbts1 + $item1->consumo["SubTotal"];

                $totalCantMbts2 = 0;
                $totalPorcMbts2 = 0;
                $totalImporMbts2 = 0;
                foreach($item1->area as $item2)
                {
                    $item2->area;
                    $item2->consumo;
                    $totalPorcMbts2 = $totalPorcMbts2 + $item2->consumo["Porc_Mbps"];
                    $totalCantMbts2 = $totalCantMbts2 + $item2->consumo["Mbps_Asignado"];
                    $totalImporMbts2 = $totalImporMbts2 + $item2->consumo["SubTotal"];



                }
                $item1->totalCantMbts = $totalCantMbts2;
                $item1->totalPorcMbts = $totalPorcMbts2;
                $item1->totalImporMbts = round($totalImporMbts2, 2);

            }
            $item->totalCantMbts = $totalCantMbts1;
            $item->totalPorcMbts = $totalPorcMbts1;
            $item->totalImporMbts = round($totalImporMbts1, 2);


        }
        $itemContrato->totalCantMbts = $totalCantMbts;
        $itemContrato->totalPorcMbts = $totalPorcMbts;
        $itemContrato->totalImporMbts = round($totalImporMbts, 2);
        return $itemContrato;
    }



    public function flst_Guardar(Contrato $data, $vlst_DetContrato)
    {
        DB::beginTransaction();
        try
        {
            $primarykey = $this->ContratoModel->getKeyName();
            $maxKey = Contrato::all()->max($primarykey);
            $data->$primarykey = $maxKey+1;
            $data->save();

            foreach($vlst_DetContrato as $item)
            {
                $item->$primarykey = $maxKey+1;
                $this->Det_contratoRepo->fbol_Guardar($item);
            }
        }
            // Ha ocurrido un error, devolvemos la BD a su estado previo y hacemos lo que queramos con esa excepción
        catch (\Exception $e)
        {
            DB::rollback();
            // no se... Informemos con un echo por ejemplo
            return flase;
        }

        DB::commit();
        return true;

    }

    public function fbol_eliminar($id){
        $mdata_Contrato = Contrato::find($id);
        $mdata_Contrato->Img_url = 0;
        return $mdata_Contrato->save();
    }

}