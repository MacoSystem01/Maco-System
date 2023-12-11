<?php
session_start();

if(isset($_POST)){
    require_once '../models/Collect.php';
    require_once '../models/CollectImpl.php';
    $objCollectImpl = new CollectImpl();
    
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;

    $objCollect = new Collect();    
    $objCollect->setCode($_POST['txbCodeHidden']);
    
    $objCollect->setValue($_POST['txbValue']);
    $variableA1 = $objCollect->getValue();
    $sig[] = '.';
    $sig[] = ',';
    $valor = str_replace($sig, '', $variableA1);
    $objCollect->setValue($valor); 
    $objCollect->setObservation($_POST['txbObservations']);

    $objCollectImpl->update($objCollect);
    
    
    //actualizar saldo
    require_once '../models/CreditImpl.php';
    require_once '../models/Credit.php';
    $objCreditImpl = new CreditImpl();
    $objCredit = new Credit();
    
    $totalCredito = $objCreditImpl->getValue($_POST['txbCodeCreditHidden']);

    $objCollectImpl = new CollectImpl();

    $idCredit = $_POST['txbCodeCreditHidden'];                    
    $totalRecaudado = $objCollectImpl->sumValueByBiil($idCredit);

    $objCredit->setCode($idCredit);
    $objCredit->setSaldo($totalCredito - $totalRecaudado);                    
    $objCreditImpl->updateSaldo($objCredit);
    
    //verifico  si ya se salda la deuda
    if($objCredit->getSaldo()<=0){
        $objCredit->setState('CA');
        $objCreditImpl->updateStateByID($objCredit);
    }
    else{
        $objCredit->setState('AC');
        $objCreditImpl->updateStateByID($objCredit);
    }
    
    echo '<script>document.location.href = "http://'.$ip.'/baruk/views/collect/"; </script>';    
}
?>