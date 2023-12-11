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
        <script src="../../js/search.js"></script>
        <!--<script src="../../js/confirm.js"></script>-->
        <script src="../../js/alertify/alertify.js"></script>
        <link href="../../css/alertify/alertify.css" rel="stylesheet">
        <link href="../../css/alertify/themes/default.css" rel="stylesheet">
        <title>Tipos de Clientes</title>
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
                        Tipos de Clientes
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
                    <div class="tituloContenido"><h1>Gestión Tipos de Clientes</h1></div><div class="agregarDato">
                        <a href="add_type_client.php"><input type="button" value="Agregar"></a></div><div class="buscar">
                            <input type="text" id="txbSearchTypeClient" placeholder="Buscar...">
                        </div>                    
                </div>
                <div class="listado">
                                        
                    <form method="post" action="">
                        <table>
                            <tr>
                                <th>CODIGO</th>
                                <th>NOMBRE</th>                                
                                <th>ACCION</th>
                            </tr>
                            
                            <?php
                            require '../../models/TypeClientImpl.php';
                            $objTypeClientImpl = new TypeClientImpl();
                            
                            foreach ($objTypeClientImpl->getAll() as $valor) {
                                ?>
                                <tr>
                                    <td class="tdDerecha"><?php echo $valor->getCode(); ?></td>                                
                                    <td><?php echo $valor->getName(); ?></td>                                                              
                                    <td id="tdAcciones">
                                        <?php
                                        echo '<a href="edit_type_client.php?id='.$valor->getCode().'"><img src="../../res/edit-16.png"></a>';
                                        echo '<a class="aDelete" href="../../controllers/ctrlDeleteTypeClient.php?id='.$valor->getCode().'"><img src="../../res/delete-16.png"></a>';                                        
                                        ?>                                        
                                    </td>  
                                </tr>
                                <?php
                                }
                                ?>
                        </table>
                    </form> 
                    
                    <?php echo '<p>Ultimos registros de '.$objTypeClientImpl->getCount().' encontrados</p>';   ?>
                    
                    
                </div>
                
                <?php
                if(isset($_GET['em']))
                {
                    echo '<script>alertify.error("El tipo de cliente no se puede eliminar, favor revisar");</script>';          
                }
                ?>
                
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