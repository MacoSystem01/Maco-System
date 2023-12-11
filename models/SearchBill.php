<?php
    $buscar = $_POST['b'];    
    
    if (!empty($buscar)) {
        $sql = "SELECT /*+ RULE */ *
				FROM factura fctr 
				WHERE fctr.FACTUESTAD = 'AC' 
				AND fctr.FACTUCODIG LIKE '%" . $buscar . "%'"
                . "OR fctr.FACTUESTAD = 'AC' 
				AND UPPER(fctr.FACTUCLIEN) LIKE UPPER ('%" . $buscar . "%')";
        
		buscar($sql, $buscar);
    }
    else
    {
        $sql = "SELECT /*+ RULE */ * 
				FROM factura fctr 
				WHERE fctr.FACTUESTAD = 'AC' 
				ORDER BY fctr.FACTUCODIG DESC";
        
		buscar($sql, $buscar);
    }

    function buscar($sql, $buscar) {
        require './Conexion.php';
        $conex = Conexion::getInstancia();
        $stid = oci_parse($conex, $sql);
        oci_execute($stid);
        $foo = array();
        ?>
        
        <table>
            <tr>
                <th>CÓDIGO</th>
                <th>CLIENTE</th>
                <th>IDENTIFICACIÓN</th>
                <th>FECHA</th>
                <th>PAGO</th>
                <th>ACCIÓN</th>
            </tr>  
        
            <?php
            $cont = 0;
            require_once './ClientImpl.php';
            
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {  
                $objClientImpl = new ClientImpl();
                $cliente = $objClientImpl->getNameClient($row[1]);
                
                if($cont%2 != 0){?>
                    <tr id="tdColor">
                <?php
                }else{?>
                    <tr>
                <?php }?>
                    <td><?php echo $row[0]; ?></td>                                
                    <td><?php echo $cliente; ?></td>
                    <td><?php echo $row[1]; ?></td>
                    <td><?php echo $row[2]; ?></td>
<!--                    <td><?php echo $row[3]; ?></td>
                    <td><?php echo $row[4]; ?></td>-->
                    
                    <?php
                    if (strcmp($row[5], 'CO') == 0)
                        echo '<td>CONTADO</td>';
                    else if (strcmp($row[5], 'CR') == 0)
                        echo '<td>CREDITO</td>';                                       
                    ?> 
                    
                    <td id="tdAcciones">
                        <?php
                            echo '<a href="view_bill.php?id='.$row[0].'"><img src="../../res/open-in-browser-16.png"></a>';
                            echo '<a href="edit_bill.php?id='.$row[0].'"><img src="../../res/edit-16.png"></a>';
                            if(strcmp ($row[7], 'AC') == 0 || strcmp ($row[7], 'ac') == 0)
                                echo '<a href="../../controllers/ctrlCancelBill.php?id='.$row[0].'&ac"><img src="../../res/x-mark-16.png"></a>'; 
                            else if(strcmp ($row[7], 'IN') == 0 || strcmp ($row[7], 'in') == 0)
                                echo '<a href="../../controllers/ctrlCancelBill.php?id='.$row[0].'&in"><img src="../../res/check-mark-16.png"></a>'; 
                            echo '<a target="_blank" href="../../controllers/ctrlPrintBill.php?id='.$row[0].'"><img src="../../res/printer-2-16.png"></a>';     
                        ?>                                        
                    </td>  
                </tr> 
        
            <?php
            $cont++;
            }?>
        </table>

    <?php }
?>