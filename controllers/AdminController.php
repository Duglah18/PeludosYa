<?php 

class AdminController extends GeneralController{
    #Region Views
    public function index(){
        //esta logica se puede usar en el buscar
        //q te mande a la misma pag pero q si recibe un parametro x q te haga algo diferente
        if (isset($_SESSION['usuario'])){
            $objAdmin = $this->loadModel("AdminModel");
            $objAdmin->registraCierraSesion($_SESSION['iduser']);
            session_destroy();
            /*UY ESTO HAY QUE CAMBIARLO SI VAS AL INDEX LOGUEADO SE TE DESLOGUEA */
            //sin el refresh se seguiria viendo el Usuario como si
            //estuvieras logueado para entender si quieres
            //comenta la siguiente linea y carga el admin y cierra sesion
            //y mira la barra de navegacion
            header("refresh: " . 0);
            $this->loadView("admin/admin.phtml","Login Administrador");
        } else {
        $this->loadView("admin/admin.phtml","Login Administrador");
        }
    }

    public function animales(){
        $objAdmin = $this->loadModel("FundacionModel");
        $pagina = isset($_GET['pagina'])? intval($_GET['pagina']): 1;
        $pagina = $pagina < 0? 1: $pagina;
        $qty = 10;
        $data['pagina'] = $pagina;
        $data['por_pagina'] = $qty;
        $data['totalregistro'] = $objAdmin->TotalConsultaAnimales('');
        $data['animalesAdmin'] = $objAdmin->consultaAnimales('',$pagina,$qty);
        //atras envie nada para que me arroje todo
        $this->loadView("admin/veranimales.phtml","Ver Animales",$data);
    }

    public function albergues(){
        $objAdmin = $this->loadModel("FundacionModel");
        $pagina = isset($_GET['pagina'])? intval($_GET['pagina']): 1;
        $pagina = $pagina < 0? 1: $pagina;
        $qty = 10;
        $data['pagina'] = $pagina;
        $data['por_pagina'] = $qty;
        $data['totalregistro'] = $objAdmin->TotalconsultaAlbergues('');
        $data['alberguesAdmin'] = $objAdmin->consultaAlbergue('', $pagina, $qty);
        //atras envie nada para que me arroje todo
        $this->loadView("admin/veralbergues.phtml","Ver Albergues",$data);
    }

    public function adopciones(){
        $objAdmin = $this->loadmodel("AdminModel");
        $pagina = isset($_GET['pagina'])? intval($_GET['pagina']): 1;
        $pagina = $pagina < 0? 1: $pagina;
        $qty = 10;
        $data['pagina'] = $pagina;
        $data['por_pagina'] = $qty;
        if (!isset($_POST['AlbergueEsp']) || $_POST['AlbergueEsp'] == "0"){
            $data['totalregistro'] = $objAdmin->TotalconsultaAdopciones('');
            $data['adopciones'] = $objAdmin->consultaAdopciones('',$pagina, $qty);
            $data['albergues'] = $objAdmin->consultaAlbergues();
            $this->loadView("admin/verAdopciones.phtml","Ver adopciones",$data);
        } elseif(isset($_POST['AlbergueEsp']) && $_POST['AlbergueEsp'] != "0") {
            $data['Busqueda'] = $_POST['AlbergueEsp'];
            $data['totalregistro'] = $objAdmin->TotalconsultaAdopciones($_POST['AlbergueEsp']);
            $data['adopciones'] = $objAdmin->consultaAdopciones($_POST['AlbergueEsp'],$pagina, $qty);
            $data['albergues'] = $objAdmin->consultaAlbergues();
            $this->loadView("admin/verAdopciones.phtml","Ver adopciones",$data);
        }
        
    }

