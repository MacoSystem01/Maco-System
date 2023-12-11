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
        <script src="../../js/alertify/alertify.js"></script>
        <link href="../../css/alertify/alertify.css" rel="stylesheet">
        <link href="../../css/alertify/themes/default.css" rel="stylesheet">
        <title>MACO | ART. VENDIDOS</title>
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
                <h1>SALIDA ARTICULOS EN VENTA</h1>
                
                <?php
                if($_POST)
                {?>
                    <form id="formReporteArticleVendido" method="post">
                        <?php 
                        echo '<input id="txbFechaInicio" min="1979-12-31" max="2200-12-31" name="txbFechaInicio" type="date" placeholder="DESDE" required value="'.$_POST['txbFechaInicio'].'">'; 
                        echo '<input id="txbFechaFin" min="1979-12-31" max="2200-12-31" name="txbFechaFin" type="date" placeholder="HASTA" required value="'.$_POST['txbFechaFin'].'">';
                        echo '<input id="txbReferencia" name="txbReferencia" type="text" placeholder="REFERENCIA" value="'.$_POST['txbReferencia'].'" >';
                        ?>                        
                        <input id="btnConsultarArticuloVendido" type="submit" value="Consultar">
                        <input id="btnGenerarArticuloVendido" type="submit" value="Generar PDF">
                    </form>    
                <?php
                }
                else
                {?>
                    <form id="formReporteArticleVendido" method="post">
                        <?php 
                        $dateNow = date("Y-m-d");
                        echo '<input id="txbFechaInicio" min="1979-12-31" max="2200-12-31" name="txbFechaInicio" type="date" placeholder="DESDE" required value="'.$dateNow.'">'; 
                        echo '<input id="txbFechaFin" min="1979-12-31" max="2200-12-31" name="txbFechaFin" type="date" placeholder="HASTA" required value="'.$dateNow.'">';
                        ?>
                        <input id="txbReferencia" name="txbReferencia" type="text" placeholder="REFERENCIA" >
                        <input id="btnConsultarArticuloVendido" type="submit" value="Consultar">
                        <input id="btnGenerarArticuloVendido" type="submit" value="Generar PDF">
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

                        if ($objStockImpl->getCountByAlmacenBetweenDateReportArticle($_POST['txbFechaInicio'], $_POST['txbFechaFin'], $_POST['txbReferencia']) > 0)
                        {
                            $tb = 0;
                    ?>

                        <form method="post">
                        <table>
                            <tr>
                                <th>Ord. COMPRA</th>
                                <th>FECHA</th>
                                <th>REFERENCIA</th>
                                <th>ARTICULO</th>
                                <th>CANTIDAD</th>
                                <th>VLR. UNITARIO</th>
                                <th>VLR. TOTAL</th>
                            </tr>

                        <?php
                        foreach ($objStockImpl->getByArticleVendiBetweenDate($_POST['txbFechaInicio'], $_POST['txbFechaFin'], $_POST['txbReferencia']) as $valorStock) {
                            $entradas = $objStockImpl->getCountArticleIn($_POST['txbFechaInicio'], $_POST['txbFechaFin'], $valorStock->getCode());
                            $salidas = $objStockImpl->getCountArticleOut($_POST['txbFechaInicio'], $_POST['txbFechaFin'], $valorStock->getCode());
                            $existencias = $entradas-$salidas;
                            
                            echo '<tr>
                                <td>'.$valorStock->getCode().'</td>
                                <td>'.$valorStock->getMoveDate().'</td>
                                <td>'.$valorStock->getArticulo().'</td>
                                <td>'.$valorStock->getName().'</td>
                                <td>'.$valorStock->getQuantity().'</td>
                                <td class="tdDerecha">'.number_format($valorStock->getVlrUnit()).'</td>
                                <td class="tdDerecha">'.number_format($valorStock->getVlrTot()).'</td>
                            </tr>';

							$tb += $valorStock->getValueSale();

                        }                                
                        ?>

                        </table>
                        </form>  
                    
                    <?php
                        }
                        if(strcmp($_POST['txbReferencia'], "") == 0)
                                {
                            echo '<p>SubTotal Cantidad: '.number_format ($objStockImpl->getSumByBill($_POST['txbFechaInicio'], $_POST['txbFechaFin'], strtoupper($_POST['txbReferencia'])));                              
                                }
                        if(strcmp($_POST['txbReferencia'], "") != 0)
                            echo '<p>SubTotal Cantidad: '.number_format ($objStockImpl->getSumByBill($_POST['txbFechaInicio'], $_POST['txbFechaFin'], strtoupper($_POST['txbReferencia'])));                              
                        else
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