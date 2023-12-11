<?php
/**
 * Description of Banco
 *
 * @author MACOSystem
 */


if (file_exists("../models/Conexion.php")) {
    include_once("../models/Conexion.php");    
    require_once('../models/TypeClient.php');
    
} else if (file_exists("../../models/Conexion.php")) {
    include_once("../../models/Conexion.php");    
    require_once('../../models/TypeClient.php');
}


class TypeClientImpl
{
	
	public function TypeClientImpl()
	{
		 
	}
        
        public function getAll()
	{
            $sql = "SELECT tclnt.TIPCLCODIG, tclnt.TIPCLNOMBR FROM tiposclien tclnt ORDER BY tclnt.TIPCLCODIG ASC";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objTypeClient = new TypeClient();
                $objTypeClient->setCode($row[0]);
                $objTypeClient->setName($row[1]);                
                $foo[] = $objTypeClient;
            }
            return $foo;
        }
        
        public function getNameTypeClient($idTypeClient) {
            $sql = "SELECT tclnt.TIPCLNOMBR FROM tiposclien tclnt WHERE tclnt.TIPCLCODIG = ".$idTypeClient;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function getByCode($idTypeClient)
	{
            $sql = "SELECT tclnt.TIPCLCODIG, tclnt.TIPCLNOMBR FROM tiposclien tclnt WHERE tclnt.TIPCLCODIG = ".$idTypeClient;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objTypeClient = new TypeClient();
                $objTypeClient->setCode($row[0]);
                $objTypeClient->setName($row[1]);
                $foo[] = $objTypeClient;
            }
            return $foo;
        }
        
        public function insert($objTypeClient){
            $sql = "INSERT INTO tiposclien (TIPCLCODIG, TIPCLNOMBR) VALUES (".$objTypeClient->getCode().",'".$objTypeClient->getName()."')";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }        
        
        public function update($objTypeClient, $id){   
            $sql = "UPDATE tiposclien tclnt 
			SET tclnt.TIPCLCODIG = ".$objTypeClient->getCode().", tclnt.TIPCLNOMBR = '".$objTypeClient->getName()."' WHERE tclnt.TIPCLCODIG = ".$id;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 
        
        public function delete($objTypeClient){
            $sql = "DELETE FROM tiposclien tclnt WHERE tclnt.TIPCLCODIG = ".$objTypeClient->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }        
        
        public function getCount() {
            $sql = "SELECT  COUNT(*) FROM tiposclien";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function checkCode($code) {            
            $sql  = "SELECT COUNT(*) FROM tiposclien tclnt WHERE tclnt.TIPCLCODIG = ".$code;            
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