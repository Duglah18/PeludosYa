<?php 

class FundacionModel extends ConexionBD{
    public function registraAlberg($tabla, $nombre, $direcc, $ced_us, $estat){//esta no se usa :v creo 
        $data['nombre'] = $nombre;
        $data['direccion'] = $direcc;
        $data['cedula_usuario'] = $ced_us;
        $data['activo'] = $estat;
        return $this->grabaData($tabla, $data);
    }

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

    public function consultaAdopciones($fundacion){
        $resultados = $this->obtenData("SELECT a.id_adopcion, a.fecha_adopcion, b.nombre as nombreanimal, 
                                               d.nombre as nombreusuario, c.nombre as nombrealbergue,
                                               e.nombre_estado 
                                        FROM adopcion a
                                        INNER JOIN animal b ON a.animal_id = b.id_animal
                                        INNER JOIN albergue c ON b.albergue_id = c.id_albergue
                                        INNER JOIN usuarios d ON c.cedula_usuario = d.cedula
                                        INNER JOIN tipo_estado_adopcion e ON a.estado = e.id_tipo_estado
                                        WHERE d.cedula = '$fundacion' AND a.estado = '1'");
        if($resultados){
            return $resultados;
        } else {
            return false;
        }
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

    public function consultaAlbergue($cedula_user){
        $resultados = $this->obtenData("SELECT a.id_albergue, a.nombre, a.direccion, a.activo, b.nombre as nombreusuario
                                        FROM albergue a
                                        INNER JOIN usuarios b ON a.cedula_usuario = b.cedula
                                        WHERE (cedula_usuario = CASE WHEN '$cedula_user' = '' THEN cedula_usuario ELSE '$cedula_user' END)");
        if ($resultados){
            return $resultados;
        } else {
            return false;
        }
    }

    public function consultaAnimales($cedula_user){
        $resultados = $this->obtenData("SELECT a.id_animal, a.nombre, a.anio_nac, a.img, 
                                                a.fecha_ingreso, b.nombre as nomraza, c.nombre as nomtipo,
                                                e.nombre as nomalbergue, d.nombre as nombreUser
                                        FROM animal a
                                        INNER JOIN raza b ON a.raza_id = b.id_raza
                                        INNER JOIN tipo_animal c ON c.id_tipo = b.id_tipo_animal
                                        INNER JOIN albergue e ON e.id_albergue = a.albergue_id
                                        INNER JOIN usuarios d ON d.cedula = e.cedula_usuario
                                        WHERE (d.cedula = CASE WHEN '$cedula_user' = '' THEN d.cedula ELSE '$cedula_user' END)");
        /*Inciso: CASE ES COMO SWITCH O IF EN SQL EN ESTE CASO SI LLEGA VACIO $cedula_user ENTONCES
        MOSTRARA TODOS LOS CONTENIDOS DE LA TABLA PQ NO LO APLIQUE ANTES? PS DE PANA LO APRENDI HACE
        POCO RELATIVAMENTE */
       if ($resultados){
            return $resultados;
        } else {
            return false;
        }
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

    public function decisionAdopcion($identificador, $estadonuevo, $usuario){
        //primero se pide luego se guarda en bitacora
        $anterior = $this->obtenData("SELECT estado FROM adopcion WHERE id_adopcion = '$identificador'");
        if ($anterior[0][0] == $estadonuevo){
            return false;
        }
        $data['estado'] = $estadonuevo;
        $actualiza = $this->actualizaData('adopcion',$data, "id_adopcion = " . $identificador);
        
        $nuevo = $this->obtenData("SELECT estado FROM adopcion WHERE id_adopcion = '$identificador'");
        
        $arra['usuario_bit'] = $usuario;
        $arra['modulo_afectado'] = 'Modifica Adopcion';
        $arra['accion_realizada'] = $this->creaCadenaUpdate('adopcion',$data, "id_adopcion = " . $identificador);
        $arra['valor_anterior'] = $nuevo[0][0];
        $arra['valor_actual'] = $anterior[0][0];
        $arra['fecha_accion'] ='Now()';

        if (!$actualiza){
            return false;
        }
        return $this->grabaData("bitacoras", $arra);
    }
}
?>