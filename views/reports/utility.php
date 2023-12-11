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
        <link rel="icon" href="../../res/favicon.png" type="image/png" sizes="16x16">
        <script src="../../js/jquery/jquery.js"></script>
        <script src="../../js/Chart.js/Chart.js"></script>
        <script src="../../js/forms.js"></script>
        <script src="../../js/alertify/alertify.js"></script>
        <link href="../../css/alertify/alertify.css" rel="stylesheet">
        <link href="../../css/alertify/themes/default.css" rel="stylesheet">
        <title>Reporte Utilidad</title>
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
                <h1>Reporte de Utilidad</h1>
                
                <?php
                if($_POST)
                {?>
                    <form id="formReporteUtilidad" method="post">
                        <?php 
                        echo '<input id="txbFechaInicio" min="1979-12-31" max="2200-12-31" name="txbFechaInicio" type="date" placeholder="DESDE" required value="'.$_POST['txbFechaInicio'].'">'; 
                        echo '<input id="txbFechaFin" min="1979-12-31" max="2200-12-31" name="txbFechaFin" type="date" placeholder="HASTA" required value="'.$_POST['txbFechaFin'].'">';
                        echo '<input id="btnConsultarUtilidad" type="submit" value="Consultar"><label> </label>';
                        echo '<input id="btnGenerarUtilidad" type="submit" value="Generar PDF">';                        
                        ?>
                    </form>    
                <?php
                }
                else
                {?>
                    <form id="formReporteUtilidad" method="post">
                        <?php 
                        $dateNow = date("Y-m-d");
                        echo '<input id="txbFechaInicio" min="1979-12-31" max="2200-12-31" name="txbFechaInicio" type="date" placeholder="DESDE" required value="'.$dateNow.'">'; 
                        echo '<input id="txbFechaFin" min="1979-12-31" max="2200-12-31" name="txbFechaFin" type="date" placeholder="HASTA" required value="'.$dateNow.'">';
                        ?>
                        <input id="btnConsultarUtilidad" type="submit" value="Consultar"><label> </label>
                        <input id="btnGenerarUtilidad" type="submit" value="Generar PDF">
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
                                    
                                require '../../models/BillImpl.php'; 
                                require '../../models/DetailImpl.php';
                                require '../../models/StockImpl.php';
                                require '../../models/SpendImpl.php';
                                
                                $objBillImpl = new BillImpl();
                                $objStockImpl = new StockImpl();
                                $objDetailImpl = new DetailImpl();
                                $objSpendImpl = new SpendImpl();
                                         
                                $sumTotalContado = $objBillImpl->getSumPayment($_POST['txbFechaInicio'], $_POST['txbFechaFin'], 'CO');
                                $sumTotalCredito = $objBillImpl->getSumPaymentNoVentas($_POST['txbFechaInicio'], $_POST['txbFechaFin'], 'CR');
                                $sumTotalCreditoOtrosIngresos = $objBillImpl->getSumPaymentOtrosIngresos($_POST['txbFechaInicio'], $_POST['txbFechaFin'], 'CR');

                                $sumTotalRecaudo = $objBillImpl->getSumRecaudo($_POST['txbFechaInicio'], $_POST['txbFechaFin']);
								$sumPagosProveeNal = $objBillImpl->getPagosProveeNal($_POST['txbFechaInicio'], $_POST['txbFechaFin']);
								$sumPagosProveeImp = $objBillImpl->getPagosProveeImp($_POST['txbFechaInicio'], $_POST['txbFechaFin']);

								$sumTotalRecaudoSinProvee = $objBillImpl->getSumRecaudoSinProveedor($_POST['txbFechaInicio'], $_POST['txbFechaFin']);
                                $sumTotalRecaudoNoVentas = $objBillImpl->getSumRecaudoNoVentas($_POST['txbFechaInicio'], $_POST['txbFechaFin']);

								$SumRecaudoCredActuales = $objBillImpl->getSumRecaudoCredActuales($_POST['txbFechaInicio'], $_POST['txbFechaFin']);
//								$SumRecaudosCredNal = $objBillImpl->getSumRecaudosCredNal($_POST['txbFechaInicio'], $_POST['txbFechaFin']);
//								$SumRecaudosCredImp = $objBillImpl->getSumRecaudosCredImp($_POST['txbFechaInicio'], $_POST['txbFechaFin']);

								$SumComprasProveeNal = $objBillImpl->getComprasProveeNal($_POST['txbFechaInicio'], $_POST['txbFechaFin']);
								$SumComprasProveeImp = $objBillImpl->getComprasProveeImp($_POST['txbFechaInicio'], $_POST['txbFechaFin']);
                                $sumSubCompras = $SumComprasProveeNal + $SumComprasProveeImp;
								
                                $sumSubTotal = $sumTotalContado + $sumTotalCredito + $sumTotalRecaudo;

                                $sumTotalInventario = $objStockImpl->getSumStock($_POST['txbFechaInicio'], $_POST['txbFechaFin']);
                                
                                //$sumUtilidad = $sumSubTotal - $sumTotalInventario;
                                
                                $sumNacionalContado = $objDetailImpl->getSumNacionalContado($_POST['txbFechaInicio'], $_POST['txbFechaFin']);
                                $sumNacionalCredito = $objDetailImpl->getSumNacionalCredito($_POST['txbFechaInicio'], $_POST['txbFechaFin']);

                                $SumGastosNacional = $objDetailImpl->getSumGastosNacional($_POST['txbFechaInicio'], $_POST['txbFechaFin']);
                                $SumGastosImportado = $objDetailImpl->getSumGastosImportado($_POST['txbFechaInicio'], $_POST['txbFechaFin']);
//                                $SumGastosOtros = $objDetailImpl->getSumGastosOtros($_POST['txbFechaInicio'], $_POST['txbFechaFin']);
                                
                                $sumImportadoContado = $objDetailImpl->getSumImportadoContado($_POST['txbFechaInicio'], $_POST['txbFechaFin']);
                                $sumImportadoCredito = $objDetailImpl->getSumImportadoCredito($_POST['txbFechaInicio'], $_POST['txbFechaFin']);

                                $SumBancos = $objDetailImpl->getSumBancos($_POST['txbFechaInicio'], $_POST['txbFechaFin']);
								
                                //$sumTotalGastos = $objSpendImpl->getSumSpend($_POST['txbFechaInicio'], $_POST['txbFechaFin']);
                                $sumTotalGastos = $SumGastosNacional + $SumGastosImportado + $SumGastosOtros;
                               
//  FCZ - Miercoles 29 Agosto: Se adicionan compras: $sumUtilidad = $sumTotalContado + $sumTotalCredito - $sumTotalRecaudo - $sumTotalGastos;
                                $sumUtilidad = $sumTotalContado + $sumTotalCredito - $sumTotalRecaudo - $sumTotalGastos - $sumSubCompras;

                                $sumFlujoCaja = $sumTotalContado + $SumRecaudoCredActuales - $sumTotalRecaudo - $sumTotalGastos + $sumTotalRecaudoNoVentas;

                                $sumCajaNacional = $sumNacionalContado - $sumPagosProveeNal - $SumGastosNacional - $SumComprasProveeNal;
                                $sumCajaImportado = $sumImportadoContado - $sumPagosProveeImp - $SumGastosImportado - $SumComprasProveeImp;
								
                                $sumUtilidadOtrosIngresos = $sumTotalCreditoOtrosIngresos - $sumTotalRecaudoNoVentas;
                                
                                ?>
                                                    
                                <form method="post">
                                <table>
                                    <tr>
                                        <th>DETALLE</th>
                                        <th>INVENTARIO</th>
                                        <th>REMISION</th>                                        
                                        <th>OTROS INGRESOS</th>
                                    </tr>
                            
                                <?php
                                echo '<input type="hidden" id="sumInvtrHidden" value="'.$sumTotalInventario.'">';
                                echo '<input type="hidden" id="sumRemisionHidden" value="'.$sumUtilidad.'">';                                        
                                echo '<input type="hidden" id="sumOtrosHidden" value="'.$sumUtilidadOtrosIngresos.'">';                                        
                                
                                echo '<tr>
                                        <td>INVENTARIO</td>
                                        <td class="tdDerecha">'.number_format($sumTotalInventario,0).'</td>
                                        <td></td>
                                        <td></td>
                                    </tr>';                                         
                                echo '<tr>
                                        <td>REMISION CONTADO</td>
                                        <td></td>
                                        <td class="tdDerecha">'.number_format($sumTotalContado,0).'</td>
                                        <td></td>
                                    </tr>';
                                echo '<tr>
                                        <td class="tdDerecha">Nacional</td>
                                        <td></td>
                                        <td class="tdDerecha">'.number_format($sumNacionalContado,0).'</td>
                                        <td></td>
                                    </tr>'; 
                                echo '<tr>
                                        <td class="tdDerecha">Importado</td>
                                        <td></td>
                                        <td class="tdDerecha">'.number_format($sumImportadoContado,0).'</td>
                                        <td></td>
                                    </tr>'; 
                                echo '<tr>
                                        <td>REMISION CREDITO</td>
                                        <td></td>
                                        <td class="tdDerecha">'.number_format($sumTotalCredito,0).'</td>
                                        <td></td>
                                    </tr>';
                                echo '<tr>
                                        <td class="tdDerecha">Nacional</td>
                                        <td></td>
                                        <td class="tdDerecha">'.number_format($sumNacionalCredito,0).'</td>
                                        <td></td>
                                    </tr>'; 
                                echo '<tr>
                                        <td class="tdDerecha">Importado</td>
                                        <td></td>
                                        <td class="tdDerecha">'.number_format($sumImportadoCredito,0).'</td>
                                        <td></td>
                                    </tr>';
                                echo '<tr>
                                        <td>RECAUDOS CREDITOS</td>
                                        <td></td>
                                        <td class="tdDerecha">'.number_format($SumRecaudoCredActuales,0).'</td>
                                        <td></td>
                                    </tr>';
                                echo '<tr>
                                        <td>COMPRAS</td>
                                        <td></td>
                                        <td class="tdDerecha">'.number_format($sumSubCompras,0).'</td>
                                        <td></td>
                                    </tr>';
                                echo '<tr>
                                        <td class="tdDerecha">Nacional</td>
                                        <td></td>
                                        <td class="tdDerecha">'.number_format($SumComprasProveeNal,0).'</td>
                                        <td></td>
                                    </tr>'; 
                                echo '<tr>
                                        <td class="tdDerecha">Importado</td>
                                        <td></td>
                                        <td class="tdDerecha">'.number_format($SumComprasProveeImp,0).'</td>
                                        <td></td>
                                    </tr>';
                                echo '<tr>
                                        <td>PAGOS A PROVEEDORES</td>
                                        <td></td>
                                        <td class="tdDerecha">'.number_format($sumTotalRecaudo,0).'</td>
                                        <td></td>
                                    </tr>';
                                echo '<tr>
                                        <td class="tdDerecha">Nacional</td>
                                        <td></td>
                                        <td class="tdDerecha">'.number_format($sumPagosProveeNal,0).'</td>
                                        <td></td>
                                    </tr>'; 
                                echo '<tr>
                                        <td class="tdDerecha">Importado</td>
                                        <td></td>
                                        <td class="tdDerecha">'.number_format($sumPagosProveeImp,0).'</td>
                                        <td></td>
                                    </tr>';
                                echo '<tr>
                                        <td>GASTOS</td>
                                        <td></td>
                                        <td class="tdDerecha">'.number_format($sumTotalGastos,0).'</td>
                                        <td></td>
                                    </tr>';
                                echo '<tr>
                                        <td class="tdDerecha">Nacional</td>
                                        <td></td>
                                        <td class="tdDerecha">'.number_format($SumGastosNacional,0).'</td>
                                        <td></td>
                                    </tr>'; 
                                echo '<tr>
                                        <td class="tdDerecha">Importado</td>
                                        <td></td>
                                        <td class="tdDerecha">'.number_format($SumGastosImportado,0).'</td>
                                        <td></td>
                                    </tr>';
                                echo '<tr>
                                        <td class="tdDerecha">Otros Gastos</td>
                                        <td></td>
                                        <td class="tdDerecha">'.number_format($SumGastosOtros,0).'</td>
                                        <td></td>
                                    </tr>';
                                echo '<tr>
                                        <td>CREDITOS OTROS CONCEPTOS</td>
                                        <td></td>
                                        <td></td>
                                        <td class="tdDerecha">'.number_format($sumTotalCreditoOtrosIngresos,0).'</td>                                        
                                    </tr>';
                                echo '<tr>
                                        <td>RECAUDOS CREDITOS ANTERIORES</td>
                                        <td></td>
                                        <td></td>
                                        <td class="tdDerecha">'.number_format($sumTotalRecaudoNoVentas,0).'</td>
                                    </tr>';                                
                                echo '<tr id="trColor">
                                        <td>EJERCICIO</td>
                                        <td class="tdDerecha">'.number_format($sumTotalInventario,0).'</td>
                                        <td class="tdDerecha">'.number_format($sumUtilidad,0).'</td>
                                        <td class="tdDerecha">'.number_format($sumUtilidadOtrosIngresos,0).'</td>
                                    </tr>';
									
                                echo '<tr id="trColor">
                                        <td class="tdDerecha">Caja Nacional</td>
										<td></td>
                                        <td class="tdDerecha">'.number_format($sumCajaNacional,0).'</td>
                                    </tr>';

                                echo '<tr id="trColor">
                                        <td class="tdDerecha">Caja Importado</td>
										<td></td>
                                        <td class="tdDerecha">'.number_format($sumCajaImportado,0).'</td>
                                    </tr>';

									echo '<tr id="trColor">
                                        <td class="tdDerecha">Bancos</td>
										<td></td>
                                        <td class="tdDerecha">'.number_format($SumBancos,0).'</td>
                                    </tr>';
									
                                ?>
                                        
                                </table>
                                </form>  
                   
                    <?php
                    if($sumTotalInventario>0 && $sumSubTotal>0)
                    {?>
                    
                    <br><br>
                    <h1>Inventario VS Remisiones VS Recaudos</h1>
                    <br>
                        
                    <?php
                    }
                    ?>
                    
                    <div id="superContenedorCanvas">
                        <div id="contenedorCanvas">
                            <canvas id="canvas">                            
                            </canvas>
                        </div>
                    </div>
                <script>
                    if($('#sumInvtrHidden').val() > 0 && $('#sumRemisionHidden').val() > 0 && $('#sumOtrosHidden').val() > 0) 
                    {
                    
                        var randomScalingFactor = function(){ return Math.round(Math.random()*100)};

                        var barChartData = {
                                labels : ["Inventario","Remision", "Recaudos"],
                                datasets : [
                                        {
                                                fillColor : "rgba(151,187,205,0.5)",
                                                strokeColor : "rgba(151,187,205,0.8)",
                                                highlightFill : "rgba(151,187,205,0.75)",
                                                highlightStroke : "rgba(151,187,205,1)",
                                                data : [$('#sumInvtrHidden').val(),$('#sumRemisionHidden').val(), $('#sumOtrosHidden').val()]
                                        }
                                ]

                        }
                        window.onload = function(){
                                var ctx = document.getElementById("canvas").getContext("2d");
                                window.myBar = new Chart(ctx).Bar(barChartData, {
                                        responsive : true
                                });
                        }
                    }   
                </script>
                    
                    
                            <?php        
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