@extends('layouts.app')

@section('title')
    <a class="navbar-brand" href="#"> Provedor </a>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12" id="cardPrincipal">
            <div class="card">
                <div id="btnAddProveedor" class="btn card-header card-header-icon bgm-indigo" data-background-color="">
                    <i class="md md-account-balance md-2x"></i>
                </div>
                <br>
                <br>
                <div class="card-content">
                    <div class="table-responsive">
                        <table class="table" id="tblProveedor">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Nombre</th>
                                <th>User</th>
                                <th>Pasword</th>
                                <th>Telefono</th>
                                <th class="text-center">Url</th>
                                <th class="text-right"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data->Usuario as $i=>$itemUser)
                                <tr>
                                    <td class="text-center">{{$i+1}}</td>
                                    <td>{{$itemUser->Nombre}}</td>
                                    <td>{{$itemUser->Usuario}}</td>
                                    <td>{{$itemUser->password}}</td>
                                    <td>{{$itemUser->Telefono}}</td>

                                    <td class="td-actions text-right">
                                        <button type="button" rel="tooltip" class="btn btn-success btn-round btn-edit" data-value="15" data-original-title="" title="">
                                            <i class="md md-edit md-lg"></i>
                                        </button>
                                        <a href="/pagUsuario/Eliminar/{{$itemUser->idUSUARIO}}" type="button" rel="tooltip" class="btn btn-danger btn-round" data-original-title="" title="">
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
        <div class="col-md-12" style="display: none;" id="cardAddProveedor">
            <form class="card modal-content" method="POST" role="form" action="{{url('/pagUsuario/crearUsuario')}}">
                <div class="card-header card-header-icon bgm-indigo" data-background-color="">
                    <i class="md md-add md-2x"></i>
                </div>
                <div class="card-content">
                    <h4 class="card-title">Registro Usuario</h4>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">Nombre</label>
                                    <input name="nombre" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group label-floating">
                                    <label class="control-label">Apellido</label>
                                    <input name="apellido" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">Telefono</label>
                                    <input name="tel" type="number" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">Direccion</label>
                                    <input name="direc" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">Usuario</label>
                                    <input name="user" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">Password</label>
                                    <input name="pass" type="password" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">E.mail</label>
                                    <input name="email" type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="padding-top:0;">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" class="btn btn-primary btn-simple" style="color:#FFFFff;">Guardar</button>
                    <button type="button" class="btn btn-danger btn-simple"  id="btnSalirAddProveedor">Atras</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){

            $("#btnAddProveedor").on('mouseover',function(){
                var mele_icono = $(this).find('i');
                mele_icono.removeClass('md-account-balance');
                mele_icono.addClass('md-add');
            });
            $("#btnAddProveedor").on('mouseout',function(){
                var mele_icono = $(this).find('i');
                mele_icono.addClass('md-account-balance');
                mele_icono.removeClass('md-add');
            });

            $("#btnAddProveedor").on('click',function(){
                $('#cardPrincipal').hide();
                $('#cardAddProveedor').show();
            });

            $("#btnSalirAddProveedor").on('click',function(){
                $('#cardPrincipal').show();
                $('#cardAddProveedor').hide();
            });

            $('#tblProveedor').on('click',".btn-edit",function(){
                var mintProveedor = $(this).data('value');
                console.log('Idproveedor',mintProveedor);
                $('#cardPrincipal').hide();
                $('#cardAddProveedor').show();
            });



        });
    </script>
@endsection