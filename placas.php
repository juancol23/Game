<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){    
    if ($_POST['type'] == 'getPlacas')
    {
        $servicio="http://169.254.253.3/soap/cgi-bin/server.php?wsdl"; //url del servicio
        $parametros=array(); //parametros de la llamada
        $parametros['idioma']="es";
        $parametros['usuario']="manolo";
        $parametros['clave']="tuclave";
        $client = new SoapClient($servicio, array('exceptions' => 0) );
        $result = $client->getPlates($parametros);//llamamos al métdo que nos interesa con los parámetros
        echo json_encode($result);
    }
    if ($_POST['type'] == 'getUpTime')
    {
        $servicio="http://169.254.253.3/soap/cgi-bin/server.php?wsdl"; //url del servicio
        $parametros=array(); //parametros de la llamada
        $client = new SoapClient($servicio);
        $result = $client->getUpTime($parametros);//llamamos al métdo que nos interesa con los parámetros
        echo json_encode($result);
    }
    if ($_POST['type'] == 'enviarMysql')
    {
        @mysql_connect("localhost","root","") or die("No se ha podido conectar a la BD");
        mysql_select_db("invian");
        $placa = $_POST['placa'];
        $confianza = $_POST['confianza'];
        $timestamp = $_POST['timestamp'];
        $validar = $_POST['validar'];
        $contador = $_POST['contador'];
        



        /*codigo agregando campos faltantes*/
        function get_browser_name($user_agent)
        {
            if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) return 'Opera';
            elseif (strpos($user_agent, 'Edge')) return 'Edge';
            elseif (strpos($user_agent, 'Chrome')) return 'Chrome';
            elseif (strpos($user_agent, 'Safari')) return 'Safari';
            elseif (strpos($user_agent, 'Firefox')) return 'Firefox';
            elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) return 'Internet Explorer';
            
            return 'Other';
        }

        // Usage:
         
        function GetMAC(){
            ob_start();
            system('getmac');
            $Content = ob_get_contents();
            ob_clean();
            return substr($Content, strpos($Content,'\\')-20, 17);
        }
         
            $mac = GetMAC();
            $ip = $_SERVER['SERVER_ADDR'];
            $nameRed = $_SERVER['SERVER_NAME'];
            $nameNavegador = get_browser_name($_SERVER['HTTP_USER_AGENT']);

        /*fin de agregando codigo*/

      
        // $query= "INSERT INTO placas(`string`) 
        // VALUES ('$string'";
     
        $query= "INSERT INTO `placas` (`id`,`placa`,`confianza`,`timestamp`,`validar`,`contador`,`CreatedAt`) VALUES (null,'$placa','$confianza','$timestamp','$validar','$contador',LOCALTIMESTAMP())";
       
        $result = mysql_query($query) or die('Consulta no válida: ' . mysql_error());
        if ($result === TRUE){
            echo "Ok";
        }else{
            echo "Error";    
        }
    }
    return;
}


 ?>

<?php
 echo '<br/>';
  
function get_browser_name($user_agent)
{
    if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) return 'Opera';
    elseif (strpos($user_agent, 'Edge')) return 'Edge';
    elseif (strpos($user_agent, 'Chrome')) return 'Chrome';
    elseif (strpos($user_agent, 'Safari')) return 'Safari';
    elseif (strpos($user_agent, 'Firefox')) return 'Firefox';
    elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) return 'Internet Explorer';
    
    return 'Other';
}

// Usage:
 
function GetMAC(){
    ob_start();
    system('getmac');
    $Content = ob_get_contents();
    ob_clean();
    return substr($Content, strpos($Content,'\\')-20, 17);
}
 
    $mac = GetMAC();
    $ip = $_SERVER['SERVER_ADDR'];
    $nameRed = $_SERVER['SERVER_NAME'];
    $nameNavegador = get_browser_name($_SERVER['HTTP_USER_AGENT']);

    echo $mac.'<br>',$ip.'<br>',$nameRed.'<br>',$nameNavegador.'<br>';

?>






<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <!-- <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->
    <link href="icons/materialIcons.css" media="screen" rel="stylesheet" type="text/css">

    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.css" media="screen,projection" />

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Load c3.css -->
    <link href="c3-0.4.11/c3.css" rel="stylesheet" type="text/css">

    <!-- json to excel -->
    <script language="javascript" src="js/CSVExport.js"></script>

</head>

<body>
    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>

