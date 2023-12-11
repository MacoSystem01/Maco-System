<?php
/**
 * Description of Banco
 *
 * @author MACOSystem
 */

if (file_exists("../models/Conexion.php")) {
    include_once("../models/Conexion.php");    
    require_once('../models/Client.php');
    
} else if (file_exists("../../models/Conexion.php")) {
    include_once("../../models/Conexion.php");    
    require_once('../../models/Client.php');
}


class ClientImpl
{
	
	public function ClientImpl()
	{
		 
	}
        
        public function getAll()
	{
            $sql = "SELECT clnt.CLIENCODIG, clnt.CLIENNOMBR, clnt.CLIENFECCR, clnt.CLIENDEPAR, clnt.CLIENLOCAL, clnt.CLIENDIREC, 
			clnt.CLIENCELUL, clnt.CLIENTIPO 
			FROM cliente clnt 
			WHERE ROWNUM <= 10 
			ORDER BY clnt.CLIENCODIG ASC";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objClient = new Client();
                $objClient->setCode($row[0]);
                $objClient->setName($row[1]);
                $objClient->setRegistrationDate($row[2]);
                $objClient->setCodeDepartment($row[3]);
                $objClient->setCodeLocality($row[4]);
                $objClient->setDirection($row[5]);
                $objClient->setMobile($row[6]);
                $objClient->setTipo($row[7]);
                $foo[] = $objClient;
            }
            return $foo;
        }
        
        public function getNameClient($idClient) {
            $sql = "SELECT clnt.CLIENNOMBR FROM cliente clnt WHERE clnt.CLIENCODIG = ".$idClient;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function getAddressClient($idClient) {
            $sql = "SELECT clnt.CLIENDIREC FROM cliente clnt WHERE clnt.CLIENCODIG = ".$idClient;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function getMobileClient($idClient) {
            $sql = "SELECT clnt.CLIENCELUL FROM cliente clnt WHERE clnt.CLIENCODIG = ".$idClient;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function getDepartment($idClient) {
            $sql = "SELECT clnt.CLIENDEPAR FROM cliente clnt WHERE clnt.CLIENCODIG = ".$idClient;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function getLocality($idClient) {
            $sql = "SELECT clnt.CLIENLOCAL FROM cliente clnt WHERE clnt.CLIENCODIG = ".$idClient;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        
        public function getByCode($idClient)
	{
            $sql = "SELECT clnt.CLIENCODIG, clnt.CLIENNOMBR, clnt.CLIENFECCR, clnt.CLIENDEPAR, clnt.CLIENLOCAL, clnt.CLIENDIREC, 
			clnt.CLIENCELUL, clnt.CLIENUSURE, clnt.CLIENTIPO FROM cliente clnt WHERE clnt.CLIENCODIG = ".$idClient;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo = array();
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {            
                $objClient = new Client();
                $objClient->setCode($row[0]);
                $objClient->setName($row[1]);
                $objClient->setRegistrationDate($row[2]);
                $objClient->setCodeDepartment($row[3]);
                $objClient->setCodeLocality($row[4]);
                $objClient->setDirection($row[5]);
                $objClient->setMobile($row[6]);
                $objClient->setUser($row[7]);
                $objClient->setTipo($row[8]);
                $foo[] = $objClient;
            }
            return $foo;
        }
        
        public function insert(Client $objClient){
            $sql = "INSERT INTO cliente (CLIENCODIG, CLIENNOMBR, CLIENFECCR, CLIENDEPAR, CLIENLOCAL, CLIENDIREC, CLIENCELUL, CLIENUSURE, CLIENTIPO) 
			VALUES (".$objClient->getCode().",'".$objClient->getName()."',TO_DATE('".$objClient->getRegistrationDate()."', 'yyyy/mm/dd hh24:mi:ss'),
			".$objClient->getCodeDepartment().",".$objClient->getCodeLocality().",'".$objClient->getDirection()."',".$objClient->getMobile().",
			".$objClient->getUser().",".$objClient->getTipo().")";
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }        
        
        public function update(Client $objClient, $id){   
            $sql = "UPDATE cliente clnt SET clnt.CLIENCODIG = ".$objClient->getCode().", clnt.CLIENNOMBR = '".$objClient->getName()."', 
			clnt.CLIENDEPAR = ".$objClient->getCodeDepartment().", clnt.CLIENLOCAL = ".$objClient->getCodeLocality().", 
			clnt.CLIENDIREC = '".$objClient->getDirection()."', clnt.CLIENCELUL = ".$objClient->getMobile().", clnt.CLIENTIPO = ".$objClient->getTipo()." 
			WHERE clnt.CLIENCODIG = ".$id;
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        } 
        
        public function delete($objClient){
            $sql = "DELETE FROM cliente clnt WHERE clnt.CLIENCODIG = ".$objClient->getCode();
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);            
        }        
        
        public function getCount() {
            $sql = "SELECT  COUNT(*) FROM cliente";
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
            $sql  = "SELECT COUNT(*) FROM cliente clnt WHERE clnt.CLIENCODIG = ".$code;            
            $conex = Conexion::getInstancia();
            $stid = oci_parse($conex, $sql);
            oci_execute($stid);
            $foo;

            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {          
              $foo = $row[0];
            }        
            return $foo;
        }
        

        public function getCountTypeClientFromClient(Client $objClient) {
            $sql = "SELECT COUNT(*) FROM cliente clnt WHERE clnt.CLIENTIPO = ".$objClient->getTipo();
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