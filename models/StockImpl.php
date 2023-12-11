<?php
/**
 * Description of Banco
 *
 * @author MACOSystem
 */

if (file_exists("../models/Conexion.php")) {
    include_once("../models/Conexion.php");    
    require_once('../models/Stock.php');
    
} else if (file_exists("../../models/Conexion.php")) {
    include_once("../../models/Conexion.php");    
    require_once('../../models/Stock.php');
}

class StockImpl
{
	
	public function StockImpl()
	{
		 
	}
        
        public function getAll()
	{
            $sql = "SELECT invtr.INVENCODIG, invtr.INVENNOMBR, invtr.INVENMOVIM, 
			invtr.INVENCANTI, invtr.INVENCOSTO, invtr.INVENPREVE, invtr.INVENUBICA, invtr.INVENFECMO 
			FROM inventario invtr 
			WHERE ROWNUM <= 10 
			ORDER BY invtr.INVENFECMO DESC";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objStock = new Stock();
                $objStock->setCode($row[0]);
                $objStock->setName($row[1]);
                $objStock->setMove($row[2]);
                $objStock->setQuantity($row[3]);
                $objStock->setPriceBuy($row[4]);
                $objStock->setPriceSold($row[5]);
                $objStock->setUbication($row[6]);
                $objStock->setMoveDate($row[7]);
                $foo[] = $objStock;
            }
            return $foo;
        }

        
        public function getByCode($idStock)
	{
            $sql = "SELECT invtr.INVENCODIG, invtr.INVENNOMBR, invtr.INVENMOVIM, invtr.INVENCANTI, invtr.INVENUBICA, invtr.INVENFECMO 
			FROM inventario invtr WHERE invtr.INVENCODIG = ".$idStock;                        
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objStock = new Stock();    
                $objStock->setCode($row[0]);
                $objStock->setName($row[1]);
                $objStock->setMove($row[2]);
                $objStock->setQuantity($row[3]);
                $objStock->setPriceBuy($row[4]);
                $objStock->setPriceSold($row[5]);
                $objStock->setUbication($row[6]);
                $objStock->setMoveDate($row[7]);
                $objStock->setUser($row[8]);                
                
                $foo[] = $objStock;
            }
            return $foo;
        }

        
        public function getByCodeEdit($idStock)
	{
            $sql = "SELECT invtr.INVENCODIG, invtr.INVENNOMBR FROM inventario invtr WHERE invtr.INVENCODIG = '".$idStock."'";                        
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objStock = new Stock();    
                $objStock->setCode($row[0]);
                $objStock->setName($row[1]);   
                $foo[] = $objStock;
            }
            return $foo;
        }

        
        public function getNameArticle($idArticle) {
            $sql = "SELECT invtr.INVENNOMBR FROM inventario invtr WHERE invtr.INVENCODIG = '".$idArticle."'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getPromPriceReport($fi, $ff, $ref) {
           
            $sql = "SELECT (invtr.INVENCOSTO) 
			FROM inventario invtr "
            . "WHERE invtr.INVENMOVIM = 'E' AND invtr.INVENFECMO = (SELECT MAX( invtr.INVENFECMO ) 
																	FROM INVENTARIO invtr WHERE invtr.INVENCODIG = '".$ref."' 
																	AND invtr.INVENMOVIM = 'E')" 
            . "AND INVENFECMO BETWEEN TO_DATE('".$fi." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
			AND TO_DATE('".$ff." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
            . "AND invtr.INVENCODIG = UPPER('".$ref."')"
            . "ORDER BY invtr.INVENCODIG";
            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getByAlmacen()
	{
            //$sql = "SELECT invtr.INVENCODIG, invtr.INVENNOMBR, invtr.INVENMOVIM, invtr.INVENCANTI, invtr.INVENCOSTO, invtr.INVENPREVE, invtr.INVENUBICA, invtr.INVENFECMO FROM inventario invtr WHERE ROWNUM <= 5 AND invtr.INVENMOVIM = 'E' ORDER BY invtr.INVENFECMO DESC";
            $sql = "SELECT DISTINCT invtr.INVENCODIG, invtr.INVENNOMBR FROM inventario invtr "
                    . "WHERE ROWNUM <= 5 
					AND invtr.INVENMOVIM = 'E' "
                    . "ORDER BY invtr.INVENCODIG";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objStock = new Stock();
                $objStock->setCode($row[0]);
                $objStock->setName($row[1]);
                $objStock->setMove($row[2]);
                $objStock->setQuantity($row[3]);
                $objStock->setPriceBuy($row[4]);
                $objStock->setPriceSold($row[5]);
                $objStock->setUbication($row[6]);
                $objStock->setMoveDate($row[7]);
                $foo[] = $objStock;
            }
            return $foo;
        }

        
        public function getSumStock($dateA, $dateB) {
            $sql = "SELECT SUM(invtr.INVENCOSTO * invtr.INVENCANTI) 
			FROM inventario invtr 
			WHERE invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
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

        
        public function getByAlmacenBetweenDate($dateA, $dateB, $ref)
	{
            if(strcmp($ref, "") == 0)
            {
                $sql = "SELECT DISTINCT invtr.INVENCODIG, invtr.INVENNOMBR FROM inventario invtr "
                . "WHERE invtr.INVENMOVIM = 'E' 
				AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
                ORDER BY invtr.INVENCODIG";
            }
            else
            {
                $sql = "SELECT DISTINCT invtr.INVENCODIG, invtr.INVENNOMBR FROM inventario invtr "
                . "WHERE invtr.INVENMOVIM = 'E' 
				AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "AND invtr.INVENCODIG = UPPER('".$ref."') "
                . "ORDER BY invtr.INVENCODIG";
            }
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objStock = new Stock();
                $objStock->setCode($row[0]);
                $objStock->setName($row[1]);
                $objStock->setMove($row[2]);
                $objStock->setQuantity($row[3]);
                $objStock->setPriceBuy($row[4]);
                $objStock->setPriceSold($row[5]);
                $objStock->setUbication($row[6]);
                $objStock->setMoveDate($row[7]);
                $foo[] = $objStock;
            }
            return $foo;
        }

        
        public function getByArticleInOutBetweenDate($dateA, $dateB, $ref)
	{
//            $sql = "SELECT invtr.INVENCODIG, invtr.INVENNOMBR, invtr.INVENMOVIM, invtr.INVENCANTI, invtr.INVENFECMO FROM inventario invtr "
//                . "WHERE invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
//                . "AND invtr.INVENCODIG = UPPER('".$ref."') "
//                . "AND (invtr.INVENMOVIM = 'E' "                    
//                . "OR invtr.INVENMOVIM = 'V') "
//                . "ORDER BY invtr.INVENFECMO";
            
            if(strcmp($ref, "") != 0)
            {
                $sql = "SELECT DISTINCT invtr.INVENCODIG, invtr.INVENNOMBR 
				FROM inventario invtr "
                . "WHERE invtr.INVENFECMO >= TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND invtr.INVENFECMO <= TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "AND invtr.INVENCODIG = UPPER('".$ref."') "
                . "AND (invtr.INVENMOVIM = 'E' "                    
                . "OR invtr.INVENMOVIM = 'V') ";
            }
            else if(strcmp($ref, "") == 0)
            {
                $sql = "SELECT DISTINCT invtr.INVENCODIG, invtr.INVENNOMBR FROM inventario invtr "
                . "WHERE invtr.INVENFECMO >= TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND invtr.INVENFECMO <= TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "AND (invtr.INVENMOVIM = 'E' "                    
                . "OR invtr.INVENMOVIM = 'V') ";
            }
            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objStock = new Stock();
                $objStock->setCode($row[0]);
                $objStock->setName($row[1]);
                $objStock->setMove($row[2]);
                $objStock->setQuantity($row[3]);
                $objStock->setMoveDate($row[4]);
                $foo[] = $objStock;
            }
            return $foo;
        }

        
        public function getByArticleVendiBetweenDate($dateA, $dateB, $ref)
	{
            
            if(strcmp($ref, "") != 0)
            {
                $sql = "SELECT facdecodig, facdefecmo, facdeartic, invennombr, facdecanti, facdevalun, facdevalto 
				FROM factudetal, vw_nombre "
                . "WHERE facdeartic = invencodig
				AND FACDEFECMO >= TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND FACDEFECMO <= TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "AND facdeartic = UPPER('".$ref."') "
                . "ORDER BY facdefecmo desc " ;                    
            }
            else if(strcmp($ref, "") == 0)
            {
                $sql = "SELECT facdecodig, facdefecmo, facdeartic, invennombr, facdecanti, facdevalun, facdevalto 
				FROM factudetal, vw_nombre "
                . "WHERE facdeartic = invencodig
				AND FACDEFECMO >= TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND FACDEFECMO <= TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "ORDER BY facdefecmo desc ";
            }
            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objStock = new Stock();
                $objStock->setCode($row[0]);
                $objStock->setMoveDate($row[1]);
                $objStock->setArticulo($row[2]);
                $objStock->setName($row[3]);
                $objStock->setQuantity($row[4]);
                $objStock->setVlrUnit($row[5]);
                $objStock->setVlrTot($row[6]);
                $foo[] = $objStock;
            }
            return $foo;
        }

        
        public function getSumByBill($dateA, $dateB, $ref) {
            
            if(strcmp($ref, "") != 0)
                $sql = "SELECT sum(facdecanti), sum(facdevalun), sum(facdevalto)
				FROM factudetal, vw_nombre 
				WHERE facdeartic = invencodig
				AND FACDEFECMO >= TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND FACDEFECMO <= TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') 
                AND facdeartic = UPPER('".$ref."') ";
				
            else if(strcmp($ref, "") == 0)
                $sql = "SELECT sum(facdecanti), sum(facdevalun), sum(facdevalto)
				FROM factudetal, vw_nombre 
				WHERE facdeartic = invencodig
				AND FACDEFECMO >= TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND FACDEFECMO <= TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') ";
            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }        

        
        public function getCountByAlmacenBetweenDate($dateA, $dateB, $ref)
	{
            if(strcmp($ref, "") == 0)
            {
                $sql = "SELECT COUNT(*) FROM inventario invtr "
                . "WHERE invtr.INVENMOVIM = 'E' 
				AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "ORDER BY invtr.INVENCODIG";
            }
            else
            {
                $sql = "SELECT COUNT(*) FROM inventario invtr "
                . "WHERE invtr.INVENMOVIM = 'E' 
				AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "AND invtr.INVENCODIG = UPPER('".$ref."') "
                . "ORDER BY invtr.INVENCODIG";
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
        
        //

        
        public function getCountByAlmacenBetweenDateReportArticle($dateA, $dateB, $ref)
	{
            if(strcmp($ref, "") != 0)
            {
                $sql = "SELECT COUNT(*) FROM inventario invtr "
                . "WHERE invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "AND invtr.INVENCODIG = UPPER('".$ref."') "
                . "ORDER BY invtr.INVENCODIG";
            }
            else if(strcmp($ref, "") == 0)
            {
                $sql = "SELECT COUNT(*) FROM inventario invtr "
                . "WHERE invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
				AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss') "
                . "ORDER BY invtr.INVENCODIG";
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

        
        public function getOrigen($articulo) {
            $sql = "SELECT invtr.INVENUBICA FROM INVENTARIO invtr WHERE invtr.INVENCODIG = '".$articulo."'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        
        public function insert($objStock){
            $sql = "INSERT INTO inventario (INVENCODIG, INVENNOMBR, INVENMOVIM, INVENCANTI, INVENCOSTO, INVENPREVE, INVENUBICA, INVENFECMO, INVENUSUAR) 
			VALUES('".$objStock->getCode()."','".$objStock->getName()."','".$objStock->getMove()."',".$objStock->getQuantity().",
			".$objStock->getPriceBuy().",".$objStock->getPriceSold().",'".$objStock->getUbication()."',
			TO_DATE('".$objStock->getMoveDate()."', 'yyyy/mm/dd hh24:mi:ss'),".$objStock->getUser().")";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);      
        }        

        
        public function update(Stock $objStock, $id){   
            $sql = "UPDATE inventario invtr 
			SET invtr.INVENCODIG = '".$objStock->getCode()."', invtr.INVENNOMBR = '".$objStock->getName()."', 
			invtr.INVENCANTI = ".$objStock->getQuantity()."  
			WHERE invtr.INVENCODIG = '".$id."' 
			and invtr.INVENFECMO = '".$objStock->getMoveDate()."'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 
        
        
        public function updateQuantity($objStock){   
            $sql = "UPDATE inventario invtr 
			SET invtr.INVENCANTI = ".$objStock->getQuantity()." 
			WHERE invtr.INVENCODIG = '".$objStock->getCode()."' 
			AND invtr.INVENMOVIM = '".$objStock->getMove()."' 
			AND invtr.INVENFECMO = '".$objStock->getMoveDate()."'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }

        
        public function delete($objStock){
            $sql = "DELETE FROM inventario invtr 
			WHERE invtr.INVENCODIG = '".$objStock->getCode()."' 
			AND invtr.INVENMOVIM = '".$objStock->getMove()."' 
			AND invtr.INVENFECMO = '".$objStock->getMoveDate()."'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }        

        
        public function moveToAlmacen($objStock){   
            $sql = "UPDATE inventario invtr 
			SET invtr.INVENMOVIM = 'S', invtr.INVENUBICA = 'A' 
			WHERE invtr.INVENCODIG = '".$objStock->getCode()."' 
			AND invtr.INVENMOVIM = '".$objStock->getMove()."' 
			AND invtr.INVENFECMO = '".$objStock->getMoveDate()."'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }

        
        public function getCount() {
            $sql = "SELECT  COUNT(*) FROM inventario";
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
            $sql  = "SELECT COUNT(*) FROM inventario invtr WHERE UPPER(invtr.INVENCODIG) = '".$code."'";            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getQuantityAvailable($code) {
            $sql = "SELECT  SUM(invtr.INVENCANTI) FROM inventario invtr WHERE invtr.INVENCODIG = '".$code."' AND invtr.INVENMOVIM = 'E'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getQuantitySale($code) {
            $sql = "SELECT SUM(invtr.INVENCANTI) FROM inventario invtr WHERE invtr.INVENCODIG = '".$code."' AND invtr.INVENMOVIM = 'V'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getLastPriceSold($code) {
            $sql = "SELECT invtr.INVENCOSTO FROM INVENTARIO invtr WHERE invtr.INVENFECMO = 
			(SELECT MAX( invtr.INVENFECMO ) FROM INVENTARIO invtr WHERE invtr.INVENCODIG = '".$code."' 
			AND invtr.INVENMOVIM = 'E')";
            //$sql = "SELECT avg(invtr.INVENCOSTO) FROM INVENTARIO invtr WHERE invtr.INVENCODIG = '".$code."' AND invtr.INVENMOVIM = 'E'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        //obtener origen nacional o importado del ultimo registro segun la referencia
        public function getLastOrigen($code) {           
            $sql = "SELECT invtr.INVENUBICA 
			FROM INVENTARIO invtr 
			WHERE invtr.INVENFECMO = (SELECT MAX( invtr.INVENFECMO ) 
									  FROM INVENTARIO invtr 
									  WHERE invtr.INVENCODIG = '".$code."' 
									  AND invtr.INVENMOVIM = 'E') 
			AND invtr.INVENCODIG = '".$code."'";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }

        
        public function getCountArticleIn($dateA, $dateB, $code) {
            if(strcmp($code, "") == 0)
                $sql = "SELECT SUM(invtr.INVENCANTI) 
					    FROM INVENTARIO invtr 
						WHERE invtr.INVENMOVIM = 'E' 
						AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
						AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss')";
            else
                $sql = "SELECT SUM(invtr.INVENCANTI) 
						FROM INVENTARIO invtr 
						WHERE invtr.INVENCODIG = '".$code."' 
						AND invtr.INVENMOVIM = 'E' 
						AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
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

        
        public function getCountArticleOut($dateA, $dateB, $code) {
            if(strcmp($code, "") == 0)
                $sql = "SELECT SUM(invtr.INVENCANTI) 
						FROM INVENTARIO invtr 
						WHERE invtr.INVENMOVIM = 'V' 
						AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
						AND TO_DATE('".$dateB." 23:59:59', 'yyyy/mm/dd hh24:mi:ss')";
            else
                $sql = "SELECT SUM(invtr.INVENCANTI) 
						FROM INVENTARIO invtr 
						WHERE invtr.INVENCODIG = '".$code."' 
						AND invtr.INVENMOVIM = 'V' 
						AND invtr.INVENFECMO BETWEEN TO_DATE('".$dateA." 00:00:00', 'yyyy/mm/dd hh24:mi:ss') 
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