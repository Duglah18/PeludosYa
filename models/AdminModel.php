<?php 

class AdminModel extends ConexionBD{
    // #consultas Region
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

    public function consultaAdopciones($albergueEsp){
        $resultados = $this->obtenData("SELECT a.id_adopcion, a.fecha_adopcion, b.nombre as nombreanimal, 
                                        d.nombre as nombreusuario, c.nombre as nombrealbergue,
                                        e.nombre_estado
                                        FROM adopcion a
                                        INNER JOIN animal b ON a.animal_id = b.id_animal
                                        INNER JOIN albergue c ON b.albergue_id = c.id_albergue
                                        INNER JOIN usuarios d ON c.cedula_usuario = d.cedula
                                        INNER JOIN tipo_estado_adopcion e ON a.estado = e.id_tipo_estado
                                        WHERE c.id_albergue = CASE WHEN '$albergueEsp' = '' THEN c.id_albergue ELSE '$albergueEsp' END");
        if (!$resultados){
            return false;
        } 
        return $resultados;
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
        return $this->obtenData("SELECT usuarios.cedula, usuarios.nombre, usuarios.direccion, usuarios.activo, rol.nombre as nombrerol, usuarios.telefono
                                FROM usuarios 
                                INNER JOIN rol ON usuarios.rol_id = rol.id_rol
                                ORDER BY usuarios.activo DESC, usuarios.rol_id ASC");
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

    public function listaTiposAnimal($id_tipo){
        return $this->obtenData("SELECT id_tipo, nombre
                                FROM tipo_animal 
                                WHERE id_tipo = CASE WHEN '$id_tipo' = '' THEN id_tipo ELSE '$id_tipo' END");
    }

    public function listaRazas($id_raza){
        return $this->obtenData("SELECT raza.id_raza, raza.nombre, tipo_animal.nombre as nombreTipo, id_tipo_animal as id_tipo_2
                                FROM raza
                                INNER JOIN tipo_animal ON tipo_animal.id_tipo = raza.id_tipo_animal
                                WHERE raza.id_raza = CASE WHEN '$id_raza' = '' THEN raza.id_raza ELSE '$id_raza' END");
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

    public function consultarVeterinarios($id_veterinario){
        $resultado = $this->obtenData("SELECT id_veterinario, nombre, tlf, direccion, img, visible, usuario_Rveterinario
                          FROM veterinario
                          WHERE id_veterinario = CASE WHEN '$id_veterinario' = '' THEN id_veterinario ELSE '$id_veterinario' END");
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

    public function modificaVeterinario($id_veterinario, $nombre, $tlf, $direccion, $img, $visible){
        $data['nombre'] = $nombre;
        $data['tlf'] = $tlf;
        $data['direccion'] = $direccion;
        $data['img'] = $img;
        $data['visible'] = $visible;
        return $this->actualizaData('veterinario', $data, "id_veterinario = ".$id_veterinario);
    }

    public function modificaTipoAnimal($id_tipo, $nombre){
        $data['nombre'] = $nombre;
        return $this->actualizaData('tipo_animal', $data, "id_tipo = " .$id_tipo);
    }

    public function modificaRaza($id_raza, $nombre, $tipoAnimal){
        $data['nombre'] = $nombre;
        $data['id_tipo_animal'] = $tipoAnimal;
        return $this->actualizaData('raza', $data, "id_raza = " . $id_raza);
    }
    #modificar End
    
    // public function actualizar(){
    //     $data['nombre'] = "actualizado";
    //     return $this->actualizaData("mb_menu", $data,"idmenu=1");
    // }
}
?>