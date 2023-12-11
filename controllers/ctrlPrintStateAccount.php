<?php
ob_start();
require ('../templates/fpdf17/fpdf.php');
require '../models/CreditImpl.php';      
require '../models/DepartmentImpl.php';
require '../models/LocalityImpl.php';

class PDF extends FPDF {
   
//Cabecera de página
    function Header() {      
        //Logo
        $this->Image("../res/logo.jpg", 10, 8, 80, 20, "JPG");
        //Arial bold 15
        $this->SetFont('Times', '', 12);
        $this->SetTextColor(0,0,0);
        //Movernos a la derecha
        $this->Cell(80);
        //Título
        $this->Cell(0, 10, 'Centro Comercial El Tesoro', 0, 0, 'C');
        //Salto de línea
        $this->Ln(6);
        $this->Cell(80);
        $this->SetFont('Times', '', 12);
		
        $this->Cell(0, 10, 'Local 817 - Piso 8 - Tel. 318 484 34 26', 0, 0, 'C');

        $this->Cell(-180, 20, 'Cali - Valle', 0, 0, 'C');
        $this->Ln(15);
        $this->SetFont('Times', 'B', 12);

        $this->SetFont('Times', '', 9);
        $this->Cell(110, 10, 'Consulta Estado de Cuenta: ', 0, 0, 'L');
        //$this->Cell(110);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 10, 'ESTADO DE CUENTA X CLIENTE', 0, 0, 'R');        

        $this->SetFont('Times', '', 9);
        $this->Ln();

        $this->Cell(110, 2, utf8_decode('Desde: '.$_POST['txbFechaInicio'].'    Hasta: '.$_POST['txbFechaFin']), 0, 0, 'L');
        $this->Cell(0, 2, utf8_decode('Fecha Reporte: '.  date(("Y/m/d H:i:s"))), 0, 0, 'R');
        $this->Ln(10); 
    }

//    Pie de página
    function Footer() {

    }

