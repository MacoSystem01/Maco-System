<?php
      $sql = $_POST['b'];
      $pay = $_POST['pay'];
              
       
      if(!empty($sql)) {
            comprobar($sql);
            manejoCredito();
      }
      
       
      function comprobar($sql) {
        require_once './Conexion.php';
        $conex = Conexion::getInstancia();
        $stid = oci_parse($conex, $sql);
        oci_execute($stid);          
        
        /*echo '<span>'.$_POST['idc'].'</span><br>'
        .'<span>'.$_POST['idf'].'</span><br>'
        .'<span>'.$_POST['val'].'</span><br>'
        .'<span>'.$_POST['user'].'</span><br>'
        .'<span>'.$_POST['pay'].'</span>';*/
      }
      
      function manejoCredito() {  
        if($_POST['pay'] === "CR"){            
            require_once './CreditImpl.php';
            require_once './Credit.php';
            $objCreditImplCR = new CreditImpl();
            $objCreditCR = new Credit();
            $num_rows_credit = $objCreditImplCR->checkCodeBillInCredit($_POST['idf']);
           
            //si no existe el credito se crea
            if($num_rows_credit<=0){ 
                $objCreditCR->setCodeClient($_POST['idc']);
                $objCreditCR->setCodeBill($_POST['idf']);
                $objCreditCR->setRegistrationDate(date("Y/m/d H:i:s"));
                $objCreditCR->setCodeConcept(15);
                
                $objCreditCR->setValue($_POST['val']);
                $variableA1 = $objCreditCR->getValue();
                $sig[] = '.';
                $sig[] = ',';
                $valor = str_replace($sig, '', $variableA1);
                
                $objCreditCR->setValue($valor);
                $objCreditCR->setSaldo($valor);                
                $objCreditCR->setState('AC');
                $objCreditCR->setCancelDate(date("Y/m/d H:i:s"));
                $objCreditCR->setUser($_POST['user']);
                
                $objCreditImplCR->insert($objCreditCR);                        
            }
            else{//se actualiza el estado del credito si existe 
                $objCreditCR->setCodeBill($_POST['idf']);
                $objCreditCR->setState('AC');                                
                $objCreditImplCR->updateState($objCreditCR); 
                echo '222';
            }
        }
        else if($_POST['pay'] === "CO"){
            require_once './CreditImpl.php';
            require_once './Credit.php';
            $objCreditImplCR = new CreditImpl();
            $objCreditCR = new Credit();
            $num_rows_credit = $objCreditImplCR->checkCodeBillInCredit($_POST['idf']);
            
            //si esxiste el credito se cancela 
            if($num_rows_credit>0){
                $objCreditCR->setCodeBill($_POST['idf']);
                $objCreditCR->setState('CA');                
                
                $objCreditImplCR->updateState($objCreditCR);                        
            }
        }
          
          
          
//        require_once './Conexion.php';
//        $conex = Conexion::getInstancia();
//        $stid = oci_parse($conex, $sql);
//        oci_execute($stid);          
       
      }
?>
