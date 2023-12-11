<?php
    $buscar = $_POST['b'];    
    
    
    if (!empty($buscar)) {
        $sql = "SELECT lcld.LOCALCODIG, lcld.LOCALNOMBR FROM localidad lcld WHERE lcld.LOCALDEPAR = ".$buscar; 
        buscar($sql);
    }
    else
    {
        $sql = "SELECT lcld.LOCALCODIG, lcld.LOCALNOMBR FROM localidad lcld";
        buscar($sql, $buscar);
    }

    function buscar($sql) {
        
        require './Conexion.php';
        $conex = Conexion::getInstancia();
        $stid = oci_parse($conex, $sql);
        oci_execute($stid);
        $foo = array();
        
        ?>        
        <select name="selectLocality" id="selectLocality">
            <?php           
            
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {  
                echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
            }
                                    
            ?>
        </select> 
    <?php }
?>