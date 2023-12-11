<?php

if(isset($_GET)){
    require_once '../models/Spend.php';
    require_once '../models/SpendImpl.php';   
   
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;

    $objSpend = new Spend();
    $objSpend->setCode($_GET['id']);    

    $objSpendImpl = new SpendImpl();
    echo $objSpendImpl->delete($objSpend);
    
    echo '<script>document.location.href = "http://'.$ip.'/baruk/views/spend/"; </script>';    
}
?>
