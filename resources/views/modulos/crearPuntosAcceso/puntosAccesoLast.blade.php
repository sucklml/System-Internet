@extends('layouts.app')

@section('head')
@endsection

@section('title')
    <a class="navbar-brand"  style="margin-bottom: 20px;">Puntos de Acceso</a>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <ul class="actions" style="float: right;"><li><a class="bgm-indigo" style="border-radius: 50%;"></a></li><li><h5 class="card-title"><small></small>Mbps</h5></li><li><a class="bgm-lightblue" style="margin-left: 10px; border-radius: 50%;"></a></li><li><h5 class="card-title"><small></small>Areas</h5></li></ul>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card-jse" id="cardSinAsignar">
                <div class="card-header card-purple bgm-teal">
                    <div class="row">
                        <div class="col-xs-7"><h2>Áreas sin Asignar a Contrato</h2></div>
                        <div class="col-xs-5">
                            <div class="btn btn-round btn-fab bgm-white" style="position: absolute;top: -17px;min-width: 0;width: 55px;height: 55px;right: 130px;">
                                <button title="Cantidad Areas" id="Count_AreasSinAsing" class="btn btn-round btn-fab bgm-lightblue" style="height: 45px;width: 45px;min-width: 0;top: 5px;">{{(count($data->AreasSinAsig))}}</button>
                            </div>
                            <button title="Agreagar un Area" class="btn btn-round btn-fab  bgm-teal btn-CrearArea btn-Principal" style="position: absolute; height: 45px;width: 45px;min-width: 0;top: 5px;top: -15px;right: 70px;"><i class="md md-add md-lg"></i></button>
                            <button title="Desplegar" class="btn btn-round btn-fab  bgm-teal btn-colapcin" style="position: absolute; height: 45px;width: 45px;min-width: 0;top: 5px;top: -15px;right: 15px;"><i class="ico-colapcin md md-keyboard-arrow-up md-lg"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body card-padding panel-group colapcin card-colapcin">
                    <div class="table-responsive">
                        <table class="table table-hover table-jse" data-nivel="1">
                            <thead class="bgm-indigo">
                            <th width="2%">#</th>
                            <th width="25%">Area</th>
                            <th width="25%">Microtik</th>
                            <th width="20%">Interface</th>
                            <th width="15%">CTR</th>
                            <th width="5%"></th>
                            <th width="10%"></td>
                            </thead>
                            <tbody id="list_Area">
                            @foreach($data->AreasSinAsig  as $i => $itemArea)
                                <tr data-id="{{$itemArea->idAREA}}">
                                    @if(count($itemArea->area)> 0)
                                        <td class="card-link btn-colapcin no-seleccionable"><i class="ico-colapcin md md-keyboard-arrow-up md-lg" style="display:inline-block;font-size: 2em;vertical-align: -50%;"><div class="tblcount" style="display: inline-block;">{{$i+1}}</div></i></td>
                                    @else
                                        <td><i class="md md-lg" style="font-size: 2em;vertical-align: -50%;"><div class="tblcount">{{$i+1}}</div></i></td>
                                    @endif
                                    <td>{{$itemArea->Nom_Area}}</td>
                                    <td>{{$itemArea->dispositivo["Nombre"]}}</td>
                                    <td>{{$itemArea->Interface}}</td>
                                    <td>{{$itemArea->CTAS_CTR}}</td>
                                    <td>
                                        <ul class="actions">
                                            <li>
                                                <a class="btn-CrearArea"><i class="md md-add md-lg" style="font-size: 2em;vertical-align: -50%;"></i></a>
                                            </li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul class="actions">
                                            <li>
                                                <a class="btn-edit"><i class="md md-edit md-lg"></i></a>
                                            </li>
                                            <li>
                                                <a class="btn-delete"><i class="md md-delete md-lg"></i></a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                @if(count($itemArea->area)> 0)
                                    <tr class="colapcin table-colapcin panel" data-codpadre="{{$itemArea->idAREA}}">
                                        <td></td>
                                        <td colspan="6">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-jse" data-nivel="2">
                                                    <thead class="bgm-cyan">
                                                    <th width="2%">#</th>
                                                    <th width="25%">{{$itemArea->Nom_Area}}</th>
                                                    <th width="25%">Microtik</th>
                                                    <th width="20%">Interface</th>
                                                    <th width="15%">CTR</th>
                                                    <th width="5%"></th>
                                                    <th width="10%"></td>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($itemArea->area as $i => $itemArea)
                                                        <tr data-id="{{$itemArea->idAREA}}">
                                                            @if(count($itemArea->area)> 0)
                                                                <td class="card-link btn-colapcin no-seleccionable"><i class="ico-colapcin md md-keyboard-arrow-up md-lg" style="display:inline-block;font-size: 2em;vertical-align: -50%;"><div class="tblcount" style="display: inline-block;">{{$i+1}}</div></i></td>
                                                            @else
                                                                <td><i class="md md-lg" style="display:inline-block;font-size: 2em;vertical-align: -50%;"><div class="tblcount" style="display:inline-block;">{{$i+1}}</div></i></td>
                                                            @endif
                                                            <td>{{$itemArea->Nom_Area}}</td>
                                                            <td>{{$itemArea->dispositivo["Nombre"]}}</td>
                                                            <td>{{$itemArea->Interface}}</td>
                                                            <td>{{$itemArea->CTAS_CTR}}</td>
                                                            <td>
                                                                <ul class="actions">
                                                                    <li>
                                                                        <a class="btn-CrearArea"><i class="md md-add md-lg" style="font-size: 2em;vertical-align: -50%;"></i></a>
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                            <td>
                                                                <ul class="actions">
                                                                    <li>
                                                                        <a class="btn-edit"><i class="md md-edit md-lg"></i></a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="btn-delete"><i class="md md-delete md-lg"></i></a>
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                        @if(count($itemArea->area)> 0)
                                                            <tr class="colapcin table-colapcin panel" data-codpadre="{{$itemArea->idAREA}}">
                                                                <td></td>
                                                                <td colspan="6">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-hover table-jse" data-nivel="3">
                                                                            <thead class="bgm-orange">
                                                                            <th width="2%">#</th>
                                                                            <th width="25%">{{$itemArea->Nom_Area}}</th>
                                                                            <th width="25%">Microtik</th>
                                                                            <th width="20%">Interface</th>
                                                                            <th width="15%">CTR</th>
                                                                            <th width="5%"></th>
                                                                            <th width="10%"></td>
                                                                            </thead>
                                                                            <tbody>
                                                                            @foreach($itemArea->area as $i => $itemArea)
                                                                                <tr data-id="{{$itemArea->idAREA}}">
                                                                                    <td><i class="md md-lg" style="font-size: 2em;vertical-align: -50%;"><div class="tblcount">{{$i+1}}</div></i></td>
                                                                                    <td>{{$itemArea->Nom_Area}}</td>
                                                                                    <td>{{$itemArea->dispositivo["Nombre"]}}</td>
                                                                                    <td>{{$itemArea->Interface}}</td>
                                                                                    <td>{{$itemArea->CTAS_CTR}}</td>
                                                                                    <td>
                                                                                    </td>
                                                                                    <td>
                                                                                        <ul class="actions">
                                                                                            <li>
                                                                                                <a class="btn-edit"><i class="md md-edit md-lg"></i></a>
                                                                                            </li>
                                                                                            <li>
                                                                                                <a class="btn-delete"><i class="md md-delete md-lg"></i></a>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <h5 class="card-title">Asignar Ancho de Banda</h5>
            <h5 class="card-title"><small>Lista de </small>Contratos</h5>
        </div>
        <div id="lst_Contratos">
            @foreach($data->Contratos as $itemContrato)
                <div class="col-sm-12">
                    <div class="card-jse card-contrato">
                        <div class="card-header card-purple bgm-bluegray">
                            <div class="row">
                                <form class="col-xs-7"  name="formContrato" class="content" method="POST" role="form" action="{{url('/pagContrato/asignarAreaContrato')}}">
                                    <h2 style="display: inline-block">{{$itemContrato->Descripcion}}</h2>
                                    <button title="Agragar Areas" type="submit" class="btn btn-round btn-fab bgm-teal" style="position: absolute; height: 52px;width: 52px;min-width: 0;top: 5px;top: -15px;right: 140px;"><i class="md md-domain md-lg"></i></button>
                                    <button title="Ver Reporte Detallado" data-idcontrato="{{$itemContrato->idCONTRATO}}" type="button" class="btn btn-round btn-fab bgm-teal btn-reporte" style="position: absolute; height: 52px;width: 52px;min-width: 0;top: 5px;top: -15px;right: 70px;"><i class="md md-content-paste md-lg"></i></button>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_contratoid" value="{{$itemContrato->idCONTRATO}}">
                                </form>
                                <div class="col-xs-5">
                                    <div class="btn btn-round btn-fab bgm-white" style="position: absolute;top: -17px;min-width: 0;width: 55px;height: 55px;right: 130px;">
                                        <button title="Cantidad de Areas" class="btn btn-round btn-fab bgm-lightblue" style="height: 45px;width: 45px;min-width: 0;top: 5px;">{{count($itemContrato->areas)}}</button>
                                    </div>
                                    <div class="btn btn-round btn-fab bgm-white" style="position: absolute;top: -17px;min-width: 0;width: 55px;height: 55px;right: 200px;">
                                        <button title="Cantidad de Mbps" class="btn btn-round btn-fab bgm-indigo" style="height: 45px;width: 45px;min-width: 0;top: 5px;">{{$itemContrato->Velocidad_Mb}}</button>
                                    </div>
                                    <button title="Validar Porcentaje Acumulado" class="btn btn-round btn-fab bgm-bluegray" style="position: absolute; height: 45px;width: 45px;min-width: 0;top: 5px;top: -15px;right: 70px;"><i class="md md-done-all md-lg btn-validar"></i></button>
                                    <button title="Desplegar" class="btn btn-round btn-fab bgm-bluegray btn-colapcin" style="position: absolute; height: 45px;width: 45px;min-width: 0;top: 5px;top: -15px;right: 15px;"><i class="ico-colapcin md md-keyboard-arrow-up md-lg"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body card-padding panel-group colapcin card-colapcin">
                            <div class="table-responsive">
                                <table data-id="{{$itemContrato->idCONTRATO}}" data-importe="{{$itemContrato->Importe}}" data-mbts="{{$itemContrato->Velocidad_Mb}}" data-nivel = "1" class="table table-hover table-jse">
                                    <thead class="bgm-indigo">
                                    <th width="5%">#</th>
                                    <th width="15%">Area</th>
                                    <th width="10%">Interface</th>
                                    <th width="10%">Consumo</th>
                                    <th width="20%">Porc. Acumulado</th>
                                    <th width="18%" class="text-center">Mbps Asignados</th>
                                    <th width="20%">Sub Total</th>
                                    <th width="2%"></th>
                                    </thead>
                                    <tbody>
                                    @foreach($itemContrato->areas  as $i => $itemArea1)
                                        <tr data-id="{{$itemArea1->idAREA}}" data-nivel="1">
                                            @if(count($itemArea1->area)> 0)
                                                <td class="card-link btn-colapcin no-seleccionable"><i class="ico-colapcin md md-keyboard-arrow-up md-lg" style="font-size: 2em;vertical-align: -50%;">{{$i+1}}</i></td>
                                            @else
                                                <td><i class="md md-lg" style="font-size: 2em;vertical-align: -50%;">{{$i+1}}</i></td>
                                            @endif
                                            <td>{{$itemArea1->Nom_Area}}</td>
                                            <td>{{$itemArea1->Interface}}</td>
                                            <td style="text-align: center;"><div class="td-total" style="display: inline-block;">{{$itemArea1->ConsumoReal}}&nbsp;Mpbs</div></td>
                                            <td class="porc_mbts" style="padding: 0;">
                                                <div class="form-group label-floating" style="padding: 0;margin: 0;display: inline-block;width: 80%;">
                                                    <input value="{{$itemArea1->consumo["Porc_Mbps"]}}" type="number" min="0" max="100" step="0.01" class="form-control" style="text-align: center; margin-bottom: 5px;">
                                                </div>
                                                <div style="display: inline-block;width: 10%;">%</div>
                                            </td>
                                            <td class="text-center"><div class="cant_mbts" style="display: inline-block;">{{$itemArea1->consumo["Mbps_Asignado"]}}</div>&nbsp;Mpbs</td>
                                            <td class="">S/.<div class="subtotal" style="display: inline-block;">{{$itemArea1->consumo["SubTotal"]}}</div></td>
                                            <td class="card-link"><!--<i class="md md-add md-lg btn-ModalSubArea" style="font-size: 2em;vertical-align: -50%;"></i>--></td>
                                        </tr>
                                        @if(count($itemArea1->area)> 0)
                                            <tr class="colapcin table-colapcin panel" data-codpadre="{{$itemArea1->idAREA}}">
                                                <td></td>
                                                <td colspan="7">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover table-jse" data-importe="{{$itemArea1->consumo["SubTotal"]}}" data-mbts="{{$itemArea1->consumo["Mbps_Asignado"]}}" data-nivel = "2">
                                                            <thead class="bgm-cyan">
                                                            <th width="5%">#</th>
                                                            <th width="25%">{{$itemArea1->Nom_Area}}</th>
                                                            <th width="20%">Porc. Acumulado</th>
                                                            <th width="23%" class="text-center">Mbps Asignados</th>
                                                            <th width="25%">Sub Total</th>
                                                            <th width="2%"></th>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($itemArea1->area as $i => $itemArea2)
                                                                <tr data-id="{{$itemArea2->idAREA}}" data-nivel="2">
                                                                    @if(count($itemArea2->area)> 0)
                                                                        <td class="card-link btn-colapcin no-seleccionable"><i class="ico-colapcin md md-keyboard-arrow-up md-lg" style="font-size: 2em;vertical-align: -50%;">{{$i+1}}</i></td>
                                                                    @else
                                                                        <td><i class="md md-lg" style="font-size: 2em;vertical-align: -50%;">{{$i+1}}</i></td>
                                                                    @endif
                                                                    <td>{{$itemArea2->Nom_Area}}</td>
                                                                    <td class="porc_mbts" style="padding: 0;">
                                                                        <div class="form-group label-floating" style="padding: 0;margin: 0;display: inline-block;width: 80%;">
                                                                            <input value="{{$itemArea2->consumo["Porc_Mbps"]}}" type="number" min="0" max="100" step="0.01" class="form-control" style="text-align: center; margin-bottom: 5px;">
                                                                        </div>
                                                                        <div style="display: inline-block;width: 10%;">%</div>
                                                                    </td>
                                                                    <td class="text-center"><div class="cant_mbts" style="display: inline-block;">{{$itemArea2->consumo["Mbps_Asignado"]}}</div>&nbsp;Mpbs</td>
                                                                    <td class="">S/.<div class="subtotal" style="display: inline-block;">{{$itemArea2->consumo["SubTotal"]}}</div></td>
                                                                    <td class="card-link"><!--<i class="md md-add md-lg btn-ModalSubArea" style="font-size: 2em;vertical-align: -50%;"></i>--></td>
                                                                </tr>
                                                                @if(count($itemArea2->area)> 0)
                                                                    <tr class="colapcin table-colapcin panel" data-codpadre="{{$itemArea2->idAREA}}">
                                                                        <td></td>
                                                                        <td colspan="6">
                                                                            <div class="table-responsive">
                                                                                <table class="table table-hover table-jse"  data-importe="{{$itemArea2->consumo["SubTotal"]}}" data-mbts="{{$itemArea2->consumo["Mbps_Asignado"]}}" data-nivel = "3">
                                                                                    <thead class="bgm-orange">
                                                                                    <th width="5%">#</th>
                                                                                    <th width="25%">{{$itemArea2->Nom_Area}}</th>
                                                                                    <th width="20%">Porc. Acumulado</th>
                                                                                    <th width="23%" class="text-center">Mbps Asignados</th>
                                                                                    <th width="25%">Sub Total</th>
                                                                                    <th width="2%"></th>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                    @foreach($itemArea2->area as $i => $itemArea3)
                                                                                        <tr data-id="{{$itemArea3->idAREA}}" data-nivel="3">
                                                                                            <td><i class="md md-lg" style="font-size: 2em;vertical-align: -50%;">{{$i+1}}</i></td>
                                                                                            <td>{{$itemArea3->Nom_Area}}</td>
                                                                                            <td class="porc_mbts" style="padding: 0;">
                                                                                                <div class="form-group label-floating" style="padding: 0;margin: 0;display: inline-block;width: 80%;">
                                                                                                    <input value="{{$itemArea3->consumo["Porc_Mbps"]}}" type="number" min="0" max="100" step="0.01" class="form-control" style="text-align: center; margin-bottom: 5px;">
                                                                                                </div>
                                                                                                <div style="display: inline-block;width: 10%;">%</div>
                                                                                            </td>
                                                                                            <td class="text-center"><div class="cant_mbts" style="display: inline-block;">{{$itemArea3->consumo["Mbps_Asignado"]}}</div>&nbsp;Mpbs</td>
                                                                                            <td class="">S/.<div class="subtotal" style="display: inline-block;">{{$itemArea3->consumo["SubTotal"]}}</div></td>
                                                                                            <td class="card-link"><!--<i class="md md-add md-lg btn-ModalSubArea" style="font-size: 2em;vertical-align: -50%;"></i>--></td>

                                                                                        </tr>
                                                                                    @endforeach
                                                                                    </tbody>
                                                                                    <tfoot class="" >
                                                                                    <tr >
                                                                                        <td></td>
                                                                                        <td class="td-total text-center ">Total</td>
                                                                                        <td class="text-center"><div class="totalPorc_Mbps" style="display: inline-block;">{{$itemArea2->totalPorcMbps}}</div>%</td>
                                                                                        <td class="text-center"><div class="totalCant_Mbps" style="display: inline-block;">{{$itemArea2->totalCantMbps}}</div>&nbsp;Mbps</td>
                                                                                        <td class="text-left">S/.<div class="totalimporte_Mbps" style="display: inline-block;">{{$itemArea2->totalImporMbts}}</div></td>
                                                                                        <td colspan="2"></td>
                                                                                    </tr>
                                                                                    </tfoot>
                                                                                </table>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                            </tbody>
                                                            <tfoot class="" >
                                                            <tr >
                                                                <td></td>
                                                                <td class="td-total text-center">Total</td>
                                                                <td class="text-center"><div class="totalPorc_Mbps" style="display: inline-block;">{{$itemArea1->totalPorcMbts}}</div>%</td>
                                                                <td class="text-center"><div class="totalCant_Mbps" style="display: inline-block;">{{$itemArea1->totalCantMbts}}</div>&nbsp;Mbps</td>
                                                                <td class="text-left">S/.<div class="totalimporte_Mbps" style="display: inline-block;">{{$itemArea1->totalImporMbts}}</div></td>
                                                                <td colspan="2"></td>
                                                            </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr >
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="td-total text-center">Total</td>
                                        <td class="text-center"><div class="totalPorc_Mbps" style="display: inline-block;">{{$itemContrato->totalPorcMbts}}</div>%</td>
                                        <td class="text-center"><div class="totalCant_Mbps" style="display: inline-block;">{{$itemContrato->totalCantMbts}}</div>&nbsp;Mbps</td>
                                        <td class="text-left">S/.<div class="totalimporte_Mbps" style="display: inline-block;">{{round($itemContrato->totalImporMbts,2)}}</div></td>
                                        <td colspan="2"></td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="modal fade" id="mdlCrearAreas" data-keyboard="false" data-backdrop="static" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="md md-clear"></i>
                    </button>
                    <h4 class="modal-title">Agregar Areas</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Nombre</label>
                                <input id="tex_nombre" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label" style="position: absolute; top:-29px;">Microtik</label>
                                <select  id="sel_DispositivoArea" class="selectpicker" data-live-search="true" data-style="btn btn-primary" title="Seleccione" data-size="7" style="top:-7px;">
                                    @foreach($data->Dispositivo as $itemDispositivo)
                                        <option value="{{$itemDispositivo->idDispositivo}}">{{$itemDispositivo->Nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Interface</label>
                                <input id="text_interface" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">CTR</label>
                                <input id="text_CTR" type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btn-addArea" type="button" class="btn btn-primary btn-simple" data-dismiss="modal">Guardar</button>
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Atras</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="mdlCrearSubArea" data-keyboard="false" data-backdrop="static" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="md md-clear"></i>
                    </button>
                    <h4 class="modal-title">Agregar Subareas</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Nombre</label>
                                <input id="tex_nombreSubArea" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">CTR</label>
                                <input id="text_CTRSubArea" type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btn-addSubArea" type="button" class="btn btn-primary btn-simple" data-dismiss="modal">Guardar</button>
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Atras</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="mdlReporte" data-keyboard="false" data-backdrop="static" style="margin-top: -95px!important;" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="md md-clear"></i>
                    </button>
                    <div class="card-jse" style="width: 152px;position: fixed;top: 9px;right: 60px;opacity: 0.9;">
                        <div class="card-body card-padding panel-group">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Fecha de Desde</label>
                                        <input  id ="text_fechaDesde" type="text" class="form-control datepicker">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Fecha de Hasta</label>
                                        <input  id ="text_fechaHasta" type="text" class="form-control datepicker">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <i id="actualizar" style="cursor: pointer; display: block;left: 54px;position: absolute;margin-top: -2px;font-size: 20px;background-color: #c61954;padding: 9px;border-radius: 50%;max-width: 38px;box-shadow: 0 10px 30px -12px rgba(0, 0, 0, 0.42), 0 4px 25px 0px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(0, 0, 0, 0.2)" data-notify="icon" class="btn material-icons md md-polymer bgm-teal">&nbsp;</i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive" id="ifr_reporte">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btn-Generar" type="button" class="btn btn-primary btn-simple" data-dismiss="modal" style="color:#FFFFff;">Generar</button>
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Atras</button>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @section('script')
            <!--<script src="../../funciones/puntosAcceso.js"></script>-->
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var vobj_context = [];
            $("#btn-addArea").on('click',function(){
                var mint_idAreaEdit = $('#mdlCrearAreas').data('idEdit');
                var mstr_nombreArea = $('#tex_nombre').val();
                var mstr_interface = $('#text_interface').val();
                var mstr_ctr = $('#text_CTR').val();
                var mint_DispositivoArea = $('#sel_DispositivoArea').val();
                var mint_CodPadre =  $('#mdlCrearAreas').data('idCodPadre');
                var data = {nombre: mstr_nombreArea, interface: mstr_interface, ctr: mstr_ctr, idDispositivo: mint_DispositivoArea, idAreaEdit: mint_idAreaEdit, idCodPadre: mint_CodPadre};
                console.log(data);
                $.ajax({
                    type: "POST",
                    url: '{{url("/pagPuntosAccesos/CrearArea")}}',
                    data: {nombre: mstr_nombreArea, interface: mstr_interface, ctr: mstr_ctr, idDispositivo: mint_DispositivoArea, idAreaEdit: mint_idAreaEdit, idCodPadre: mint_CodPadre},
                    dataType: 'json',
                    error: function (data, status) {
                        alert('Error');
                    },
                    success: function (data) {
                        //console.log('data', data);
                        //location.reload();
                        if(data.Cod_Padre == null)
                        {
                            agregarArea(data,mint_idAreaEdit);
                        }else{
                            agregarSubArea(data,mint_idAreaEdit);
                        }
                    }
                });
            });
            function agregarArea(data,mint_idAreaEdit){
                var html = '<tr data-id="'+data.idAREA+'">'+
                        '<td><i class="md md-lg" style="font-size: 2em;vertical-align: -50%;"><div class="tblcount">#</div></i></td>'+
                        '<td>'+data.Nom_Area+'</td>'+
                        '<td>'+data.dispositivo['Nombre']+'</td>'+
                        '<td>'+data.Interface+'</td>'+
                        '<td>'+data.CTAS_CTR+'</td>'+
                        '<td><ul class="actions"><li><a class="btn-CrearArea"><i class="md md-add md-lg" style="font-size: 2em;vertical-align: -50%;"></i></a> </li> </ul> </td>'+
                        '<td> <ul class="actions"> <li> <a class="btn-edit"><i class="md md-edit md-lg"></i></a> </li> <li> <a class="btn-delete"><i class="md md-delete md-lg"></i></a> </li> </ul> </td>'+
                        '</tr>';
                console.log(mint_idAreaEdit +'!='+data.idAREA);
                if(mint_idAreaEdit != data.idAREA)
                {
                    $('#cardSinAsignar').find('table tbody').eq(0).prepend(html);
                }
                else
                {
                    var mobj_tr = $('#cardSinAsignar').find('table tbody').eq(0).find('tr[data-id="'+data.idAREA+'"]');
                    var mobj_td = mobj_tr.find('td').eq(0);
                    var tempTbody = document.createElement('table');
                    tempTbody.innerHTML = html;
                    $(tempTbody).find('td').eq(0).remove();
                    $(tempTbody).find('tr').prepend(mobj_td);
                    //$(tempTr).data('id',mint_idAreaEdit);
                    mobj_tr.after($(tempTbody).find('tbody').html());
                    mobj_tr.remove();
                }
                var count = 0;
                $('#cardSinAsignar').find('table tbody').eq(0).children('tr').each(function(i,r){
                    if($(this).data('id')!= undefined && $(this).data('id')!= null)
                    {
                        count++;
                        $(this).find('.tblcount').eq(0).text(count);
                        $('#Count_AreasSinAsing').html(count);
                    }
                });
            }
            function agregarSubArea(data,mint_idAreaEdit){
                var mobj_tr =  $('#cardSinAsignar').find('tr[data-codpadre="'+data.Cod_Padre+'"]');
                if(mobj_tr.data('codpadre') != undefined && mobj_tr.data('codpadre') != null){
                    //mobj_tr.siblings('tr[data-id="'+data.Cod_Padre+'"]');
                    var  mint_nivel = mobj_tr.find('table').eq(0).data('nivel');
                    var html =   '<tr data-id="'+data.idAREA+'">'+
                            '<td><i class="md md-lg" style="display:inline-block;font-size: 2em;vertical-align: -50%;"><div class="tblcount" style="display: inline-block;">#</div></i></td>'+
                            '<td>'+ data.Nom_Area+'</td>'+
                            '<td>'+data.dispositivo['Nombre']+'</td>'+
                            '<td>'+data.Interface+'</td>'+
                            '<td>'+data.CTAS_CTR+'</td>'+
                            '<td>';
                    if(mint_nivel != 3)
                    {
                        html +='<ul class="actions"><li><a class="btn-CrearArea"><i class="md md-add md-lg" style="font-size: 2em;vertical-align: -50%;"></i></a> </li> </ul> '
                    }
                    html +=  '</td>'+
                            '<td>'+
                            '<ul class="actions"> <li> <a class="btn-edit"><i class="md md-edit md-lg"></i></a> </li> <li> <a class="btn-delete"><i class="md md-delete md-lg"></i></a> </li> </ul>'+
                            '</td>'+
                            '</tr>';
                    console.log(mint_idAreaEdit +'!='+data.idAREA);
                    if(mint_idAreaEdit != data.idAREA)
                    {
                        mobj_tr.find('table tbody').eq(0).prepend(html);
                    }else{
                        var mobj_tr = $('#cardSinAsignar').find('table tbody').eq(0).find('tr[data-id="'+data.idAREA+'"]');
                        var mobj_td = mobj_tr.find('td').eq(0);
                        var tempTbody = document.createElement('table');
                        tempTbody.innerHTML = html;
                        $(tempTbody).find('td').eq(0).remove();
                        $(tempTbody).find('tr').prepend(mobj_td);
                        //$(tempTr).data('id',mint_idAreaEdit);
                        mobj_tr.after($(tempTbody).find('tbody').html());
                        mobj_tr.remove();
                        //mobj_tr.find('table tbody').eq(0).prepend(html);
                    }
                    mobj_tr.find('table tbody').eq(0).children('tr').each(function(i,r){
                        var count = i+1;
                        $(this).find('.tblcount').text(count);
                        if($(this).parent('tbody').attr('id')=="list_Area") {
                            $('#Count_AreasSinAsing').html(i);
                        }
                    });
                }
                else{
                    mobj_tr = $('#cardSinAsignar').find('tr[data-id="'+data.Cod_Padre+'"]');
                    var correlativo = mobj_tr.find('.tblcount').text();
                    var mint_idArea = mobj_tr.data('id');
                    var mstr_NomArea = mobj_tr.find('td').eq(1).text();
                    var mint_Nivel = mobj_tr.parents('table').eq(0).data('nivel');
                    var mint_Nivel =  mint_Nivel +1;
                    mobj_tr.find('td').eq(0).remove();
                    mobj_tr.prepend('<td class="card-link btn-colapcin no-seleccionable"><i class="ico-colapcin md md-keyboard-arrow-up md-lg" style="display:inline-block;font-size: 2em;vertical-align: -50%;"><div class="tblcount" style="display: inline-block;">'+correlativo+'</div></i></td>');
                    var html = '<tr class="colapcin panel table-colapcin" data-codpadre="'+mint_idArea+'">'+
                            '<td></td>'+
                            '<td colspan="6">'+
                            '<div class="table-responsive">'+
                            '<table class="table table-hover table-jse" data-nivel="'+mint_Nivel+'">'+
                            '<thead class="bgm-orange">'+
                            '<th width="2%">#</th>'+
                            '<th width="25%">'+mstr_NomArea+'</th>'+
                            '<th width="25%">Microtik</th>'+
                            '<th width="20%">Interface</th>'+
                            '<th width="15%">CTR</th>'+
                            '<th width="5%"></th>'+
                            '<th width="10%"></td>'+
                            '</thead>'+
                            '<tbody>'+
                            '<tr data-id="'+data.idAREA+'">'+
                            '<td><i class="md md-lg" style="display:inline-block;font-size: 2em;vertical-align: -50%;"><div class="tblcount" style="display: inline-block;">1</div></i></td>'+
                            '<td>'+ data.Nom_Area+'</td>'+
                            '<td>'+data.dispositivo['Nombre']+'</td>'+
                            '<td>'+data.Interface+'</td>'+
                            '<td>'+data.CTAS_CTR+'</td>'+
                            '<td>';
                    if(mint_nivel != 3)
                    {
                        html +='<ul class="actions"><li><a class="btn-CrearArea"><i class="md md-add md-lg" style="font-size: 2em;vertical-align: -50%;"></i></a> </li> </ul> '
                    }
                    html +=  '</td>'+
                            '<td>'+
                            '<ul class="actions"> <li> <a class="btn-edit"><i class="md md-edit md-lg"></i></a> </li> <li> <a class="btn-delete"><i class="md md-delete md-lg"></i></a> </li> </ul>'+
                            '</td>'+
                            '</tr>'+
                            '</tbody>'+
                            '</table>'+
                            '</div>'+
                            '</td>'+
                            '</tr>';
                    mobj_tr.after(html);
                }
            }
            $('#cardSinAsignar').on('click','.btn-CrearArea',function(){
                //if($(this).hasClass('btn-Principal')){}
                var mint_codpadre = $(this).parents('tr').eq(0).data('id');
                if(mint_codpadre == undefined && mint_codpadre == null)
                {
                    mint_codpadre = null;
                }
                //console.log(mint_codpadre);
                $('#mdlCrearAreas').modal('show');
                $('#mdlCrearAreas').data('idEdit',0);
                $('#mdlCrearAreas').data('idCodPadre',mint_codpadre);
                $('#mdlCrearAreas').find('.modal-title').html('Crear Area');
                $('#tex_nombre').parents('.form-group').eq(0).addClass('is-empty');
                $('#tex_nombre').val('');
                $('#sel_DispositivoArea').val(1);
                $('#sel_DispositivoArea').selectpicker('render');
                $('#sel_DispositivoArea').selectpicker('refresh');
                $('#text_interface').parents('.form-group').eq(0).addClass('is-empty');
                $('#text_interface').val('');
                $('#text_CTR').parents('.form-group').eq(0).addClass('is-empty');
                $('#text_CTR').val('');
            });
            $("#btn-addSubArea").on('click',function(){
                var mint_AreaId = $('#mdlCrearSubArea').data('id');
                var mstr_nombreArea = $('#tex_nombreSubArea').val();
                var mstr_ctr = $('#text_CTRSubArea').val();
                $.ajax({
                    type: "POST",
                    url: '{{url("/pagPuntosAccesos/CrearArea")}}',
                    data: {nombre: mstr_nombreArea, AreaId: mint_AreaId, ctr: mstr_ctr},
                    dataType: 'json',
                    error: function (data, status) {
                        alert('Error');
                    },
                    success: function (data) {
                        //console.log('data', data);
                        var mobj_tr =  $('#cardSinAsignar').find('tr[data-codpadre="'+data.Cod_Padre+'"]');
                        if(mobj_tr.data('codpadre') != undefined && mobj_tr.data('codpadre') != null ){
                            //mobj_tr.siblings('tr[data-id="'+data.Cod_Padre+'"]');
                            var  mint_nivel = mobj_tr.find('table').eq(0).data('nivel');
                            var html =   '<tr data-id="'+data.idAREA+'">'+
                                    '<td><i class="md md-lg" style="display:inline-block;font-size: 2em;vertical-align: -50%;"><div class="tblcount" style="display: inline-block;">#</div></i></td>'+
                                    '<td>'+ data.Nom_Area+'</td>'+
                                    '<td class="card-link">';
                            if(mint_nivel != 3)
                            {
                                html +='<i class="md md-add md-lg btn-CrearArea" style="font-size: 2em;vertical-align: -50%;"></i>'
                            }
                            html +=  '</td>'+
                                    '<td class="card-link"><i class="md md-delete md-lg"></i></td>'+
                                    '</tr>';
                            mobj_tr.find('table tbody').eq(0).prepend(html);
                            mobj_tr.find('table tbody').eq(0).children('tr').each(function(i,r){
                                var count = i+1;
                                $(this).find('.tblcount').text(count);
                                $('#Count_AreasSinAsing').html(i);
                            });
                        }
                        else{
                            mobj_tr = $('#cardSinAsignar').find('tr[data-id="'+data.Cod_Padre+'"]');
                            var correlativo = mobj_tr.find('.tblcount').text();
                            var mint_idArea = mobj_tr.data('id');
                            var mstr_NomArea = mobj_tr.find('td').eq(1).text();
                            var mint_Nivel = mobj_tr.parents('table').eq(0).data('nivel');
                            var mint_Nivel =  mint_Nivel +1;
                            mobj_tr.find('td').eq(0).remove();
                            mobj_tr.prepend('<td class="card-link btn-colapcin no-seleccionable"><i class="ico-colapcin md md-keyboard-arrow-up md-lg" style="display:inline-block;font-size: 2em;vertical-align: -50%;"><div class="tblcount" style="display: inline-block;">'+correlativo+'</div></i></td>');
                            var html = '<tr class="colapcin panel table-colapcin" data-codpadre="'+mint_idArea+'">'+
                                    '<td></td>'+
                                    '<td colspan="6">'+
                                    '<div class="table-responsive">'+
                                    '<table class="table table-hover table-jse" data-nivel="'+mint_Nivel+'">'+
                                    '<thead class="bgm-orange">'+
                                    '<th width="5%">#</th>'+
                                    '<th width="85%">'+mstr_NomArea+'</th>'+
                                    '<th width="5%"></th>'+
                                    '<th width="5%"></th>'+
                                    '</thead>'+
                                    '<tbody>'+
                                    '<tr data-id="'+data.idAREA+'">'+
                                    '<td><i class="md md-lg" style="font-size: 2em;vertical-align: -50%;"><div class="tblcount">1</div></i></td>'+
                                    '<td>'+data.Nom_Area+'</td>'+
                                    '<td class="card-link">';
                            if(mint_Nivel != 3)
                            {
                                html += '<i class="md md-add md-lg btn-CrearArea" style="font-size: 2em;vertical-align: -50%;"></i></td>';
                            }
                            html +='<td class="card-link"><i class="md md-delete md-lg"></i></td>'+
                                    '</tr>'+
                                    '</tbody>'+
                                    '</table>'+
                                    '</div>'+
                                    '</td>'+
                                    '</tr>';
                            mobj_tr.after(html);
                        }
                        //location.reload();
                    }
                });
            });
            $('#cardSinAsignar').on('click','.btn-ModalSubArea',function(){
                var mobj_modal = $('#mdlCrearSubArea');
                var mint_AreaId = $(this).parents('tr').eq(0).data('id');
                mobj_modal.data('id',mint_AreaId);
                mobj_modal.modal('show');
            });
            $('#cardSinAsignar').on('click','.btn-colapcin',function(){
                f_colapcion(this);
            });
            $('#lst_Contratos').on('click','.btn-colapcin',function(){
                f_colapcion(this);
            });
            function f_colapcion(contex){
                var mele_btn = $(contex).find('.ico-colapcin');
                var mele_Card = $(contex).parents('.card-header').siblings('div .colapcin');
                var mstr_Card = 'card';
                if(!mele_Card.hasClass('colapcin')){
                    //mele_Card = $(this).parent().siblings('.colapcin');
                    mint_posion = $(contex).parent().index();
                    mele_Card = $(contex).parent().parent().children('tr').eq(mint_posion+1);
                    //console.log(mele_Card.attr('class'));
                    mstr_Card = 'table';
                }
                if(mele_btn.hasClass('md-keyboard-arrow-up')){
                    mele_Card.removeClass(mstr_Card+'-colapcin');
                    mele_Card.addClass(mstr_Card+'-colapcin-off');
                    mele_btn.removeClass('md-keyboard-arrow-up');
                    mele_btn.addClass('md-keyboard-arrow-down');
                }else{
                    mele_Card.addClass(mstr_Card+'-colapcin');
                    mele_Card.removeClass(mstr_Card+'-colapcin-off');
                    mele_btn.addClass('md-keyboard-arrow-up');
                    mele_btn.removeClass('md-keyboard-arrow-down');
                }
            }
            $('.btn-validar').on('click',function(){
                //console.log(f_validar(this));
                /*if(f_validar(this)==true){
                 $.bootstrapGrowl("Error! areas sin validar", {
                 type: 'danger',
                 align: 'botton',
                 });
                 return false;
                 }*/
                var mint_ContratoId = $(this).parent().data('id');
                var mlst_lstConsumo = new Array();
                var mobj_card = $(this).parents('.card-jse');
                mobj_card.find('input[type="number"]').each(function(){
                    var mint_AreaId = $(this).parents('tr').data('id');
                    var mflo_Porc_Comsumo =$(this).val();
                    var mflo_Cant_Comsumo = $(this).parent().parent().parent().children().find('.cant_mbts').text();
                    var mflo_SubTotal_Comsumo = $(this).parent().parent().parent().children().find('.subtotal').text();
                    var mobj_Consumo = new Object();
                    obj_Consumo =
                    {
                        "idArea": mint_AreaId,
                        "Mbps_Asignado": parseFloat(mflo_Cant_Comsumo).toFixed(3),
                        "Porc_Mbps": parseFloat(mflo_Porc_Comsumo).toFixed(3),
                        "SubTotal": parseFloat(mflo_SubTotal_Comsumo).toFixed(3),
                    }
                    //console.log(obj_Consumo);
                    mlst_lstConsumo.push(obj_Consumo);
                });
                //console.log(JSON.stringify(mlst_lstConsumo));
                notificacion("<b>Monitoreo de Redes</b> - Este proceso podría tomar algunos minutos. Se le Notificara cuando esté Termininado",'info');
                $.ajax({
                    type: "POST",
                    //url: '/pagPuntosAccesos/CrearConsumo',
                    url: "{{url('/pagPuntosAccesos/CrearConsumo')}}",
                    data: {lstConsumo: mlst_lstConsumo},
                    dataType: 'json',
                    error: function (data, status) {
                        alert('Error');
                    },
                    success: function (data) {
                        // console.log('data', data);
                        ///location.reload();
                        notificacion("<b>Monitoreo de Redes</b> - Exito al validar el contrato!",'success');
                    }
                });
            });
            $('#lst_Contratos').on('click','input[type="number"]',function(){
                listar(this);
            });
            $('#lst_Contratos').on('keyup','input[type="number"]',function(){
                listar(this);
            });
            function listar(m_conten){
                $(m_conten).parents('.card-contrato').find('table').each(function(){
                    var mint_globalNivel = $(this).data('nivel');
                    var mint_globalImporte = $(this).data('importe');
                    var mint_globalCantMbps = $(this).data('mbts');
                    var totalporc_Mbps = 0;
                    var totalcant_Mbps = 0;
                    var totalimporte_Mbps = 0;
                    $(this).find('tr[data-nivel="'+mint_globalNivel+'"]').each(function(){
                        var mint_AreaId = $(this).data('id');
                        var mstr_porcMbps = $(this).children('.porc_mbts').find('input').eq(0).val();
                        if(mstr_porcMbps == ""){
                            mstr_porcMbps = 0;
                        }
                        var mint_cantMbps = parseFloat(mint_globalCantMbps *  mstr_porcMbps/100).toFixed(2);
                        var mint_importeMbps = parseFloat(mstr_porcMbps/100 * mint_globalImporte).toFixed(3);
                        $(this).children().find('.cant_mbts').text(mint_cantMbps);
                        $(this).children().find('.subtotal').text(mint_importeMbps);
                        var mobj_tablaHija = $(this).siblings('tr[data-codpadre="'+mint_AreaId+'"]').find('table[data-nivel="' + parseInt(mint_globalNivel + 1) + '"]')
                        mobj_tablaHija.data('importe',mint_importeMbps);
                        mobj_tablaHija.data('mbts',mint_cantMbps);
                        totalporc_Mbps += parseFloat(mstr_porcMbps);
                        totalcant_Mbps += parseFloat($(this).children().find('.cant_mbts').text());
                        totalimporte_Mbps += parseFloat($(this).children().find('.subtotal').text());
                    });
                    totalporc_Mbps =roundtwo(totalporc_Mbps);
                    totalcant_Mbps = roundtwo(totalcant_Mbps);
                    totalimporte_Mbps = roundtwo(totalimporte_Mbps);
                    //$(this).children('tfoot').remove();
                    $(this).children('tfoot').find('.totalPorc_Mbps').text(totalporc_Mbps);
                    $(this).children('tfoot').find('.totalCant_Mbps').text(totalcant_Mbps);
                    $(this).children('tfoot').find('.totalimporte_Mbps').text(totalimporte_Mbps);
                    if(totalporc_Mbps>100){
                        $(m_conten).val(0);
                        listar(m_conten);
                    }
                });
            }
            function roundtwo(num){
                return +(Math.round(num +"e+2") +"e-2");
            }
            function f_validar(m_conten){
                var count = 0;
                $(m_conten).parents('.card-contrato').find('table').each(function(){
                    var mint_globalNivel = $(this).data('nivel');
                    var totalporc_Mbps = 0;
                    $(this).find('tr[data-nivel="'+mint_globalNivel+'"]').each(function(){
                        var mstr_porcMbps = $(this).children('.porc_mbts').find('input').eq(0).val();
                        if(mstr_porcMbps == ""){
                            mstr_porcMbps = 0;
                        }
                        totalporc_Mbps += parseFloat(mstr_porcMbps);
                    });
                    if(totalporc_Mbps != 100){
                        count ++;
                    }
                });
                if(count == 0 ){
                    return false;
                }
                return true;
            }
            $('#cardSinAsignar').on('click','.btn-edit',function(){
                $('#mdlCrearAreas').find('.modal-title').html('Editar Area');
                var mint_idArea = $(this).parents('tr').eq(0).data('id');
                $.ajax({
                    type: "POST",
                    //url: '/pagPuntosAccesos/CrearConsumo',
                    url: "{{url('/pagPuntosAccesos/obtenerArea')}}",
                    data: {idArea: mint_idArea},
                    dataType: 'json',
                    error: function (data, status) {
                        alert('Error');
                    },
                    success: function (data) {
                        //console.log('data', data);
                        $('#tex_nombre').parents('.form-group').eq(0).removeClass('is-empty');
                        $('#tex_nombre').val(data.Nom_Area);
                        $('#sel_DispositivoArea').val(data.idDispositivo);
                        $('#sel_DispositivoArea').selectpicker('render');
                        $('#sel_DispositivoArea').selectpicker('refresh');
                        $('#text_interface').parents('.form-group').eq(0).removeClass('is-empty');
                        $('#text_interface').val(data.Interface);
                        $('#text_CTR').parents('.form-group').eq(0).removeClass('is-empty');
                        $('#text_CTR').val(data.CTAS_CTR);
                        $('#mdlCrearAreas').data('idEdit',data.idAREA);
                        $('#mdlCrearAreas').data('idCodPadre',data.Cod_Padre);
                        $('#mdlCrearAreas').modal('show');
                    }
                });
            });
            $('#cardSinAsignar').on('click','.btn-delete',function(){
                var mint_Areaid = $(this).parents('tr').eq(0).data('id');
                var Contex = this;
                swal({
                    title:"¿Está seguro de eliminar?",
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#9c27b0",
                    confirmButtonText: "SI",
                    cancelButtonText: "NO"})
                        .then(function () {
                            f_Eliminar(mint_Areaid,Contex);
                        });
            });
            function f_Eliminar(vint_Areaid,Contex){
                $.ajax({
                    type: "POST",
                    url: '{{url("/pagPuntosAccesos/EliminarArea")}}',
                    data: {idArea: vint_Areaid},
                    dataType: 'json',
                    error: function (data, status) {
                        alert('Error');
                    },
                    success: function (data) {
                        //console.log('data', data);
                        //location.reload();
                        if(data ==  true)
                        {
                            notificacion("<b>Monitoreo de Redes</b> - Exito! al eliminar el Area",'success');
                            var mobj_tbody = $(Contex).parents('tr').eq(0).parent('tbody');
                            $(Contex).parents('tr').eq(0).remove();
                            var count = 0;
                            mobj_tbody.children('tr').each(function(i,r){
                                if($(this).data('id')!= undefined && $(this).data('id')!= null)
                                {
                                    count++;
                                    $(this).find('.tblcount').eq(0).text(count);
                                    if(mobj_tbody.attr('id')=="list_Area"){
                                        $('#Count_AreasSinAsing').html(count);
                                    }
                                }
                            });
                        }else{
                            notificacion("<b>Monitoreo de Redes</b> - Error! al eliminar el Area",'warning');
                        }
                    }
                });
            }
            function notificacion(vstr_mensaje,color){
                //type = ['','info','success','warning','danger','rose','primary'];
                $.notify({
                    icon: " md md-notifications",
                    message: vstr_mensaje,
                },{
                    type: color,
                    timer: 3000,
                    placement: {
                        //from: 'top',
                        align: 'right'
                    }
                });
            }
            $('#lst_Contratos').on('click','.btn-reporte',function(){
                var mint_idcontrato = $(this).data('idcontrato');
                $('#mdlReporte').data('idcontrato',mint_idcontrato);
                var mstr_fechaHasta =  $('#text_fechaHasta').val();
                var mstr_fechaDesde = $('#text_fechaDesde').val();
                var mint_idcontrato =$('#mdlReporte').data('idcontrato');
                $('#ifr_reporte').html('');
                var html = '<iframe src="'+'{{url("/pagReporte")}}/'+mint_idcontrato+'/'+mstr_fechaDesde.split('/').join('-')+'/'+mstr_fechaHasta.split('/').join('-')+'" height="600px" width="100%" frameborder="0" style="border: 0" allowfullscreen></iframe>';
                var tempDiv = document.createElement('div');
                tempDiv.innerHTML = html;
                $('#ifr_reporte').append(tempDiv);
                //document.getElementById('ifr_reporte').location.reload();
                $('#mdlReporte').modal('show');
            });
            $('#btn-Generar').on('click',function(){
                var mint_idcontrato = $('#mdlReporte').data('idcontrato');
                var mstr_fechaDesde = $('#text_fechaDesde').val();
                var mstr_fechaHasta =  $('#text_fechaHasta').val();
                swal({
                    title:"¿Está seguro de Generar un Reporte?",
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#9c27b0",
                    confirmButtonText: "SI",
                    cancelButtonText: "NO"})
                        .then(function () {
                            f_generar(mint_idcontrato,mstr_fechaDesde,mstr_fechaHasta);
                            notificacion("<b>Monitoreo de Redes</b> - Este proceso podría tomar algunos minutos. Se le Notificara cuando esté Termininado",'info');
                        });
            });
            function f_generar(vint_idcontrato, vstr_fechaDesde, vstr_fechaHasta){
                $.ajax({
                    type: "POST",
                    url: '{{url("/pagPuntosAccesos/GenerarReporte")}}',
                    data: {idContrato: vint_idcontrato, fechaDesde: vstr_fechaDesde.split('/').join('-'), fechaHasta: vstr_fechaHasta.split('/').join('-')},
                    dataType: 'json',
                    error: function (data, status) {
                        alert('Error');
                    },
                    success: function (data) {
                        //console.log('data', data);
                        //location.reload();
                        if(data ==  true)
                        {
                            notificacion("<b>Monitoreo de Redes</b> - Exito al gerenar el reporte.",'success');
                        }else{
                            notificacion("<b>Monitoreo de Redes</b> - Error al eliminar el reporte.",'warning');
                        }
                    }
                });
            }
        });
        $('.datepicker').on('click',function(){
            var input = $(this);
            if(input.val()!='')
            {
                input.parent().removeClass('is-empty');
            }
        });
        $('.datepicker').datetimepicker({
            format: 'DD/MM/YYYY',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove',
                inline: true
            }
        });
        $('#actualizar').on('click',function(){
            var mstr_fechaHasta =  $('#text_fechaHasta').val();
            var mstr_fechaDesde = $('#text_fechaDesde').val();
            if(mstr_fechaHasta == "") {mstr_fechaHasta = " ";}
            if(mstr_fechaDesde == "") {mstr_fechaDesde = " ";}
            console.log(mstr_fechaDesde);
            var mint_idcontrato =$('#mdlReporte').data('idcontrato');
            $('#ifr_reporte').html('');
            var html = '<iframe src="'+'{{url("/pagReporte")}}/'+mint_idcontrato+'/'+mstr_fechaDesde.split('/').join('-')+'/'+mstr_fechaHasta.split('/').join('-')+'" height="600px" width="100%" frameborder="0" style="border: 0" allowfullscreen></iframe>';
            var tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;
            $('#ifr_reporte').append(tempDiv);
            //document.getElementById('ifr_reporte').location.reload();
        });
        function f_actualizarDispositivoArea(){
            $('#sel_DispositivoArea').val(1);
            $('#sel_DispositivoArea').selectpicker('render');
            $('#sel_DispositivoArea').selectpicker('refresh')
        }
    </script>
@endsection