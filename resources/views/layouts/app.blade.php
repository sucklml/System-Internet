<!doctype html>
<html lang="es">


<!-- Mirrored from demos.creative-tim.com/material-dashboard-pro/examples/forms/extended.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 11 Apr 2017 03:10:04 GMT -->
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" type="image/x-icon" sizes="76x76" href="{{url('/assets/img/Team_liquid.ico')}}" />
    <link rel="icon" type="image/x-icon" href="{{url('/assets/img/Team_liquid.ico?v=2')}}'" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>MR by  Team Liquid</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <!-- Bootstrap core CSS     -->
    <link href="{{url('/assets/css/bootstrap.min.css')}}" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href="{{url('/assets/css/material-dashboard.css')}}" rel="stylesheet" />
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="{{url('/assets/css/demo.css')}}" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="{{url('/assets/css/font-awesome.css')}}" rel="stylesheet">
    <!--     Fonts and icons     -->

    <link href="{{url('/assets/css/animate.css')}}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{url('/assets/css/material-design-iconic-font.css')}}" />
    @yield('head')
</head>

<body >
<div class="wrapper">
    <div class="sidebar" data-active-color="blue" data-background-color="black"><!--data-image="{{url('/assets/img/sidebar-1.jpg')}}">-->
        <!--
    Tip 1: You can change the color of active element of the sidebar using: data-active-color="purple | blue | green | orange | red | rose"
    Tip 2: you can also add an image using data-image tag
    Tip 3: you can change the color of the sidebar with data-background-color="white | black"
-->
        <div class="logo">
            <a class="simple-text">
                Sistema RCI
            </a>
        </div>
        <div class="logo logo-mini">
            <a class="simple-text">
                SR
            </a>
        </div>
        <div class="sidebar-wrapper">
            <ul class="nav">
                <?php $vstr_titulo = 0; ?>
                @foreach($item as $i)
                    @if($i->idArea>0 && $vstr_titulo == 0)
                        <?php $vstr_titulo = 1; ?>
                        <li style="pointer-events: none;">
                            <div class="logo">
                                <a href="http://www.creative-tim.com/" class="simple-text">
                                    Menu Entidad
                                </a>
                            </div>
                            <div class="logo logo-mini">
                                <a href="http://www.creative-tim.com/" class="simple-text">
                                    ME
                                </a>
                            </div>

                        </li>
                    @endif
                    @if(count($i->list_SubAcesos)== 0)
                        <li @if($i->resaltado)class="active"@endif>
                            <a href="@if($i->idArea>0) {{url($i->url."/".$i->idArea)}} @else{{url($i->url)}}  @endif">
                                <i class="md {{$i->icono}} md-lg"></i>
                                <p>{{$i->nombre}}</p>
                            </a>
                        </li>
                    @else
                        <li>
                            <a data-toggle="collapse" href="#{{$i->id}}_AC2" aria-expanded="true">
                                <i class="md {{$i->icono}} md-lg"></i>
                                <p>{{$i->nombre}}
                                    <b class="caret"></b>
                                </p>
                            </a>
                            <div class="collapse @if($i->resaltado) in @endif" id="{{$i->id}}_AC2">
                                <ul class="nav">
                                    @foreach($i->list_SubAcesos as $r)
                                        <li @if($r->resaltado)class="active"@endif>
                                            <a href="@if($i->idArea>0) {{url($r->url."/".$i->idArea)}} @else{{url($r->url)}}  @endif">{{$r->nombre}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @endif
                @endforeach

            </ul>
        </div>
    </div>
    @yield('extra')
    <div id="spinner" class="btn spinner spinner-3 spinner-float" style="padding: 0px;">
        <div class="content" style="position: absolute;bottom: 5px; width: 80px; text-align: center;"  data-dispositivo="{{$data->Dispositivos}}">
            <!--<object style="width:50px;" data="{{url('/svg/fuego.svg')}}" type="image/svg+xml"></object>-->
        </div>
    </div>
    <div class="main-panel pat-one-in-million">
        <nav class="navbar navbar-transparent navbar-absolute">
            <div class="container-fluid">
                <div class="navbar-minimize">
                    <button id="minimizeSidebar" class="btn btn-round btn-white btn-fill btn-just-icon">
                        <i class="material-icons visible-on-sidebar-regular md md-more-vert md-2x"></i>
                        <i class="material-icons visible-on-sidebar-mini md md-view-list md-2x"></i>
                    </button>
                </div>
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    @yield('title')
                </div>
                <div class="collapse navbar-collapse">
                    <div class="navbar-form navbar-right" role="search" style="display: none;" id="btn-Search">
                        <div class="form-group form-search is-empty">
                            <input type="text" class="form-control" placeholder="Search">
                            <span class="material-input"></span>
                        </div>
                        <button class="btn btn-white btn-round btn-just-icon">
                            <i class="md md-search"></i>
                            <div class="ripple-container"></div>
                        </button>
                    </div>
                </div>

            </div>
        </nav>
        <div class="content" style="height: 90%;">
            <div class="container-fluid" style="height: 100%;">
                @yield('content')

            </div>
        </div>
        <footer class="footer">
            <div class="container-fluid">
            </div>
        </footer>

    </div>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}" />
