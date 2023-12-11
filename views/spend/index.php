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
        <script src="../../js/alertify/alertify.js"></script>
        <link href="../../css/alertify/alertify.css" rel="stylesheet">
        <link href="../../css/alertify/themes/default.css" rel="stylesheet">
        <title>MACO | GASTOS</title>
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
                        GASTOS
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
                    <div class="tituloContenido"><h1>GESTIÓN GASTOS</h1></div><div class="agregarDato">
                        <a href="add_spend.php"><input type="button" value="Agregar"></a></div><div class="buscar">
                            <input type="text" id="txbSearchSpend" placeholder="Buscar...">
                        </div>                    
                </div>
                <div class="listado">
                                        
                    <form method="post" action="">
                        <table>
                            <tr>
                                <th>FECHA</th>
                                <th>RECIBO</th>
                                <th>CLIENTE</th>                                
                                <th>CONCEPTO</th>                                
                                <th>VALOR</th>                               
                                <th>ACCIÓN</th>
                            </tr>
                            
                            <?php
                            require '../../models/SpendImpl.php';
                            $objSpendImpl = new SpendImpl();
                            
                            require '../../models/ClientImpl.php';
                            $objClientImpl = new ClientImpl();
                            
                            require '../../models/ConceptImpl.php';
                            $objConceptImpl = new ConceptImpl();
                            
                            foreach ($objSpendImpl->getAll() as $valor) {
                                ?>
                                <tr>
                                    <td class="tdDerecha"><?php echo $valor->getCode(); ?></td>                                                                    
                                    <td><?php echo $objClientImpl->getNameClient($valor->getCodeClient()); ?></td>                                                              
                                    <td><?php echo $objConceptImpl->getNameConcept($valor->getCodeConcept()); ?></td>                                     
                                    <td class="tdDerecha"><?php echo number_format($valor->getValue()); ?></td>                                                              
                                    <td><?php echo $valor->getGenerationDate(); ?></td>                                                              
                                    <td id="tdAcciones">
                                        <?php
                                        echo '<a href="edit_spend.php?id='.$valor->getCode().'"><img src="../../res/edit-16.png"></a>';
                                        echo '<a class="aDelete" href="../../controllers/ctrlDeleteSpend.php?id='.$valor->getCode().'"><img src="../../res/delete-16.png"></a>';                                        
                                        echo '<a target="_blank" href="../../controllers/ctrlPrintSpendRecibo.php?id='.$valor->getCode().'"><img src="../../res/printer-2-16.png"></a>';     
                                        ?>                                        
                                    </td>  
                                </tr>
                                <?php
                                }
                                ?>
                        </table>
                    </form> 
                    
                    <?php echo '<p>Ultimos registros de '.$objSpendImpl->getCount().' encontrados</p>';   ?>
                    
                    
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