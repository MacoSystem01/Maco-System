<?php
/**
 * Description of Banco
 *
 * @author MACOSystem
 */

  $code =strtoupper($_POST['b']);

  if(!empty($code)) {
        checkCode($code);
  }

  function checkCode($b) {          
    require './Conexion.php';
    $conex = Conexion::getInstancia();
    $sql  = "SELECT clnt.CLIENNOMBR FROM cliente clnt WHERE clnt.CLIENCODIG = ".$b;            
    $stid = oci_parse($conex, $sql);
    oci_execute($stid); 
    $name;


    while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {  
        $name = $row[0];
    }        

    echo $name;
    
}

           
?>