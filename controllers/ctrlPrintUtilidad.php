<?php
ob_start();
require ('../templates/fpdf17/fpdf.php');
require '../models/BillImpl.php'; 
require '../models/DetailImpl.php';
require '../models/StockImpl.php';
require '../models/SpendImpl.php';

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
        $this->Cell(110, 6, 'Utilidad X Rango de Fechas: ', 0, 0, 'L');
        //$this->Cell(110);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 6, 'UTILIDAD EJERCICIO', 1, 0, 'C');

        $this->SetFont('Times', '', 9);
        $this->Ln();

        $this->Cell(110, 6, utf8_decode('Desde: '.$_POST['txbFechaInicio'].'    Hasta: '.$_POST['txbFechaFin']), 0, 0, 'L');
        $this->Cell(110, 6, utf8_decode('Fecha de Generación: '.date("Y/m/d H:i:s")), 0, 0, 'L');
        $this->Ln();
        $this->Cell(110, 6, '', 0, 0, 'L');                        
                 
        if(strcmp($_POST['comboPayment'], "TODOS") == 0)
            $this->Cell(0, 6, utf8_decode('Forma de Pago: TODOS'), 0, 0, 'L');
        else if(strcmp($_POST['comboPayment'], "CONTADO") == 0)
            $this->Cell(0, 6, utf8_decode('Forma de Pago: CONTADO'), 0, 0, 'L');
        else if(strcmp($_POST['comboPayment'], "CREDITO") == 0)
            $this->Cell(0, 6, utf8_decode('Forma de Pago: CREDITO'), 0, 0, 'L');
        
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
        $objBillImpl = new BillImpl();
        $objStockImpl = new StockImpl();        
        $objDetailImpl = new DetailImpl();
        $objSpendImpl = new SpendImpl();
                
        $sumTotalContado = $objBillImpl->getSumPayment($_POST['txbFechaInicio'], $_POST['txbFechaFin'], 'CO');
        $sumTotalCredito = $objBillImpl->getSumPaymentNoVentas($_POST['txbFechaInicio'], $_POST['txbFechaFin'], 'CR');
        $sumTotalCreditoOtrosIngresos = $objBillImpl->getSumPaymentOtrosIngresos($_POST['txbFechaInicio'], $_POST['txbFechaFin'], 'CR');

		$SumRecaudoCredActuales = $objBillImpl->getSumRecaudoCredActuales($_POST['txbFechaInicio'], $_POST['txbFechaFin']);

		$sumPagosProveeNal = $objBillImpl->getPagosProveeNal($_POST['txbFechaInicio'], $_POST['txbFechaFin']);
		$sumPagosProveeImp = $objBillImpl->getPagosProveeImp($_POST['txbFechaInicio'], $_POST['txbFechaFin']);
		
        $sumTotalRecaudo = $objBillImpl->getSumRecaudo($_POST['txbFechaInicio'], $_POST['txbFechaFin']);
        $sumTotalRecaudoNoVentas = $objBillImpl->getSumRecaudoNoVentas($_POST['txbFechaInicio'], $_POST['txbFechaFin']);

        $sumSubTotal = $sumTotalContado + $sumTotalCredito + $sumTotalRecaudo;

        $sumTotalInventario = $objStockImpl->getSumStock($_POST['txbFechaInicio'], $_POST['txbFechaFin']);

        //$sumUtilidad = $sumSubTotal - $sumTotalInventario;
        $sumNacionalContado = $objDetailImpl->getSumNacionalContado($_POST['txbFechaInicio'], $_POST['txbFechaFin']);
        $sumNacionalCredito = $objDetailImpl->getSumNacionalCredito($_POST['txbFechaInicio'], $_POST['txbFechaFin']);

        $sumImportadoContado = $objDetailImpl->getSumImportadoContado($_POST['txbFechaInicio'], $_POST['txbFechaFin']);
        $sumImportadoCredito = $objDetailImpl->getSumImportadoCredito($_POST['txbFechaInicio'], $_POST['txbFechaFin']);

        //$sumTotalGastos = $objSpendImpl->getSumSpend($_POST['txbFechaInicio'], $_POST['txbFechaFin']);
        $SumGastosNacional = $objDetailImpl->getSumGastosNacional($_POST['txbFechaInicio'], $_POST['txbFechaFin']);
        $SumGastosImportado = $objDetailImpl->getSumGastosImportado($_POST['txbFechaInicio'], $_POST['txbFechaFin']);
        //$SumGastosOtros = $objDetailImpl->getSumGastosOtros($_POST['txbFechaInicio'], $_POST['txbFechaFin']);
		$sumTotalGastos = $SumGastosNacional + $SumGastosImportado + $SumGastosOtros;
        
		$SumComprasProveeNal = $objBillImpl->getComprasProveeNal($_POST['txbFechaInicio'], $_POST['txbFechaFin']);
		$SumComprasProveeImp = $objBillImpl->getComprasProveeImp($_POST['txbFechaInicio'], $_POST['txbFechaFin']);
        $sumSubCompras = $SumComprasProveeNal + $SumComprasProveeImp;

        $sumUtilidad = $sumTotalContado + $sumTotalCredito - $sumTotalRecaudo - $sumTotalGastos - $sumSubCompras;
        $sumUtilidadOtrosIngresos = $sumTotalCreditoOtrosIngresos - $sumTotalRecaudoNoVentas;
        $sumFlujoCaja = $sumTotalContado + $SumRecaudoCredActuales - $sumTotalRecaudo - $sumTotalGastos - $sumSubCompras + $sumTotalRecaudoNoVentas;

        //Cabecera
        $this->SetFont('Times', 'B', 10);
        $this->SetTextColor(0,0,0);

        foreach ($header as $col)
        {
            $this->Cell(48, 7, $col, 1, 0, 'C');
        }
        $this->Ln();
        $this->SetFont('Times', '', 10);
        $this->SetTextColor(0,0,0);

        $objBillImpl = new BillImpl();
        
        $this->Cell(48, 5, 'Inventario', 1);
        $this->Cell(48, 5, number_format($sumTotalInventario,0), 1, 0, 'R');
        $this->Cell(48, 5, '', 1);
        $this->Cell(48, 5, '', 1);        
        $this->Ln();
        
        $this->Cell(48, 5, utf8_decode('Remisión Contado'), 1);
        $this->Cell(48, 5, '', 1);
        $this->Cell(48, 5, number_format($sumTotalContado,0), 1, 0, 'R');
        $this->Cell(48, 5, '', 1);
        $this->Ln();
        $this->Cell(48, 5, utf8_decode('Nacional'), 1, 0, 'R');
        $this->Cell(48, 5, '', 1);
        $this->Cell(48, 5, number_format($sumNacionalContado,0), 1, 0, 'R');
        $this->Cell(48, 5, '', 1);
        $this->Ln();
        $this->Cell(48, 5, utf8_decode('Importado'), 1, 0, 'R');
        $this->Cell(48, 5, '', 1);
        $this->Cell(48, 5, number_format($sumImportadoContado,0), 1, 0, 'R');
        $this->Cell(48, 5, '', 1);
        $this->Ln();
        
        $this->Cell(48, 5, utf8_decode('Remisión Crédito'), 1);
        $this->Cell(48, 5, '', 1);
        $this->Cell(48, 5, number_format($sumTotalCredito,0), 1, 0, 'R');
        $this->Cell(48, 5, '', 1);
        $this->Ln();
        $this->Cell(48, 5, utf8_decode('Nacional'), 1, 0, 'R');
        $this->Cell(48, 5, '', 1);
        $this->Cell(48, 5, number_format($sumNacionalCredito,0), 1, 0, 'R');
        $this->Cell(48, 5, '', 1);
        $this->Ln();
        $this->Cell(48, 5, utf8_decode('Importado'), 1, 0, 'R');
        $this->Cell(48, 5, '', 1);
        $this->Cell(48, 5, number_format($sumImportadoCredito,0), 1, 0, 'R');
        $this->Cell(48, 5, '', 1);
        $this->Ln();

        $this->Cell(48, 5, utf8_decode('Recaudos Créditos'), 1);
        $this->Cell(48, 5, '', 1);
        $this->Cell(48, 5, number_format($SumRecaudoCredActuales,0), 1, 0, 'R');
        $this->Cell(48, 5, '', 1);
        $this->Ln();
        
        $this->Cell(48, 5, utf8_decode('Compras'), 1);
        $this->Cell(48, 5, '', 1);
        $this->Cell(48, 5, number_format($sumSubCompras,0), 1, 0, 'R');
        $this->Cell(48, 5, '', 1);
        $this->Ln();
        $this->Cell(48, 5, utf8_decode('Nacional'), 1, 0, 'R');
        $this->Cell(48, 5, '', 1);
        $this->Cell(48, 5, number_format($SumComprasProveeNal,0), 1, 0, 'R');
        $this->Cell(48, 5, '', 1);
        $this->Ln();
        $this->Cell(48, 5, utf8_decode('Importado'), 1, 0, 'R');
        $this->Cell(48, 5, '', 1);
        $this->Cell(48, 5, number_format($SumComprasProveeImp,0), 1, 0, 'R');
        $this->Cell(48, 5, '', 1);
        $this->Ln();

        $this->Cell(48, 5, utf8_decode('Pagos a Proveedores'), 1);
        $this->Cell(48, 5, '', 1);
        $this->Cell(48, 5, number_format($sumTotalRecaudo,0), 1, 0, 'R');
        $this->Cell(48, 5, '', 1);
        $this->Ln();
        $this->Cell(48, 5, utf8_decode('Nacional'), 1, 0, 'R');
        $this->Cell(48, 5, '', 1);
        $this->Cell(48, 5, number_format($sumPagosProveeNal,0), 1, 0, 'R');
        $this->Cell(48, 5, '', 1);
        $this->Ln();
        $this->Cell(48, 5, utf8_decode('Importado'), 1, 0, 'R');
        $this->Cell(48, 5, '', 1);
        $this->Cell(48, 5, number_format($sumPagosProveeImp,0), 1, 0, 'R');
        $this->Cell(48, 5, '', 1);
        $this->Ln();

        $this->Cell(48, 5, utf8_decode('Gastos'), 1);
        $this->Cell(48, 5, '', 1);
        $this->Cell(48, 5, number_format($sumTotalGastos,0), 1, 0, 'R');
        $this->Cell(48, 5, '', 1);
        $this->Ln();
        $this->Cell(48, 5, utf8_decode('Nacional'), 1, 0, 'R');
        $this->Cell(48, 5, '', 1);
        $this->Cell(48, 5, number_format($SumGastosNacional,0), 1, 0, 'R');
        $this->Cell(48, 5, '', 1);
        $this->Ln();
        $this->Cell(48, 5, utf8_decode('Importado'), 1, 0, 'R');
        $this->Cell(48, 5, '', 1);
        $this->Cell(48, 5, number_format($SumGastosImportado,0), 1, 0, 'R');
        $this->Cell(48, 5, '', 1);
        $this->Ln();
        $this->Cell(48, 5, utf8_decode('Otros Gastos'), 1, 0, 'R');
        $this->Cell(48, 5, '', 1);
        $this->Cell(48, 5, number_format($SumGastosOtros,0), 1, 0, 'R');
        $this->Cell(48, 5, '', 1);
        $this->Ln();

