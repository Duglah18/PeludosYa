<?php
//call main fpdf file
require('./assets/fpdf/fpdf.php');

//create new class extending fpdf class
class PDF_MC_Table extends FPDF {

// Cabecera de página
function Header(){
    // Logo
    //$this->Image('logo.png',10,8,33);
    // Arial bold 15
    $this->SetFont('Arial','B',18);
    // Movernos a la derecha
    $this->Cell(80);
    // Título
    $this->Cell(175,10,isset($_POST['Reporte'])? $_POST['Reporte']: "Title",1,0,'C');
    // Salto de línea
    $this->Ln(20);
	
	//usa un switch para colcar la parte de arriba de la tabla la cabecera dependiendo del tipo de consulta
	$this->SetFont('Arial','B',12);
	switch($_POST['Reporte']){
		case "Animales":
			$this->Cell(15, 5, "ID", 1, 0,'C', 0);
			$this->Cell(35, 5, "Nombre", 1, 0,'C', 0);
			$this->Cell(20, 5, utf8_decode("Año Nac."), 1, 0,'C', 0);
			$this->Cell(35, 5, "Img", 1, 0,'C', 0);
			$this->Cell(45, 5, "Descripcion", 1, 0,'C', 0);
			$this->Cell(35, 5, "Fecha Ingreso", 1, 0,'C', 0);
			$this->Cell(35, 5, "Raza", 1, 0,'C', 0);
			$this->Cell(35, 5, utf8_decode("Tamaño"), 1, 0,'C', 0);
			$this->Cell(35, 5, "Albergue", 1, 0,'C', 0);
			$this->Cell(34, 5, "Visible", 1, 1,'C', 0);
			break;
		case "Veterinarios":
			break;
		case "Usuarios":
			break;
		case "Movimientos":
			break;
		default: echo "a";
			break;
	}
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
	//https://stackoverflow.com/questions/23753991/fpdf-get-page-numbers-at-footer-on-every-a4-size-page
    $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
}

// variable to store widths and aligns of cells, and line height
var $widths;
var $aligns;
var $lineHeight;

//Set the array of column widths
function SetWidths($w){
    $this->widths=$w;
}

//Set the array of column alignments
function SetAligns($a){
    $this->aligns=$a;
}

//Set line height
function SetLineHeight($h){
    $this->lineHeight=$h;
}

//Calculate the height of the row
function Row($data)
{
    // number of line
    $nb=0;

    // loop each data to find out greatest line number in a row.
    for($i=0;$i<count($data);$i++){
        // NbLines will calculate how many lines needed to display text wrapped in specified width.
        // then max function will compare the result with current $nb. Returning the greatest one. And reassign the $nb.
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    }
    
    //multiply number of line with line height. This will be the height of current row
    $h=$this->lineHeight * $nb;

    //Issue a page break first if needed
    $this->CheckPageBreak($h);

    //Draw the cells of current row
    for($i=0;$i<count($data);$i++)
    {
        // width of the current col
        $w=$this->widths[$i];
        // alignment of the current col. if unset, make it left.
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h);
        //Print the text
        $this->MultiCell($w,5,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
    //calculate the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}
}
?>