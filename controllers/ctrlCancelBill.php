<?php
session_start();
if(isset($_GET)){
     require_once '../models/Bill.php';
    require_once '../models/BillImpl.php';
    require_once '../models/Detail.php';
    require_once '../models/DetailImpl.php';
    require_once '../models/Stock.php';
    require_once '../models/StockImpl.php';

    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;    
    
    $objBill = new Bill();    
    $objBill->setCode($_GET['id']);
    
    if(isset($_GET['ac']))
        $objBill->setState('IN');
    else if(isset ($_GET['in']))
        $objBill->setState('AC');
    
    
    $objBillImpl = new BillImpl();
    $objBillImpl->updateState($objBill);
    
    
    //Regresar los articulos de la factura cancelada al stock
    $objDetailImpl = new DetailImpl();
       
    foreach ($objDetailImpl->getByCode($_GET['id']) as $valor) {
//        echo 'Factura: '.$valor->getCodeBill().'<br>';
//        echo 'Articulo: '.$valor->getCodeArticle().'<br>';
//        echo '------------<br>';
        
        $objStock = new Stock();
        $objStockImpl = new StockImpl();

        $objStock->setCode($valor->getCodeArticle());
        $objStock->setName($objStockImpl->getNameArticle($valor->getCodeArticle()));
        $objStock->setMove('E');
        $objStock->setQuantity($valor->getQuantity());
        $objStock->setPriceBuy($objStockImpl->getLastPriceSold($valor->getCodeArticle()));
        $objStock->setPriceSold(0);
        $objStock->setUbication($objDetailImpl->getOrigen($_GET['id'], $valor->getCodeArticle()));
        $objStock->setMoveDate(date("Y/m/d H:i:s"));
        $objStock->setUser($_SESSION['userCode']);
        
        $objStockImpl->insert($objStock);
    }
                                
    echo '<script>document.location.href = "http://'.$ip.'/baruk/views/bill/"; </script>';    
}
?>