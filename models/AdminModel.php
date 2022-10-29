<?php 

class AdminModel extends ConexionBD{
    #consultas Region
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
                                        WHERE (cedula = CASE WHEN $idusuario = '' THEN cedula ELSE $idusuario END)");
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

    public function listar(){
        return $this->obtenData("SELECT usuarios.cedula, usuarios.nombre, usuarios.direccion, usuarios.contrasenia, usuarios.activo, rol.nombre as nombrerol, usuarios.telefono
                                FROM usuarios INNER JOIN rol ON usuarios.rol_id = rol.id_rol");
                                //tristemente el array no capta algo tipo usuarios a = a.nombre asi que
                                //como el nombre del rol y el nombre del usuario tienen el mismo campo con mismo nombre entonces
                                //simplemente hice que el nombre de rol se reconociera como as 
    }

    public function consultarAnimal($id_animal){
        return $this->obtenData("SELECT a.id_animal, a.nombre, a.anio_nac, a.img, a.descripcion, 
                                a.fecha_ingreso, a.raza_id, a.tamanio_id, a.albergue_id, a.visible, b.id_tipo_animal
                                FROM animal a
                                INNER JOIN raza b ON a.raza_id = b.id_raza
                                WHERE a.id_animal = CASE WHEN '$id_animal' = '' THEN a.id_animal ELSE '$id_animal'END");
    }//Resolver el problema de si esta adoptado

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
    #Region de Modificar
    public function modificaUsuario($idusuario,$nombre,$rol,$direccion,$contrasena,$activo,$telefono){
        $data['cedula'] = $idusuario;
        $data['nombre'] = $nombre;
        $data['rol_id'] = $rol;
        $data['direccion'] = $direccion;
        $data['contrasenia'] = $contrasena;
        $data['activo'] = $activo;
        $data['telefono'] = $telefono;
        return $this->actualizaData("usuarios",$data,"cedula = " .$idusuario);
    }
    public function modificaAnimal($tabla, $id_animal,$nom, $anionac, $nomimg, $descripcion, $id_raza, $tamano_id, $albergue, $visible){
        $data['nombre'] = $nom;
        $data['anio_nac'] = $anionac;
        $data['img'] = $nomimg;
        $data['descripcion'] = $descripcion;
        $data['raza_id'] = $id_raza;
        $data['tamanio_id'] = $tamano_id;
        $data['albergue_id'] = $albergue;
        $data['visible'] = $visible;
        return $this->actualizaData($tabla, $data, "id_animal = " . $id_animal);
    }
    #modificar End
    
    // public function actualizar(){
    //     $data['nombre'] = "actualizado";
    //     return $this->actualizaData("mb_menu", $data,"idmenu=1");
    // }
}

?>