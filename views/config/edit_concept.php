<?php
session_start();

include '../../com/server.php';
$server = new SimpleXMLElement($xmlstr);
$ip = $server->server[0]->ip;

if (!empty($_SESSION['userCode']) && !empty($_SESSION['userName']))
{
?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../../css/style.css" rel="stylesheet">
        <script src="../../js/jquery/jquery.js"></script>
        <script src="../../js/select.js"></script>
        <script src="../../js/alertify/alertify.js"></script>
        <link href="../../css/alertify/alertify.css" rel="stylesheet">
        <link href="../../css/alertify/themes/default.css" rel="stylesheet">
        <title>Conceptos</title>
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
                        Conceptos
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
            
            <?php
            if(isset($_GET))
            {?>
                <section class="contenido" id="contenidoGeneral">
                    <h1>Editar Concepto</h1>
                    <form method="post" action="../../controllers/ctrlEditConcept.php">
                        <?php
                        include_once '../../models/Concept.php';
                        include_once '../../models/ConceptImpl.php';
                        $objConceptImpl = new ConceptImpl();
                        
                        require_once '../../models/CreditImpl.php';
                        require_once '../../models/SpendImpl.php';
                        require_once '../../models/CollectImpl.php';
                        require_once '../../models/Credit.php';
                        require_once '../../models/Spend.php';
                        require_once '../../models/Collect.php';
                        
                        $objCredit = new Credit();
                        $objSpend = new Spend();                        
                        $objCollect = new Collect();
                        
                        $objCreditImpl = new CreditImpl();
                        $objSpendImpl = new SpendImpl();
                        $objCollectImpl = new CollectImpl;
                        
                        $objCredit->setCodeConcept($_GET['id']);
                        $objSpend->setCodeConcept($_GET['id']);
                        $objCollect->setCodeConcept($_GET['id']);
                        
                        
                        $conceptInCredit = $objCreditImpl->getCountConceptFromCredit($objCredit); 
                        $conceptInSpend = $objSpendImpl->getCountConceptFromSpend($objSpend);
                        $conceptInCollect = $objCollectImpl->getCountConceptFromCollect($objCollect);
                        
                                                
                        if($conceptInCredit > 0 || $conceptInSpend > 0 || $conceptInCollect > 0)
                        {
                            foreach ($objConceptImpl->getByCode($_GET[id]) as $valor) {   
                                echo '<input type="hidden" value="'.$valor->getCode().'" name="txbCodeHidden">';
                                echo '<input type="number" value="'.$valor->getCode().'" name="txbCode" placeholder="Código" maxlength="12" required readonly>';
                                echo '<input type="text" value="'.$valor->getName().'" name="txbName" placeholder="Nombres" maxlength="60" required>';                            
                            }
                            echo '<input type="submit" value="Guardar">';
                            echo '<script>alertify.error("No es posible modificar el código");</script>'; 
                            
                        }
                        else
                        {
                            foreach ($objConceptImpl->getByCode($_GET[id]) as $valor) {   
                                echo '<input type="hidden" value="'.$valor->getCode().'" name="txbCodeHidden">';
                                echo '<input type="number" value="'.$valor->getCode().'" name="txbCode" placeholder="Código" maxlength="12" required>';
                                echo '<input type="text" value="'.$valor->getName().'" name="txbName" placeholder="Nombres" maxlength="60" required>';                            
                            }
                            echo '<input type="submit" value="Guardar">';  
                        }
                        ?>  
                    </form>
                </section>
            <?php
            }?>
            
            
            <footer>
                <div class="franjaAzul"></div>    
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