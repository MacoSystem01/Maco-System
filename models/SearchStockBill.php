<?php
    $buscar = $_POST['b'];    
    
    if (!empty($buscar)) {
        //$sql = "SELECT * FROM inventario invtr WHERE invtr.INVENMOVIM = 'E' AND UPPER(invtr.INVENCODIG) LIKE UPPER ('%" . $buscar . "%')"
          //      . "OR invtr.INVENMOVIM = 'E' AND UPPER(invtr.INVENNOMBR) LIKE UPPER ('%" . $buscar . "%')";
        
        $sql = "SELECT DISTINCT invtr.INVENCODIG, invtr.INVENNOMBR FROM inventario invtr "
                ."WHERE invtr.INVENMOVIM = 'E' AND UPPER(invtr.INVENCODIG) LIKE UPPER ('%" . $buscar . "%') "
                . "OR UPPER(invtr.INVENNOMBR) LIKE UPPER ('%" . $buscar . "%') ORDER BY invtr.INVENCODIG";
                
        
        
        buscar($sql, $buscar);
    }
    else
    {
        $sql = "SELECT * FROM inventario invtr WHERE ROWNUM <= 5 AND invtr.INVENMOVIM = 'E' ORDER BY invtr.INVENCODIG";
        buscar($sql, $buscar);
    }

    function buscar($sql, $buscar) {
        require './Conexion.php';
        require './StockImpl.php';
        $conex = Conexion::getInstancia();
        $stid = oci_parse($conex, $sql);
        oci_execute($stid);
        $foo = array();
        ?>
        <script src="../../js/prompt.js"></script>
        <table>
            <tr>
                <th>REFERENCIA</th>
                <th>ARTICULO</th>
                <th>CANTIDAD</th>
                <th>ORIGEN</th>
                <th>ACCIÓN</th>
            </tr>  
        
            <?php
            $objStockImpl = new StockImpl();
            
            $cont = 0;
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                $quantityAvailable = $objStockImpl->getQuantityAvailable($row[0]);
                $quantitySale = $objStockImpl->getQuantitySale($row[0]);
                $totalCantidad = $quantityAvailable - $quantitySale; 
                
            if($totalCantidad>0){
                if($cont%2 != 0){?>
                    <tr id="tdColor">
                <?php
                }else{?>
                    <tr>
                <?php }?>
                    
                    <?php echo '<td id="td1'.$cont.'">'.$row[0]; ?></td>                                
                    <?php echo '<td id="td2'.$cont.'">'.$row[1]; ?></td>
                    
                    <?php
                    echo '<td class="tdDerecha" id="td3' . $cont . '">';
                    
                    echo number_format($totalCantidad,0);

                    echo '</td>';
                    
                    echo '<td class="tdNoVisible" id="td4'.$cont.'">';
                    $priceBuy = $objStockImpl->getLastPriceSold($row[0]); 
                    echo number_format($priceBuy,0);
                    echo '</td>';
                    
                    $origen =  $objStockImpl->getLastOrigen($row[0]);
					//echo 'ORIGEN ES: '.$origen.' - '.$row[0];
                                    
                                    if(strcmp($origen, "I") == 0)
                                            $origen = "IMPORTADO";
                                    else if(strcmp($origen, "N") == 0)
                                            $origen = "NACIONAL";
                                    
                                    echo '<td id="td5'.$cont.'">'.$origen.'</td>';
                    
                    ?>
                    
                   
                                        
                    <td id="tdAcciones">
                        <?php
                        //echo '<a href="edit_detail.php?idf='.$_POST['id'].'&ida='.$row[0].'&n='.$row[1].'&pc='.$row[4].'&pv='.$row[5].'&m='.$$row[2].'&u='.$row[6].'&fm='.$row[7].'"><img src="../../res/add-list-16.png"></a>';                                        
                        echo '<img class="imgEditClass" id="'.$cont.'" src="../../res/add-list-16.png">';
                        ?>                                        
                    </td>  
                </tr> 
        
            <?php
            $cont++;
            }
            }
            ?>
        </table>











    <?php }
?>