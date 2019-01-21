<?php
/**
 * Created by PhpStorm.
 * User: Jose Arias
 * Date: 12/05/2017
 * Time: 12:31
 */

namespace App\Repositories;
use App\Documento;
use Carbon\Carbon;

class DocumentoRepository
{
    private $DocumentoModel;
    public  function __construct(Documento $DocumentoModel)
    {
        $this->DocumentoModel = $DocumentoModel;
    }

    public function flst_Listar()//->Falta filtrar por usuario
    {
        $mobj_data = Documento::select('documentos.*','contrato.Descripcion as Contrato','usuario.Usuario')
            ->join('contrato','documentos.idCONTRATO','=','contrato.idCONTRATO')
            ->join('usuario','documentos.idUsuario','=','usuario.idUsuario')
            ->orderBy('Fecha','desc')
            ->get();

        foreach($mobj_data as $item)
        {
            $item->Fecha = Carbon::parse($item->Fecha)->format('d/m/Y');
        }

        return $mobj_data;
    }

    public  function flst_Obtener($vint_id)
    {
        return Documento::find($vint_id);
    }

    public function flst_Guardar(Documento $data)
    {
        $primarykey = $this->DocumentoModel->getKeyName();
        $maxKey = Documento::all()->max($primarykey);
        $data->$primarykey = $maxKey+1;
        return  $data->save();
    }

    public function flst_Actualizar(Documento $data)
    {
        $data->save();
    }
    public function fobj_RenderHtml($vdat_Entidad, $vdat_Contrato, $vstr_fechaDesde, $vstr_fechaHasta, $vbol_Pdf, $vstr_Tipo){
        $mobj_data = new \stdClass();
        $mobj_data->entidad = $vdat_Entidad;
        $mobj_data->contrato = $vdat_Contrato;
        $mobj_data->fechaDesde = $vstr_fechaDesde;
        $mobj_data->fechaHasta = $vstr_fechaHasta;
        $mobj_data->pdf = $vbol_Pdf;
        $mobj_data->tipo = $vstr_Tipo;
        return View('modulos.consultarConsumo.solicitado.reporte.Consumo',["data"=>$mobj_data])->render();
    }

    public  function flst_Eliminar($vint_id)
    {
        $mdat_Documento = Documento::find($vint_id);
        $mdat_Documento->Estado = 0;
        $mdat_Documento->save();
    }
}