    //Vista Agregar animales Admin
    public function agregaAnimales(){
        $objAdmin = $this->loadModel("AdminModel");
        if (isset($_POST['accion']) && $_POST['accion'] == 'Modificar'){
            $data['raza'] = $objAdmin->consultaRazaAnimal('');
            $data['tipoanimal'] = $objAdmin->consultaTipoAnimal();
            $data['tamano'] = $objAdmin->consultaTamanoAnimal();
            $data['albergues'] = $objAdmin->consultaAlbergues();
            $ammodificar = (isset($_POST['modificacion']))? $_POST['modificacion']: "";
            $data['animales'] = $objAdmin->consultarAnimal($ammodificar);
            $this->loadView("admin/agAnimal.phtml","Modifica el Animal desde Admin", $data);
        }else {
            $data['tipoanimal'] = $objAdmin->consultaTipoAnimal();
            if(isset($_POST['tipoanimal'])){
                $busqueda_animal= $_POST['tipoanimal'];
            $data['raza'] = $objAdmin->consultaRazaAnimal($busqueda_animal);
            }
            $data['tamano'] = $objAdmin->consultaTamanoAnimal();
            $data['albergues'] = $objAdmin->consultaAlbergues();
            $this->loadView("admin/agAnimal.phtml","Agregar Animal Desde Admin",$data);
        }
    }
    
    //Vista Agregar usuarios Admin
    public function agregaUsuarios(){
        $objAdmin = $this->loadModel("AdminModel");
        if(isset($_POST['accion']) && $_POST['accion'] == 'Modificar'){
            $data['usuario'] = $objAdmin->consultaUsuario($_POST['modificacion']);
            $data['dataRoles'] = $objAdmin->ConsultaRoles();
            $this->loadView("admin/agusaurios.phtml","Modifica el usuario", $data);
        } else {
        $data['dataRoles'] = $objAdmin->ConsultaRoles();
        $this->loadView("admin/agusaurios.phtml","Agrega usuarios como Admin", $data);
        }
    }

    public function agregaVeterinarios(){
        $objAdmin = $this->loadmodel("AdminModel");
        if (isset($_POST['accion']) && $_POST['accion'] == 'Modificar'){
            $pagina = isset($_GET['pagina'])? intval($_GET['pagina']): 1;
            $pagina = $pagina < 0? 1: $pagina;
            $qty = 10;
            $data['pagina'] = $pagina;
            $data['por_pagina'] = $qty;
            $data['totalregistro'] = $objAdmin->TotalVeterinariosConsults();
            $data['Veterinarios'] = $objAdmin->consultarVeterinarios('',$pagina,$qty);
            $data['vtrModificar'] = $objAdmin->consultarVeterinarios($_POST['modificacion'],$pagina,$qty);
            $this->loadView("admin/agVeterinario.phtml", "Modifica Veterinario como Admin",$data);
        } else {
            $pagina = isset($_GET['pagina'])? intval($_GET['pagina']): 1;
            $pagina = $pagina < 0? 1: $pagina;
            $qty = 10;
            $data['pagina'] = $pagina;
            $data['por_pagina'] = $qty;
            $data['totalregistro'] = $objAdmin->TotalVeterinariosConsults();
            $data['Veterinarios'] = $objAdmin->consultarVeterinarios('',$pagina,$qty);
            $this->loadView("admin/agVeterinario.phtml", "Agrega Veterinarios como Admin",$data);
        }
    }

    public function agregaAlbergueAdmin(){
        //este model es para cargar el select
        $objFund = $this->loadModel("FundacionModel");
        if(isset($_POST['accion']) && $_POST['accion'] == 'Modificar'){
            $data['userfund'] = $objFund->consultaUser();
            $data['albergue'] = $objFund->consultaAlberguePorID($_POST['modificacion']);
            $this->loadView("admin/agalbergue.phtml","Modificar Albergue como Admin",$data);
        } else {
            $data['userfund'] = $objFund->consultaUser();
            $this->loadView("admin/agalbergue.phtml","Agregar Albergue como Admin",$data);
        }
    }
    
    public function mostrarData(){
        $objAdmin = $this->loadModel("AdminModel");
        $pagina = isset($_GET['pagina'])? intval($_GET['pagina']): 1;
        $pagina = $pagina < 0? 1: $pagina;
        $qty = 10;
        $data['pagina'] = $pagina;
        $data['por_pagina'] = $qty;
        $data['totalregistro'] = $objAdmin->TotalUsuarios();
        $data['dataAdmin'] = $objAdmin->listar($pagina, $qty);
        $this->loadView("admin/adIndex.phtml", "Administrador Ver Usuarios",$data);
    }

