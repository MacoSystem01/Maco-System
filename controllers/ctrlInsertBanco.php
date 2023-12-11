<?php
session_start();

if(isset($_POST)){
    require_once '../models/Banco.php';
    require_once '../models/BancosImpl.php';
    $objBancosImpl = new BancosImpl();
    
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;
    
    $num_rows = $objBancosImpl->checkCode($_POST['txbCode']);
    
    //echo 'es : '.$num_rows;
    
    if($num_rows == 0)//ENABLE CODE
    {
        //echo '1';
        $name = $_POST['txbName'];
        $objBancos = new Banco();    
        $objBancos->setCode($_POST['txbCode']);
        $objBancos->setName($name);
        $objBancos->setGenerationDate(date('Y/m/d H:i:s'));
        
		
		
        $variableA1 = $_POST['txbValor'];
        $sig[] = '.';
        $sig[] = ',';
        $valor = str_replace($sig, '', $variableA1);
        $objBancos->setValor($valor);
		
        $objBancosImpl->insert($objBancos);
        echo '<script>document.location.href = "http://'.$ip.'/baruk/views/config/bancos.php"; </script>';
        
    }
    else // DISABLE CODE
    {
        //echo '2';
        echo '<script>document.location.href = "http://'.$ip.'/baruk/views/config/add_banco.php?e&id='.$_POST['txbCode'].'&n='.$_POST['txbName'].'"; </script>';        
    }
    
}
?>