    //Tabla simple
    function TablaSimple($header) {        
        //Cabecera
        $this->SetFont('Times', 'B', 8);
        $this->SetTextColor(0,0,0);
        $this->Cell(0, 0, '', 1);
        $this->Ln();

        $cont = 0;
        foreach ($header as $col)
        {
            if($cont == 0)
                $this->Cell(12, 7, $col, 0);
            else if($cont == 1)
                $this->Cell(14, 7, $col, 0);
            else if($cont == 2)
                $this->Cell(70, 7, $col, 0);
            else if($cont == 3)
                $this->Cell(31, 7, $col, 0);
            else if($cont == 4)
                $this->Cell(31, 7, $col, 0);
            else if($cont == 5)
                $this->Cell(27, 7, $col, 0);
            else if($cont == 6)
                $this->Cell(21, 7, $col, 0); 
            else if($cont == 7)
                $this->Cell(21, 7, $col, 0); 
            else if($cont == 8)
                $this->Cell(21, 7, $col, 0); 
            else if($cont == 9)
                $this->Cell(12, 7, $col, 0); 
           
                    
            $cont++;
        }
        $this->Ln();
        $this->Cell(0, 0, '', 1);
        $this->Ln(3);
        $this->SetFont('Times', '', 8);
        $this->SetTextColor(0,0,0);

        require_once '../models/ClientImpl.php';
        require_once '../models/CollectImpl.php';
        $objCreditImpl = new CreditImpl();
        $objClientImpl = new ClientImpl();
        $objCollectImpl = new CollectImpl();
        
        $valorTotalCreditos = 0;
        $valorTotalAbonos = 0;
        $valorTotalSaldos = 0;
        
        
        if ($objCreditImpl->getCountCreditBetweenDate($_POST['txbFechaInicio'], $_POST['txbFechaFin'], $_POST['txbCliente'], $_POST['txbCredito'],  $_POST['txbRemision']) > 0)
        {
            foreach ($objCreditImpl->getCreditBetweenDate($_POST['txbFechaInicio'], $_POST['txbFechaFin'], $_POST['txbCliente'], $_POST['txbCredito'],  $_POST['txbRemision']) as $valorCredit)
            {     
                $this->Cell(12, 5, $valorCredit->getCode(), 0, 0, 'C');
                $this->Cell(14, 5, $valorCredit->getCodeBill(), 0, 0, 'C');                
                $this->Cell(70, 5, $valorCredit->getCodeClient().' - '.$objClientImpl->getNameClient($valorCredit->getCodeClient()), 0);

                $objDepartmentImpl = new DepartmentImpl();
                $objLocalityImpl = new LocalityImpl();

                $idDpto = $objClientImpl->getDepartment($valorCredit->getCodeClient());
                $idLclt = $objClientImpl->getLocality($valorCredit->getCodeClient());
                
                $this->Cell(31, 5, $objDepartmentImpl->getNameDepartment($idDpto), 0);
                $this->Cell(31, 5, $objLocalityImpl->getNameLocality($idLclt), 0);
                
                $this->SetFont('Times', '', 7);
                $this->Cell(27, 5, $valorCredit->getRegistrationDate(), 0); 
                $this->SetFont('Times', '', 8);

                $this->Cell(21, 5, number_format($valorCredit->getValue()), 0, 0, 'R');            
                $this->Cell(21, 5, 0, 0, 0, 'R');
                $this->Cell(21, 5, number_format($valorCredit->getValue()), 0, 0, 'R');
                $this->Cell(12, 5, floor($objCreditImpl->getDaysMora($valorCredit->getCode())), 0, 0, 'R');

                $this->Ln(6);
                
                $valorTotalCreditos += $valorCredit->getValue();
                
                foreach ($objCollectImpl->getByCredit($valorCredit->getCode()) as $valorCollect)
                {                                                                       
                    $numBill = $objCreditImpl->getBill($valorCollect->getCodeCredit());
                    $idClient = $objCreditImpl->getClient($valorCollect->getCodeCredit());
                    $nameClient = $objClientImpl->getNameClient($idClient);
                    $valueCredit = $objCreditImpl->getValue($valorCollect->getCodeCredit());
                    $pagosAnteriores = $objCollectImpl->getPagosAnterioresFecha($valorCollect->getRegistrationDate(), $valorCollect->getCodeCredit());

                    $this->Cell(12, 5, $valorCollect->getCodeCredit(), 0, 0, 'C');
                    $this->Cell(14, 5, $numBill, 0, 0, 'C');                
                    $this->Cell(70, 5, $idClient.' - '.$nameClient, 0);

                    $objDepartmentImpl = new DepartmentImpl();
                    $objLocalityImpl = new LocalityImpl();

                    $idDpto = $objClientImpl->getDepartment($valorCredit->getCodeClient());
                    $idLclt = $objClientImpl->getLocality($valorCredit->getCodeClient());
                    
                    $this->Cell(31, 5, $objDepartmentImpl->getNameDepartment($idDpto), 0);
                    $this->Cell(31, 5, $objLocalityImpl->getNameLocality($idLclt), 0);
                    
                    $this->SetFont('Times', '', 7);
                    $this->Cell(27, 5, $valorCollect->getRegistrationDate(), 0); 
                    $this->SetFont('Times', '', 8);

                    $this->Cell(21, 5, number_format($valueCredit), 0, 0, 'R');            
                    $this->Cell(21, 5, number_format($valorCollect->getValue()), 0, 0, 'R');
                    $this->Cell(21, 5, number_format($valueCredit-$pagosAnteriores), 0, 0, 'R');
                    
//                    if( ($valueCredit-$pagosAnteriores) == 0)
//                        $this->Cell(12, 5, 0, 0, 0, 'R');
//                    else
                        $this->Cell(12, 5, floor($objCreditImpl->getDaysMora($valorCollect->getCodeCredit())), 0, 0, 'R');

                    $this->Ln(6);
                    
                    $valorTotalAbonos += $valorCollect->getValue();

                }                
                
            }
            
            $valorTotalSaldos = $valorTotalCreditos - $valorTotalAbonos;
            
            $this->Cell(12, 5, '', 'C');
            $this->Cell(14, 5, '', 'C');
            $this->Cell(70, 5, '', 'C');
            $this->Cell(31, 5, '', 'C');            
            $this->Cell(31, 5, '', 'C');
            $this->Cell(27, 5, '', 'C');
            $this->Cell(21, 5, number_format($valorTotalCreditos), 0, 0, 'R');            
            $this->Cell(21, 5, number_format($valorTotalAbonos), 0, 0, 'R');
            $this->Cell(21, 5, number_format($valorTotalSaldos), 0, 0, 'R');
            $this->Cell(12, 5, '', 'C');

        }
        
    }
    
}

//$pdf = new PDF();
$pdf=new PDF('L','mm','Letter'); 
//Títulos de las columnas
$header = array(utf8_decode('Crédito'), utf8_decode('Remisión'), 'Cliente', 'Departamento', 'Ciudad', 'Fecha', '           Valor', '           Abono',
 '         Saldo', 'D. Mora');
$pdf->AliasNbPages();
//Primera página
$pdf->AddPage();
$pdf->SetY(50);
$pdf->TablaSimple($header);
$pdf->Output();
?>