</body>
<!--   Core JS Files   -->
<script src="{{url('/assets/js/jquery-3.1.1.min.js')}}" type="text/javascript"></script>
<script src="{{url('/assets/js/jquery-ui.min.js')}}" type="text/javascript"></script>
<script src="{{url('/assets/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{url('/assets/js/material.min.js')}}" type="text/javascript"></script>
<script src="{{url('/assets/js/perfect-scrollbar.jquery.min.js')}}" type="text/javascript"></script>
<!-- Forms Validations Plugin -->
<script src="{{url('/assets/js/jquery.validate.min.js')}}"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="{{url('/assets/js/moment.min.js')}}"></script>
<!--  Charts Plugin -->
<script src="{{url('/assets/js/chartist.min.js')}}"></script>
<!--  Plugin for the Wizard -->
<script src="{{url('/assets/js/jquery.bootstrap-wizard.js')}}"></script>
<!--  Notifications Plugin    -->
<script src="{{url('/assets/js/bootstrap-notify.js')}}"></script>
<!--   Sharrre Library    -->
<script src="{{url('/assets/js/jquery.sharrre.js')}}"></script>
<!-- DateTimePicker Plugin -->
<script src="{{url('/assets/js/bootstrap-datetimepicker.js')}}"></script>
<!-- Sliders Plugin -->
<script src="{{url('/assets/js/nouislider.min.js')}}"></script>
<!-- Select Plugin -->
<script src="{{url('/assets/js/jquery.select-bootstrap.js')}}"></script>
<!--  DataTables.net Plugin    -->
<script src="{{url('/assets/js/jquery.datatables.js')}}"></script>
<!-- Sweet Alert 2 plugin -->
<script src="{{url('/assets/js/sweetalert2.js')}}"></script>
<!--	Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="{{url('/assets/js/jasny-bootstrap.min.js')}}"></script>
<!--  Full Calendar Plugin    -->
<script src="{{url('/assets/js/fullcalendar.min.js')}}"></script>
<!-- TagsInput Plugin -->
<script src="{{url('/assets/js/jquery.tagsinput.js')}}"></script>

<script src="{{url('/assets/js/jquery.nicescroll.js')}}"></script>
<!-- Material Dashboard javascript methods -->
<script src="{{url('/assets/js/material-dashboard.js')}}"></script>

