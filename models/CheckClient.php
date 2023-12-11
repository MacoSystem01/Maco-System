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
    $sql  = "SELECT COUNT(*) FROM cliente clnt WHERE clnt.CLIENCODIG = ".$b;            
    $stid = oci_parse($conex, $sql);
    oci_execute($stid); 
    $contar;


    while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {  
        $contar = $row[0];
    }        

    if ($contar != 0) {
        echo ("El código del cliente ya existe");
    }
}

           
?>