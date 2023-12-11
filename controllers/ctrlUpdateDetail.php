<?php
session_start();

if(isset($_POST)){
    
//    echo $_POST['txbQuantityBuyDetail'];
//    echo $_POST['txbPriceSaleDetail'];
    
    require_once '../models/Detail.php';
    require_once '../models/DetailImpl.php';
    require_once '../models/Stock.php';
    require_once '../models/StockImpl.php'; 
    require_once '../models/Bill.php';
    require_once '../models/BillImpl.php';

    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;
    
    $objDetail = new Detail(); 
    $objDetailImpl = new DetailImpl();
    
    
    if(isset($_POST['txbQuantityBuyDetail']) && isset($_POST['txbPriceSaleDetail']))
    {
        $objDetail->setCodeBill($_POST['hiddenCodeBillDetail']);
        $objDetail->setCodeArticle($_POST['hiddenCodeArticleDetail']);
        $quantityInDetail = $objDetailImpl->getQuantityInDetailByBill($objDetail);
        
        $variableUM1 = $_POST['txbQuantityBuyDetail'];
        $sig[] = '.';
        $sig[] = ',';
        $cantidadSolicitada = str_replace($sig, '', $variableUM1);
        
        $objDetail->setValueUnit($_POST['txbPriceSaleDetail']);            
        $variableUA2 = $objDetail->getValueUnit();
        $sig[] = '.';
        $sig[] = ',';
        $precioVentaFormateado = str_replace($sig, '', $variableUA2);
        $objDetail->setValueUnit($precioVentaFormateado);
        
        if($quantityInDetail > $cantidadSolicitada)
        {
//            echo 'es mayor lo del detalle';
//            echo 'En detalle: '.$quantityInDetail.'<br>';
//            echo 'Solicitado: '.$cantidadSolicitada.'<br>';
            $diferencia = $quantityInDetail-$cantidadSolicitada;            
//            echo 'Diferencia: '.$diferencia.' En detalle mayor que lo solicitado';
            
            $objDetail->setQuantity($cantidadSolicitada);
            $objDetail->setTotal($objDetail->getQuantity() * $objDetail->getValueUnit());
            $objDetail->setMove('V');
            
            $objDetailImpl->updateQuantityValUnitValTotal($objDetail); 
            
            //inserto la diferencia como entrada (lo que se regresa al stock)
            $objStockU = new Stock();
            $objStockImplU = new StockImpl();
            
            $objStockU->setCode($objDetail->getCodeArticle());
            $objStockU->setName($objStockImplU->getNameArticle($objDetail->getCodeArticle()));
            $objStockU->setMove('E');
            $objStockU->setQuantity($diferencia);
            $objStockU->setPriceBuy($objStockImplU->getLastPriceSold($objDetail->getCodeArticle()));
            $objStockU->setPriceSold(0);
            
            
            $objStockU->setUbication($objDetailImpl->getOrigen($_POST['hiddenCodeBillDetail'], $objDetail->getCodeArticle()));
            
            $objStockU->setMoveDate(date("Y/m/d H:i:s"));
            $objStockU->setUser($_SESSION['userCode']);
            
            $objStockImplU->insert($objStockU);   
            
            //actualizar total factura
            $objBill = new Bill();
            $objBill->setCode($_POST['hiddenCodeBillDetail']);

            $totalBill = $objDetailImpl->getTotalDetailBill($objDetail);

            $objBill->setValueSale($totalBill);

            $objBillImpl = new BillImpl();
            $objBillImpl->updateTotal($objBill);
        }
        else if($quantityInDetail < $cantidadSolicitada)
        {
            
//            echo 'En detalle: '.$quantityInDetail.'<br>';
//            echo 'Solicitado: '.$cantidadSolicitada.'<br>';
//            $difer = $cantidadSolicitada-$quantityInDetail;
//            echo 'Diferencia: '.$difer.' En detalle menor que lo solicitado';
    //            echo 'es menor lo del detalle';
                //verificar existencia del detalle segun la remision     
            if($objDetailImpl->checkDetailExistencia($objDetail) > 0){
                //como existe el articulo en el detalle, ahora se obtiene la cantidad ingresada
                //cantidad a actualizar 
                $objDetail->setQuantity($cantidadSolicitada);        

                $total = $objDetail->getQuantity() * $objDetail->getValueUnit();  
                $objDetail->setTotal($total);

                $objDetail->setMove('V');

//                echo $objDetail->getCodeBill().'<br>';
//                echo $objDetail->getCodeArticle().'<br>';
//                echo $objDetail->getMove().'<br>';
//                echo $objDetail->getValueUnit().'<br>';
//                echo $objDetail->getQuantity().'<br>';
//                echo $objDetail->getTotal().'<br>';
//                echo $quantityInDetail.'<br>';
//                echo $cantidadSolicitada.'<br>';
                
                //actualizar el detail con los nuevos valores
                $objDetailImpl->updateQuantityValUnitValTotal($objDetail);
//
                //inserto la diferencia como entrada (lo que se regresa al stock)
                $objStockU = new Stock();
                $objStockImplU = new StockImpl();

                $objStockU->setCode($objDetail->getCodeArticle());
                $objStockU->setName($objStockImplU->getNameArticle($objDetail->getCodeArticle()));
                $objStockU->setMove('V');
                $objStockU->setQuantity($cantidadSolicitada-$quantityInDetail);
                $objStockU->setPriceBuy(0);
                $objStockU->setPriceSold(0);
                $objStockU->setUbication($objDetailImpl->getOrigen($_POST['hiddenCodeBillDetail'], $objDetail->getCodeArticle()));
                $objStockU->setMoveDate(date("Y/m/d H:i:s"));
                $objStockU->setUser($_SESSION['userCode']);
//
                $objStockImplU->insert($objStockU);
                
                //actualizar total factura
                $objBill = new Bill();
                $objBill->setCode($_POST['hiddenCodeBillDetail']);

                $totalBill = $objDetailImpl->getTotalDetailBill($objDetail);

                $objBill->setValueSale($totalBill);

                $objBillImpl = new BillImpl();
                $objBillImpl->updateTotal($objBill);
            }               
        }
        else if($quantityInDetail == $cantidadSolicitada){
                //cantidad a actualizar 
                $objDetail->setQuantity($cantidadSolicitada);        
                $total = $objDetail->getQuantity() * $objDetail->getValueUnit();  
                $objDetail->setTotal($total);
               
                //actualizar el detail con los nuevos valores
                $objDetailImpl->updateQuantityValUnitValTotal($objDetail);
                
                //actualizar total factura
                $objBill = new Bill();
                $objBill->setCode($_POST['hiddenCodeBillDetail']);

                $totalBill = $objDetailImpl->getTotalDetailBill($objDetail);

                $objBill->setValueSale($totalBill);

                $objBillImpl = new BillImpl();
                $objBillImpl->updateTotal($objBill);
        }
    }
    
    echo '<script>document.location.href = "http://'.$ip.'/baruk/views/bill/edit_bill.php?id='.$_POST['hiddenCodeBillDetail'].'"; </script>';
    
    
    
    /**************
    
    
       
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
        //$objDetail->setMoveDate(date("Y/m/d H:i:s"));
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
    $objStock->setUbication('A');
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
    *****/
}
?>