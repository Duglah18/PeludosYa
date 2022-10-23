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
//falta telefono usuario
    public function registerUser($ced,$nombre,$direcc,$contra){
        $data['cedula'] = $ced; //rif del usuario 
        $data['nombre'] = $nombre; // nombre del usuario
        $data['rol_id'] = 2; //identificador del rol
        $data['direccion'] = $direcc; //direccion del usuario
        $data['contrasenia'] = $contra; //contraseña del usuario a registrar
        $data['activo'] = 1;
        //primero verificamos si existimos 
        $verificar = $this->obtenData("SELECT cedula, nombre, contrasenia, activo, rol_id
                                       FROM usuarios
                                       WHERE cedula = '$ced'");
        if ($verificar){
            return "Usuario ya registrado";
        } else {

        return $this->grabaData('usuarios',$data);
        }
    }

    public function obtenAnimales(){
        $result = $this->obtenData("SELECT a.id_animal, a.nombre, a.anio_nac, a.img, a.descripcion, a.fecha_ingreso, 
                                        b.nombre as nomRaza, c.nombre as tamanio, d.nombre as albergue
                                    FROM animal a
                                    INNER JOIN raza b ON a.raza_id = b.id_raza
                                    INNER JOIN tamanio c ON a.tamanio_id = c.id_tamanio
                                    INNER JOIN albergue d ON a.albergue_id = d.id_albergue
                                    WHERE visible = 1");
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
    }

    public function retornaResponsable($iduser){//aca no hace falta revisar si es real pq ya se verifica antes
        $resultado = $this->obtenData("SELECT nombre, telefono
                                       FROM usuarios
                                       WHERE cedula = '$iduser'");
        return $resultado;
    }
}
?>