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
        $this->Cell(110, 6, 'Inventario por Rango de Fechas: ', 0, 0, 'L');
        //$this->Cell(110);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 6, 'REPORTE DE INVENTARIO', 1, 0, 'C');

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
                $this->Cell(23, 7, $col, 0);
            else if($cont == 1)
                $this->Cell(82, 7, $col, 0);
            /*else if($cont == 2)
                $this->Cell(23, 7, $col, 0);*/
            else if($cont == 2)
                $this->Cell(23, 7, $col, 0, 0, 'C');
            else if($cont == 3)
                $this->Cell(18, 7, $col, 0, 0, 'C');
            else if($cont == 4)
                $this->Cell(23, 7, $col, 0);
            $cont++;
        }
        $this->Ln();
        $this->Cell(192, 0, '', 1);
        $this->Ln(3);
        $this->SetFont('Times', '', 8);
        $this->SetTextColor(0,0,0);

        $objStockImpl = new StockImpl();
        $totalCostoInventario = 0;
        $totalCostoNacional = 0;
        $totalCostoImportada = 0;
        
        foreach ($objStockImpl->getByAlmacenBetweenDate($_POST['txbFechaInicio'],$_POST['txbFechaFin'], $_POST['txbReferencia']) as $valorStock) {            
            $quantityAvailable = $objStockImpl->getQuantityAvailable($valorStock->getCode());
            $quantitySale = $objStockImpl->getQuantitySale($valorStock->getCode());
            $totalCantidad = $quantityAvailable - $quantitySale; 

            if ($totalCantidad != 0)
			{

			$prom = $objStockImpl->getPromPriceReport($_POST['txbFechaInicio'], $_POST['txbFechaFin'], $valorStock->getCode());
            $valueInventary = $prom * $totalCantidad;
            
            $this->Cell(23, 5, utf8_decode($valorStock->getCode()), 0);
            $this->Cell(82, 5, utf8_decode($valorStock->getName()), 0);
            //$this->Cell(23, 5, ''.number_format($prom), 0, 0, 'R');
            $this->Cell(23, 5, ''.number_format($totalCantidad,0), 0, 0, 'R');
            
            $origen = $objStockImpl->getOrigen($valorStock->getCode());
            if(strcmp($origen, "N") == 0)
            {
                $totalCostoNacional += $valueInventary;
            }
            else if(strcmp($origen, "I") == 0)
            {
                $totalCostoImportada += $valueInventary;
            }
            
            
            $this->Cell(18, 5, ''.$origen, 0, 0, 'C');
            $this->Cell(23, 5, ''.number_format($valueInventary), 0, 0, 'R');
            $this->Ln(5);                
            
            $totalCostoInventario += $valueInventary;
			}       
        }       

        $this->Ln(10); 
        $this->Cell(25, 5, '', 0);
        $this->Cell(92, 5, '', 0);
        $this->Cell(25, 5, '', 0);
        $this->Cell(25, 5, 'COSTO MERCANCIA NACIONAL:', 0, 0, 'R');
        $this->Cell(25, 5, ''.number_format($totalCostoNacional), 0, 0, 'R');
        $this->Ln(5); 
        $this->Cell(25, 5, '', 0);
        $this->Cell(92, 5, '', 0);
        $this->Cell(25, 5, '', 0);
        $this->Cell(25, 5, 'COSTO MERCANCIA IMPORTADA:', 0, 0, 'R');
        $this->Cell(25, 5, ''.number_format($totalCostoImportada), 0, 0, 'R');
        $this->Ln(5);
        $this->Cell(25, 5, '', 0);
        $this->Cell(92, 5, '', 0);
        $this->Cell(25, 5, '', 0);
        $this->Cell(25, 5, 'COSTO TOTAL INVENTARIO:', 0, 0, 'R');
        $this->Cell(25, 5, ''.number_format($totalCostoInventario), 0, 0, 'R');
        $this->Ln(5);

    }

    //Tabla coloreada
    function TablaColores($header) {
//Colores, ancho de línea y fuente en negrita
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');
//Cabecera

        for ($i = 0; $i < count($header); $i++)
            $this->Cell(40, 7, $header[$i], 1, 0, 'C', 1);
        $this->Ln();
//Restauración de colores y fuentes
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
//Datos
        $fill = false;
        $this->Cell(40, 6, "hola", 'LR', 0, 'L', $fill);
        $this->Cell(40, 6, "hola2", 'LR', 0, 'L', $fill);
        $this->Cell(40, 6, "hola3", 'LR', 0, 'R', $fill);
        $this->Cell(40, 6, "hola4", 'LR', 0, 'R', $fill);
        $this->Ln();
        $fill = !$fill;
        $this->Cell(40, 6, "col", 'LR', 0, 'L', $fill);
        $this->Cell(40, 6, "col2", 'LR', 0, 'L', $fill);
        $this->Cell(40, 6, "col3", 'LR', 0, 'R', $fill);
        $this->Cell(40, 6, "col4", 'LR', 0, 'R', $fill);
        $fill = true;
        $this->Ln();
        $this->Cell(160, 0, '', 'T');
    }

}

$pdf = new PDF();
//Títulos de las columnas
$header = array('Referencia', utf8_decode('Descripción'), '          Existencias', 'Origen'  ,'            Costo Inv.');
$pdf->AliasNbPages();
//Primera página
$pdf->AddPage();
$pdf->SetY(55);
//$pdf->AddPage();
$pdf->TablaSimple($header);
//Segunda página
//$pdf->AddPage();
//$pdf->SetY(65);
//$pdf->TablaColores($header);
$pdf->Output();
?>