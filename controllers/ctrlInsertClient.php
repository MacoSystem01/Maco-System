<?php
session_start();

if(isset($_POST)){
    require_once '../models/Client.php';
    require_once '../models/ClientImpl.php';
    $objClientImpl = new ClientImpl();
    
    include '../com/server.php';
    $server = new SimpleXMLElement($xmlstr);
    $ip = $server->server[0]->ip;
    
    $num_rows = $objClientImpl->checkCode($_POST['txbCode']);
    
    //echo 'es : '.$num_rows;
    
    if($num_rows == 0)//ENABLE CODE
    {
        //echo '1';
        $name = $_POST['txbName'];
        $objClient = new Client();    
        $objClient->setCode($_POST['txbCode']);
        $objClient->setName($name);
        $objClient->setRegistrationDate(date("Y/m/d H:i:s"));
        $objClient->setCodeDepartment($_POST['selectDepartment']);
        $objClient->setCodeLocality($_POST['selectLocality']);
        $objClient->setDirection($_POST['txbDirection']);
        $objClient->setTipo($_POST['selectTipo']);
        
        if (strcmp($_POST['txbMobile'], '') == 0)
            $objClient->setMobile(0);
        else 
            $objClient->setMobile($_POST['txbMobile']);
        
        $objClient->setUser($_SESSION['userCode']);
        $objClientImpl->insert($objClient);
        
        if(isset($_POST['hiddenGotoBill'])){
            echo '<script>document.location.href = "http://'.$ip.'/baruk/views/bill/add_bill.php?idc='.$_POST['txbCode'].'"; </script>';
        }
        else if(isset($_POST['hiddenGotoBillCredit'])){
            echo '<script>document.location.href = "http://'.$ip.'/baruk/views/credit/add_credit.php?idc='.$_POST['txbCode'].'"; </script>';
        }
        else{
            echo '<script>document.location.href = "http://'.$ip.'/baruk/views/clients/"; </script>';
        }        
    }
    else // DISABLE CODE
    {
        //echo '2';
        echo '<script>document.location.href = "http://'.$ip.'/baruk/views/clients/add_client.php?e&id='.$_POST['txbCode'].'&n='.$_POST['txbName'].'&d='.$_POST['selectDepartment'].'&dir='.$_POST['txbDirection'].'&c='.$_POST['txbMobile'].'$tp='.$_POST['selectTipo'].'"; </script>';        
    }
    
    
    
    
    
    
    
    
}
?>