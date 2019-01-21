<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <title>Example jse</title>
    @if($data->pdf == true)
        <link rel="stylesheet" href="reporte/consumo/style.css" media="all" />
    @else
        <link rel="stylesheet" href="{{url('reporte/consumo/style.css')}}" media="all" />
        @endif
                <!--<body oncontextmenu="return false" onkeydown="return false">-->
<body>
<div>
    <div style="display:inline-block; font-weight: bold; width: 95%"><div style="float: left; display: inline-block;">N° {{str_pad($data->contrato->idDocumento, 8,0, STR_PAD_LEFT)}}</div> <div style="float: right; display: inline-block;">{{Carbon\Carbon::parse()->format('d/m/Y')}}</div></div>
    <div id="logo" style="text-align: center;">
        @if($data->pdf == true)

            <img style="margin-right: 487px;" src='reporte/consumo/logo-digeti.png'>
            <img src='reporte/consumo/logo-upeu.png'>
        @else
            <img style="margin-right: 487px;" src='{{url("reporte/consumo/logo-digeti.png")}}'>
            <img src='{{url("reporte/consumo/logo-upeu.png")}}'>
        @endif
    </div>
    <!--style="page-break-before:always;"-->
    <div class="titulo">
        <!--<h1>{{$data->entidad->Nombre}}</h1>-->
        <h3 style="margin-bottom: 0;">COBRANZA POR EL SERVICIO DE ACCESO DEDICADO A INTERNET</h3>
        <div style="font-weight: bold;"><small>PERIODO GENERADO {{\Carbon\Carbon::parse($data->fechaDesde)->format('d/m/Y')}} AL {{\Carbon\Carbon::parse($data->fechaHasta)->format('d/m/Y')}}</small></div>
        <br>
    </div>
    <div class="project clearfix" style="display:inline-block;  float: left; width: 45%">
        <div><span>PROVEEDOR</span>{{$data->contrato->proveedor->Nom_Empresa}}</div>
        <div><span>RUC</span>{{$data->contrato->proveedor->RUC}}</div>
        <div><span>DIRECCION</span>{{$data->contrato->proveedor->Direccion}}</div>
        <div><span>TELEFONO</span>{{$data->contrato->proveedor->Telefono}}</div>
    </div>
    <div class="project" style="display:inline-block; width: 50%">
        <div><span>ENTIDAD</span>{{$data->entidad->Nombre}}</div>
        <div><span>RUC</span>{{$data->entidad->C_RUC}}</div>
        <!--<div><span>COD. DE SERVICIO</span>{{$data->entidad->Cod_Servicio}}</div>-->
        <!--<div><span>DIR. FACTURACION</span>{{$data->entidad->Dir_FACT}}</div>-->
    </div>
