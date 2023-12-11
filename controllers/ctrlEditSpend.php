<?php
session_start();

if(isset($_POST)){
    require_once '../models/Spend.php';
    require_once '../models/SpendImpl.php';
    $objSpendImpl = new SpendImpl();
    
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;
    
    $objSpend = new Spend();    
    $objSpend->setCode($_POST['txbCode']);
    $objSpend->setCodeClient($_POST['txbCodeClient']);
    $objSpend->setCodeConcept($_POST['selectConcept']);
    $objSpend->setValue($_POST['txbValue']);
    
    $variableA1 = $objSpend->getValue();
    $sig[] = '.';
    $sig[] = ',';
    $valor = str_replace($sig, '', $variableA1);
    $objSpend->setValue($valor); 

    $objSpendImpl->update ($objSpend);
    echo '<script>document.location.href = "http://'.$ip.'/baruk/views/spend/"; </script>';
        

    
    
    
    
    
}
?>