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
        <link rel="icon" href="../../res/logo/frase.ico" type="image/x-icon">
        <link rel="shortcut icon" href="../../res/logo/frase.ico" type="image/x-icon">
    </head>
    <body>
        <section class="contenedor">
            <header>
                <div class="logoEmpresa">
                    <a href="../../index.php">
                        <a href="index.php">
                            <img src="../../res/logo/logo-1.png" class="logo-ini">
                        </a>
                    </a>
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
                <h1>Cantidad del Articulo</h1>
                
                <?php                
                if(isset($_GET)){ ?>
                
                <form method="post" action="../../controllers/ctrlInsertDetail.php">
                <?php   
                    echo '<input type="hidden" name="hiddenCodeBill" value="'.$_GET['idf'].'">';
                    echo '<input type="hidden" name="hiddenCodeArticle" value="'.$_GET['ida'].'">';   
                    echo '<input type="hidden" name="hiddenName" value="'.$_GET['n'].'">';
                    echo '<input type="hidden" name="hiddenPriceBuy" value="'.$_GET['pc'].'">';
                    echo '<input type="hidden" name="hiddenPriceSale" value="'.$_GET['pv'].'">';
                    echo '<input type="hidden" name="hiddenMove" value="'.$_GET['m'].'">';
                    echo '<input type="hidden" name="hiddenUbication" value="'.$_GET['u'].'">';
                    echo '<input type="hidden" name="hiddenMoveDate" value="'.$_GET['fm'].'">';
                    
                    echo '<input type="number" name="txbQuantity" value="'.$_GET['q'].'" maxlength="6" required>';
                    
                    echo '<input type="submit" value="Guardar">';
                ?>
                </form>
                <?php                
                    }
                ?>
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