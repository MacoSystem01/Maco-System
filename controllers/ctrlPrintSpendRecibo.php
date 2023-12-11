<?php
ob_start();
require ('../templates/fpdf17/fpdf.php');
require '../models/SpendImpl.php';      
require '../models/ClientImpl.php';
require '../models/DetailImpl.php';
require '../models/StockImpl.php';
require '../models/DepartmentImpl.php';
require '../models/LocalityImpl.php';
require '../models/UserImpl.php';
require '../models/CreditImpl.php';
require '../models/ConceptImpl.php';
require_once '../models/Letras.php';

class PDF extends FPDF {
   
//Cabecera de página
    function Header() {      
        //Logo
        $this->Image("../res/logo.jpg", 10, 8, 80, 20, "JPG");
        //Arial bold 15
        $this->SetFont('Times', '', 12);
        $this->SetTextColor(48,131,155);
        //Movernos a la derecha
        $this->Cell(80);
        //Título
        $this->Cell(0, 0, 'Centro Comercial El Tesoro', 0, 0, 'C');
        //Salto de línea
        $this->Ln(6);
        $this->Cell(80);
        $this->SetFont('Times', '', 12);
        $this->Cell(0, 0, 'Local 817 - Piso 8', 0, 0, 'C');
        $this->Cell(-110, 10, 'Cel. 318 484 34 26', 0, 0, 'C');
        $this->Cell(110, 20, 'Cali - Valle', 0, 0, 'C');
		
        $this->Cell(-90, 500, 'Recibido: _____________________________', 0, 0, 'C');
        $this->Cell(0, 510, 'CC / Nit: _____________________________', 0, 0, 'C');

        $this->Cell(-300, 500, utf8_decode('!!! Después de 3 días de recibida Mercancía'), 0, 0, 'C');
        $this->Cell(-0, 510, 'NO se aceptan Reclamos x Faltantes !!!', 0, 0, 'C');

        $this->Ln(15);
        $this->SetFont('Times', 'B', 12);
        
        
        $objSpendImpl = new SpendImpl();
        
        foreach ($objSpendImpl->getByCode($_GET['id']) as $valorSpend) {
            $objClientImpl = new ClientImpl();
            $objDepartmentImpl = new DepartmentImpl();
            $objlocalityImpl = new LocalityImpl();
            $objUserImpl = new UserImpl();
            //$objCreditImpl = new CreditImpl();
            
            //$codeClient = $objCreditImpl->getClient($_GET['idc']);
            
            foreach ($objClientImpl->getByCode($valorSpend->getCodeClient()) as $valor) {
                $nameClient = $valor->getName();
                $cc = $valor->getCode();
                $dir = $valor->getDirection();
                $tel = $valor->getMobile();
                $deptoName = $objDepartmentImpl->getNameDepartment($valor->getCodeDepartment());
                $localityName = $objlocalityImpl->getNameLocality($valor->getCodeLocality());
            }
            
            $this->SetFont('Times', '', 9);
            $this->Cell(110, 6, 'Cliente: '.$nameClient, 0, 0, 'L');
            //$this->Cell(110);
            $this->SetFont('Times', 'B', 12);
            $this->Cell(0, 6, 'RECIBO DE CAJA No. '.$_GET['id'], 1, 0, 'C');
        
            $this->SetFont('Times', '', 9);
            $this->Ln();
            
            $this->Cell(110, 6, utf8_decode('Identificación: '.$cc), 0, 0, 'L');
            $this->Cell(0, 6, utf8_decode('Fecha: '.$valorSpend->getGenerationDate()), 0, 0, 'L');
            $this->Ln();
            $this->Cell(110, 6, utf8_decode('Dirección: '.$dir), 0, 0, 'L');            
            $nameUser = $objUserImpl->getNameUser($valorSpend->getUser());
            $this->Cell(0, 6, 'Vendedor: '.$nameUser, 0, 0, 'L');
                        
            $this->Ln();
            $this->Cell(110, 6, utf8_decode('Teléfono: '.$tel), 0, 0, 'L');            
            $this->Ln();    
            $this->Cell(110, 6, utf8_decode('Depto/Ciudad: '.$deptoName.', '.$localityName), 0, 0, 'L');  
            $this->Ln(10);
        }        
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
        $objSpendImpl = new SpendImpl();  
        $objConceptImpl = new ConceptImpl();
        
            //Cabecera
            $this->SetFont('Times', 'B', 9);
            $this->SetTextColor(48,131,155);
            $this->Cell(192, 0, '', 1);
            $this->Ln();
            
            $cont = 0;
            foreach ($header as $col)
            {
                if($cont == 0)
                    $this->Cell(25, 7, $col, 0);
                else if($cont == 1)
                    $this->Cell(130, 7, $col, 0);
                else if($cont == 2)
                    $this->Cell(37, 7, $col, 0);
                $cont++;
            }
            $this->Ln();
            $this->Cell(192, 0, '', 1);
            $this->Ln(3);
            $this->SetFont('Times', '', 8);
            $this->SetTextColor(102,102,102);
            
            $totalL=0;
            
            foreach ($objSpendImpl->getByCode($_GET['id']) as $valorSpend) {                           
                
                $this->Cell(25, 5, utf8_decode($valorSpend->getCode()), 0, 0, 'C');
                
                $nameConcept = $objConceptImpl->getNameConcept($valorSpend->getCodeConcept());                
                $this->Cell(130, 5, $valorSpend->getCodeConcept().' - '.utf8_decode($nameConcept), 0);
                
                $this->Cell(37, 5, number_format($valorSpend->getValue(),0), 0, 0, 'L');                
                $this->Ln(5);                
                $totalL = $valorSpend->getValue();
            }
             
            $objLetras = new Letras(); 
            $con_letra = strtoupper($objLetras->ValorEnLetras($totalL, "pesos"));
//            echo "<b>".$con."</b>";      
          
            //CREACION DEL TOTAL
            $this->Ln(5);
            $this->SetFont('Times', 'B', 12);
            $this->SetTextColor(48,131,155);            
            $this->Cell(110);            
            
            foreach ($objSpendImpl->getByCode($_GET['id']) as $valorSpend) {
                $totalSpend = number_format($valorSpend->getValue(), 0);
                $this->Cell(0, 6, 'TOTAL $ '.$totalSpend, 1, 0, 'C');
                
                $this->SetFont('Times', '', 9);
                $this->SetTextColor(102,102,102);
                $this->Ln(10);                
            }
            $this->Ln(10);
            $this->Cell(130, 5, 'EN TOTAL SON: ', 0);
            $this->Ln(5);
            $this->Cell(130, 5, $con_letra.' M/CTE', 0);
    }   

}

$pdf = new PDF();
//Títulos de las columnas
$header = array('Abonar a', 'Concepto', 'Valor');

$pdf->AliasNbPages();
//Primera página
$pdf->AddPage();
$pdf->SetY(65);
$pdf->TablaSimple($header);
$pdf->Output();
?>