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
        <script src="../../js/confirm.js"></script>
        <script src="../../js/alertify/alertify.js"></script>
        <link href="../../css/alertify/alertify.css" rel="stylesheet">
        <link href="../../css/alertify/themes/default.css" rel="stylesheet">
        <title>MACO | PROVEEDORES</title>
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
                        PROVEEDOR
                    </div>
                </div>
            </header>
            <nav id="menu">
                <ul>
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
                    <div class="tituloContenido"><h1>GESTIÓN PROVEEDOR</h1></div><div class="agregarDato">
                        <a href="add_client.php"><input type="button" value="Agregar"></a></div><div class="buscar">
                            <input type="text" id="txbSearchClient" placeholder="Buscar...">
                        </div>                    
                </div>
                <div class="listado">
                                        
                    <form method="post" action="">
                        <table>
                            <tr>
                                <th>NIT/CC</th>
                                <th>NOMBRES</th>
                                <th>DEPARTAMENTO</th>
                                <th>CIUDAD</th>
                                <th>DIRECCION</th>
                                <th>CELULAR</th>
                                <th>TIPO</th>
                                <th>ACCION</th>
                            </tr>
                            
                            <?php
                            require '../../models/ClientImpl.php';
                            require '../../models/DepartmentImpl.php';
                            require '../../models/LocalityImpl.php';
                            require '../../models/TypeClientImpl.php';
                            $objClientImpl = new ClientImpl();
                            $cont = 0;
                            
                            foreach ($objClientImpl->getAll() as $valor) {
                                $objDepartmentImpl = new DepartmentImpl();
                                $department = $objDepartmentImpl->getNameDepartment($valor->getCodeDepartment());
                                $objLocalityImpl = new LocalityImpl();
                                $locality = $objLocalityImpl->getNameLocality($valor->getCodeLocality());
                                
                                if(strcmp($valor->getTipo(),"") != 0)
                                {
                                    $objTypeClientImpl = new TypeClientImpl();
                                    $tipo = $objTypeClientImpl->getNameTypeClient($valor->getTipo());
                                }
                                
                                
                                if($cont%2 != 0){?>
                                    <tr id="tdColor">
                                <?php
                                }else{?>
                                    <tr>
                                <?php }?>
                                    <td><?php echo $valor->getCode(); ?></td>                                
                                    <td><?php echo $valor->getName(); ?></td>
                                    <td><?php echo $department; ?></td>                                
                                    <td><?php echo $locality; ?></td>                                
                                    <td><?php echo $valor->getDirection(); ?></td>                                
                                    <td><?php echo $valor->getMobile(); ?></td>   
                                    
                                    <?php
                                    if(strcmp($valor->getTipo(),"") != 0)
                                    {?>
                                        <td><?php echo $tipo; ?></td>
                                    <?php                                    
                                    }
                                    else{?>
                                        <td><?php echo ''; ?></td>
                                    <?php
                                    }
                                    ?>
                                    
                                    
                                    <td id="tdAcciones">
                                        <?php
                                        echo '<a href="edit_client.php?id='.$valor->getCode().'"><img src="../../res/edit-16.png"></a>';                                                                                
                                        ?>                                        
                                    </td>  
                                </tr>                                                     
                            <?php
                            $cont++;
                            }
                            ?>   
                        </table>
                    </form> 
                    
                    <?php echo '<p>Ultimos registros de '.$objClientImpl->getCount().' encontrados</p>';   ?>
                    
                    
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