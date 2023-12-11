<?php
/**
 * Description of Banco
 *
 * @author MACOSystem
 */

  $code =strtoupper($_POST['b']);

  if(!empty($code)) {
        checkCodeArticle($code);
  }

  function checkCodeArticle($b) {          
    require './Conexion.php';
    $conex = Conexion::getInstancia();
    $sql  = "SELECT invtr.INVENNOMBR FROM inventario invtr WHERE UPPER(invtr.INVENCODIG) = '".$b."'";            
    $stid = oci_parse($conex, $sql);
    oci_execute($stid); 
    $nameArticle;


    while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {  
        $nameArticle = $row[0];
    }        

    echo $nameArticle;                            

  }

           
?>