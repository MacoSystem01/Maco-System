<?php
    $buscar = $_POST['b'];    
    
    if (!empty($buscar)) {
        $sql = "SELECT * FROM credito cr WHERE cr.CREDICODIG LIKE '%" . $buscar . "%'"
                . "OR UPPER(cr.CREDIFACTU) LIKE '%" . $buscar . "%'"
                . "OR cr.CREDICLIEN = (SELECT clnt.CLIENCODIG FROM cliente clnt "
                . "WHERE UPPER(clnt.CLIENNOMBR) = UPPER('" . $buscar . "'))";
                       
        buscar($sql, $buscar, 1);
    }
    else
    {
        $sql = "SELECT * FROM credito cr WHERE ROWNUM <= 10 ORDER BY cr.CREDICODIG ASC";
        buscar($sql, $buscar, 0);
    }

    function buscar($sql, $buscar, $flag) {
        require './Conexion.php';
        $conex = Conexion::getInstancia();
        $stid = oci_parse($conex, $sql);
        oci_execute($stid);
        $foo = array();
        ?>
        <script src="../../js/prompt_collect.js"></script>
        <table>
            <tr>
                <th>CÓDIGO</th>
                <th>CLIENTE</th>
                <th>Ord. COMPRA</th>
                <th>FECHA</th>                                
                <th>VALOR</th>   
                <th>SALDO</th> 
				<th class="tdNoVisible">CONCEPTO</th>				
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
                        
                    <?php 
                    
                    echo '<td id="td1'.$cont.'">'.$row[0].'</td>';    
                    
                    require_once './ClientImpl.php';
                    $objClientImpl = new ClientImpl();
                    $cliente = $objClientImpl->getNameClient($row['1']);
                    
                    echo '<td id="td2'.$cont.'">'.$cliente.'</td>';    
                    echo '<td class="tdDerecha id="td3'.$cont.'">'.$row[2].'</td>';   
                    echo '<td id="td4'.$cont.'">'.$row[3].'</td>';    
                    echo '<td class="tdDerecha" id="td5'.$cont.'">'.number_format($row[5]).'</td>';    
                    echo '<td class="tdDerecha" id="td6'.$cont.'">'.number_format($row[6]).'</td>';   
					echo '<td class="tdNoVisible" id="td7'.$cont.'">'.$row[4].'</td>';					
                    
                                  
                    ?>
                    
                    <td id="tdAcciones">
                        <?php
                        echo '<img class="imgEditClass" id="'.$cont.'" src="../../res/add-list-16.png">';                                     
                        
                        ?>                                        
                    </td>  
                </tr> 
        
            <?php            
            $cont++;
            }
            ?>
        </table>
    <?php 
        if($flag == 0)
        {
//            require_once './ClientImpl.php';
//            $objClientImpl = new ClientImpl();
//            echo '<p>Ultimos registros de '.$objClientImpl->getCount().' encontrados</p>';
        }
    
    }
?>