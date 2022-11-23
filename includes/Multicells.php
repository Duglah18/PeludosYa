<?php
//call main fpdf file
require('./assets/fpdf/fpdf.php');
//http://www.fpdf.org/en/script/script9.php Para marca de agua
//create new class extending fpdf class
class PDF_MC_Table extends FPDF {

	// Cabecera de página
	function Header(){
		// Logo
		// $this->imag
		$this->Image(URL_ASSETS."/blue.png", null, null, 60);//Logo polipropeludos

		// Arial bold 12
		$this->SetFont('Arial','B',12);

		//Fecha y usuario
		$this->SetXY(135, 10);
		$this->Cell(200, 10,'Usuario: ' . $_SESSION['usuario'], 0, 0, 'R');
		$this->SetXY(235, 15);
		$this->Cell(100, 10,'Fecha: '.date('d/m/Y'), 0, 0, 'R');
		
		// Arial bold 18
		$this->SetFont('Arial','B',18);
		// Movernos a la derecha
		$this->SetXY(0, 20);
    	$this->Cell(0, 10, 'Reportes Peludos Ya', 0, 1, 'C');
		$this->Cell(80);
		// Título
		$this->SetFont('Arial','BIU',18);
		$this->SetXY(0, 30);
		$this->Cell(0,10,isset($_POST['Reporte'])? $_POST['Reporte']: "Title",0,0,'C');
		// Salto de línea
		$this->Ln(20);
		//Se pudo haber hecho esto pero bueno:
		//http://www.fpdf.org/en/script/script50.php
		//sacado de: https://tucafejava.blogspot.com/2018/06/personaliza-tus-reportes-pdf-desde-php.html
		//prueba
		
		//Preguntar a la profesora si es mejor que se repita siempre el header o no 
		//usa un switch para colcar la parte de arriba de la tabla la cabecera dependiendo del tipo de consulta
		$this->SetFont('Arial','B',12);
		$this->SetTitle("Reportes de ".$_POST['Reporte']);
		switch($_POST['Reporte']){
			case "Peludos":
				//$this->SetTitle('Reportes de Peludos');
				
				$this->SetXY(10, 30);
				$this->Cell(50, 10, "Peludos Totales: ". $_SESSION['numtotAnimales'], 0, 1, 'L');
				// $this->SetXY(10, 35);
				// $this->Cell(50, 10, "Peludos Adoptados Totales en todo el sistema: " . $_SESSION['TotAdop'], 0, 1, 'L');
				// $this->SetXY(10, 40);
				// $this->Cell(50, 10, "Adopciones Canceladas En todo el sistema: " . $_SESSION['AdopCanc'], 0, 1, 'L');


				$this->Cell(15, 5, "ID", 1, 0,'C', 0);
				$this->Cell(40, 5, "Nombre", 1, 0,'C', 0);
				$this->Cell(20, 5, utf8_decode("Año Nac."), 1, 0,'C', 0);
				//$this->Cell(35, 5, "Img", 1, 0,'C', 0);
				$this->Cell(55, 5, "Descripcion", 1, 0,'C', 0);
				$this->Cell(30,5, "Adoptado", 1, 0, 'C', 0);
				$this->Cell(35, 5, "Fecha Ingreso", 1, 0,'C', 0);
				$this->Cell(30, 5, "Raza", 1, 0,'C', 0);
				$this->Cell(20, 5, utf8_decode("Tamaño"), 1, 0,'C', 0);
				$this->Cell(50, 5, "Albergue", 1, 0,'C', 0);
				$this->Cell(35, 5, "Disponible", 1, 1,'C', 0);
				break;
			case "Veterinarios":
				//$this->SetTitle('Reportes de Veterinarios');
					
				$this->SetXY(10, 30);
				$this->Cell(50, 10, "Veterinarios Totales: ".$_SESSION['TotVeter'], 0, 1, 'L');

				$this->Cell(30, 5, "ID", 1, 0,'C', 0);
				$this->Cell(65, 5, "Nombre", 1, 0,'C', 0);
				$this->Cell(45, 5, utf8_decode("Teléfono"), 1, 0,'C', 0);
				$this->Cell(65, 5, utf8_decode("Dirección"), 1, 0,'C', 0);
				$this->Cell(65, 5, "Usuario Que lo Registro", 1, 0,'C', 0);
				$this->Cell(60, 5, "Visible", 1, 1,'C', 0);
				break;
				//20,65,45,60,45,60,30
			case "Usuarios":
				//$this->SetTitle('Reportes de Usuarios');
				
				$this->SetXY(10, 30);
				$this->Cell(50, 10, "Usuarios Totales: " . $_SESSION['Num'], 0, 1, 'L');
				$this->SetXY(10, 35);
				$this->Cell(50, 10, "Peludos Adoptados Totales: ", 0, 1, 'L');
				$this->SetXY(10, 40);
				$this->Cell(50, 10, "Adopciones Canceladas: ", 0, 1, 'L');

				$this->Cell(35, 5, "Cedula", 1, 0,'C', 0);
				$this->Cell(60, 5, "Nombre", 1, 0,'C', 0);
				$this->Cell(35, 5, "Rol", 1, 0,'C', 0);
				$this->Cell(60, 5, utf8_decode("Dirección"), 1, 0,'C', 0);
				$this->Cell(45, 5, utf8_decode("Teléfono"), 1, 0,'C', 0);
				$this->Cell(55, 5, "Detalles", 1, 0,'C', 0);
				$this->Cell(40, 5, "Activo", 1, 1,'C', 0);
				break;
			case "Albergues":
				//$this->SetTitle('Reportes de Movimientos');

				$this->SetXY(10, 30);
				$this->Cell(50, 10, "Movimientos Totales Mostrando: " . $_SESSION['num'], 0, 1, 'L');
				
				$this->Cell(35, 5, "ID", 1, 0,'C', 0);
				$this->Cell(70, 5, utf8_decode("Nombre Albergue"), 1, 0,'C', 0);
				$this->Cell(70, 5, utf8_decode("Dirección"), 1, 0,'C', 0);
				$this->Cell(75, 5, utf8_decode("Fundacion Propietaria"), 1, 0,'C', 0);
				$this->Cell(45, 5, "Activo", 1, 1,'C', 0);
				break;
			case "Bitacora":
				//$this->SetTitle('Reportes de Bitacoras');
				
				$this->SetXY(10, 30);
				$this->Cell(50, 10, "Registros Totales: " . $_SESSION['num'], 0, 1, 'L');

				$this->Cell(30, 5, "ID", 1, 0,'C', 0);
				$this->Cell(35, 5, utf8_decode("Usuario Acción"), 1, 0,'C', 0);
				$this->Cell(45, 5, utf8_decode("Módulo"), 1, 0,'C', 0);
				$this->Cell(70, 5, utf8_decode("Acción"), 1, 0,'C', 0);
				$this->Cell(55, 5, utf8_decode("Valor Anterior"), 1, 0,'C', 0);
				$this->Cell(55, 5, utf8_decode("Valor Actual"), 1, 0,'C', 0);
				$this->Cell(40, 5, "Fecha", 1, 1,'C', 0);
				break;
			default: echo "a";
				break;
		}
	}

	// Pie de página
	function Footer(){
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
	function Row($data){
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
		for($i=0;$i<count($data);$i++){
			// width of the current col
			$w=$this->widths[$i];
			// alignment of the current col. if unset, make it left.
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';//para centrar el contenido o colcoarlo  a la izquierda
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

	function CheckPageBreak($h){
		//If the height h would cause an overflow, add a new page immediately
		if($this->GetY()+$h>$this->PageBreakTrigger)
			$this->AddPage($this->CurOrientation);
	}

	function NbLines($w,$txt){
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
		while($i<$nb){
			$c=$s[$i];
			if($c=="\n"){
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
			if($l>$wmax){
				if($sep==-1){
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