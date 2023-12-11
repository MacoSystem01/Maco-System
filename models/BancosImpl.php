<?php
/**
 * Description of Banco
 *
 * @author MACOSystem
 */

if (file_exists("../models/Conexion.php")) {
    include_once("../models/Conexion.php");    
    require_once('../models/Banco.php');
    
} else if (file_exists("../../models/Conexion.php")) {
    include_once("../../models/Conexion.php");    
    require_once('../../models/Banco.php');
}

class BancosImpl
{
	
	public function BancosImpl()
	{
		 
	}
        
        public function getAll()
	{
            $sql = "select bancocodig, banconombr, bancofecha, bancovalor from banco order by bancocodig";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objBancos = new Banco();
                $objBancos->setCode($row[0]);
                $objBancos->setName($row[1]);
                $objBancos->setgenerationDate($row[2]);                
                $objBancos->setValor($row[3]);                
                $foo[] = $objBancos;
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
        
        public function getByCode($idBanco)
	{
            $sql = "SELECT BANCOCODIG, BANCONOMBR, BANCOVALOR FROM banco WHERE BANCOCODIG = ".$idBanco;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objBancos = new Banco();
                $objBancos->setCode($row[0]);
                $objBancos->setName($row[1]);
				$objBancos->setValor($row[2]);
                $foo[] = $objBancos;
            }
            return $foo;
        }
        
        public function insert($objBancos){
            $sql = "INSERT INTO banco (BANCOCODIG, BANCONOMBR, BANCOFECHA, BANCOVALOR) 
			VALUES (".$objBancos->getCode().", '".$objBancos->getName()."', 
			TO_DATE('".$objBancos->getGenerationDate()."', 'yyyy/mm/dd hh24:mi:ss'), 
			".$objBancos->getValor().")";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }        
        
        public function update($objBancos, $id){   
            $sql = "UPDATE banco 
			SET BANCOCODIG = ".$objBancos->getCode().", BANCONOMBR = '".$objBancos->getName()."', BANCOVALOR = ".$objBancos->getValor()." WHERE BANCOCODIG = ".$id;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 
        
        public function delete($objBancos){
            $sql = "DELETE FROM banco WHERE BANCOCODIG = ".$objBanco->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }        
        
        public function getCount() {
            $sql = "SELECT COUNT(*) FROM banco";
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
            $sql  = "SELECT COUNT(*) FROM banco WHERE BANCOCODIG = ".$code;            
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