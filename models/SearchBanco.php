<?php
    $buscar = $_POST['b'];    
    
    if (!empty($buscar)) {
        $sql = "SELECT * FROM BANCO WHERE BANCOCODIG LIKE '%" . $buscar . "%'"
                . "OR UPPER(BANCONOMBR) LIKE UPPER ('%" . $buscar . "%')";
                       
        buscar($sql, $buscar, 1);
    }
    else
    {
        $sql = "SELECT * FROM banco WHERE ROWNUM <= 10 ORDER BY BANCOCODIG ASC";
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
                <th>FECHA</th>
                <th>VALOR</th>
                <th>ACCIÓN</th>
            </tr>  
        
            <?php
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {  ?> 
                <tr>
                    <td><?php echo $row[0]; ?></td>                                
                    <td><?php echo $row[1]; ?></td>                  
					<td><?php echo $row[2]; ?></td>   
					<td class="tdDerecha"><?php echo number_format($row[3]); ?></td>   
                    <td id="tdAcciones">
                        <?php
                        echo '<a href = "edit_banco.php?id='.$row[0].'"><img src = "../../res/edit-16.png"></a>';
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
            require_once './BancosImpl.php';
            $objBancoImpl = new BancosImpl();
            echo '<p>Ultimos registros de '.$objBancoImpl->getCount().' encontrados</p>';
        }
    
    }
?>