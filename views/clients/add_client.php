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
        <script src="../../js/select.js"></script>  
        <script src="../../js/check_client.js"></script>
        <script src="../../js/alertify/alertify.js"></script>
        <link href="../../css/alertify/alertify.css" rel="stylesheet">
        <link href="../../css/alertify/themes/default.css" rel="stylesheet">
        <title>MACO | CLIENTES</title>
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
                        CLIENTES
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
                if(isset($_GET['r']))
                {?>
                    <section class="contenido" id="contenidoGeneral">
                        <h1>REGISTRO CLIENTE</h1>
                        <form method="post" action="../../controllers/ctrlInsertClient.php">
                            <?php
                            echo '<input type="number" name="txbCode" id="txbCode" value="'.$_GET['id'].'" placeholder="Código" maxlength="12" required>';
                            
                            if(isset($_GET['c']))
                            {?>
                                <input type="hidden" name="hiddenGotoBillCredit">        
                            <?php }
                            else{ ?>
                                <input type="hidden" name="hiddenGotoBill">
                            <?php }
                            ?>
                            <input type="text" name="txbName" placeholder="Nombres" maxlength="60" required>

                            <select name="selectTipo" id="selectTipo">
                            <?php
                            include_once '../../models/TypeClient.php';
                            include_once '../../models/TypeClientImpl.php';
                            $objTypeClientImpl = new TypeClientImpl();

                            foreach ($objTypeClientImpl->getAll() as $valor) {
                                echo '<option value="'.$valor->getCode().'">'.$valor->getName().'</option>';                        
                            }                    
                            ?>
                            </select> 
                            
                            
                            <select name="selectDepartment" id="selectDepartment">
                            <?php
                            include_once '../../models/DepartmentImpl.php';
                            include_once '../../models/Department.php';
                            $objDepartmentImpl = new DepartmentImpl();

                            foreach ($objDepartmentImpl->getAll() as $valor) {
                                echo '<option value="'.$valor->getCode().'">'.$valor->getName().'</option>';                        
                            }                    
                            ?>
                            </select>                   

                            <select name="selectLocality" id="selectLocality">

                            </select>                    

                            <input type="text" name="txbDirection" placeholder="Dirección" maxlength="100" required>
                            <input type="number" name="txbMobile" placeholder="Celular" maxlength="12">
                            
                            
                            
                            <input type="submit" value="Guardar">
                        </form>

                        <div class="listado"></div>
                    </section>
                <?php
                }
                
                else// si no hay r
                {
                ?> 

                <section class="contenido" id="contenidoGeneral">
                    <h1>Agregar Cliente</h1>
                    <form method="post" action="../../controllers/ctrlInsertClient.php">
                        <?php 
                        echo '<input type="number" name="txbCode" id="txbCode" value="'.$_GET['id'].'" placeholder="Código" maxlength="12" required>';
                        echo '<input type="text" name="txbName" value="'.$_GET['n'].'" placeholder="Nombres" maxlength="60" required>';

                        echo '<select name="selectTipo" id="selectTipo">';
                        include_once '../../models/TypeClient.php';
                        include_once '../../models/TypeClientImpl.php';
                        $objTypeClientImpl = new TypeClientImpl();

                        foreach ($objTypeClientImpl->getAll() as $valor) {
                            echo '<option value="'.$valor->getCode().'">'.$valor->getName().'</option>';                        
                        }                    
                        echo '</select>'; 
                        
                        echo '<select name="selectDepartment" id="selectDepartment">';

                        include_once '../../models/DepartmentImpl.php';
                        include_once '../../models/Department.php';
                        $objDepartmentImpl = new DepartmentImpl();

                        foreach ($objDepartmentImpl->getAll() as $valor) {
                            if(strcmp ($valor->getCode(), $_GET['d']) == 0)
                                echo '<option value="'.$valor->getCode().'" selected="selected">'.$valor->getName().'</option>';
                            else{
                                echo '<option value="'.$valor->getCode().'">'.$valor->getName().'</option>';
                            }
                        }                    

                        echo '</select>';

                        echo '<select name="selectLocality" id="selectLocality"></select>';                    

                        echo '<input type="text" name="txbDirection" value="'.$_GET['dir'].'" placeholder="Dirección" maxlength="100" required>';
                        echo '<input type="number" name="txbMobile" placeholder="Celular" value="'.$_GET['c'].'" maxlength="12">';
                                                                        
                        echo '<input type="submit" value="Guardar">';

                        ?>
                    </form>

                    <div class="listado"></div>
                </section>
                <?php
                }
            }
            else
            {
            ?>
            
                <section class="contenido" id="contenidoGeneral">
                    <h1>Agregar Cliente</h1>
                    <form method="post" action="../../controllers/ctrlInsertClient.php">
                        <input type="number" name="txbCode" id="txbCode" placeholder="Código" maxlength="12" required>
                        <input type="text" name="txbName" placeholder="Nombres" maxlength="60" required>

                        <select name="selectTipo" id="selectTipo">
                        <?php
                        include_once '../../models/TypeClient.php';
                        include_once '../../models/TypeClientImpl.php';
                         $objTypeClientImpl = new TypeClientImpl();

                        foreach ($objTypeClientImpl->getAll() as $valor) {
                            echo '<option value="'.$valor->getCode().'">'.$valor->getName().'</option>';                        
                        }                    
                        ?>
                        </select>                         
                        
                        <select name="selectDepartment" id="selectDepartment">
                        <?php
                        include_once '../../models/DepartmentImpl.php';
                        include_once '../../models/Department.php';
                        $objDepartmentImpl = new DepartmentImpl();

                        foreach ($objDepartmentImpl->getAll() as $valor) {
                            echo '<option value="'.$valor->getCode().'">'.$valor->getName().'</option>';                        
                        }                    
                        ?>
                        </select>                   

                        <select name="selectLocality" id="selectLocality">

                        </select>                    

                        <input type="text" name="txbDirection" placeholder="Dirección" maxlength="100" required>
                        <input type="number" name="txbMobile" placeholder="Celular" maxlength="12" >                     
                                                
                        <input type="submit" value="Guardar">
                    </form>

                    <div class="listado"></div>
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
    if(isset($_GET))
        if(isset($_GET['e']))
        {
            echo '<script>alertify.error("El código del cliente ya existe");</script>';                            
        }
        else if(isset($_GET['r']))
        {
            echo '<script>alertify.error("Se debe registrar el cliente");</script>';            
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