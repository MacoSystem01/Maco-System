<?php
/**
 * Description of Banco
 *
 * @author MACOSystem
 */


if (file_exists("../models/Conexion.php")) {
    include_once("../models/Conexion.php");    
    require_once('../models/Detail.php');
    
} else if (file_exists("../../models/Conexion.php")) {
    include_once("../../models/Conexion.php");    
    require_once('../../models/Detail.php');
}

class DetailImpl
{
	
	public function DetailImpl()
	{
		 
	}
        
        public function getAll()
	{
            $sql = "SELECT dtl.FACDECODIG, dtl.FACDEARTIC, dtl.FACDECANTI, dtl.FACDEVALUN, dtl.FACDEVALTO, dtl.FACDEFECMO 
			FROM factudetal dtl ORDER BY dtl.FACDECODIG DESC";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objDetail = new Detail();
                $objDetail->setCodeBill($row[0]);
                $objDetail->setCodeArticle($row[1]);
                $objDetail->setQuantity($row[2]);
                $objDetail->setValueUnit($row[3]);
                $objDetail->setTotal($row[4]);
                $objDetail->setMoveDate($row[5]);
                $foo[] = $objDetail;
            }
            return $foo;
        }
        
        public function getByCode($idBill)
	{
            $sql = "SELECT dtl.FACDECODIG, dtl.FACDEARTIC, dtl.FACDECANTI, dtl.FACDEVALUN, dtl.FACDEVALTO, dtl.FACDEFECMO 
			FROM factudetal dtl WHERE dtl.FACDECODIG = ".$idBill;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objDetail = new Detail();
                $objDetail->setCodeBill($row[0]);
                $objDetail->setCodeArticle($row[1]);
                $objDetail->setQuantity($row[2]);
                $objDetail->setValueUnit($row[3]);
                $objDetail->setTotal($row[4]);
                $objDetail->setMoveDate($row[5]);
                $foo[] = $objDetail;
            }
            return $foo;
        }
        
        public function getByBillArticleDate($idBill, $idArticle, $dateMove)
	{
            $sql = "SELECT dtl.FACDECODIG, dtl.FACDEARTIC, dtl.FACDECANTI, dtl.FACDEVALUN, dtl.FACDEVALTO, dtl.FACDEFECMO 
			FROM factudetal dtl WHERE dtl.FACDECODIG = ".$idBill." 
			AND dtl.FACDEARTIC = '".$idArticle."' 
			AND dtl.FACDEFECMO = '".$dateMove."'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objDetail = new Detail();
                $objDetail->setCodeBill($row[0]);
                $objDetail->setCodeArticle($row[1]);
                $objDetail->setQuantity($row[2]);
                $objDetail->setValueUnit($row[3]);
                $objDetail->setTotal($row[4]);
                $objDetail->setMoveDate($row[5]);
                $foo[] = $objDetail;
            }
            return $foo;
        }
                
        public function insert(Detail $objDetail){
            $sql = "INSERT INTO factudetal (FACDECODIG, FACDEARTIC, FACDECANTI, FACDEVALUN, FACDEVALTO, FACDEMOVIM, FACDEFECMO, FACDEORIGE) 
			VALUES (".$objDetail->getCodeBill().",'".$objDetail->getCodeArticle()."',".$objDetail->getQuantity().",".$objDetail->getValueUnit().",
			".$objDetail->getTotal().",'".$objDetail->getMove()."', 
			TO_DATE('".$objDetail->getMoveDate()."', 'yyyy/mm/dd hh24:mi:ss'),'".$objDetail->getOrigen()."')";
            //$sql = "INSERT INTO factudetal (FACDECODIG, FACDEARTIC, FACDECANTI, FACDEVALUN, FACDEVALTO, FACDEMOVIM) VALUES (".$objDetail->getCodeBill().",'".$objDetail->getCodeArticle()."',".$objDetail->getQuantity().",".$objDetail->getValueUnit().",".$objDetail->getTotal().",'".$objDetail->getMove()."')";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }        
        
        public function updateQuantityAndTotal($objDetail){   
            $sql = "UPDATE factudetal dtl 
			SET dtl.FACDECANTI = ".$objDetail->getQuantity().", dtl.FACDEVALTO = ".$objDetail->getTotal()." 
			WHERE dtl.FACDECODIG = ".$objDetail->getCodeBill()." 
			AND dtl.FACDEARTIC = '".$objDetail->getCodeArticle()."' 
			AND dtl.FACDEFECMO = '".$objDetail->getMoveDate()."'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 
        
        public function delete($objDetail){
            $sql = "DELETE FROM factudetal dtl 
			WHERE dtl.FACDECODIG = ".$objDetail->getCodeBill()." AND dtl.FACDEARTIC = '".$objDetail->getCodeArticle()."'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }           
        
        public function getTotalDetailBill($objDetail) {
            $sql = "SELECT SUM(dtl.FACDEVALTO) FROM FACTUDETAL dtl WHERE dtl.FACDECODIG = ".$objDetail->getCodeBill();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function getSumNacionalContado($dateA, $dateB) {
            $sql = "SELECT SUM(dtl.FACDEVALTO) 
			FROM factudetal dtl, factura fctr 
			WHERE dtl.FACDEORIGE = 'N' 
			AND dtl.FACDEFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
			AND dtl.FACDECODIG = fctr.FACTUCODIG 
			AND fctr.FACTUFORPA = 'CO'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        public function getSumNacionalCredito($dateA, $dateB) {
            $sql = "SELECT SUM(dtl.FACDEVALTO) 
			FROM factudetal dtl, factura fctr 
			WHERE dtl.FACDEORIGE = 'N' 
			AND dtl.FACDEFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
			AND dtl.FACDECODIG = fctr.FACTUCODIG 
			AND fctr.FACTUFORPA = 'CR'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        

        public function getSumGastosNacional($dateA, $dateB) {
            $sql = "SELECT SUM(GASTOVALOR)
					FROM gasto
					WHERE GASTOORIGE = 'N'
					AND GASTOFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss')
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

        public function getSumGastosImportado($dateA, $dateB) {
            $sql = "SELECT SUM(GASTOVALOR)
					FROM gasto
					WHERE GASTOORIGE = 'I'
					AND GASTOFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss')
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

        
/*       public function getSumGastosOtros($dateA, $dateB) {
            $sql = "SELECT SUM(GASTOVALOR)
					FROM gasto, cliente
					WHERE GASTOCONCE not in (16,17)
					AND clientipo <> 3
					AND gastoclien = cliencodig
					AND GASTOFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss')
					AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss')";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        } */


        public function getSumImportadoContado($dateA, $dateB) {
            $sql = "SELECT SUM(dtl.FACDEVALTO) 
			FROM factudetal dtl, factura fctr 
			WHERE dtl.FACDEORIGE = 'I' 
			AND dtl.FACDEFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
			AND dtl.FACDECODIG = fctr.FACTUCODIG 
			AND fctr.FACTUFORPA = 'CO'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        public function getSumImportadoCredito($dateA, $dateB) {
            $sql = "SELECT SUM(dtl.FACDEVALTO) 
			FROM factudetal dtl, factura fctr 
			WHERE dtl.FACDEORIGE = 'I' 
			AND dtl.FACDEFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
			AND dtl.FACDECODIG = fctr.FACTUCODIG 
			AND fctr.FACTUFORPA = 'CR'";            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        

        public function getSumBancos($dateA, $dateB) {
            $sql = "select sum(bancovalor) from banco 
			WHERE BANCOFECHA BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
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


        public function getOrigen($factura, $articulo) {
            $sql = "SELECT dtl.FACDEORIGE FROM FACTUDETAL dtl WHERE dtl.FACDECODIG = ".$factura." and FACDEARTIC= '".$articulo."'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function getCountArticleFromDetail($objDetail) {
            $sql = "SELECT COUNT(*) FROM FACTUDETAL dtl WHERE dtl.FACDEARTIC = '".$objDetail->getCodeArticle()."'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function checkDetailExistencia(Detail $objDetail) {
            $sql = "SELECT COUNT(*) 
			FROM FACTUDETAL dtl 
			WHERE dtl.FACDEARTIC = '".$objDetail->getCodeArticle()."' 
			AND dtl.FACDECODIG = ".$objDetail->getCodeBill();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        public function getQuantityInDetailByBill(Detail $objDetail) {
            $sql = "SELECT dtl.FACDECANTI 
			FROM FACTUDETAL dtl 
			WHERE dtl.FACDECODIG = ".$objDetail->getCodeBill()." 
			AND dtl.FACDEARTIC = '".$objDetail->getCodeArticle()."'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function updateQuantityValUnitValTotal(Detail $objDetail){   
            $sql = "UPDATE factudetal dtl 
			SET dtl.FACDECANTI = ".$objDetail->getQuantity().", dtl.FACDEVALUN = ".$objDetail->getValueUnit().", dtl.FACDEVALTO = ".$objDetail->getTotal()." 
			WHERE dtl.FACDECODIG = ".$objDetail->getCodeBill()." 
			AND dtl.FACDEARTIC = '".$objDetail->getCodeArticle()."'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 
        
        public function updateValUnitValTotal(Detail $objDetail){   
            $sql = "UPDATE factudetal dtl 
			SET dtl.FACDEVALUN = ".$objDetail->getValueUnit().", dtl.FACDEVALTO = ".$objDetail->getTotal()." 
			WHERE dtl.FACDECODIG = ".$objDetail->getCodeBill()." 
			AND dtl.FACDEARTIC = '".$objDetail->getCodeArticle()."'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 

}