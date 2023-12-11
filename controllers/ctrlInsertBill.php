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
        echo '<script>document.location.href = "http://'.$ip.'/baruk/views/clients/add_client.php?r&id=' . $_POST['txbCodeClient'] . '"; </script>';
    } 
    else
    {
//      echo 'A';
        $name = $_POST['txbName'];
    
        require_once '../models/Bill.php';
        require_once '../models/BillImpl.php';
        $objBillImpl = new BillImpl();


        $objBill = new Bill();    
        //$objBill->setCode($objBillImpl->getSequence());
        $objBill->setClient($_POST['txbCodeClient']);
        $objBill->setGenerationDate($_POST['txbDateGeneration']);
        $objBill->setValueSale($_POST['txbValueSale']);
        //$objBill->setValueBuy($_POST['txbValueBuy']);
        $objBill->setValueBuy(0);
        $objBill->setPayment($_POST['selectPayment']);
        $objBill->setUser($_SESSION['userCode']); 
        $objBill->setState('AC');

        $objBillImpl->insert($objBill);

        $date = date_create($_POST['txbDateGeneration']);
        $f = strtoupper(date_format($date, 'd-M-y H:i:s'));

        $objBill->setGenerationDate($f);
		//$objBill->setGenerationDate('08/01/2016 11:45:40'); 		
        //obtengo el id de la factura recien ingresada
        $idRegister = $objBillImpl->getId($objBill);

        
        //CREACION DEL CREDITO 
        if(strcmp($_POST['selectPayment'], "CR") == 0)
        {
            //echo 'es credito';
            require_once '../models/Credit.php';
            require_once '../models/CreditImpl.php';
            $objCredit = new Credit();
            $objCreditImpl = new CreditImpl();
            
            $num_rows_credit = $objCreditImpl->checkCodeBillInCredit($idRegister);
            
            //si existe el credito ingresa
            if($num_rows_credit>0)
            {
                //echo 'mayor a cero';
            }
            else//si no existe el credito
            {
                //echo 'menor a cero';
                $objCredit->setCodeClient($_POST['txbCodeClient']);
                $objCredit->setCodeBill($idRegister);
                $objCredit->setRegistrationDate(date("Y/m/d H:i:s"));
                $objCredit->setCodeConcept(15);
                $objCredit->setValue($_POST['txbValueSale']);
                $objCredit->setSaldo($_POST['txbValueSale']);
                $objCredit->setState('AC');
                $objCredit->setCancelDate(date("Y/m/d H:i:s"));
                $objCredit->setUser($_SESSION['userCode']);
                $objCreditImpl->insert($objCredit);
            }
        }
        else{
            //echo 'no es credito';
        }
        
        

        echo '<script>document.location.href = "http://'.$ip.'/baruk/views/bill/edit_bill.php?id='.$idRegister.'"; </script>';
        
    }
    
    
    
    
    
    
}
?>