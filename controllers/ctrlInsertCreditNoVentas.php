<?php
session_start();

if(isset($_POST)){
    require_once '../models/Client.php';
    require_once '../models/ClientImpl.php';
    $objClientImpl = new ClientImpl();    
    
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;
    
    $num_rows = $objClientImpl->checkCode($_POST['txbCodeClient']);
    
    //echo 'es : '.$num_rows;
    
    if($num_rows == 0)//debe registrar el cliente
    {
//      echo 'B';
        echo '<script>document.location.href = "http://'.$ip.'/baruk/views/clients/add_client.php?r&c&id=' . $_POST['txbCodeClient'] . '"; </script>';
    } 
    else
    {

        //INSERT FACTU Y LUEGO GET CODIGO
        $name = $_POST['txbName'];
        
        require_once '../models/Bill.php';
        require_once '../models/BillImpl.php';
        $objBillImpl = new BillImpl();

        $variableA = $_POST['txbValue'];
        $sig[] = '.';
        $sig[] = ',';
        $valueS = str_replace($sig, '', $variableA);
        
        $objBill = new Bill();    
        $objBill->setClient($_POST['txbCodeClient']);
        $objBill->setGenerationDate($_POST['txbDateGeneration']);
        $objBill->setValueSale($valueS);
        $objBill->setValueBuy(0);
        $objBill->setPayment('CR');
        $objBill->setUser($_SESSION['userCode']); 
        $objBill->setState('AC');
        $objBillImpl->insert($objBill);
        
        $date = date_create($_POST['txbDateGeneration']);
        $f = strtoupper(date_format($date, 'd-M-y H:i:s'));
        $objBill->setGenerationDate($f);
        $idRegister = $objBillImpl->getId($objBill);

        
        //CREACION DEL CREDITO 
        require_once '../models/Credit.php';
        require_once '../models/CreditImpl.php';
        $objCredit = new Credit();
        $objCreditImpl = new CreditImpl();            
            
        $objCredit->setCodeClient($_POST['txbCodeClient']);
        $objCredit->setCodeBill($idRegister);
        $objCredit->setRegistrationDate(date("Y/m/d H:i:s"));
        $objCredit->setCodeConcept(11);
        
        
            
        $objCredit->setValue($valueS);
        $objCredit->setSaldo($valueS);
        
        $objCredit->setState('AC');
        $objCredit->setCancelDate(date("Y/m/d H:i:s"));
        $objCredit->setUser($_SESSION['userCode']);
        $objCreditImpl->insert($objCredit);      
        

        echo '<script>document.location.href = "http://'.$ip.'/baruk/views/credit/"; </script>';
        
    }
    
    
    
    
    
    
}
?>