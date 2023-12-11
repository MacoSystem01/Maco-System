<?php
    $buscar = $_POST['b'];    
    
    if (!empty($buscar)) {
        $sql = "SELECT * FROM concepto cncpt WHERE cncpt.CONCECODIG LIKE '%" . $buscar . "%'"
                . "OR UPPER(cncpt.CONCENOMBR) LIKE UPPER ('%" . $buscar . "%')";
                       
        buscar($sql, $buscar, 1);
    }
    else
    {
        $sql = "SELECT * FROM concepto cncpt WHERE ROWNUM <= 10 ORDER BY cncpt.CONCECODIG ASC";
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
                <th>CODIGO</th>
                <th>NOMBRE</th>                
                <th>ACCION</th>
            </tr>  
        
            <?php
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {  ?> 
                <tr>
                    <td><?php echo $row[0]; ?></td>                                
                    <td><?php echo $row[1]; ?></td>                  
                    <td id="tdAcciones">
                        <?php
                        echo '<a href = "edit_concept.php?id='.$row[0].'"><img src = "../../res/edit-16.png"></a>';
                        echo '<a href = "../../controllers/ctrlDeleteConcept.php?id='.$row[0].'"><img src = "../../res/delete-16.png"></a>';                                        
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