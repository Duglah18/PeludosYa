<?php

/*
-Clase encargada de los reportes del sistema 
-Se utilizara en torno a ello
-Reportes de:
	*Modificacion de datos: Saldran las consultas en sucio y todo ello y etc como cuantas modificaciones se hicieron en torno a esto etc, por modulo
	*Animales: Cuantos fueron adoptados en torno a tiempo eso desde hasta
	*Usuarios: Cuantos han ingresado etc, Cuantos han sido bloqueados
	*Veterinarios: Cuantos fueron bloqueados, agregados en rango de fecha

Options sacar el value etc:
http://www.forosdelweb.com/f18/recibir-mediante-_post-dos-datos-option-476507/


Yo creo que simplemente no necesitare el crear otra vista aqui mismo se puede imprimir todo
*/
class ReportController extends GeneralController{
 //Esto podria ser un constructor?
	public function Combrueba(){
		if(!isset($_SESSION['usuario']) || $_SESSION['rol'] != "1"){
            return header("location: ".BASE_URL);
        }
	}

	public function Bitacora_Animales(){
		$this->Combrueba();
		if($_POST['Columna'] < 0 || $_POST['Columna'] > 9){
			return header("location: " .BASE_URL. "admin/Reportes");
		}
		$objReports = $this->LoadModel("ReportModel");
		$columna = 0;//$_POST['Columna'];
		$filtro = "";//isset($_POST['Filtro'])? $_POST['Filtro']:"";
		$desde = "";//isset($_POST['Desde'])?$_POST['Desde']:0;
		$hasta = "";//isset($_POST['Hasta'])?$_POST['Hasta']:0;
		$estatus = 0;
		
		// $animales = $objReports->Animales($columna, $filtro,$desde, $hasta, $estatus);
		$animales = $objReports->Animales();
		// $numTotalAnimales = $objReports->TotalAnimales($columna, $filtro,$desde, $hasta, $estatus);
		
		$pdf = new PDF_MC_Table('L','mm',array(350,200));
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Times','',12);
		// for($i=1;$i<=40;$i++)
			// $pdf->Cell(0,10,'Imprimiendo línea número '.$i,0,1);
		//Set width for each column (10)
		$pdf->SetWidths(Array(15,35,20,35,45,35,35,35,35,34));
		//Set Line height
		$pdf->SetLineHeight(5);
		foreach ($animales as $animal){
			$pdf->Row(Array(
				$animal['id_animal'],
				utf8_decode($animal['nombre']),
				$animal['anio_nac'],
				utf8_decode($animal['img']),
				utf8_decode($animal['descripcion']),
				$fecha = date("d-m-Y",strtotime($animal['fecha_ingreso'])),
				utf8_decode($animal['nombreRaza']),
				utf8_decode($animal['nombreTamano']),
				utf8_decode($animal['nombreAlbergue']),
				$animal['visible'] != 1? "No": "Si"
			));
		}
		
		$pdf->Output();
		
		return 0;
	}
	
	public function Bitacora_Veterinarios(){
		$this->Combrueba();
		$objReports = $this->LoadModel("ReportModel");
		$columna = $_POST['Columna'];
		$filtro = isset($_POST['Filtro'])? $_POST['Filtro']:"";
		$objReports->Veterinarios($columna,$filtro);
		$objReports->TotalVeterinarios($columna,$filtro);
		return 0;
	}

	public function Bitacora_Usuarios(){
		$this->Combrueba();
		$objReports = $this->LoadModel("ReportModel");
		$columna = $_POST['Columna'];
		$filtro = isset($_POST['Filtro'])? $_POST['Filtro']:"";
		
		$objReports->Usuarios($columna, $filtro);
		$objReports->TotalUsuarios($columna, $filtro);
		return 0;
	}
	
	public function Bitacora_Movimientos(){
		$this->Combrueba();
		$objReports = $this->LoadModel("ReportModel");
		$columna = $_POST['Columna'];
		$filtro = isset($_POST['Filtro'])? $_POST['Filtro']:"";
		$desde = isset($_POST['Desde'])?$_POST['Desde']:0;
		$hasta = isset($_POST['Hasta'])?$_POST['Hasta']:0;
		
		$objReports->Movimientos($columna, $filtro,$desde, $hasta);
		$objReports->ContadorMovimientos($columna, $filtro,$desde, $hasta);
		return 0;
	}
	
	public function Bitacora_Todo(){
		$this->Combrueba();
		$objReports = $this->LoadModel("ReportModel");
		$columna = $_POST['Columna'];
		$filtro = isset($_POST['Filtro'])? $_POST['Filtro']:"";
		//Creo que lo que manda la pagina de reportes es nada :V porque no hay formulario pero podemos hacerlo
		$objReports->Bitacora($columna, $filtro);
		$objReports->TotalBitacora($columna, $filtro);
		return 0;
	}
}
?>