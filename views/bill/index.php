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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../../css/style.css" rel="stylesheet">
        <script src="../../js/jquery/jquery.js"></script>
        <script src="../../js/search.js"></script>
        <title>MACO | Ord. Compra</title>
        <link rel="icon" href="res/logo/frase.ico" type="image/x-icon">
        <link rel="shortcut icon" href="res/logo/frase.ico" type="image/x-icon">
    </head>
    
    <body>
        <section class="contenedor">
            <header>
                <div class="logoEmpresa">
                    <a href="index.php"><img src="../../../res/logo/logo-1.png" class="logo-ini"></a>
                </div>
                <div class="sesion">
                </div>
                <div class="contenedorRutaApp">
                    <div class="nombreAplicacion">
                        MACO System "Sistema de Registro Contable"
                    </div>
                    <div class="arrowImgRight">
                        <img src="../../../res/arrow-25-16.png">
                    </div>
                    <div class="opcionSeleccionada">
                        INICIO
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
                    <li><a href="views/spend/"><img src="../../../res/item/prestamo.png" style="height: 25px;">PRESTAMO</a>
                    </li>
                    <li><a href="views/credit/"><img src="../../../res/item/proveedor.png"
                                style="height: 25px;">PROVEEDORES</a></li>
                    <li><a href="views/collect/"><img src="../../../res/item/nomina.png" style="height: 25px;">NOM.
                            ELECTRONICA</a></li>
                    <li><a href="views/reports/"><img src="../../../res/item/reporte.png">REPORTES</a></li>
                </ul>
            </nav>
            <section class="contenido" id="contenidoGeneral">
                <div class="encabezadoContenido">
                    <div class="tituloContenido">
                        <h1>GESTIÓN ORDEN DE COMPRA</h1> <!-- REMISION CAMBIO A ORDEN DE COMPRA-->
                    </div>
                    <div class="agregarDato">
                        <a href="../../../add_bill.php"><input type="button" value="Generar Orden de Compra"></a>
                    </div>
                    <div class="buscar">
                        <input type="number" id="txbSearchBill" placeholder="Buscar...">
                    </div>
                </div>
                <div class="listado">
                    <form method="post" action="">
                        <table>
                            <tr>
                                <th>FECHA CREACIÓN</th>
                                <th>CÓDIGO</th>
                                <th>CLIENTE</th>
                                <!-- <th>IDENTIFICACIÓN</th> -->
                                <th>PAGO</th>
                                <th>ACCIÓN</th>
                            </tr>
                            <?php
                            require '../../models/BillImpl.php';
                            require '../../models/ClientImpl.php';                            
                            $objBillImpl = new BillImpl();
                            $cont = 0;
                            
                            foreach ($objBillImpl->getAll() as $valor) {
                                $objClientImpl = new ClientImpl();
                                $cliente = $objClientImpl->getNameClient($valor->getClient());
                                
                                if($cont%2 != 0){?>
                                    <tr id="tdColor">
                                <?php
                                }else{?>
                                    <tr>
                                        <?php }?>
                                        
                                        <td><?php echo $valor->getGenerationDate(); ?></td>
                                        <td><?php echo $valor->getCode(); ?></td>
                                        <td><?php echo $cliente ?></td>
                                        <td><?php echo $valor->getClient(); ?></td>
                                    
                                        <?php
                                        if(strcmp ($valor->getPayment(), 'CO') == 0)
                                            echo '<td>CONTADO</td>';
                                        else if(strcmp ($valor->getPayment(), 'CR') == 0)
                                            echo '<td>CREDITO</td>';                                                                      
                                        ?>
                                    
                                        <td id="tdAcciones">
                                            <?php
                                            echo '<a href="view_bill.php?id='.$valor->getCode().'"><img src="../../res/open-in-browser-16.png"></a>';
                                            echo '<a href="edit_bill.php?id='.$valor->getCode().'"><img src="../../res/edit-16.png"></a>';
                                            
                                            if(strcmp ($valor->getState(), 'AC') == 0 || strcmp ($valor->getState(), 'ac') == 0)
                                            echo '<a href="../../controllers/ctrlCancelBill.php?id='.$valor->getCode().'&ac"><img src="../../res/x-mark-16.png"></a>'; 
                                            else if(strcmp ($valor->getState(), 'IN') == 0 || strcmp ($valor->getState(), 'in') == 0)
                                            echo '<a href="../../controllers/ctrlCancelBill.php?id='.$valor->getCode().'&in"><img src="../../res/check-mark-16.png"></a>'; 
                                            echo '<a target="_blank" href="../../controllers/ctrlPrintBill.php?id='.$valor->getCode().'"><img src="../../res/printer-2-16.png"></a>';     
                                            ?> 
                                        </td>  
                                    </tr>                                                     
                                <?php
                                $cont++;
                                }
                                ?>   
                        </table>
                    </form>
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