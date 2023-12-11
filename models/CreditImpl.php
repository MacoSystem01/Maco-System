<?php
/**
 * Description of Banco
 *
 * @author MACOSystem
 */

if (file_exists("../models/Conexion.php")) {
    include_once("../models/Conexion.php");    
    require_once('../models/Credit.php');
    
} else if (file_exists("../../models/Conexion.php")) {
    include_once("../../models/Conexion.php");    
    require_once('../../models/Credit.php');
}

class CreditImpl
{
	
	public function CreditImpl()
	{
		 
	}
        
        public function getAll()
	{
            $sql = "SELECT cr.CREDICODIG, cr.CREDICLIEN, cr.CREDIFACTU, cr.CREDIFECHA, cr.CREDICONCE, cr.CREDIVALOR, 
			cr.CREDISALDO, cr.CREDIESTAD, cr.CREDIFECCA, cr.CREDIUSUAR FROM credito cr ORDER BY cr.CREDICODIG ASC";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objCredit = new Credit();
                $objCredit->setCode($row[0]);
                $objCredit->setCodeClient($row[1]);                
                $objCredit->setCodeBill($row[2]);                
                $objCredit->setRegistrationDate($row[3]);                
                $objCredit->setCodeConcept($row[4]);                
                $objCredit->setValue($row[5]);                
                $objCredit->setSaldo($row[6]);                
                $objCredit->setState($row[7]);                
                $objCredit->setCancelDate($row[8]);                
                $objCredit->setUser($row[9]);                
                $foo[] = $objCredit;
            }
            return $foo;
        }
        
        public function getByCode($idCredit)
	{
            $sql = "SELECT cr.CREDICODIG, cr.CREDICLIEN, cr.CREDIFACTU, cr.CREDIFECHA, cr.CREDICONCE, cr.CREDIVALOR, cr.CREDISALDO, cr.CREDIESTAD, 
			cr.CREDIFECCA, cr.CREDIUSUAR FROM credito cr WHERE cr.CREDICODIG = ".$idCredit;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objCredit = new Credit();
                $objCredit->setCode($row[0]);
                $objCredit->setCodeClient($row[1]);                
                $objCredit->setCodeBill($row[2]);                
                $objCredit->setRegistrationDate($row[3]);                
                $objCredit->setCodeConcept($row[4]);                
                $objCredit->setValue($row[5]);                
                $objCredit->setSaldo($row[6]);                
                $objCredit->setState($row[7]);                
                $objCredit->setCancelDate($row[8]);                
                $objCredit->setUser($row[9]);                
                $foo[] = $objCredit;
            }
            return $foo;
        }
        
        public function getByStateAC()
	{
            $sql = "SELECT cr.CREDICODIG, cr.CREDICLIEN, cr.CREDIFACTU, cr.CREDIFECHA, cr.CREDICONCE, cr.CREDIVALOR, cr.CREDISALDO, cr.CREDIESTAD, 
			cr.CREDIFECCA, cr.CREDIUSUAR 
			FROM credito cr 
			WHERE ROWNUM <= 5 
			AND cr.CREDIESTAD = 'AC' 
			ORDER BY cr.CREDICODIG DESC";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objCredit = new Credit();
                $objCredit->setCode($row[0]);
                $objCredit->setCodeClient($row[1]);                
                $objCredit->setCodeBill($row[2]);                
                $objCredit->setRegistrationDate($row[3]);                
                $objCredit->setCodeConcept($row[4]);                
                $objCredit->setValue($row[5]);                
                $objCredit->setSaldo($row[6]);                
                $objCredit->setState($row[7]);                
                $objCredit->setCancelDate($row[8]);                
                $objCredit->setUser($row[9]);                
                $foo[] = $objCredit;
            }
            return $foo;
        }
        
        public function getByStateANoVentas()
	{
            $sql = "SELECT cr.CREDICODIG, cr.CREDICLIEN, cr.CREDIFACTU, cr.CREDIFECHA, cr.CREDICONCE, cr.CREDIVALOR, cr.CREDISALDO, cr.CREDIESTAD,
			cr.CREDIFECCA, cr.CREDIUSUAR 
			FROM credito cr 
			WHERE ROWNUM <= 5 
			AND cr.CREDIESTAD = 'AC' 
			AND cr.CREDICONCE = 11 
			ORDER BY cr.CREDICODIG DESC";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objCredit = new Credit();
                $objCredit->setCode($row[0]);
                $objCredit->setCodeClient($row[1]);                
                $objCredit->setCodeBill($row[2]);                
                $objCredit->setRegistrationDate($row[3]);                
                $objCredit->setCodeConcept($row[4]);                
                $objCredit->setValue($row[5]);                
                $objCredit->setSaldo($row[6]);                
                $objCredit->setState($row[7]);                
                $objCredit->setCancelDate($row[8]);                
                $objCredit->setUser($row[9]);                
                $foo[] = $objCredit;
            }
            return $foo;
        }
        
        public function getId($codeBill)
	{
            $sql = "SELECT cr.CREDICODIG FROM credito cr WHERE cr.CREDIFACTU = ".$codeBill;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function getIdByClient($codeClient)
	{
            $sql = "SELECT cr.CREDICODIG FROM credito cr WHERE cr.CREDICLIEN = ".$codeClient;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
           
        public function getClient($codeCredit)
	{
            $sql = "SELECT cr.CREDICLIEN FROM credito cr WHERE cr.CREDICODIG = ".$codeCredit;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function getValue($codeCredit)
	{
            $sql = "SELECT cr.CREDIVALOR FROM credito cr WHERE cr.CREDICODIG = ".$codeCredit;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function getSaldo($codeCredit)
	{
            $sql = "SELECT cr.CREDISALDO FROM credito cr WHERE cr.CREDICODIG = ".$codeCredit;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function getBill($codeCredit)
	{
            $sql = "SELECT cr.CREDIFACTU FROM credito cr WHERE cr.CREDICODIG = ".$codeCredit;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function insert(Credit $objCredit){
            $sql = "INSERT INTO credito (CREDICODIG, CREDICLIEN, CREDIFACTU, CREDIFECHA, CREDICONCE, 
			CREDIVALOR, CREDISALDO, CREDIESTAD, CREDIFECCA, CREDIUSUAR) 
			VALUES (SEQ_CREDITO.NextVal, ".$objCredit->getCodeClient().",".$objCredit->getCodeBill().",
			TO_DATE('".$objCredit->getRegistrationDate()."', 'yyyy/mm/dd hh24:mi:ss'),
			".$objCredit->getCodeConcept().",".$objCredit->getValue().",".$objCredit->getSaldo().",'".$objCredit->getState()."',
			TO_DATE('".$objCredit->getCancelDate()."', 'yyyy/mm/dd hh24:mi:ss'),".$objCredit->getUser().")";                                                
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }        
        
        public function insert2(Credit $objCredit){
            $sql = "INSERT INTO credito (CREDICODIG, CREDICLIEN, CREDIFACTU, CREDIFECHA, CREDICONCE, CREDIVALOR) 
			VALUES (SEQ_CREDITO.NextVal, ".$objCredit->getCodeClient().", ".$objCredit->getCodeBill().", 
			TO_DATE('".$objCredit->getRegistrationDate()."', 'yyyy/mm/dd hh24:mi:ss'), ".$objCredit->getCodeConcept().", ".$objCredit->getValue().")";                                                
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 
        
        public function update($objCredit, $id){   
            $sql = "UPDATE credito cr SET cr.CREDICODIG = ".$objCredit->getCode().", cr.CONCENOMBR = '".$objCredit->getName()."' 
			WHERE cr.CREDICODIG = ".$id;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }
        
        public function updateState(Credit $objCredit){   
            $sql = "UPDATE credito cr SET cr.CREDIESTAD = '".$objCredit->getState()."' WHERE cr.CREDIFACTU = ".$objCredit->getCodeBill();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 
        
        public function updateStateByID(Credit $objCredit){   
            $sql = "UPDATE credito cr SET cr.CREDIESTAD = '".$objCredit->getState()."' WHERE cr.CREDICODIG = ".$objCredit->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 
        
        public function updateValue(Credit $objCredit){   
            $sql = "UPDATE credito cr SET cr.CREDIVALOR = ".$objCredit->getValue()." WHERE cr.CREDIFACTU = ".$objCredit->getCodeBill();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 
        
        public function updateSaldo(Credit $objCredit){   
            $sql = "UPDATE credito cr SET cr.CREDISALDO = '".$objCredit->getSaldo()."' WHERE cr.CREDICODIG = ".$objCredit->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 
        
        public function delete($objCredit){
            $sql = "DELETE FROM credito cr WHERE cr.CREDICODIG = ".$objCredit->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }        
        
        public function getCount() {
            $sql = "SELECT  COUNT(*) FROM credito";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function checkCodeBillInCredit($codeBill) {            
            $sql  = "SELECT COUNT(*) FROM credito cr WHERE cr.CREDIFACTU = ".$codeBill;            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function getCountCreditBetweenDate($dateA, $dateB, $client, $credit, $bill)
	{
//            if(strcmp($client, "") == 0 && strcmp($credit, "") == 0 && strcmp($bill, "") == 0 ) 
//            {
//                $sql = "SELECT COUNT(*) FROM credito cr "
//                . "WHERE cr.CREDIFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
//					AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
//                . "ORDER BY cr.CREDICODIG";
//            }
            if(strcmp($client, "") != 0 && strcmp($credit, "") == 0 && strcmp($bill, "") == 0 ) 
            {
                $sql = "SELECT COUNT(*) FROM credito cr "
                . "WHERE cr.CREDICLIEN = ".$client." 
				AND cr.CREDIFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ";
                //. "ORDER BY cr.CREDICODIG";
            }
            else if(strcmp($client, "") == 0 && strcmp($credit, "") != 0 && strcmp($bill, "") == 0 ) 
            {
                $sql = "SELECT COUNT(*) FROM credito cr "
                . "WHERE cr.CREDICODIG = ".$credit." 
				AND cr.CREDIFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ";                
            }
            else if(strcmp($client, "") == 0 && strcmp($credit, "") == 0 && strcmp($bill, "") != 0 ) 
            {
                $sql = "SELECT COUNT(*) FROM credito cr "
                . "WHERE cr.CREDIFACTU = ".$bill." 
				AND cr.CREDIFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ";
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
        
        public function getCreditBetweenDate($dateA, $dateB, $client, $credit, $bill)
	{
            if(strcmp($client, "") == 0 && strcmp($credit, "") == 0 && strcmp($bill, "") == 0 ) 
            {
                $sql = "SELECT * FROM credito cr "
                . "WHERE cr.CREDIFECHA 
				BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "ORDER BY cr.CREDICODIG";
            }   
            if(strcmp($client, "") != 0 && strcmp($credit, "") == 0 && strcmp($bill, "") == 0 ) 
            {
                $sql = "SELECT * FROM credito cr "
                . "WHERE cr.CREDICLIEN = ".$client." 
				AND cr.CREDIFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "ORDER BY cr.CREDICODIG";
            }
            else if(strcmp($client, "") == 0 && strcmp($credit, "") != 0 && strcmp($bill, "") == 0 ) 
            {
                $sql = "SELECT * FROM credito cr "
                . "WHERE cr.CREDICODIG = ".$credit." 
				AND cr.CREDIFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "ORDER BY cr.CREDICODIG";
            }
            else if(strcmp($client, "") == 0 && strcmp($credit, "") == 0 && strcmp($bill, "") != 0 ) 
            {
                $sql = "SELECT * FROM credito cr "
                . "WHERE cr.CREDIFACTU = ".$bill." 
				AND cr.CREDIFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "ORDER BY cr.CREDICODIG";
            }               
            
            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objCredit = new Credit();
                $objCredit->setCode($row[0]);
                $objCredit->setCodeClient($row[1]);
                $objCredit->setCodeBill($row[2]);
                $objCredit->setRegistrationDate($row[3]);
                $objCredit->setCodeConcept($row[4]);
                $objCredit->setValue($row[5]);
                $objCredit->setSaldo($row[6]);
                $objCredit->setState($row[7]);
                $objCredit->setCancelDate($row[8]);
                $objCredit->setUser($row[9]);
                $foo[] = $objCredit;
            }
            return $foo;
        }

        public function getCountConceptFromCredit(Credit $objCredit) {
            $sql = "SELECT COUNT(*) FROM credito cr WHERE cr.CREDICONCE = ".$objCredit->getCodeConcept();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        public function getSumCreditByID($credit)
	{            
            //verificar si este metodo funciona
            $sql = "SELECT SUM(cr.RECAUVALOR) FROM credito cr "
            . "WHERE cr.RECAUCREDI = ".$credit." AND cr.RECAUFECHA <= '".$dateA."'";

            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;


            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $foo = $row[0];
            }     
            
            return $foo;      
        }
        
        public function getSumCreditByClient($dateA, $dateB, $client)
	{            
            $sql = "SELECT SUM(cr.CREDIVALOR) FROM credito cr "
            . "WHERE cr.CREDICLIEN = ".$client." 
			AND cr.CREDIFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ";

            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;


            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $foo = $row[0];
            }     
            
            return $foo;      
        }
        
        public function getSumSaldoByClient($dateA, $dateB, $client)
	{            
            $sql = "SELECT SUM(cr.CREDISALDO) FROM credito cr "
            . "WHERE cr.CREDICLIEN = ".$client." 
			AND cr.CREDIFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ";

            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;


            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $foo = $row[0];
            }     
            
            return $foo;      
        }
        
        public function getDaysMora($credit)
	{            
            $sql = "SELECT (sysdate - CREDIFECHA) FROM credito cr, dual "
            . "WHERE cr.CREDICODIG = ".$credit;

            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $foo = $row[0];
            }     
            
            return $foo;      
        }
        
        
        public function getCountCreditOnlyBetweenDate($dateA, $dateB)
	{
            $sql = "SELECT COUNT(*) FROM credito cr "
            . "WHERE cr.CREDIFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
            . "AND cr.CREDIESTAD = 'AC' ORDER BY cr.CREDICODIG";
            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = 0;
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $foo = $row[0];
            }
            return $foo;
        } 

        public function getCountCreditOnlyBetweenDate_PROVE($dateA, $dateB)
	{
            $sql = "SELECT COUNT(*) FROM credito cr, cliente "
            . "WHERE cr.CREDIESTAD = 'AC'
			AND CLIENTIPO IN (3,4)
			AND crediclien = cliencodig
			AND cr.CREDIFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ";
                        
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = 0;
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $foo = $row[0];
            }
            return $foo;
        } 
        
        public function getCreditOnlyBetweenDate($dateA, $dateB)
	{
            $sql = "SELECT * 
			FROM credito cr, cliente "
            . "WHERE cr.CREDIFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
            . "AND cr.CREDIESTAD = 'AC'
			AND clientipo <> 3
			AND clientipo <> 4
			AND credisaldo > 0
			AND crediclien = cliencodig 
			ORDER BY cr.CREDICODIG DESC";
                        
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objCredit = new Credit();
                $objCredit->setCode($row[0]);
                $objCredit->setCodeClient($row[1]);
                $objCredit->setCodeBill($row[2]);
                $objCredit->setRegistrationDate($row[3]);
                $objCredit->setCodeConcept($row[4]);
                $objCredit->setValue($row[5]);
                $objCredit->setSaldo($row[6]);
                $objCredit->setState($row[7]);
                $objCredit->setCancelDate($row[8]);
                $objCredit->setUser($row[9]);
                $foo[] = $objCredit;
            }
            return $foo;
        }

        public function getCreditOnlyBetweenDate_PROVE($dateA, $dateB)
	{
            $sql = "SELECT * 
			FROM credito cr, cliente "
            . "WHERE cr.CREDIFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
            . "AND cr.CREDIESTAD = 'AC'
			AND clientipo in (3,4)	
			AND crediclien = cliencodig 
			ORDER BY cr.CREDICODIG DESC";
                        
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objCredit = new Credit();
                $objCredit->setCode($row[0]);
                $objCredit->setCodeClient($row[1]);
                $objCredit->setCodeBill($row[2]);
                $objCredit->setRegistrationDate($row[3]);
                $objCredit->setCodeConcept($row[4]);
                $objCredit->setValue($row[5]);
                $objCredit->setSaldo($row[6]);
                $objCredit->setState($row[7]);
                $objCredit->setCancelDate($row[8]);
                $objCredit->setUser($row[9]);
                $foo[] = $objCredit;
            }
            return $foo;
        }
}