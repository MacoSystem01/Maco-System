<?php
ob_start();
require ('../templates/fpdf17/fpdf.php');
require '../models/SpendImpl.php';      
//require '../models/ClientImpl.php';
//require '../models/DetailImpl.php';


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
        $this->Cell(0, 0, 'Centro Comercial El Tesoro', 0, 0, 'C');
		
        $this->Cell(-180, 10, 'Local 817 - Piso 8 - Tel. 318 484 34 26', 0, 0, 'C');

        //Salto de línea
        $this->Ln(6);
        $this->Cell(80);
        $this->SetFont('Times', '', 12);
        $this->Cell(0, 8, 'Cali - Valle', 0, 0, 'C');
        $this->Ln(15);
        $this->SetFont('Times', 'B', 12);

        $this->SetFont('Times', '', 9);
        $this->Cell(110, 6, 'Gastos Distribuidora: ', 0, 0, 'L');
        //$this->Cell(110);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 6, 'GASTOS DISTRIBUIDORA', 0, 0, 'R');

        $this->SetFont('Times', '', 9);
        $this->Ln();

        $this->Cell(110, 6, utf8_decode('Desde: '.$_POST['txbFechaInicio'].'    Hasta: '.$_POST['txbFechaFin']), 0, 0, 'L');
        $this->Cell(0, 6, utf8_decode('Fecha Reporte: '.  date(("Y/m/d H:i:s"))), 0, 0, 'R');
        $this->Ln(10);
    }

//    Pie de página
    function Footer() {
//        //Posición: a 1,5 cm del final
//        $this->SetY(-15);
//        //Arial italic 8
//        $this->SetFont('Arial', 'I', 8);
//        //Número de página
//        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    //Tabla simple
    function TablaSimple($header) {        
        //Cabecera
        $this->SetFont('Times', 'B', 9);
        $this->SetTextColor(0,0,0);
        $this->Cell(0, 0, '', 1);
        $this->Ln();

        $cont = 0;
        foreach ($header as $col)
        {
            if($cont == 0)
                $this->Cell(21, 7, $col, 0);
            else if($cont == 1)
                $this->Cell(80, 7, $col, 0);
            else if($cont == 2)
                $this->Cell(90, 7, $col, 0);
            else if($cont == 3)
                $this->Cell(30, 7, $col, 0);
            else if($cont == 4)
                $this->Cell(39, 7, $col, 0);          
                    
            $cont++;
        }
        $this->Ln();
        $this->Cell(0, 0, '', 1);
        $this->Ln(3);
        $this->SetFont('Times', '', 8);
        $this->SetTextColor(0,0,0);

        require_once '../models/ClientImpl.php';
        require_once '../models/ConceptImpl.php';
        
        $objSpendImpl = new SpendImpl();        
        
        $totalGastos = 0;
        
        foreach ($objSpendImpl->getSpendBetweenDate($_POST['txbFechaInicio'], $_POST['txbFechaFin'], $_POST['txbCliente'], $_POST['txbSpendo'],  $_POST['txbRemision']) as $valorSpend) {                        
            $this->Cell(21, 5, $valorSpend->getCode(), 0, 0, 'C');
            
            $objClientImpl = new ClientImpl();
            $this->Cell(80, 5, $valorSpend->getCodeClient().' - '. $objClientImpl->getNameClient($valorSpend->getCodeClient()), 0);

            $objConceptImpl = new ConceptImpl();
            $this->Cell(90, 5, $objConceptImpl->getNameConcept($valorSpend->getCodeConcept()), 0); 
            $this->Cell(30, 5, $valorSpend->getGenerationDate(), 0); 
            
            $this->Cell(39, 5, number_format($valorSpend->getValue()), 0, 0, 'R'); 
            $this->Ln(6);
            
            $totalGastos += $valorSpend->getValue();
        }
        
        $this->Cell(21, 5, '', 0);
        $this->Cell(80, 5, '', 0);
        $this->Cell(90, 5, '', 0);
        $this->Cell(30, 5, '', 0);
        $this->Cell(39, 5, number_format($totalGastos), 0, 0, 'R');

    }
    
}

$pdf=new PDF('L','mm','Letter'); 
//Títulos de las columnas
$header = array('Recibo', 'Cliente', 'Concepto', 'Fecha', '                                 Valor');
$pdf->AliasNbPages();
//Primera página
$pdf->AddPage();
$pdf->SetY(50);
$pdf->TablaSimple($header);
$pdf->Output();
?>