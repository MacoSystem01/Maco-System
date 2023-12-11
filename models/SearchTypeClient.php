<?php
    $buscar = $_POST['b'];    
    
    if (!empty($buscar)) {
        $sql = "SELECT * FROM tiposclien tclnt WHERE tclnt.TIPCLCODIG LIKE '%" . $buscar . "%'"
                . "OR UPPER(tclnt.TIPCLNOMBR) LIKE UPPER ('%" . $buscar . "%')";
                       
        buscar($sql, $buscar, 1);
    }
    else
    {
        $sql = "SELECT * FROM tiposclien tclnt WHERE ROWNUM <= 10 ORDER BY tclnt.TIPCLCODIG ASC";
        buscar($sql, $buscar, 0);
    }

    function buscar($sql, $buscar, $flag) {
        require './Conexion.php';
        $conex = Conexion::getInstancia();
        $stid = oci_parse($conex, $sql);
        oci_execute($stid);
        $foo = array();
        ?>
        <table>
            <tr>
                <th>CÓDIGO</th>
                <th>NOMBRE</th>                
                <th>ACCIÓN</th>
            </tr>  
        
            <?php
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {  ?> 
                <tr>
                    <td><?php echo $row[0]; ?></td>                                
                    <td><?php echo $row[1]; ?></td>                  
                    <td id="tdAcciones">
                        <?php
                        echo '<a href = "edit_type_client.php?id='.$row[0].'"><img src = "../../res/edit-16.png"></a>';
                        echo '<a href = "../../controllers/ctrlDeleteTypeClient.php?id='.$row[0].'"><img src = "../../res/delete-16.png"></a>';                                        
                        ?>                                        
                    </td>  
                </tr>
            <?php
            }
            ?>
        </table>
    <?php 
        if($flag == 0)
        {
            require_once './ClientImpl.php';
            $objClientImpl = new ClientImpl();
            echo '<p>Ultimos registros de '.$objClientImpl->getCount().' encontrados</p>';
        }
    
    }
?>