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