</div>
<div>
    <br>
    <table>
        <thead>
        <tr>
            <th>SERVICIO</th>
            <th>CD / Req</th>
            <th>Vel.</th>
            <th>Oficina</th>
            <th>TOTAL</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data->contrato->detalle as $itemDet)
            <tr>
                <td class="service">{{$itemDet->Servicio}}</td>
                <td class="desc">{{$itemDet->CD_Req}}</td>
                <td class="unit">{{$itemDet->Velocidad}}&nbsp;Mpbs</td>
                <td class="qty">{{$itemDet->Oficina}}</td>
                <td class="total">S/.{{number_format((double)$itemDet->Importe,2, '.', ',')}}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="2">TOTAL</td>
            <td class="total">{{$data->contrato->Velocidad_Mb}}&nbsp;Mpbs</td>
            <td colspan="1">SUBTOTAL</td>
            <td class="total">S/.{{number_format((double)$data->contrato->Importe/1.18,2, '.', ',') }}</td>
        </tr>
        <tr>
            <td colspan="4">IGV</td>
            <td class="total">S/.{{number_format((double)$data->contrato->Importe - (double)$data->contrato->Importe/1.18, 2, '.', ',')}}</td>
        </tr>
        <tr>
            <td colspan="4" class="grand total">TOTAL</td>
            <td class="grand total">S/.{{number_format($data->contrato->Importe, 2, '.', ',')}}</td>
        </tr>
        </tfoot>
    </table>
    @if($data->tipo == 'D')
        @foreach($data->contrato->areas as $i=>$itemArea)
            <div class="subtitulo">
                <div style="width: 95%; display: inline-block">
                    <lu style="list-style-type: none;padding: 0;margin: 0;;">
                        <li style="float: left;width: 5%;display: inline-block;"><a style="display: block;text-decoration: none;text-align: left;"><h2>{{$i+1}}.</h2></a></li>
                        <li style="float: left;width: 45%;display: inline-block;;"><a style="display: block;text-decoration: none;text-align: left;"><h3>{{$itemArea->Nom_Area}}</h3></a></li>
                        <li style="float: left;width: 48%;display: inline-block;;"><a style="display: block;text-decoration: none;text-align: right;"><h3>IMPORTE: S/.{{number_format($itemArea->consumo["SubTotal"], 3, '.', ',')}}</h3></a></li>
                    </lu>
                </div>
            </div>
            <div class="project clearfix" style="display:inline-block;  float: left; width: 45%;page-break-before: auto;">
                <div><span>AREA</span>{{$itemArea->Nom_Area}}</div>
                <div><span>RESPONSABLE</span>{{$data->entidad->Nombre}}</div>
                <div><span>CTAS CTR</span>{{$itemArea->CTAS_CTR}}</div>
            </div>
            <div class="project" style="display:inline-block; width: 50%;page-break-before: auto;">
                <div><span>PORC. ACUMULADO</span>{{number_format($itemArea->consumo["Porc_Mbps"], 2, '.', ',')}}%</div>
                <div><span>VELOCIDAD</span>{{number_format($itemArea->consumo["Mbps_Asignado"], 3, '.', ',')}} Mbps</div>
                <div><span>IMPORTE</span>S/.{{number_format($itemArea->consumo["SubTotal"], 3, '.', ',')}}</div>
            </div>
            <br>
            <br>
            @if(count($itemArea->area) > 0)
                <table>
                    <thead>
                    <tr>
                        <th width="">#</th>
                        <th  style="text-align: left;">SUBAREAS</th>
                        <th  width="">CTAS CTR</th>
                        <th  width="">PORC. ACUMULADO</th>
                        <th  width="">VELOCIDAD</th>
                        <th  width="">TOTAL</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($itemArea->area as $i1 => $itemArea1)
                        <tr>
                            <td>{{$i1+1}}</td>
                            <td class="service">{{$itemArea1->Nom_Area}}</td>
                            <td style="text-align: center;">{{$itemArea1->CTAS_CTR}}</td>
                            <td style="text-align: center;">{{number_format($itemArea1->consumo["Porc_Mbps"], 2, '.', ',')}}%</td>
                            <td class="qty">{{number_format($itemArea1->consumo["Mbps_Asignado"], 3, '.', ',')}} Mbts</td>
                            <td class="total">S/.{{number_format($itemArea1->consumo["SubTotal"], 3, '.', ',')}}</td>
                        </tr>
                        @if(count($itemArea1->area) > 0)
                            <tr>
                                <td></td>
                                <td colspan="5" class="find">
                                    <table style="margin-bottom:0;">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th style="text-align: left;" width="50%">SUBAREAS</th>
                                            <th>CTAS CTR</th>
                                            <th>PORC. ACUMULADO</th>
                                            <th>VELOCIDAD</th>
                                            <th>TOTAL</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($itemArea1->area as $i2 => $itemArea2)
                                            <tr>
                                                <td>{{$i2+1}}</td>
                                                <td class="service">{{$itemArea2->Nom_Area}}</td>
                                                <td style="text-align: center;">{{$itemArea2->CTAS_CTR}}</td>
                                                <td style="text-align: center;">{{number_format($itemArea2->consumo["Porc_Mbps"], 2, '.', ',')}}%</td>
                                                <td class="qty">{{number_format($itemArea2->consumo["Mbps_Asignado"], 3, '.', ',')}} Mbts</td>
                                                <td class="total">S/.{{number_format($itemArea2->consumo["SubTotal"], 3, '.', ',')}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="3">TOTAL</td>
                                            <td style="text-align: center;">{{$itemArea1->totalPorcMbts}}%</td>
                                            <td class="qty">{{number_format($itemArea1->totalCantMbts, 2, '.', ',')}} Mbps</td>
                                            <td class="total">S/.{{number_format($itemArea1->totalImporMbts, 3, '.', ',')}}</td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="3">TOTAL</td>
                        <td style="text-align: center;">{{$itemArea->totalPorcMbts}}%</td>
                        <td class="qty">{{number_format($itemArea->totalCantMbts, 2, '.', ',')}} Mbps</td>
                        <td class="total">S/.{{number_format($itemArea->totalImporMbts, 3, '.', ',')}}</td>
                    </tr>
                    </tfoot>
                </table>
            @endif
        @endforeach

        <div class="subtitulo">
            <div style="width: 95%; display: inline-block">
                <lu style="list-style-type: none;padding: 0;margin: 0;">
                    <li style="float: left;width: 25%;"><a style="display: block;text-decoration: none;text-align: left;"><h1>TOTAL</h1></a></li>
                </lu>
            </div>
        </div>
        <table>
            <thead>
            <tr>
                <th>#</th>
                <th>CANT. AREAS</th>
                <th>PORC. ACUMULADO</th>
                <th>VELOCIDAD</th>
                <th>IMPORTE</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td style="text-align: center;">-</td>
                <td style="text-align: center">{{count($data->contrato->areas)}}</td>
                <td style="text-align: center">{{number_format($data->contrato->totalPorcMbts, 2, '.', ',')}}%</td>
                <td class="qty">{{number_format(number_format($data->contrato->totalCantMbts, 2, '.', ','), 3, '.', ',')}} Mbps</td>
                <td class="total">S/.{{number_format($data->contrato->totalImporMbts, 3, '.', ',')}}</td>
            </tr>
            </tbody>
        </table>
    @elseif($data->tipo == 'S')
        <div class="subtitulo">
            <div style="text-align: left; width: 45%; display: inline-block">
                <h1> AREAS</h1>
            </div>
            <div style="text-align: right; width: 50%;display: inline-block">
                <h1 style="display: inline-block; text-align: right;"><small>Total Mbps: </small>{{$data->contrato->Velocidad_Mb}}</h1>
            </div>
        </div>
        <table style="margin-right: 1.5rem">
            <thead>
            <tr>
                <th>#</th>
                <th style="text-align: left;" width="50%">NOMBRE</th>
                <th>CTAS CTR</th>
                <th>% ACUMULADO</th>
                <th>CANT. MBTS</th>
                <th>SUB-TOTAL</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data->contrato->areas as $i=>$itemArea)
                <tr>
                    <th>{{$i+1}}</th>
                    <td class="service">{{$itemArea->Nom_Area}}</td>
                    <td class="desc">{{$itemArea->CTAS_CTR}}</td>
                    <td class="unit">{{number_format($itemArea->consumo["Porc_Mbps"], 2, '.', ',')}}</td>
                    <td class="qty">{{number_format($itemArea->consumo["Mbps_Asignado"], 3, '.', ',')}}</td>
                    <td class="total">{{number_format($itemArea->consumo["SubTotal"], 3, '.', ',')}}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td colspan="3">TOTAL</td>
                <td class="unit">{{$data->contrato->totalPorcMbts}}</td>
                <td class="qty">{{number_format($data->contrato->totalCantMbts, 2, '.', ',')}}</td>
                <td class="total">{{number_format($data->contrato->totalImporMbts, 3, '.', ',')}}</td>
            </tr>
            <tr>
                <td colspan="6" class="grand total"></td>
            </tr>
            </tfoot>
        </table>
    @endif
</div>
</body>
</html>