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
        <script src="../../js/prompt.js"></script>
        <script src="../../js/prompt_detail.js"></script>
        <script type="text/javascript" src="../../js/jquery.price_format.2.0.min.js"></script>
        <script type="text/javascript" src="../../js/price_format.js"></script>
        <script src="../../js/updatePayMethod.js"></script>
        <title>MACO | Ord. Compra</title>
        <link rel="icon" href="../../res/logo/frase.ico" type="image/x-icon">
        <link rel="shortcut icon" href="../../res/logo/frase.ico" type="image/x-icon">
    </head>

    <body>
        <section class="contenedor">
            <header>
                <div class="logoEmpresa">
                    <a href="index.php"><img src="../../res/logo/logo-1.png" class="logo-ini"></a>
                </div>
                <div class="sesion">
                </div>
                <div class="contenedorRutaApp">
                    <div class="nombreAplicacion">
                        MACO System "Sistema de Registro Contable"
                    </div>
                    <div class="arrowImgRight">
                        <img src="../../res/arrow-25-16.png">
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
                <h1>ORDEN DE COMPRA</h1>
                    <?php                
                    if(isset($_GET)){
                    $metodoPago;    
                    ?>
                <form method="post" action="../../controllers/ctrlEditBill.php">                    
                    <?php   
                        require '../../models/BillImpl.php';
                        require '../../models/ClientImpl.php';
                        $objBillImpl = new BillImpl();
                        $objClientImpl = new ClientImpl();
                        
                        $billNumber;
                        
                        foreach ($objBillImpl->getByCode($_GET['id']) as $valor) {
                            $billNumber = $valor->getCode();
                            echo '<input type="hidden" id="userHidden" value="'.$_SESSION['userCode'].'">';
                            echo '<input type="hidden" id="billNumberHidden" value="'.$billNumber.'">';
                            echo '<input type="number" name="txbCode" id="txbCode" value="'.$valor->getCode().'" readonly>';
                            echo '<input type="text" name="txbCodeClient" id="txbCodeClient" value="'.$valor->getClient().'" maxlength="12" required readonly>';
                            
                            $clientName = $objClientImpl->getNameClient($valor->getClient());
                            echo '<input type="text" name="txbCodeClient" value="'.$clientName.'" readonly>';
                            
                            echo '<input type="text" name="txbDateGeneration" value="'.$valor->getGenerationDate().'" readonly>';
                            echo '<input type="text" name="txbValueSale" id="txbValueSale" value="'.number_format($valor->getValueSale(),0).'" readonly>';
                            //echo '<input type="text" name="txbValueBuy" value="'.$valor->getValueBuy().'" readonly>';
                            
                            $metodoPago = $valor->getPayment();
                            //echo $metodoPago;
                                                
                            
                        }
                            //echo '<input type="submit" value="Guardar">';
                    ?>
                </form>
                    <?php                
                        }
                    ?>
                <div class="encabezadoContenido">
                    <div class="tituloContenido">
                        <h1>Seleccionar Artículos</h1>
                    </div>
                    <div class="agregarDato"></div>
                    <div class="buscar">
                        <input type="text" id="txbSearchStockBill" placeholder="Buscar...">
                    </div>
                </div>
                <div class="listadoStockBill">
                                        
                    <form method="post" action="">
                        <table>
                            <tr>
                                <th>REFERENCIA</th>
                                <th>ARTICULO</th>
                                <th>CANTIDAD</th>
                                <th class="tdNoVisible">PRECIO COSTO</th>
                                <th>ORIGEN</th>   
                                <th>ACCIÓN</th>
                            </tr>

                            <?php
                            require '../../models/StockImpl.php';
                            $objStockImpl = new StockImpl();
                            $cont = 0;
                            
                            foreach ($objStockImpl->getByAlmacen() as $valor) {
                                $quantityAvailable = $objStockImpl->getQuantityAvailable($valor->getCode());
                                $quantitySale = $objStockImpl->getQuantitySale($valor->getCode());
                                $totalCantidad = $quantityAvailable - $quantitySale; 
                                
                            if($totalCantidad>0){    
                                if($cont%2 != 0){?>
                                    <tr id="tdColor">
                                <?php
                                }else{?>
                                <tr>
                                    <?php }?>
                                    <?php echo '<td id="td1'.$cont.'">'.$valor->getCode(); ?></td>                                
                                    <?php echo '<td id="td2'.$cont.'">'.$valor->getName(); ?></td>
                                    
                                    
                                    <?php echo '<td class="tdDerecha" id="td3'.$cont.'">';
                                    //$quantityAvailable = $objStockImpl->getQuantityAvailable($valor->getCode());
                                    //$quantitySale = $objStockImpl->getQuantitySale($valor->getCode());
                                    //$totalCantidad = $quantityAvailable - $quantitySale; 
                                    echo number_format($totalCantidad,0);
                                    
                                    echo '</td>';?>
                                    
                                    <?php echo '<td class="tdNoVisible" id="td4'.$cont.'">';
                                    $priceBuy = $objStockImpl->getLastPriceSold($valor->getCode()); 
                                    echo number_format($priceBuy,0);
                                    echo '</td>';
                                    
                                    $origen =  $objStockImpl->getLastOrigen($valor->getCode());
                                    
                                    //echo 'ORIGEN = '.$origen;
                                    if(strcmp($origen, "N") == 0)
                                           $origen = "NACIONAL";
									else if(strcmp($origen, "I") == 0)
                                           $origen = "IMPORTADO";
                                    
                                    echo '<td id="td5'.$cont.'">'.$origen.'</td>';
                                    
                                    echo '<input type="hidden" id="txbOculto"'.$cont.' name="txbOculto" value="5">';
                                    ?>                             
                                    
                                    <td id="tdAcciones">
                                        <?php
                                        //echo '<a href="edit_detail.php?idf='.$billNumber.'&ida='.$valor->getCode().'&n='.$valor->getName().'&pc='.$valor->getPriceBuy().'&pv='.$valor->getPriceSold().'&m='.$valor->getMove().'&u='.$valor->getUbication().'&fm='.$valor->getMoveDate().'"><img src="../../res/add-list-16.png"></a>';                                        
                                        //echo '<a id="articleDetail1" href="edit_detail.php?idf='.$billNumber.'&ida='.$valor->getCode().'&n='.$valor->getName().'&pc='.$priceBuy.'"><img id="imgEdit1" src="../../res/add-list-16.png"></a>';                                        
                                        echo '<img class="imgEditClass" id="'.$cont.'" src="../../res/add-list-16.png">';                                        
                                        ?>                                        
                                    </td>                                      
                                </tr>                                                     
                            <?php
                            $cont++;
                            }
                            }
                            ?>   
                        </table>
                    </form> 
                </div>
                <div class="contenidoCantidadPrecio">
                    
                </div>
                <div class="detallesCantidadPrecio">
                    <form id="formSubmit" method="post" action="../../controllers/ctrlInsertDetail.php">                        
                        <br>
                        <h1></h1>
                        
                        <?php
                        echo '<input type="hidden" name="hiddenCodeBill" value="'.$billNumber.'">';
                        echo '<input type="hidden" name="hiddenCodeArticle" id="hiddenCodeArticle">';        
                        ?>
                        
                        <input type="hidden" name="hiddenName" id="hiddenName">
                        <input type="hidden" name="hiddenPriceBuy" id="hiddenPriceBuy">
                        <input type="hidden" name="hiddenPriceSale" id="hiddenPriceSale">
                        <input type="hidden" name="hiddenOrigen" id="hiddenOrigen">
                        
                        <input type="hidden" name="hiddenPriceSale" id="hiddenAuxAvailable">
                        
                    
                        
                        <input id="txbQuantityBuy" class="cantExample" name="txbQuantityBuy" type="text" placeholder="CANTIDAD" required>
                        <input type="text" id="example2" name="txbPriceSale" placeholder="PRECIO VENTA" required><br>
                        <p id="pDisponibles"></p>
                        <p id="pPrecioCompra"></p>
                        <p id="pMensaje"></p><br>
                        <input id="btnSubmit" type="submit" value="Guardar" disabled>
                    </form>
                </div>
                <br><br>
                <h1>Detalles</h1>
                <br>
                
                
                <div class="listado">                                        
                    <form method="post" action="">
                        <table>
                            <tr>
                                <th>REFERENCIA</th>
                                <th>CANTIDAD</th>
                                <th>VALOR UNITARIO</th>
                                <th>VALOR TOTAL</th>                                
                                <th>ACCION</th>
                            </tr>
                            
                            <?php
                            require '../../models/DetailImpl.php';
                            $objDetailImpl = new DetailImpl();
                            $contDetail = 0;
                            
                            foreach ($objDetailImpl->getByCode($billNumber) as $valor) {
                                
                                
                                if($contDetail%2 != 0){?>
                                    <tr id="tdColor">
                                <?php
                                }else{?>
                                    <tr>
                                <?php }
                                
                                        echo '<td id="tdd1'.$contDetail.'">'.$valor->getCodeArticle().'</td>';
                                        echo '<td class="tdDerecha" id="tdd2'.$contDetail.'">';echo number_format($valor->getQuantity(),0).'</td>';
                                        echo '<td class="tdDerecha" id="tdd3'.$contDetail.'">';echo number_format($valor->getValueUnit(),0).'</td>';
                                        echo '<td class="tdDerecha" id="tdd4'.$contDetail.'">';echo number_format($valor->getTotal(),0).'</td>';
                                        
                                                                           
                                    ?>
                                        <td id="tdAcciones">
                                            <?php
                                            echo '<img class="imgEditClassDetail" id="'.$contDetail.'" src="../../res/edit-16.png">';                                        
                                            echo '<a href="../../controllers/ctrlDeleteDetail.php?idf='.$billNumber.'&ida='.$valor->getCodeArticle().'&q='.$valor->getQuantity().'"><img src="../../res/x-mark-16.png"></a>';                                                                                    
                                            ?>                                        
                                        </td>  
                                </tr>                                                     
                            <?php
                            $contDetail++;
                            }
                            ?>   
                        </table>
                    </form>                                       
                    
                <div class="contenidoCantidadPrecioDetail">
                    
                </div>
                <div class="detallesCantidadPrecioDetail">
                    <form id="formSubmit" method="post" action="../../controllers/ctrlUpdateDetail.php">                        
                        <br>
                        <h1></h1>
                        
                        <?php
                        echo '<input type="hidden" name="hiddenCodeBillDetail" value="'.$billNumber.'">';
                        echo '<input type="hidden" name="hiddenCodeArticleDetail" id="hiddenCodeArticleDetail">';      
                        ?>
                        
                        <input type="hidden" name="hiddenQuantityDetail" id="hiddenName">
                        <input type="hidden" name="hiddenPriceBuyDetail" id="hiddenPriceBuy">
                        
                        <input id="txbQuantityBuyDetail" class="cantExample" name="txbQuantityBuyDetail" type="text" placeholder="CANTIDAD" required>
                        <input type="text" id="example22" name="txbPriceSaleDetail" placeholder="PRECIO VENTA" required><br>
                        <p id="pCantidadDetail"></p>
                        <p id="pPrecioCompraDetail"></p>
                        <p id="pMensajeDetail"></p><br>
                        <input id="btnSubmitDetail" type="submit" value="Guardar" disabled>
                    </form>
                </div>
                    
                 
                </div>                              
                
                <div class="encabezadoContenido">
                    <div class="tituloContenido" id="pago"></div><div class="agregarDato"></div><div class="buscar">
                        
                        <?php 
                        
                        
                            if(strcmp ($metodoPago, 'CO') == 0)
                            {
                                echo '<select name = "selectPayment" id="selectPaymentBill">';     
                                echo '<option value="CO" selected="selected">CONTADO</option>';
                                echo '<option value="CR">CREDITO</option>';
                                echo '</select><br><br>'; 
                            }
                            else if(strcmp ($metodoPago, 'CR') == 0)
                            {
                                echo '<select name = "selectPayment" id="selectPaymentBill"  disabled>';     
                                echo '<option value="CO" >CONTADO</option>';
                                echo '<option value="CR" selected="selected">CREDITO</option>';
                                echo '</select><br><br>'; 
                            }                        
                        
                        if(strcmp ($metodoPago, 'CR') == 0){
                            echo '<a href="../../views/collect/add_collect.php"><input type="button" value="Recaudar"></a> '; 
                        }
                        
                        echo '<a target="_blank" href="../../controllers/ctrlPrintBill.php?id='.$billNumber.'"><input type="button" value="Imprimir"></a>'; 
                        
                        ?>
                    </div>                    
                </div>
                
                
            </section>
            <footer>
                <div class="franjaAzul"></div>    
            </footer>
            
            <?php
            if(isset($_GET)){
                require_once '../../models/Credit.php';
                require_once '../../models/CreditImpl.php';
                require_once '../../models/BillImpl.php';
                $objCredit = new Credit();
                $objCreditImpl = new CreditImpl();
                                
                

                $num_rows_credit = $objCreditImpl->checkCodeBillInCredit($_GET['id']);

                //si existe el credito ingresa
                if ($num_rows_credit > 0) {
                    $objBillU = new Bill();
                    $objBillU->setCode($_GET['id']);                    
                    
                    $objCredit->setValue($objBillImpl->getValueBill($objBillU));
                    $objCredit->setCodeBill($_GET['id']);
                    $objCreditImpl->updateValue($objCredit);
                    
                    //actualizar saldo
                    require_once '../../models/CollectImpl.php';
                    $totalCredito = $objCredit->getValue();
                    
                    $objCollectImpl = new CollectImpl();
                    
                    $idCredit = $objCreditImpl->getId($_GET['id']);                    
                    $totalRecaudado = $objCollectImpl->sumValueByBiil($idCredit);
                    
                    $objCredit->setCode($idCredit);
                    $objCredit->setSaldo($totalCredito - $totalRecaudado);                    
                    $objCreditImpl->updateSaldo($objCredit);
                    
                    /*echo 'TOTAL CREDITO: '.$totalCredito.'<br>';
                    echo 'TOTAL RECAUDADO: '.$totalRecaudado.'<br>';
                    echo 'TOTAL SALDO: '.($totalCredito - $totalRecaudado).'<br>';*/
                    
                }
            }
            ?>
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