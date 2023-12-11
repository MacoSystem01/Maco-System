<?php

if(isset($_GET)){
    require_once '../models/Collect.php';
    require_once '../models/CollectImpl.php';   
   
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;

    $objCollect = new Collect();
    $objCollect->setCode($_GET['idr']);    
    
    $objCollectImpl = new CollectImpl();
    $valorTemporal = $objCollectImpl->getValueByCode($_GET['idr']);
    
    $objCollectImpl->delete($objCollect);
    
    
    //actualizar saldo
    require_once '../models/CreditImpl.php';
    require_once '../models/Credit.php';
    $objCreditImpl = new CreditImpl();
    $objCredit = new Credit();
    
    $objCollectImpl = new CollectImpl();

    $idCredit = $_GET['idc'];                    
    
    
    $totalSaldo = $objCreditImpl->getSaldo($idCredit);
    //echo $valorTemporal;
    
    $objCredit->setCode($idCredit);
    $objCredit->setSaldo($totalSaldo + $valorTemporal);                    
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
