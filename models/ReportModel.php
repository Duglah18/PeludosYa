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
	public function Animales($columna = 0, $filtro = "", $desde = "2022", $hasta = "2022", $estatus = 0){
		//estatus serviria para buscar en albergue esos animales adoptados no adoptados o en proceso
		//https://codigoroot.net/blog/obtener-fecha-y-hora-en-php-con-date/#:~:text=Obtener%20fecha%20actual%20php%20con%20formato%20(Dia%2FMes%2FA%C3%B1o)&text=%24fechaActual%20%3D%20date('d%2Fm%2Fy')%3B
		
	$resultados =  $this->ObtenData("SELECT a.id_animal, a.nombre, a.anio_nac, a.img, a.descripcion,
							a.fecha_ingreso, b.nombre as nombreRaza, c.nombre AS nombreTamano,
							d.nombre AS nombreAlbergue, e.nombre AS nombreTipoAnimal,
							COUNT(f.animal_id) AS totalAdopciones, a.visible
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
					WHERE (
							($columna = 0 AND a.id_animal = CASE WHEN '$filtro' = '' THEN a.id_animal ELSE '$filtro' END) OR 
							($columna = 1 AND a.nombre LIKE '$filtro' + '%') OR
							($columna = 2 AND a.anio_nac BETWEEN '$desde' AND '$hasta') OR 
							($columna = 3 AND a.fecha_ingreso BETWEEN '$desde' AND '$hasta') OR 
							($columna = 4 AND b.id_raza = CASE WHEN '$filtro' = 0 THEN b.id_raza ELSE '$filtro' END) OR 
							($columna = 5 AND c.id_tamanio = CASE WHEN '$filtro' = 0 THEN c.id_tamanio ELSE '$filtro' END) OR
							($columna = 6 AND a.albergue_id = CASE WHEN '$filtro' = 0 THEN a.albergue_id ELSE '$filtro' END AND f.estado = CASE WHEN $estatus = 0 THEN f.estado ELSE $estatus END) OR
							($columna = 7 AND d.nombre LIKE '$filtro' + '%') OR
							($columna = 8 AND  e.id_tipo = '$filtro')
							)
					GROUP BY a.id_animal, a.nombre, a.anio_nac, a.img, a.descripcion,
					a.fecha_ingreso, b.nombre, c.nombre,
					d.nombre, e.nombre");//Estas buscando menores numeros de adopcion que estas ingresando o cuantos?
		return $resultados;//Se podria colocar un and como en los ejemplos
	}// OR ($columna = 9 AND COUNT(f.animal_id) AS totalAdopciones  < '$filtro')Problema
	//https://es.stackoverflow.com/questions/351356/si-el-select-tiene-valor-negro-ocultar-input
	
	public function TotalAnimales($columna, $filtro, $desde = 2022, $hasta = 2022){
		$resultados = $resultados =  $this->ObtenData("SELECT a.id_animal, a.nombre, a.anio_nac, a.img, a.descripcion,
															a.fecha_ingreso, b.nombre as nombreRaza, c.nombre AS nombreTamano,
															d.nombre AS nombreAlbergue, e.nombre AS nombreTipoAnimal,
															COUNT(f.animal_id) AS totalAdopciones
														FROM animal a
														INNER JOIN raza b ON a.raza_id = b.id_raza
														INNER JOIN tamanio c ON a.tamanio_id = c.id_tamanio
														INNER JOIN albergue d ON a.albergue_id = d.id_albergue
														INNER JOIN tipo_animal e ON b.id_tipo_animal = e.id_tipo
														LEFT JOIN adopcion f ON a.id_animal = f.animal_id
														WHERE (
																($columna = 0 AND a.id_animal = CASE WHEN '$filtro' = '' THEN a.id_animal ELSE '$filtro' END) OR 
																($columna = 1 AND a.nombre LIKE '$filtro' + '%') OR
																($columna = 2 AND a.anio_nac BETWEEN '$desde' AND '$hasta') OR 
																($columna = 3 AND a.fecha_ingreso BETWEEN '$desde' AND '$hasta') OR 
																($columna = 4 AND b.raza_id = CASE WHEN '$filtro' = 0 THEN b.raza_id ELSE '$filtro' END) OR --Raza--Aca se implementa un combobox si se puede si no ps vere
																($columna = 5 AND c.id_tamanio = CASE WHEN '$filtro' = 0 THEN c.id_tamanio ELSE '$filtro' END) OR --Tamanio
																($columna = 6 AND a.albergue_id = CASE WHEN '$filtro' = 0 THEN a.albergue_id ELSE '$filtro' END) OR --Albergue podria ser codigo --si saliera un cmb podria sacarle una consulta
																($columna = 7 AND d.nombre LIKE '$filtro' + '%') OR --Albergue nombre
																($columna = 8 AND  e.id_tipo = '$filtro') OR --Tipo Animal
																(($columna = 9 AND totalAdopciones  < '$filtro') --Numero de adopciones
															  )
														GROUP BY a.id_animal, a.nombre, a.anio_nac, a.img, a.descripcion,
														a.fecha_ingreso, b.nombre, c.nombre,
														d.nombre, e.nombre");
									
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
	public function AnimalesAdoptados($columna, $filtro, $desde = 2022, $hasta = 2022, $estatus = 0){
		return $resultados =  $this->ObtenData("SELECT a.id_animal, a.nombre, a.anio_nac, a.img, a.descripcion,
														a.fecha_ingreso, b.nombre as nombreRaza, c.nombre AS nombreTamano,
														d.nombre AS nombreAlbergue, e.nombre AS nombreTipoAnimal,
														CASE WHEN ISNULL(f.animal_id) THEN 0 ELSE SUM(f.animal_id) END AS TotalAdopciones
												FROM animal a
												INNER JOIN raza b ON a.raza_id = b.id_raza
												INNER JOIN tamanio c ON a.tamanio_id = c.id_tamanio
												INNER JOIN albergue d ON a.albergue_id = d.id_albergue
												INNER JOIN tipo_animal e ON b.id_tipo_animal = e.id_tipo
												INNER JOIN adopcion f ON a.id_animal = f.animal_id
												WHERE (
														($columna = 0 AND a.id_animal = CASE WHEN '$filtro' = '' THEN a.id_animal ELSE '$filtro' END) OR 
														($columna = 1 AND a.nombre LIKE '$filtro' + '%') OR
														($columna = 2 AND a.anio_nac BETWEEN $desde AND $hasta) OR 
														($columna = 3 AND a.fecha_ingreso BETWEEN $desde AND $hasta) OR 
														($columna = 4 AND b.raza_id = CASE WHEN $filtro = 0 THEN b.raza_id ELSE $filtro END) OR --Raza--Aca se implementa un combobox si se puede si no ps vere
														($columna = 5 AND c.id_tamanio = CASE WHEN $filtro = 0 THEN c.id_tamanio ELSE $filtro END) OR --Tamanio
														($columna = 6 AND a.albergue_id = CASE WHEN $filtro = 0 THEN a.albergue_id ELSE $filtro END) OR --Albergue podria ser codigo --si saliera un cmb podria sacarle una consulta
														($columna = 7 AND d.nombre LIKE '$filtro' + '%') OR --Albergue nombre
														($columna = 8 AND e.id_tipo = '$filtro')--Tipo Animal
													  )");
	}
	
	public function Usuarios($columna, $filtro){//deberias hacerle unos inners
		return $this->ObtenData("SELECT cedula, nombre, b.nombre AS RolNom, direccion, activo, telefono, detalles
								FROM usuarios a
								INNER JOIN rol b ON a.rol_id = b.id_rol
								WHERE(
										($columna = 0 AND cedula = CASE WHEN '$filtro' = '' THEN cedula ELSE '$filtro' END ) OR 
										($columna = 1 AND nombre LIKE '$filtro' + %) OR 
										($columna = 2 AND rol_id = '$filtro') OR 
										($columna = 3 AND activo = '$filtro')
									)");//Se le puede agregar otra funcionalidad de fecha para saber en fecha determinada algo
	}
	
	public function TotalUsuarios($columna, $filtro){
		return $this->ObtenData("SELECT COUNT(*) AS TotalUsuarios
						FROM usuarios
						WHERE(
								($columna = 0 AND cedula = CASE WHEN '$filtro' = '' THEN cedula ELSE '$filtro' END ) OR 
								($columna = 1 AND nombre LIKE '$filtro' + %) OR 
								($columna = 2 AND rol_id = '$filtro') OR 
								($columna = 3 AND activo = '$filtro')
							)");
	}
	
	public function Albergues($columna, $filtro) {
	return $this->ObtenData("SELECT id_albergue, nombre, direccion, cedula_usuario, activo
					FROM albergue
					WHERE(
							($columna = 0 AND id_albergue = CASE WHEN '$filtro' = '' THEN id_albergue ELSE '$filtro' END) OR
							($columna = 1 AND nombre LIKE '$filtro' + '%') OR 
							($columna = 2 AND cedula_usuaurio CASE WHEN '$filtro' = '' THEN cedula_usuario ELSE '$filtro') OR
							($columna = 3 AND activo = CASE WHEN '$filtro' = '' THEN activo ELSE '$filtro' END)
						 )");
	}
	//supongo que sera una consulta sobre logins y registers
	//creo que esto se puede ampliar a INSERTS Y UPDATES
	public function Movimientos($columna, $filtro, $desde, $hasta){
		return $this->ObtenData("SELECT id_bitacora, usuario_bit, modulo_afectado, accion_realizada, fecha_accion
						FROM bitacoras
						WHERE(
								($columna = 0 AND id_bitacora = CASE WHEN '$filtro' = '' THEN id_bitacora ELSE '$filtro' END) OR
								($columna = 1 AND usuario_bit =CASE WHEN '$filtro' = '' THEN usuario_bit ELSE '$filtro' END) OR
								($columna = 2 AND modulo_afectado = '$filtro') OR 
								($columna = 3 AND accion_realizada = '$filtro') OR
								($columna = 4 AND fecha_accion BETWEEN $desde, $hasta)
							 ) 
							 AND (modulo_afectado = 'Usuario Logueandose' OR modulo_afectado = 'Cerrar Sesion')");
		
	}
	
	public function ContadorMovimientos($columna, $filtro, $desde, $hasta){
		return $this->ObtenData("SELECT COUNT(*) AS TotalMovimientos
						FROM bitacoras
						WHERE(
								($columna = 0 AND id_bitacora = CASE WHEN '$filtro' = '' THEN id_bitacora ELSE '$filtro' END) OR
								($columna = 1 AND usuario_bit =CASE WHEN '$filtro' = '' THEN usuario_bit ELSE '$filtro' END) OR
								($columna = 2 AND modulo_afectado = '$filtro') OR 
								($columna = 3 AND accion_realizada = '$filtro') OR
								($columna = 4 AND fecha_accion BETWEEN '$desde' AND '$hasta')
							 ) 
							 AND (modulo_afectado = 'Usuario Logueandose' OR modulo_afectado = 'Cerrar Sesion')");
	}
	
	//esto podria ser por Accion, si fue un UPDATE o un INSERT
	//ademas creo q hay que castear eso como DATE
	public function Bitacora($columna, $filtro, $desde = "", $hasta = ""){
		return $this->ObtenData("SELECT id_bitacora, usuario_bit, modulo_afectado, accion_realizada, fecha_accion
						FROM bitacoras
						WHERE(
								($columna = 0 AND id_bitacora = CASE WHEN '$filtro' = '' THEN id_bitacora ELSE '$filtro' END) OR
								($columna = 1 AND usuario_bit =CASE WHEN '$filtro' = '' THEN usuario_bit ELSE '$filtro' END) OR
								($columna = 2 AND modulo_afectado = '$filtro') OR 
								($columna = 3 AND accion_realizada = '$filtro') OR
								($columna = 4 AND fecha_accion BETWEEN '$desde' AND '$hasta')
							 )");
	}
	
	public function TotalBitacora($columna, $filtro, $desde, $hasta){
		return $this->ObtenData("SELECT COUNT(*) AS totalBitacora
						FROM bitacoras
						WHERE(
								($columna = 0 AND id_bitacora = CASE WHEN '$filtro' = '' THEN id_bitacora ELSE '$filtro' END) OR
								($columna = 1 AND usuario_bit =CASE WHEN '$filtro' = '' THEN usuario_bit ELSE '$filtro' END) OR
								($columna = 2 AND modulo_afectado = '$filtro') OR 
								($columna = 3 AND accion_realizada = '$filtro') OR
								($columna = 4 AND fecha_accion BETWEEN '$desde' AND '$hasta')
							 )");
	}
	//las columnas son basicamente el select que va a tener el buscar reporte veterinario
	//no especificamos en que direccion tiene asi que sera dificil hacerle un buscar
	public function Veterinarios($columna, $filtro){
		$this->ObtenData("SELECT id_veterinario, nombre, tlf, direccion, img, visible, usuario_Rveterinario
						FROM veterinario
						WHERE (
								($columna = 0 AND id_veterinario = CASE WHEN $filtro = '' THEN id_veterinario ELSE '$filtro' END) OR
								($columna = 1 AND nombre LIKE '$filtro' + '%' ) OR
								($columna = 2 AND tlf = CASE WHEN '$filtro' = '' THEN tlf ELSE '$filtro' END) OR
								($columna = 3 AND visible = CASE WHEN '$filtro' = '' THEN visible ELSE CASE WHEN '$filtro' LIKE  'visible' THEN 1 ELSE 0 END END) OR 
								($columna = 4 AND usuario_Rveterinario = CASE WHEN '$filtro' = '' THEN usuario_Rveterinario ELSE '$filtro' END)
							  )");
	}
	//me parecio muy tonto buscar a un veterinario por su tlf 
	//Linea borrada ($columna = 2 AND tlf = CASE WHEN '$filtro' = '' THEN tlf ELSE '$filtro' END) OR Fecha: 16/11/2022
	public function TotalVeterinarios($columna, $filtro){
		$resultados = $this->ObtenData("SELECT COUNT(*) AS TotalVeterinarios
									FROM veterinario
									WHERE (
											($columna = 0 AND id_veterinario = CASE WHEN $filtro = '' THEN id_veterinario ELSE '$filtro' END) OR
											($columna = 1 AND nombre LIKE '$filtro' + '%' ) OR
											($columna = 2 AND visible = CASE WHEN '$filtro' = '' THEN visible ELSE CASE WHEN '$filtro' LIKE  'visible' THEN 1 ELSE 0 END END) OR 
											($columna = 3 AND usuario_Rveterinario = CASE WHEN '$filtro' = '' THEN usuario_Rveterinario ELSE '$filtro' END)
										  )");
		return $resultados [0]['TotalVeterinarios'];
	}
	
/*
(@COLUMNA = 0 AND A1.IDNPP = CASE WHEN @TEXTO = '' THEN A1.IDNPP ELSE @TEXTO END) OR        
					--(@COLUMNA = 1 AND A1.NOMCLI LIKE '%' + @TEXTO + '%') OR --NO EXISTE EL NOMBRE DE LA PROMOCION EN LA TABLA PROMOCION
					(@COLUMNA = 2 AND A1.DCTO = CASE WHEN @COLUMNA <> 2 THEN A1.DCTO ELSE @TEXTO END) OR
					(@COLUMNA = 3 AND A1.DIASMIN = CASE WHEN @COLUMNA <> 3 THEN A1.DIASMIN ELSE @TEXTO END) OR
					(@COLUMNA = 4 AND A1.DIASMAX = CASE WHEN @COLUMNA <> 4 THEN A1.DIASMAX ELSE @TEXTO END) OR
					(@COLUMNA = 5 AND A1.TIPOMONEDA = CASE WHEN @COLUMNA <> 5 THEN A1.TIPOMONEDA ELSE @TEXTO END) OR
					(@COLUMNA = 6 AND A1.CODFORMAPAGO = CASE WHEN @COLUMNA <> 6 THEN A1.CODFORMAPAGO ELSE @TEXTO END) OR 
					(@COLUMNA = 7 AND A1.TIPOCUENTA = CASE WHEN @COLUMNA <> 7 THEN A1.TIPOCUENTA ELSE @TEXTO END)
					)
					
					
 SELECT IDNPP, FECHADEPDESDE, FECHADEPHASTA, DCTO, DIASMIN, DIASMAX, TIPOMONEDA, ESTATUS FROM (
	SELECT DISTINCT CASE WHEN GETDATE() BETWEEN A.FECHADEPDESDE AND A.FECHADEPHASTA THEN 'VIGENTES'
			WHEN GETDATE() > A.FECHADEPDESDE AND GETDATE() > A.FECHADEPHASTA THEN 'VENCIDAS'
			WHEN GETDATE() < A.FECHADEPDESDE AND GETDATE() < A.FECHADEPHASTA THEN 'POR INICIAR'
			ELSE ''
			END AS ESTATUS, A.IDNPP, A.FECHADEPDESDE, A.FECHADEPHASTA, A.DCTO, A.DIASMIN, A.DIASMAX, A.TIPOMONEDA FROM COB_MAEPROMONOTAS A WITH(NOLOCK)
	INNER JOIN COB_DETPROMONOTAS B WITH(NOLOCK) ON A.IDNPP = B.IDNPP
	WHERE (A.FECHADEPDESDE BETWEEN  @DESDE AND @HASTA
	 OR A.FECHADEPHASTA BETWEEN @DESDE AND @HASTA OR 
	 (A.FECHADEPDESDE < @DESDE AND A.FECHADEPHASTA > @HASTA))
	 --OR NOMPROMOCION LIKE '%' + @NOMBRE + '%'
	 AND A.IDNPP = CASE WHEN @IDPROMO = 0 THEN A.IDNPP ELSE @IDPROMO END
	 AND B.CODCLI LIKE CASE WHEN @CODCLI = '' THEN '%' + B.CODCLI + '%' ELSE '%' + @CODCLI+'%' END

) A1 WHERE A1.ESTATUS = CASE WHEN @ESTATUS = 'TODAS' THEN A1.ESTATUS ELSE @ESTATUS END
	

 public function consultarVeterinarios($id_veterinario, $pagina, $qty){
        if($pagina <= 0){ $pagina = 1; }
        $desde = ($pagina - 1) * $qty;
        $resultado = $this->obtenData("SELECT id_veterinario, nombre, tlf, direccion, img, visible, usuario_Rveterinario
                          FROM veterinario
                          WHERE id_veterinario = CASE WHEN '$id_veterinario' = '' THEN id_veterinario ELSE '$id_veterinario' END
                          LIMIT $desde, $qty");
        return $resultado;
    }
	
	INSERT INTO #NOTASISV (CODCLI, RECIBO, TIPOMOV, OPERFAC)  
	SELECT A.CODCLI, A.RECIBO, A.TIPOMOV, E.NOMOPER
	FROM MAECUENTA A WITH (NOLOCK)
	INNER JOIN MAECLIENTE C WITH (NOLOCK) ON A.CODCLI = C.CODCLI
	INNER JOIN V_REGIONXCLIENTE2 D WITH (NOLOCK) ON D.CODCLI = C.CODCLI AND D.CODZON = C.CODZON
	INNER JOIN MAEOPERADOR E WITH(NOLOCK) ON C.OPERFAC = E.CODOPER
	WHERE A.FACHAMOV < @HASTA + 1
		  AND A.ESTATUS = 'PE' 
		  --AND C.FORMAPAGO = 'VENCIMIENTO'
		  AND A.TIPOMOV = 'ND' 
		  AND A.CONCEPTO = 'ISV' 
		  AND EXISTS (
						SELECT * 
						FROM MAECUENTA B WITH (NOLOCK) 
						WHERE B.CODCLI = A.CODCLI 
							  AND ESTATUS = 'PE' 
							  AND TIPOMOV = 'FA' 
							  AND A.RECIBO = '0' + B.RECIBO
					)
		  AND D.REGION = CASE WHEN @REGION IN ('-1', 'TODAS') THEN D.REGION ELSE @REGION END
		  AND D.NOMDISTRITO = CASE WHEN @DISTRITO IN ('-1', 'TODAS') THEN D.NOMDISTRITO ELSE @DISTRITO END
		  AND C.CODZON = CASE WHEN @ZONA IN ('-1', 'TODAS') THEN C.CODZON ELSE @ZONA END
		  AND C.CADENA = CASE WHEN @CADENA IN ('-1', 'TODAS') THEN C.CADENA ELSE @CADENA END 
		  AND C.CODCLI = CASE WHEN @CLIENTE IN ('-1', 'TODAS') THEN C.CODCLI ELSE @CLIENTE END
		  AND C.CODZON NOT IN ('#','9','T') 
		  AND C.CODZON NOT LIKE 'X%'   
		  AND C.CADENA NOT IN ('DPTO.  LEGAL')
		  AND C.OPERFAC = CASE WHEN @ANALISTA IN ('-1', '!') THEN C.OPERFAC ELSE @ANALISTA END
		 
*/
}
?>