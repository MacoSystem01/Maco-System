<?php
/**
 * Description of Banco
 *
 * @author MACOSystem
 */

if (file_exists("../models/Conexion.php")) {
    include_once("../models/Conexion.php");    
    require_once('../models/Bill.php');
    
} else if (file_exists("../../models/Conexion.php")) {
    include_once("../../models/Conexion.php");    
    require_once('../../models/Bill.php');
}

class BillImpl
{
	
	public function BillImpl()
	{
		 
	}
        
        public function getAll()
	{
            $sql = "SELECT /*+ RULE */ 
			fctr.FACTUCODIG, fctr.FACTUCLIEN, fctr.FACTUFECGE, fctr.FACTUVALOR, fctr.FACTUPRECO, fctr.FACTUFORPA, 
			fctr.FACTUUSUAR, fctr.FACTUESTAD 
			FROM factura fctr 
			WHERE fctr.FACTUESTAD = 'AC'
			AND FACTUFECGE > SYSDATE - 120
			ORDER BY fctr.FACTUCODIG DESC";
            
			$conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            
			while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objBill = new Bill();
                $objBill->setCode($row[0]);
                $objBill->setClient($row[1]);
                $objBill->setGenerationDate($row[2]);
                $objBill->setValueSale($row[3]);
                $objBill->setValueBuy($row[4]);
                $objBill->setPayment($row[5]);
                $objBill->setUser($row[6]);
                $objBill->setState($row[7]);
                $foo[] = $objBill;
            }
            return $foo;
        }

        
        public function getByCode($idBill)
	{
            $sql = "SELECT fctr.FACTUCODIG, fctr.FACTUCLIEN, fctr.FACTUFECGE, fctr.FACTUVALOR, fctr.FACTUPRECO, fctr.FACTUFORPA, fctr.FACTUUSUAR 
			FROM factura fctr WHERE fctr.FACTUCODIG = ".$idBill;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objBill = new Bill();
                $objBill->setCode($row[0]);
                $objBill->setClient($row[1]);
                $objBill->setGenerationDate($row[2]);
                $objBill->setValueSale($row[3]);
                $objBill->setValueBuy($row[4]);
                $objBill->setPayment($row[5]);
                $objBill->setUser($row[6]);
                $foo[] = $objBill;
            }
            return $foo;
        }

        
        public function getValueBill(Bill $objBill) {
            $sql = "SELECT fctr.FACTUVALOR FROM factura fctr WHERE fctr.FACTUCODIG  = ".$objBill->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getSequence() {
            $sql = "SELECT SEQ_FACTURA.nextval FROM FACTURA";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getId($objBill) {
            //$sql = "SELECT fctr.FACTUCODIG FROM factura fctr WHERE fctr.FACTUCLIEN = ".$objBill->getClient()." AND fctr.FACTUFECGE = '".$objBill->getGenerationDate()."'";
            $sql = "SELECT fctr.FACTUCODIG 
			FROM factura fctr 
			WHERE fctr.FACTUCLIEN = ".$objBill->getClient()." 
			AND fctr.FACTUFECGE = TO_DATE('".$objBill->getGenerationDate()."', 'dd-MM-yy hh24:mi:ss')";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        
        public function getSumPayment($dateA, $dateB, $pym) {
            $sql = "SELECT SUM(fctr.FACTUVALOR) 
			FROM factura fctr 
			WHERE fctr.FACTUFECGE BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
			AND fctr.FACTUFORPA = '".$pym."' 
			AND fctr.FACTUESTAD = 'AC'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getSumPaymentNoVentas($dateA, $dateB, $pym) {
            $sql = "SELECT SUM(fctr.FACTUVALOR) 
			FROM factura fctr, credito cr 
			WHERE fctr.FACTUFECGE BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
			AND fctr.FACTUFORPA = 'CR' 
			AND fctr.FACTUESTAD = 'AC' 
			and fctr.FACTUCODIG = cr.CREDIFACTU 
			and cr.CREDICONCE <> 11";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getSumPaymentOtrosIngresos($dateA, $dateB, $pym) {
            $sql = "SELECT SUM(cr.CREDIVALOR) 
			FROM credito cr, cliente
			WHERE clientipo <> 3
			AND cr.CREDICONCE <> 11
			AND cliencodig = crediclien
			AND cr.CREDIFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
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

		
        public function getSumRecaudo($dateA, $dateB) {
            $sql = "SELECT SUM(recau.RECAUVALOR) 
			FROM recaudo recau, credito, cliente 
			WHERE clientipo in (3, 4)
			AND recau.RECAUFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
			AND recaucredi = credicodig
			AND crediclien = cliencodig";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

		
        public function getPagosProveeNal($dateA, $dateB) {
            $sql = "SELECT SUM(recau.RECAUVALOR) 
			FROM recaudo recau, credito, cliente 
			WHERE clientipo = 3
			AND recau.RECAUFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
			AND recaucredi = credicodig
			AND crediclien = cliencodig";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getPagosProveeImp($dateA, $dateB) {
            $sql = "SELECT SUM(recau.RECAUVALOR) 
			FROM recaudo recau, credito, cliente 
			WHERE clientipo = 4
			AND recau.RECAUFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
			AND recaucredi = credicodig
			AND crediclien = cliencodig";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getComprasProveeNal($dateA, $dateB) {
            $sql = "SELECT SUM(CREDISALDO) 
			FROM credito, cliente 
			WHERE crediclien = cliencodig
			AND crediestad = 'AC'
			AND clientipo = 3
			AND crediconce = 11
			AND CREDIFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
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


        public function getComprasProveeImp($dateA, $dateB) {
            $sql = "SELECT SUM(CREDISALDO) 
			FROM credito, cliente 
			WHERE crediclien = cliencodig
			AND crediestad = 'AC'
			AND clientipo = 4
			AND crediconce = 11
			AND CREDIFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
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


        public function getSumRecaudoSinProveedor($dateA, $dateB) {
            $sql = "SELECT SUM(recau.RECAUVALOR) 
			FROM recaudo recau, credito, cliente 
			WHERE clientipo <> 3
			AND recau.RECAUFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
			AND recaucredi = credicodig
			AND crediclien = cliencodig";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

		
        public function getSumRecaudoNoVentas($dateA, $dateB) {
            $sql = "SELECT SUM(recau.RECAUVALOR) 
			FROM recaudo recau, credito, cliente 
			WHERE recau.RECAUCONCE = 14
			AND clientipo <> 3
			AND recaucredi = credicodig
			AND crediclien = cliencodig
			AND recau.RECAUFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
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
        
        
        public function getSumRecaudoCredActuales($dateA, $dateB) {
            $sql = "SELECT SUM(recau.RECAUVALOR) 
			FROM recaudo recau, credito, cliente 
			WHERE recau.RECAUCONCE = 15
			AND clientipo <> 3
			AND recaucredi = credicodig
			AND crediclien = cliencodig
			AND recau.RECAUFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
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


        public function getSumBills($fi, $ff) {
            $sql = "SELECT SUM(fctr.FACTUVALOR) 
			FROM factura fctr 
			WHERE fctr.FACTUFECGE BETWEEN TO_DATE('".$fi." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
			AND fctr.FACTUESTAD = 'AC'";
            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getSumByClient($client, $fi, $ff, $ref, $payment) {
            if(strcmp($payment, "CONTADO") == 0)
                $pym = 'CO';
            if(strcmp($payment, "CREDITO") == 0)
                $pym = 'CR';
            
            if(strcmp($ref, "") == 0 && strcmp($client, "") != 0 && strcmp($payment, "TODOS") == 0) //solo cliente 
                $sql = "SELECT SUM(fctr.FACTUVALOR) 
				FROM factura fctr 
				WHERE fctr.FACTUFECGE BETWEEN TO_DATE('".$fi." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
				AND fctr.FACTUCLIEN = ".$client." 
				AND fctr.FACTUESTAD = 'AC'";
            else if(strcmp($ref, "") != 0 && strcmp($client, "") != 0 && strcmp($payment, "TODOS") == 0) //solo cliente y ref 
                $sql = "SELECT SUM(fctr.FACTUVALOR) 
				FROM factura fctr, factudetal dtl 
				WHERE fctr.FACTUFECGE BETWEEN TO_DATE('".$fi." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
				AND fctr.FACTUCLIEN = ".$client." 
				AND fctr.FACTUESTAD = 'AC' 
				AND fctr.FACTUCODIG = dtl.FACDECODIG 
				AND UPPER(dtl.FACDEARTIC) = '".$ref."'";
            else if(strcmp($ref, "") == 0 && strcmp($client, "") != 0 && strcmp($payment, "TODOS") != 0) //solo cliente y pago 
                $sql = "SELECT SUM(fctr.FACTUVALOR) 
				FROM factura fctr 
				WHERE fctr.FACTUFECGE BETWEEN TO_DATE('".$fi." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
				AND fctr.FACTUCLIEN = ".$client." 
				AND fctr.FACTUESTAD = 'AC' 
				AND fctr.FACTUFORPA = '".$pym."'";
            else if(strcmp($ref, "") != 0 && strcmp($client, "") != 0 && strcmp($payment, "TODOS") != 0) //todos 
                $sql = "SELECT SUM(fctr.FACTUVALOR) 
				FROM factura fctr, factudetal dtl 
				WHERE fctr.FACTUFECGE BETWEEN TO_DATE('".$fi." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
				AND fctr.FACTUCLIEN = ".$client." 
				AND fctr.FACTUESTAD = 'AC' 
				AND fctr.FACTUFORPA = '".$pym."' 
				AND fctr.FACTUCODIG = dtl.FACDECODIG 
				AND UPPER(dtl.FACDEARTIC) = '".$ref."'";
            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }        

        
        public function getByReport($fi, $ff, $ref, $art, $client, $payment)
	{
            $pym = '';
            $searchByNameArt = 0;
            
            if(strcmp($payment, "CONTADO") == 0)
                $pym = 'CO';
            if(strcmp($payment, "CREDITO") == 0)
                $pym = 'CR';
            
            if(strcmp($ref, "") == 0 && strcmp($client, "") == 0 && strcmp($payment, "TODOS") == 0 && strcmp($art, "") == 0) // no aplican 
                $sql = "SELECT fctr.FACTUFECGE, fctr.FACTUCODIG, fctr.FACTUCLIEN, fctr.FACTUFORPA, fctr.FACTUVALOR 
				FROM factura fctr 
				WHERE fctr.FACTUESTAD = 'AC' 
				AND fctr.FACTUFECGE BETWEEN TO_DATE('".$fi."', 'yyyy/mm/dd') 
				AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
				ORDER BY fctr.FACTUFECGE desc";
            else if(strcmp($ref, "") != 0 && strcmp($client, "") != 0 && strcmp($payment, "TODOS") != 0 && strcmp($art, "") == 0) // aplican todos menos art
                $sql = "SELECT fctr.FACTUFECGE, fctr.FACTUCODIG, fctr.FACTUCLIEN, fctr.FACTUFORPA, fctr.FACTUVALOR 
				FROM factura fctr, factudetal dtl 
				WHERE fctr.FACTUESTAD = 'AC' 
				AND fctr.FACTUFECGE BETWEEN TO_DATE('".$fi."', 'yyyy/mm/dd') 
				AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
				AND fctr.FACTUFORPA = '".$pym."' 
				AND fctr.FACTUCLIEN = ".$client." 
				AND fctr.FACTUCODIG = dtl.FACDECODIG 
				AND dtl.FACDEARTIC = UPPER('".$ref."') 
				ORDER BY fctr.FACTUFECGE desc";        
            else if(strcmp($ref, "") != 0 && strcmp($client, "") == 0 && strcmp($payment, "TODOS") == 0 && strcmp($art, "") == 0) // solo ref
                $sql = "SELECT fctr.FACTUFECGE, fctr.FACTUCODIG, fctr.FACTUCLIEN, fctr.FACTUFORPA, fctr.FACTUVALOR FROM factura fctr, factudetal dtl 
				WHERE fctr.FACTUESTAD = 'AC' 
				AND fctr.FACTUFECGE BETWEEN TO_DATE('".$fi."', 'yyyy/mm/dd') 
				AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
				AND fctr.FACTUCODIG = dtl.FACDECODIG 
				AND dtl.FACDEARTIC = UPPER('".$ref."')  
				ORDER BY fctr.FACTUFECGE desc";    
            else if(strcmp($ref, "") == 0 && strcmp($client, "") == 0 && strcmp($payment, "TODOS") != 0 && strcmp($art, "") == 0) // solo pago
                $sql = "SELECT fctr.FACTUFECGE, fctr.FACTUCODIG, fctr.FACTUCLIEN, fctr.FACTUFORPA, fctr.FACTUVALOR FROM factura fctr 
				WHERE fctr.FACTUESTAD = 'AC' 
				AND fctr.FACTUFECGE BETWEEN TO_DATE('".$fi."', 'yyyy/mm/dd') 
				AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
				AND fctr.FACTUFORPA = '".$pym."' 
				ORDER BY fctr.FACTUFECGE desc";    
            else if(strcmp($ref, "") == 0 && strcmp($client, "") != 0 && strcmp($payment, "TODOS") == 0 && strcmp($art, "") == 0) // solo cliente
                $sql = "SELECT fctr.FACTUFECGE, fctr.FACTUCODIG, fctr.FACTUCLIEN, fctr.FACTUFORPA, fctr.FACTUVALOR FROM factura fctr 
				WHERE fctr.FACTUESTAD = 'AC' 
				AND fctr.FACTUFECGE BETWEEN TO_DATE('".$fi."', 'yyyy/mm/dd') 
				AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
				AND fctr.FACTUCLIEN = '".$client."' 
				ORDER BY fctr.FACTUFECGE desc";    
            else if(strcmp($ref, "") != 0 && strcmp($client, "") != 0 && strcmp($payment, "TODOS") == 0 && strcmp($art, "") == 0) // ref y cliente
                $sql = "SELECT fctr.FACTUFECGE, fctr.FACTUCODIG, fctr.FACTUCLIEN, fctr.FACTUFORPA, fctr.FACTUVALOR FROM factura fctr, factudetal dtl 
				WHERE fctr.FACTUESTAD = 'AC' 
				AND fctr.FACTUFECGE BETWEEN TO_DATE('".$fi."', 'yyyy/mm/dd') 
				AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
				AND fctr.FACTUCLIEN = ".$client." 
				AND fctr.FACTUCODIG = dtl.FACDECODIG 
				AND dtl.FACDEARTIC = UPPER('".$ref."') 
				ORDER BY fctr.FACTUFECGE desc";        
            else if(strcmp($ref, "") != 0 && strcmp($client, "") == 0 && strcmp($payment, "TODOS") != 0 && strcmp($art, "") == 0) // ref y pago
                $sql = "SELECT fctr.FACTUFECGE, fctr.FACTUCODIG, fctr.FACTUCLIEN, fctr.FACTUFORPA, fctr.FACTUVALOR FROM factura fctr, factudetal dtl 
				WHERE fctr.FACTUESTAD = 'AC' 
				AND fctr.FACTUFECGE BETWEEN TO_DATE('".$fi."', 'yyyy/mm/dd') 
				AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
				AND fctr.FACTUFORPA = '".$pym."' 
				AND fctr.FACTUCODIG = dtl.FACDECODIG 
				AND dtl.FACDEARTIC = UPPER('".$ref."') 
				ORDER BY fctr.FACTUFECGE desc";       
            else if(strcmp($ref, "") == 0 && strcmp($client, "") != 0 && strcmp($payment, "TODOS") != 0 && strcmp($art, "") == 0) // cliente y pago
                $sql = "SELECT fctr.FACTUFECGE, fctr.FACTUCODIG, fctr.FACTUCLIEN, fctr.FACTUFORPA, fctr.FACTUVALOR FROM factura fctr 
				WHERE fctr.FACTUESTAD = 'AC' 
				AND fctr.FACTUFECGE BETWEEN TO_DATE('".$fi."', 'yyyy/mm/dd') 
				AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
				AND fctr.FACTUFORPA = '".$pym."' 
				AND fctr.FACTUCLIEN = ".$client." 
				ORDER BY fctr.FACTUFECGE desc";       
            else if(strcmp($ref, "") == 0 && strcmp($client, "") != 0 && strcmp($payment, "TODOS") != 0 && strcmp($art, "") != 0) // articulo, cliente y pago
            {
                $sql = "SELECT distinct(invencodig), invennombr, fctr.FACTUFECGE, fctr.FACTUCODIG, fctr.FACTUCLIEN, fctr.FACTUFORPA, fctr.FACTUVALOR" 
                        ." FROM factura fctr, factudetal dtl, inventario invtr"
                        ." WHERE fctr.FACTUESTAD = 'AC'" 
                        ." AND fctr.FACTUFECGE BETWEEN TO_DATE('".$fi."', 'yyyy/mm/dd') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss')"
                        ." AND fctr.FACTUFORPA = '".$pym."' "
                        ." AND fctr.FACTUCODIG = dtl.FACDECODIG"
                        ." AND dtl.FACDEARTIC = invtr.INVENCODIG"
                        ." AND fctr.FACTUCLIEN = ".$client." 
						AND invtr.INVENNOMBR LIKE UPPER('%".$art."%')"
                        ." ORDER BY fctr.FACTUFECGE desc";
                
                $searchByNameArt = 1;
            }           
            else if(strcmp($ref, "") == 0 && strcmp($client, "") != 0 && strcmp($payment, "TODOS") == 0 && strcmp($art, "") != 0) // articulo, cliente
            {
                $sql = "SELECT distinct(invencodig), invennombr, fctr.FACTUFECGE, fctr.FACTUCODIG, fctr.FACTUCLIEN, fctr.FACTUFORPA, fctr.FACTUVALOR" 
                        ." FROM factura fctr, factudetal dtl, inventario invtr"
                        ." WHERE fctr.FACTUESTAD = 'AC'" 
                        ." AND fctr.FACTUFECGE BETWEEN TO_DATE('".$fi."', 'yyyy/mm/dd') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss')"
                        ." AND fctr.FACTUCODIG = dtl.FACDECODIG"
                        ." AND dtl.FACDEARTIC = invtr.INVENCODIG"
                        ." AND fctr.FACTUCLIEN = ".$client." AND invtr.INVENNOMBR LIKE UPPER('%".$art."%')"
                        ." ORDER BY fctr.FACTUFECGE desc";
                
                $searchByNameArt = 1;
            }
            else if(strcmp($ref, "") == 0 && strcmp($client, "") == 0 && strcmp($payment, "TODOS") != 0 && strcmp($art, "") != 0) // articulo y pago
            {
                $sql = "SELECT distinct(invencodig), invennombr, fctr.FACTUFECGE, fctr.FACTUCODIG, fctr.FACTUCLIEN, fctr.FACTUFORPA, fctr.FACTUVALOR" 
                        ." FROM factura fctr, factudetal dtl, inventario invtr"
                        ." WHERE fctr.FACTUESTAD = 'AC'" 
                        ." AND fctr.FACTUFECGE BETWEEN TO_DATE('".$fi."', 'yyyy/mm/dd') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss')"
                        ." AND fctr.FACTUFORPA = '".$pym."' "
                        ." AND fctr.FACTUCODIG = dtl.FACDECODIG"
                        ." AND dtl.FACDEARTIC = invtr.INVENCODIG"
                        ." AND invtr.INVENNOMBR LIKE UPPER('%".$art."%')"
                        ." ORDER BY fctr.FACTUFECGE desc";
                
                $searchByNameArt = 1;
            }
            else if(strcmp($ref, "") == 0 && strcmp($client, "") == 0 && strcmp($payment, "TODOS") == 0 && strcmp($art, "") != 0) // articulo
            {
                $sql = "SELECT distinct(invencodig), invennombr, fctr.FACTUFECGE, fctr.FACTUCODIG, fctr.FACTUCLIEN, fctr.FACTUFORPA, fctr.FACTUVALOR" 
                        ." FROM factura fctr, factudetal dtl, inventario invtr"
                        ." WHERE fctr.FACTUESTAD = 'AC'" 
                        ." AND fctr.FACTUFECGE BETWEEN TO_DATE('".$fi."', 'yyyy/mm/dd') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss')"
                        ." AND fctr.FACTUCODIG = dtl.FACDECODIG"
                        ." AND dtl.FACDEARTIC = invtr.INVENCODIG"
                        ." AND invtr.INVENNOMBR LIKE UPPER('%".$art."%')"
                        ." ORDER BY fctr.FACTUFECGE desc";
                
                $searchByNameArt = 1;
            }
            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            
            //si es uno es porque necesita hacer una consulta con el nombre de un articulo y esto evita campos perdidos en la consulta
            if($searchByNameArt==1)
            {
                while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                    $objBill = new Bill();

                    $objBill->setGenerationDate($row[2]);
                    $objBill->setCode($row[3]);
                    $objBill->setClient($row[4]);
                    $objBill->setPayment($row[5]);
                    $objBill->setValueSale($row[6]);
                    $foo[] = $objBill;
                }                
            }
            else
            {
                while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                    $objBill = new Bill();

                    $objBill->setGenerationDate($row[0]);
                    $objBill->setCode($row[1]);
                    $objBill->setClient($row[2]);
                    $objBill->setPayment($row[3]);
                    $objBill->setValueSale($row[4]);
                    $foo[] = $objBill;
                }
            }
            
            return $foo;
        }

        
        public function getCountByReport($fi, $ff, $ref, $art, $client, $payment)
	{
            $pym = '';
            
            if(strcmp($payment, "CONTADO") == 0)
                $pym = 'CO';
            if(strcmp($payment, "CREDITO") == 0)
                $pym = 'CR';
            
            if(strcmp($ref, "") == 0 && strcmp($client, "") == 0 && strcmp($payment, "TODOS") == 0 && strcmp($art, "") == 0)//no aplican 
                $sql = "SELECT COUNT(*) 
				FROM factura fctr 
				WHERE fctr.FACTUESTAD = 'AC' 
				AND fctr.FACTUFECGE BETWEEN TO_DATE('".$fi."', 'yyyy/mm/dd') 
				AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
				ORDER BY fctr.FACTUCODIG";
            else if(strcmp($ref, "") != 0 && strcmp($client, "") != 0 && strcmp($payment, "TODOS") != 0 && strcmp($art, "") == 0)//aplican todos
                $sql = "SELECT COUNT(*) 
				FROM factura fctr, factudetal dtl 
				WHERE fctr.FACTUESTAD = 'AC' 
				AND fctr.FACTUFECGE BETWEEN TO_DATE('".$fi." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
				AND fctr.FACTUFORPA = '".$pym."' 
				AND fctr.FACTUCLIEN = ".$client." 
				AND fctr.FACTUCODIG = dtl.FACDECODIG 
				AND dtl.FACDEARTIC = UPPER('".$ref."') 
				ORDER BY fctr.FACTUCODIG";        
            else if(strcmp($ref, "") != 0 && strcmp($client, "") == 0 && strcmp($payment, "TODOS") == 0 && strcmp($art, "") == 0)//solo ref
                $sql = "SELECT COUNT(*) 
				FROM factura fctr, factudetal dtl 
				WHERE fctr.FACTUESTAD = 'AC' 
				AND fctr.FACTUFECGE BETWEEN TO_DATE('".$fi." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
				AND fctr.FACTUCODIG = dtl.FACDECODIG 
				AND dtl.FACDEARTIC = UPPER('".$ref."')  
				ORDER BY fctr.FACTUCODIG";    
            else if(strcmp($ref, "") == 0 && strcmp($client, "") == 0 && strcmp($payment, "TODOS") != 0 && strcmp($art, "") == 0)//solo pago
                $sql = "SELECT COUNT(*) FROM 
				factura fctr 
				WHERE fctr.FACTUESTAD = 'AC' 
				AND fctr.FACTUFECGE BETWEEN TO_DATE('".$fi." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
				AND fctr.FACTUFORPA = '".$pym."' 
				ORDER BY fctr.FACTUCODIG";    
            else if(strcmp($ref, "") == 0 && strcmp($client, "") != 0 && strcmp($payment, "TODOS") == 0 && strcmp($art, "") == 0)//solo cliente
                $sql = "SELECT COUNT(*) FROM factura fctr WHERE fctr.FACTUESTAD = 'AC' AND fctr.FACTUFECGE BETWEEN TO_DATE('".$fi." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') AND fctr.FACTUCLIEN = '".$client."' ORDER BY fctr.FACTUCODIG";    
            else if(strcmp($ref, "") != 0 && strcmp($client, "") != 0 && strcmp($payment, "TODOS") == 0 && strcmp($art, "") == 0)//ref y cliente
                $sql = "SELECT COUNT(*) FROM factura fctr, factudetal dtl WHERE fctr.FACTUESTAD = 'AC' AND fctr.FACTUFECGE BETWEEN TO_DATE('".$fi." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') AND fctr.FACTUCLIEN = ".$client." AND fctr.FACTUCODIG = dtl.FACDECODIG AND dtl.FACDEARTIC = UPPER('".$ref."') ORDER BY fctr.FACTUCODIG";        
            else if(strcmp($ref, "") != 0 && strcmp($client, "") == 0 && strcmp($payment, "TODOS") != 0 && strcmp($art, "") == 0)//ref y pago
                $sql = "SELECT COUNT(*) FROM factura fctr, factudetal dtl WHERE fctr.FACTUESTAD = 'AC' AND fctr.FACTUFECGE BETWEEN TO_DATE('".$fi." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') AND fctr.FACTUFORPA = '".$pym."' AND fctr.FACTUCODIG = dtl.FACDECODIG AND dtl.FACDEARTIC = UPPER('".$ref."') ORDER BY fctr.FACTUCODIG";       
            else if(strcmp($ref, "") == 0 && strcmp($client, "") != 0 && strcmp($payment, "TODOS") != 0 && strcmp($art, "") == 0)//cliente y pago
                $sql = "SELECT COUNT(*) FROM factura fctr WHERE fctr.FACTUESTAD = 'AC' AND fctr.FACTUFECGE BETWEEN TO_DATE('".$fi." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') AND fctr.FACTUFORPA = '".$pym."' AND fctr.FACTUCLIEN = ".$client." ORDER BY fctr.FACTUCODIG";       
            else if(strcmp($ref, "") == 0 && strcmp($client, "") != 0 && strcmp($payment, "TODOS") != 0 && strcmp($art, "") != 0)//articulo, cliente y pago
                $sql = "SELECT  COUNT(distinct(invencodig))" 
                        ." FROM factura fctr, factudetal dtl, inventario invtr"
                        ." WHERE fctr.FACTUESTAD = 'AC'" 
                        ." AND fctr.FACTUFECGE BETWEEN TO_DATE('".$fi." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss')"
                        ." AND fctr.FACTUFORPA = '".$pym."' "
                        ." AND fctr.FACTUCODIG = dtl.FACDECODIG"
                        ." AND dtl.FACDEARTIC = invtr.INVENCODIG"
                        ." AND fctr.FACTUCLIEN = ".$client." AND invtr.INVENNOMBR LIKE UPPER('%".$art."%')"
                        ." ORDER BY fctr.FACTUCODIG";
            else if(strcmp($ref, "") == 0 && strcmp($client, "") != 0 && strcmp($payment, "TODOS") == 0 && strcmp($art, "") != 0)//articulo, cliente
                $sql = "SELECT  COUNT(distinct(invencodig))" 
                        ." FROM factura fctr, factudetal dtl, inventario invtr"
                        ." WHERE fctr.FACTUESTAD = 'AC'" 
                        ." AND fctr.FACTUFECGE BETWEEN TO_DATE('".$fi." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss')"
                        ." AND fctr.FACTUCODIG = dtl.FACDECODIG"
                        ." AND dtl.FACDEARTIC = invtr.INVENCODIG"
                        ." AND fctr.FACTUCLIEN = ".$client." AND invtr.INVENNOMBR LIKE UPPER('%".$art."%')"
                        ." ORDER BY fctr.FACTUCODIG";
            else if(strcmp($ref, "") == 0 && strcmp($client, "") == 0 && strcmp($payment, "TODOS") != 0 && strcmp($art, "") != 0)//articulo y pago
                $sql = "SELECT  COUNT(distinct(invencodig))" 
                        ." FROM factura fctr, factudetal dtl, inventario invtr"
                        ." WHERE fctr.FACTUESTAD = 'AC'" 
                        ." AND fctr.FACTUFECGE BETWEEN TO_DATE('".$fi." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss')"
                        ." AND fctr.FACTUFORPA = '".$pym."' "
                        ." AND fctr.FACTUCODIG = dtl.FACDECODIG"
                        ." AND dtl.FACDEARTIC = invtr.INVENCODIG"
                        ." AND invtr.INVENNOMBR LIKE UPPER('%".$art."%')"
                        ." ORDER BY fctr.FACTUCODIG";
            else if(strcmp($ref, "") == 0 && strcmp($client, "") == 0 && strcmp($payment, "TODOS") == 0 && strcmp($art, "") != 0)//articulo
                $sql = "SELECT  COUNT(distinct(invencodig))" 
                        ." FROM factura fctr, factudetal dtl, inventario invtr"
                        ." WHERE fctr.FACTUESTAD = 'AC'" 
                        ." AND fctr.FACTUFECGE BETWEEN TO_DATE('".$fi." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss')"
                        ." AND fctr.FACTUCODIG = dtl.FACDECODIG"
                        ." AND dtl.FACDEARTIC = invtr.INVENCODIG"
                        ." AND invtr.INVENNOMBR LIKE UPPER('%".$art."%')"
                        ." ORDER BY fctr.FACTUCODIG";
            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = 0;
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $foo = $row[0];
            }
            return $foo;
        }

        
        public function insert($objBill){
            $sql = "INSERT INTO factura (FACTUCODIG, FACTUCLIEN, FACTUFECGE, FACTUVALOR, FACTUPRECO, FACTUFORPA, FACTUUSUAR, FACTUESTAD) 
			VALUES (SEQ_FACTURA.NextVal,".$objBill->getClient().",TO_DATE('".$objBill->getGenerationDate()."', 'yyyy/mm/dd hh24:mi:ss'),
			".$objBill->getValueSale().",".$objBill->getValueBuy().",'".$objBill->getPayment()."',".$objBill->getUser().",'".$objBill->getState()."')";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }        

        
        public function update($objBill, $id){   
            $sql = "UPDATE factura fctr 
			SET fctr.FACTUCLIEN = ".$objClient->getCode().", fctr.FACTUFECGE = '".$objClient->getGenerationDate()."', 
			fctr.FACTUVALOR = ".$objClient->getValueSale().", fctr.FACTUPRECO = ".$objClient->getValueBuy().", 
			fctr.FACTUFORPA = '".$objClient->getPayment()."', fctr.FACTUUSUAR = ".$objClient->getUser()." 
			WHERE fctr.FACTUCLIEN = ".$id;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }

        
        public function updateTotal($objBill){   
            $sql = "UPDATE factura fctr SET fctr.FACTUVALOR = ".$objBill->getValueSale()." WHERE fctr.FACTUCODIG = ".$objBill->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 

        
        public function updateClientPayment($objBill){   
            $sql = "UPDATE factura fctr 
			SET fctr.FACTUCLIEN = ".$objBill->getClient().", fctr.FACTUFORPA = '".$objBill->getPayment()."' 
			WHERE fctr.FACTUCODIG = ".$objBill->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 

        
        public function updateState($objBill){   
            $sql = "UPDATE factura fctr SET fctr.FACTUESTAD = '".$objBill->getState()."' WHERE fctr.FACTUCODIG = ".$objBill->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 

        
        public function delete($objBill){
            $sql = "DELETE FROM factura fctr WHERE fctr.FACTUCODIG = ".$objBill->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }

}