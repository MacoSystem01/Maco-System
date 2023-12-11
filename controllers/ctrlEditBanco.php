<?php
session_start();

if(isset($_POST)){
    require_once '../models/Banco.php';
    require_once '../models/BancosImpl.php';
    $objBancosImpl = new BancosImpl();
    
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;
    
        $name = $_POST['txbName'];
        $objBancos = new Banco();    
        $objBancos->setCode($_POST['txbCode']);
        $objBancos->setName($name);
				
		$variableA1 = $_POST['txbValor'];
        $sig[] = '.';
        $sig[] = ',';
        $valor = str_replace($sig, '', $variableA1);
        
		$objBancos->setValor($valor);
		
        $objBancosImpl->update ($objBancos, $_POST['txbCodeHidden']);
        echo '<script>document.location.href = "http://'.$ip.'/baruk/views/config/bancos.php"; </script>';

}
?>