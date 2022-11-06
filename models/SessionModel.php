<?php 

class SessionModel extends ConexionBD{
    public function loginUser($cedula, $contra){
        $result = $this->obtenData("SELECT cedula, nombre, contrasenia, activo, rol_id FROM usuarios 
                    WHERE cedula = '$cedula' AND contrasenia = '$contra'");
        if ($result){
            return $result;
        } else {
            return false;
        }
    }

    public function consultarVeterinarios($id_veterinario, $pagina, $qty){
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
//falta telefono usuario
    public function registerUser($ced,$nombre,$direcc,$contra,$telefono){
        $data['cedula'] = $ced; //rif del usuario 
        $data['nombre'] = $nombre; // nombre del usuario
        $data['rol_id'] = 2; //identificador del rol
        $data['direccion'] = $direcc; //direccion del usuario
        $data['contrasenia'] = $contra; //contraseña del usuario a registrar
        $data['activo'] = 1;
        $data['telefono'] = $telefono;
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

    public function obtenAnimales(){
        $result = $this->obtenData("SELECT DISTINCT a.id_animal, a.nombre, a.anio_nac, a.img, a.descripcion, a.fecha_ingreso, 
                                        b.nombre as nomRaza, c.nombre as tamanio, d.nombre as albergue
                                    FROM animal a
                                    INNER JOIN raza b ON a.raza_id = b.id_raza
                                    INNER JOIN tamanio c ON a.tamanio_id = c.id_tamanio
                                    INNER JOIN albergue d ON a.albergue_id = d.id_albergue
                                    LEFT JOIN adopcion e ON a.id_animal = e.animal_id
                                    WHERE (a.visible = '1') AND (e.estado IN ('1','2') OR e.estado IS NULL) AND (d.activo = '1')");
                                    //creo que ya funciona
        if($result){
            return $result;
        } else {
            return false;
        }
    }

    public function ObtenAnimalSelecc($id){
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
        $resultado = $this->obtenData("SELECT id_veterinario, nombre, tlf, direccion, img
                                      FROM veterinario 
                                      WHERE id_veterinario = '$idveterinario'");
        if($resultado){
            return $resultado;
        } else {
            return false;
        }
    }

    public function verificaExistencia($idAnimal, $iduser){
        $resultado = $this->obtenData("SELECT animal_id, cedula_usuario, estado
                                        FROM adopcion");
        return $resultado;
    }

    public function registraPeticionAdopcion($idAnimal, $user){
        $data['fecha_adopcion'] = "Now()";
        $data['animal_id'] = $idAnimal;
        $data['cedula_usuario'] = $user;
        $data['estado'] = "1";
        return $this->grabaData('adopcion',$data);
    }//Deberia hacerle bitacora a esto?

    public function retornaResponsable($iduser){//aca no hace falta revisar si es real pq ya se verifica antes
        $resultado = $this->obtenData("SELECT nombre, telefono
                                       FROM usuarios
                                       WHERE cedula = '$iduser'");
        return $resultado;
    }
}
?>