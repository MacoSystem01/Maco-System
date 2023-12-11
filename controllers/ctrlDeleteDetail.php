<?php
session_start();

if(isset($_GET)){    
    require_once '../models/Detail.php';
    require_once '../models/DetailImpl.php';   
   
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;

    //DELETE DEL DETALLE
    $objDetail = new Detail();
    $objDetail->setCodeBill($_GET['idf']);    
    $objDetail->setCodeArticle($_GET['ida']);
    
    //obtengo el origen del articulo en detalle factura
    $objDetailImpl = new DetailImpl();
    $origen = $objDetailImpl->getOrigen($_GET['idf'], $_GET['ida']);
    
    
    $objDetailImpl->delete($objDetail);
    
    //INSERT ARTICULOS ELIMINADOS EN STOCK
    require_once '../models/Stock.php';
    require_once '../models/StockImpl.php';   
   
    $objStockImpl = new StockImpl();
    $objStock = new Stock();
    
    $objStock->setCode($_GET['ida']);
    $name = $objStockImpl->getNameArticle($_GET['ida']);
    $objStock->setName($name);
    $objStock->setMove('E');
    $objStock->setQuantity(3);
    
    $variable = $_GET['q'];
    $sig[] = '.';
    $sig[] = ',';
    $objStock->setQuantity(str_replace($sig, '', $variable));
    
    $objStock->setPriceBuy($objStockImpl->getLastPriceSold($_GET['ida']));
    $objStock->setPriceSold(0);
    $objStock->setUbication($origen);
    $objStock->setMoveDate(date("Y/m/d H:i:s"));
    $objStock->setUser($_SESSION['userCode']);
    
//    echo $objStock->getCode().'<br>';    
//    echo $objStock->getName().'<br>';
//    echo $objStock->getMove().'<br>';
//    echo $objStock->getQuantity().'<br>';
//    echo $objStock->getPriceBuy().'<br>';
//    echo $objStock->getPriceSold().'<br>';
//    echo $objStock->getUbication().'<br>';
//    echo $objStock->getMoveDate().'<br>';
//    echo $objStock->getUser().'<br>';
    
    
    //echo 'idf = '.$_GET['idf'].' - '.$_GET['ida'];
    //echo $objDetailImpl->getOrigen($_GET['idf'], $_GET['ida']);
    $objStockImpl->insert($objStock);
    
    
    //UPDATE TOTAL PRICE IN BILL
    require_once '../models/Bill.php';
    require_once '../models/BillImpl.php';
    require_once '../models/DetailImpl.php';
    require_once '../models/Detail.php';

    $objDetailImplUV = new DetailImpl();
    $objDetailUV = new Detail();
    $objBillImplUV = new BillImpl();
    $objBillUV = new Bill();

    $objBillUV->setCode($_GET['idf']);
    $objDetailUV->setCodeBill($_GET['idf']);

    $totalBillUV = $objDetailImplUV->getTotalDetailBill($objDetailUV);
    
    if($totalBillUV > 0)
        $objBillUV->setValueSale($totalBillUV);
    else
        $objBillUV->setValueSale(0);

    $objBillImplUV->updateTotal($objBillUV);
    //-------------------------



    echo '<script>document.location.href = "http://'.$ip.'/baruk/views/bill/edit_bill.php?id='.$_GET['idf'].'"; </script>';    
}
?>