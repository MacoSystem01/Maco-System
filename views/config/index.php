<?php
session_start();

include '../../com/server.php';
$server = new SimpleXMLElement($xmlstr);
$ip = $server->server[0]->ip;

if (!empty($_SESSION['userCode']) && !empty($_SESSION['userName']))
{
?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../../css/style.css" rel="stylesheet">
        <script src="../../js/jquery/jquery.js"></script>
        <!--<script src="../../js/search.js"></script>-->
        <!--<script src="../../js/reports.js"></script>-->
        <title>Parámetros</title>
    </head>
    <body>
        <section class="contenedor">
            <header>
                <div class="logoEmpresa">
                    <a href="../../index.php"><img src="../../res/logo.png"></a></div><div class="sesion">
                        Salir<a href="../../controllers/ctrlLogout.php"><img src="../../res/logout-24.png"></a>
                    </div>                    
                <div class="contenedorRutaApp">
                    <div class="nombreAplicacion">
                        Sistema de Información "Baruk Distribuciones"
                    </div><div class="arrowImgRight">
                        <img src="../../res/arrow-25-16.png">
                    </div><div class="opcionSeleccionada">
                        Parámetros
                    </div>
                </div>
            </header>
            <nav id="menu">
                <ul>
                    <li><a href="../config/"><img src="../../res/settings-4-16.png">Parámetros</a></li>
                    <li><a href="../clients/"><img src="../../res/guest-16.png">Clientes</a></li>
                    <li><a href="../stock/"><img src="../../res/list-ingredients-16.png">Inventario</a></li>
                    <li><a href="../bill"><img src="../../res/document-16.png">Remisiones</a></li>
                    <li><a href="../spend/"><img src="../../res/banknotes-16.png">Gastos</a></li>                    
                    <li><a href="../credit/"><img src="../../res/credit-card-2-16.png">Créditos</a></li>                       
                    <li><a href="../collect/"><img src="../../res/cash-receiving-16.png">Recaudos</a></li>
                    <li><a href="../reports/"><img src="../../res/line-16.png">Reportes</a></li>   
                </ul>
            </nav>
            
            <section class="contenido" id="contenidoGeneral">
                <div class="encabezadoContenido">
                    <div class="tituloContenido"><h1>Parámetros</h1></div><div class="agregarDato">
                        </div><div class="buscar">                              
                        </div>                    
                </div>
                <div class="listado">
                                        
                    <form method="post" action="">
                        <table>
                            <tr>
                                <th>PARAMETRO</th>
                                <th>DESCRIPCION</th>
                                <th>ACCION</th>
                            </tr>
                            <tr>
                                <td>TIPOS DE CLIENTE</td>
                                <td>GESTIONAR TIPOS DE CLIENTE</td>
                                <td id="tdAcciones"><a href="type_clients.php"><img src="../../res/open-in-browser-16.png"></a></td>                                
                            </tr>
                            <tr>
                                <td>CONCEPTOS</td>
                                <td>GESTIONAR CONCEPTOS</td>
                                <td id="tdAcciones"><a href="concepts.php"><img src="../../res/open-in-browser-16.png"></a></td>
                            </tr>                            
                                <td>BANCOS</td>
                                <td>GESTIONAR BANCOS</td>
                                <td id="tdAcciones"><a href="bancos.php"><img src="../../res/open-in-browser-16.png"></a></td>
                            </tr>                            
                        </table>
                    </form> 
                </div>
                
            </section>
            <footer>
                <div class="franjaAzul"></div>     
            </footer>
        </section>
    </body>
</html>

<?php
}
else
{
    echo '<script>document.location.href = "http://'.$ip.'/baruk/login.php"; </script>';    
}
?>