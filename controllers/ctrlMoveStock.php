<?php

if(isset($_GET)){
    
    require_once '../models/Stock.php';
    require_once '../models/StockImpl.php';
    
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;

    $objStock = new Stock();    
    $objStock->setCode($_GET['id']);
    $objStock->setMove($_GET['m']);
    $objStock->setMoveDate($_GET['fm']);    
        
    $objStockImpl = new StockImpl();
    $objStockImpl->moveToAlmacen($objStock);
    
    echo '<script>document.location.href = "http://'.$ip.'/baruk/views/stock/"; </script>';
    
    
    
    
}
?>