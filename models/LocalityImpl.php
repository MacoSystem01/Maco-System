<?php
/**
 * Description of Banco
 *
 * @author MACOSystem
 */

if (file_exists("../models/Conexion.php")) {
    include_once("../models/Conexion.php");   
    
} else if (file_exists("../../models/Conexion.php")) {
    include_once("../../models/Conexion.php");
}


class LocalityImpl {
    
    public function LocalityImpl(){
        
    }


    public function getAll() {
        $sql = "SELECT lclt.localcodig, lclt.localdepar, lclt.localnombr  FROM localidad lclt";
        $conex = Conexion::getInstancia();
        $stid = oci_parse($conex, $sql);
        oci_execute($stid);
        $foo = array();
        while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
          $objLocality = new Locality();
          $objLocality->setCode($row[0]);
          $objLocality->setCodeDepartment($row[1]);
          $objLocality->setName($row[2]);
          $foo[] = $objLocality;
        }
        return $foo;
    }
    
    public function getByDepartment($idDepartment) {
        $sql = "SELECT lclt.localcodig, lclt.localdepar, lclt.localnombr FROM localidad lclt WHERE lclt.localdepar = ".$idDepartment;
        $conex = Conexion::getInstancia();
        $stid = oci_parse($conex, $sql);
        oci_execute($stid);
        $foo = array();
        while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
          $objLocality = new Locality();
          $objLocality->setCode($row[0]);
          $objLocality->setCodeDepartment($row[1]);
          $objLocality->setName($row[2]);
          $foo[] = $objLocality;
        }
        return $foo;
    }
    
    public function getNameLocality($idLocality) {
        $sql = "SELECT lclt.localnombr FROM localidad lclt WHERE lclt.localcodig = ".$idLocality;
        $conex = Conexion::getInstancia();
        $stid = oci_parse($conex, $sql);
        oci_execute($stid);
        $foo;
        
        while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
          $foo = $row[0];
        }        
        return $foo;
    }

}
