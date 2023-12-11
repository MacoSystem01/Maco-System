<?php
session_start();

include '../com/server.php';
$server = new SimpleXMLElement($xmlstr);
$ip = $server->server[0]->ip;

if(!empty($_SESSION['userCode']))
{
	unset($_SESSION['userCode']);
	unset($_SESSION['userName']);
	session_destroy();
	echo '<script>document.location.href = "http://'.$ip.'/baruk/login.php"; </script>';    
	exit;
}
else
{
	echo '<script>document.location.href = "http://'.$ip.'/baruk/login.php"; </script>';    
}
?>