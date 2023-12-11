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
        <script src="../../js/check.js"></script>
        <script src="../../js/alertify/alertify.js"></script>
        <script type="text/javascript" src="../../js/jquery.price_format.2.0.min.js"></script>
        <script type="text/javascript" src="../../js/price_format.js"></script>
        <link href="../../css/alertify/alertify.css" rel="stylesheet">
        <link href="../../css/alertify/themes/default.css" rel="stylesheet">
        <title>Inventario</title>
    </head>
    <body>
        <section class="contenedor">
            <header>
                <div class="logoEmpresa">
                    <a href="../../index.php"><img src="../../res/logo.png"></a></div><div class="sesion">
                        Salir<a href="../../controllers/ctrlLogout.php"><img src="../../res/logout-24.png"></a>
                    </div>                    
                <div class="contenedorRutaApp">
                    <div class="nombreAplicacion">
                        Sistema de Información "Baruk Distribuciones"
                    </div><div class="arrowImgRight">
                        <img src="../../res/arrow-25-16.png">
                    </div><div class="opcionSeleccionada">
                        Inventario
                    </div>
                </div>
            </header>
            <nav id="menu">
                <ul>
                    <li><a href="../config/"><img src="../../res/settings-4-16.png">Parámetros</a></li>
                    <li><a href="../clients/"><img src="../../res/guest-16.png">Clientes</a></li>
                    <li><a href="../stock/"><img src="../../res/list-ingredients-16.png">Inventario</a></li>
                    <li><a href="../bill"><img src="../../res/document-16.png">Remisiones</a></li>
                    <li><a href="../spend/"><img src="../../res/banknotes-16.png">Gastos</a></li>                     
                    <li><a href="../credit/"><img src="../../res/credit-card-2-16.png">Créditos</a></li>                      
                    <li><a href="../collect/"><img src="../../res/cash-receiving-16.png">Recaudos</a></li>
                    <li><a href="../reports/"><img src="../../res/line-16.png">Reportes</a></li>   
                </ul>
            </nav>
            
            <section class="contenido" id="contenidoGeneral">
                <h1>Agregar al Inventario</h1>
                <form method="post" action="../../controllers/ctrlInsertStock.php" id="formInsertArticle">
                    <input type="text" name="txbCode" id="txbCode" placeholder="Referencia" maxlength="12" required>
                    <input type="text" name="txbName" id="txbName" placeholder="Articulo" maxlength="60" required>
                    
                    <select name="selectMove" id="selectUbication">
                        <option value="N">NACIONAL</option>
                        <option value="I">IMPORTADO</option>                        
                    </select>                                                       
                    
                    <input type="text" id="example22" name="txbQuantity" placeholder="Cantidad" maxlength="12" required>                    
                    <input type="text" id="example2" name="txbPriceBuy" placeholder="Precio Costo" maxlength="14" required>
                    <!--<input type="text" value="" id="example2" name="example2">-->
                    <!--<input type="number" name="txbPriceSale" placeholder="Precio Venta" maxlength="14">-->
                    
<!--                    <select name="selectMove" id="selectUbication">
                        <option value="B">BODEGA</option>
                        <option value="A">ALMACEN</option>                        
                    </select>                    -->
                    
                    <input type="submit" id="btnInsertarArticulo" value="Guardar">
                </form>
                <div id="resultado"></div>
            </section>
            <footer>
                <div class="franjaAzul"></div>      
            </footer>
        </section>
    </body>
    
    <?php
    if(isset($_GET))
        if(isset($_GET['e']))
        {
            echo '<script>alertify.error("El código del artículo ya existe");</script>';                            
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