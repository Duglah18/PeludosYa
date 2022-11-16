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

*/
class AdminController extends GeneralController{

	public function Bitacora_Animales(){
		$objReports = $this->LoadModel("ReportModel");
		$columna = $_POST['Columna'];
		$filtro = isset($_POST['Filtro'])? $_POST['Filtro']:"";
		$desde = isset($_POST['Desde'])?$_POST['Desde']:0;
		$hasta = isset($_POST['Hasta'])?$_POST['Hasta']:0;
		$estatus = 0;
		
		$objReports->Animales($columna, $filtro,$desde, $hasta, $estatus);
		$objReports->TotalAnimales($columna, $filtro,$desde, $hasta, $estatus);
		return 0;
	}
	
	public function Bitacora_Veterinarios(){
		$objReports = $this->LoadModel("ReportModel");
		$columna = $_POST['Columna'];
		$filtro = isset($_POST['Filtro'])? $_POST['Filtro']:"";
		$objReports->Veterinarios($columna,$filtro);
		$objReports->TotalVeterinarios($columna,$filtro);
		return 0;
	}

	public function Bitacora_Usuarios(){
		$objReports = $this->LoadModel("ReportModel");
		$columna = $_POST['Columna'];
		$filtro = isset($_POST['Filtro'])? $_POST['Filtro']:"";
		
		$objReports->Usuarios($columna, $filtro);
		$objReports->TotalUsuarios($columna, $filtro);
		return 0;
	}
	
	public function Bitacora_Movimientos(){
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