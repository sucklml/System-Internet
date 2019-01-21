@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div id="container"></div>
            </div>
            <div class="col-md-4">
                <div class="card" style="width: 330px;">
                    <div class="card-header card-header-icon" data-background-color="rose">
                        <i class="md md-equalizer md-lg"></i>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Datos Max. MB Consumidos</h4>
                        <div id="conten-fire">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input name="interface" id="interface" type="text" value="WLAN"/>
        <div id="trafico"></div>
    </div>
    </div>
@endsection


@section('script')

    <script src="https://www.gstatic.com/firebasejs/3.7.8/firebase.js"></script>
    <script>
        // Initialize Firebase
        var config = {
            apiKey: "AIzaSyBGxROr4X8Mv3rNgKV1R_LYDTs9AOfBWAQ",
            authDomain: "mikrotik-9de82.firebaseapp.com",
            databaseURL: "https://mikrotik-9de82.firebaseio.com",
            projectId: "mikrotik-9de82",
            storageBucket: "mikrotik-9de82.appspot.com",
            messagingSenderId: "438385978086"
        };
        firebase.initializeApp(config);
    </script>
    <script>
        var chart;
        function requestDatta(interface) {
            $.ajax({
                url: '/getdata/' + interface,
                datatype: "json",
                success: function (data) {
                    var midata = JSON.parse(data);
                    if (midata.length > 0) {
                        var TX = parseInt(midata[0].data);
                        var RX = parseInt(midata[1].data);
                        var x = (new Date()).getTime();
                        shift = chart.series[0].data.length > 19;
                        chart.series[0].addPoint([x, TX], true, shift);
                        chart.series[1].addPoint([x, RX], true, shift);
                        setDataFirebase("{{ date('Y-m-d') }}/", x, TX, RX);
                        document.getElementById("trafico").innerHTML = TX + " / " + RX;
                    } else {
                        document.getElementById("trafico").innerHTML = "- / -";
                    }
                },
                error: function (xhr) {
                    console.log(xhr)
                }
            });
        }
        function setDataFirebase(day, time, tx, rx) {
            var init = true;
            var data_app = firebase.database().ref('data_app/' + day);
            var data_ap = firebase.database().ref('data_app/');
            if(init){
                data_ap.on('value',function (data) {
                        //var html = '<label class="label-control"><i class="md md-today md-lg"></i>Fecha'+
                          //          '<p id="fecha_mtk">'+data.val()+'</p></label>';
                        //$('#conten-fire').append(html);
                        $.each(data,function (i,data2) {
                            //console.log(data2);
                            //var  html = '<span class="material-input"><p id="data-fire">Tx :'+data2.TX+' mb Rx: '+data2.RX+' mb</p></span>';
                            //$('#conten-fire').append(html);
                        });

                    });
                init = false;
            }
            data_app.on('value', function (data) {
                if (data.val() == null) {
                    firebase.database().ref('data_app/' + day).set({time: time, TX: tx, RX: rx});
                } else {
                    if (tx > data.val().TX) {
                        firebase.database().ref('data_app/' + day).set({time: time, TX: tx, RX: data.val().RX});
                    }
                    if (rx > data.val().RX) {
                        firebase.database().ref('data_app/' + day).set({time: time, TX: data.val().TX, RX: rx});
                    }
                }
            });

        }
        $(document).ready(function () {
            Highcharts.setOptions({
                global: {
                    useUTC: false
                }
            });


            chart = new Highcharts.Chart({
                chart: {
                    renderTo: 'container',
                    animation: Highcharts.svg,
                    type: 'spline',
                    events: {
                        load: function () {
                            setInterval(function () {
                                requestDatta(document.getElementById("interface").value);
                            }, 1000);
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
                        margin: 80
                    }
                },
                series: [{
                    name: 'TX',
                    data: []
                }, {
                    name: 'RX',
                    data: []
                }]
            });
        });
    </script>
@endsection