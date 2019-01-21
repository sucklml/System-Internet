@extends('layouts.app')

@section('title')
    <a class="navbar-brand" href="#"> Contrato </a>
@endsection

@section('extra')
<button  class="btn bgm-teal btn-float waves-effect waves-button waves-float" id="btnAgregarContrato"><i class="md md-add"></i></button>
@endsection

@section('content')
    <div class="row" id="cardListcontrato">
        @foreach($data->Contratos as $itemContrato)
        <div class="col-lg-3 col-sm-4">
            <div class="card card-pricing card-raised">
                <form name="formContrato" class="content" method="POST" role="form" action="{{url('/pagContrato/asignarAreaContrato')}}">
                    <ul class="actions" style="margin:0;">
                        <li style="padding:0;">
                            <p class="category">{{$itemContrato->Descripcion}}</p>
                        </li>
                        <li>
                            <ul class="actions" style="position: relative; top:-5px; right: -15px;margin:0;">
                                <li class="dropdown" style="padding: 0">
                                    <a href="" data-toggle="dropdown" aria-expanded="false">
                                        <i class="md md-more-vert" style="top:0;"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-right" style="margin:0;">
                                        <li style="padding: 2px;">
                                            <a><i  class="md md-edit btn-edit"></i>&nbsp; Editar</a>
                                        </li>
                                        <li style="padding: 2px;">
                                            <a class="btn-eliminar" data-id="{{$itemContrato->idCONTRATO}}"><i class="md md-delete"></i>&nbsp;Anular</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <?php $varr_iconocolor = array("icon-rose","icon-primary","icon-success","icon-info","icon-warning","icon-danger"); ?>
                    <div class="icon {{$varr_iconocolor[array_rand($varr_iconocolor)]}}">
                        <i class="md md-home md-lg"></i>
                    </div>
                    <h6 class="category" style="color: #3c4858;">Asignados</h6>
                    <h3 class="card-title" style="margin-top: 0;">{{$itemContrato->Velocidad_Mb}} <small>Mbts/</small>{{count($itemContrato->areas)}} <small>Areas</small></h3>
                    <p class="card-description">
                        Contrato hecho {{Carbon\Carbon::parse($itemContrato->Fech_Emision)->format('d/m/Y')}}
                        hasta {{Carbon\Carbon::parse($itemContrato->Fech_Vencimiento )->format('d/m/Y')}}.
                    </p>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"><!-- Esta etique se debe poner en todos los formulario para la validacion -->
                    <input type="hidden" name="_contratoid" value="{{$itemContrato->idCONTRATO}}"><!-- Este valor se de pintar dependiendo de los contratos que tiene el cliente, medinate java scrip o en el servidor -->
                    <button type="submit" class="btn btn-rose btn-round bgm-indigo">Areas Asignadas</button>
                </form>
            </div>
            </div>
        @endforeach
    </div>
    <div class="row" id="cardAgregarProveedor" style="display: none;">
        <div class="col-md-12" >
            <div class="card modal-content" >
                <div class="card-header card-header-icon" data-background-color="rose">
                    <i class="md md-add md-2x"></i>
                </div>
                <div class="card-content">
                    <h4 class="card-title">Crear Contrato</h4>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">Titulo</label>
                                    <input id ="text_Titulo" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">Numero de Recibo</label>
                                    <input id ="text_NumRecivo" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">Cod. Contrato</label>
                                    <input id ="text_CodContrato" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">Fecha de Emision</label>
                                    <input  id ="text_fechaEmision" type="text" class="form-control datepicker">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">Fecha de Vencimiento</label>
                                    <input id ="text_fechaVencimiento" type="text" class="form-control datepicker">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" style="position: absolute; top:-29px;">Proveedor</label>
                                    <select  id="sel_Proveedor" class="selectpicker" data-live-search="true" data-style="btn btn-primary" title="Seleccione" data-size="7" style="top:-7px;">
                                    @foreach($data->Proveedores as $itemProveedor)
                                        <option value="{{$itemProveedor->idProveedor}}">{{$itemProveedor->Nom_Empresa}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <button id="btnAgregarDetContrato" class="btn btn-primary btn-round btn-fab btn-fab-mini" style="line-height: 7px; display: inline-block">
                                    <i class="md md-add"></i>
                                </button>
                                <h4 class="card-title" style="display: inline-block;">Detalle</h4>
                                <div class="table-responsive">
                                    <table id="tbldetalle" class="table table-hover table-jse">
                                        <thead class="bgm-indigo">
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Servico</th>
                                                <th>CD/Req</th>
                                                <th class="text-center">Cantidad Mbts</th>
                                                <th>Oficina</th>
                                                <th class="text-center">Importe</th>
                                                <th class="text-right"></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="3" class="td-total text-center">Cantidad Total</td>
                                            <td class="text-center totalCant_Mbts">0.00</td>
                                            <td class="td-total text-center">SubTotal</td>
                                            <td class="text-right subtotalimporte">0.00</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="td-total text-center">IGV</td>
                                            <td class="text-right totaligv">0.00</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="td-total text-center">Total</td>
                                            <td class="text-right totalimporte">0.00</td>
                                            <td></td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="padding-top: 0;">
                    <button type="button" id="btn-Guardar" class="btn btn-primary btn-simple">Guardar</button>
                    <button type="button" class="btn btn-danger btn-simple" id="btnAtrasContrato">Atras</button>
                </div>
            </div>
        </div>

    </div>
    <!--Modal agregar contrato detalle -->
    <div class="modal fade" id="mdlAgregarDetContrato" data-keyboard="false" data-backdrop="static" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="md md-clear"></i>
                    </button>
                    <h4 class="modal-title">Agregar Detalle Contrato</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group label-floating">
                                <label class="control-label">Servicio</label>
                                <input id="text_Servicio" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group label-floating">
                                <label class="control-label">CD/Req</label>
                                <input id="text_Cdrq" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group label-floating">
                                <label class="control-label">Oficina</label>
                                <input id="text_Oficina" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group label-floating">
                                <label class="control-label">Cantida Mbts</label>
                                <input id="text_CantMbts" value="0.00" type="number" min="0" step="0.01" class="form-control" style="text-align: center;">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group label-floating">
                                <label class="control-label">Importe</label>
                                <input id="text_Importe"  value="0.00" type="number" min="0" step="0.01" class="form-control" style="text-align: center;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-simple" data-dismiss="modal" id="btnCrearDetalle">Guardar</button>
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Atras</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('input[name="_token"]').val($('meta[name="csrf-token"]').attr('content'));

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            <!-- Sirve para la validacion del laravel asi los formulario -->
            $('#btnAgregarDetContrato').on('click',function(){
                $('#mdlAgregarDetContrato').modal('show');
            });

            $('#btnAgregarContrato').on('click',function(){
                $('#cardListcontrato').hide();
                $('#btnAgregarContrato').hide();
                $('#cardAgregarProveedor').show();
            });

            $('#btnAtrasContrato').on('click',function(){
                $('#cardListcontrato').show();
                $('#btnAgregarContrato').show();
                $('#cardAgregarProveedor').hide();
            });

           $('#btnCrearDetalle').on('click',function(){
               var mint_CantMbts = $('#text_CantMbts').val();
               var mint_Importe = $('#text_Importe').val();
               var mstr_Oficina = $('#text_Oficina').val();
               var mint_Cdrq = $('#text_Cdrq').val();
               var mstr_Servicio = $('#text_Servicio').val();
               f_agregarDetContrato(mstr_Servicio, mint_CantMbts, mint_Importe, mint_Cdrq, mstr_Oficina);
              $('#text_CantMbts').val('0.00');
              $('#text_Importe').val('0.00');
              $('#text_Oficina').val('');
              $('#text_Cdrq').val('');
              $('#text_Servicio').val('');

           });

            function f_agregarDetContrato(vstr_Servicio, vint_CantMbts, vint_Importe, vstr_Cdrq ,vstr_Oficina)
            {

                var obj_detContrato = {
                        'Servicio': vstr_Servicio,
                        'CD_Req': vstr_Cdrq,
                        'Oficina': vstr_Oficina,
                        'Velocidad': parseFloat(vint_CantMbts).toFixed(2),
                        'Importe': parseFloat(vint_Importe).toFixed(2),
                    };

                var html =
                        "<tr data-value='"+JSON.stringify(obj_detContrato)+"' >"+
                        '<td class="text-center"></td>'+
                        '<td>'+vstr_Servicio+'</td>'+
                        '<td>'+vstr_Cdrq+'</td>'+
                        '<td class="text-center cant-mbts">'+roundtwo(vint_CantMbts)+'</td>'+
                        '<td>'+vstr_Oficina+'</td>'+
                        '<td class="text-right importe">'+parseFloat(vint_Importe).toFixed(2)+'</td>'+
                        '<td class="td-actions text-right">'+
                        '<button type="button" rel="tooltip" class="btn btn-danger btn-round btn-removeDet" data-original-title="" title="">'+
                        '<i class="md md-delete md-lg"></i>'+
                        '</button>'+
                        '</td>'+
                        '</tr>';
                $('#tbldetalle tbody').append(html);

                $('.btn-removeDet').on('click',function(){
                    $(this).parents('tr').remove();
                    sumar();
                });
                sumar();
            }

            function sumar(){

                var count = 0;
                var totalcant_Mbts = 0;
                var subtotalimporte_Mbts = 0;

                $('#tbldetalle tbody tr').each(function(){
                    count++;
                    $(this).find('td').eq(0).text(count);
                    totalcant_Mbts += roundtwo($(this).find('.cant-mbts').text());
                    subtotalimporte_Mbts += roundtwo($(this).find('.importe').text());
                });
                totalcant_Mbts = parseFloat(totalcant_Mbts).toFixed(2);
                subtotalimporte_Mbts = parseFloat(subtotalimporte_Mbts).toFixed(2);
                var totalIgv = parseFloat(subtotalimporte_Mbts *0.18).toFixed(2);
                var totalimporte_Mbts = parseFloat(roundtwo(totalIgv) + roundtwo(subtotalimporte_Mbts)).toFixed(2);

                $('.totalCant_Mbts').text(roundtwo(totalcant_Mbts));
                $('.subtotalimporte').text(subtotalimporte_Mbts);
                $('.totaligv').text(totalIgv);
                $('.totalimporte').text(totalimporte_Mbts);
            }

            function roundtwo(num){
                return +(Math.round(num +"e+2") +"e-2");
            }

            $('#btn-Guardar').on('click',function(){

                var mobj_contrato = [{
                    "Fech_Emision": $('#text_fechaEmision').val(),
                    "Fech_Vencimiento": $('#text_fechaVencimiento').val(),
                    "Num_Recibo": $('#text_NumRecivo').val(),
                    "Velocidad_Mb": $('.totalCant_Mbts').text(),
                    "Importe": $('.totalimporte').text(),
                    "idProveedor": $('#sel_Proveedor').val(),
                    "Cod_Contrato": $('#text_CodContrato').val(),
                    "Descripcion": $('#text_Titulo').val(),

                },];

                var detalle = [];

                $('#tbldetalle tbody tr').each(function(){
                    var mobj_detalle = $(this).data('value');
                    detalle.push(mobj_detalle);
                });


                mobj_contrato[0]["detalle"] = detalle;

                $.ajax({
                    type: "POST",
                    url: '{{url("/pagContrato/CrearContrato")}}',
                    data: {Contrato: JSON.stringify(mobj_contrato)},
                    dataType: 'json',
                    error: function (data, status) {
                        alert('Error');
                    },
                    success: function (data) {
                        console.log('data', data);
                        location.reload();
                    }
                });
            });

            $('.datepicker').on('click',function(){
                var input = $(this);
                if(input.val()!='')
                {
                    input.parent().removeClass('is-empty');
                }
            });

            $('.datepicker').datetimepicker({
                format: 'YYYY-MM-DD',
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
            $('.btn-eliminar').on('click',function(){

                var mint_contratoId = $(this).data('id');
                swal({
                    title:"¿Está seguro de eliminar?",
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#9c27b0",
                    confirmButtonText: "SI",
                    cancelButtonText: "NO"})
                        .then(function () {
                            f_Eliminar(mint_contratoId);
                        });

            });

            function f_Eliminar(vint_contratoId){

                $.ajax({
                    type: "POST",
                    url: '{{url("/pagContrato/Eliminar")}}',
                    data: {idContrato: vint_contratoId},
                    dataType: 'json',
                    error: function (data, status) {
                        alert('Error');
                    },
                    success: function (data) {
                        //console.log('data', data);
                        //
                        if(data ==  true)
                        {
                            notificacion("<b>Monitoreo de Redes</b> - Exito al eliminar la Contrato!",'success');
                            location.reload();
                        }else{
                            notificacion("<b>Monitoreo de Redes</b> - Error al eliminar el Contrato!",'warning');
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


        });

    </script>
@endsection