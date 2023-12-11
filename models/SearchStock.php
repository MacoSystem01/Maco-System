<?php
    $buscar = strtoupper ($_POST['b']);    
    
    if (!empty($buscar)) {
        
        if(strcmp ($buscar, 'ENTRADA') == 0)
            $sql = "SELECT * FROM inventario invtr WHERE UPPER(invtr.INVENMOVIM) = 'E'";
        else if(strcmp ($buscar, 'SALIDA') == 0)
            $sql = "SELECT * FROM inventario invtr WHERE UPPER(invtr.INVENMOVIM) = 'S'";
        else if(strcmp ($buscar, 'VENTA') == 0)
            $sql = "SELECT * FROM inventario invtr WHERE UPPER(invtr.INVENMOVIM) = 'V'";
        else
        {
            $sql = "SELECT * FROM inventario invtr WHERE UPPER(invtr.INVENCODIG) LIKE UPPER ('%" . $buscar . "%')"
                . "OR UPPER(invtr.INVENNOMBR) LIKE UPPER ('%" . $buscar . "%')"
                . "OR UPPER(invtr.INVENMOVIM) = UPPER('" . $buscar . "')";
        }
        
        buscar($sql, $buscar, 1);
    }
    else
    {
        $sql = "SELECT * FROM inventario invtr WHERE ROWNUM <= 10 ORDER BY invtr.INVENFECMO DESC";
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
                <th>REFERENCIA</th>
                <th>ARTICULO</th>
                <th>MOVIMIENTO</th>
                <th>CANTIDAD</th>
                <th>FECHA</th>  
                <th>ACCIÓN</th>
            </tr>  
        
            <?php
            $cont = 0;
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {    
                if($cont%2 != 0){?>
                    <tr id="tdColor">
                <?php
                }else{?>
                    <tr>
                <?php }?>
                    <td><?php echo $row[0]; ?></td>                                
                    <td><?php echo $row[1]; ?></td>
                    
                    <?php
                        if(strcmp ($row[2], 'E') == 0 || strcmp ($row[2], 'e') == 0)
                            echo '<td>ENTRADA</td>';
                        else if(strcmp ($row[2], 'S') == 0 || strcmp ($row[2], 's') == 0)
                            echo '<td>SALIDA</td>';
                        else if(strcmp ($row[2], 'V') == 0 || strcmp ($row[2], 'v') == 0)
                            echo '<td>VENTA</td>';
                        else
                            echo '<td></td>';
                        ?>                                
                    <td class="tdDerecha"><?php echo number_format($row[3],0); ?></td>                                

                    <td class="tdDerecha"><?php echo $row[7]; ?></td>                                
                    
                        <?php
//                        if(strcmp ($row[6], 'B') == 0 || strcmp ($row[6], 'b') == 0)
//                            echo '<td>BODEGA</td>';
//                        else if(strcmp ($row[6], 'A') == 0 || strcmp ($row[6], 'a') == 0)
//                            echo '<td>ALMACEN</td>';
//                        else
//                            echo '<td></td>';
                    ?>
                    
                    <td id="tdAcciones">
                        <?php
                        echo '<a href="edit_stock.php?id='.$row[0].'&n='.$row[1].'&c='.$row[3].'&f='.$row[7].'"><img src="../../res/edit-16.png"></a>';                                                                                
                        ?>                                        
                    </td> 
                    
                    <!--<td id="tdAcciones">-->
                        <?php
//                        if(strcmp ($row[2], 'E') == 0 || strcmp ($row[2], 'e') == 0)//si es una entrada
//                        {
//                            if(strcmp ($row[6], 'B') == 0 || strcmp ($row[6], 'b') == 0)//si esta en bodega
//                                echo '<a href="../../controllers/ctrlMoveStock.php?id='.$row[0].'&m='.$row[2].'&fm='.$row[7].'"><img src="../../res/send-file-16.png"></a>';                                        
//
//                        }
//                        echo '<a href="../../controllers/ctrlDeleteStock.php?id='.$row[0].'&m='.$row[2].'&fm='.$row[7].'"><img src="../../res/delete-16.png"></a>';                                        
                        ?>                                        
                    <!--</td>-->  
                </tr> 
        
            <?php
            $cont++;
            }
            
            ?>
        </table>

    <?php 
        if ($flag == 0) {
            require_once './StockImpl.php';
            $objStockImpl = new StockImpl();
            echo '<p>Ultimos registros de ' . $objStockImpl->getCount() . ' encontrados</p>';
        }
    }
?>