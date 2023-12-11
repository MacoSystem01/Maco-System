<?php
session_start();

include '../../com/server.php';
$server = new SimpleXMLElement($xmlstr);
$ip = $server->server[0]->ip;

if (!empty($_SESSION['userCode']) && !empty($_SESSION['userName']))
{
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../../css/style.css" rel="stylesheet">
        <script src="../../js/jquery/jquery.js"></script>
        <script src="../../js/forms.js"></script>
        <script src="../../js/ctrlsReports.js"></script>
        <script src="../../js/alertify/alertify.js"></script>
        <link href="../../css/alertify/alertify.css" rel="stylesheet">
        <link href="../../css/alertify/themes/default.css" rel="stylesheet">
        <title>MACO | REPORTE GASTOS</title>
        <link rel="icon" href="res/logo/frase.ico" type="image/x-icon">
        <link rel="shortcut icon" href="res/logo/frase.ico" type="image/x-icon">
    </head>
    <body>
        <section class="contenedor">
            <header>
                <div class="logoEmpresa">
                    <a href="../../index.php"><img src="../../res/logo/logo-1.png"></a>
                </div>
                <div class="sesion">
                    Salir<a href="../../controllers/ctrlLogout.php"><img src="../../res/logout-24.png"></a>
                </div>                    
                <div class="contenedorRutaApp">
                    <div class="nombreAplicacion">
                        MACO System "Sistema de Registro Contable"
                    </div><div class="arrowImgRight">
                        <img src="../../res/arrow-25-16.png">
                    </div><div class="opcionSeleccionada">
                        REPORTES
                    </div>
                </div>
            </header>
            
            <nav id="menu">
                <ul>
                    <li><a href="views/config/"><img src="../../../res/item/configuracion.png">CONFIGURACIÓN</a></li>
                    <li><a href="views/clients/"><img src="../../../res/item/clientes.png">CLIENTES</a></li>
                    <li><a href="views/stock/"><img src="../../../res/item/inventario.png">INVENTARIO</a></li>
                    <li><a href="views/bill"><img src="../../../res/item/compra.png">Ord. COMPRA</a></li>
                    <li><a href="views/spend/"><img src="../../../res/item/gasto.png">GASTOS</a></li>
                    <li><a href="views/credit/"><img src="../../../res/item/credito.png">CRÉDITO</a></li>
                    <li><a href="views/bill"><img src="../../../res/item/recaudo.png">RECAUDO</a></li>
                    <li><a href="views/spend/"><img src="../../../res/item/prestamo.png" style="height: 25px;">PRESTAMO</a></li>
                    <li><a href="views/credit/"><img src="../../../res/item/proveedor.png" style="height: 25px;">PROVEEDORES</a></li>
                    <li><a href="views/collect/"><img src="../../../res/item/nomina.png" style="height: 25px;">NOM. ELECTRONICA</a></li>
                    <li><a href="views/reports/"><img src="../../../res/item/reporte.png">REPORTES</a></li>
                </ul>
            </nav>
            
            <section class="contenido" id="contenidoGeneral2">
                <h1>GASTOS DE LA COMPAÑIA</h1>
                
                <?php
                if($_POST)
                {?>
                    <form id="formReporteGastos" method="post">
                        <?php 
                        echo '<input id="txbReciboRG" name="txbRecibo" type="number" placeholder="CODIGO RECIBO" value="'.$_POST['txbRecibo'].'">';
                        echo '<input id="txbClienteRG" name="txbCliente" type="text" placeholder="NIT/CC CLIENTE" value="'.$_POST['txbCliente'].'">';
                        echo '<input id="txbConceptoRG" name="txbConcepto" type="number" placeholder="CODIGO CONCEPTO" value="'.$_POST['txbConcepto'].'">';                                                
                        echo '<input id="txbFechaInicio" min="1979-12-31" max="2200-12-31" name="txbFechaInicio" type="date" placeholder="DESDE" required value="'.$_POST['txbFechaInicio'].'">'; 
                        echo '<input id="txbFechaFin" min="1979-12-31" max="2200-12-31" name="txbFechaFin" type="date" placeholder="HASTA" required value="'.$_POST['txbFechaFin'].'">';
                        
                        ?>                        
                        <input id="btnConsultarGastos" type="submit" value="Consultar">
                        <input id="btnGenerarGastos" type="submit" value="Generar PDF">
                    </form>    
                <?php
                }
                else
                {?>
                    <form id="formReporteGastos" method="post">
                        <?php 
                        
                        echo '<input id="txbReciboRG" name="txbRecibo" type="number" placeholder="CODIGO RECIBO">';
                        echo '<input id="txbClienteRG" name="txbCliente" type="text" placeholder="NIT/CC CLIENTE">';
                        echo '<input id="txbConceptoRG" name="txbConcepto" type="number" placeholder="CODIGO CONCEPTO">';                                                
                        
                        $dateNow = date("Y-m-d");
                        echo '<input id="txbFechaInicio" min="1979-12-31" max="2200-12-31" name="txbFechaInicio" type="date" placeholder="DESDE" required value="'.$dateNow.'">'; 
                        echo '<input id="txbFechaFin" min="1979-12-31" max="2200-12-31" name="txbFechaFin" type="date" placeholder="HASTA" required value="'.$dateNow.'">';
                        ?>
                        
                        <input id="btnConsultarGastos" type="submit" value="Consultar">
                        <input id="btnGenerarGastos" type="submit" value="Generar PDF">
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
                            require_once '../../models/SpendImpl.php';
                            $objSpendImpl = new SpendImpl();
                            
                            require_once '../../models/ClientImpl.php';
                            require_once '../../models/ConceptImpl.php';

                            if ($objSpendImpl->getCountSpendBetweenDate($_POST['txbFechaInicio'], $_POST['txbFechaFin'], $_POST['txbRecibo'], $_POST['txbCliente'],  $_POST['txbConcepto']) > 0)
                            {
                                
                            $totalRecibos = 0;
                                
                            ?>
                                <form method="post">
                                <table>
                                    <tr>
                                        <th>RECIBO</th>
                                        <th>CLIENTE</th>
                                        <th>CONCEPTO</th>
                                        <th>FECHA</th>                                        
                                        <th>VALOR</th>
                                    </tr>

                                <?php
                                foreach ($objSpendImpl->getSpendBetweenDate($_POST['txbFechaInicio'], $_POST['txbFechaFin'], $_POST['txbRecibo'], $_POST['txbCliente'],  $_POST['txbConcepto']) as $valorSpend)
                                {
                                    $objClientImpl = new ClientImpl();
                                    $nameClient = $objClientImpl->getNameClient($valorSpend->getCodeClient());
                                    
                                    $objConcepImpl = new ConceptImpl();
                                    $nameConcept = $objConcepImpl->getNameConcept($valorSpend->getCodeConcept());
                                    
                                    echo '<tr>
                                        <td class="tdDerecha">'.$valorSpend->getCode().'</td>
                                        <td>'.$valorSpend->getCodeClient().' - '.$nameClient.'</td>
                                        <td>'.$nameConcept.'</td>
                                        <td>'.$valorSpend->getGenerationDate().'</td>
                                        <td class="tdDerecha">'.number_format($valorSpend->getValue()).'</td>';
                                    
                                    $totalRecibos += $valorSpend->getValue();
                                } 
                                
                                echo '<tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="tdDerecha">'.number_format($totalRecibos).'</td>                                    
                                   <tr>';
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
                <p class="m-0 text-center">&copy; <a href="http://127.0.0.1:5500/login.html">MACO System Accountant</a>.
                    Reservados todos los derechos. Diseñado Por <a href="https://github.com/MacoSystem01" target="_blank">MACO
                        System</a><br>
                </p>
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