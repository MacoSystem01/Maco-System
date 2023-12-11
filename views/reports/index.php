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
        <title>MACO | REPORTE</title>
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
            
            <section class="contenido" id="contenidoGeneral">
                <div class="encabezadoContenido">
                    <div class="tituloContenido"><h1>Reportes</h1></div><div class="agregarDato">
                        </div><div class="buscar">                              
                        </div>                    
                </div>
                <div class="listado">
                                        
                    <form method="post" action="">
                        <table>
                            <tr>
                                <th>REPORTE</th>
                                <th>DESCRIPCIÓN</th>
                                <th>ACCIÓN</th>
                            </tr>
                            <tr>
                                <td>INVENTARIO</td>
                                <td>CONSULTAR INFORMACIÓN DEL INVENTARIO</td>
                                <td id="tdAcciones"><a href="stock.php"><img src="../../res/line-16.png"></a></td>
                                <!--<td><img class="imgEditClass" id="0" src="../../res/line-16.png"></a></td>-->
                            </tr>
                            <tr>
                                <td>INVENTARIO</td>
                                <td>EXISTENCIAS POR ARTICULO</td>
                                <td id="tdAcciones"><a href="article.php"><img src="../../res/line-16.png"></a></td>
                            </tr>
                            <tr>
                                <td>Ord. COMPRA</td>
                                <td>INFORMACIÓN DE Ord. COMPRA</td>
                                <td id="tdAcciones"><a href="bill.php"><img src="../../res/line-16.png"></a></td>
                            </tr>                            
                            <tr>
                                <td>ARTICULO</td>
                                <td>ARTICULOS VENDIDOS</td>
                                <td id="tdAcciones"><a href="cantvend.php"><img src="../../res/line-16.png"></a></td>
                            </tr>                            
                            <tr>
                                <td>UTILIDAD</td>
                                <td>INFORMACION RELACIONADA CON LA UTILIDAD</td>
                                <td id="tdAcciones"><a href="utility.php"><img src="../../res/line-16.png"></a></td>                                
                            </tr>
                            <tr>
                                <td>ESTADO DE CUENTA</td>
                                <td>ESTADO DE CUENTA X CLIENTE</td>
                                <td id="tdAcciones"><a href="state_account.php"><img src="../../res/line-16.png"></a></td>                                
                            </tr>
                            <tr>
                                <td>ESTADO DE CUENTA GENERAL</td>
                                <td>ESTADO DE CUENTA GENERAL</td>
                                <td id="tdAcciones"><a href="state_account_general.php"><img src="../../res/line-16.png"></a></td>                                
                            </tr>
                            <tr>
                                <td>ESTADO CUENTA PROVEEDORES</td>
                                <td>CARTERA PROVEEDORES</td>
                                <td id="tdAcciones"><a href="state_account_proveedor.php"><img src="../../res/line-16.png"></a></td>                                
                            </tr>
                            <tr>
                                <td>GASTOS</td>
                                <td>GASTOS DE LA DISTRIBUIDORA</td>
                                <td id="tdAcciones"><a href="spend.php"><img src="../../res/line-16.png"></a></td>                                
                            </tr>
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
    echo '<script>document.location.href = "http://'.$ip.'/baruk/login.php"; </script>';    
}
?>