<script type="text/javascript" src="{{url('/assets/plugin/highchart/js/highcharts.js')}}"></script>
<script type="text/javascript" src="{{url('/assets/plugin/highchart/js/highcharts-more.js')}}"></script>
<!--<script type="text/javascript" src="{{url('/assets/plugin/highchart/js/themes/gray.js')}}"></script>-->
<script type="text/javascript" src="{{url('/assets/js/jquery.bootstrap-growl.min.js')}}"></script>
<script type="text/javascript" src="{{url('/assets/js/offline.min.js')}}"></script>
<script>

    $.fn.extend({
        animateCss: function (animationName) {
            var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
            this.addClass('animated ' + animationName).one(animationEnd, function() {
                $(this).removeClass('animated ' + animationName);
            });
            return this;
        }
    });
    $timerId = 0;
    $svg = $("<h5/>");
    $cantidad = $("<h5/>");
    $alert_offline = function () {};
    $(document).ready(function() {



        if (!("WebSocket" in window)) {
            $('#spinner').fadeOut("fast");
            $('<p>Oh no, you need a browser that supports WebSockets. How about <a href="http://www.google.com/chrome">Google Chrome</a>?</p>').appendTo('#container');
        } else {
            Offline.options = {checkOnLoad: false, checks: {
                image: {url: 'http://192.168.137.5/assets/img/Team_liquid.ico'}, active: 'image'}}
            var run = function(){
                if (Offline.state === 'up'){
                    Offline.check();
                }
            }
            setInterval(run, 5000);
            Offline.on('up', function() {
                $('#spinner').removeClass('spinner-3');
                $('#spinner').addClass('spinner-1');
                connect();
            });
            Offline.on('down', function() {
                $('#spinner').removeClass('spinner-1');
                $('#spinner').addClass('spinner-3');
            });
            //The user has WebSockets
            connect();
            function connect() {
                var socket;
                var host = "ws://192.168.137.5:8090";
                try {
                    var socket = new WebSocket(host);

                    socket.onopen = function () {
                        notificacion("<b>Servidor de Notificaciones</b> - Conexión Establecida.",'success');
                        var offline = 0;
                        $('#spinner').removeClass('spinner-3');
                        $('#spinner').addClass('spinner-1');

                        var data =  $('#spinner').find('.content').data('dispositivo');
                        $.each(data,function (i,r) {
                            if(r.Ping == 0){
                                offline++;
                            }
                        });
                        $alert_offline(offline);
                    }

                    socket.onmessage = function (msg) {
                        var data = JSON.parse(msg.data);
                        var offline = 0;
                        $.each(data.dispositivos,function (i,r) {
                            if(r.Ping == 0){
                                offline++;
                            }
                        });
                        $alert_offline(offline);

                    }


                    socket.onclose = function () {
                        $('#spinner').removeClass('spinner-1');
                        $('#spinner').addClass('spinner-3');
                        $('#spinner').find('.content').html('');
                        notificacion("<b>Servidor de Notificaciones</b> - Conexión perdida con el servicio de notificaciones.",'warning');
                    }

                } catch (exception) {
                    $('#spinner').removeClass('spinner-1');
                    $('#spinner').addClass('spinner-3');
                    $('#spinner').find('.content').html('');
                }

                $('#spinner').click(function () {
                    //socket.close();
                    window.location.replace("/pagMikrotik");
                });

            }
            function btm_svg (objet) {
                var url = "";
                switch (objet) {
                    case 0:
                        url = "/svg/enrutador.svg";
                        break;
                    case 1:
                        url = "/svg/fuego.svg";
                        break;
                };

                return $('<object class="icono" style="width:50px;margin-bottom:3px;" data="' + url + '" type="image/svg+xml"></object>');
            }

            $alert_offline = function alert_offline(cantidad) {
                $('#spinner').find('.content').html('');
                clearInterval($timerId);
                if(cantidad > 0){
                    notificacion("<b>Servidor de Notificaciones</b> - Existe <b>"+pad(cantidad,2)+"</b> Mikrotiks apagados.",'info');
                    $svg = btm_svg(1)
                    $cantidad = $("<div><h2 style='font-family: Interstellar;'>"+pad(cantidad,2)+"</h2></div>");
                    $('#spinner').find('.content').append($cantidad);
                    $svg.hide();
                    $('#spinner').find('.content').append($svg);

                    $timerId = setInterval(function () {
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

                    },3000);
                }else{
                    var svg = btm_svg(0);
                    $('#spinner').find('.content').append(svg);
                    clearInterval($timerId);
                }
            }
            function pad (n, length) {
                var  n = n.toString();
                while(n.length < length)
                    n = "0" + n;
                return n;
            }
            //End connect

        }//End else

        function notificacion(vstr_mensaje,color){
            //type = ['','info','success','warning','danger','rose','primary'];

            $.notify({
                icon: " md md-notifications",
                message: vstr_mensaje,

            },{
                type: color,
                timer: 500,
                placement: {
                    //from: 'top',
                    align: 'right'
                }
            });
        }
    });
</script>
@yield('script')
</html>