</body>
    <!-- Load d3.js and c3.js -->
    <script src="c3-0.4.11/d3.v3.min.js" charset="utf-8"></script>
    <script src="c3-0.4.11/c3.min.js"></script>
    <div class="row">
        <div class="col s12 m3">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Tiempos</span>
                    <!-- <p>Comntenido</p> -->
                </div>
                <div class="card-content">
                    <div id="chartTiempo"></div>
                </div>
            </div>
        </div>

        <div class="col s12 m3">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Confiabilidad</span>
                    <!-- <p>Comntenido</p> -->
                </div>
                <div class="card-content chart-linea">
                    <div id="chartConfibilidad"></div>
                </div>
            </div>
        </div>

        <div class="col s12 m6">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Resumen</span>
                    <!-- <p>Comntenido</p> -->
                </div>
                <div class="card-content"  style="overflow-y: scroll">
                    <ul id="staggered-test" class="collection" style="visibility: collapse;">
                        <li class="collection-item avatar">
                          <p id="total"></p>
                        </li>
                        <li class="collection-item avatar">
                          <p id="confidence"></p>
                        </li>
                        <li class="collection-item avatar">
                          <p id="time"></p>
                        </li>
                      </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Detalle</span>
                    <!-- <p>Comntenido</p> -->
                </div>
                <div class="card-content">
                    <ul id="detalle"></ul>
                </div>
            </div>
        </div>
    </div>
    <!-- <form name="Demo" action="" method="post">
        <div>
            <input type="button" value="Soap" onclick="getPlacas();" />
            <br/>
            <label  id="getUpTime" onclick="getUpTime();" />getUpTime</label>
        </div>
    </form> -->
