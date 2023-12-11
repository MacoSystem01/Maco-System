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
    <script src="../../js/search.js"></script>
    <title>MACO | Ord. Compra</title>
</head>

<body>
    <section class="contenedor">
        <header>
            <div class="logoEmpresa">
                <a href="../../index.php"><img src="../../res/logo.png"></a>
            </div>
            <div class="sesion">
                Salir<a href="../../controllers/ctrlLogout.php"><img src="../../res/logout-24.png"></a>
            </div>
            <div class="contenedorRutaApp">
                <div class="nombreAplicacion">
                    MACO System "Sistema de Registro Contable"
                </div>
                <div class="arrowImgRight">
                    <img src="../../res/arrow-25-16.png">
                </div>
                <div class="opcionSeleccionada">
                    ORDEN DE COMPRA
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
            <h1>ORDEN DE COMPRA</h1>

            <?php                
                if(isset($_GET)){?>
            <form method="post" action="../../controllers/ctrlEditBill.php">
                <?php   
                    require '../../models/BillImpl.php';
                    $objBillImpl = new BillImpl();
                    
                    $billNumber;
                    ?>
                <table>
                    <?php
                    foreach ($objBillImpl->getByCode($_GET['id']) as $valor) {
                        $billNumber = $valor->getCode();
                        
                        require '../../models/ClientImpl.php';
                        $objClientImpl = new ClientImpl();
                        $client = $objClientImpl->getNameClient($valor->getClient());
                        
                    ?>

                    <tr>
                        <th>ORDEN COMPRA No</th>
                        <th>NIT/CC</th>
                        <th>CLIENTE</th>
                        <th>FECHA</th>
                        <th>VENTA</th>
                        <th>PAGO</th>
                    </tr>

                    <?php
                            if($cont%2 != 0){?>
                    <tr id="tdColor">
                        <?php
                                }else{?>
                    <tr>
                        <?php }
                                ?>
                        <td>
                            <?php echo $valor->getCode(); ?>
                        </td>
                        <td>
                            <?php echo $valor->getClient(); ?>
                        </td>
                        <td>
                            <?php echo $client; ?>
                        </td>
                        <td>
                            <?php echo $valor->getGenerationDate(); ?>
                        </td>
                        <td>
                            <?php echo number_format($valor->getValueSale(),0); ?>
                        </td>

                        <?php
                                        if(strcmp ($valor->getPayment(), 'CO') == 0)
                                            echo '<td>CONTADO</td>';
                                        else if(strcmp ($valor->getPayment(), 'CR') == 0)
                                            echo '<td>CREDITO</td>';                                                                      
                                        ?>
                    </tr>
                    <?php
                            $cont++;
                            }
                            ?>


                </table>


            </form>
            <?php                
                    }
                ?>



            <div class="encabezadoContenido">
                <div class="tituloContenido">
                    <h1>Detalles</h1>
                </div>
                <div class="agregarDato"></div>
                <div class="buscar">
                </div>
            </div>


            <div class="listado">
                <form method="post" action="">
                    <table>
                        <tr>
                            <th>REFERENCIA</th>
                            <th>ARTICULO</th>
                            <th>CANTIDAD</th>
                            <th>VALOR UNITARIO</th>
                            <th>VALOR TOTAL</th>
                        </tr>

                        <?php
                            require '../../models/DetailImpl.php';
                            require '../../models/StockImpl.php';
                            
                            $objDetailImpl = new DetailImpl();
                            $cont = 0;
                            
                            foreach ($objDetailImpl->getByCode($billNumber) as $valor) {
                                
                                
                                if($cont%2 != 0){?>
                        <tr id="tdColor">
                            <?php
                                }else{?>
                        <tr>
                            <?php }
                                
                                $objStockImpl = new StockImpl();
                                $article = $objStockImpl->getNameArticle($valor->getCodeArticle());
                                
                                ?>
                            <td>
                                <?php echo $valor->getCodeArticle() ?>
                            </td>
                            <td>
                                <?php echo $article; ?>
                            </td>
                            <td class="tdDerecha">
                                <?php echo number_format($valor->getQuantity(),0) ?>
                            </td>
                            <td class="tdDerecha">
                                <?php echo number_format($valor->getValueUnit(),0); ?>
                            </td>
                            <td class="tdDerecha">
                                <?php echo number_format($valor->getTotal(),0); ?>
                            </td>
                        </tr>
                        <?php
                            $cont++;
                            }
                            ?>
                    </table>
                </form>


            </div>

            <div class="encabezadoContenido">
                <div class="tituloContenido"></div>
                <div class="agregarDato"></div>
                <div class="buscar">
                    <?php echo '<a target="_blank" href="../../controllers/ctrlPrintBill.php?id='.$billNumber.'"><input type="button" value="Imprimir"></a>'; ?>
                </div>
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