    public function tipoAnimal(){// Probar falta el div bajo de la tabla aunque haz un if para
	//ver si los resultados son muchos si son muchos si pagina si no no
        $objAdmin = $this->loadModel("AdminModel");
        if (isset($_POST['accion']) && $_POST['accion'] == 'Modificar'){
			$pagina = isset($_GET['pagina'])? intval($_GET['pagina']): 1;
			$pagina = $pagina < 0? 1: $pagina;
			$qty = 10;
			$data['pagina'] = $pagina;
			$data['por_pagina'] = $qty;
			$data['totalregistro'] = $objAdmin->TotallistaTiposAnimal();
            $data['tAnimal'] = $objAdmin->listaTiposAnimal($_POST['modificacion'],$pagina, $qty);
            $data['dataTipos'] = $objAdmin->listaTiposAnimal('',$pagina, $qty);
            return $this->loadView("admin/adTAnimal.phtml", "Modifica el Tipo de Animal", $data);
        }
		$pagina = isset($_GET['pagina'])? intval($_GET['pagina']): 1;
        $pagina = $pagina < 0? 1: $pagina;
        $qty = 10;
        $data['pagina'] = $pagina;
        $data['por_pagina'] = $qty;
        $data['totalregistro'] = $objAdmin->TotallistaTiposAnimal();
        $data['dataTipos'] = $objAdmin->listaTiposAnimal('',$pagina, $qty);
        $this->loadView("admin/adTAnimal.phtml", "Administrar Tipos de Animal", $data);
    }

    public function razasAnimal(){
        $objAdmin = $this->loadModel("AdminModel");
        $objFund = $this->loadModel("FundacionModel");
        $pagina = isset($_GET['pagina'])? intval($_GET['pagina']): 1;
        $pagina = $pagina < 0? 1: $pagina;
        $qty = 10;
        if (isset($_POST['accion']) && $_POST['accion'] == 'Modificar'){
            $data['buscarazas'] = $objAdmin->listaRazas($_POST['modificacion'], $pagina, $qty);
            $data['pagina'] = $pagina;
            $data['por_pagina'] = $qty;
            $data['totalregistro'] = $objAdmin->TotallistaRazas();
            $data['dataRazas'] = $objAdmin->listaRazas('',$pagina, $qty);
            $data['tiposAnimales'] = $objFund->consultaTipoAnimal();
            return $this->loadView("admin/adRazas.phtml", "Modifica la Raza de Animal", $data);
        }
        $data['pagina'] = $pagina;
        $data['por_pagina'] = $qty;
        $data['totalregistro'] = $objAdmin->TotallistaRazas();
        $data['dataRazas'] = $objAdmin->listaRazas('',$pagina, $qty);
        $data['tiposAnimales'] = $objFund->consultaTipoAnimal();
        $this->loadView("admin/adRazas.phtml", "Administrar Razas de Animal", $data);
    }

    #endregion

    public function consultaData(){
        if(!isset($_POST['username']) && !isset($_POST['password'])){
            die("No se enviaron datos");
        }
        $user = $_POST['username'];
        $contra = $_POST['password'];
        $objAdmin = $this->loadModel("AdminModel");
        $dataAdmin = $objAdmin->consultarAdmin($user, $contra);
            if ($dataAdmin != true){
                die("NO COINCIDE");
            }
            //lo mismo de aca abajo hacer en login normal y register
            $_SESSION['usuario'] = $dataAdmin[0]['nombre'];
            $_SESSION['rol'] = $dataAdmin[0]['rol_id'];
            $_SESSION['iduser'] = $dataAdmin[0]['cedula'];
            header("location: ". BASE_URL. "admin/mostrarData");
    }

    // public function Closesession(){
    //     if (isset($_SESSION)){
    //         session_destroy();
    //     }
    //     $this->index();
    // }

    public function registraUsuario(){//falta telefono 
        //verifica si existe el usuario
        //y la cedula
        $objAdmin = $this->loadModel("AdminModel");
        if (isset($_POST['Agregar'])){
            $cedula = $_POST['cedula'];
            $nombre = $_POST['nombre'];
            $rol = $_POST['rol'];
            $direccion = $_POST['direccion'];
            $contrasenia = $_POST['contrasenia'];
            $tlf = $_POST['telefono'];
        
            $objAdmin->registrarUsuario("usuarios",$cedula,$nombre,$rol,$direccion,
                                        $contrasenia, "1", $tlf, $_SESSION['iduser']);
            //mientras carga mostrarData agregar una pantalla de carga
            header("location: ".BASE_URL. "admin/mostrarData");//solucion a recargar la pagina !!!!
        } elseif (isset($_POST['Modificar'])){//usa redireccionamiento header
            $cedula = $_POST['cedula'];
            $nombre = $_POST['nombre'];
            $rol = $_POST['rol'];
            $direccion = $_POST['direccion'];
            $contrasenia = $_POST['contrasenia'];
            $activo = $_POST['activo'];
            $tlf = $_POST['telefono'];
            echo $objAdmin->modificaUsuario($cedula,$nombre,$rol,$direccion,$contrasenia,
                                        $activo,$tlf, $_SESSION['iduser']);
            header("location: ".BASE_URL. "admin/mostrarData");
        }
    }

