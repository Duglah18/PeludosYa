<?php
class SessionModel extends ConexionBD {
	/*
	Creo que tambien hay que colocar para buscar los animales adoptados o no adoptados de todos los albergues o mas 
	bien de un albergue especifico ej: alberg polipro todos los animales adoptados
	*/
	//0 = a todos 
	public function Animales($columna, $filtro, $desde = 2022, $hasta = 2022, $estatus = 0){
		//estatus serviria para buscar en albergue esos animales adoptados no adoptados o en proceso
		//https://codigoroot.net/blog/obtener-fecha-y-hora-en-php-con-date/#:~:text=Obtener%20fecha%20actual%20php%20con%20formato%20(Dia%2FMes%2FA%C3%B1o)&text=%24fechaActual%20%3D%20date('d%2Fm%2Fy')%3B
		
		$resultados =  $this->ObtenData("SELECT a.id_animal, a.nombre, a.anio_nac, a.img, a.descripcion,
																					a.fecha_ingreso, b.nombre as nombreRaza, c.nombre AS nombreTamano,
																					d.nombre AS nombreAlbergue, e.nombre AS nombreTipoAnimal,
																					CASE WHEN ISNULL(f.animal_id) THEN 0 ELSE SUM(f.animal_id) END AS TotalAdopciones
																						FROM animal a
																						INNER JOIN raza b ON a.raza_id = b.id_raza
																						INNER JOIN tamanio c ON a.tamanio_id = c.id_tamanio
																						INNER JOIN albergue d ON a.albergue_id = d.id_albergue
																						INNER JOIN --TipoAnimal e ON 
																						LEFT JOIN adopcion f ON a.id_animal = f.animal_id
																						WHERE (
																										($columna = 0 AND a.id_animal = CASE WHEN '$filtro' = '' THEN a.id_animal ELSE '$filtro' END) OR 
																										($columna = 1 AND a.nombre LIKE '$filtro' + '%') OR
																										($columna = 2 AND a.anio_nac BETWEEN $desde AND $hasta) OR 
																										($columna = 3 AND a.fecha_ingreso BETWEEN $desde AND $hasta) OR 
																										($columna = 4 AND b.raza_id = CASE WHEN $filtro = 0 THEN b.raza_id ELSE $filtro END) OR --Raza--Aca se implementa un combobox si se puede si no ps vere
																										($columna = 5 AND c.id_tamanio = CASE WHEN $filtro = 0 THEN c.id_tamanio ELSE $filtro END) OR --Tamanio
																										($columna = 6 AND a.albergue_id = CASE WHEN $filtro = 0 THEN a.albergue_id ELSE $filtro END AND f.estado = CASE WHEN $estatus = 0 THEN f.estado ELSE $estatus END) OR --Albergue podria ser codigo --si saliera un cmb podria sacarle una consulta
																										($columna = 7 AND d.nombre LIKE '$filtro' + '%') OR --Albergue nombre
																										($columna = 7 AND ) OR --Tipo Animal
																										($columna = 8 AND CASE WHEN f.estado IS NULL THEN 0 ELSE SUM(f.estado) END < $filtro) --Numero de adopciones
																									  )");//Estas buscando menores numeros de adopcion que estas ingresando o cuantos?
		return $resultados;//Se podria colocar un and como en los ejemplos
	}
	//https://es.stackoverflow.com/questions/351356/si-el-select-tiene-valor-negro-ocultar-input
	
	public function TotalAnimales($columna, $filtro, $desde = 2022, $hasta = 2022){
		$resultados = $resultados =  $this->ObtenData("SELECT a.id_animal, a.nombre, a.anio_nac, a.img, a.descripcion,
																													a.fecha_ingreso, b.nombre as nombreRaza, c.nombre AS nombreTamano,
																													d.nombre AS nombreAlbergue, e.nombre AS nombreTipoAnimal,
																													CASE WHEN ISNULL(f.animal_id) THEN 0 ELSE SUM(f.animal_id) END AS TotalAdopciones
																														FROM animal a
																														INNER JOIN raza b ON a.raza_id = b.id_raza
																														INNER JOIN tamanio c ON a.tamanio_id = c.id_tamanio
																														INNER JOIN albergue d ON a.albergue_id = d.id_albergue
																														INNER JOIN --TipoAnimal e ON 
																														LEFT JOIN adopcion f ON a.id_animal = f.animal_id
																														WHERE (
																																		($columna = 0 AND a.id_animal = CASE WHEN '$filtro' = '' THEN a.id_animal ELSE '$filtro' END) OR 
																																		($columna = 1 AND a.nombre LIKE '$filtro' + '%') OR
																																		($columna = 2 AND a.anio_nac BETWEEN $desde AND $hasta) OR 
																																		($columna = 3 AND a.fecha_ingreso BETWEEN $desde AND $hasta) OR 
																																		($columna = 4 AND b.raza_id = CASE WHEN $filtro = 0 THEN b.raza_id ELSE $filtro END) OR --Raza--Aca se implementa un combobox si se puede si no ps vere
																																		($columna = 5 AND c.id_tamanio = CASE WHEN $filtro = 0 THEN c.id_tamanio ELSE $filtro END) OR --Tamanio
																																		($columna = 6 AND a.albergue_id = CASE WHEN $filtro = 0 THEN a.albergue_id ELSE $filtro END) OR --Albergue podria ser codigo --si saliera un cmb podria sacarle una consulta
																																		($columna = 7 AND d.nombre LIKE '$filtro' + '%') OR --Albergue nombre
																																		($columna = 7 AND ) OR --Tipo Animal
																																		($columna = 8 AND CASE WHEN f.estado IS NULL THEN 0 ELSE SUM(f.estado) END < $filtro) --Numero de adopciones
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
	
	public function AnimalesAdoptados($columna, $filtro, $desde = 2022, $hasta = 2022, $estatus = 0){
		return $resultados =  $this->ObtenData("SELECT a.id_animal, a.nombre, a.anio_nac, a.img, a.descripcion,
																					a.fecha_ingreso, b.nombre as nombreRaza, c.nombre AS nombreTamano,
																					d.nombre AS nombreAlbergue, e.nombre AS nombreTipoAnimal,
																					CASE WHEN ISNULL(f.animal_id) THEN 0 ELSE SUM(f.animal_id) END AS TotalAdopciones
																						FROM animal a
																						INNER JOIN raza b ON a.raza_id = b.id_raza
																						INNER JOIN tamanio c ON a.tamanio_id = c.id_tamanio
																						INNER JOIN albergue d ON a.albergue_id = d.id_albergue
																						INNER JOIN --TipoAnimal e ON 
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
																											($columna = 7 AND )--Tipo Animal
																										  )");
	}
	
	public function Usuarios($columna, $filtro){
		return $this->ObtenData("SELECT cedula, nombre, rol_id
																	FROM usuarios
																	WHERE(
																						($columna = 0 AND cedula = CASE WHEN $filtro = '' THEN cedula ELSE $filtro END ) OR 
																						($columna = 1 AND nombre LIKE '$filtro' + %) OR 
																						($columna = 2 AND rol_id = $filtro)
																					)");
	}
	
	public function Albergues() {
		$this->ObtenData("SELECT *
									FROM albergue
									WHERE");
	}
	//supongo que sera una consulta sobre logins y registers
	public function Movimientos(){
		return $this->ObtenData("SELECT *
									FROM bitacoras
									WHERE ");
		
	}
	//esto podria ser por modulo, si fue un UPDATE o un INSERT
	public function Bitacora(){
		return $this->ObtenData("SELECT *
									FROM bitacoras
									WHERE ");
		return 0;
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
	
	public function TotalVeterinarios($columna, $filtro){
		$resultados = $this->ObtenData("SELECT COUNT(*) AS TotalVeterinarios
									FROM veterinario
									WHERE (
													($columna = 0 AND id_veterinario = CASE WHEN $filtro = '' THEN id_veterinario ELSE '$filtro' END) OR
													($columna = 1 AND nombre LIKE '$filtro' + '%' ) OR
													($columna = 2 AND tlf = CASE WHEN '$filtro' = '' THEN tlf ELSE '$filtro' END) OR
													($columna = 3 AND visible = CASE WHEN '$filtro' = '' THEN visible ELSE CASE WHEN '$filtro' LIKE  'visible' THEN 1 ELSE 0 END END) OR 
													($columna = 4 AND usuario_Rveterinario = CASE WHEN '$filtro' = '' THEN usuario_Rveterinario ELSE '$filtro' END)
												  )");
		return $resultados [0]['TotalVeterinarios'];
	}
/*(@COLUMNA = 0 AND A1.IDNPP = CASE WHEN @TEXTO = '' THEN A1.IDNPP ELSE @TEXTO END) OR        
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