/*        $this->Cell(48, 5, utf8_decode('Gastos'), 1);
        $this->Cell(48, 5, '', 1);
        $this->Cell(48, 5, number_format($sumTotalGastos,0), 1, 0, 'R');
        $this->Cell(48, 5, '', 1);
        $this->Ln();*/
        
        $this->Cell(48, 5, utf8_decode('Créditos Otros Conceptos'), 1);
        $this->Cell(48, 5, '', 1);                
        $this->Cell(48, 5, '', 1);
        $this->Cell(48, 5, number_format($sumTotalCreditoOtrosIngresos,0), 1, 0, 'R');
        $this->Ln();
        
        $this->Cell(48, 5, utf8_decode('Recaudos Créditos Anteriores'), 1);
        $this->Cell(48, 5, '', 1);
        $this->Cell(48, 5, '', 1);
        $this->Cell(48, 5, number_format($sumTotalRecaudoNoVentas,0), 1, 0, 'R');
        $this->Ln();
        
        $this->Cell(48, 5, 'Ejercicio', 1);
        $this->Cell(48, 5, number_format($sumTotalInventario,0), 1, 0, 'R');        
        $this->Cell(48, 5, number_format($sumUtilidad,0), 1, 0, 'R');    
        $this->Cell(48, 5, number_format($sumUtilidadOtrosIngresos,0), 1, 0, 'R');
		$this->Ln(13);

        $this->Cell(48, 5, 'Flujo Caja', 1);
        $this->Cell(48, 5, number_format($sumFlujoCaja,0), 1, 0, 'R');    
