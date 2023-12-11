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
        <script src="../../js/ctrlsReports.js"></script>
        <script src="../../js/alertify/alertify.js"></script>
        <link href="../../css/alertify/alertify.css" rel="stylesheet">
        <link href="../../css/alertify/themes/default.css" rel="stylesheet">
        <title>Reporte Estado de Cuenta</title>
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
                <h1>Estado de Cuenta x Cliente</h1>
                
                <?php
                if($_POST)
                {?>
                    <form id="formReporteEstadoCuenta" method="post">
                        <?php 
                        echo '<input id="txbClienteRC" name="txbCliente" type="text" placeholder="NIT/CC CLIENTE" value="'.$_POST['txbCliente'].'">';
                        echo '<input id="txbCreditoRC" name="txbCredito" type="number" placeholder="CODIGO CREDITO" value="'.$_POST['txbCredito'].'">';                        
                        echo '<input id="txbRemisionRC" name="txbRemision" type="number" placeholder="CODIGO REMISION" value="'.$_POST['txbRemision'].'">';                        
                        echo '<input id="txbFechaInicio" min="1979-12-31" max="2200-12-31" name="txbFechaInicio" type="date" placeholder="DESDE" required value="'.$_POST['txbFechaInicio'].'">'; 
                        echo '<input id="txbFechaFin" min="1979-12-31" max="2200-12-31" name="txbFechaFin" type="date" placeholder="HASTA" required value="'.$_POST['txbFechaFin'].'">';
                        
                        ?>                        
                        <input id="btnConsultarEstadoCuenta" type="submit" value="Consultar">
                        <input id="btnGenerarEstadoCuenta" type="submit" value="Generar PDF">
                    </form>    
                <?php
                }
                else
                {?>
                    <form id="formReporteEstadoCuenta" method="post">
                        <?php 
                        echo '<input id="txbClienteRC" name="txbCliente" type="text" placeholder="NIT/CC CLIENTE">';
                        echo '<input id="txbCreditoRC" name="txbCredito" type="number" placeholder="CODIGO CREDITO">';                        
                        echo '<input id="txbRemisionRC" name="txbRemision" type="number" placeholder="CODIGO REMISION">';    
                        $dateNow = date("Y-m-d");
                        echo '<input id="txbFechaInicio" min="1979-12-31" max="2200-12-31" name="txbFechaInicio" type="date" placeholder="DESDE" required value="'.$dateNow.'">'; 
                        echo '<input id="txbFechaFin" min="1979-12-31" max="2200-12-31" name="txbFechaFin" type="date" placeholder="HASTA" required value="'.$dateNow.'">';
                        ?>
                        
                        <input id="btnConsultarEstadoCuenta" type="submit" value="Consultar">
                        <input id="btnGenerarEstadoCuenta" type="submit" value="Generar PDF">
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
                        if(strcmp($_POST['txbCliente'],"")!= 0  || strcmp($_POST['txbCredito'], "") != 0  || strcmp($_POST['txbRemision'], "") != 0)
                        {
                            require_once '../../models/CreditImpl.php';
                            $objCreditImpl = new CreditImpl();
                            
                            require_once '../../models/CollectImpl.php';
                            $objCollectImpl = new CollectImpl();

                            require_once '../../models/ClientImpl.php';
                            $objClientImpl = new ClientImpl();
                            
                            require_once '../../models/DepartmentImpl.php';
                            require_once '../../models/LocalityImpl.php';
                            
                            if ($objCreditImpl->getCountCreditBetweenDate($_POST['txbFechaInicio'], $_POST['txbFechaFin'], $_POST['txbCliente'], $_POST['txbCredito'],  $_POST['txbRemision']) > 0)
                            {
                                
                            $valorTotalCreditos = 0;
                            $valorTotalAbonos = 0;
                            $valorTotalSaldos = 0;
                                
                            ?>
                                <form method="post">
                                <table>
                                    <tr>
                                        <th>CREDITO</th>
                                        <th>REMISION</th>
                                        <th>CLIENTE</th>
                                        <th>DEPARTAMENTO</th>
                                        <th>CIUDAD</th>
                                        <th>FECHA</th>
                                        <th>VALOR</th>
                                        <th>ABONO</th>
                                        <th>SALDO</th>
                                        <th>DIAS MORA</th>
                                    </tr>
                                                 
                                    
                                <?php
                                
                                foreach ($objCreditImpl->getCreditBetweenDate($_POST['txbFechaInicio'], $_POST['txbFechaFin'], $_POST['txbCliente'], $_POST['txbCredito'],  $_POST['txbRemision']) as $valorCredit)
                                {
                                    $objClientImpl = new ClientImpl();
                                    $nameClient = $objClientImpl->getNameClient($valorCredit->getCodeClient());

                                    $objDepartmentImpl2 = new DepartmentImpl();
                                    $objLocalityImpl2 = new LocalityImpl();

                                    $idDpto2 = $objClientImpl->getDepartment($valorCredit->getCodeClient());
                                    $idLclt2 = $objClientImpl->getLocality($valorCredit->getCodeClient());

                                    echo '<tr>
                                        <td class="tdDerecha">'.$valorCredit->getCode().'</td>
                                        <td class="tdDerecha">'.$valorCredit->getCodeBill().'</td>
                                        <td>'.$valorCredit->getCodeClient().' - '.$nameClient.'</td>
                                        <td>'.$objDepartmentImpl2->getNameDepartment($idDpto2).'</td>    
                                        <td>'.$objLocalityImpl2->getNameLocality($idLclt2).'</td>
                                        <td>'.$valorCredit->getRegistrationDate().'</td>
                                        <td class="tdDerecha">'.number_format($valorCredit->getValue()).'</td>
                                        <td class="tdDerecha">0</td>
                                        <td class="tdDerecha">'.number_format($valorCredit->getValue()).'</td>
                                        <td class="tdDerecha">'.floor($objCreditImpl->getDaysMora($valorCredit->getCode())).'</td>';

                                        $valorTotalCreditos += $valorCredit->getValue();
                                        
                                    
                                    foreach($objCollectImpl->getByCredit($valorCredit->getCode()) as $valorCollect)
                                    {                                                                    
                                        $numBill = $objCreditImpl->getBill($valorCollect->getCodeCredit());
                                        $idClient = $objCreditImpl->getClient($valorCollect->getCodeCredit());
                                        $nameClient = $objClientImpl->getNameClient($idClient);

                                        $objDepartmentImpl = new DepartmentImpl();
                                        $objLocalityImpl = new LocalityImpl();

                                        $idDpto = $objClientImpl->getDepartment($idClient);
                                        $idLclt = $objClientImpl->getLocality($idClient);

                                        $valueCredit = $objCreditImpl->getValue($valorCollect->getCodeCredit());
                                        $pagosAnteriores = $objCollectImpl->getPagosAnterioresFecha($valorCollect->getRegistrationDate(), $valorCollect->getCodeCredit());

                                        echo '<tr>
                                            <td class="tdDerecha">'.$valorCollect->getCodeCredit().'</td>
                                            <td class="tdDerecha">'.$numBill.'</td>
                                            <td>'.$idClient.' - '.$nameClient.'</td>
                                            <td>'.$objDepartmentImpl->getNameDepartment($idDpto).'</td>    
                                            <td>'.$objLocalityImpl->getNameLocality($idLclt).'</td>
                                            <td>'.$valorCollect->getRegistrationDate().'</td>
                                            <td class="tdDerecha">'.number_format($valueCredit).'</td>
                                            <td class="tdDerecha">'.number_format($valorCollect->getValue()).'</td>
                                            <td class="tdDerecha">'.  number_format($valueCredit-$pagosAnteriores).'</td>';
                                        
//                                            if( ($valueCredit-$pagosAnteriores) == 0)
//                                                echo '<td class="tdDerecha">0</td>';
//                                            else
                                                echo '<td class="tdDerecha">'.floor($objCreditImpl->getDaysMora($valorCollect->getCodeCredit())).'</td>';

                                            $valorTotalAbonos += $valorCollect->getValue();    
                                    }
                                    
                                    $valorTotalSaldos = $valorTotalCreditos - $valorTotalAbonos;
                                    
                                    
                                }
                                
                                    echo '<tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="tdDerecha">'.number_format($valorTotalCreditos).'</td>
                                        <td class="tdDerecha">'.number_format($valorTotalAbonos).'</td>
                                        <td class="tdDerecha">'.number_format($valorTotalSaldos).'</td>
                                        <td></td>
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
                            echo '<script>alertify.error("Ningún parametro de búsqueda ingresado");</script>';
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