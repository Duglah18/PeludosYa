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
        $table = "usuarios";
        $data['cedula'] = $ced; //rif del usuario 
        $data['nombre'] = $nombre; // nombre del usuario
        $data['rol_id'] = 2; //identificador del rol
        $data['direccion'] = $direcc; //direccion del usuario
        $data['contrasenia'] = $contra; //contraseña del usuario a registrar
        $data['activo'] = 1;
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
/*
    public function registrarUsuario($tabla, $rif, $nombre, $rol, $direccion, $contrasenia, $estado){
        //$tabla donde se ingresara 
        //los nombres de los sectores del array data tienen q ser los mismos nombres
        //de la tabla donde lo vayas a insertar
        $data['cedula'] = $rif; //rif del usuario 
        $data['nombre'] = $nombre; // nombre del usuario
        $data['rol_id'] = $rol; //identificador del rol
        $data['direccion'] = $direccion; //direccion del usuario
        $data['contrasenia'] = $contrasenia; //contraseña del usuario a registrar
        $data['activo'] = $estado; //si el usuario esta activo aunque deberia estar perma en 1 hasta
        //que se modifique por otras personas
        return $this->grabaData($tabla, $data);
    }*/
}

?>