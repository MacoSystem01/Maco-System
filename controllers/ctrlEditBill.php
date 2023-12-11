<?php

if(isset($_GET)){
        
    require_once '../models/Bill.php';
    require_once '../models/BillImpl.php';
    
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;

    $objBill = new Bill();    
    $objBill->setCode($_POST['txbCode']);
    $objBill->setClient($_POST['txbCodeClient']);
    $objBill->setPayment($_POST['selectPayment']);    
        
    $objBillImpl = new BillImpl();
    $objBillImpl->updateClientPayment($objBill);
    
    echo '<script>document.location.href = "http://'.$ip.'/baruk/views/bill/edit_bill.php?id='.$_POST['txbCode'].'"; </script>';
    
    
    
    
}
?>