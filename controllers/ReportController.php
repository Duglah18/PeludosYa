<?php
/*
-Clase encargada de los reportes del sistema 
-Se utilizara en torno a ello
-Reportes de:
	*Modificacion de datos: Saldran las consultas en sucio y todo ello y etc como cuantas modificaciones se hicieron en torno a esto etc, 
	por modulo
	*Animales: Cuantos fueron adoptados en torno a tiempo eso desde hasta
	*Usuarios: Cuantos han ingresado etc, Cuantos han sido bloqueados
	*Veterinarios: Cuantos fueron bloqueados, agregados en rango de fecha

Options sacar el value etc:
http://www.forosdelweb.com/f18/recibir-mediante-_post-dos-datos-option-476507/

Cosas interesantes como links, diagramas, etc:
http://www.fpdf.org/en/script/script20.php
http://www.fpdf.org/en/script/script19.php
http://www.fpdf.org/en/script/script28.php
http://www.fpdf.org/en/script/script98.php
http://www.fpdf.org/en/script/script99.php /Otra cosa que podria servir pero ese template de mostrar todos y detallados lo raltentizaria

A ver aqui hay unas platillas la que realmente me interesa es la de unico
buscar por unico?
http://www.fpdf.org/en/script/script102.php o se coloca un link q lleve a algo unico dependiendo de q selecciones?



Visita y lee: https://tucafejava.blogspot.com/2018/06/personaliza-tus-reportes-pdf-desde-php.html
*/
class ReportController extends GeneralController{
	
	/*****************************************************************
	*	Pertenece: ReportController
	*	Nombre: Comprobador
	*	Función: Comprobar si alguien se encuentra logueado o si tiene el rol requerido
	*	Entradas: Session y Rol
	*	Salidas: Retorno a Pág. Principal.
	*****************************************************************/
	public function Combrueba(){
		if(!isset($_SESSION['usuario']) || $_SESSION['rol'] != "1"){
            return header("location: ".BASE_URL);
        }
	}

	/******************************************************************
	*	Pertenece: ReportController
	*	Nombre: Bitacora_Animales
	*	Función: Mostrar Reporte Animales
	*	Entradas: Filtro de busqueda, columna a buscar, desde, hasta, estatus
	*	Salidas: Reporte de Animales
	******************************************************************/
	public function Bitacora_Animales(){
		$this->Combrueba();
		
		if($_POST['Columna'] < 0 || $_POST['Columna'] > 9){
			return header("location: " .BASE_URL. "admin/Reportes");
		}
		
		$objReports = $this->LoadModel("ReportModel");
		$columna = isset($_POST['Columna'])? $_POST['Columna']: 0;
		$filtro = isset($_POST['Filtro'])? $_POST['Filtro']:"";
		$desde = isset($_POST['Desde'])?$_POST['Desde']:0;
		$hasta = isset($_POST['Hasta'])?$_POST['Hasta']:0;
		$estatus = 0;
		
		// $animales = $objReports->Animales($columna, $filtro,$desde, $hasta, $estatus);
		$animales = $objReports->Animales();
		$numTotalAnimales = $objReports->TotalAnimales($columna, $filtro,$desde, $hasta, $estatus);
		//como voy a hacer para mostrarlo si esto es despues de la tabla :v
		//y en la tabla no puede llamarse a esta funcion creo
		//aunque creo que se puede por como tambien se le puede enviar POST
		
		/*----------Inicio del Documento PDF----------*/
		$pdf = new PDF_MC_Table('L','mm',array(350,200));
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Times','',12);
		
		//Colocar el tamaño de las columnas de las celdas de la tabla (10)
		$pdf->SetWidths(Array(15,35,20,35,45,35,35,35,35,34));
		
		//Colocar la altura de la linea
		$pdf->SetLineHeight(5);
		
		if($animales != false){
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
		} else {
			$pdf->Cell(0,10,"No existen Datos en la Base de Datos Que correspondan a su busqueda.",1,1,'C');
		}
		
		return $pdf->Output();
	}
	
	/******************************************************************
	*	Pertenece: ReportController
	*	Nombre: Bitacora_Veterinarios
	*	Función: Mostrar Reporte Veterinarios
	*	Entradas: Filtro de busqueda, columna a buscar
	*	Salidas: Reporte de Veterinarios
	******************************************************************/
	public function Bitacora_Veterinarios(){
		//Se comprueba si estas logueado y si eres admin sino te enviara a la Página principal
		$this->Combrueba();
		
		$objReports = $this->LoadModel("ReportModel");
		$columna = $_POST['Columna'];
		$filtro = isset($_POST['Filtro'])? $_POST['Filtro']:"";
		
		$veterinarios = $objReports->Veterinarios($columna,$filtro);
		$totalVeterinarios = $objReports->TotalVeterinarios($columna,$filtro);
		
		/*----------Inicio del Documento PDF----------*/
		$pdf = new PDF_MC_Table('L','mm',array(350,200));
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Times','',12);
		
		//Colocar el tamaño de las columnas de las celdas de la tabla (7)
		$pdf->SetWidths(Array(15,35,20,35,35,45,34));
		
		//Colocar la altura de la linea
		$pdf->SetLineHeight(5);
		
		if ($veterinarios != false){
			foreach ($veterinarios as $veterinario){
				$pdf->Row(Array(
					$veterinario['id_veterinario'],
					utf8_decode($veterinario['nombre']),
					$veterinario['tlf'],
					utf8_decode($veterinario['direccion']),
					$veterinario['usuario_Rveterinario'],
					$veterinario['visible'] != 1? "No": "Si"
				));
			}
		}else {
			$pdf->Cell(0,10,"No existen Datos en la Base de Datos Que correspondan a su busqueda.",1,1,'C');
		}
		
		return $pdf->Output();
	}
	
