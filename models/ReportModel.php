<?php
class ReportModel extends ConexionBD {
	/*
	http://www.epsilon-eridani.com/cubic/ap/cubic.php/doc/phpDocumentor---documentacion-para-codigo-PHP-246.html
	
	*Modificacion de datos: Saldran las consultas en sucio y todo ello y etc como cuantas modificaciones se hicieron en torno a esto etc, por modulo
	*Animales: Cuantos fueron adoptados en torno a tiempo eso desde hasta
	*Usuarios: Cuantos han ingresado etc, Cuantos han sido bloqueados
	*Veterinarios: Cuantos fueron bloqueados, agregados en rango de fecha
	
	Creo que tambien hay que colocar para buscar los animales adoptados o no adoptados de todos los albergues o mas 
	bien de un albergue especifico ej: alberg polipro todos los animales adoptados
	
	Contadores:
		-Usuarios Bloqueados
		-Veterinarios Bloqueados
		
	Actualizacion no se buscara por edad del animal de pana q me mato si lo hago
	Ademas de q como esta en string seria mas complicado
	o tal vez sea lo mismo
	*/
	
	
	//creo que lo que pide sql es un string no un numero como 2022
	//0 = a todos 
	/*
	SELECT A.CODCLI, A.NOMCLI, COUNT(B.IDNPP) AS TOTALES
FROM MAECLIENTE A WITH(NOLOCK) 
LEFT JOIN COB_DETPROMONOTAS B WITH(NOLOCK) ON A.CODCLI = B.CODCLI
WHERE A.ESTATUS <> 'Bloqueado'
GROUP BY A.CODCLI, A.NOMCLI
El peo es el group by pero meh o no creo simplemente mete todo en group y ya
https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.youtube.com%2Fwatch%3Fv%3DZ47eF35t7E8&psig=AOvVaw1FXJe29om1CIX4CuIYgKq8&ust=1668862475520000&source=images&cd=vfe&ved=0CA4QjhxqFwoTCLjW8eTit_sCFQAAAAAdAAAAABA0
	*/
	//CASE WHEN ISNULL(f.animal_id) THEN 0 ELSE SUM(f.animal_id) END AS TotalAdopciones replanteate esta linea de la forma 
	//anterior podria funcionar ya lo implemente pruebalo
	//definir el desde y hasta en date q se vuelve string pero solo el año aqui
	//$nombre,$anio_nac,$raza, $tamano, $desde, $hasta, $estatus, $albergue
	public function Animales($nombre = "", $anio_nac = "", $raza = 0, $tamano = 0, $desde = "2021-01-01", $hasta = "2022-11-22", $estatus = 0, $albergue = 0, $tipoanimal = 0){
		//estatus serviria para buscar en albergue esos animales adoptados no adoptados o en proceso
		//https://codigoroot.net/blog/obtener-fecha-y-hora-en-php-con-date/#:~:text=Obtener%20fecha%20actual%20php%20con%20formato%20(Dia%2FMes%2FA%C3%B1o)&text=%24fechaActual%20%3D%20date('d%2Fm%2Fy')%3B
		
	$resultados =  $this->ObtenData("SELECT a.id_animal, a.nombre, a.anio_nac, a.img, a.descripcion,
											a.fecha_ingreso, b.nombre as nombreRaza, c.nombre AS nombreTamano,
											d.nombre AS nombreAlbergue, e.nombre AS nombreTipoAnimal,
											a.visible, CASE WHEN f.estado IN ('1','2') OR f.estado IS NULL THEN 'No' ELSE 'Si' END AS EstadoAdop
									FROM animal a
									INNER JOIN raza b 
											ON a.raza_id = b.id_raza
									INNER JOIN tamanio c 
											ON a.tamanio_id = c.id_tamanio
									INNER JOIN albergue d 
											ON a.albergue_id = d.id_albergue
									INNER JOIN tipo_animal e 
											ON b.id_tipo_animal = e.id_tipo
									LEFT JOIN adopcion f 
											ON a.id_animal = f.animal_id
									WHERE 	(
											(a.nombre LIKE CASE WHEN '$nombre' = '' THEN a.nombre ELSE '%$nombre%' END) AND
											(a.anio_nac  = CASE WHEN '$anio_nac' = '' THEN a.anio_nac ELSE '$anio_nac' END) AND 
											(b.id_raza = CASE WHEN '$raza' = 0 THEN b.id_raza ELSE '$raza' END) AND 
											(c.id_tamanio = CASE WHEN '$tamano' = 0 THEN c.id_tamanio ELSE '$tamano' END) AND 
											(a.albergue_id = CASE WHEN '$albergue' = 0 THEN a.albergue_id ELSE '$albergue' END) AND
											(e.id_tipo = CASE WHEN '$tipoanimal' = 0 THEN e.id_tipo ELSE '$tipoanimal' END) AND 
											(CASE WHEN '$estatus' = 0 THEN f.estado IN ('1','2','3') OR f.estado IS NULL ELSE 
											CASE WHEN '$estatus' = 1 THEN f.estado IN ('1','2') OR f.estado IS NULL ELSE f.estado = 3 END END) AND
											(a.fecha_ingreso BETWEEN '$desde' AND '$hasta')
											)
											ORDER BY a.id_animal");
											//Anotacion no aparecer 3 porque esos salen que fueron ingresados el 00-00-0000
		return $resultados;
	}
	//https://es.stackoverflow.com/questions/351356/si-el-select-tiene-valor-negro-ocultar-input
	
	public function TotalAnimales($nombre = "", $anio_nac = "", $raza = 0, $tamano = 0, $desde = "2021-01-01", $hasta = "2022-11-22", $estatus = 0, $albergue = 0, $tipoanimal = 0){
		$resultados = $resultados =  $this->ObtenData("SELECT COUNT(*) AS TotalAnimales
														FROM animal a
														INNER JOIN raza b ON a.raza_id = b.id_raza
														INNER JOIN tamanio c ON a.tamanio_id = c.id_tamanio
														INNER JOIN albergue d ON a.albergue_id = d.id_albergue
														INNER JOIN tipo_animal e ON b.id_tipo_animal = e.id_tipo
														LEFT JOIN adopcion f ON a.id_animal = f.animal_id
														WHERE (
															(a.nombre LIKE CASE WHEN '$nombre' = '' THEN a.nombre ELSE '%$nombre%' END) AND
															(a.anio_nac  = CASE WHEN '$anio_nac' = '' THEN a.anio_nac ELSE '$anio_nac' END) AND 
															(b.id_raza = CASE WHEN '$raza' = 0 THEN b.id_raza ELSE '$raza' END) AND 
															(c.id_tamanio = CASE WHEN '$tamano' = 0 THEN c.id_tamanio ELSE '$tamano' END) AND 
															(a.albergue_id = CASE WHEN '$albergue' = 0 THEN a.albergue_id ELSE '$albergue' END) AND
															(e.id_tipo = CASE WHEN '$tipoanimal' = 0 THEN e.id_tipo ELSE '$tipoanimal' END) AND 
															(CASE WHEN $estatus = 0 THEN f.estado IN ('1','2','3') OR f.estado IS NULL ELSE 
															CASE WHEN '$estatus' = 1 THEN f.estado IN ('1','2') OR f.estado IS NULL ELSE f.estado = 3 END END) AND
															(a.fecha_ingreso BETWEEN '$desde' AND '$hasta')
															)");
									
		return $resultados[0]['TotalAnimales'];
	}
	
	/*
	
	WHERE (A.FECHADEPDESDE BETWEEN  @DESDE AND @HASTA
	 OR A.FECHADEPHASTA BETWEEN @DESDE AND @HASTA OR 
	 (A.FECHADEPDESDE < @DESDE AND A.FECHADEPHASTA > @HASTA))
	 
	public function consultarAnimal($id_animal){
        $id_animal = mysqli_real_escape_string($this->conectar(),$id_animal);
        return $this->obtenData("SELECT a.id_animal, a.nombre, a.anio_nac, a.img, a.descripcion, 
                                    a.fecha_ingreso, a.raza_id, a.tamanio_id, a.albergue_id, a.visible, 
                                    b.id_tipo_animal
                                FROM animal a
                                INNER JOIN raza b ON a.raza_id = b.id_raza
                                WHERE a.id_animal = CASE WHEN '$id_animal' = '' THEN a.id_animal ELSE '$id_animal'END");
    }
	*/
	//creo que este esta de mas si en lo anterior puedo hacerlo no ?
	//esta tiene un error en lo del case del select
	//esta no deberia existir la anterior de animales general ya cumple su proposito
	public function AnimalesAdoptados($nombreAnimal = "", $raza = 0, $tamano = 0, $albergue = 0, $Anio_nac = "", $tipoAnimal = 0, $desde = "2021-01-01", $hasta = "2022-11-26", $estatus = 0){
		return $resultados =  $this->ObtenData("SELECT a.id_adopcion, b.nombre AS nombreAnimal, d.nombre AS nombreUsuario, c.nombre AS razaNombre,
													   e.nombre AS nombreTamano, g.nombre AS nombreAlbergue, f.nombre AS TipoAnimal, h.nombre_estado AS estadoAdopcion,
													   a.fecha_adopcion, b.anio_nac
												FROM adopcion a
												INNER JOIN animal b ON a.animal_id = b.id_animal
												INNER JOIN raza c ON b.raza_id = c.id_raza
												INNER JOIN usuarios d ON a.cedula_usuario = d.cedula
												INNER JOIN tamanio e ON b.tamanio_id = e.id_tamanio
												INNER JOIN tipo_animal f ON c.id_tipo_animal = f.id_tipo
												INNER JOIN albergue g ON b.albergue_id = g.id_albergue
												INNER JOIN tipo_estado_adopcion h ON a.estado = h.id_tipo_estado
												WHERE (
														(b.nombre LIKE CASE WHEN '$nombreAnimal' = '' THEN b.nombre ELSE '%$nombreAnimal%' END) AND
														(a.fecha_adopcion BETWEEN '$desde' AND '$hasta') AND 
														(b.raza_id = CASE WHEN '$raza' = 0 THEN b.raza_id ELSE '$raza' END) AND 
														(e.id_tamanio = CASE WHEN '$tamano' = 0 THEN e.id_tamanio ELSE '$tamano' END) AND 
														(b.albergue_id = CASE WHEN '$albergue' = 0 THEN b.albergue_id ELSE '$albergue' END) AND
														(b.anio_nac = CASE WHEN '$Anio_nac' = '' THEN b.anio_nac ELSE '$Anio_nac' END) AND
														(c.id_tipo_animal = CASE WHEN '$tipoAnimal' = 0 THEN c.id_tipo_animal ELSE '$tipoAnimal' END) AND
														(CASE WHEN $estatus = 0 THEN a.estado IN ('1','2','3') OR a.estado IS NULL ELSE 
															CASE WHEN '$estatus' = 1 THEN a.estado IN ('1','2') OR a.estado IS NULL ELSE a.estado = 3 END END)
													  )");
	}

	public function TotalesAdopciones($nombreAnimal = "", $raza = 0, $tamano = 0, $albergue = 0, $Anio_nac = "", $tipoAnimal = 0, $desde = "2021-01-01", $hasta = "2022-11-22", $estatus = 0){
		return $resultados =  $this->ObtenData("SELECT COUNT(*) AS TotalAdoptados
												FROM adopcion a
												INNER JOIN animal b ON a.animal_id = b.id_animal
												INNER JOIN raza c ON b.raza_id = c.id_raza
												INNER JOIN usuarios d ON a.cedula_usuario = d.cedula
												INNER JOIN tamanio e ON b.tamanio_id = e.id_tamanio
												INNER JOIN tipo_animal f ON c.id_tipo_animal = f.id_tipo
												INNER JOIN albergue g ON b.albergue_id = g.id_albergue
												INNER JOIN tipo_estado_adopcion h ON a.estado = h.id_tipo_estado
												WHERE (
														(b.nombre LIKE CASE WHEN '$nombreAnimal' = '' THEN b.nombre ELSE '%$nombreAnimal%' END) AND
														(a.fecha_adopcion BETWEEN '$desde' AND '$hasta') AND 
														(b.raza_id = CASE WHEN '$raza' = 0 THEN b.raza_id ELSE '$raza' END) AND 
														(e.id_tamanio = CASE WHEN '$tamano' = 0 THEN e.id_tamanio ELSE '$tamano' END) AND 
														(b.albergue_id = CASE WHEN '$albergue' = 0 THEN b.albergue_id ELSE '$albergue' END) AND
														(b.anio_nac = CASE WHEN '$Anio_nac' = '' THEN b.anio_nac ELSE '$Anio_nac' END) AND
														(c.id_tipo_animal = CASE WHEN '$tipoAnimal' = 0 THEN c.id_tipo_animal ELSE '$tipoAnimal' END) AND
														(CASE WHEN $estatus = 0 THEN a.estado IN ('1','2','3') OR a.estado IS NULL ELSE 
														CASE WHEN '$estatus' = 1 THEN a.estado IN ('1','2') OR a.estado IS NULL ELSE a.estado = 3 END END)
													  )");
	}
	
	public function TotalesAdopcionesCanceladas($nombreAnimal = "", $raza = 0, $tamano = 0, $albergue = 0, $Anio_nac = "", $tipoAnimal = 0, $desde = "2021-01-01", $hasta = "2022-11-22"){
		return $resultados =  $this->ObtenData("SELECT COUNT(*) AS TotalAdoptados
												FROM adopcion a
												INNER JOIN animal b ON a.animal_id = b.id_animal
												INNER JOIN raza c ON b.raza_id = c.id_raza
												INNER JOIN usuarios d ON a.cedula_usuario = d.cedula
												INNER JOIN tamanio e ON b.tamanio_id = e.id_tamanio
												INNER JOIN tipo_animal f ON c.id_tipo_animal = f.id_tipo
												INNER JOIN albergue g ON b.albergue_id = g.id_albergue
												INNER JOIN tipo_estado_adopcion h ON a.estado = h.id_tipo_estado
												WHERE (
														(b.nombre LIKE CASE WHEN '$nombreAnimal' = '' THEN b.nombre ELSE '%$nombreAnimal%' END) AND
														(a.fecha_adopcion BETWEEN '$desde' AND '$hasta') AND 
														(b.raza_id = CASE WHEN '$raza' = 0 THEN b.raza_id ELSE '$raza' END) AND 
														(e.id_tamanio = CASE WHEN '$tamano' = 0 THEN e.id_tamanio ELSE '$tamano' END) AND 
														(b.albergue_id = CASE WHEN '$albergue' = 0 THEN b.albergue_id ELSE '$albergue' END) AND
														(b.anio_nac = CASE WHEN '$Anio_nac' = '' THEN b.anio_nac ELSE '$Anio_nac' END) AND
														(c.id_tipo_animal = CASE WHEN '$tipoAnimal' = 0 THEN c.id_tipo_animal ELSE '$tipoAnimal' END) AND
														(a.estado = 2)
													  )");
	}

	public function Usuarios($cedula = "", $nombre = "", $roles = 0, $activos = 2){//deberias hacerle unos inners
		return $this->ObtenData("SELECT cedula, a.nombre, b.nombre AS RolNom, direccion, activo, telefono, detalles
								FROM usuarios a
								INNER JOIN rol b ON a.rol_id = b.id_rol
								WHERE(
										(cedula LIKE CASE WHEN '$cedula' = '' THEN cedula ELSE '%$cedula%' END) AND 
										(a.nombre LIKE CASE WHEN '$nombre' = '' THEN a.nombre ELSE '%$nombre%' END) AND 
										(rol_id = CASE WHEN '$roles' = 0 THEN rol_id ELSE '$roles' END) AND 
										(activo = CASE WHEN '$activos' = 2 THEN activo ELSE '$activos' END)
									)
									ORDER BY activo DESC");//Se le puede agregar otra funcionalidad de fecha para saber en fecha determinada algo
	}
	
	public function TotalUsuarios($cedula = "", $nombre = "", $roles = 0, $activos = 2){
		return $this->ObtenData("SELECT COUNT(*) AS TotalUsuarios
									FROM usuarios a
									WHERE(
											(cedula LIKE CASE WHEN '$cedula' = '' THEN cedula ELSE '%$cedula%' END) AND 
											(a.nombre LIKE CASE WHEN '$nombre' = '' THEN a.nombre ELSE '%$nombre%' END) AND 
											(rol_id = CASE WHEN '$roles' = 0 THEN rol_id ELSE '$roles' END) AND 
											(activo = CASE WHEN '$activos' = 2 THEN activo ELSE '$activos' END)
										)");
	}
	
	public function Albergues($nombre = "", $UsuarioProp = "", $activo = 2) {
	return $this->ObtenData("SELECT id_albergue, nombre, direccion, cedula_usuario, activo
					FROM albergue
					WHERE(
							(nombre LIKE CASE WHEN '$nombre' = '' THEN nombre ELSE '%$nombre%' END) AND 
							(cedula_usuario LIKE CASE WHEN '$UsuarioProp' = '' THEN cedula_usuario ELSE '%$UsuarioProp%' END) AND
							(activo = CASE WHEN '$activo' = 2 THEN activo ELSE '$activo' END)
						 )");
	}

	public function TotalAlbergues($nombre = "", $UsuarioProp = "", $activo = 2) {
		return $this->ObtenData("SELECT COUNT(*) AS totalalbergues
						FROM albergue
						WHERE(
							(nombre LIKE CASE WHEN '$nombre' = '' THEN nombre ELSE '%$nombre%' END) AND 
							(cedula_usuario LIKE CASE WHEN '$UsuarioProp' = '' THEN cedula_usuario ELSE '%$UsuarioProp%' END) AND
							(activo = CASE WHEN '$activo' = 2 THEN activo ELSE '$activo' END)
							 )");
	}
	//supongo que sera una consulta sobre logins y registers
	//creo que esto se puede ampliar a INSERTS Y UPDATES
	public function Movimientos($columna, $filtro, $desde, $hasta, $accion){
		return $this->ObtenData("SELECT id_bitacora, usuario_bit, modulo_afectado, accion_realizada, fecha_accion
						FROM bitacoras
						WHERE(
								($columna = 0 AND id_bitacora = CASE WHEN '$filtro' = '' THEN id_bitacora ELSE '$filtro' END) OR
								($columna = 1 AND usuario_bit = CASE WHEN '$filtro' = '' THEN usuario_bit ELSE '$filtro' END) OR
								($columna = 2 AND modulo_afectado = '$filtro') OR 
								($columna = 3 AND accion_realizada = CASE WHEN '$accion' = 'Todos' THEN accion_realizada ELSE '$accion' END) OR
								($columna = 4 AND fecha_accion BETWEEN '$desde' AND '$hasta')
							 )
							 AND (modulo_afectado = 'Usuario Logueandose' OR modulo_afectado = 'Cerrar Sesion')");
		
	}
	
	public function ContadorMovimientos($columna, $filtro, $desde, $hasta, $usuario = "", $accion){
		return $this->ObtenData("SELECT COUNT(*) AS TotalMovimientos
						FROM bitacoras
						WHERE(
								($columna = 0 AND id_bitacora = CASE WHEN '$filtro' = '' THEN id_bitacora ELSE '$filtro' END) OR
								($columna = 1 AND usuario_bit =CASE WHEN '$filtro' = '' THEN usuario_bit ELSE '$filtro' END) OR
								($columna = 2 AND modulo_afectado = '$filtro' AND usuario_bit = CASE WHEN '$usuario' = '' THEN usuario_bit ELSE '$usuario' END) OR 
								($columna = 3 AND accion_realizada = CASE WHEN '$accion' = 'Todos' THEN accion_realizada ELSE '$accion' END) OR
								($columna = 4 AND fecha_accion BETWEEN '$desde' AND '$hasta')
							 ) 
							 AND (modulo_afectado = 'Usuario Logueandose' OR modulo_afectado = 'Cerrar Sesion')");
	}
	
	//esto podria ser por Accion, si fue un UPDATE o un INSERT
	//ademas creo q hay que castear eso como DATE
	public function Bitacora($usuario = "", $modulo = "", $accion = "", $desde = "", $hasta = ""){
		return $this->ObtenData("SELECT id_bitacora, usuario_bit, modulo_afectado, accion_realizada, valor_anterior, valor_actual,fecha_accion
						FROM bitacoras
						WHERE(
								(usuario_bit LIKE CASE WHEN '$usuario' = '' THEN usuario_bit ELSE '%$usuario%' END) AND
								(modulo_afectado LIKE '%$modulo%') AND 
								(accion_realizada LIKE CASE WHEN '$accion' = 'Todos' THEN accion_realizada ELSE '%$accion%' END) AND
								(fecha_accion BETWEEN '$desde' AND '$hasta')
							 )");
	}
	
	public function TotalBitacora($usuario = "", $modulo = "", $accion = "", $desde = "", $hasta = ""){
		return $this->ObtenData("SELECT COUNT(*) AS totalBitacora
						FROM bitacoras
						WHERE(
								(usuario_bit LIKE CASE WHEN '$usuario' = '' THEN usuario_bit ELSE '%$usuario%' END) AND
								(modulo_afectado LIKE '%$modulo%') AND 
								(accion_realizada LIKE CASE WHEN '$accion' = 'Todos' THEN accion_realizada ELSE '%$accion%' END) AND
								(fecha_accion BETWEEN '$desde' AND '$hasta')
							 )");
	}
	//las columnas son basicamente el select que va a tener el buscar reporte veterinario
	//no especificamos en que direccion tiene asi que sera dificil hacerle un buscar
	public function Veterinarios($nombre = "",$visibilidad = 3, $usuarioRegistro = ""){
		return $this->ObtenData("SELECT id_veterinario, nombre, tlf, direccion, img, visible, usuario_Rveterinario
								FROM veterinario
								WHERE (
										(nombre LIKE '%$nombre%') AND
										(visible = CASE WHEN '$visibilidad' = 3 THEN visible ELSE '$visibilidad' END) AND 
										(usuario_Rveterinario LIKE CASE WHEN '$usuarioRegistro' = '' THEN usuario_Rveterinario ELSE '%$usuarioRegistro%' END)
									)");
	}
	//me parecio muy tonto buscar a un veterinario por su tlf 
	//Linea borrada ($columna = 2 AND tlf = CASE WHEN '$filtro' = '' THEN tlf ELSE '$filtro' END) OR Fecha: 16/11/2022
	public function TotalVeterinarios($nombre = "",$visibilidad = 3, $usuarioRegistro = ""){
		$resultados = $this->ObtenData("SELECT COUNT(*) AS TotalVeterinarios
										FROM veterinario
										WHERE (
											(nombre LIKE '%$nombre%') AND
											(visible = CASE WHEN '$visibilidad' = 3 THEN visible ELSE '$visibilidad' END) AND 
											(usuario_Rveterinario LIKE CASE WHEN '$usuarioRegistro' = '' THEN usuario_Rveterinario ELSE '%$usuarioRegistro%' END)
											)");
		return $resultados [0]['TotalVeterinarios'];
	}
	
}
?>