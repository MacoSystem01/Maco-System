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
        <script src="../../js/forms.js"></script>
        <script src="../../js/alertify/alertify.js"></script>
        <link href="../../css/alertify/alertify.css" rel="stylesheet">
        <link href="../../css/alertify/themes/default.css" rel="stylesheet">
        <title>Reporte Inventario</title>
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
                        Reportes
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
            
            <section class="contenido" id="contenidoGeneral2">
                <h1>Reporte de Inventario</h1>
                
                <?php
                if($_POST)
                {?>
                    <form id="formReporteInventario" method="post">
                        <?php 
                        echo '<input id="txbFechaInicio" min="1979-12-31" max="2200-12-31" name="txbFechaInicio" type="date" placeholder="DESDE" required value="'.$_POST['txbFechaInicio'].'">'; 
                        echo '<input id="txbFechaFin" min="1979-12-31" max="2200-12-31" name="txbFechaFin" type="date" placeholder="HASTA" required value="'.$_POST['txbFechaFin'].'">';
                        echo '<input id="txbReferencia" name="txbReferencia" type="text" placeholder="REFERENCIA" value="'.$_POST['txbReferencia'].'">';
                        ?>                        
                        <input id="btnConsultarInventario" type="submit" value="Consultar">
                        <input id="btnGenerarInventario" type="submit" value="Generar PDF">
                    </form>    
                <?php
                }
                else
                {?>
                    <form id="formReporteInventario" method="post">
                        <?php 
                        $dateNow = date("Y-m-d");
                        echo '<input id="txbFechaInicio" min="1979-12-31" max="2200-12-31" name="txbFechaInicio" type="date" placeholder="DESDE" required value="'.$dateNow.'">'; 
                        echo '<input id="txbFechaFin" min="1979-12-31" max="2200-12-31" name="txbFechaFin" type="date" placeholder="HASTA" required value="'.$dateNow.'">';
                        ?>
                        <input id="txbReferencia" name="txbReferencia" type="text" placeholder="REFERENCIA">
                        <input id="btnConsultarInventario" type="submit" value="Consultar">
                        <input id="btnGenerarInventario" type="submit" value="Generar PDF">
                    </form>
                <?php
                }
                ?>
                
            </section>
            
            <section class="contenido" id="contenidoGeneral2">                
                <div class="listado">                                      
                    <?php
                    if($_POST)
                    {
                        $dateInicio = $_POST['txbFechaInicio'];
                        $dateFin = $_POST['txbFechaFin'];
                        
                        if($dateFin>=$dateInicio){
                            require_once '../../models/StockImpl.php';
                            $objStockImpl = new StockImpl();

                            if ($objStockImpl->getCountByAlmacenBetweenDate($_POST['txbFechaInicio'], $_POST['txbFechaFin'], $_POST['txbReferencia']) > 0)
                            {
                                $totalCostoInventario = 0;
                                $totalCostoNacional = 0;
                                $totalCostoImportada = 0;
                            ?>
                                <form method="post">
                                <table>
                                    <tr>
                                        <th>REFERENCIA</th>
                                        <th>ARTICULO</th>
                                        <th>COSTO</th>
                                        <th>EXISTENCIAS</th>
                                        <th>ORIGEN</th>
                                        <th>COSTO INV.</th>
                                    </tr>
                                    
                                <?php
                                foreach ($objStockImpl->getByAlmacenBetweenDate($_POST['txbFechaInicio'], $_POST['txbFechaFin'], $_POST['txbReferencia']) as $valorStock) {
                                    $quantityAvailable = $objStockImpl->getQuantityAvailable($valorStock->getCode());
                                    $quantitySale = $objStockImpl->getQuantitySale($valorStock->getCode());
                                    $totalCantidad = $quantityAvailable - $quantitySale;
									if ($totalCantidad != 0)
									{
                                    echo '<tr>
                                        <td>'.$valorStock->getCode().'</td>
                                        <td>'.$valorStock->getName().'</td>';
                                        $prom = $objStockImpl->getPromPriceReport($_POST['txbFechaInicio'], $_POST['txbFechaFin'], $valorStock->getCode());
                                        $valueInventary = $prom * $totalCantidad;
                                        
                                        $origen = $objStockImpl->getOrigen($valorStock->getCode());
                                        if(strcmp($origen, "N") == 0)
                                        {       
                                            $origen = 'NACIONAL';
                                            $totalCostoNacional += $valueInventary;
                                        }
                                        else if(strcmp($origen, "I") == 0)
                                        {
                                            $origen = 'IMPORTADO';
                                            $totalCostoImportada += $valueInventary;
                                        }
                                        
                                        echo '<td class="tdDerecha">'.number_format($prom).'</td> 
                                        <td class="tdDerecha">'.number_format($totalCantidad,0).'</td>
                                        <td>'.$origen.'</td>    
                                        <td class="tdDerecha" >'.number_format($valueInventary).'</td>
                                    </tr>';
                                    
                                   $totalCostoInventario += $valueInventary;
									}
                                }                                
                                
                                 echo '<tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    </tr>';
                                  echo '<tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    </tr>';
                                
                                echo '<tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="tdDerecha">COSTO MERCANCIA NACIONAL</td>
                                    <td class="tdDerecha"> '.number_format($totalCostoNacional).'</td></tr>';                                
                                echo '<tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="tdDerecha">COSTO MERCANCIA IMPORTADA</td>
                                    <td class="tdDerecha"> '.number_format($totalCostoImportada).'</td></tr>';
                                
                                echo '<tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="tdDerecha">COSTO TOTAL INVENTARIO</td>
                                    <td class="tdDerecha"> '.number_format($totalCostoInventario).'</td></tr>';
                                
                                ?>

                                </table>
                                </form> 
                            <?php
                            }
                            else {
                                echo '<script>alertify.error("No se encontraron registros");</script>';                                
                            }
                        
                        }
                        else
                        {
                            echo '<script>alertify.error("La fecha final debe ser mayor que la fecha inicial");</script>';
                        }
                    }
                    ?>                          
                         
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