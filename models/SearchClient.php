<?php
    $buscar = $_POST['b'];    
    
    if (!empty($buscar)) {
        $sql = "SELECT * FROM cliente clnt WHERE clnt.CLIENCODIG LIKE '%" . $buscar . "%'"
                . "OR UPPER(clnt.CLIENNOMBR) LIKE UPPER ('%" . $buscar . "%')"
                . "OR UPPER(clnt.CLIENDIREC) LIKE UPPER ('%" . $buscar . "%')"
                . "OR UPPER(clnt.CLIENCELUL) LIKE UPPER ('%" . $buscar . "%')"
                . "OR UPPER(clnt.CLIENCELUL) LIKE UPPER ('%" . $buscar . "%')"
                . "OR clnt.CLIENDEPAR = (SELECT dprtm.DEPARCODIG FROM departamen dprtm "
                . "WHERE UPPER(dprtm.DEPARNOMBR) = UPPER('" . $buscar . "'))"
                . "OR clnt.CLIENLOCAL = (SELECT lclt.LOCALCODIG FROM localidad lclt "
                . "WHERE UPPER(lclt.LOCALNOMBR) = UPPER('" . $buscar . "'))";
                       
        buscar($sql, $buscar, 1);
    }
    else
    {
        $sql = "SELECT * FROM cliente clnt WHERE ROWNUM <= 10 ORDER BY clnt.CLIENCODIG ASC";
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
                <th>NIT/CC</th>
                <th>NOMBRES</th>
                <th>DEPARTAMENTO</th>
                <th>CIUDAD</th>
                <th>DIRECCION</th>
                <th>CELULAR</th>
                <th>TIPO</th>
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
                    require_once './DepartmentImpl.php';
                    $objDepartmentImpl = new DepartmentImpl();
                    $department = $objDepartmentImpl->getNameDepartment($row['3']);
                    ?>                    
                    <td><?php echo $department; ?></td>
                    
                    <?php
                    require_once './LocalityImpl.php';
                    $objLocalityImpl = new LocalityImpl();
                    $locality = $objLocalityImpl->getNameLocality($row['4']);
                    ?>                    
                    <td><?php echo $locality; ?></td>
                    
                    <td><?php echo $row[5]; ?></td>
                    <td><?php echo $row[6]; ?></td>
                    
                    <?php
                    
                    if(strcmp($row[8],"") != 0)
                    {
                        require_once './TypeClientImpl.php';
                        $objTypeClientImpl = new TypeClientImpl();
                        $tipo = $objTypeClientImpl->getNameTypeClient($row['8']);?>
                        <td><?php echo $tipo; ?></td>
                    <?php                                    
                    }
                    else{?>
                        <td><?php echo ''; ?></td>
                    <?php
                    }
                    ?>
                    
                    <td id="tdAcciones">
                        <?php
                        echo '<a href = "edit_client.php?id='.$row[0].'"><img src = "../../res/edit-16.png"></a>';
//<a href = "../../controllers/ctrlDeleteClient.php?id='.$row[0].'"><img src = "../../res/delete-16.png"></a>';                                        
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
            require_once './ClientImpl.php';
            $objClientImpl = new ClientImpl();
            echo '<p>Ultimos registros de '.$objClientImpl->getCount().' encontrados</p>';
        }
    
    }
?>