<?php
/**
 * Created by PhpStorm.
 * User: Jose Arias
 * Date: 12/05/2017
 * Time: 12:31
 */

namespace App\Repositories;
use App\Area;
use App\Dispositivo;

class AreaRepository
{
    private $AreaModel;
    public  function __construct(Area $AreaModel)
    {
        $this->AreaModel = $AreaModel;
    }

    public function flst_Listar($vint_EntidadId)
    {
        return Area::where('IdEntidad',$vint_EntidadId)
            ->where('Nivel','=',0)
            ->where('Estado','=',1)
            ->orderBy('idAREA','desc')
            ->get();
    }

    public function flst_ListarAreaSinAsing($vint_EntidadId)
    {
        $mdat_area =  Area::whereNotIn('idAREA', Area::Select('area.idAREA')
            ->join('area_has_contrato','area.idAREA','=','area_has_contrato.idAREA')
            ->get() )
            ->where('IdEntidad','=',$vint_EntidadId)
            ->where('Nivel','=',0)
            ->where('Estado','=',1)
            ->orderBy('idAREA','desc')
            ->get();

        foreach($mdat_area as $item)
        {
            $item->area;
            $item->dispositivo = Dispositivo::find($item->idDispositivo);
            foreach($item->area as $item)
            {
                $item->area;
                $item->dispositivo = Dispositivo::find($item->idDispositivo);
                foreach($item->area as $item)
                {
                    $item->area;
                    $item->dispositivo = Dispositivo::find($item->idDispositivo);

                }
            }
        }
        return $mdat_area;
    }

    public  function flst_Obtener($vint_id)
    {
        return Area::find($vint_id);
    }
    public function flst_Actualizar(Area $data)
    {
        $data->save();
        return $data;
    }

    public function flst_Guardar(Area $data)
    {
        $primarykey = $this->AreaModel->getKeyName();
        if($data->$primarykey == 0){
            $maxKey = Area::all()->max($primarykey);
            $data->$primarykey = $maxKey+1;
            $data->save();
            $data->idAREA = $maxKey+1;
        }else{
            $data1 = Area::find($data->$primarykey);
            $data1->CTAS_CTR =  $data->CTAS_CTR;
            $data1->Dependencia =  $data->Dependencia;
            $data1->Obs =  $data->Obs;
            $data1->CTW =  $data->CTW;
            $data1->idEntidad =  $data->idEntidad;
            $data1->Interface =  $data->Interface;
            $data1->Nivel =   $data->Nivel;
            $data1->Nom_Area =  $data->Nom_Area;
            $data1->Cod_Padre = $data->Cod_Padre;
            $data1->idDispositivo =  $data->idDispositivo;
            $data1->save();
        }
        return $data;
    }

    public function fbol_Eliminar($idAre){
        $area = Area::find($idAre);
        $area->Estado = 0;
        return $area->save();
    }

    public function flst_ListarSubAreasSinAsing($Areaid,$varr_Nivel)
    {

        $mdat_subarea=[];
        $mdat_subarea1=[];
        $mdat_subarea2=[];
        $mdat_subarea3=[];


        $mdat_subarea1 =  Area::where('Cod_Padre',$Areaid)
            ->orderBy('idAREA','desc')
            ->get();

        foreach($mdat_subarea1 as $item1)
        {
            $item1->area;
            foreach($item1->area as $item2)
            {
                array_push($mdat_subarea2,$item2);
                $item2->area;

                foreach($item2->area as $item3)
                {
                    array_push($mdat_subarea3,$item3);

                }
            }
        }


        if(in_array(1,$varr_Nivel))
        {
            $mdat_subarea = array_merge(collect($mdat_subarea)->toArray(),collect($mdat_subarea1)->toArray());
        }
        if (in_array(2,$varr_Nivel))
        {
            $mdat_subarea = array_merge(collect($mdat_subarea)->toArray(),collect($mdat_subarea2)->toArray());
        }
        if (in_array(3,$varr_Nivel))
        {
            $mdat_subarea = array_merge(collect($mdat_subarea)->toArray(),collect($mdat_subarea3)->toArray());
        }

        return $mdat_subarea;
    }

    public function flst_ObtenerAreasMikrotik($mikrotikId){
        $areas = Area::where('idDispositivo',$mikrotikId)
            ->where('Estado',1)
            ->where('Interface','!=','')
            ->get();
        return $areas;

    }
}