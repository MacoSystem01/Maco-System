<?php

if(isset($_GET)){
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;

    require_once '../models/Client.php';
    require_once '../models/ClientImpl.php';
    
    $objClient = new Client();    
    $objClient->setCode($_POST['txbCode']);
    $objClient->setName($_POST['txbName']);
    $objClient->setCodeDepartment($_POST['selectDepartment']);
    $objClient->setCodeLocality($_POST['selectLocality']);
    $objClient->setDirection($_POST['txbDirection']);
    $objClient->setMobile($_POST['txbMobile']);
    $objClient->setTipo($_POST['selectType']);
            
    $objClientImpl = new ClientImpl();
    $objClientImpl->update($objClient, $_POST['txbCodeHidden']);
    
    echo '<script>document.location.href = "http://'.$ip.'/baruk/views/clients/"; </script>';
    
}
?>