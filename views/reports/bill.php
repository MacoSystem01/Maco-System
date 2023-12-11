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
        <link rel="icon" href="../../res/favicon.png" type="image/png" sizes="16x16">
        <script src="../../js/jquery/jquery.js"></script>
        <script src="../../js/forms.js"></script>
        <script src="../../js/ctrlsReports.js"></script>
        <script src="../../js/alertify/alertify.js"></script>
        <link href="../../css/alertify/alertify.css" rel="stylesheet">
        <link href="../../css/alertify/themes/default.css" rel="stylesheet">
        <title>MACO | Ord. COMPRA</title>
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
                <h1>Ord. COMPRA POR FECHA</h1>
                
                <?php
                if($_POST)
                {
                   ?>
                
                
                    <form id="formReporteRemision" method="post">
                        <?php 
                        echo '<input id="txbFechaInicio" min="1979-12-31" max="2200-12-31" name="txbFechaInicio" type="date" placeholder="DESDE" required value="'.$_POST['txbFechaInicio'].'">'; 
                        echo '<input id="txbFechaFin" min="1979-12-31" max="2200-12-31" name="txbFechaFin" type="date" placeholder="HASTA" required value="'.$_POST['txbFechaFin'].'">';
                        echo '<input id="txbReferencia" name="txbReferencia" type="text" placeholder="REFERENCIA" value="'.$_POST['txbReferencia'].'">';
                        echo '<input id="txbArticulo" name="txbArticulo" type="text" placeholder="ARTICULO" value="'.$_POST['txbArticulo'].'">';
                        echo '<input id="txbCliente" name="txbCliente" type="text" placeholder="NIT/CC CLIENTE" value="'.$_POST['txbCliente'].'">';
                        
                        if(strcmp($_POST['comboPayment'], "TODOS") == 0)
                            echo '<select name="comboPayment"><option value="TODOS" selected>TODOS</option><option value="CONTADO">CONTADO</option><option value="CREDITO">CREDITO</option></select>';
                        else if(strcmp($_POST['comboPayment'], "CONTADO") == 0)
                            echo '<select name="comboPayment"><option value="TODOS">TODOS</option><option value="CONTADO" selected>CONTADO</option><option value="CREDITO">CREDITO</option></select>';
                        else if(strcmp($_POST['comboPayment'], "CREDITO") == 0)
                            echo '<select name="comboPayment"><option value="TODOS">TODOS</option><option value="CONTADO">CONTADO</option><option value="CREDITO" selected>CREDITO</option></select>';
                        
                        echo '<input id="btnConsultarRemision" type="submit" value="Consultar"><label> </label>';
                        echo '<input id="btnGenerarRemision" type="submit" value="Generar PDF">';                        
                        ?>
                    </form>    
                <?php
                }
                else
                {?>
                    <form id="formReporteRemision" method="post">
                        <?php 
                        $dateNow = date("Y-m-d");
                        echo '<input id="txbFechaInicio" min="1979-12-31" max="2200-12-31" name="txbFechaInicio" type="date" placeholder="DESDE" required value="'.$dateNow.'">'; 
                        echo '<input id="txbFechaFin" min="1979-12-31" max="2200-12-31" name="txbFechaFin" type="date" placeholder="HASTA" required value="'.$dateNow.'">';
                        ?>
                        <input id="txbReferencia" name="txbReferencia" type="text" placeholder="REFERENCIA">
                        <input id="txbArticulo" name="txbArticulo" type="text" placeholder="ARTICULO">
                        <input id="txbCliente" name="txbCliente" type="text" placeholder="NIT/CC CLIENTE">
                        
                        <select name="comboPayment">
                            <option value="TODOS">TODOS</option>
                            <option value="CONTADO">CONTADO</option>
                            <option value="CREDITO">CREDITO</option>
                        </select>
                        
                        <input id="btnConsultarRemision" type="submit" value="Consultar"><label> </label>
                        <input id="btnGenerarRemision" type="submit" value="Generar PDF">
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
                                
                                require_once '../../models/BillImpl.php';
                                $objBillImpl = new BillImpl();
                                
                                if ($objBillImpl->getCountByReport($_POST['txbFechaInicio'], $_POST['txbFechaFin'], $_POST['txbReferencia'], $_POST['txbArticulo'], $_POST['txbCliente'], $_POST['comboPayment']) > 0)
                                {
                                    $tb = 0;
                                ?>
                                                    
                                <form method="post">
                                <table>
                                    <tr>
                                        <th>FECHA</th>
                                        <th>Ord. COMPRA</th>
                                        <th>NIT/CC</th>
                                        <th>CLIENTE</th>
                                        <th>PAGO</th> 
                                        <th>VALOR Ord. COMPRA</th>
                                    </tr>
                            
                                <?php
                                require_once '../../models/ClientImpl.php';
                                $objClientImpl = new ClientImpl();
                                
                                foreach ($objBillImpl->getByReport($_POST['txbFechaInicio'], $_POST['txbFechaFin'], $_POST['txbReferencia'], $_POST['txbArticulo'], $_POST['txbCliente'], $_POST['comboPayment']) as $valorStock) {
                                    echo '<tr>
                                        <td>'.$valorStock->getGenerationDate().'</td>
                                        <td>'.$valorStock->getCode().'</td>
                                        <td>'.$valorStock->getClient().'</td>';
                                        
                                        echo '<td>'.$objClientImpl->getNameClient($valorStock->getClient()).'</td>';
                                    
                                        if(strcmp ($valorStock->getPayment(), 'CO') == 0)
                                            echo '<td>CONTADO</td>';
                                        else if(strcmp ($valorStock->getPayment(), 'CR') == 0)
                                            echo '<td>CREDITO</td>';
                                    
                                        echo '<td class="tdDerecha">'.number_format($valorStock->getValueSale(),0).'</td>
                                    </tr>';
                                        
                                        $tb += $valorStock->getValueSale();
                                }                                
                                ?>
                                    
                                </table>
                                </form>  
                    
                            <?php
                                if(strcmp($_POST['txbCliente'], "") == 0)
                                {
                                    echo '<p>Total Remisiones: $ '.number_format ($tb).'</p>';                                    
                                }
                                if(strcmp($_POST['txbCliente'], "") != 0)
                                    echo '<p>Total Remisiones Cliente: $ '.number_format ($objBillImpl->getSumByClient($_POST['txbCliente'], $_POST['txbFechaInicio'], $_POST['txbFechaFin'], strtoupper($_POST['txbReferencia']), $_POST['comboPayment']));                              
                                }else
                                {
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