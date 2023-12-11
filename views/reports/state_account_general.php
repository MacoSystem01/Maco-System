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
        <title>MACO | REPORTE ESTADO DE CUENTA GENERAL</title>
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
                <h1>ESTADO DE CUENTA GENERAL</h1>
                
                <?php
                if($_POST)
                {?>
                    <form id="formReporteEstadoCuentaGeneral" method="post">
                        <?php 
                        /*echo '<input id="txbClienteRC" name="txbCliente" type="text" placeholder="NIT/CC CLIENTE" value="'.$_POST['txbCliente'].'">';
                        echo '<input id="txbCreditoRC" name="txbCredito" type="number" placeholder="CODIGO CREDITO" value="'.$_POST['txbCredito'].'">';                        
                        echo '<input id="txbRemisionRC" name="txbRemision" type="number" placeholder="CODIGO REMISION" value="'.$_POST['txbRemision'].'">';*/                        
                        echo '<input id="txbFechaInicio" min="1979-12-31" max="2200-12-31" name="txbFechaInicio" type="date" placeholder="DESDE" required value="'.$_POST['txbFechaInicio'].'">'; 
                        echo '<input id="txbFechaFin" min="1979-12-31" max="2200-12-31" name="txbFechaFin" type="date" placeholder="HASTA" required value="'.$_POST['txbFechaFin'].'">';
                        
                        ?>                        
                        <input id="btnConsultarEstadoCuentaGeneral" type="submit" value="Consultar">
                        <input id="btnGenerarEstadoCuentaGeneral" type="submit" value="Generar PDF">
                    </form>    
                <?php
                }
                else
                {?>
                    <form id="formReporteEstadoCuentaGeneral" method="post">
                        <?php 
                        /*echo '<input id="txbClienteRC" name="txbCliente" type="text" placeholder="NIT/CC CLIENTE">';
                        echo '<input id="txbCreditoRC" name="txbCredito" type="number" placeholder="CODIGO CREDITO">';                        
                        echo '<input id="txbRemisionRC" name="txbRemision" type="number" placeholder="CODIGO REMISION">';    */
                        $dateNow = date("Y-m-d");
                        echo '<input id="txbFechaInicio" min="1979-12-31" max="2200-12-31" name="txbFechaInicio" type="date" placeholder="DESDE" required value="'.$dateNow.'">'; 
                        echo '<input id="txbFechaFin" min="1979-12-31" max="2200-12-31" name="txbFechaFin" type="date" placeholder="HASTA" required value="'.$dateNow.'">';
                        ?>
                        
                        <input id="btnConsultarEstadoCuentaGeneral" type="submit" value="Consultar">
                        <input id="btnGenerarEstadoCuentaGeneral" type="submit" value="Generar PDF">
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
                            require_once '../../models/CreditImpl.php';
                            $objCreditImpl = new CreditImpl();
                            
                            require_once '../../models/ClientImpl.php';
                            require_once '../../models/DepartmentImpl.php';
                            require_once '../../models/LocalityImpl.php';

                            if ($objCreditImpl->getCountCreditOnlyBetweenDate($_POST['txbFechaInicio'], $_POST['txbFechaFin']) > 0)
                            {
                                
                            $totalCreditos = 0;
                            $totalAbonos = 0;
                            $totalSaldos = 0;
                                
                            ?>
                                <form method="post">
                                <table>
                                    <tr>
                                        <th>CRÉDITO</th>
                                        <th>REMISIÓN</th>
                                        <th>CLIENTE</th>
                                        <th>DIRECCIÓN</th>
                                        <th>CELULAR</th>
                                        <th>CIUDAD</th>
                                        <th>FECHA</th>
                                        <th>VALOR</th>
                                        <th>SALDO</th>
                                        <th>DIAS MORA</th>
                                    </tr>

                                <?php
                                foreach ($objCreditImpl->getCreditOnlyBetweenDate($_POST['txbFechaInicio'], $_POST['txbFechaFin']) as $valorCredit)
                                {
                                    $objClientImpl = new ClientImpl();
                                    $nameClient = $objClientImpl->getNameClient($valorCredit->getCodeClient());
                                    $addressClient = $objClientImpl->getAddressClient($valorCredit->getCodeClient());
                                    $mobileClient = $objClientImpl->getMobileClient($valorCredit->getCodeClient());
                                    $idDpto = $objClientImpl->getDepartment($valorCredit->getCodeClient());
                                    $idLclt = $objClientImpl->getLocality($valorCredit->getCodeClient());
                                    
                                    $objDepartmentImpl = new DepartmentImpl();
                                    $objLocalityImpl = new LocalityImpl();
                                    
                                    echo '<tr>
                                        <td class="tdDerecha">'.$valorCredit->getCode().'</td>
                                        <td class="tdDerecha">'.$valorCredit->getCodeBill().'</td>
                                        <td>'.$valorCredit->getCodeClient().' - '.$nameClient.'</td>
                                        <td>'.$addressClient.'</td>
                                        <td>'.$mobileClient.'</td>
                                        <td>'.$objLocalityImpl->getNameLocality($idLclt).'</td>
                                        <td>'.$valorCredit->getRegistrationDate().'</td>
                                        <td class="tdDerecha">'.number_format($valorCredit->getValue()).'</td>
                                        <td class="tdDerecha">'.number_format($valorCredit->getSaldo()).'</td>
                                        <td class="tdDerecha">'.floor($objCreditImpl->getDaysMora($valorCredit->getCode())).'</td>';
                                    
                                    $totalCreditos += $valorCredit->getValue();
                                    $totalAbonos += ($valorCredit->getValue() - $valorCredit->getSaldo());
                                    $totalSaldos += $valorCredit->getSaldo();
                                } 
                                
                                echo '<tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="tdDerecha">'.number_format($totalCreditos).'</td>
                                    <td class="tdDerecha">'.number_format($totalSaldos).'</td>
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