<?php
ob_start();
require ('../templates/fpdf17/fpdf.php');
require '../models/DetailImpl.php';
require '../models/StockImpl.php';


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
		
        $this->Cell(-110, 10, 'Local 817 - Piso 8 - Tel. 318 484 34 26', 0, 0, 'C');

        //Salto de línea
        $this->Ln(6);
        $this->Cell(80);
        $this->SetFont('Times', '', 12);
        $this->Cell(0, 8, 'Cali - Valle', 0, 0, 'C');
        $this->Ln(15);
        $this->SetFont('Times', 'B', 12);

        $this->SetFont('Times', '', 9);
        $this->Cell(110, 6, utf8_decode('Existencias X Artículo X Rango de Fechas: '), 0, 0, 'L');
        //$this->Cell(110);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 6, 'EXISTENCIAS X ARTICULO', 1, 0, 'C');

        $this->SetFont('Times', '', 9);
        $this->Ln();

        $this->Cell(110, 6, utf8_decode('Desde: '.$_POST['txbFechaInicio'].'    Hasta: '.$_POST['txbFechaFin']), 0, 0, 'L');
        
        if(strcmp($_POST['txbReferencia'], "") == 0)
            $this->Cell(0, 6, utf8_decode('Referencia: TODOS'), 0, 0, 'L');
        else
            $this->Cell(0, 6, utf8_decode('Referencia: '.strtoupper($_POST['txbReferencia'])), 0, 0, 'L');
        
        
        $this->Ln();
        $this->Cell(110, 6, '', 0, 0, 'L');                        
        $this->Cell(110, 6, utf8_decode('Fecha de Generación: '.date("Y/m/d H:i:s")), 0, 0, 'L');   
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
        $this->Cell(192, 0, '', 1);
        $this->Ln();

        $cont = 0;
        foreach ($header as $col)
        {
            if($cont == 0)
                $this->Cell(25, 7, $col, 0);
            else if($cont == 1)
                $this->Cell(92, 7, $col, 0);
            else if($cont == 2)
                $this->Cell(18, 7, $col, 0);
            else if($cont == 3)
                $this->Cell(25, 7, $col, 0, 0, 'C');
            else if($cont == 4)
                $this->Cell(32, 7, $col, 0);
            $cont++;
        }
        $this->Ln();
        $this->Cell(192, 0, '', 1);
        $this->Ln(3);
        $this->SetFont('Times', '', 8);
        $this->SetTextColor(0,0,0);

        $objStockImpl = new StockImpl();
        
        foreach ($objStockImpl->getByArticleInOutBetweenDate($_POST['txbFechaInicio'],$_POST['txbFechaFin'], $_POST['txbReferencia']) as $valorStock) {            
            $entradas = $objStockImpl->getCountArticleIn($_POST['txbFechaInicio'], $_POST['txbFechaFin'], $valorStock->getCode());
            $salidas = $objStockImpl->getCountArticleOut($_POST['txbFechaInicio'], $_POST['txbFechaFin'], $valorStock->getCode());
            $existencias = $entradas-$salidas;
            
            $this->Cell(25, 5, utf8_decode($valorStock->getCode()), 0);
            $this->Cell(92, 5, utf8_decode($valorStock->getName()), 0);           
             
            
            $this->Cell(18, 5, ''.number_format($entradas,0), 0, 0, 'R');
            $this->Cell(25, 5, ''.number_format($salidas,0), 0, 0, 'R');
            $this->Cell(32, 5, ''.number_format($existencias,0), 0, 0, 'R');
            $this->Ln(5);                
        }        
        
        $this->Ln(12);
        
    }

}   
$pdf = new PDF();
//Títulos de las columnas
$header = array('Referencia', utf8_decode('Artículo'), 'Entradas', '              Salidas', '                Existencias');
$pdf->AliasNbPages();
//Primera página
$pdf->AddPage();
$pdf->SetY(55);
$pdf->TablaSimple($header);
$pdf->Output();
?>