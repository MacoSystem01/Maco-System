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
        <script src="../../js/check_get_client.js"></script>
        <script src="../../js/alertify/alertify.js"></script>
        <link href="../../css/alertify/alertify.css" rel="stylesheet">
        <script type="text/javascript" src="../../js/jquery.price_format.2.0.min.js"></script>
        <script type="text/javascript" src="../../js/price_format.js"></script>
        <link href="../../css/alertify/themes/default.css" rel="stylesheet">
        <title>MACO | PRÉSTAMO</title>
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
                        PRÉSTAMO
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
            
            <?php
            if($_GET)
            {
            ?>
            <section class="contenido" id="contenidoGeneral">
                <h1>REGISTRO CRÉDITO NO ASOCIADO A VENTAS</h1>
                
                <form method="post" action="../../controllers/ctrlInsertCreditNoVentas.php">
                    <!--<input type="number" name="txbCode" disabled>-->
                    <?php echo '<input type="number" name="txbCodeClient" id="txbCodeClient" value="'.$_GET['idc'].'" placeholder="Codigo Cliente" maxlength="12" required>'; ?>
                    <?php echo '<input type="text" name="txbNameClient" id="txbNameClient" placeholder="Cliente" readonly>'; ?>
                    <?php echo '<input type="text" name="txbDateGeneration" value="'.date("Y/m/d H:i:s").'" readonly>'; ?>
                    <input type="text" id="example2" name="txbValue" placeholder="Valor" required>
                    
                    <input type="submit" value="Crear">
                </form>
            </section>
            <?php            
            }
            else
            {
            ?>
            
            <section class="contenido" id="contenidoGeneral">
                <h1>REGISTRO CRÉDITO NO ASOCIADO A VENTAS</h1>
                
                <form method="post" action="../../controllers/ctrlInsertCreditNoVentas.php">
                    <!--<input type="number" name="txbCode" disabled>-->
                    <input type="number" name="txbCodeClient" id="txbCodeClient" placeholder="Codigo Cliente" maxlength="12" required>
                    <input type="text" name="txbNameClient" id="txbNameClient" placeholder="Cliente" readonly>
                    <?php echo '<input type="text" name="txbDateGeneration" value="'.date("Y/m/d H:i:s").'" readonly>'; ?>
                    <input type="text"  id="example2" name="txbValue" placeholder="Valor" required>
                    
                    <input type="submit" value="Crear">
                </form>
            </section>
                
            <?php
            }
            ?>
            
            
            <footer>
                <div class="franjaAzul"></div>
                <p class="m-0 text-center">&copy; <a href="http://127.0.0.1:5500/login.html">MACO System Accountant</a>.
                    Reservados todos los derechos. Diseñado Por <a href="https://github.com/MacoSystem01" target="_blank">MACO
                        System</a><br>
                </p>
            </footer>
        </section>
    </body>
    <?php
    if(isset($_GET['idc']))
    {
        //echo '<script>alertify.error("Se debe registrar el cliente");</script>';
        echo '<script>alertify.success("Ahora se puede crear el crédito");</script>'; 
    }
    ?>
</html>

<?php
}
else
{
    echo '<script>document.location.href = "http://'.$ip.'/baruk/login.php"; </script>';    
}
?>