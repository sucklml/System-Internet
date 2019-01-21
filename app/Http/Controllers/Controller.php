<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function f_Acceso($vint_id,$vstr_uri,$vstr_nombre,$vstr_icono,array $list_SubAcesos,$vbol_usuario){
        $acceso = new \stdClass();
        $acceso->id=$vint_id;
        //$acceso->resaltado=false;
        $acceso->url=$vstr_uri;
        $acceso->idArea=0;
        $acceso->nombre=$vstr_nombre;
        $acceso->icono=$vstr_icono;
        $acceso->list_SubAcesos=$list_SubAcesos;
        $acceso->EstadoCliente=$vbol_usuario;
        return $acceso;
    }
    public function f_SubAcceso($vstr_nombre, $vstr_url){
        $subacceso = new \stdClass();
        $subacceso->nombre=$vstr_nombre;
        $subacceso->url=$vstr_url;
        $subacceso->idArea=0;
        return $subacceso;
    }
    public function f_accesoresaltado($vlst_accesos, $request){
        $uri = $request->getRequestUri();
        $uri = explode('/',$uri);
        $uri = '/'.$uri[1];

        foreach($vlst_accesos as $i => $j)
        {
            if($j->url == $uri)
            {
                $j->resaltado=true;
            }
            else
            {
                $j->resaltado=false;
                foreach($j->list_SubAcesos as $r)
                {
                    if($r->url==$uri)
                    {
                        $r->resaltado=true;
                        $j->resaltado=true;
                    }
                    else
                    {
                        $r->resaltado=false;
                    }
                }
            }

            if( $j->EstadoCliente == true && $request->v == null){
                unset($vlst_accesos[$i]);
            }else if($j->EstadoCliente == true && $request->v != null)
            {
                $j->idArea=$request->v;
            }

        }
        return $vlst_accesos;
    }
    public function f_castAccesos($user){
        $mlstaccesos = array();
        foreach($user as $itemContr){
            $itemContr->CO = false;
            $itemContr->CT = false;
            $itemContr->PA = false;
            $itemContr->roles;
            $itemContr->entidades;
            foreach($itemContr->roles as $itemRol)
            {
                $itemRol->accesos;

                foreach($itemRol->accesos as $itemAcceso)
                {
                    if($itemAcceso->idACCESO == 4)
                    {
                        $itemContr->CT = true;
                    }
                    elseif($itemAcceso->idACCESO == 5)
                    {
                        $itemContr->PA = true;
                    }
                    elseif
                    ($itemAcceso->idACCESO == 6)
                    {
                        $itemContr->CO = true;
                    }
                    $listsubacceso = array();
                    $itemAcceso->subacceso;
                    foreach($itemAcceso->subacceso as $itemsubacceso)
                    {
                        $subacceso= $this->f_SubAcceso($itemsubacceso->Descripcion,$itemsubacceso->URL);
                        array_push($listsubacceso,$subacceso);
                    }
                    $acceso= $this->f_Acceso($itemAcceso->idACCESO,$itemAcceso->URL,$itemAcceso->Descripcion,$itemAcceso->icono,$listsubacceso,$itemAcceso->Entidad);
                    array_push($mlstaccesos,$acceso);
                }
            }
            foreach($itemContr->entidades as $itemEntidad)
            {
                $GtotalCantMbts = 0;
                $GtotalAreas = 0;
                $itemEntidad->contrato;
                foreach($itemEntidad->contrato as $item)
                {
                    $item->detalle;
                    $item->areas;
                    $GtotalAreas = $GtotalAreas + count($item->areas);
                    foreach($item->areas as $item1)
                    {
                        $item1->area;
                        $item1->consumo;
                        $GtotalCantMbts = $GtotalCantMbts + $item1->consumo["Mbps_Asignado"];
                    }
                }
                $itemEntidad->CantMbts = $GtotalCantMbts;
                $itemEntidad->TotalAreas = $GtotalAreas;
            }
        }
        return $mlstaccesos;
    }
}
