@extends('layouts.app')

@section('title')
    <a class="navbar-brand" href="#"> Mikrotik </a>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12" id="cardPrincipal">
            <div class="card">
                <div id="btnAddMikrotik" class="btn card-header card-header-icon bgm-indigo" data-background-color="">
                    <i class="md md-account-balance md-2x"></i>
                </div>
                <br>
                <br>
                <div class="card-content">
                    <div class="table-responsive">
                        <table class="table" id="tblMikrotik">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Nombre</th>
                                <th>IP</th>
                                <th>Puerto</th>
                                <th>User</th>
                                <th>Password</th>
                                <th class="text-center">Url</th>
                                <th class="text-right"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data->Dispositivo as $i=>$itemMikrotik)
                                <tr>
                                    <td class="text-center">{{$i+1}}</td>
                                    <td>{{$itemMikrotik->Nombre}}</td>
                                    <td>{{$itemMikrotik->Ip}}</td>
                                    <td>{{$itemMikrotik->Puerto}}</td>
                                    <td>{{$itemMikrotik->User}}</td>
                                    <td>{{$itemMikrotik->Password}}</td>
                                    <td class="td-actions text-right">

                                        <button id="{{$itemMikrotik->idDispositivo}}" class="btn btn-success btn-round btn-edit edit-disp" data-background-color="">
                                            <i class="md md-edit md-lg"></i>
                                        </button>
                                        <a href="/pagMikrotik/Eliminar/{{$itemMikrotik->idDispositivo}}" type="button" rel="tooltip" class="btn btn-danger btn-round" data-original-title="" title="">
                                            <i class="md md-delete md-lg"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12" style="display: none;" id="cardAddMikrotik">
            <form class="card modal-content" method="POST" role="form" action="{{url('/pagMikrotik/crearDispositivo')}}">
                <div class="card-header card-header-icon bgm-indigo" data-background-color="">
                    <i class="md md-add md-2x"></i>
                </div>
                <div class="card-content">
                    <h4 class="card-title">Registro Mikrotik</h4>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">Nombre</label>
                                    <input name="nombre" id="Nombre" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group label-floating">
                                    <label class="control-label">IP</label>
                                    <input name="ip" id="Ip" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">Puerto</label>
                                    <input name="puerto" id="Puerto" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">User</label>
                                    <input name="user" id="User" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">Password</label>
                                    <input name="password" id="Pass" type="Password" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="padding-top:0;">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" class="btn btn-primary btn-simple" style="color:#FFFFff;">Guardar</button>
                    <button type="button" class="btn btn-danger btn-simple"  id="btnSalirAddMikrotik">Atras</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){

            $("#btnAddMikrotik").on('mouseover',function(){
                var mele_icono = $(this).find('i');
                mele_icono.removeClass('md-account-balance');
                mele_icono.addClass('md-add');
            });
            $("#btnAddMikrotik").on('mouseout',function(){
                var mele_icono = $(this).find('i');
                mele_icono.addClass('md-account-balance');
                mele_icono.removeClass('md-add');
            });

            $("#btnAddMikrotik").on('click',function(){
                $('#cardPrincipal').hide();
                $('#cardAddMikrotik').show();
            });

            $("#btnSalirAddMikrotik").on('click',function(){
                $('#cardPrincipal').show();
                $('#cardAddMikrotik').hide();
            });

            $('#tblMikrotik').on('click',".btn-edit",function(){
                var mintProveedor = $(this).attr("id");
                console.log('Idmikrotik',mintProveedor);
                flst_editardiapo(mintProveedor);
                $('#cardPrincipal').hide();
                $('#cardAddMikrotik').show();
            });
            function flst_editardiapo(id){
            var sData = "{idDispositivo:"+id+"}";
            var sUrl ="/pagMikrotik/Editar/";
            console.log(sData);
            $.ajax({
            type: "POST",
            url: sUrl,
            data: sData,
            async: false, //comentar este async
            dataType: "json",
            error: function (data) {
                console.log("error");
               // swal(mstr_Error);
            },
            success: function (resp) {
                var registros = resp;
                var html = "";
                console.log(resp);
                 $("#Nombre").val(registros.Nombre);
                    $("#Ip").val(registros.Ip);
                    $("#Puerto").val(registros.Puerto);
                    $("#User").val(registros.User);
                    $("#Pass").val(registros.Password);
                }
            });


            }
        });



    </script>
@endsection