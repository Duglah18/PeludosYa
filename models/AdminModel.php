<?php 

class AdminModel extends ConexionBD{

    // #consultas Region
    public function consultarVeterinarios($id_veterinario, $pagina, $qty){
        if($pagina <= 0){ $pagina = 1; }
        $desde = ($pagina - 1) * $qty;
        $resultado = $this->obtenData("SELECT id_veterinario, nombre, tlf, direccion, img, visible, usuario_Rveterinario
                          FROM veterinario
                          WHERE id_veterinario = CASE WHEN '$id_veterinario' = '' THEN id_veterinario ELSE '$id_veterinario' END
                          LIMIT $desde, $qty");
        return $resultado;
    }

    public function TotalVeterinariosConsults(){
        $resultado = $this->obtenData("SELECT COUNT(*) AS TotalVeterinarios FROM veterinario");
        return $resultado[0]['TotalVeterinarios'];
    }

    public function consultarAdmin($user, $contrasenia){
        $user = mysqli_real_escape_string($this->conectar(),$user);
        $contrasenia = mysqli_real_escape_string($this->conectar(),$contrasenia);
        $resultado = $this->obtenData("SELECT cedula, nombre, contrasenia, rol_id 
                                        FROM usuarios 
                                        WHERE nombre = '$user' AND contrasenia = '$contrasenia' AND rol_id = 1");
        if ($resultado) {
            return $resultado;
        } else {
            return false;
        }
    }

    public function consultaUsuario($idusuario){
        $idusuario = mysqli_real_escape_string($this->conectar(),$idusuario);
        $resultado = $this->obtenData("SELECT cedula, nombre, contrasenia, rol_id, direccion, contrasenia,
                                              activo, telefono, detalles
                                        FROM usuarios
                                        WHERE (cedula = CASE WHEN '$idusuario' = '' THEN cedula ELSE '$idusuario' END)");
        return $resultado;
    }

    public function consultaAlbergues(){
        $resultados = $this->obtenData("SELECT id_albergue, nombre FROM albergue");
        if ($resultados){
            return $resultados;
        } else {
            return false;
        }
    }

    public function consultaAdopciones($albergueEsp, $pagina, $qty){
        $albergueEsp = mysqli_real_escape_string($this->conectar(),$albergueEsp);
        if($pagina <= 0){ $pagina = 1; }
        $desde = ($pagina - 1) * $qty;
        $resultados = $this->obtenData("SELECT a.id_adopcion, a.fecha_adopcion, b.nombre as nombreanimal, 
                                        d.nombre as nombreusuario, c.nombre as nombrealbergue,
                                        e.nombre_estado
                                        FROM adopcion a
                                        INNER JOIN animal b ON a.animal_id = b.id_animal
                                        INNER JOIN albergue c ON b.albergue_id = c.id_albergue
                                        INNER JOIN usuarios d ON c.cedula_usuario = d.cedula
                                        INNER JOIN tipo_estado_adopcion e ON a.estado = e.id_tipo_estado
                                        WHERE c.id_albergue = CASE WHEN '$albergueEsp' = '' THEN c.id_albergue ELSE '$albergueEsp' END
                                        LIMIT $desde,$qty");
        if (!$resultados){
            return false;
        } 
        return $resultados;
    }

    public function TotalconsultaAdopciones($albergueEsp){
        mysqli_real_escape_string($this->conectar(),$albergueEsp);
        $resultados = $this->obtenData("SELECT COUNT(*) AS TotalAdopciones
                                        FROM adopcion a
                                        INNER JOIN animal b ON a.animal_id = b.id_animal
                                        INNER JOIN albergue c ON b.albergue_id = c.id_albergue
                                        INNER JOIN usuarios d ON c.cedula_usuario = d.cedula
                                        INNER JOIN tipo_estado_adopcion e ON a.estado = e.id_tipo_estado
                                        WHERE c.id_albergue = CASE WHEN '$albergueEsp' = '' THEN c.id_albergue ELSE '$albergueEsp' END");

        return $resultados[0]['TotalAdopciones'];
    }

    public function ConsultaRoles(){
        $resultado = $this->obtenData("SELECT id_rol, nombre FROM rol");
        if ($resultado) {
            return $resultado;
        } else {
            return false;
        }
    }

    public function listar($pagina, $qty){
        if($pagina <= 0){ $pagina = 1; }
        $desde = ($pagina - 1) * $qty;
        return $this->obtenData("SELECT usuarios.cedula, usuarios.nombre, usuarios.direccion, 
                                        usuarios.activo, rol.nombre as nombrerol, usuarios.telefono,
                                        usuarios.detalles
                                FROM usuarios 
                                INNER JOIN rol ON usuarios.rol_id = rol.id_rol
                                ORDER BY usuarios.activo DESC, usuarios.rol_id ASC
                                LIMIT $desde, $qty");
                                //tristemente el array no capta algo tipo usuarios a = a.nombre asi que
                                //como el nombre del rol y el nombre del usuario tienen el mismo campo con mismo nombre entonces
                                //simplemente hice que el nombre de rol se reconociera como as 
    }

    public function TotalUsuarios(){
        $resultado = $this->obtenData("SELECT COUNT(*) AS TotalUsuarios
                                FROM usuarios 
                                INNER JOIN rol ON usuarios.rol_id = rol.id_rol");
        return $resultado[0]['TotalUsuarios'];
    }

    public function consultarAnimal($id_animal){
        $id_animal = mysqli_real_escape_string($this->conectar(),$id_animal);
        return $this->obtenData("SELECT a.id_animal, a.nombre, a.anio_nac, a.img, a.descripcion, 
                                    a.fecha_ingreso, a.raza_id, a.tamanio_id, a.albergue_id, a.visible, 
                                    b.id_tipo_animal
                                FROM animal a
                                INNER JOIN raza b ON a.raza_id = b.id_raza
                                WHERE a.id_animal = CASE WHEN '$id_animal' = '' THEN a.id_animal ELSE '$id_animal'END");
    }//Resolver el problema de si esta adoptado
	//he de suponer que mi yo pasado se preguntaba sobre lo de si esta adoptado o no en vista de usuarios
	//pero este no es el de usuarios
	
    public function listaTiposAnimal($id_tipo, $pagina, $qty){
        $id_tipo = mysqli_real_escape_string($this->conectar(),$id_tipo);
		if($pagina <= 0){ $pagina = 1; }
        $desde = ($pagina - 1) * $qty;
        return $this->obtenData("SELECT id_tipo, nombre
                                FROM tipo_animal 
                                WHERE id_tipo = CASE WHEN '$id_tipo' = '' THEN id_tipo ELSE '$id_tipo' END
								LIMIT $desde, $qty");
    }

	public function TotallistaTiposAnimal(){
		$resultados = $this->obtenData("SELECT COUNT(*) AS TotalTiposAnimal
                                FROM tipo_animal ");
		return $resultados[0]['TotalTiposAnimal'];
	}

    public function listaRazas($id_raza, $pagina, $qty){
        $id_raza = mysqli_real_escape_string($this->conectar(),$id_raza);
        if($pagina <= 0){ $pagina = 1; }
        $desde = ($pagina - 1) * $qty;
        return $this->obtenData("SELECT raza.id_raza, raza.nombre, tipo_animal.nombre as nombreTipo, id_tipo_animal as id_tipo_2
                                FROM raza
                                INNER JOIN tipo_animal ON tipo_animal.id_tipo = raza.id_tipo_animal
                                WHERE raza.id_raza = CASE WHEN '$id_raza' = '' THEN raza.id_raza ELSE '$id_raza' END
                                LIMIT $desde, $qty");
    }

    public function TotallistaRazas(){
        $resultados = $this->obtenData("SELECT COUNT(*) AS TotalRazasAnimal
                                        FROM raza");
        return $resultados[0]['TotalRazasAnimal'];
    }

    public function consultaTipoAnimal(){
        $resultados = $this->obtenData("SELECT id_tipo, nombre FROM tipo_animal");
        if ($resultados){
            return $resultados;
        } else {
            return false;
        }
    }

    public function consultaRazaAnimal($id_tipo){
        $id_tipo = mysqli_real_escape_string($this->conectar(),$id_tipo);
        $resultados = $this->obtenData("SELECT id_raza, nombre FROM raza 
                                        WHERE id_tipo_animal = CASE WHEN '$id_tipo' = '' THEN id_tipo_animal ELSE '$id_tipo' END");
        if ($resultados){
            return $resultados;
        } else {
            return false;
        }
    }

    public function consultaTamanoAnimal(){
        $resultados = $this->obtenData("SELECT id_tamanio, nombre FROM tamanio");
        if ($resultados){
            return $resultados;
        } else {
            return false;
        }
    }

    public function registrarUsuario($tabla, $rif, $nombre, $rol, $direccion, 
                                    $contrasenia, $estado, $tlf, $usuario_ingresando){
        $data['cedula'] = mysqli_real_escape_string($this->conectar(),$rif);
        $data['nombre'] = mysqli_real_escape_string($this->conectar(),$nombre);
        $data['rol_id'] = mysqli_real_escape_string($this->conectar(),$rol);
        $data['direccion'] = mysqli_real_escape_string($this->conectar(),$direccion);
        $data['contrasenia'] = mysqli_real_escape_string($this->conectar(),$contrasenia);
        $data['activo'] = mysqli_real_escape_string($this->conectar(),$estado);
        $data['telefono'] = mysqli_real_escape_string($this->conectar(),$tlf);
        $verificar = $this->obtenData("SELECT cedula, nombre, contrasenia, activo, rol_id
                                        FROM usuarios
                                        WHERE cedula = '$rif'");
        if($verificar){//se verifica si existe un usuario con esa ced y si es asi retorna falso
            return false;
        }

        $registrandoUser = $this->grabaData($tabla, $data);
        //si se agrega no sera un booleano pero si no si lo sera hay un error raro que agarra
        //el if si se verifica si es falso asi que esto se queda asi
        if (is_bool($registrandoUser)){
            return false;
        }

        $ingresando = $this->creaCadenaInsert($data, $tabla);
        $arry['usuario_bit'] = $usuario_ingresando;
        $arry['modulo_afectado'] = 'Añadir Usuario Admin';
        $arry['accion_realizada'] = $ingresando;
        $arry['valor_actual'] = implode("; ",$data);
        $arry['fecha_accion'] ='Now()';

        $bitacora = $this->grabaData("bitacoras",$arry);

        if (!$bitacora){
            return false;
        }
        return $bitacora;
    }

    public function registraTipoAnimal($tabla, $nombre, $usuario_ingresando){
        $data['nombre'] = mysqli_real_escape_string($this->conectar(),$nombre);

        $registrandoTAnimal = $this->grabaData($tabla, $data);
        if (is_bool($registrandoTAnimal)){
            return false;
        }

        $ingresando = $this->creaCadenaInsert($data, $tabla);
        $arry['usuario_bit'] = $usuario_ingresando;
        $arry['modulo_afectado'] = 'Añadir Tipo Animal Admin';
        $arry['accion_realizada'] = $ingresando;
        $arry['valor_actual'] = implode("; ",$data);
        $arry['fecha_accion'] ='Now()';

        $bitacora = $this->grabaData("bitacoras",$arry);

        if (!$bitacora){
            return false;
        }
        return $bitacora;
    }

    public function registraRazaAnimal($tabla, $nombre, $tiporaza, $usuario_ingresando){
        $data['nombre'] = mysqli_real_escape_string($this->conectar(),$nombre);
        $data['id_tipo_animal'] = mysqli_real_escape_string($this->conectar(),$tiporaza);
        $registrandoRAnimal = $this->grabaData($tabla, $data);

        if(is_bool($registrandoRAnimal)){
            return false;
        }

        $ingresando = $this->creaCadenaInsert($data, $tabla);
        $arry['usuario_bit'] = $usuario_ingresando;
        $arry['modulo_afectado'] = 'Añadir Raza Animal Admin';
        $arry['accion_realizada'] = $ingresando;
        $arry['valor_actual'] = implode("; ",$data);
        $arry['fecha_accion'] ='Now()';

        $bitacora = $this->grabaData("bitacoras",$arry);

        if (!$bitacora){
            return false;
        }
        return $bitacora;
    }
    
    public function registraAnimal($tabla, $nom, $anionac, $nomimg, $descripcion, $fecha_ing, 
                                    $id_raza, $tamano_id, $albergue, $visible, $usuario_ingresando){
        $data['nombre'] = mysqli_real_escape_string($this->conectar(),$nom);
        $data['anio_nac'] = mysqli_real_escape_string($this->conectar(),$anionac);
        $data['img'] = mysqli_real_escape_string($this->conectar(),$nomimg);
        $data['descripcion'] = mysqli_real_escape_string($this->conectar(),$descripcion);
        $data['fecha_ingreso'] = mysqli_real_escape_string($this->conectar(),$fecha_ing);
        $data['raza_id'] = mysqli_real_escape_string($this->conectar(),$id_raza);
        $data['tamanio_id'] = mysqli_real_escape_string($this->conectar(),$tamano_id);
        $data['albergue_id'] = mysqli_real_escape_string($this->conectar(),$albergue);
        $data['visible'] = mysqli_real_escape_string($this->conectar(),$visible);
        $registrandoAnimal = $this->grabaData($tabla, $data);

        if(is_bool($registrandoAnimal)){
            return false;
        }

        $ingresando = $this->creaCadenaInsert($data, $tabla);
        $arry['usuario_bit'] = $usuario_ingresando;
        $arry['modulo_afectado'] = 'Añadir Animal Admin';
        $arry['accion_realizada'] = $ingresando;
        $arry['valor_actual'] = implode("; ",$data);
        $arry['fecha_accion'] ='Now()';

        $bitacora = $this->grabaData("bitacoras",$arry);
        if(!$bitacora){
            return false;
        }
        return $bitacora;
    }

    public function registraVeterinario($nombre,$telefono,$direccion,$img,
                                        $adminregistra){
        $data['nombre'] = mysqli_real_escape_string($this->conectar(),$nombre);
        $data['tlf'] = mysqli_real_escape_string($this->conectar(),$telefono);
        $data['direccion'] = mysqli_real_escape_string($this->conectar(),$direccion);
        $data['img'] = mysqli_real_escape_string($this->conectar(),$img);
        $data['visible'] = 1;
        $data['usuario_Rveterinario'] = mysqli_real_escape_string($this->conectar(),$adminregistra);
        $registrandoVeterinario = $this->grabaData('veterinario',$data);

        if(is_bool($registrandoVeterinario)){
            return false;
        }

        $ingresando = $this->creaCadenaInsert($data, 'veterinario');
        $arry['usuario_bit'] = $adminregistra;
        $arry['modulo_afectado'] = 'Añadir Veterinario Admin';
        $arry['accion_realizada'] = $ingresando;
        $arry['valor_actual'] = implode("; ",$data);
        $arry['fecha_accion'] ='Now()';

        $bitacora = $this->grabaData("bitacoras",$arry);
        if(!$bitacora){
            return false;
        }
        return $bitacora;
    }

    public function registraCierraSesion($user){
        $arry['usuario_bit'] = mysqli_real_escape_string($this->conectar(),$user);
        $arry['modulo_afectado'] = 'Cerrar Sesion';
        $arry['accion_realizada'] = "Cerrar Sesion";
        $arry['valor_actual'] = $user . " Cerrando Sesion";
        $arry['fecha_accion'] ='Now()';

        $bitacora = $this->grabaData("bitacoras",$arry);
        if(!$bitacora){
            return false;
        }
        return $bitacora;
    }
    #Region de Modificar
    public function modificaUsuario($idusuario,$nombre,$rol,$direccion,$contrasena,
                                    $activo,$telefono, $detalles, $usuario_modificando){
        $anterior = $this->obtenData("SELECT cedula, nombre, rol_id, direccion, activo, telefono, detalles
                                        FROM usuarios WHERE cedula = '$idusuario'");
        $data['cedula'] = mysqli_real_escape_string($this->conectar(),$idusuario);
        $data['nombre'] = mysqli_real_escape_string($this->conectar(),$nombre);
        $data['rol_id'] = mysqli_real_escape_string($this->conectar(),$rol);
        $data['direccion'] = mysqli_real_escape_string($this->conectar(),$direccion);
        $data['contrasenia'] = mysqli_real_escape_string($this->conectar(),$contrasena);
        $data['activo'] = mysqli_real_escape_string($this->conectar(),$activo);
        $data['telefono'] = mysqli_real_escape_string($this->conectar(),$telefono);
        $data['detalles'] = mysqli_real_escape_string($this->conectar(),$detalles);
        $modificaUsuario = $this->actualizaData("usuarios",$data,"cedula = '$idusuario'");

        $nuevo = $this->obtenData("SELECT cedula, nombre, rol_id, direccion, activo, telefono, detalles
                                    FROM usuarios WHERE cedula = '$idusuario'");
        if(!$modificaUsuario){
            return false;
        }
        $arra['usuario_bit'] = $usuario_modificando;
        $arra['modulo_afectado'] = 'Modifica Usuario';
        $arra['accion_realizada'] = $this->creaCadenaUpdate('usuarios',$data, "cedula = " . $idusuario);
        $arra['valor_anterior'] = implode(";", $anterior[0]);
        $arra['valor_actual'] = implode("; ",$nuevo[0]);
        $arra['fecha_accion'] ='Now()';

        return $this->grabaData("bitacoras", $arra);
    }

    public function modificaAnimal($tabla, $id_animal,$nom, $anionac, $nomimg, $descripcion, 
                                    $id_raza, $tamano_id, $albergue, $visible, $usuario_modificando){
        $anterior = $this->obtenData("SELECT nombre, anio_nac, img, descripcion, raza_id, tamanio_id,
                                        albergue_id, visible
                                        FROM animal
                                        WHERE id_animal = '$id_animal'");
        $data['nombre'] = mysqli_real_escape_string($this->conectar(),$nom);
        $data['anio_nac'] = mysqli_real_escape_string($this->conectar(),$anionac);
        $data['img'] = mysqli_real_escape_string($this->conectar(),$nomimg);
        $data['descripcion'] = mysqli_real_escape_string($this->conectar(),$descripcion);
        $data['raza_id'] = mysqli_real_escape_string($this->conectar(),$id_raza);
        $data['tamanio_id'] = mysqli_real_escape_string($this->conectar(),$tamano_id);
        $data['albergue_id'] = mysqli_real_escape_string($this->conectar(),$albergue);
        $data['visible'] = mysqli_real_escape_string($this->conectar(),$visible);
        $modificaAnimal = $this->actualizaData($tabla, $data, "id_animal = '$id_animal'");

        $nuevo = $this->obtenData("SELECT nombre, anio_nac, img, descripcion, raza_id, tamanio_id,
                                    albergue_id, visible
                                    FROM animal
                                    WHERE id_animal = '$id_animal'");

        if(!$modificaAnimal){
            return false;
        }

        $arra['usuario_bit'] = $usuario_modificando;
        $arra['modulo_afectado'] = 'Modifica Animal';
        $arra['accion_realizada'] = $this->creaCadenaUpdate('animal',$data, "id_animal = " . $id_animal);
        $arra['valor_anterior'] = implode(";", $anterior[0]);
        $arra['valor_actual'] = implode("; ",$nuevo[0]);
        $arra['fecha_accion'] ='Now()';

        return $this->grabaData("bitacoras", $arra);
    }

    public function modificaVeterinario($id_veterinario, $nombre, $tlf, $direccion, 
                                        $img, $visible, $usuario_modificando){
        $anterior = $this->obtenData("SELECT nombre, tlf, direccion, img, visible
                                        FROM veterinario WHERE id_veterinario = '$id_veterinario'");
        
        $data['nombre'] = mysqli_real_escape_string($this->conectar(),$nombre);
        $data['tlf'] = mysqli_real_escape_string($this->conectar(),$tlf);
        $data['direccion'] = mysqli_real_escape_string($this->conectar(),$direccion);
        $data['img'] = mysqli_real_escape_string($this->conectar(),$img);
        $data['visible'] = mysqli_real_escape_string($this->conectar(),$visible);
        $modificaVeterinario = $this->actualizaData('veterinario', $data, "id_veterinario = '$id_veterinario'");

        $nuevo = $this->obtenData("SELECT nombre, tlf, direccion, img, visible
                                    FROM veterinario WHERE id_veterinario = '$id_veterinario'");

        if(!$modificaVeterinario){
            return false;
        }

        $arra['usuario_bit'] = $usuario_modificando;
        $arra['modulo_afectado'] = 'Modifica Veterinario Admin';
        $arra['accion_realizada'] = $this->creaCadenaUpdate('veterinario',$data, "id_veterinario = " . $id_veterinario);
        $arra['valor_anterior'] = implode(";", $anterior[0]);
        $arra['valor_actual'] = implode("; ",$nuevo[0]);
        $arra['fecha_accion'] ='Now()';

        return $this->grabaData("bitacoras", $arra);
    }

    public function modificaTipoAnimal($id_tipo, $nombre, $usuario_modificando){
        $anterior = $this->obtenData("SELECT nombre
                                        FROM tipo_animal 
                                        WHERE id_tipo = '$id_tipo'");

        $data['nombre'] = mysqli_real_escape_string($this->conectar(),$nombre);
        $modificaTipoAnimal = $this->actualizaData('tipo_animal', $data, "id_tipo = '$id_tipo'");

        $nuevo = $this->obtenData("SELECT nombre
                                    FROM tipo_animal 
                                    WHERE id_tipo = '$id_tipo'");

        if(!$modificaTipoAnimal){
            return false;
        }

        $arra['usuario_bit'] = $usuario_modificando;
        $arra['modulo_afectado'] = 'Modifica Tipo Animal admin';
        $arra['accion_realizada'] = $this->creaCadenaUpdate('tipo_animal',$data, "id_tipo = " . $id_tipo);
        $arra['valor_anterior'] = implode(";", $anterior[0]);
        $arra['valor_actual'] = implode("; ",$nuevo[0]);
        $arra['fecha_accion'] ='Now()';

        return $this->grabaData("bitacoras", $arra);
    }

    public function modificaRaza($id_raza, $nombre, $tipoAnimal, $usuario_modificando){
        $anterior = $this->obtenData("SELECT nombre, id_tipo_animal
                                        FROM raza WHERE id_raza = '$id_raza'");

        $data['nombre'] = mysqli_real_escape_string($this->conectar(),$nombre);
        $data['id_tipo_animal'] = mysqli_real_escape_string($this->conectar(),$tipoAnimal);
        $modificaRazaAnimal = $this->actualizaData('raza', $data, "id_raza = " . $id_raza);

        $nuevo = $this->obtenData("SELECT nombre, id_tipo_animal
                                    FROM raza WHERE id_raza = '$id_raza'");

        if(!$modificaRazaAnimal){
            return false;
        }

        $arra['usuario_bit'] = $usuario_modificando;
        $arra['modulo_afectado'] = 'Modifica Raza Animal Admin';
        $arra['accion_realizada'] = $this->creaCadenaUpdate('raza',$data, "id_raza = " . $id_raza);
        $arra['valor_anterior'] = implode(";", $anterior[0]);
        $arra['valor_actual'] = implode("; ",$nuevo[0]);
        $arra['fecha_accion'] ='Now()';

        return $this->grabaData("bitacoras", $arra);
    }

    public function DecisionActivacionUsuario($id_usuario, $decision, $usuario_modificando){
        $id_usuario = mysqli_real_escape_string($this->conectar(),$id_usuario);
        $anterior = $this->obtenData("SELECT cedula, activo
                                        FROM usuarios 
                                        WHERE cedula = '$id_usuario'");
        $data['activo'] = $decision;

        $modificaActivacionUsuario = $this->actualizaData('usuarios', $data, "cedula = " . $id_usuario);

        $nuevo = $this->obtenData("SELECT cedula, activo
                                    FROM usuarios 
                                    WHERE cedula = '$id_usuario'");

        if(!$modificaActivacionUsuario){
            return false;
        }

        $arra['usuario_bit'] = $usuario_modificando;
        $arra['modulo_afectado'] = 'Modifica Bloqueo de Usuario Admin';
        $arra['accion_realizada'] = $this->creaCadenaUpdate('usuarios',$data, "cedula = " . $id_usuario);
        $arra['valor_anterior'] = implode(";", $anterior[0]);
        $arra['valor_actual'] = implode("; ",$nuevo[0]);
        $arra['fecha_accion'] ='Now()';

        return $this->grabaData("bitacoras", $arra);
    }

    public function DecisionActivacionVeterinario($id_veterinario, $decision, $usuario_modificando){
        $id_veterinario = mysqli_real_escape_string($this->conectar(),$id_veterinario);
        $anterior = $this->obtenData("SELECT id_veterinario, visible
                                        FROM veterinario 
                                        WHERE id_veterinario = '$id_veterinario'");
        $data['visible'] = $decision;

        $modificaActivacionUsuario = $this->actualizaData('veterinario', $data, "id_veterinario = " . $id_veterinario);

        $nuevo = $this->obtenData("SELECT id_veterinario, visible
                                    FROM veterinario 
                                    WHERE id_veterinario = '$id_veterinario'");

        if(!$modificaActivacionUsuario){
            return false;
        }

        $arra['usuario_bit'] = $usuario_modificando;
        $arra['modulo_afectado'] = 'Modifica Vision de Veterinario Admin';
        $arra['accion_realizada'] = $this->creaCadenaUpdate('veterinario',$data, "id_veterinario = " . $id_veterinario);
        $arra['valor_anterior'] = implode(";", $anterior[0]);
        $arra['valor_actual'] = implode("; ",$nuevo[0]);
        $arra['fecha_accion'] ='Now()';

        return $this->grabaData("bitacoras", $arra);
    }

    public function DecisionActivacionPeludos($id_peludo, $decision, $usuario_modificando){
        $id_peludo = mysqli_real_escape_string($this->conectar(),$id_peludo);
        $anterior = $this->obtenData("SELECT id_animal, visible
                                        FROM animal 
                                        WHERE id_animal = '$id_peludo'");
        $data['visible'] = $decision;

        $modificaActivacionUsuario = $this->actualizaData('animal', $data, "id_animal = " . $id_peludo);

        $nuevo = $this->obtenData("SELECT id_animal, visible
                                    FROM animal 
                                    WHERE id_animal = '$id_peludo'");

        if(!$modificaActivacionUsuario){
            return false;
        }

        $arra['usuario_bit'] = $usuario_modificando;
        $arra['modulo_afectado'] = 'Modifica Visibilidad Peludo Admin';
        $arra['accion_realizada'] = $this->creaCadenaUpdate('animal',$data, "id_animal = " . $id_peludo);
        $arra['valor_anterior'] = implode(";", $anterior[0]);
        $arra['valor_actual'] = implode("; ",$nuevo[0]);
        $arra['fecha_accion'] ='Now()';

        return $this->grabaData("bitacoras", $arra);
    }

    public function DecisionActivacionAlbergues($id_albergue,$decision, $usuario_modificando){
        $id_albergue = mysqli_real_escape_string($this->conectar(),$id_albergue);
        $anterior = $this->obtenData("SELECT id_albergue, activo
                                        FROM albergue 
                                        WHERE id_albergue = '$id_albergue'");
        $data['activo'] = $decision;

        $modificaActivacionUsuario = $this->actualizaData('albergue', $data, "id_albergue = " . $id_albergue);

        $nuevo = $this->obtenData("SELECT id_albergue, activo
                                    FROM albergue 
                                    WHERE id_albergue = '$id_albergue'");

        if(!$modificaActivacionUsuario){
            return false;
        }

        $arra['usuario_bit'] = $usuario_modificando;
        $arra['modulo_afectado'] = 'Modifica Visibilidad Albergue Admin';
        $arra['accion_realizada'] = $this->creaCadenaUpdate('albergue',$data, "id_albergue = " . $id_albergue);
        $arra['valor_anterior'] = implode(";", $anterior[0]);
        $arra['valor_actual'] = implode("; ",$nuevo[0]);
        $arra['fecha_accion'] ='Now()';

        return $this->grabaData("bitacoras", $arra);
    }
}
?>