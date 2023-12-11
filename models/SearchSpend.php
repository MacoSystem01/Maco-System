<?php
    $buscar = $_POST['b'];    
    
    if (!empty($buscar)) {
        $sql = "SELECT * FROM gasto gst WHERE gst.GASTORECIB LIKE '%" . $buscar . "%'"
                . "OR gst.GASTOCONCE = (SELECT cncpt.CONCECODIG FROM concepto cncpt "
                . "WHERE UPPER(cncpt.CONCENOMBR) = UPPER('" . $buscar . "'))"
                . "OR gst.GASTOCLIEN LIKE '%" . $buscar . "%'";
                       
        buscar($sql, $buscar, 1);
    }
    else
    {
        $sql = "SELECT * FROM gasto gst WHERE ROWNUM <= 10 ORDER BY gst.GASTORECIB ASC";
        buscar($sql, $buscar, 0);
    }

    function buscar($sql, $buscar, $flag) {
        require './Conexion.php';
        require './ConceptImpl.php';
        require './ClientImpl.php';
        $conex = Conexion::getInstancia();
        $stid = oci_parse($conex, $sql);
        oci_execute($stid);
        $foo = array();
        ?>
        <table>
            <tr>
                <th>RECIBO</th>
                <th>CLIENTE</th>                
                <th>CONCEPTO</th>                
                <th>VALOR</th>                
                <th>FECHA</th>                
                <th>ACCIÓN</th>
            </tr>  
        
            <?php
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {  
                
                $objConeptImpl = new ConceptImpl();
                $objClientImpl = new ClientImpl();
                
                ?> 
                <tr>
                    <td><?php echo $row[0]; ?></td>                                
                    <td><?php echo $objClientImpl->getNameClient($row[1]); ?></td>                  
                    <td><?php echo $objConeptImpl->getNameConcept($row[2]); ?></td>                  
                    <td><?php echo $row[3]; ?></td>                  
                    <td><?php echo $row[4]; ?></td>                  
                    <td id="tdAcciones">    
                        <?php
                        echo '<a href = "edit_spend.php?id='.$row[0].'"><img src = "../../res/edit-16.png"></a>';
                        echo '<a href = "../../controllers/ctrlDeleteSpend.php?id='.$row[0].'"><img src = "../../res/delete-16.png"></a>';                                        
                        echo '<a target="_blank" href="../../controllers/ctrlPrintSpendRecibo.php?id='.$row[0].'"><img src="../../res/printer-2-16.png"></a>';     
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
            require_once './ConceptImpl.php';
            $objConceptImpl = new ConceptImpl();
            echo '<p>Ultimos registros de '.$objConceptImpl->getCount().' encontrados</p>';
        }
    
    }
?>