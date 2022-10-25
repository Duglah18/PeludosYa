<?php 

class AdminModel extends ConexionBD{

    public function consultarAdmin($user, $contrasenia){
        $resultado = $this->obtenData("SELECT cedula, nombre, contrasenia, rol_id FROM usuarios WHERE nombre = '$user' AND contrasenia = '$contrasenia' AND rol_id = 1");
        //sin el and del rol se podria loguear un usuario normal como admin :v
        if ($resultado) {
            return $resultado;
        } else {
            return false;
        }
    }

    public function consultaAlbergues(){
        $resultados = $this->obtenData("SELECT id_albergue, nombre FROM albergue");
        if ($resultados){
            return $resultados;
        } else {
            return false;
        }
    }

    public function ConsultaRoles(){
        $resultado = $this->obtenData("SELECT id_rol, nombre FROM rol");
        if ($resultado) {
            return $resultado;
        } else {
            return false;
        }
    }
//falta telefono usuario
    public function registrarUsuario($tabla, $rif, $nombre, $rol, $direccion, $contrasenia, $estado, $tlf){
        //$tabla donde se ingresara 
        //los nombres de los sectores del array data tienen q ser los mismos nombres
        //de la tabla donde lo vayas a insertar
        $data['cedula'] = $rif; //rif del usuario 
        $data['nombre'] = $nombre; // nombre del usuario
        $data['rol_id'] = $rol; //identificador del rol
        $data['direccion'] = $direccion; //direccion del usuario
        $data['contrasenia'] = $contrasenia; //contraseña del usuario a registrar
        $data['activo'] = $estado; //si el usuario esta activo aunque deberia estar perma en 1 hasta
        $data['telefono'] = $tlf;
        //que se modifique por otras personas
        return $this->grabaData($tabla, $data);
    }

    public function registraTipoAnimal($tabla, $nombre){
        $data['nombre'] = $nombre;
        return $this->grabaData($tabla, $data);
    }

    public function registraRazaAnimal($tabla, $nombre, $tiporaza){
        $data['nombre'] = $nombre;
        $data['id_tipo_animal'] = $tiporaza;
        return $this->grabaData($tabla, $data);
    }

    public function registrar(){
        $data['padre'] = "0";
        $data['nombre'] = "opcion 2";
        $data['url'] = "opcion3/mostrar";
        return $this->grabaData("mb_menu", $data);
    }

    public function actualizar(){
        $data['nombre'] = "actualizado";
        return $this->actualizaData("mb_menu", $data,"idmenu=1");
    }

    public function listar(){
        return $this->obtenData("SELECT usuarios.cedula, usuarios.nombre, usuarios.direccion, usuarios.contrasenia, usuarios.activo, rol.nombre as nombrerol, usuarios.telefono
                                FROM usuarios INNER JOIN rol ON usuarios.rol_id = rol.id_rol");
                                //tristemente el array no capta algo tipo usuarios a = a.nombre asi que
                                //como el nombre del rol y el nombre del usuario tienen el mismo campo con mismo nombre entonces
                                //simplemente hice que el nombre de rol se reconociera como as 
    }

    public function listaTiposAnimal(){
        return $this->obtenData("SELECT id_tipo, nombre
                                FROM tipo_animal");
    }

    public function listaRazas(){
        return $this->obtenData("SELECT raza.id_raza, raza.nombre, tipo_animal.nombre as nombreTipo
                                FROM raza
                                INNER JOIN tipo_animal ON tipo_animal.id_tipo = raza.id_tipo_animal");
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
        $resultados = $this->obtenData("SELECT id_raza, nombre FROM raza WHERE id_tipo_animal = '$id_tipo'");
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

    public function registraAnimal($tabla, $nom, $anionac, $nomimg, $descripcion, $fecha_ing, $id_raza, $tamano_id, $albergue, $visible){
        $data['nombre'] = $nom;
        $data['anio_nac'] = $anionac;
        $data['img'] = $nomimg;
        $data['descripcion'] = $descripcion;
        $data['fecha_ingreso'] = $fecha_ing;
        $data['raza_id'] = $id_raza;
        $data['tamanio_id'] = $tamano_id;
        $data['albergue_id'] = $albergue;
        $data['visible'] = $visible;
        return $this->grabaData($tabla, $data);
    }

    public function registraVeterinario($nombre,$telefono,$direccion,$img,$adminregistra){
        $data['nombre'] = $nombre;
        $data['tlf'] = $telefono;
        $data['direccion'] = $direccion;
        $data['img'] = $img;
        $data['visible'] = 1;
        $data['usuario_Rveterinario'] = $adminregistra;
        return $this->grabaData('veterinario',$data);
    }

    public function consultarVeterinarios(){
        $resultado = $this->obtenData("SELECT id_veterinario, nombre, tlf, direccion, img, visible, usuario_Rveterinario
                          FROM veterinario");
        return $resultado;
    }

}

?>