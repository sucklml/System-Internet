<?php
/**
 * Created by PhpStorm.
 * User: Jose Arias
 * Date: 12/05/2017
 * Time: 12:31
 */

namespace App\Repositories;
use App\Area;
use App\Area_has_Contrato;
use App\Consumo;
use Illuminate\Support\Facades\DB;
use App\Repositories\ConsumoRepository;

class Area_has_ContratoRepository
{
    private $Area_has_ContratoModel;
    private $ConsumoRepo;
    public  function __construct(Area_has_Contrato $Area_has_ContratoModel, ConsumoRepository $ConsumoRepo)
    {
        $this->Area_has_ContratoModel = $Area_has_ContratoModel;
        $this->ConsumoRepo = $ConsumoRepo;
    }

    public function flst_Listar()
    {

    }

    
    public  function fbol_Eliminar($vint_ContratoId,$vlst_AreasId)
    {
        DB::beginTransaction();
        try
        {
            $mlst_Areas_has_Contrato =Area_has_Contrato::where('idCONTRATO','=',$vint_ContratoId)
                ->get();
            foreach($mlst_Areas_has_Contrato as $item)
            {
                $item->forceDelete();
            }

            $mint_acumulado = 0;
            foreach($vlst_AreasId as $i => $itemAreaId)
            {
                $min_cantMbps = round(1/count($vlst_AreasId)*100,2);
                $mint_acumulado = $mint_acumulado + $min_cantMbps;

                if(count($vlst_AreasId) == $i+1)
                {
                    $min_cantMbps = $min_cantMbps + (100 - $mint_acumulado) ;
                }


                $mdat_Areas_has_Contrato = new Area_has_Contrato();
                $mdat_Areas_has_Contrato->idCONTRATO = $vint_ContratoId;
                $mdat_Areas_has_Contrato->idAREA = $itemAreaId;
                $this->fbol_Guardar($mdat_Areas_has_Contrato);
                //desavilitar el consumo de todas las areas
                $this->ConsumoRepo->flst_Desabiltar($itemAreaId);
                $date = new \DateTime();
                $mdat_Consumo = new Consumo();
                $mdat_Consumo->idArea =  $itemAreaId;
                $mdat_Consumo->Porc_Mbps = $min_cantMbps;
                $mdat_Consumo->Fecha = $date;
                $mdat_Consumo->Estado = 1;
                $mbol_data = $this->ConsumoRepo->flst_Guardar($mdat_Consumo);
                $data_area = Area::find($itemAreaId);
                $mint_acumulado1 = 0;
                foreach($data_area->area as $i1 =>$itemArea)
                {
                    $min_cantMbps1 = round(1/count($data_area->area)*100,2);
                    $mint_acumulado1 = $mint_acumulado1 + $min_cantMbps1;
                    if(count($data_area->area) == $i1+1)
                    {
                        $min_cantMbps1 = $min_cantMbps1 + (100 - $mint_acumulado1) ;
                    }
                    $this->ConsumoRepo->flst_Desabiltar($itemArea->idAREA);
                    $date = new \DateTime();
                    $mdat_Consumo = new Consumo();
                    $mdat_Consumo->idArea =  $itemArea->idAREA;
                    $mdat_Consumo->Porc_Mbps = $min_cantMbps1;
                    $mdat_Consumo->Fecha = $date;
                    $mdat_Consumo->Estado = 1;
                    $mbol_data = $this->ConsumoRepo->flst_Guardar($mdat_Consumo);
                    $mint_acumulado2 = 0;
                    foreach($itemArea->area as $i2 => $itemArea1)
                    {
                        $min_cantMbps2 = round(1/count($itemArea->area)*100,2);
                        $mint_acumulado2 = $mint_acumulado2 + $min_cantMbps2;
                        if(count($itemArea->area) == $i2+1)
                        {
                            $min_cantMbps2 = $min_cantMbps2 + (100 - $mint_acumulado2) ;
                        }
                        $this->ConsumoRepo->flst_Desabiltar($itemArea1->idAREA);
                        $date = new \DateTime();
                        $mdat_Consumo = new Consumo();
                        $mdat_Consumo->idArea =  $itemArea1->idAREA;
                        $mdat_Consumo->Porc_Mbps = $min_cantMbps2;
                        $mdat_Consumo->Fecha = $date;
                        $mdat_Consumo->Estado = 1;
                        $mbol_data = $this->ConsumoRepo->flst_Guardar($mdat_Consumo);
                        $mint_acumulado3 = 0;
                        foreach($itemArea1->area as $i3 => $itemArea2)
                        {
                            $min_cantMbps3 = round(1/count($itemArea1->area)*100,2);
                            $mint_acumulado3 = $mint_acumulado3 + $min_cantMbps3;
                            if(count($itemArea->area) == $i3+1)
                            {
                                $min_cantMbps3 = $min_cantMbps3 + (100 - $mint_acumulado3) ;
                            }
                            $this->ConsumoRepo->flst_Desabiltar($itemArea2->idAREA);
                            $date = new \DateTime();
                            $mdat_Consumo = new Consumo();
                            $mdat_Consumo->idArea =  $itemArea2->idAREA;
                            $mdat_Consumo->Porc_Mbps = $min_cantMbps3;
                            $mdat_Consumo->Fecha = $date;
                            $mdat_Consumo->Estado = 1;
                            $mbol_data = $this->ConsumoRepo->flst_Guardar($mdat_Consumo);
                            $mint_acumulado4 = 0;
                            foreach($itemArea2->area as $i4 => $itemArea3)
                            {
                                $min_cantMbps4 = round(1/count($itemArea2->area)*100,2);
                                $mint_acumulado4 = $mint_acumulado4 + $min_cantMbps4;
                                if(count($itemArea->area) == $i4+1)
                                {
                                    $min_cantMbps4 = $min_cantMbps4 + (100 - $mint_acumulado4) ;
                                }
                                $this->ConsumoRepo->flst_Desabiltar($itemArea3->idAREA);
                                $date = new \DateTime();
                                $mdat_Consumo = new Consumo();
                                $mdat_Consumo->idArea =  $itemArea3->idAREA;
                                $mdat_Consumo->Porc_Mbps = $min_cantMbps4;
                                $mdat_Consumo->Fecha = $date;
                                $mdat_Consumo->Estado = 1;
                                $mbol_data = $this->ConsumoRepo->flst_Guardar($mdat_Consumo);
                            }
                        }
                    }
                }

            }

        }
            // Ha ocurrido un error, devolvemos la BD a su estado previo y hacemos lo que queramos con esa excepción
        catch (\Exception $e)
        {
            DB::rollback();
            // no se... Informemos con un echo por ejemplo
            return -1;
        }
        // Hacemos los cambios permanentes ya que no han habido errores
        DB::commit();
        return 1;
    }


    public function fbol_Guardar(Area_has_Contrato $data)
    {
        $primarykey = $this->Area_has_ContratoModel->getKeyName();
        $maxKey = Area_has_Contrato::all()->max($primarykey);
        $data->$primarykey = $maxKey+1;
        return  $data->save();
    }

}