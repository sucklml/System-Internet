<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <title>Example jse</title>

    <!-- Demo Dependencies -->
    <script src="{{url('/reporte/assets/js/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{url('/reporte/assets/js/chartist.js')}}" type="text/javascript"></script>


    <link rel="stylesheet" href="{{url('reporte/consumo/style.css')}}" media="all" />
    <link rel="stylesheet" href="{{url('/reporte/assets/css/chartist.css')}}" />
    <!--<body oncontextmenu="return false" onkeydown="return false">-->
</head>

<body style="width: 100%!important;height: 100%!important;">
<div>
    <div id="logo" style="text-align: center;">
        <img style="margin-right: 487px;" src='{{url("reporte/consumo/logo-digeti.png")}}'>
        <img src='{{url("reporte/consumo/logo-upeu.png")}}'>
    </div>
    <!--style="page-break-before:always;"-->
    <div class="titulo">
        <h3 style="margin-bottom: 0;">REPORTE DEL TRÁFICO DE LA RED </h3>
        <div style="font-weight: bold;"><small>DESDE {{\Carbon\Carbon::parse($data->fechaDesde)->format('d/m/Y')}} HASTA {{\Carbon\Carbon::parse($data->fechaHasta)->format('d/m/Y')}}</small></div>
        <br>
    </div>
    <div class="container-fluid">
        <div class="project clearfix" style="display:inline-block;  float: left; width: 45%">
            <div><span>DISPOSITIVO</span>{{$data->Dispo->Nombre}}</div>
            <div><span>IP</span>{{$data->Dispo->Ip}}</div>
            <div><span>PUERTO</span>{{$data->Dispo->Puerto}}</div>
            <div><span>USER</span>{{$data->Dispo->User}}</div>
            <div><span>ESTADO</span>
                @if($data->Dispo->Ping == 0) DESACTIVADO @else ACTIVO @endif</div>
        </div>
        <div class="project" style="display:inline-block; width: 50%">
            <div><span>ENTIDAD</span>{{$data->entidad->Nombre}}</div>
            <div><span>RUC</span>{{$data->entidad->C_RUC}}</div>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div class="subtitulo">
            <div style="width: 95%; display: inline-block">
                <lu style="list-style-type: none;padding: 0;margin: 0;;">
                    <li style="float: left;width: 45%;display: inline-block;;"><a style="display: block;text-decoration: none;text-align: left;"><h3>CONSUMO GLOBAL {{number_format($data->consumoGlobal->bajada, 2, '.', ',')}} MBPS</h3></a></li>
                    <li style="float: left;width: 48%;display: inline-block;;"><a style="display: block;text-decoration: none;text-align: right;"><h3></h3></a></li>
                </lu>
            </div>
        </div>
        <table>
            <thead>
            <tr>
                <th width="5%">#</th>
                <th  width="30%" style="text-align: left;">AREAS</th>
                <th width="10%">CTAS CTR</th>
                <th width="15%">CONSUMO DE UPLOAD</th>
                <th width="15%">CONSUMO DE DOWNLOAD</th>
                <th width="15%">DESVIACIÓN ESTÁNDAR</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data->consumoArea as $i => $itemArea)
                <tr>
                    <td>{{$i+1}}</td>
                    <td class="service">{{$itemArea->Nom_Area}}</td>
                    <td style="text-align: center;">{{$itemArea->CTAS_CTR}}</td>
                    <td style="text-align: center;">{{number_format($itemArea->subida, 2, '.', ',')}} Mbts</td>
                    <td class="qty">{{number_format($itemArea->bajada, 2, '.', ',')}} Mbts</td>
                    <td class="total">{{number_format($itemArea->desvSTR, 2, '.', ',')}}  Mbts</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td colspan="3">TOTAL</td>
                <td style="text-align: center;">{{number_format($data->consumoGlobal->subida, 2, '.', ',')}} Mbts</td>
                <td class="qty">{{number_format($data->consumoGlobal->bajada, 2, '.', ',')}} Mbts</td>
                <td class=""></td>
            </tr>
            </tfoot>
        </table>
        <hr>
    </div>
</div>
</body>
<script>
    new Chartist.Line('#chart-01', {
        labels: [1, 2, 3, 4, 5, 6, 7, 8],
        series: [
            [5, 9, 7, 8, 5, 3, 5, 4]
        ]
    }, {
        low: 0,
        showArea: true
    });

    var data = {
        series: [5, 3, 4]
    };

    var sum = function(a, b) { return a + b };

    new Chartist.Pie('#chart-02', data, {
        labelInterpolationFnc: function(value) {
            return Math.round(value / data.series.reduce(sum) * 100) + '%';
        }
    });
</script>
</html>