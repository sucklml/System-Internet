@extends('layouts.app')

@section('head')
    <link rel="stylesheet" type="text/css" href="../../assets/css/fileinput.css" />
@endsection
@section('title')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Reporte -
                        <small>{{$data->Entidad["Nombre"]}}</small>
                    </h4>
                </div>
                <div class="card-content">
                    <button id="btnGenerar" style="float: right;" class="btn btn-primary btn-round">Genera Reporte</button>
                    <ul class="nav nav-pills nav-pills-warning">
                        @if($data->rolId == 1)
                        <li @if($data->Estado == 1)class="active" @endif>
                            <a href="{{url('/pagConsumoSolicitado/EstadoDoc/1')}}">Generado</a>
                        </li>
                        <li @if($data->Estado == 2)class="active" @endif>
                            <a href="{{url('/pagConsumoSolicitado/EstadoDoc/2')}}">En Proceso</a>
                        </li>
                        <li @if($data->Estado == 3)class="active" @endif>
                            <a href="{{url('/pagConsumoSolicitado/EstadoDoc/3')}}">Validados</a>
                        </li>
                        @endif
                            @if($data->rolId == 2)
                                <li @if($data->Estado == 1)class="active" @endif>
                                    <a href="{{url('/pagConsumoSolicitado/EstadoDoc/1')}}">Generado</a>
                                </li>
                            @endif
                            @if($data->rolId == 3)
                                <li @if($data->Estado == 2)class="active" @endif>
                                    <a href="{{url('/pagConsumoSolicitado/EstadoDoc/2')}}">En Proceso</a>
                                </li>
                            @endif
                            @if($data->rolId == 4)
                                <li @if($data->Estado == 3)class="active" @endif>
                                    <a href="{{url('/pagConsumoSolicitado/EstadoDoc/3')}}">Validados</a>
                                </li>
                            @endif

                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active">
                            <div class="row">
                                <form name="formReporte" class="content" method="POST" role="form" action="{{url('/pagConsumoSolicitado/Search')}}">
                                    <div class="col-sm-3">
                                        <select id="sel_contrato" name="sel_contrato" class="selectpicker" data-live-search="true" data-style="btn btn-primary" title="Selecionar Contrato">
                                            <option value="0">Selecionar Contrato</option>
                                            @foreach($data->Entidad["contrato"] as $itemContrato)
                                                <option value="{{$itemContrato->idCONTRATO}}">{{$itemContrato->Descripcion}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Fecha de Referencia</label>
                                            <input  name ="text_fechaDesde" type="text" class="form-control datepickerRef" value="{{$data->Text_FecRef}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-3" style="height:50px;">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn bgm-indigo btn-float waves-effect waves-button"><i class="md md-search"></i><div class="ripple-container"></div></button>
                                    </div>
                                </form>
                                <div class="col-sm-12">
                                    <br>
                                    <div class="table-responsive">
                                        <table id="tblConsultaSolicitado" class="table table-jse">
                                        <thead class="bgm-indigo">
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Contrato</th>
                                            <th class="text-center">Fecha Referencia</th>
                                            <th class="text-center">Cantidad</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data->Entidad->Documentos as $i => $itemDocumento)
                                            <tr>
                                                <td width="3%"class="text-center">{{$i+1}}</td>
                                                <td>{{$itemDocumento->contrato["Descripcion"]}}</td>
                                                <td class="text-center" style="font-size: 15px;">{{$itemDocumento->FechaRef}}</td>
                                                <td class="text-center" style="font-size: 15px;">{{$itemDocumento->Cantidad}}</td>
                                                <td class="text-right card-link btn-colapcin"><i class="ico-colapcin md md-keyboard-arrow-up md-lg" style="font-size: 2em;vertical-align: -50%;"></i></td>
                                            </tr>
                                            <tr class="colapcin table-colapcin panel">
                                                <td></td>
                                                <td colspan="4">
                                                    <div class="table-responsive">
                                                        <table class="table table-jse">
                                                            <tbody>
                                                            @foreach($itemDocumento->detalle as $j => $itemDetalle)
                                                                @if($itemDetalle->EstadoDoc == 3)
                                                                    <tr>
                                                                        <td class="text-center">{{$j+1}}</td>
                                                                        <td>
                                                                            <ul style="list-style: none; display: inline-block;">
                                                                                <li><small>Creado el</small></li>
                                                                                <li>{{\Carbon\Carbon::parse($itemDetalle->Fecha)->format('d/m/Y h:i:s A')}}</li>
                                                                                <li><small>por </small>{{$itemDetalle->usuario["Usuario"]}}</li>
                                                                            </ul>
                                                                            <ul style="list-style: none; display: inline-block;">
                                                                                <li><small>Perio del </small> 01/05/2017</li>
                                                                                <li><small>al </small> 28/05/2017</li>
                                                                            </ul>
                                                                        </td>
                                                                        <td>
                                                                            <ul class="actions">
                                                                                <li><small>Prueba: </small></li>
                                                                                @if(count(explode('/',$itemDetalle->TypePrue))>1)
                                                                                <li class="text-center"><a type="button" rel="tooltip" download="{{$itemDocumento->contrato["Descripcion"].'-Documento-Prueba.'.explode('/',$itemDetalle->TypePrue)[1]}}" href="{{'data:'.$itemDetalle->TypePrue.';base64,'.$itemDetalle->DocPrueba}}"><i class="md md-file-download md-lg"></i></a></li>
                                                                                @endif
                                                                            </ul>
                                                                        </td>
                                                                        <td class="td-actions text-right">
                                                                            <ul class="actions">
                                                                                <li>Simple :</li>
                                                                                <li class="text-center"><a class="btn-verDoc" data-tipo="2" data-iddocumento="{{$itemDetalle->idDocumentos}}"><i class="md md-visibility md-lg"></i></a></li>
                                                                                <a type="button" rel="tooltip" download="{{$itemDocumento->contrato["Descripcion"].'-'.$itemDetalle->Fecha.'.pdf'}}" href="{{'data:'.$itemDetalle->TypeDocum.';base64,'.$itemDetalle->DocumentoSimple}}"><i class="md md-file-download md-lg"></i></a>
                                                                            </ul>
                                                                        </td>
                                                                        <td class="td-actions text-right">
                                                                            <ul class="actions">
                                                                                <li>Detallado :</li>
                                                                                <li class="text-center"><a class="btn-verDoc" data-tipo="1" data-iddocumento="{{$itemDetalle->idDocumentos}}"><i class="md md-visibility md-lg"></i></a></li>
                                                                                <li class="text-center">
                                                                                    <a type="button" rel="tooltip" download="{{$itemDocumento->contrato["Descripcion"].'-'.$itemDetalle->Fecha.'.pdf'}}" href="{{'data:'.$itemDetalle->TypeDocum.';base64,'.$itemDetalle->Documento}}"><i class="md md-file-download md-lg"></i></a>
                                                                                </li>
                                                                            </ul>
                                                                        </td>
                                                                        <td width="3%" class="td-actions text-right">
                                                                            <ul class="actions">
                                                                                <li>
                                                                                    <a class="btn-restore" href="{{url("/pagConsumoSolicitado/ExtornarDoc/".$itemDetalle->idDocumentos)}}"><i class="md md-settings-backup-restore md-lg"></i></a>
                                                                                </li>
                                                                            </ul>
                                                                        </td>
                                                                    </tr>
                                                                @elseif($itemDetalle->EstadoDoc == 2)
                                                                    <tr>
                                                                        <td class="text-center">{{$j+1}}</td>
                                                                        <td>
                                                                            <ul style="list-style: none; display: inline-block;">
                                                                                <li><small>Creado el</small></li>
                                                                                <li>{{\Carbon\Carbon::parse($itemDetalle->Fecha)->format('d/m/Y h:i:s A')}}</li>
                                                                                <li><small>por </small>{{$itemDetalle->usuario["Usuario"]}}</li>
                                                                            </ul>
                                                                            <ul style="list-style: none; display: inline-block;">
                                                                                <li><small>Desde:</small> 01/05/2017</li>
                                                                                <li><small>Hasta:</small> 28/05/2017</li>
                                                                            </ul>
                                                                        </td>
                                                                        <td>
                                                                            <ul class="actions">
                                                                                <li>Prueba :</li>
                                                                                <li class="text-center">
                                                                                    <button style="padding: 6px;" class="btn btn-simple btn-behance btn-file" data-id="{{$itemDetalle->idDocumentos}}">
                                                                                        <i class="md md-attach-file md-lg"></i>Añadir
                                                                                    </button>
                                                                                </li>
                                                                            </ul>
                                                                        </td>
                                                                        <td class="td-actions text-right">
                                                                            <ul class="actions">
                                                                                <li>Simple :</li>
                                                                                <li class="text-center"><a class="btn-verDoc" data-tipo="2" data-iddocumento="{{$itemDetalle->idDocumentos}}"><i class="md md-visibility md-lg"></i></a></li>
                                                                                <a type="button" rel="tooltip" download="{{$itemDocumento->contrato["Descripcion"].'-'.$itemDetalle->Fecha.'.pdf'}}" href="{{'data:'.$itemDetalle->TypeDocum.';base64,'.$itemDetalle->DocumentoSimple}}"><i class="md md-file-download md-lg"></i></a>
                                                                            </ul>
                                                                        </td>
                                                                        <td class="td-actions text-right">
                                                                            <ul class="actions">
                                                                                <li>Detallado :</li>
                                                                                <li class="text-center"><a class="btn-verDoc" data-tipo="1" data-iddocumento="{{$itemDetalle->idDocumentos}}"><i class="md md-visibility md-lg"></i></a></li>
                                                                                <li class="text-center">
                                                                                    <a type="button" rel="tooltip" download="{{$itemDocumento->contrato["Descripcion"].'-'.$itemDetalle->Fecha.'.pdf'}}" href="{{'data:'.$itemDetalle->TypeDocum.';base64,'.$itemDetalle->Documento}}"><i class="md md-file-download md-lg"></i></a>
                                                                                </li>
                                                                            </ul>
                                                                        </td>
                                                                        <td width="3%" class="td-actions text-right">
                                                                            <ul class="actions">
                                                                                <li>
                                                                                    <a class="btn-restore" href="{{url("/pagConsumoSolicitado/ExtornarDoc/".$itemDetalle->idDocumentos)}}"><i class="md md-settings-backup-restore md-lg"></i></a>
                                                                                </li>
                                                                            </ul>
                                                                        </td>
                                                                    </tr>
                                                                @elseif($itemDetalle->EstadoDoc == 1)
                                                                    <tr>
                                                                        <td class="text-center">{{$j+1}}</td>
                                                                        <td>
                                                                            <ul style="list-style: none; display: inline-block;">
                                                                                <li><small>Creado el</small></li>
                                                                                <li>{{\Carbon\Carbon::parse($itemDetalle->Fecha)->format('d/m/Y h:i:s A')}}</li>
                                                                                <li><small>por </small>{{$itemDetalle->usuario["Usuario"]}}</li>
                                                                            </ul>
                                                                            <ul style="list-style: none; display: inline-block;">
                                                                                <li><small>Desde:</small> {{\Carbon\Carbon::parse($itemDetalle->FechaDesde)->format('d/m/Y')}}</li>
                                                                                <li><small>Hasta:</small> {{\Carbon\Carbon::parse($itemDetalle->FechaHasta)->format('d/m/Y')}}</li>
                                                                            </ul>
                                                                        </td>
                                                                        <td>
                                                                            <ul class="actions">
                                                                                <li>Validar: </li>
                                                                                <li class="text-center">
                                                                                    <a class="btn-AceptarDoc" href="{{url("/pagConsumoSolicitado/AceptarDoc/".$itemDetalle->idDocumentos)}}">
                                                                                        <i class="md md-thumb-up md-lg"></i>
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </td>
                                                                        <td class="td-actions text-right">
                                                                            <ul class="actions">
                                                                                <li>Simple :</li>
                                                                                <li class="text-center"><a class="btn-verDoc" data-tipo="2" data-iddocumento="{{$itemDetalle->idDocumentos}}"><i class="md md-visibility md-lg"></i></a></li>
                                                                            </ul>
                                                                        </td>
                                                                        <td class="td-actions text-right">
                                                                            <ul class="actions">
                                                                                <li>Detallado :</li>
                                                                                <li class="text-center"><a class="btn-verDoc" data-tipo="1" data-iddocumento="{{$itemDetalle->idDocumentos}}"><i class="md md-visibility md-lg"></i></a></li>
                                                                            </ul>
                                                                        </td>
                                                                        <td width="3%" class="td-actions text-right">
                                                                            <ul class="actions">
                                                                                <li>
                                                                                    <a href="{{url("/pagConsumoSolicitado/EliminarDoc/".$itemDetalle->idDocumentos)}}" class="btn-delete"><i class="md md-delete md-lg"></i></a>
                                                                                </li>
                                                                            </ul>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="mdladdFile" data-keyboard="false" data-backdrop="static" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close btn-close" data-dismiss="modal" aria-hidden="true">
                        <i class="md md-clear"></i>
                    </button>
                    <h4 class="modal-title">Añadir</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <input id="images" name="images" type="file" multiple=false class="file-loading" >
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple btn-close" data-dismiss="modal">Atras</button>
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
                    <div class="table-responsive" id="ifr_reporte">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Atras</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="mdlGenerar" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="md md-clear"></i>
                    </button>
                    <h4 class="modal-title">Generar Reporte -</h4>
                    <small>&nbsp;&nbsp;&nbsp;de todos los contratos.</small>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Fecha de Desde</label>
                                <input  id ="text_fechaDesde" type="text" class="form-control datepicker">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Fecha de Hasta</label>
                                <input  id ="text_fechaHasta" type="text" class="form-control datepicker">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btnGenerarAllDoc" type="button" class="btn btn-primary btn-simple" data-dismiss="modal">Generar</button>
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Atras</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="../../assets/js/fileinput.js"></script>
    <script src="../../assets/js/jquery.webui-popover.js"></script>
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            f_actualizarSelContrato();

            function f_actualizarSelContrato(){
                $('#sel_contrato').val({{$data->Sel_idContrato}});
                $('#sel_contrato').selectpicker('render');
                $('#sel_contrato').selectpicker('refresh');
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

            $('.btn-AceptarDoc').on('click',function(){
                notificacion("<b>Monitoreo de Redes</b> - Este proceso podría tomar algunos minutos.",'info');
            });

            $('#tblConsultaSolicitado').on('click','.btn-colapcin',function(){
                var mele_btn = $(this).find('.ico-colapcin');
                var mele_Card = $(this).parents('.card-header').siblings('div .colapcin');
                var mstr_Card = 'card';
                if(!mele_Card.hasClass('colapcin')){
                    //mele_Card = $(this).parent().siblings('.colapcin');
                    mint_posion = $(this).parent().index();
                    mele_Card = $(this).parent().parent().children('tr').eq(mint_posion+1);
                    mstr_Card = 'table';
                }

                if(mele_btn.hasClass('md-keyboard-arrow-up')){
                    mele_Card.removeClass(mstr_Card+'-colapcin');
                    mele_Card.addClass(mstr_Card+'-colapcin-off');
                    mele_btn.removeClass('md-keyboard-arrow-up');
                    mele_btn.addClass('md-keyboard-arrow-down');
                    if(mstr_Card == 'card')
                    {
                        flst_AreasContrato($(this).data('value'),this);
                    }

                }else{
                    mele_Card.addClass(mstr_Card+'-colapcin');
                    mele_Card.removeClass(mstr_Card+'-colapcin-off');
                    mele_btn.addClass('md-keyboard-arrow-up');
                    mele_btn.removeClass('md-keyboard-arrow-down');
                }

            });

            $('.btn-verDoc').on('click',function(){
                var mint_iddocumento =$(this).data('iddocumento');
                var mint_tipo =$(this).data('tipo');
                $('#ifr_reporte').html('');
                var html = '<iframe src="'+'{{url("/pagConsumoSolicitado/VerGenerado")}}/'+mint_iddocumento + '/'+mint_tipo+'" height="600px" width="100%" frameborder="0" style="border: 0" allowfullscreen></iframe>';
                var tempDiv = document.createElement('div');
                tempDiv.innerHTML = html;
                $('#ifr_reporte').append(tempDiv);
                //document.getElementById('ifr_reporte').location.reload();
                $('#mdlReporte').modal('show');
            });

            $('#tblConsultaSolicitado').on('click','.btn-file',function(){
                var mint_DocumentoId = $(this).data('id');
                $("#mdladdFile").modal('show');
                $("#images").fileinput({
                    uploadUrl: "/pagConsumoSolicitado/subirPdf", // server upload action
                    uploadAsync: false,
                    maxFileCount: 1,
                    uploadExtraData: {mint_DocumentoId:mint_DocumentoId},
                }).on('filebatchpreupload', function(event, data, id, index) {
                    console.log('en proceso');
                    notificacion("<b>Monitoreo de Redes</b> - Este proceso podría tomar algunos minutos.",'info');
                }).on('filebatchuploadsuccess', function(event, data, id, index) {
                    console.log('envio',data);
                    notificacion("<b>Monitoreo de Redes</b> - Exito al subir el archivo.",'success');
                    location.reload();
                }).on('filebatchuploaderror', function(event, data, id, index) {
                    console.log('error',event)
                    notificacion("<b>Monitoreo de Redes</b> - Error al subir el archivo.",'warning');
                });
            });




            $('#btnGenerar').on('click',function(){
                $('#mdlGenerar').modal('show');
            });

            $('#btnGenerarAllDoc').on('click',function(){
                notificacion("<b>Monitoreo de Redes</b> - Este proceso podría tomar algunos minutos.",'info');
                var mstr_fechaDesde = $('#text_fechaDesde').val();
                var mstr_fechaHasta =$('#text_fechaHasta').val();
                $.ajax({
                    type: "POST",
                    url: '{{url("/pagConsumoSolicitado/guardarPdf")}}',
                    data: {fechaDesde: mstr_fechaDesde, fechaHasta: mstr_fechaHasta},
                    //dataType: 'json',
                    error: function (data, status) {
                        alert('Error');
                    },
                    success: function (data) {
                        console.log('data',data);
                        if(data == true)
                        {
                            notificacion("<b>Monitoreo de Redes</b> - Exito al generar los Reportes.",'success');
                            location.reload();
                        }
                        else
                        {
                            notificacion("<b>Monitoreo de Redes</b> - Error al generar los Reportes.",'warning');
                        }
                    }
                });
            });

        });
        $('.datepickerRef').on('click',function(){
            var input = $(this);
            if(input.val()!='')
            {
                input.parent().removeClass('is-empty');
            }
        });

        $('.datepickerRef').datetimepicker({
            format: 'MM/YYYY',
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