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
        <script src="../../js/prompt_collect.js"></script>
        <script type="text/javascript" src="../../js/jquery.price_format.2.0.min.js"></script>
        <script type="text/javascript" src="../../js/price_format.js"></script>
        <script src="../../js/updatePayMethod.js"></script>
        <title>MACO | CRÉDITO</title>
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
                        CRÉDITO
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
                <h1>GESTIÓN CRÉDITO</h1>
                
                                
                <div class="encabezadoContenido">
                    <div class="tituloContenido"><h1>Seleccionar Crédito</h1></div><div class="agregarDato">
                        <a href="add_credit.php"><input type="button" value="Agregar Crédito"></a></div><div class="buscar">
                            <input type="text" id="txbSearchCreditCollectNoVentas" placeholder="Buscar...">
                    </div>                    
                </div>
                
                <div class="listadoCreditBill">
                                        
                    <form method="post" action="">
                        <table>
                            <tr>
                                <th>CÓDIGO</th>
                                <th>CLIENTE</th>
                                <th>Ord. COMPRA</th>
                                <th>FECHA</th>                                
                                <th>VALOR</th>   
                                <th>SALDO</th> 
                                <th class="tdNoVisible">CONCEPTO</th>
                                <th>ACCIÓN</th>
                            </tr>
                            
                            <?php
                            require '../../models/CreditImpl.php';
                            require '../../models/ClientImpl.php';
                            $objCreditImpl = new CreditImpl();
                            $cont = 0;
                            
                            foreach ($objCreditImpl->getByStateANoVentas() as $valor) {
                                /*$quantityAvailable = $objCreditImpl->getQuantityAvailable($valor->getCode());
                                $quantitySale = $objCreditImpl->getQuantitySale($valor->getCode());
                                $totalCantidad = $quantityAvailable - $quantitySale; */
                                
                                $objClientImpl = new ClientImpl();
                                
                                if($cont%2 != 0){?>
                                    <tr id="tdColor">
                                <?php
                                }else{?>
                                    <tr>
                                <?php }?>
                                    <?php echo '<td id="td1'.$cont.'">'.$valor->getCode(); ?></td>                                
                                    <?php echo '<td id="td2'.$cont.'">'.$objClientImpl->getNameClient($valor->getCodeClient()); ?></td>
                                    <?php echo '<td class="tdDerecha" id="td3'.$cont.'">'.$valor->getCodeBill(); ?></td>                                
                                    <?php echo '<td id="td4'.$cont.'">'.$valor->getRegistrationDate(); ?></td>                                
                                    <?php echo '<td class="tdDerecha" id="td5'.$cont.'">'.number_format($valor->getValue()); ?></td>                                
                                    <?php echo '<td class="tdDerecha" id="td6'.$cont.'">'.number_format($valor->getSaldo()); ?></td>                                
                                    <?php echo '<td class="tdNoVisible" id="td7'.$cont.'">'.$valor->getCodeConcept(); ?></td>

                                    <td id="tdAcciones">
                                        <?php                                        
                                        //echo '<a id="articleDetail1" href="edit_detail.php?idf='.$billNumber.'&ida='.$valor->getCode().'&n='.$valor->getName().'&pc='.$priceBuy.'"><img id="imgEdit1" src="../../res/add-list-16.png"></a>';                                        
                                        echo '<img class="imgEditClass" id="'.$cont.'" src="../../res/add-list-16.png">';                                        
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
                
                
                <div class="contenidoRecaudo">
                    
                </div>
                <div class="detallesRecaudo">
                    <form id="formSubmit" method="post" action="../../controllers/ctrlInsertCollect.php">                        
                        <br>
                        <h1>RECAUDAR</h1><br>
                        
                        <?php
                        echo '<input type="hidden" name="hiddenCodeCredit" id="hiddenCodeCredit">';        
                        ?>
                        
<!--                        <input type="hidden" name="hiddenName" id="hiddenName">
                        <input type="hidden" name="hiddenPriceBuy" id="hiddenPriceBuy">
                        <input type="hidden" name="hiddenPriceSale" id="hiddenPriceSale">
                        
                        <input type="hidden" name="hiddenPriceSale" id="hiddenAuxAvailable">-->
                        
                    
                        <input type="text" id="example2" class="txbValue" name="txbValue" placeholder="VALOR" maxlength="14" required><br>
                        <input id="txbObservations" name="txbObservations" type="text" placeholder="OBSERVACIONES" maxlength="200">
                        <input type="hidden" name="hiddenSaldo" id="hiddenSaldo">
                        <input type="hidden" name="hiddenCodeConcept" id="hiddenCodeConcept">
                        
                        <p id="pValor"></p>
                        <p id="pSaldo"></p>
                        <p id="pMensaje"></p><br>
                        <input id="btnSubmit" type="submit" value="Guardar" disabled>
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
    echo '<script>document.location.href = "http://'.$ip.'/baruk/login.php"; </script>';    
}
?>