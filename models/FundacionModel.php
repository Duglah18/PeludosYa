<?php 

class FundacionModel extends ConexionBD{
    public function registraAlberg($tabla, $nombre, $direcc, $ced_us, $estat){//esta no se usa :v creo 
        $data['nombre'] = $nombre;
        $data['direccion'] = $direcc;
        $data['cedula_usuario'] = $ced_us;
        $data['activo'] = $estat;
        return $this->grabaData($tabla, $data);
    }
	//Esto revisa si se sigue usando y para que 
    public function consultaUser(){//esto a futuro abra q borrarlo luego esto es para mostrar
        //los usuarios a registrarles los albergues cuando halla sessions se quitara
        $resultados = $this->obtenData("SELECT cedula, rol_id, nombre FROM usuarios WHERE rol_id = 3");
        if ($resultados) {
            return $resultados;
        } else {
            return false;
        }
    }

    public function consultaAlberguePorID($id_albergue){
        $resultado = $this->obtenData("SELECT id_albergue, nombre, direccion, cedula_usuario, activo
                                      FROM albergue 
                                      WHERE id_albergue = CASE WHEN '$id_albergue' = '' THEN id_albergue ELSE '$id_albergue' END");

        if(!$resultado){
            return false;
        }

        return $resultado;
    }

    public function consultaAdopciones($fundacion,$pagina,$qty){
        if ($pagina <= 0){ $pagina = 1; }
        $desde = ($pagina - 1) * $qty;
        $resultados = $this->obtenData("SELECT a.id_adopcion, a.fecha_adopcion, b.nombre as nombreanimal, 
                                               j.nombre as nombreusuario, j.telefono, c.nombre as nombrealbergue,
                                               e.nombre_estado, j.detalles
                                        FROM adopcion a
										INNER JOIN usuarios j ON j.cedula = a.cedula_usuario
                                        INNER JOIN animal b ON a.animal_id = b.id_animal
                                        INNER JOIN albergue c ON b.albergue_id = c.id_albergue
                                        INNER JOIN usuarios d ON c.cedula_usuario = d.cedula
                                        INNER JOIN tipo_estado_adopcion e ON a.estado = e.id_tipo_estado
                                        WHERE d.cedula = '$fundacion' AND a.estado = '1'
										ORDER BY a.fecha_adopcion ASC
										LIMIT $desde,$qty");
        if($resultados){//las ordeno de manera ascendente para que las mas antiguas salgan primero
            return $resultados;
        } else {
            return false;
        }
    }

    public function TotalconsultaAdopciones($fundacion){
        $resultados = $this->obtenData("SELECT COUNT(*) AS TotalAdopciones
                                        FROM adopcion a
										INNER JOIN usuarios j ON j.cedula = a.cedula_usuario
                                        INNER JOIN animal b ON a.animal_id = b.id_animal
                                        INNER JOIN albergue c ON b.albergue_id = c.id_albergue
                                        INNER JOIN usuarios d ON c.cedula_usuario = d.cedula
                                        INNER JOIN tipo_estado_adopcion e ON a.estado = e.id_tipo_estado
                                        WHERE d.cedula = '$fundacion' AND a.estado = '1'");
        return $resultados[0]['TotalAdopciones'];
    }

    public function consultaAdopcionEspecifica($identificador_adop){
        $resultados = $this->obtenData("SELECT a.id_adopcion, a.fecha_adopcion,b.nombre as nombreAnimal, 
                                                a.estado, c.nombre as nombreUsuario
                                        FROM adopcion a
                                        INNER JOIN animal b ON a.animal_id = b.id_animal
                                        INNER JOIN usuarios c ON a.cedula_usuario = c.cedula
                                        WHERE a.id_adopcion = '$identificador_adop'");

        if(!$resultados){
            return false;
        }
        return $resultados;
    }

    public function consultaEstadosAdopciones(){//Esto sera para cargar un select de cada una de las
        //opciones que se pueden cambiar del estado de una adopcion
        $resultados = $this->obtenData("SELECT id_tipo_estado, nombre_estado
                                        FROM tipo_estado_adopcion");

        if(!$resultados){
            return false;
        }
        return $resultados;
    }

    public function consultaAlbergue($cedula_user,$pagina = 1,$qty = 1){
        if ($pagina <= 0){ $pagina = 1; }
        $desde = ($pagina - 1) * $qty;
        $resultados = $this->obtenData("SELECT a.id_albergue, a.nombre, a.direccion, a.activo, b.nombre as nombreusuario
                                        FROM albergue a
                                        INNER JOIN usuarios b ON a.cedula_usuario = b.cedula
                                        WHERE (cedula_usuario = CASE WHEN '$cedula_user' = '' THEN cedula_usuario ELSE '$cedula_user' END)
                                        LIMIT $desde,$qty");
        if ($resultados){
            return $resultados;
        } else {
            return false;
        }
    }

    public function TotalconsultaAlbergues($cedula_user){
        $resultados = $this->obtenData("SELECT COUNT(*) AS TotalAlbergues
                                        FROM albergue a
                                        INNER JOIN usuarios b ON a.cedula_usuario = b.cedula
                                        WHERE (cedula_usuario = CASE WHEN '$cedula_user' = '' THEN cedula_usuario ELSE '$cedula_user' END)");
        
        return $resultados[0]['TotalAlbergues'];
    }
//modificado pienso yo que sumara los resultados que halla del numero de adopciones de cada animal
    public function consultaAnimales($cedula_user, $pagina = 1, $qty = 10){
        if ($pagina <= 0){ $pagina = 1; }
        $desde = ($pagina - 1) * $qty;
        $resultados = $this->obtenData("SELECT a.id_animal, a.nombre, a.anio_nac, a.img, 
                                                a.fecha_ingreso, b.nombre as nomraza, c.nombre as nomtipo,
                                                e.nombre as nomalbergue, d.nombre as nombreUser, a.visible,
                                                CASE WHEN f.estado IN ('1','2') OR f.estado IS NULL  THEN 'No' ELSE 'Si' END AS Adoptado
                                        FROM animal a
                                        INNER JOIN raza b ON a.raza_id = b.id_raza
                                        INNER JOIN tipo_animal c ON c.id_tipo = b.id_tipo_animal
                                        INNER JOIN albergue e ON e.id_albergue = a.albergue_id
                                        INNER JOIN usuarios d ON d.cedula = e.cedula_usuario
										LEFT JOIN adopcion f ON a.id_animal = f.animal_id
                                        WHERE (d.cedula = CASE WHEN '$cedula_user' = '' THEN d.cedula ELSE '$cedula_user' END)
                                        ORDER BY a.id_animal DESC, a.visible ASC
                                        LIMIT $desde,$qty");
        /*Inciso: CASE ES COMO SWITCH O IF EN SQL (TRANSACT SQL) EN ESTE CASO SI LLEGA VACIO $cedula_user ENTONCES
        MOSTRARA TODOS LOS CONTENIDOS DE LA TABLA PQ NO LO APLIQUE ANTES? PS DE PANA LO APRENDI HACE
        POCO RELATIVAMENTE */
		//Probar ya que modifique para que solo salgan animales que sean visibles para que parezcan borrados
       if ($resultados){
            return $resultados;
        } else {
            return false;
        }
    } 

    public function TotalConsultaAnimales($usuario = ""){ //Esto se usaba para fundacion para ver los animales?
        $resultados = $this->obtenData("SELECT COUNT(*) AS TotalAnimales
                                        FROM animal a
                                        INNER JOIN raza b ON a.raza_id = b.id_raza
                                        INNER JOIN tipo_animal c ON c.id_tipo = b.id_tipo_animal
                                        INNER JOIN albergue e ON e.id_albergue = a.albergue_id
                                        INNER JOIN usuarios d ON d.cedula = e.cedula_usuario
                                        WHERE (d.cedula = CASE WHEN '$usuario' = '' THEN d.cedula ELSE '$usuario' END)");
        return $resultados[0]['TotalAnimales'];
    }

    public function consultaTipoAnimal(){
        $resultados = $this->obtenData("SELECT id_tipo, nombre FROM tipo_animal");
        if ($resultados){
            return $resultados;
        } else {
            return false;
        }
    }
	
	public function TotalConsultaTipoAnimal(){
		$resultados = $this->obtenData("SELECT COUNT(*) AS TotalTipoAnimales FROM tipo_animal");
		return $resultados[0]['TotalTipoAnimales'];
	}

    public function consultaRazaAnimal($id_tipo){
        $resultados = $this->obtenData("SELECT a.id_raza, a.nombre, b.nombre AS nombredeTanimal
                                        FROM raza a
                                        INNER JOIN tipo_animal b ON a.id_tipo_animal = b.id_tipo
                                        WHERE a.id_tipo_animal = CASE WHEN '$id_tipo' = '' THEN a.id_tipo_animal ELSE '$id_tipo' END");
        if ($resultados){
            return $resultados;
        } else {
            return false;
        }
    }
	
	public function TotalConsultaRazaAnimal($id_tipo){
		$resultados = $this->obtenData("SELECT COUNT(*) AS TotalRazaAnimales FROM raza 
                                        WHERE id_tipo_animal = CASE WHEN '$id_tipo' = '' THEN id_tipo_animal ELSE '$id_tipo' END");
		return $resultados[0]['TotalRazaAnimales'];
	}

    public function consultaTamanoAnimal(){//Esta creo yo no necesita paginacion
        $resultados = $this->obtenData("SELECT id_tamanio, nombre FROM tamanio");
        if ($resultados){
            return $resultados;
        } else {
            return false;
        }
    }

    public function registraAlbergue($tabla, $rif, $nombre, $direccion, $estado){
        $data['nombre'] = $nombre;
        $data['direccion'] = $direccion;
        $data['cedula_usuario'] = $rif;
        $data['activo'] = $estado;
        $registrandoAlbergue = $this->grabaData($tabla,$data);

        if(is_bool($registrandoAlbergue)){
            return false;
        }

        $ingresando = $this->creaCadenaInsert($data, $tabla);
        $arry['usuario_bit'] = $rif;
        $arry['modulo_afectado'] = 'Añadir Albergue';
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
        $arry['modulo_afectado'] = 'Añadir Animal';
        $arry['accion_realizada'] = $ingresando;
        $arry['valor_actual'] = implode("; ",$data);
        $arry['fecha_accion'] ='Now()';

        $bitacora = $this->grabaData("bitacoras",$arry);

        if (!$bitacora){
            return false;
        }
        return $bitacora;
    }

    public function modificaAlbergue($id_albergue, $nombre, $usuario, $direccion, $activo, $usuario_modificando){
        $anterior = $this->obtenData("SELECT nombre, direccion, cedula_usuario, activo
                                        FROM albergue WHERE id_albergue = '$id_albergue'");
        $data['nombre'] = $nombre;
        $data['direccion'] = $direccion;
        $data['cedula_usuario'] = $usuario;
        $data['activo'] = $activo;
        $modificaAlbergue = $this->actualizaData('albergue',$data, "id_albergue = '$id_albergue'");

        $nuevo = $this->obtenData("SELECT nombre, direccion, cedula_usuario, activo
                                    FROM albergue WHERE id_albergue = '$id_albergue'");

        if(!$modificaAlbergue){
            return false;
        }
        $arra['usuario_bit'] = $usuario_modificando;
        $arra['modulo_afectado'] = 'Modifica Usuario';
        $arra['accion_realizada'] = $this->creaCadenaUpdate('albergue',$data, "id_albergue = " . $id_albergue);
        $arra['valor_anterior'] = implode(";", $anterior[0]);
        $arra['valor_actual'] = implode("; ",$nuevo[0]);
        $arra['fecha_accion'] ='Now()';

        return $this->grabaData("bitacoras", $arra);
    }

    public function decisionAdopcion($identificador, $estadonuevo, $razon, $usuario){
        //primero se pide luego se guarda en bitacora
        $anterior = $this->obtenData("SELECT estado FROM adopcion WHERE id_adopcion = '$identificador'");
        $anteriorUser = $this->obtenData("SELECT a.cedula, a.detalles FROM usuarios a 
                                            INNER JOIN adopcion b ON a.cedula = b.cedula_usuario
                                            WHERE b.id_adopcion = '$identificador'");
        // if ($anterior[0][0] == $estadonuevo){
            // return false;
        // } Era para verificar si recargabas pero ya 
        $data['estado'] = $estadonuevo;
        $actualiza = $this->actualizaData('adopcion',$data, "id_adopcion = " . $identificador);
        $modifica = $anteriorUser[0]['cedula'];
        $dataUser['detalles'] = $razon;
        $this->actualizaData("usuarios",$dataUser,"cedula = '$modifica'");

        $nuevoUser = $this->obtenData("SELECT detalles FROM usuarios a 
                                        INNER JOIN adopcion b ON a.cedula = b.cedula_usuario
                                        WHERE b.id_adopcion = '$identificador'");
        $nuevo = $this->obtenData("SELECT estado FROM adopcion WHERE id_adopcion = '$identificador'");
        
        $arra['usuario_bit'] = $usuario;
        $arra['modulo_afectado'] = 'Modifica Adopcion';
        $arra['accion_realizada'] = $this->creaCadenaUpdate('adopcion',$data, "id_adopcion = " . $identificador);
        $arra['valor_anterior'] = $anterior[0][0];
        $arra['valor_actual'] = $nuevo[0][0];
        $arra['fecha_accion'] ='Now()';

        $arraUser['usuario_bit'] = $usuario;
        $arraUser['modulo_afectado'] = 'Modifica Usuario Razon';
        $arraUser['accion_realizada'] = $this->creaCadenaUpdate("usuarios",$dataUser,"cedula = ".$anteriorUser[0]['cedula']);
        $arraUser['valor_anterior'] = implode("; ",$anteriorUser[0]);
        $arraUser['valor_actual'] = implode("; ", $nuevoUser[0]);
        $arraUser['fecha_accion'] ='Now()';
        $this->grabaData("bitacoras", $arraUser);
        if (!$actualiza){
            return false;
        }
        return $this->grabaData("bitacoras", $arra);
    }

    public function DecisionActivacionPeludos($id_peludo, $decision, $usuario_modificando){
        $id_peludo = mysqli_real_escape_string($this->conectar(),$id_peludo);
        $anterior = $this->obtenData("SELECT id_animal, visible
                                        FROM animal 
                                        WHERE id_animal = '$id_peludo'");
        $data['visible'] = $decision;

        $modificaActivacionUsuario = $this->actualizaData('animal', $data, "id_animal = '$id_peludo'");

        $nuevo = $this->obtenData("SELECT id_animal, visible
                                    FROM animal 
                                    WHERE id_animal = '$id_peludo'");

        if(!$modificaActivacionUsuario){
            return false;
        }

        $arra['usuario_bit'] = $usuario_modificando;
        $arra['modulo_afectado'] = 'Modifica Visibilidad Peludo Fundacion';
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

        $modificaActivacionUsuario = $this->actualizaData('albergue', $data, "id_albergue = '$id_albergue'");

        $nuevo = $this->obtenData("SELECT id_albergue, activo
                                    FROM albergue 
                                    WHERE id_albergue = '$id_albergue'");

        if(!$modificaActivacionUsuario){
            return false;
        }

        $arra['usuario_bit'] = $usuario_modificando;
        $arra['modulo_afectado'] = 'Modifica Visibilidad Albergue Fundacion';
        $arra['accion_realizada'] = $this->creaCadenaUpdate('albergue',$data, "id_albergue = " . $id_albergue);
        $arra['valor_anterior'] = implode(";", $anterior[0]);
        $arra['valor_actual'] = implode("; ",$nuevo[0]);
        $arra['fecha_accion'] ='Now()';

        return $this->grabaData("bitacoras", $arra);
    }
}
?>