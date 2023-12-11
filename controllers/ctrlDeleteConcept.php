<?php

if(isset($_GET)){
    require_once '../models/Concept.php';
    require_once '../models/ConceptImpl.php';
    require_once '../models/CreditImpl.php';
    require_once '../models/SpendImpl.php';
    require_once '../models/CollectImpl.php';
    
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;

    $objConcept = new Concept();
    $objConcept->setCode($_GET['id']);    
    
    $objCreditImpl = new CreditImpl();
    $objCredit = new Credit();
    $objCredit->setCodeConcept($_GET['id']);
    
    $objSpendImpl = new SpendImpl();
    $objSpend = new Spend();
    $objSpend->setCodeConcept($_GET['id']);
    
    $objCollectImpl = new CollectImpl();
    $objCollect = new Collect();
    $objCollect->setCodeConcept($_GET['id']);

    $conceptInCredit = $objCreditImpl->getCountConceptFromCredit($objCredit); 
    $conceptInSpend = $objSpendImpl->getCountConceptFromSpend($objSpend);
    $conceptInCollect = $objCollectImpl->getCountConceptFromCollect($objCollect);
                        
                                                
    if($conceptInCredit > 0 || $conceptInSpend > 0 || $conceptInCollect > 0)
    {
        echo '<script>document.location.href = "http://'.$ip.'/baruk/views/config/concepts.php?em"; </script>';    
    }
    else
    {
        $objConceptImpl = new ConceptImpl();
        $objConceptImpl->delete($objConcept);
        echo '<script>document.location.href = "http://'.$ip.'/baruk/views/config/concepts.php"; </script>';    
    }
    
    //echo '<script>document.location.href = "http://'.$ip.'/baruk/views/config/concepts.php"; </script>';    
}
?>
