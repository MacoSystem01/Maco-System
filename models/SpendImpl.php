<?php
/**
 * Description of Banco
 *
 * @author MACOSystem
 */


if (file_exists("../models/Conexion.php")) {
    include_once("../models/Conexion.php");    
    require_once('../models/Spend.php');
    
} else if (file_exists("../../models/Conexion.php")) {
    include_once("../../models/Conexion.php");    
    require_once('../../models/Spend.php');
}

class SpendImpl
{
	
	public function SpendImpl()
	{
		 
	}
        
        public function getAll()
	{
            $sql = "SELECT gst.GASTORECIB, gst.GASTOCLIEN, gst.GASTOCONCE, gst.GASTOVALOR, gst.GASTOFECHA, gst.GASTOUSUAR 
			FROM gasto gst 
			WHERE GASTOFECHA > SYSDATE - 180
			ORDER BY gst.GASTORECIB DESC";
            
			$conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objSpend = new Spend();
                $objSpend->setCode($row[0]);
                $objSpend->setCodeClient($row[1]);                
                $objSpend->setCodeConcept($row[2]);
                $objSpend->setValue($row[3]);
                $objSpend->setGenerationDate($row[4]);
                $objSpend->setUser($row[5]);                
                $foo[] = $objSpend;
            }
            return $foo;
        }
        
        
