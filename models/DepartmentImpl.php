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



class DepartmentImpl {
    
    private $objDataBase;

    public function DepartmentImpl() {
        
    }

    public function getAll() {
        $sql = "SELECT dpnbr.deparcodig, dpnbr.deparnombr FROM departamen dpnbr";
        $conex = Conexion::getInstancia();
        $stid = oci_parse($conex, $sql);
        oci_execute($stid);
        $foo = array();
        while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
          $objDepartment = new Department();
          $objDepartment->setCode($row[0]);
          $objDepartment->setName($row[1]);
          $foo[] = $objDepartment;
        }        
        return $foo;
    }
    
    public function getNameDepartment($idDepartment) {
        $sql = "SELECT dpnbr.deparnombr FROM departamen dpnbr WHERE dpnbr.deparcodig = ".$idDepartment;
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