    public function agregaTipoanimal(){
        $objAdmin = $this->loadModel("AdminModel");
        if(isset($_POST['accion']) && $_POST['accion'] == 'Modificar'){
            $identificador = $_POST['identificador'];
            $nombre = $_POST['nombreTipo'];
            $objAdmin->modificaTipoAnimal($identificador,$nombre, $_SESSION['iduser']);
            $_POST['accion'] = "";
            header("location: ".BASE_URL."admin/tipoAnimal");
        } elseif(isset($_POST['accion']) && $_POST['accion'] == 'Agregar') {
            $nombre = $_POST['nombreTipo'];
            $objAdmin->registraTipoAnimal('tipo_animal',$nombre, $_SESSION['iduser']);
            header("location: ".BASE_URL."admin/tipoAnimal");
        }
    }

    public function agregaRazaAnimal(){
        $objAdmin = $this->loadModel("AdminModel");
        if(isset($_POST['accion']) && $_POST['accion'] == 'Modificar'){
            $identificador = $_POST['identificador'];
            $nombre = $_POST['nombreRaza'];
            $TipoAnimal = $_POST['tipoanimal'];
            $objAdmin->modificaRaza($identificador, $nombre, $TipoAnimal, $_SESSION['iduser']);
            $_POST['accion'] = "";
            header("location: ".BASE_URL."admin/razasAnimal");
        } elseif(isset($_POST['accion']) && $_POST['accion'] == 'Agregar'){
            $nombre = $_POST['nombreRaza'];
            $TipoAnimal = $_POST['tipoanimal'];
            $objAdmin->registraRazaAnimal('raza', $nombre, $TipoAnimal, $_SESSION['iduser']);
            header("location: ".BASE_URL."admin/razasAnimal");
        }
    }

