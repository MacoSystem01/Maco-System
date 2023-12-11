<?php

if(isset($_GET)){
    
    require_once '../models/Stock.php';
    require_once '../models/StockImpl.php';
    
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;
    
    $objStock = new Stock();    
    $objStock->setCode($_POST['txbCode']);
    $objStock->setName($_POST['txbName']);
    $objStock->setQuantity($_POST['txbQuantity']);    
    $objStock->setMoveDate($_POST['txbDate']); 
        
    $objStockImpl = new StockImpl();    
    $objStockImpl->update($objStock, $_POST['txbCodeHidden']);
    
    echo '<script>document.location.href = "http://'.$ip.'/baruk/views/stock/"; </script>';
}
?>