<script type="text/javascript">
    "use strict";
    var contador =0, anterior="";
    $(".button-collapse").sideNav();
    $('select').material_select();
    var alto= 200;
    $("#staggered-test").parent().height(alto);
    var colores ={1:"#9c27b0",2:"#26c6da",3:"#999999",4:"#ff0000",5:'#96ff75',6:"#ffe458"};
    var chart1 = c3.generate({
        bindto: '#chartTiempo',
        size: {
            height: alto
        },
        data: {
            columns: [
                ['TiempoTotal', 0],
                ['TiempoPromedio', 0],
            ],
            type : 'donut',
            colors: {
                TiempoTotal: colores[2],
                TiempoPromedio: colores[1],
            },
        },
        donut: {
            width: 20,
            title: "",
            label: {
                show: false
            },
        },
        // legend: {
        //     show: false
        // },
    });
    var chart2 = c3.generate({
        bindto: '#chartConfibilidad',
        size: {
            height: alto
        },
        data: {
            columns: [
                ['Confiable', 0],
                ['NoConfiable', 0],
            ],
            type : 'donut',
            colors: {
                Confiable: colores[2],
                NoConfiable: colores[1],
            },
        },
        donut: {
            width: 20,
            title: "",
            label: {
                show: false
            },
        },
        // legend: {
        //     show: false
        // },
    });
    var tiempoReal = setInterval(getPlacas, 500);
    function getPlacas(){
        var placas ={}, total=0;
        var tiempoPromedio=0,tiempoTotal=0;
        var confiablePromedio=0,confiableTotal=0;
        $.ajax({
            type: "POST",
            url: "placas2.php",
            data: {
                type: "getPlacas",
                string: 123
            },
            // async: false,
            success: function (datos) {
                if(datos.length<3){
                    return;
                }
                datos = JSON.parse(datos);
                datos=datos.replace(/"/g,"");
                datos=datos.replace(/ /g,"");
                datos = datos.replace(/}/g,"},");
                datos = datos.slice(0,-1);

                datos = datos.replace(/},/g,"},$");

                datos = datos.split("$");
                //console.log(datos);
                for(var i=0;i<datos.length;i++){
                    //datos = JSON.parse(datos[i]);    
                    var item = datos[i];
                    item=item.split(",");
                    if(item[1] !== undefined){
                        var confidence = parseFloat(item[5].substr(9,4));
                        confiableTotal += confidence;
                        var placa = item[4].replace("plate:","");
                        var timestamp = item[7].replace("timestamp:","").replace("}","");
                        //console.log(new Date(parseInt(timestamp) ) );
                        if(placas[placa]){
                            placas[placa]={count:placas[placa].count+1,timestamp:placas[placa].timestamp,confidence:placas[placa].confidence+confidence};
                        }else{
                            placas[placa]={count:1,timestamp:timestamp,confidence:confidence};        
                        }
                        total++;                     
                    }
                } 
            },
            error: function(e) {
                Materialize.toast('ERROR DE LPR', 3000, 'rounded') 
            }
        }).then(function(datos) {
            if(datos.length<3){
                return;
            }
            tiempoPromedio=tiempoTotal/total;
            confiablePromedio=confiableTotal/total;
            $.each(placas, function(i,value){ 
                var confidence = (100*(placas[i].confidence)/placas[i].count).toFixed(1);
                if(confidence>=95){
                    Materialize.toast('Placa '+ i +" "+ confidence , 3000, 'rounded');
                    $("#detalle").prepend("<li>Placa: "+i+" cantidad: "+placas[i].count+" duración: "+placas[i].count+" ms "+ " confianza: "+ confidence+" %</li>");
                }else{
                    Materialize.toast('<span style="color:red;">Placa '+ i+" "+confidence +'</span>', 3000, 'rounded');
                    $("#detalle").prepend("<li style='color:red;'>Placa: "+i+" cantidad: "+placas[i].count+" duración: "+placas[i].count+" ms "+ " confianza: "+ confidence+" %</li>");
                }
                enviarMysql(i,confidence,parseInt(placas[i].timestamp) );
            });
            $("#total").text("Total de registros: "+total);
            $("#confidence").text("Confianza: "+ (confiablePromedio*100).toFixed(1) + " %");
            $("#time").text("Duracion total: "+tiempoTotal+" ms");
            $('#staggered-test').css("visibility","visible");
            chart1.load({
                columns: [['TiempoPromedio', tiempoPromedio],['TiempoTotal', tiempoTotal - tiempoPromedio]]
            });
            d3.select('#chartTiempo  .c3-chart-arcs-title').node().innerHTML = tiempoPromedio.toFixed(1) + " mili seg";

            chart2.load({
                columns: [['Confiable', confiablePromedio],['NoConfiable', 1 - confiablePromedio ]]
            });
            d3.select('#chartConfibilidad  .c3-chart-arcs-title').node().innerHTML = (confiablePromedio*100).toFixed(1) + " %";
        });
              
    }
    function enviarMysql(placa,confidence,timestamp,validar,CreatedAt){
        if(anterior == placa && anterior.indexOf("*") == -1){
            confidence>99.9?contador+=4:contador++;
        }else{
            anterior=placa;
            contador=0;
        }
             console.log("CONTADOR:"+contador);

         if (contador>6 ){
            validar = "true";
             console.log("true"); 
            }
        else{
            validar = "false";
             console.log("false"); 

        };
       


        //console.log(new Date(timestamp), anterior.indexOf("*") );
       
        $.ajax({
            type: "POST",
            url: "placas2.php",
            data: {
                type: "enviarMysql",
                placa: placa,
                confianza: confidence,
                timestamp: timestamp,
                validar: validar,
                contador: contador,
                 
            },
            // async: false,
            success: function (datos) {
                //console.log(datos);
                
            },
            error: function(e) {
                console.log(e);
            }

        });  
        if(contador>6){
            contador=0;
            enviarTelerik(placa,confidence,timestamp);
        }
    }
    function enviarTelerik(placa,confidence,timestamp){
        var object = { "placa" : placa,
        "confidence": confidence,
        "timestamp": timestamp };
        // console.log(object); 
        $.ajax({
            type: "POST",
            url: 'https://api.everlive.com/v1/nn4jvqw0lro14020/registros',
            headers: { 
                // "Authorization" : "Bearer your-access-token" 
            },
            contentType: "application/json",
            data: JSON.stringify(object),
            success: function(data) {
                //console.log("OK Telerik");
                Materialize.toast('<span style="color:white;">Placa '+ placa+" "+confidence +'</span>', 3000,'green');
                $("#detalle").prepend("<li style='color:green;'>Placa: "+placa+" timestamp: "+ timestamp+ " confianza: "+ confidence+" %</li>");
            },
            error: function(error) {
                console.log(JSON.stringify(error));
            }
        })
    }
    function getUpTime(){
        $.ajax({
            type: "POST",
            url: "placas2.php",
            data: {
                type: "getUpTime",
                parametro: 123
            },
            // async: false,
            success: function (datos) {
                console.log(datos);
                $("#getUpTime").text(datos);
            },
            error: function(e) {
                console.log(e);
            }
        });  
    }




     



</script>

</html>
