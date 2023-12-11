<?php
include_once("./Conexion.php");
$sql = "select 1 from dual" ;
                
$conex = Conexion::getInstancia();
$stid = oci_parse($conex, $sql);
oci_execute($stid);
 
$foo= array();
while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
 
     $foo[] = $row;
}
 
var_dump($foo);

?>