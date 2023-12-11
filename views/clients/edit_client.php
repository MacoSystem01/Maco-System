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
            
            <section class="contenido" id="contenidoGeneral">
                <h1>EDITAR DATOS CLIENTE</h1>
                <form method="post" action="../../controllers/ctrlEditClient.php">
                    <?php 
                    if(isset($_GET))
                    {
                        include_once '../../models/Client.php';
                        include_once '../../models/ClientImpl.php';
                        $objClientImpl = new ClientImpl();

                        foreach ($objClientImpl->getByCode($_GET[id]) as $valor) {                           
                            
                            echo '<input type="hidden" value="'.$valor->getCode().'" name="txbCodeHidden">';
                            echo '<input type="number" value="'.$valor->getCode().'" name="txbCode" placeholder="Código" maxlength="12" required>';
                            echo '<input type="text" value="'.$valor->getName().'" name="txbName" placeholder="Nombres" maxlength="60" required>';
                            echo '<input type="text" value="'.$valor->getRegistrationDate().'" disabled>';
                            
                            echo '<select name = "selectDepartment" id = "selectDepartment">';                                
                                include_once '../../models/DepartmentImpl.php';
                                include_once '../../models/Department.php';
                                $objDepartmentImpl = new DepartmentImpl();

                                foreach ($objDepartmentImpl->getAll() as $valorDepartment) {
                                    if($valor->getCodeDepartment() == $valorDepartment->getCode())
                                        echo '<option value="' . $valorDepartment->getCode() . '" selected="selected">' . $valorDepartment->getName() . '</option>';
                                    else
                                        echo '<option value="' . $valorDepartment->getCode() . '">' . $valorDepartment->getName() . '</option>';
                                }
                            echo '</select>'; 
                            
                            echo '<select name="selectLocality" id="selectLocality">';
                                include_once '../../models/LocalityImpl.php';
                                include_once '../../models/Locality.php';
                                $objLocalityImpl = new LocalityImpl();

                                foreach ($objLocalityImpl->getAll() as $valorlocality) {
                                    if($valor->getCodeLocality() == $valorlocality->getCode())
                                        echo '<option value="' . $valorlocality->getCode() . '" selected="selected">' . $valorlocality->getName() . '</option>';
                                    else
                                        echo '<option value="' . $valorlocality->getCode() . '">' . $valorlocality->getName() . '</option>';
                                }                                
                            echo '</select>';
                            
                            echo '<input type="text" value="'.$valor->getDirection().'" name="txbDirection" placeholder="Dirección" maxlength="100" required>';
                            echo '<input type="number" value="'.$valor->getMobile().'" name="txbMobile" placeholder="Celular" maxlength="12">';
                            
                            
                            echo '<select name="selectType" id="selectType">';
                                include_once '../../models/TypeClientImpl.php';
                                include_once '../../models/TypeClient.php';
                                $objTypeClientImpl = new TypeClientImpl();

                                foreach ($objTypeClientImpl->getAll() as $valorTypeClient) {
                                    if($valor->getTipo() == $valorTypeClient->getCode())
                                        echo '<option value="' . $valorTypeClient->getCode() . '" selected="selected">' . $valorTypeClient->getName() . '</option>';
                                    else
                                        echo '<option value="' . $valorTypeClient->getCode() . '">' . $valorTypeClient->getName() . '</option>';
                                }                                
                            echo '</select>';
                            
                            
                            //include_once '../../models/Client.php';
                            include_once '../../models/UserImpl.php';
                            $objUserImpl = new UserImpl();
                            $user = $objUserImpl->getNameUser($valor->getUser());
                            
                            echo '<input type="text" value="'.$user.'" disabled>';
                        }
                        
                        echo '<input type="submit" value="Guardar">';
                    }
                    else
                    {
                        
                    }                 
                    
                    
                    
                    
                    ?>                 
                    
                    
                </form>
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