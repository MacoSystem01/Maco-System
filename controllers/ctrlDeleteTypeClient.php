<?php

if(isset($_GET)){
    require_once '../models/TypeClient.php';
    require_once '../models/TypeClientImpl.php';
    require_once '../models/ClientImpl.php';
   
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;

    $objTypeClient = new TypeClient();
    $objTypeClient->setCode($_GET['id']);    

    $objClientImpl = new ClientImpl();
    $objClient = new Client();
    $objClient->setTipo($_GET['id']);
    
    $typeClientInClient = $objClientImpl->getCountTypeClientFromClient($objClient);
    
    if($typeClientInClient > 0)
    {
        echo '<script>document.location.href = "http://'.$ip.'/baruk/views/config/type_clients.php?em"; </script>';    
    }
    else
    {
        $objTypeClientImpl = new TypeClientImpl();
        echo $objTypeClientImpl->delete($objTypeClient);
        echo '<script>document.location.href = "http://'.$ip.'/baruk/views/config/type_clients.php"; </script>';    
    }
    
        
    echo '<script>document.location.href = "http://'.$ip.'/baruk/views/config/type_clients.php"; </script>';    
}
?>

