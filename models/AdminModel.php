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
        $resultado = $this->obtenData("SELECT cedula, nombre, contrasenia, rol_id FROM usuarios WHERE nombre = '$user' AND contrasenia = '$contrasenia' AND rol_id = 1");
        //sin el and del rol se podria loguear un usuario normal como admin :v
        if ($resultado) {
            return $resultado;
        } else {
            return false;
        }
    }

    public function consultaUsuario($idusuario){
        $resultado = $this->obtenData("SELECT cedula, nombre, contrasenia, rol_id, direccion, contrasenia,
                                              activo, telefono
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
        return $this->obtenData("SELECT a.id_animal, a.nombre, a.anio_nac, a.img, a.descripcion, 
                                    a.fecha_ingreso, a.raza_id, a.tamanio_id, a.albergue_id, a.visible, 
                                    b.id_tipo_animal
                                FROM animal a
                                INNER JOIN raza b ON a.raza_id = b.id_raza
                                WHERE a.id_animal = CASE WHEN '$id_animal' = '' THEN a.id_animal ELSE '$id_animal'END");
    }//Resolver el problema de si esta adoptado

    public function listaTiposAnimal($id_tipo, $pagina, $qty){
		if($pagina <= 0){ $pagina = 1; }
        $desde = ($pagina - 1) * $qty;
        return $this->obtenData("SELECT id_tipo, nombre
                                FROM tipo_animal 
                                WHERE id_tipo = CASE WHEN '$id_tipo' = '' THEN id_tipo ELSE '$id_tipo' END
								LIMIT $desde, $qty");
    } //bien XD este es el que se usa para listar en admin?

	public function TotallistaTiposAnimal(){
		$resultados = $this->obtenData("SELECT COUNT(*) AS TotalTiposAnimal
                                FROM tipo_animal ");
		return $resultados[0]['TotalTiposAnimal'];
	}

    public function listaRazas($id_raza, $pagina, $qty){
        if($pagina <= 0){ $pagina = 1; }
        $desde = ($pagina - 1) * $qty;
        return $this->obtenData("SELECT raza.id_raza, raza.nombre, tipo_animal.nombre as nombreTipo, id_tipo_animal as id_tipo_2
                                FROM raza
                                INNER JOIN tipo_animal ON tipo_animal.id_tipo = raza.id_tipo_animal
                                WHERE raza.id_raza = CASE WHEN '$id_raza' = '' THEN raza.id_raza ELSE '$id_raza' END
                                LIMIT $desde, $qty");
    }//Repito esto es lo q se usa para listar en admin?

    public function TotallistaRazas(){
        $resultados = $this->obtenData("SELECT COUNT(*) AS TotalRazasAnimal
                                        FROM raza");
        return $resultados[0]['TotalRazasAnimal'];
    }

    public function consultaTipoAnimal(){//Esto esta haciendo lo mismo que hace otra
        //podria hacerlo pero prefiero que funcione ahora a que no funcione y me ocupe en ello
        $resultados = $this->obtenData("SELECT id_tipo, nombre FROM tipo_animal");
        if ($resultados){
            return $resultados;
        } else {
            return false;
        }
    }

    public function consultaRazaAnimal($id_tipo){
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
        $data['cedula'] = $rif;
        $data['nombre'] = $nombre;
        $data['rol_id'] = $rol;
        $data['direccion'] = $direccion;
        $data['contrasenia'] = $contrasenia;
        $data['activo'] = $estado;
        $data['telefono'] = $tlf;
        $verificar = $this->obtenData("SELECT cedula, nombre, contrasenia, activo, rol_id
                                        FROM usuarios
                                        WHERE cedula = '$rif'");
        if($verificar){//se verifica si existe un usuario con esa ced y si si retorna falso
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
        $data['nombre'] = $nombre;

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
        $data['nombre'] = $nombre;
        $data['id_tipo_animal'] = $tiporaza;
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
        $data['nombre'] = $nom;
        $data['anio_nac'] = $anionac;
        $data['img'] = $nomimg;
        $data['descripcion'] = $descripcion;
        $data['fecha_ingreso'] = $fecha_ing;
        $data['raza_id'] = $id_raza;
        $data['tamanio_id'] = $tamano_id;
        $data['albergue_id'] = $albergue;
        $data['visible'] = $visible;
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
        $data['nombre'] = $nombre;
        $data['tlf'] = $telefono;
        $data['direccion'] = $direccion;
        $data['img'] = $img;
        $data['visible'] = 1;
        $data['usuario_Rveterinario'] = $adminregistra;
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
        $arry['usuario_bit'] = $user;
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
                                    $activo,$telefono, $usuario_modificando){
        $anterior = $this->obtenData("SELECT cedula, nombre, rol_id, direccion, activo, telefono
                                        FROM usuarios WHERE cedula = '$idusuario'");
        $data['cedula'] = $idusuario;
        $data['nombre'] = $nombre;
        $data['rol_id'] = $rol;
        $data['direccion'] = $direccion;
        $data['contrasenia'] = $contrasena;
        $data['activo'] = $activo;
        $data['telefono'] = $telefono;
        $modificaUsuario = $this->actualizaData("usuarios",$data,"cedula = '$idusuario'");

        $nuevo = $this->obtenData("SELECT cedula, nombre, rol_id, direccion, activo, telefono
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
        $data['nombre'] = $nom;
        $data['anio_nac'] = $anionac;
        $data['img'] = $nomimg;
        $data['descripcion'] = $descripcion;
        $data['raza_id'] = $id_raza;
        $data['tamanio_id'] = $tamano_id;
        $data['albergue_id'] = $albergue;
        $data['visible'] = $visible;
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
        
        $data['nombre'] = $nombre;
        $data['tlf'] = $tlf;
        $data['direccion'] = $direccion;
        $data['img'] = $img;
        $data['visible'] = $visible;
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
        //Probar 3
        $anterior = $this->obtenData("SELECT nombre
                                        FROM tipo_animal WHERE id_tipo = '$id_tipo'");

        $data['nombre'] = $nombre;
        $modificaTipoAnimal = $this->actualizaData('tipo_animal', $data, "id_tipo = '$id_tipo'");

        $nuevo = $this->obtenData("SELECT nombre
                                    FROM tipo_animal WHERE id_tipo = '$id_tipo'");

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
        //Probar 4
        $anterior = $this->obtenData("SELECT nombre, id_tipo_animal
                                        FROM raza WHERE id_raza = '$id_raza'");

        $data['nombre'] = $nombre;
        $data['id_tipo_animal'] = $tipoAnimal;
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
}
?>