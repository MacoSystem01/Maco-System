<?php
session_start();

if(isset($_POST)){
    require_once '../models/Concept.php';
    require_once '../models/ConceptImpl.php';
    $objConceptImpl = new ConceptImpl();
    
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;
    
//    $num_rows = $objConceptImpl->checkCode($_POST['txbCode']);
    
    //echo 'es : '.$num_rows;
    
//    if($num_rows == 0)//ENABLE CODE
//    {
        //echo '1';
        $name = $_POST['txbName'];
        $objConcept = new Concept();    
        $objConcept->setCode($_POST['txbCode']);
        $objConcept->setName($name);
        
        $objConceptImpl->update ($objConcept, $_POST['txbCodeHidden']);
        echo '<script>document.location.href = "http://'.$ip.'/baruk/views/config/concepts.php"; </script>';
        
//    }
//    else // DISABLE CODE
//    {
//        //echo '2';
//        echo '<script>document.location.href = "http://'.$ip.'/baruk/views/config/add_type_client.php?e&id='.$_POST['txbCode'].'&n='.$_POST['txbName'].'&idh='.$_POST['txbCodeHidden'].'"; </script>';        
//    }
    
    
    
    
    
    
    
    
}
?>