<?php
session_start();

if(isset($_POST)){
    require_once '../models/Client.php';
    require_once '../models/ClientImpl.php';
    $objClientImpl = new ClientImpl();    
        
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;
    
    $name = $_POST['txbName'];

    require_once '../models/Bill.php';
    require_once '../models/BillImpl.php';
    $objBillImpl = new BillImpl();

    //echo 'es credito';
    require_once '../models/Collect.php';
    require_once '../models/CollectImpl.php';
    $objCollect = new Collect();
    $objCollectImpl = new CollectImpl();


    //echo 'menor a cero';
    $objCollect->setCodeCredit($_POST['hiddenCodeCredit']);
    $objCollect->setCodeConcept($_POST['hiddenCodeConcept']);
    
    $objCollect->setValue($_POST['txbValue']);    
    $variableA1 = $objCollect->getValue();
    $sig[] = '.';
    $sig[] = ',';
    $valor = str_replace($sig, '', $variableA1);
    $objCollect->setValue($valor); 
    
    
    $objCollect->setRegistrationDate(date("Y/m/d H:i:s"));
    $objCollect->setObservation($_POST['txbObservations']);
    $objCollect->setUser($_SESSION['userCode']);
    
    /*echo $objCollect->getCodeCredit().'<br>';
    echo $objCollect->getCodeConcept().'<br>';
    echo $objCollect->getValue().'<br>';
    echo $objCollect->getRegistrationDate().'<br>';
    echo $objCollect->getObservation().'<br>';
    echo $objCollect->getUser().'<br>';*/
    
    
    $objCollectImpl->insert($objCollect);
    
    
    //actualizar saldo
    require_once '../models/CreditImpl.php';
    require_once '../models/Credit.php';
    $objCreditImpl = new CreditImpl();
    $objCredit = new Credit();
    
    $totalCredito = $objCreditImpl->getValue($_POST['hiddenCodeCredit']);

    $objCollectImpl = new CollectImpl();

    $idCredit = $_POST['hiddenCodeCredit'];                    
    $totalRecaudado = $objCollectImpl->sumValueByBiil($idCredit);

    $objCredit->setCode($idCredit);
    $objCredit->setSaldo($totalCredito - $totalRecaudado);                    
    $objCreditImpl->updateSaldo($objCredit);
    
    //verifico  si ya se salda la deuda
    if($objCredit->getSaldo()<=0){
        $objCredit->setState('CA');
        $objCreditImpl->updateStateByID($objCredit);
    }        
                          
    echo '<script>document.location.href = "http://'.$ip.'/baruk/views/collect/"; </script>';    
}
?>