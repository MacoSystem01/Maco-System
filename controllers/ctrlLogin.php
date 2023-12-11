<?php
session_start();
require("../models/UserImpl.php");
$objUserImpl = new UserImpl();

$userName = $_POST['txbUser'];
$pass = $_POST['txbPassword'];

include '../com/server.php';
$server = new SimpleXMLElement($xmlstr);
$ip = $server->server[0]->ip;


$encontrados = $objUserImpl->login($userName, $pass);
if($encontrados>0){
    $codeUser = $objUserImpl->getIdbyName($userName);
    $_SESSION['userCode'] = $codeUser; 
    $_SESSION['userName'] = $userName;
    echo '<script>document.location.href = "http://'.$ip.'/baruk/"; </script>';    
}
 else {
    echo '<script>document.location.href = "http://'.$ip.'/baruk/login.php?error"; </script>';    
    
 }

//$pass = sha1($_POST['txbPass']);
//$pass2 = md5($_POST['txbPass']);
//
//echo $pass.'<br>';
//echo $pass2.'<br>';
//echo hash('sha256', $_POST['ppasscode']);

?>