<html>
<head>
    <?php include('header.php'); ?>
    <title><?php echo env('APP_NAME'); ?> :: Estadisticas</title>
</head>
<body>
<?php include('navegate_bar.php'); ?>
<div class="py-5">
    <div class="container">
        <h3>Estadisticas</h3>
        <div class="row">
            <div class="col-md-4 jumbotron">
                <input type="url" class="form-control" placeholder="Id Enlace" id="url_input">
                <input type="password" class="form-control" placeholder="Clave (Solo si es necesaria)" id="pass_input">
                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-secondary" onclick="onClickButton('hour')">Ult. Hora</button>
                    <button type="button" class="btn btn-secondary" onclick="onClickButton('day')">Hoy</button>
                    <button type="button" class="btn btn-secondary" onclick="onClickButton('week')">Semana</button>
                    <button type="button" class="btn btn-secondary" onclick="onClickButton('month')">Mes</button>
                    <button type="button" class="btn btn-secondary" onclick="onClickButton('year')">A&ntilde;o</button>
                </div>
                </br>
                <i id="loader" style="display: none;" class="fa fa-circle-o-notch fa-spin" style="font-size:24px"></i>
            </div>
            <div class="col-md-4">
                <div id="chart_div_os"></div>
            </div>
            <div class="col-md-4">
                <div id="chart_div_devices"></div>
            </div>
            <div class="col-md-4">
                <div id="chart_div_browsers"></div>
            </div>
            <div class="col-md-4">
                <div id="chart_div_countries"></div>
            </div>
            <div class="col-md-4">
                <h3 id="clicks"></h3>
            </div>
        </div>
    </div>
</div>
<?php include('scripts.php'); ?>
<script type="application/javascript">
    $(document).ready(function(){
        //auto update of statistics
        window.tipoActual = "day";
        setInterval(function(){onClickButton(window.tipoActual,true)},120000);
    });

    function onClickButton(tipo, autoUpdate=false){
        var idURL = $("#url_input").val();

        window.tipoActual = tipo;
        if(autoUpdate){console.log("Actualizando...");}

        //Is url_input a url' id valid?
        if(idURL.match(/^[0-9a-zA-Z]+$/)){
            drawCharts(tipo, idURL, $("#pass_input").val());
        }else{
            if(!autoUpdate){swal("Oops!!", "Ingrese un id valido.", "error"); }
        }
    }

    /**
     * The data are get and the graphs are draw
     * */
    function drawCharts(tipoDeDatos, id, clave = ""){
        $("#loader").css("display", "inline-block");
        $.ajax({
            url: "<?php echo env('APP_URL'); ?>/api/urls/"+id+"/statistics/"+tipoDeDatos+"?pass="+clave
        }).done(function( data ) {
            //the view is cleared
            ["#clicks", "#chart_div_os", "#chart_div_devices", "#chart_div_browsers", "#chart_div_countries"].forEach(function (i) {
                $(i).html("");
            });
            if(data.total_accesses>0){
                $("#clicks").html(data.total_accesses + " clicks obtenidos");
                create_graph_pie(data.countries,"country","chart_div_countries");
                create_graph_pie(data.os, "os", "chart_div_os");
                create_graph_pie(data.devices, "device", "chart_div_devices");
                create_graph_pie(data.browsers, "browser","chart_div_browsers");
            }else{
                swal(":(", "No hay estadisticas disponibles", "info")
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            //the error is processed
            switch(jqXHR.status){
                case 404:
                    swal("Oops!!","La URL solicitada no existe.","error");
                    break;
                case 401:
                    swal("Oops!!","URL protegida, ingrese la clave correcta", "error");
                    break;
                default:
                    swal("Oops!!","No se pudo obtener los datos", "error");
            }
        }).always(function(){
            $("#loader").css("display", "none");
        });
    }

    function create_graph_pie(data, key, divContainer){
        //the data is generated
        var keys = [];
        var values = [];
        data.forEach(function (i) {
            keys.push(i[key]);
            values.push(parseInt(i["cant"]));
        });
        console.log(keys);
        console.log(values);
        var options = {
            chart: {
                width: 380,
                type: 'pie',
            },
            labels: keys,
            series: values,
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };
        var chart = new ApexCharts(document.querySelector("#"+divContainer),options);
        chart.render();
    }
</script>
</body>
</html>