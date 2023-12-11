<?php
/**
 * Description of Banco
 *
 * @author MACOSystem
 */


if (file_exists("../models/Conexion.php")) {
    include_once("../models/Conexion.php");    
    require_once('../models/Concept.php');
    
} else if (file_exists("../../models/Conexion.php")) {
    include_once("../../models/Conexion.php");    
    require_once('../../models/Concept.php');
}


class ConceptImpl
{
	
	public function ConceptImpl()
	{
		 
	}
        
        public function getAll()
	{
            $sql = "SELECT cncpto.CONCECODIG, cncpto.CONCENOMBR FROM concepto cncpto ORDER BY cncpto.CONCECODIG ASC";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objConcept = new Concept();
                $objConcept->setCode($row[0]);
                $objConcept->setName($row[1]);                
                $foo[] = $objConcept;
            }
            return $foo;
        }
        
        public function getAllOrderByName()
	{
            $sql = "SELECT cncpto.CONCECODIG, cncpto.CONCENOMBR FROM concepto cncpto ORDER BY cncpto.CONCENOMBR ASC";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objConcept = new Concept();
                $objConcept->setCode($row[0]);
                $objConcept->setName($row[1]);                
                $foo[] = $objConcept;
            }
            return $foo;
        }
        
        public function getNameConcept($idConcept) {
            $sql = "SELECT cncpt.CONCENOMBR FROM concepto cncpt WHERE cncpt.CONCECODIG = ".$idConcept;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function getByCode($idConcept)
	{
            $sql = "SELECT cncpt.CONCECODIG, cncpt.CONCENOMBR FROM concepto cncpt WHERE cncpt.CONCECODIG = ".$idConcept;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objConcept = new Concept();
                $objConcept->setCode($row[0]);
                $objConcept->setName($row[1]);
                $foo[] = $objConcept;
            }
            return $foo;
        }
        
        public function insert($objConcept){
            $sql = "INSERT INTO concepto (CONCECODIG, CONCENOMBR) VALUES (".$objConcept->getCode().",'".$objConcept->getName()."')";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }        
        
        public function update($objConcept, $id){   
            $sql = "UPDATE concepto cncpt 
			SET cncpt.CONCECODIG = ".$objConcept->getCode().", cncpt.CONCENOMBR = '".$objConcept->getName()."' 
			WHERE cncpt.CONCECODIG = ".$id;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 
        
        public function delete($objConcept){
            $sql = "DELETE FROM concepto cncpt WHERE cncpt.CONCECODIG = ".$objConcept->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }        
        
        public function getCount() {
            $sql = "SELECT  COUNT(*) FROM concepto";
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
            $sql  = "SELECT COUNT(*) FROM concepto cncpt WHERE cncpt.CONCECODIG = ".$code;            
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