//        public function getNameSpend($idSpend) {
//            $sql = "SELECT clnt.CLIENNOMBR FROM cliente clnt WHERE clnt.CLIENCODIG = ".$idSpend;
//            $conex = Conexion::getInstancia();
//            $stid = oci_parse($conex, $sql);
//            oci_execute($stid);
//            $foo;
//
//            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
//              $foo = $row[0];
//            }        
//            return $foo;
//        }
//        

        public function getByCode($idSpend)
	{
            $sql = "SELECT gst.GASTORECIB, gst.GASTOCLIEN, gst.GASTOCONCE, gst.GASTOVALOR, gst.GASTOFECHA, gst.GASTOUSUAR 
			FROM gasto gst 
			WHERE gst.GASTORECIB = ".$idSpend;
            
			$conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objSpend = new Spend();
                $objSpend->setCode($row[0]);
                $objSpend->setCodeClient($row[1]);                
                $objSpend->setCodeConcept($row[2]);
                $objSpend->setValue($row[3]);
                $objSpend->setGenerationDate($row[4]);
                $objSpend->setUser($row[5]);                
                $foo[] = $objSpend;
            }
            return $foo;
        }

        
        public function insert(Spend $objSpend){
            $sql = "INSERT INTO gasto (GASTORECIB, GASTOCLIEN, GASTOCONCE, GASTOVALOR, GASTOFECHA, GASTOUSUAR, GASTOORIGE) 
			VALUES (SEQ_RECAUDO.NextVal, ".$objSpend->getCodeClient().",".$objSpend->getCodeConcept().",".$objSpend->getValue().",
			TO_DATE('".$objSpend->getGenerationDate()."', 'yyyy/mm/dd hh24:mi:ss'),".$objSpend->getUser().",'".$objSpend->getOrigen()."')";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }        

        
        public function update(Spend $objSpend){   
            $sql = "UPDATE gasto gst SET gst.GASTOCLIEN = ".$objSpend->getCodeClient().", gst.GASTOCONCE = ".$objSpend->getCodeConcept().", 
			gst.GASTOVALOR = ".$objSpend->getValue()." WHERE gst.GASTORECIB = ".$objSpend->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 

        
        public function delete($objSpend){
            $sql = "DELETE FROM gasto gst WHERE gst.GASTORECIB = ".$objSpend->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }        

        
        public function getCount() {
            $sql = "SELECT COUNT(*) FROM gasto";
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
            $sql  = "SELECT COUNT(*) FROM gasto gst WHERE gst.GASTORECIB = ".$code;            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getCountSpendBetweenDate($dateA, $dateB, $recibo, $client, $concept)
	{
            if(strcmp($recibo, "") == 0 && strcmp($client, "") == 0 && strcmp($concept, "") == 0 ) 
            {
                $sql = "SELECT COUNT(*) FROM gasto gst "
                . "WHERE gst.GASTOFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "ORDER BY gst.GASTORECIB";
            }
            if(strcmp($recibo, "") != 0 && strcmp($client, "") == 0 && strcmp($concept, "") == 0 ) 
            {
                $sql = "SELECT COUNT(*) FROM gasto gst "
                . "WHERE gst.GASTORECIB = ".$recibo." AND gst.GASTOFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "ORDER BY gst.GASTORECIB";
            }
            else if(strcmp($recibo, "") == 0 && strcmp($client, "") != 0 && strcmp($concept, "") == 0 ) 
            {
                $sql = "SELECT COUNT(*) FROM gasto gst "
                . "WHERE gst.GASTOCLIEN = ".$client." AND gst.GASTOFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "ORDER BY gst.GASTORECIB";
            }
            else if(strcmp($recibo, "") == 0 && strcmp($client, "") == 0 && strcmp($concept, "") != 0 ) 
            {
                $sql = "SELECT COUNT(*) FROM gasto gst "
                . "WHERE gst.GASTOCONCE = ".$concept." AND gst.GASTOFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "ORDER BY gst.GASTORECIB";
            }            
            else if(strcmp($recibo, "") == 0 && strcmp($client, "") != 0 && strcmp($concept, "") != 0 ) 
            {
                $sql = "SELECT COUNT(*) FROM gasto gst "
                . "WHERE gst.GASTOCLIEN = ".$client." AND gst.GASTOCONCE = ".$concept." 
				AND gst.GASTOFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "ORDER BY gst.GASTORECIB";
            }  
            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = 0;
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $foo = $row[0];
            }
            return $foo;
        } 

        
        public function getSpendBetweenDate($dateA, $dateB, $recibo, $client, $concept)
	{
            if(strcmp($recibo, "") == 0 && strcmp($client, "") == 0 && strcmp($concept, "") == 0 ) 
            {
                $sql = "SELECT * FROM gasto gst "
                . "WHERE gst.GASTOFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "ORDER BY gst.GASTORECIB DESC";
            }
            if(strcmp($recibo, "") != 0 && strcmp($client, "") == 0 && strcmp($concept, "") == 0 ) 
            {
                $sql = "SELECT * FROM gasto gst "
                . "WHERE gst.GASTORECIB = ".$recibo." AND gst.GASTOFECHA 
				BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "ORDER BY gst.GASTORECIB DESC";
            }
            else if(strcmp($recibo, "") == 0 && strcmp($client, "") != 0 && strcmp($concept, "") == 0 ) 
            {
                $sql = "SELECT * FROM gasto gst "
                . "WHERE gst.GASTOCLIEN = ".$client." AND gst.GASTOFECHA 
				BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "ORDER BY gst.GASTORECIB DESC";
            }
            else if(strcmp($recibo, "") == 0 && strcmp($client, "") == 0 && strcmp($concept, "") != 0 ) 
            {
                $sql = "SELECT * FROM gasto gst "
                . "WHERE gst.GASTOCONCE = ".$concept." AND gst.GASTOFECHA 
				BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "ORDER BY gst.GASTORECIB DESC";
            }                
            else if(strcmp($recibo, "") == 0 && strcmp($client, "") != 0 && strcmp($concept, "") != 0 ) 
            {
                $sql = "SELECT * FROM gasto gst "
                . "WHERE gst.GASTOCLIEN = ".$client." 
				AND gst.GASTOCONCE = ".$concept." 
				AND gst.GASTOFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "ORDER BY gst.GASTORECIB DESC";
            }
            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objSpend = new Spend();
                $objSpend->setCode($row[0]);
                $objSpend->setCodeClient($row[1]);
                $objSpend->setCodeConcept($row[2]);
                $objSpend->setValue($row[3]);
                $objSpend->setGenerationDate($row[4]);
                $objSpend->setUser($row[5]);
                $foo[] = $objSpend;
            }
            return $foo;
        }

        
        public function getCountConceptFromSpend(Spend $objSpend) {
            $sql = "SELECT COUNT(*) FROM gasto gst WHERE gst.GASTOCONCE = ".$objSpend->getCodeConcept();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getSumSpend($dateA, $dateB) {
            $sql = "SELECT SUM(gst.GASTOVALOR) 
			FROM gasto gst, cliente
			WHERE clientipo <> 3
			AND gastoclien = cliencodig
			AND gst.GASTOFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss')";
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