//		$this->Ln(13);
        
        /*
        $this->Cell(110, 5, '', 0, 0, 'R');        
        $this->SetFont('Times', 'B', 12);
        $this->SetTextColor(0,0,0);
        $this->Cell(0, 5, 'Utilidad Ejercicio: '.number_format($sumUtilidad,0), 1, 0, 'C'); */   
        
        if($sumTotalInventario >0 && $sumSubTotal > 0)
        {
            $this->Ln(18);
            $data = array('Inventario' => $sumTotalInventario, 'Remisiones' => $sumUtilidad, 'Otros' => $sumUtilidadOtrosIngresos);
            $this->SetFont('Times', 'B', 12);
            $this->Cell(0, 5, 'Inventario - Remisiones - Otros Ingresos', 0, 1);
            $this->Ln(8);
            $valX = $this->GetX();
            $valY = $this->GetY();
            $this->BarDiagram(190, 70, $data, '%l : %v (%p)', array(255, 175, 100));
            $this->SetXY($valX, $valY + 80);
        }
    }
    
    function BarDiagram($w, $h, $data, $format, $color=null, $maxVal=0, $nbDiv=4)
    {
        $this->SetFont('Courier', '', 10);
        $this->SetLegends($data, $format);

        $XPage = $this->GetX();
        $YPage = $this->GetY();
        $margin = 2;
        $YDiag = $YPage + $margin;
        $hDiag = floor($h - $margin * 2);
        $XDiag = $XPage + $margin * 2 + $this->wLegend;
        $lDiag = floor($w - $margin * 3 - $this->wLegend);
        if($color == null)
            $color=array(177, 204, 218);
        if ($maxVal == 0) {
            $maxVal = max($data);
        }
        $valIndRepere = ceil($maxVal / $nbDiv);
        $maxVal = $valIndRepere * $nbDiv;
        $lRepere = floor($lDiag / $nbDiv);
        $lDiag = $lRepere * $nbDiv;
        $unit = $lDiag / $maxVal;
        $hBar = floor($hDiag / ($this->NbVal + 1));
        $hDiag = $hBar * ($this->NbVal + 1);
        $eBaton = floor($hBar * 80 / 100);

        $this->SetLineWidth(0.2);
        $this->Rect($XDiag, $YDiag, $lDiag, $hDiag);

        $this->SetFont('Courier', '', 10);
        $this->SetFillColor(177, 204, 218);
        $i=0;
        foreach($data as $val) {
            //Bar
            $xval = $XDiag;
            $lval = (int)($val * $unit);
            $yval = $YDiag + ($i + 1) * $hBar - $eBaton / 2;
            $hval = $eBaton;
            $this->Rect($xval, $yval, $lval, $hval, 'DF');
            //Legend
            $this->SetXY(0, $yval);
            $this->Cell($xval - $margin, $hval, $this->legends[$i], 0, 0, 'R');
            $i++;
        }

        //Scales
        for ($i = 0; $i <= $nbDiv; $i++) {
            $xpos = $XDiag + $lRepere * $i;
            $this->Line($xpos, $YDiag, $xpos, $YDiag + $hDiag);
            $val = $i * $valIndRepere;
            $xpos = $XDiag + $lRepere * $i - $this->GetStringWidth($val) / 2;
            $ypos = $YDiag + $hDiag - $margin;
            $this->Text($xpos, $ypos, $val);
        }
    }
    
    function SetLegends($data, $format)
    {
        $this->legends=array();
        $this->wLegend=0;
        $this->sum=array_sum($data);
        $this->NbVal=count($data);
        foreach($data as $l=>$val)
        {
            $p=sprintf('%.2f', $val/$this->sum*100).'%';
            $legend=str_replace(array('%l', '%v', '%p'), array($l, number_format($val), $p), $format);
            $this->legends[]=$legend;
            $this->wLegend=max($this->GetStringWidth($legend), $this->wLegend);
        }
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
$header = array('Detalle', 'Inventario', 'Remisiones', 'Otros Ingresos');
$pdf->AliasNbPages();
//Primera página
$pdf->AddPage();
$pdf->SetY(53);
//$pdf->AddPage();
$pdf->TablaSimple($header);
//Segunda página
//$pdf->AddPage();
//$pdf->SetY(65);
//$pdf->TablaColores($header);
$pdf->Output();
?>