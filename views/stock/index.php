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
    <script src="../../js/search.js"></script>
    <title>MACO | INVENTARIO</title>
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
                </div>
                <div class="arrowImgRight">
                    <img src="../../res/arrow-25-16.png">
                </div>
                <div class="opcionSeleccionada">
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
            <div class="encabezadoContenido">
                <div class="tituloContenido">
                    <h1>GESTIÓN INVENTARIO</h1>
                </div>
                <div class="agregarDato">
                    <a href="add_stock.php"><input type="button" value="Agregar"></a>
                </div>
                <div class="buscar">
                    <input type="text" id="txbSearchStock" placeholder="Buscar...">
                </div>
            </div>
            <div class="listado">

                <form method="post" action="">
                    <table>
                        <tr>
                            <th>REFERENCIA</th>
                            <th>ARTICULO</th>
                            <th>MOVIMIENTO</th>
                            <th>CANTIDAD</th>
                            <th>FECHA</th>
                            <th>ACCIÓN</th>
                        </tr>

                        <?php
                            require '../../models/StockImpl.php';
                            $objStockImpl = new StockImpl();
                            $cont = 0;
                            
                            foreach ($objStockImpl->getAll() as $valor) {
                                if($cont%2 != 0){?>
                        <tr id="tdColor">
                            <?php
                                }else{?>
                        <tr>
                            <?php }?>
                            <td>
                                <?php echo $valor->getCode(); ?>
                            </td>
                            <td>
                                <?php echo $valor->getName(); ?>
                            </td>
                            <?php
                                    if(strcmp ($valor->getMove(), 'E') == 0 || strcmp ($valor->getMove(), 'e') == 0)
                                        echo '<td>ENTRADA</td>';
                                    else if(strcmp ($valor->getMove(), 'S') == 0 || strcmp ($valor->getMove(), 's') == 0)
                                        echo '<td>SALIDA</td>';
                                    else if(strcmp ($valor->getMove(), 'V') == 0 || strcmp ($valor->getMove(), 'v') == 0)
                                        echo '<td>VENTA</td>';
                                    else
                                        echo '<td></td>';
                                    ?>
                            <td class="tdDerecha">
                                <?php echo number_format($valor->getQuantity(),0); ?>
                            </td>

                            <td class="tdDerecha">
                                <?php echo $valor->getMoveDate(); ?>
                            </td>

                            <?php
                                //if(strcmp ($valor->getUbication(), 'B') == 0 || strcmp ($valor->getUbication(), 'b') == 0)
                                //echo '<td>BODEGA</td>';
                                //else if(strcmp ($valor->getUbication(), 'A') == 0 || strcmp ($valor->getUbication(), 'a') == 0)
                                //echo '<td>ALMACEN</td>';
                                //else
                                //echo '<td></td>';
                            ?>


                            <td id="tdAcciones">
                                <?php
                                        echo '<a href="edit_stock.php?id='.$valor->getCode().'&n='.$valor->getName().'&c='.$valor->getQuantity().'&f='.$valor->getMoveDate().'"><img src="../../res/edit-16.png"></a>';                                                                                
                                        ?>
                            </td>
                            <?php
                                //f(strcmp ($valor->getMove(), 'E') == 0 || strcmp ($valor->getMove(), 'e') == 0)//si es una entrada
                                //{
                                //if(strcmp ($valor->getUbication(), 'B') == 0 || strcmp ($valor->getUbication(), 'b') == 0)//si esta en bodega
                                //echo '<a href="../../controllers/ctrlMoveStock.php?id='.$valor->getCode().'&m='.$valor->getMove().'&fm='.$valor->getMoveDate().'"><img src="../../res/send-file-16.png"></a>';                                        

                                //}
                                //echo '<a href="../../controllers/ctrlDeleteStock.php?id='.$valor->getCode().'&m='.$valor->getMove().'&fm='.$valor->getMoveDate().'"><img src="../../res/delete-16.png"></a>';                                        
                            ?>

                        </tr>
                        <?php
                            $cont++;
                            }
                            ?>
                    </table>
                </form>

                <?php echo '<p>Ultimos registros de '.$objStockImpl->getCount().' encontrados</p>';   ?>

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
    echo '<script>document.location.href = "http://'.$ip.'/baruk/login.php"; </script>'; //ORGANIZAR LA REDIRECCIÓN
}
?>