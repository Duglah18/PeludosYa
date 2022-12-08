<?php

class SessionModel extends ConexionBD{
    public function consultarVeterinarios($id_veterinario, $pagina, $qty){
        $id_veterinario = mysqli_real_escape_string($this->conectar(),$id_veterinario);
        if($pagina <= 0){ $pagina = 1; }
        $desde = ($pagina - 1) * $qty;
        $resultado = $this->obtenData("SELECT id_veterinario, nombre, tlf, direccion, img, visible, usuario_Rveterinario
                          FROM veterinario
                          WHERE id_veterinario = CASE WHEN '$id_veterinario' = '' THEN id_veterinario ELSE '$id_veterinario' END
                          AND visible = 1
                          LIMIT $desde, $qty");
        return $resultado;
    }

    public function TotalVeterinarios(){
        $numTotal = $this->obtenData("SELECT COUNT(*) AS TotalVeter
                                        FROM veterinario
                                        WHERE visible = 1");
        return $numTotal[0]['TotalVeter'];
    }

    public function obtenAnimales($pagina, $qty, $filtro =""){
        if($pagina <= 0){ $pagina = 1; }
        $desde = ($pagina - 1) * $qty;
        $result = $this->obtenData("SELECT DISTINCT a.id_animal, a.nombre, a.anio_nac, a.img, a.descripcion, a.fecha_ingreso, 
                                        b.nombre as nomRaza, c.nombre as tamanio, d.nombre as albergue
                                    FROM animal a
                                    INNER JOIN raza b ON a.raza_id = b.id_raza
                                    INNER JOIN tamanio c ON a.tamanio_id = c.id_tamanio
                                    INNER JOIN albergue d ON a.albergue_id = d.id_albergue
                                    LEFT JOIN adopcion e ON a.id_animal = e.animal_id
                                    WHERE 
											(a.visible = '1') AND (e.estado IN ('1','2') OR e.estado IS NULL) AND (d.activo = '1') AND
											(b.id_tipo_animal = CASE WHEN '$filtro' = '' THEN b.id_tipo_animal ELSE '$filtro' END)
                                    LIMIT $desde, $qty");
                                    //creo que ya funciona
        if($result){
            return $result;
        } else {
            return false;
        }
    }

    public function TotalAnimalesCatalogoSess($filtro =""){
        $numTotal = $this->ObtenData("SELECT COUNT(DISTINCT a.id_animal) AS TotalAnimales
                                        FROM animal a
                                        INNER JOIN raza b ON a.raza_id = b.id_raza
                                        INNER JOIN tamanio c ON a.tamanio_id = c.id_tamanio
                                        INNER JOIN albergue d ON a.albergue_id = d.id_albergue
                                        LEFT JOIN adopcion e ON a.id_animal = e.animal_id
                                        WHERE 
                                        ((a.visible = '1') AND (e.estado IN ('1','2') OR e.estado IS NULL) AND (d.activo = '1')) AND 
                                        (b.id_tipo_animal = CASE WHEN '$filtro' = '' THEN b.id_tipo_animal ELSE '$filtro' END)");
        return $numTotal[0]['TotalAnimales'];
    }

    
    public function consultaFundaciones($pagina, $qty){
        if($pagina <= 0){ $pagina = 1; }
        $desde = ($pagina - 1) * $qty;
        $retorno = $this->obtenData("SELECT cedula, nombre, direccion, telefono
                                        FROM usuarios
                                        WHERE rol_id = 3 AND activo = 1
                                        LIMIT $desde,$qty");
        return $retorno;
    }

    public function TotalconsultaFundaciones(){
        $retorno = $this->obtenData("SELECT COUNT(*) AS TotalconsultaFundaciones
                                        FROM usuarios
                                        WHERE rol_id = 3 AND activo = 1");
        return $retorno[0]['TotalconsultaFundaciones'];
    }

    public function ObtenAnimalSelecc($id){
        $id = mysqli_real_escape_string($this->conectar(),$id);
        $resultado = $this->obtenData("SELECT a.id_animal, a.nombre, a.anio_nac, a.img, a.descripcion, a.fecha_ingreso, 
                                              b.nombre as nomRaza, c.nombre as tamanio, d.nombre as albergue, a.visible
                                      FROM animal a
                                      INNER JOIN raza b ON a.raza_id = b.id_raza
                                      INNER JOIN tamanio c ON a.tamanio_id = c.id_tamanio
                                      INNER JOIN albergue d ON a.albergue_id = d.id_albergue
                                      WHERE a.id_animal = '$id'");
        if($resultado){
            return $resultado;
        } else {
            return false;
        }
    }

    public function ObtenVeterinarioSelecc($idveterinario){
        $idveterinario = mysqli_real_escape_string($this->conectar(),$idveterinario);
        $resultado = $this->obtenData("SELECT id_veterinario, nombre, tlf, direccion, img
                                      FROM veterinario 
                                      WHERE id_veterinario = '$idveterinario'");
        if($resultado){
            return $resultado;
        } else {
            return false;
        }
    }

    public function loginUser($cedula, $contra){
        $cedula = mysqli_real_escape_string($this->conectar(),$cedula);
        $contra = mysqli_real_escape_string($this->conectar(),$contra);
        $result = $this->obtenData("SELECT cedula, nombre, contrasenia, activo, rol_id 
                                    FROM usuarios 
                                    WHERE cedula = '$cedula' AND contrasenia = '$contra'");
        if ($result){
            $arry['usuario_bit'] = $cedula;
            $arry['modulo_afectado'] = 'Usuario Logueandose';
            $arry['accion_realizada'] = "Logueandose";
            $arry['valor_actual'] = implode("; ",$result[0]);
            $arry['fecha_accion'] ='Now()';
            $this->grabaData("bitacoras",$arry);

            return $result;
        } else {
            return false;
        }
    }

    public function registerUser($ced,$nombre,$direcc,$contra,$telefono){
        $data['cedula'] = mysqli_real_escape_string($this->conectar(),$ced); //rif del usuario 
        $data['nombre'] = mysqli_real_escape_string($this->conectar(),$nombre); // nombre del usuario
        $data['rol_id'] = 2; //identificador del rol
        $data['direccion'] = mysqli_real_escape_string($this->conectar(),$direcc); //direccion del usuario
        $data['contrasenia'] = mysqli_real_escape_string($this->conectar(),$contra); //contraseña del usuario a registrar
        $data['activo'] = 1;
        $data['telefono'] = mysqli_real_escape_string($this->conectar(),$telefono);
        //primero verificamos si existimos 
        $verificar = $this->obtenData("SELECT cedula, nombre, contrasenia, activo, rol_id
                                       FROM usuarios
                                       WHERE cedula = '$ced'");
        if ($verificar){
            return "Usuario ya registrado";
        } elseif(!$verificar) {
            $registraUsuario = $this->grabaData('usuarios',$data);

            if(is_bool($registraUsuario)){
                return false;
            }

            
        $ingresando = $this->creaCadenaInsert($data, 'usuarios');
        $arry['usuario_bit'] = $ced;
        $arry['modulo_afectado'] = 'Usuario Registrandose';
        $arry['accion_realizada'] = $ingresando;
        $arry['valor_actual'] = implode("; ",$data);
        $arry['fecha_accion'] ='Now()';

        $bitacora = $this->grabaData("bitacoras",$arry);

        if (!$bitacora){
            return false;
        }
        return $bitacora;

        }
    }

	//Creado en la oficina 11/11/2022
	public function consultaUsuarioEspecifico($identify){
        $identify = mysqli_real_escape_string($this->conectar(),$identify);
		$buscar = $this->ObtenData("SELECT cedula, nombre, direccion ,contrasenia, telefono, activo
                                       FROM usuarios
                                       WHERE cedula = '$identify' AND activo = 1");
		if(!$buscar){
		return "No existe";
		}
		return $buscar;
	}

    
    public function verificaExistencia($idAnimal, $iduser){
        $idAnimal = mysqli_real_escape_string($this->conectar(),$idAnimal);
        $iduser = mysqli_real_escape_string($this->conectar(),$iduser);
        $resultado = $this->obtenData("SELECT animal_id, cedula_usuario, estado
                                        FROM adopcion
                                        WHERE animal_id = '$idAnimal' AND 
                                              cedula_usuario = '$iduser' AND 
                                              estado = 1 OR estado = 2");
        return $resultado;
    }

    public function registraPeticionAdopcion($idAnimal, $user){
		//Validacion de si el animal q se esta pidiendo ya fue adoptado
		$objVerificacion = $this->ObtenData("SELECT a.id_animal, a.visible
											FROM animal a
											INNER JOIN adopcion f ON a.id_animal = f.animal_id
											WHERE id_animal = '$idAnimal' AND f.estado = 3");
		if($objVerificacion){
			return "Este Animal Ya fue adoptado"; //se verifica si la adopcion esta completada si es asi
		}
		
        $data['fecha_adopcion'] = "Now()";
        $data['animal_id'] = mysqli_real_escape_string($this->conectar(),$idAnimal);
        $data['cedula_usuario'] = mysqli_real_escape_string($this->conectar(),$user);
        $data['estado'] = "1";
        $registraPeticion = $this->grabaData('adopcion',$data);

        if (is_bool($registraPeticion)){
            return false;
        }
        $ingresando = $this->creaCadenaInsert($data, 'adopcion');
        $arry['usuario_bit'] = $user;
        $arry['modulo_afectado'] = 'Usuario Pidiendo Adopcion';
        $arry['accion_realizada'] = $ingresando;
        $arry['valor_actual'] = implode("; ",$data);
        $arry['fecha_accion'] ='Now()';

        $bitacora = $this->grabaData("bitacoras",$arry);

        if (!$bitacora){
            return false;
        }
        return $bitacora;
    }

    public function retornaResponsable($iduser){//aca no hace falta revisar si es real pq ya se verifica antes
        $iduser = mysqli_real_escape_string($this->conectar(),$iduser);
        $resultado = $this->obtenData("SELECT nombre, telefono
                                       FROM usuarios
                                       WHERE cedula = '$iduser'");
        return $resultado;
    }

    public function modificaUsuario($idusuario,$nombre,$direccion,$contrasena,$telefono){
        $idusuario = mysqli_real_escape_string($this->conectar(),$idusuario);
        $anterior = $this->obtenData("SELECT cedula, nombre, rol_id, direccion, activo, telefono
                                        FROM usuarios WHERE cedula = '$idusuario'");
        $data['nombre'] = mysqli_real_escape_string($this->conectar(),$nombre);
        $data['direccion'] = mysqli_real_escape_string($this->conectar(),$direccion);
        $data['contrasenia'] = mysqli_real_escape_string($this->conectar(),$contrasena);
        $data['telefono'] = mysqli_real_escape_string($this->conectar(),$telefono);
        $modificaUsuario = $this->actualizaData("usuarios",$data,"cedula = '$idusuario'");

        $nuevo = $this->obtenData("SELECT cedula, nombre, rol_id, direccion, activo, telefono
                                    FROM usuarios WHERE cedula = '$idusuario'");
        if(is_bool($modificaUsuario) && $modificaUsuario == false){
            return "false";
        }
        $arra['usuario_bit'] = $idusuario;
        $arra['modulo_afectado'] = 'Modifica Usuario Propio';
        $arra['accion_realizada'] = $this->creaCadenaUpdate('usuarios',$data, "cedula = " . $idusuario);
        $arra['valor_anterior'] = implode(";", $anterior[0]);
        $arra['valor_actual'] = implode("; ",$nuevo[0]);
        $arra['fecha_accion'] ='Now()';

        return $this->grabaData("bitacoras", $arra);
    }
}
?>