    public function agregaAnimal(){//ahora si
        $objFund = $this->loadModel("AdminModel");
        if (isset($_POST['accion']) && $_POST['accion'] == 'Agregar'){
            $nombre = $_POST['nombre'];
            $fechanac= $_POST['fecha'];
            /*----------------------Empezamos el tratamiento de img----------------------------*/
            //esto es lo q queria automatizar pq vamos a tener q hacer esto cada q queramos guardar una img
            $fecha_paratmp = new DateTime();
            $imgtxt = (isset($_FILES['img']['name']))?$_FILES['img']['name']:"";
            $nombreArchivo =($imgtxt!="")?$fecha_paratmp->getTimestamp()."_".$_FILES['img']['name']:"imagen.jpg";
            $image= $_FILES['img']['tmp_name'];
            if ($image!=""){
                move_uploaded_file($image,"./img/animales/".$nombreArchivo);
            }
            /*----------------------Terminado el tratamiento de img----------------------------*/
            $descrip= $_POST['descrip'];
            $fecha_ing= "Now()";
            $raza_id= $_POST['raza'];
            $tamanio_id= $_POST['tamano'];
            $albergue_id= $_POST['albergue'];
            $visible = 1;
            $objFund->registraAnimal('animal', $nombre, $fechanac, $nombreArchivo, $descrip, 
                                    $fecha_ing, $raza_id,$tamanio_id, $albergue_id, $visible,
                                    $_SESSION['iduser']);
            header("location: ".BASE_URL."admin/animales");
        } elseif (isset($_POST['accion']) && $_POST['accion'] == 'Modificar'){
            $id_animal = $_POST['id_animal'];
            $nombre = $_POST['nombre'];
            $fechanac= $_POST['fecha'];
            $img_modificar = $_POST['imgmodificar'];
            /*----------------------Empezamos el tratamiento de img----------------------------*/
            //esto es lo q queria automatizar pq vamos a tener q hacer esto cada q queramos guardar una img
            $fecha_paratmp = new DateTime();
            $imgtxt = (isset($_FILES['img']['name']))?$_FILES['img']['name']:"";
            $nombreArchivo =($imgtxt!="")?$fecha_paratmp->getTimestamp()."_".$_FILES['img']['name']:"imagen.jpg";
            $image= $_FILES['img']['tmp_name'];
            move_uploaded_file($image,"./img/animales/".$nombreArchivo);

            $imagenEliminar = $objFund->consultarAnimal($id_animal);
                if($imagenEliminar[0]['img'] != $nombreArchivo){
                    if ($imagenEliminar[0]["img"]!="imagen.jpg") {
                        if (file_exists("./img/animales/".$imagenEliminar[0]["img"])) {
                            unlink("./img/animales/".$imagenEliminar[0]["img"]);
                        }
                    }
                } else {
                    $nombreArchivo = $img_modificar;
                }
            /*----------------------Terminado el tratamiento de img----------------------------*/
            $descrip= $_POST['descrip'];
            $raza_id= $_POST['raza'];
            $tamanio_id= $_POST['tamano'];
            $albergue_id= $_POST['albergue'];
            $visible = $_POST['visible'];
            $objFund->modificaAnimal('animal', $id_animal,$nombre, $fechanac, $nombreArchivo, 
                                    $descrip, $raza_id,$tamanio_id, $albergue_id, $visible,
                                    $_SESSION['iduser']);
            header("location: ".BASE_URL."admin/animales");
        }
    }
    public function registraVeterinario(){
        //creo que esto puede servir
        $objAdmin = $this->loadModel("AdminModel");
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        if (isset($_POST['accion']) && $_POST['accion'] == 'Modificar'){
            $visible = $_POST['visible'];
            /*----------------------Tratamiento de Img------------------------------------------*/
            $img_modificar = $_POST['imgmodificar'];

            $id_veterinario = $_POST['vetIdentificador'];
            $fecha_paratmp = new DateTime();
            $imgtxt = (isset($_FILES['img']['name']))? $_FILES['img']['name']:"";
            $nombreArchivo =($imgtxt!="")?$fecha_paratmp->getTimestamp()."_".$_FILES['img']['name']:"imagen.jpg";
            $image = $_FILES['img']['tmp_name'];
            move_uploaded_file($image,"./img/veterinarios/".$nombreArchivo);

            $imagenEliminar = $objAdmin->consultarVeterinarios($id_veterinario);
                if($imagenEliminar[0]['img'] != $nombreArchivo){
                    if ($imagenEliminar[0]["img"]!="imagen.jpg"){//Se cumple?
                        if (file_exists("./img/veterinarios/".$imagenEliminar[0]["img"])) {
                            unlink("./img/veterinarios/".$imagenEliminar[0]["img"]);
                        }
                    }
                } else {
                    $nombreArchivo = $img_modificar;
                }
            /*-----------------------Terminando de Img------------------------------------------*/
            $objAdmin->modificaVeterinario($id_veterinario, $nombre, $telefono, $direccion, 
                                            $nombreArchivo, $visible, $_SESSION['iduser']);
            $_POST['accion'] = "";
            header("location: ".BASE_URL."admin/agregaVeterinarios");
        } elseif(isset($_POST['accion']) && $_POST['accion'] == 'Agregar') {
            if ($nombre != "" && $telefono != "" && $direccion != ""){
                /*----------------------Tratamiento de Img------------------------------------------*/
                $fecha_paratmp = new DateTime();
                $imgtxt = (isset($_FILES['img']['name']))? $_FILES['img']['name']:"";
                $nombreArchivo =($imgtxt!="")?$fecha_paratmp->getTimestamp()."_".$_FILES['img']['name']:"imagen.jpg";
                $image = $_FILES['img']['tmp_name'];
                if($image != ""){
                    move_uploaded_file($image,"./img/veterinarios/".$nombreArchivo);
                }
                /*-----------------------Terminando de Img------------------------------------------*/
                $adminRegistrando = $_POST['admin'];
                $objAdmin->registraVeterinario($nombre,$telefono,$direccion, 
                                                $nombreArchivo, $adminRegistrando);
                header("location: ".BASE_URL."admin/agregaVeterinarios");
            } else {
                header("location: ".BASE_URL."admin/agregaVeterinarios");
                //añadir variable de error por get 
            }
        }
    }
}

?>