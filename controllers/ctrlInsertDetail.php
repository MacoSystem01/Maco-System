<?php
session_start();

if(isset($_POST)){
    
//    echo $_POST['txbQuantityBuyDetail'];
//    echo $_POST['txbPriceSaleDetail'];
    
    require_once '../models/Detail.php';
    require_once '../models/DetailImpl.php';
    require_once '../models/Stock.php';
    require_once '../models/StockImpl.php'; 

    $objDetail = new Detail(); 
    $objDetailImpl = new DetailImpl();
    
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;
       
    $objDetail->setCodeBill($_POST['hiddenCodeBill']);
    $objDetail->setCodeArticle($_POST['hiddenCodeArticle']);
    $objDetail->setQuantity($_POST['txbQuantityBuy']);
    
    $variableA1 = $objDetail->getQuantity();
    $sig[] = '.';
    $sig[] = ',';
    $cantidadComprada = str_replace($sig, '', $variableA1);
    $objDetail->setQuantity($cantidadComprada); 
    
    $variableA = $_POST['txbPriceSale'];
    $sig[] = '.';
    $sig[] = ',';
    $valueSaleUnit = str_replace($sig, '', $variableA);    
    $objDetail->setValueUnit($valueSaleUnit);
    
    $origen = $_POST['hiddenOrigen'];
        if(strcmp($origen, "NACIONAL") == 0)
            $origen = 'N';
        else if(strcmp($origen, "IMPORTADO") == 0)
            $origen = 'I';       
    $objDetail->setOrigen($origen);
    
    //verificar existencia del detalle segun la remision     
    if($objDetailImpl->checkDetailExistencia($objDetail) > 0){
        //como existe el articulo en el detalle, ahora se obtiene la cantidad ingresada
        $quantityInDetail = $objDetailImpl->getQuantityInDetailByBill($objDetail);
        //cantidad a actualizar 
        $objDetail->setQuantity($objDetail->getQuantity()+$quantityInDetail);        
    
        $total = $objDetail->getQuantity() * $valueSaleUnit;  
        $objDetail->setTotal($total);

        $objDetail->setMove('V');
        
        //actualizar el detail con los nuevos valores
        $objDetailImpl->updateQuantityValUnitValTotal($objDetail);       
    }
    else{    
        $total = $objDetail->getQuantity() * $valueSaleUnit;  
        $objDetail->setTotal($total);

        $objDetail->setMove('V');
        $objDetail->setMoveDate(date("Y/m/d H:i:s"));
                
        $objDetailImpl->insert($objDetail);
    }
    
    
    
    //INSERT TO STOCK TABLE
       
    
    $name = $_POST['hiddenName'];
    
    $objStock = new Stock();    
    $objStock->setCode($_POST['hiddenCodeArticle']);
    $objStock->setName($name);
    $objStock->setMove('V');
    $objStock->setQuantity($cantidadComprada);
    $objStock->setPriceBuy($_POST['hiddenPriceBuy']);
    $objStock->setPriceSold($valueSaleUnit);
    $objStock->setUbication($origen);
    $objStock->setMoveDate(date("Y/m/d H:i:s"));
    $objStock->setUser($_SESSION['userCode']);    
    
    $variable = $objStock->getPriceBuy(); 
    $sig[] = '.';
    $sig[] = ',';
    $objStock->setPriceBuy(str_replace($sig, '', $variable));
        
    $objStockImpl = new StockImpl();
    $objStockImpl->insert($objStock);   
    
    

    //UPDATE TOTAL PRICE IN BILL
    require_once '../models/Bill.php';
    require_once '../models/BillImpl.php';
    
    $objBill = new Bill();
    $objBill->setCode($_POST['hiddenCodeBill']);
        
    $totalBill = $objDetailImpl->getTotalDetailBill($objDetail);
        
    $objBill->setValueSale($totalBill);
    
    $objBillImpl = new BillImpl();
    $objBillImpl->updateTotal($objBill);
    
    
    echo '<script>document.location.href = "http://'.$ip.'/baruk/views/bill/edit_bill.php?id='.$_POST['hiddenCodeBill'].'"; </script>';
  
}
?>