	/******************************************************************
	*	Pertenece: ReportController
	*	Nombre: Bitacora_Usuarios
	*	Función: Mostrar Reporte Usuarios
	*	Entradas: Filtro de busqueda, columna a buscar
	*	Salidas: Reporte de Usuarios
	******************************************************************/
	public function Bitacora_Usuarios(){
		$this->Combrueba();
		
		$objReports = $this->LoadModel("ReportModel");
		$columna = $_POST['Columna'];
		$filtro = isset($_POST['Filtro'])? $_POST['Filtro']:"";
		
		$Usuarios = $objReports->Usuarios($columna, $filtro);
		$TotalUsuarios = $objReports->TotalUsuarios($columna, $filtro);
		
		/*----------Inicio del Documento PDF----------*/
		$pdf = new PDF_MC_Table('L','mm',array(350,200));
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Times','',12);
		
		//Colocar el tamaño de las columnas de las celdas de la tabla (7)
		$pdf->SetWidths(Array(25,35,35,35,45,45,34));
		
		//Colocar la altura de la linea
		$pdf->SetLineHeight(5);
		
		if($Usuarios != false){
			foreach ($Usuarios as $usuario){
				$pdf->Row(Array(
					$usuario['cedula'],
					utf8_decode($usuario['nombre']),
					$usuario['RolNom'],
					utf8_decode($usuario['direccion']),
					utf8_decode($usuario['telefono']),
					utf8_decode($usuario['detalles']),
					$usuario['activo'] != 1? "No": "Si"
				));
			}
		} else {
			$pdf->Cell(0,10,"No existen Datos en la Base de Datos Que correspondan a su busqueda.",1,1,'C');
		}
		
		return $pdf->Output();
	}
	
	/******************************************************************
	*	Pertenece: ReportController
	*	Nombre: Bitacora_Movimientos
	*	Función: Mostrar Reporte Movimientos
	*	Entradas: Filtro de busqueda, columna a buscar, desde, hasta
	*	Salidas: Reporte de Movimientos
	******************************************************************/
	public function Bitacora_Movimientos(){
		$this->Combrueba();
		
		$objReports = $this->LoadModel("ReportModel");
		$columna = $_POST['Columna'];
		$filtro = isset($_POST['Filtro'])? $_POST['Filtro']:"";
		$desde = isset($_POST['Desde'])?$_POST['Desde']:0;
		$hasta = isset($_POST['Hasta'])?$_POST['Hasta']:0;
		
		$Movimientos = $$objReports->Movimientos($columna, $filtro,$desde, $hasta);
		$TotalMovimientos = $objReports->ContadorMovimientos($columna, $filtro,$desde, $hasta);
		
		/*----------Inicio del Documento PDF----------*/
		$pdf = new PDF_MC_Table('L','mm',array(350,200));
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Times','',12);
		
		//Colocar el tamaño de las columnas de las celdas de la tabla (5)
		$pdf->SetWidths(Array(15,35,35,35,35));
		
		///Colocar la altura de la linea
		$pdf->SetLineHeight(5);
		
		if($Movimientos != false){
			foreach ($Movimientos as $movimiento){
				$pdf->Row(Array(
					$movimiento['id_bitacora'],
					utf8_decode($movimiento['usuario_bit']),
					utf8_decode($movimiento['modulo_afectado']),
					utf8_decode($movimiento['accion_realizada']),
					$fecha = date("d-m-Y",strtotime($movimiento['fecha_accion']))
				));
			}
		} else {
			$pdf->Cell(0,10,"No existen Datos en la Base de Datos Que correspondan a su busqueda.",1,1,'C');
		}
		
		return $pdf->Output();
	}
	
	/******************************************************************
	*	Pertenece: ReportController
	*	Nombre: Bitacora_General
	*	Función: Mostrar Reporte General del Sistema
	*	Entradas: Filtro de busqueda, columna a buscar
	*	Salidas: Reporte General
	******************************************************************/
	public function Bitacora_General(){
		$this->Combrueba();
		
		$objReports = $this->LoadModel("ReportModel");
		$columna = $_POST['Columna'];
		$filtro = isset($_POST['Filtro'])? $_POST['Filtro']:"";
		//Creo que lo que manda la pagina de reportes es nada :V porque no hay formulario pero podemos hacerlo
		$Bitacoras = $objReports->Bitacora($columna, $filtro);
		$TotalBitacoras = $objReports->TotalBitacora($columna, $filtro);
		
		/*----------Inicio del Documento PDF----------*/
		$pdf = new PDF_MC_Table('L','mm',array(350,200));
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Times','',12);
		
		//Colocar el tamaño de las columnas de las celdas de la tabla (10)
		$pdf->SetWidths(Array(15,35,20,35,45,35,35,35,35,34));
		
		///Colocar la altura de la linea
		$pdf->SetLineHeight(5);
		
		if($Bitacoras != false){
			foreach ($Bitacoras as $bitacora){
				$pdf->Row(Array(
					$bitacora['id_bitacora'],
					utf8_decode($bitacora['usuario_bit']),
					utf8_decode($bitacora['modulo_afectado']),
					utf8_decode($bitacora['accion_realizada']),
					$fecha = date("d-m-Y",strtotime($bitacora['fecha_accion']))
				));
			}
		} else {
			$pdf->Cell(0,10,"No existen Datos en la Base de Datos Que correspondan a su busqueda.",1,1,'C');
		}
		
		return $pdf->Output();
	}
}
?>