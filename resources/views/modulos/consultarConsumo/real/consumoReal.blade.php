@extends('layouts.app')

@section('title')
@endsection
@section('content')
    <div class="row" style="margin-top: -77px;">
        <div class="card">
            <div class="card-content">
                <div class="tab-content">
                    <div class="tab-pane active" id="realtime">
                        <div id="grap_monitor" class="row">
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <select id="slec_dispositivo" class="selectpicker" data-live-search="true"
                                            data-style="btn btn-primary" title="Seleccionar Contrato"></select>
                                </div>
                                <div class="col-md-3">
                                    <select id="selec_area" class="selectpicker" data-live-search="true"
                                            data-style="btn btn-primary" title="Seleccionar Area"></select>
                                </div>
                                <div class="col-md-6">
                                    <div id="panel" class="stats" style="padding:10px;margin-top:5px;border-radius: 10px 10px 10px 10px;-moz-border-radius: 10px 10px 10px 10px;-webkit-border-radius: 10px 10px 10px 10px;border: 1px solid #23539c;display: none;">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p><b>Dispositivo: </b><small id="txt_dispositivo"> </small></p>
                                            </div>
                                            <div class="col-sm-6">
                                                <p><b>Ip: </b><small id="txt_ip"> </small> <b> Puerto:</b><small id="txt_puerto"></small></p>
                                            </div>
                                            <div class="col-sm-6">
                                                <p><b>User: </b><small id="txt_usuario"></small></p>
                                            </div>
                                            <div class="col-sm-6">
                                                <p><b>Interface: </b><small id="txt_interface"></small></p>
                                            </div>
                                            <div class="col-sm-6">
                                                <p><b>Estado: </b><small id="txt_estado"> <b></b></small></p>
                                            </div>
                                            <button id="btn-reporte" title="Ver Reporte Detallado" type="button" class="btn btn-round btn-fab bgm-teal" style="float: right; height: 52px;width: 52px;min-width: 0;right: 15px;"><i class="md md-content-paste md-lg"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div id="horapro" style="max-width: 280px;"></div>
                            </div>
                            <div class="col-md-12" id="ConsumoReal">
                                <br>
                                <input id="interface" type="hidden" value="">
                                <div id="container"></div>
                                <span style="font-size: 15px;color: #2f7ed8;" class="fa fa-long-arrow-up"
                                      id="tx_t"></span>
                                <span style="font-size: 15px;color: #0d233a;" class="fa fa-long-arrow-down"
                                      id="rx_t"></span>

                            </div>
                            <div class="col-md-12" class="table-responsive" style="">
                                <div id="Barraras" style="display:none;width: 75%"></div>
                            </div>
                            <div class="col-md-12" style="">
                                <div style="display: none;" id="Consumo">
                                    <div class="col-md-7">
                                        <div class="card card-chart">
                                            <div class="card-header" data-background-color="orange">
                                                <div id="straightLinesChart" class="ct-chart"></div>
                                            </div>
                                            <div class="card-content">
                                                <h4 class="card-title">Mbps por Hora </h4>
                                                <p class="category">Reporte de Consumo por Hora</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="card card-chart">
                                            <div class="card-header" data-background-color="rose">
                                                <div id="roundedLineChart" class="ct-chart"></div>
                                            </div>
                                            <div class="card-content">
                                                <h4 class="card-title">Mbps por Dia</h4>
                                                <p class="category">Reporte de Consumo por Dia</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="card card-chart">
                                            <div class="card-header" data-background-color="blue">
                                                <div id="simpleBarChart" class="ct-chart"></div>
                                            </div>
                                            <div class="card-content">
                                                <h4 class="card-title">Mbps por Mes</h4>
                                                <p class="category">Reporte de Consumo por Mes</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="history">
                        <di id="area2"></di>
                    </div>
                    <div class="tab-pane" id="settings">
                    </div>
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
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        listarDispositivos();
        function listarDispositivos() {

            var dispositivo = $("#spinner").find('.content').data('dispositivo');
            $('#slec_dispositivo').html('');
            $.each(dispositivo,function (i,r) {
                var html = $("<option value='"+r.idDispositivo+"'>"+r.Nombre+"</option>");
                $(html).data('dispositivo',r);
                $('#slec_dispositivo').append(html);

            });
            $('#slec_dispositivo').selectpicker('render');
            $('#slec_dispositivo').selectpicker('refresh');
        }

        $('#slec_dispositivo').on('change',function () {
            var dispo = $(this).find(":selected").data('dispositivo');

            var microtikId = $(this).val();
            listarAreas(microtikId);
            clearInterval($timerId);

            var estado = "ACTIVO";
            if(dispo.Ping == 0){
                estado = "DESACTIVADO";
            }


            $("#txt_dispositivo").text(dispo.Nombre);
            $("#txt_estado").text(estado);
            $("#txt_ip").text(dispo.Ip);
            $("#txt_puerto").text(dispo.Puerto);
            $("#txt_usuario").text(dispo.User);

            if(microtikId>0){
                $('#panel').show();
            }else{
                $('#panel').hide();
            }

        });

        function listarAreas(microtikId) {
            $.ajax({
                type: "POST",
                url:'{{url("/pagConsumoReal/lstareas")}}',
                data: {microtikId: microtikId},
                dataType: 'json',
                error: function (data, status) {
                    alert('Error');
                },
                success: function (data) {
                    $('#selec_area').html('');
                    $.each(data,function (i,r) {
                        var html = $("<option value='"+r.idAREA+"'>"+r.Nom_Area+"</option>");
                        $(html).data('objArea',r);
                        $('#selec_area').append(html);
                    });
                    $('#selec_area').selectpicker('render');
                    $('#selec_area').selectpicker('refresh');
                }

            });
        }
        obtnerDispositivo();

        Highcharts.setOptions({
            global: {
                useUTC: false
            }
        });
        var TX = 0,RX = 0;
        var Datos = [];
        var mbts = 40;

        function obtnerDispositivo() {
            var count = 0;
            setInterval(function () {
                requestDatta();
                /*count ++;
                if(count == 3){
                    if($('#spinner').hasClass('cantidad')){
                        $cantidad.show();
                        $svg.hide();
                        $cantidad.animateCss('bounceIn');
                        $('#spinner').removeClass('cantidad');
                    }else{
                        $cantidad.hide();
                        $svg.show();
                        $svg.animateCss('tada');
                        $('#spinner').addClass('cantidad');
                    }
                    count = 0;
                }*/
            }, 1000);
        }

        var chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                animation: Highcharts.svg,
                type: 'spline',
                events: {
                    load: function () {

                    }
                }
            },
            title: {
                text: 'Consumo de Internet'
            },
            xAxis: {
                type: 'datetime',
                tickPixelInterval: 150,
                maxZoom: 20 * 1000
            },
            yAxis: {
                minPadding: 0.2,
                maxPadding: 0.2,
                title: {
                    text: 'Trafico',
                    margin: 10
                }
            },
            series: [{
                name: 'TX: Transmición',
                data: []
            }, {
                name: 'RX: Recepción',
                data: []
            }]
        });

        function requestDatta() {
            var dispositivo =  $('#selec_area').find(":selected").data('objArea');
            var microtikId = $('#slec_dispositivo').find(":selected").val();

            if(dispositivo == null){ return false}
            $("#txt_interface").text(dispositivo.Interface);
            if(dispositivo.Interface == "") {return false;}

            $.ajax({
                type: "POST",
                url: '/getdata/' + dispositivo.Interface,
                data: {microtikId: microtikId},
                async: true,
                datatype: "json",
                success: function (data) {
                    var midata = JSON.parse(data);
                    TX = parseInt(midata[0].data);
                    RX = parseInt(midata[1].data);
                    var x = (new Date()).getTime();
                    shift = chart.series[0].data.length > 19;
                    chart.series[0].addPoint([x, TX], true, shift);
                    chart.series[1].addPoint([x, RX], true, shift);
                    //point.update(TX);
                    $('#tx_t').text(TX+' Mbps');
                    $('#rx_t').text(RX+' Mbps');
                },
                error: function (data) {
                    console.log('error');
                }
            });
        }

        $('#btn-reporte').on('click',function(){
            var dispositivoId =  $('#slec_dispositivo').find(":selected").val();
            if(dispositivoId == 0){
                notificacion("<b>Monitoreo de Redes</b> - Seleccione un Dispositivo Microtik",'info');
                return false
            }


            var mstr_fechaHasta = $('#text_fechaHasta').val();
            var mstr_fechaDesde = $('#text_fechaDesde').val();
            $('#ifr_reporte').html('');
            var html = '<iframe src="' + '{{url("/pagReporteReal")}}'+ '/' +dispositivoId+ '/' + mstr_fechaDesde.split('/').join('-') + '/' + mstr_fechaHasta.split('/').join('-') + '" height="600px" width="100%" frameborder="0" style="border: 0" allowfullscreen></iframe>';
            var tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;
            $('#ifr_reporte').append(tempDiv);
            //document.getElementById('ifr_reporte').location.reload();
            $('#mdlReporte').modal('show');
        });

        $('#actualizar').on('click',function(){
            var dispositivoId =  $('#slec_dispositivo').find(":selected").val();
            if(dispositivoId == 0){
                notificacion("<b>Monitoreo de Redes</b> - Seleccione un Dispositivo Microtik",'info');
                return false
            }
            var mstr_fechaHasta =  $('#text_fechaHasta').val();
            var mstr_fechaDesde = $('#text_fechaDesde').val();
            if(mstr_fechaHasta == "") {mstr_fechaHasta = " ";}
            if(mstr_fechaDesde == "") {mstr_fechaDesde = " ";}


            $('#ifr_reporte').html('');
            var html = '<iframe src="'+'{{url("/pagReporteReal")}}/'+dispositivoId+'/'+mstr_fechaDesde.split('/').join('-')+'/'+mstr_fechaHasta.split('/').join('-')+'" height="600px" width="100%" frameborder="0" style="border: 0" allowfullscreen></iframe>';
            var tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;
            $('#ifr_reporte').append(tempDiv);
            //document.getElementById('ifr_reporte').location.reload();
        });

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


    </script>

@endsection