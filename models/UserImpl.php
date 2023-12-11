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

class UserImpl {
    public function getNameUser($idUser) {
        $sql = "SELECT usr.USUARNOMBR FROM usuario usr WHERE usr.USUARCODIG = " . $idUser;
        $conex = Conexion::getInstancia();
        $stid = oci_parse($conex, $sql);
        oci_execute($stid);
        $foo;

        while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
            $foo = $row[0];
        }
        return $foo;
    }
    
    public function getIdbyName($name) {
        $sql = "SELECT usr.USUARCODIG FROM usuario usr WHERE usr.USUARNOMBR = '".$name."'";
        $conex = Conexion::getInstancia();
        $stid = oci_parse($conex, $sql);
        oci_execute($stid);
        $foo;

        while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
            $foo = $row[0];
        }
        return $foo;
    }
    
    public function login($userName, $pass) {
//        $sql = "SELECT COUNT(*) FROM usuario usr, SYS.USER$  WHERE usr.USUARNOMBR = '".$userName."' AND password = '".$pass."'";
        $sql = "SELECT COUNT(*) FROM usuario usr WHERE usr.USUARNOMBR = '".$userName."' AND usr.USUARPASSW = '".$pass."'";
        $conex = Conexion::getInstancia();
        $stid = oci_parse($conex, $sql);
        oci_execute($stid);
        $row = oci_fetch_array($stid);
        return $row[0];
    }

}
