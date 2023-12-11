<?php
session_start();

include '../../com/server.php';
$server = new SimpleXMLElement($xmlstr);
$ip = $server->server[0]->ip;

if (!empty($_SESSION['userCode']) && !empty($_SESSION['userName']))
{
?>

<!DOCTYPE html>
<html lang="esp">
    <head>
        <meta charset="UTF-8">
        <link href="../../css/style.css" rel="stylesheet">
        <script src="../../js/jquery/jquery.js"></script>
        <script src="../../js/alertify/alertify.js"></script>
        <link href="../../css/alertify/alertify.css" rel="stylesheet">
        <link href="../../css/alertify/themes/default.css" rel="stylesheet">
        <title>MACO | INVENTARIO</title>
        <link rel="icon" href="res/logo/frase.ico" type="image/x-icon">
        <link rel="shortcut icon" href="res/logo/frase.ico" type="image/x-icon">
    </head>

    <body>
        <section class="contenedor">
            <header>
                <div class="logoEmpresa">
                    <a href="../../index.php">
                        <img src="../../res/logo/logo-1.png">
                    </a>
                </div>
                <div class="sesion">
                        Salir
                        <a href="../../controllers/ctrlLogout.php">
                            <img src="../../res/logout-24.png">
                        </a>
                    </div>                    
                <div class="contenedorRutaApp">
                    <div class="nombreAplicacion">
                        MACO System "Sistema de Registro Contable"
                    </div><div class="arrowImgRight">
                        <img src="../../res/arrow-25-16.png">
                    </div><div class="opcionSeleccionada">
                        INVENTARIO
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
            
            <section class="contenido" id="contenidoGeneral">
                <h1>Editar Inventario</h1>
                <form method="post" action="../../controllers/ctrlEditStock.php">
                    <?php 
                    if(isset($_GET))
                    {
                        include_once '../../models/Detail.php';
                        include_once '../../models/DetailImpl.php';
                        $objDetailImpl = new DetailImpl();
                        $objDetail  = new Detail();
                        
                        $objDetail->setCodeArticle($_GET['id']);
                        //echo "es: "+$objDetailImpl->getCountArticleFromDetail($objDetail);
                        if($objDetailImpl->getCountArticleFromDetail($objDetail) > 0)
                        {
                            echo '<input type="hidden" value="'.$_GET['id'].'" name="txbCodeHidden">';
                            echo '<input type="text" value="'.$_GET['id'].'" name="txbCode" placeholder="Referencia" maxlength="12" readonly required>';
                            echo '<input type="text" value="'.$_GET['n'].'" name="txbName" placeholder="Nombres" maxlength="60" readonly required>';
                            echo '<input type="text" value="'.$_GET['c'].'" name="txbQuantity" placeholder="Cantidad" maxlength="12" required>';
                            echo '<input type="text" value="'.$_GET['f'].'" name="txbDate" readonly>';
                            echo '<script>alertify.error("La referencia del artículo no se puede modificar, favor revisar remisiones");</script>'; 
                            echo '<input type="submit" value="Guardar">';
                        }
                        else
                        {
                            echo '<input type="hidden" value="'.$_GET['id'].'" name="txbCodeHidden">';
                            echo '<input type="text" value="'.$_GET['id'].'" name="txbCode" placeholder="Referencia" maxlength="12" required>';
                            echo '<input type="text" value="'.$_GET['n'].'" name="txbName" placeholder="Nombres" maxlength="60" required>';
                            echo '<input type="text" value="'.$_GET['c'].'" name="txbQuantity" placeholder="Cantidad" maxlength="12" required>';
                            echo '<input type="text" value="'.$_GET['f'].'" name="txbDate" readonly>';
                            echo '<input type="submit" value="Guardar">';
                        }
                        
                        include_once '../../models/Stock.php';
                        include_once '../../models/StockImpl.php';
                        $objStockImpl = new StockImpl();
                        

                        //foreach ($objStockImpl->getByCodeEdit($_GET[id]) as $valor) {
                            //echo '<input type="hidden" value="'.$valor->getCode().'" name="txbCodeHidden">';
                            //echo '<input type="number" value="'.$valor->getCode().'" name="txbCode" placeholder="Referencia" maxlength="12" required>';
                            //echo '<input type="text" value="'.$valor->getName().'" name="txbName" placeholder="Nombres" maxlength="60" required>';
//                            echo '<input type="text" value="'.$valor->getMove().'" name="txbMove" placeholder="Movimiento" maxlength="12" disabled>';
//                            echo '<input type="text" value="'.$valor->getQuantity().'" name="txbQunatity" placeholder="Cantidad" maxlength="12" required>';
//                            echo '<input type="text" value="'.$valor->getPriceBuy().'" name="txbPriceBuy" placeholder="Precio Compra" maxlength="14" required>';
//                            echo '<input type="text" value="'.$valor->getPriceSold().'" name="txbPriceSold" placeholder="Precio Venta" maxlength="14" required>';
                            
//                            echo '<select name = "selectUbication">';     
//                            if(strcmp ($valor->getUbication(), 'B') == 0)
//                                echo '<option value="B" selected="selected">BODEGA</option>';
//                            else if(strcmp ($valor->getUbication, 'A') == 0)
//                                echo '<option value="A" selected="selected">ALMACEN</option>';
//                            echo '</select>';                             
                            
//                            echo '<input type="text" value="'.$valor->getMoveDate().'" name="txbMoveDate" placeholder="Fecha Movimiento" maxlength="60" required>';
//                            echo '<input type="text" value="'.$valor->getUser().'" name="txbUser" placeholder="Usuario" maxlength="20" required>';                            
                            
                        //}                        
                        
                    }
                    else
                    {
                        
                    }                 
                    
                    
                    ?>                 
                    
                    
                </form>
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