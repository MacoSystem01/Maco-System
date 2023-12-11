<?php

if(isset($_GET)){
    require_once '../models/Banco.php';
    require_once '../models/BancoImpl.php';
    
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;

    $objBanco = new Banco();
    $objBanco->setCode($_GET['id']);    
    
    if($conceptInCredit > 0 || $conceptInSpend > 0 || $conceptInCollect > 0)
    {
        echo '<script>document.location.href = "http://'.$ip.'/baruk/views/config/banco.php?em"; </script>';    
    }
    else
    {
        $objBanco = new BancoImpl();
        $objBancoImpl->delete($objBanco);
        echo '<script>document.location.href = "http://'.$ip.'/baruk/views/config/banco.php"; </script>';    
    }
    
    //echo '<script>document.location.href = "http://'.$ip.'/baruk/views/config/concepts.php"; </script>';    
}
?>
