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
			$_SESSION['Error'] = "Usted no posee el nivel suficiente para entrar aquí";
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
	
		$objReports = $this->LoadModel("ReportModel");

		$nombre = isset($_POST['NombreAnimal'])? $_POST['NombreAnimal']:"";
		$anio_nac = isset($_POST['Ano_nac'])? $_POST['Ano_nac']: "";
		$raza = isset($_POST['raza'])?$_POST['raza']:0;
		$tamano = isset($_POST['tamano'])?$_POST['tamano']:0;
		$desde = isset($_POST['Desde'])?$_POST['Desde']: date('Y-m-d');
		$hasta = isset($_POST['Hasta'])?$_POST['Hasta']: date('Y-m-d');
		$estatus = isset($_POST['estatus'])?$_POST['estatus']:0;
		$albergue = isset($_POST['albergue'])?$_POST['albergue']:0;
		$tipoanimal = isset($_POST['tipoanimal'])?$_POST['tipoanimal']:0;
		$animales = $objReports->Animales($nombre,$anio_nac,$raza, $tamano, $desde, $hasta, $estatus, $albergue, $tipoanimal);
		$numTotalAnimales = $objReports->TotalAnimales($nombre,$anio_nac,$raza, $tamano, $desde, $hasta, $estatus, $albergue, $tipoanimal);
		//$TotalAdoptados = $objReports->TotalAnimales(9,3);//modificar
		//$adopcionescanceladas = $objReports->TotalesAdopciones(2);//modificar

		$_SESSION['numtotAnimales'] = $numTotalAnimales;
		// $_SESSION['TotAdop'] = $TotalAdoptados;
		// $_SESSION['AdopCanc'] = $adopcionescanceladas[0][0];

		/*----------Inicio del Documento PDF----------*/
		$pdf = new PDF_MC_Table('L','mm',array(350,200));
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Times','',12);

		// $pdf->Cell(0,10,$nombre. " ".$anio_nac. " ".$raza. " ".$tamano. " ".$desde. " ".$hasta. " ".$estatus. " ".$albergue. " ".$tipoanimal,1,50);
		//Colocar el tamaño de las columnas de las celdas de la tabla (10)
		$pdf->SetWidths(Array(15,40,20,55,30,35,30,20,50,35));
		
		//Colocar la altura de la linea
		$pdf->SetLineHeight(5);
		if($animales != false){
			foreach ($animales as $animal){
				$pdf->Row(Array(
					$animal['id_animal'],
					utf8_decode($animal['nombre']),
					$animal['anio_nac'],
					//utf8_decode($animal['img']),
					utf8_decode($animal['descripcion']),
					$animal['EstadoAdop'],
					$animal['fecha_ingreso'] = date("d-m-Y",strtotime($animal['fecha_ingreso'])),
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

		$nombre = isset($_POST['nombre'])? $_POST['nombre']:"";
		$visibilidad = isset($_POST['Visible'])?$_POST['Visible']:3;
		$usuarioRegistro = isset($_POST['admin'])? $_POST['admin']:"";

		$veterinarios = $objReports->Veterinarios($nombre, $visibilidad, $usuarioRegistro);
		$totalVeterinarios = $objReports->TotalVeterinarios($nombre, $visibilidad, $usuarioRegistro);
		$_SESSION['TotVeter'] = $totalVeterinarios;
		/*----------Inicio del Documento PDF----------*/
		$pdf = new PDF_MC_Table('L','mm',array(350,200));
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Times','',12);
		
		//Colocar el tamaño de las columnas de las celdas de la tabla (7)
		$pdf->SetWidths(Array(30,65,45,65,65,60));
		
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

		$cedula = isset($_POST['cedula'])? $_POST['cedula']:"";
		$nombre = isset($_POST['nombre'])? $_POST['nombre']:"";
		$rol = isset($_POST['busquedaRol'])? $_POST['busquedaRol']: 0;
		$activos = isset($_POST['busquedaAct'])? $_POST['busquedaAct']: 2;

		$Usuarios = $objReports->Usuarios($cedula, $nombre, $rol,$activos);
		$TotalUsuarios = $objReports->TotalUsuarios($cedula, $nombre, $rol,$activos);
		$_SESSION['Num'] = $TotalUsuarios[0]['TotalUsuarios'];

		/*----------Inicio del Documento PDF----------*/
		$pdf = new PDF_MC_Table('L','mm',array(350,200));
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Times','',12);
		
		//Colocar el tamaño de las columnas de las celdas de la tabla (7)
		$pdf->SetWidths(Array(35,60,35,60,45,55,40));
		
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

		$usuarioMov = isset($_POST['usuario'])? $_POST['usuario']: "";
		$modulo = isset($_POST['modulo'])? $_POST['modulo']: "";
		$accion = isset($_POST['accion'])? $_POST['accion']: "";
		$desde = isset($_POST['Desde'])?$_POST['Desde']:date('Y-m-d');
		$hasta = isset($_POST['Hasta'])?$_POST['Hasta']:date('Y-m-d');
		
		$Movimientos = $objReports->Movimientos($usuarioMov, $modulo, $accion,$desde, $hasta);
		$TotalMovimientos = $objReports->ContadorMovimientos($usuarioMov, $modulo, $accion,$desde, $hasta);
		$TotalCierres = $objReports->ContadorMovimientos("",'Cerrar Sesion', "", $accion,$desde, $hasta);
		$TotalLogins = $objReports->ContadorMovimientos("",'Usuario Logueandose', "", $accion,$desde, $hasta);

		$_SESSION['num'] = $TotalMovimientos[0]['TotalMovimientos'];
		$_SESSION['closes'] = $TotalCierres[0]['TotalMovimientos'];
		$_SESSION['logins'] = $TotalLogins[0]['TotalMovimientos'];
		/*----------Inicio del Documento PDF----------*/
		$pdf = new PDF_MC_Table('L','mm',array(350,200));
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Times','',12);
		
		//Colocar el tamaño de las columnas de las celdas de la tabla (5)
		$pdf->SetWidths(Array(35,50,60,75,45));
		
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
			$pdf->Cell(0,10,"No existen Datos en la Base de Datos Que correspondan a su busqueda. ",1,1,'C');
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
		$usuarioMov = isset($_POST['usuario'])? $_POST['usuario']: "";
		$modulo = isset($_POST['modulo'])? $_POST['modulo']: "";
		$accion = isset($_POST['accion'])? $_POST['accion']: "";
		$desde = isset($_POST['Desde'])?$_POST['Desde']:date('Y-m-d');
		$hasta = isset($_POST['Hasta'])?$_POST['Hasta']:date('Y-m-d');
		
		//Creo que lo que manda la pagina de reportes es nada :V porque no hay formulario pero podemos hacerlo
		$Bitacoras = $objReports->Bitacora($usuarioMov, $modulo, $accion,$desde, $hasta);
		$TotalBitacoras = $objReports->TotalBitacora($usuarioMov, $modulo, $accion,$desde, $hasta);
		$_SESSION['num'] = $TotalBitacoras[0]['totalBitacora'];
		/*----------Inicio del Documento PDF----------*/
		$pdf = new PDF_MC_Table('L','mm',array(350,200));
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Times','',12);
		
		//Colocar el tamaño de las columnas de las celdas de la tabla (10)
		$pdf->SetWidths(Array(30,35,45,70,55,55,40));
		
		///Colocar la altura de la linea
		$pdf->SetLineHeight(5);
		
		if($Bitacoras != false){
			foreach ($Bitacoras as $bitacora){
				$pdf->Row(Array(
					$bitacora['id_bitacora'],
					utf8_decode($bitacora['usuario_bit']),
					utf8_decode($bitacora['modulo_afectado']),
					utf8_decode($bitacora['accion_realizada']),
					utf8_decode($bitacora['valor_anterior']),
					utf8_decode($bitacora['valor_actual']),
					$fecha = date("d-m-Y",strtotime($bitacora['fecha_accion']))
				));
			}
		} else {
			$pdf->Cell(0,10,"No existen Datos en la Base de Datos Que correspondan a su busqueda.",1,1,'C');
		}
		
		return $pdf->Output();
	}

	/******************************************************************
	*	Pertenece: ReportController
	*	Nombre: Bitacora_Albergues
	*	Función: Mostrar Reporte General del Sistema
	*	Entradas: Filtro de busqueda, columna a buscar
	*	Salidas: Reporte General
	******************************************************************/
	public function Bitacora_Albergues(){
		$this->Combrueba();
		
		$objReports = $this->LoadModel("ReportModel");

		$nombre = isset($_POST['nombre'])? $_POST['nombre']:"";
		$rifpropietario = isset($_POST['cedulaUser'])? $_POST['cedulaUser']:"";
		$activo = isset($_POST['Activo'])? $_POST['Activo']:2;
		
		//Creo que lo que manda la pagina de reportes es nada :V porque no hay formulario pero podemos hacerlo
		$Albergues = $objReports->Albergues($nombre, $rifpropietario, $activo);
		$TotalAlbergues = $objReports->TotalAlbergues($nombre, $rifpropietario, $activo);
		$_SESSION['num'] = $TotalAlbergues[0]['totalalbergues'];
		/*----------Inicio del Documento PDF----------*/
		$pdf = new PDF_MC_Table('L','mm',array(350,200));
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Times','',12);
		
		//Colocar el tamaño de las columnas de las celdas de la tabla (10)
		$pdf->SetWidths(Array(35,70,70,75,45));
		
		///Colocar la altura de la linea
		$pdf->SetLineHeight(5);
		
		if($Albergues != false){
			foreach ($Albergues as $albergue){
				$pdf->Row(Array(
					$albergue['id_albergue'],
					utf8_decode($albergue['nombre']),
					utf8_decode($albergue['direccion']),
					utf8_decode($albergue['cedula_usuario']),
					utf8_decode($albergue['activo'] = 1? "Si": "No")
				));
			}
		} else {
			$pdf->Cell(0,10,"No existen Datos en la Base de Datos Que correspondan a su busqueda.",1,1,'C');
		}
		
		return $pdf->Output();
	}
}
?>
