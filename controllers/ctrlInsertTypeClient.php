<?php
session_start();

if(isset($_POST)){
    require_once '../models/TypeClient.php';
    require_once '../models/TypeClientImpl.php';
    $objTypeClientImpl = new TypeClientImpl();
    
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;
    
    $num_rows = $objTypeClientImpl->checkCode($_POST['txbCode']);
    
    //echo 'es : '.$num_rows;
    
    if($num_rows == 0)//ENABLE CODE
    {
        //echo '1';
        $name = $_POST['txbName'];
        $objTypeClient = new TypeClient();    
        $objTypeClient->setCode($_POST['txbCode']);
        $objTypeClient->setName($name);
        
        $objTypeClientImpl->insert($objTypeClient);
        echo '<script>document.location.href = "http://'.$ip.'/baruk/views/config/type_clients.php"; </script>';
        
    }
    else // DISABLE CODE
    {
        //echo '2';
        echo '<script>document.location.href = "http://'.$ip.'/baruk/views/config/add_type_client.php?e&id='.$_POST['txbCode'].'&n='.$_POST['txbName'].'"; </script>';        
    }
    
    
    
    
    
    
    
    
}
?>