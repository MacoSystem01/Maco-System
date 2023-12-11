<?php

if(isset($_POST)){
   
    echo 'en edit detail control';
    
    require_once '../models/Detail.php';
    require_once '../models/DetailImpl.php';
    
    $idBill = $_POST['hiddenCodeBill'];
    $idArticle = $_POST['hiddenCodeArticle'];
    $dateMove = $_POST['hiddenMoveDate'];
    
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;
    
    
    echo $_GET['idf'].'<br>';
    echo $_GET['ida'].'<br>';
    echo $_GET['m'].'<br>';
    echo $_GET['fm'].'<br>';
    echo $_GET['p'].'<br>';
    
    require_once '../models/Detail.php';
    require_once '../models/DetailImpl.php';
    
    $objDetail = new Detail();    
    $objDetail->setCodeBill($_GET['idf']);
    $objDetail->setCodeArticle($_GET['ida']);
    $objDetail->setQuantity(1);
    $objDetail->setValueUnit($_GET['pv']);
    $objDetail->setTotal($_GET['pv']);
    $objDetail->setMove($_GET['m']);
    $objDetail->setMoveDate($_GET['fm']);
    
    
    
    
    
    
    
    
    
    $objDetailImpl = new DetailImpl();   
    $objDetail = new Detail();
    
    foreach ($objDetailImpl->getByBillArticleDate($idBill, $idArticle, $dateMove)  as $valor) {        
        $objDetail->setCodeBill($valor->getCodeBill());
        $objDetail->setCodeArticle($valor->getCodeArticle());
        $objDetail->setMoveDate($valor->getMoveDate());
        $objDetail->setQuantity($_POST['txbQuantity']);
        
        $total = $_POST['txbQuantity'] * $valor->getValueUnit();                
        $objDetail->setTotal($total);                       
    }
    
    $objDetailImpl->updateQuantityAndTotal($objDetail);
    
    
    //bill update total
    require_once '../models/Bill.php';
    require_once '../models/BillImpl.php';
    
    $objBill = new Bill();
    $objBill->setCode($objDetail->getCodeBill());
    $totalBill = $objDetailImpl->getTotalDetailBill($objDetail);
    echo $totalBill;
    
    $objBill->setValueSale($totalBill);
    
    $objBillImpl = new BillImpl();
    $objBillImpl->updateTotal($objBill);
    
    
    //stock update quantity
    require_once '../models/Stock.php';
    require_once '../models/StockImpl.php';
    
    $objStock = new Stock();
    $objStock->setCode($idArticle);
    $objStock->setMove('S');
    $objStock->setMoveDate($dateMove);
    $objStock->setQuantity($_POST['txbQuantity']);
    
    $objStockImpl = new StockImpl();
    $objStockImpl->updateQuantity($objStock);
    
    
    
    echo '<script>document.location.href = "http://'.$ip.'/baruk/views/bill/edit_bill.php?id='.$objDetail->getCodeBill().'"; </script>';

    
//    echo $idBill.'<br>';
//    echo $idArticle.'<br>';
//    echo $dateMove.'<br>';
//    echo $_POST['txbQuantity'].'<br>';
//    echo $total.'<br>';
//    echo $valor->getValueUnit();
    
    
    
    
    
    
    
}
?>