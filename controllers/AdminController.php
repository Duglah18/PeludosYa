<?php 

class AdminController extends GeneralController{
    #Region Views
    public function Comprobador(){
        if(!isset($_SESSION['usuario']) || $_SESSION['rol'] != "1"){
            return header("location: ".BASE_URL);
        }
    }

    public function index(){
        if (isset($_SESSION['usuario'])){
            $objAdmin = $this->loadModel("AdminModel");
            $objAdmin->registraCierraSesion($_SESSION['iduser']);
            session_destroy();
            header("refresh: " . 0);
            $this->loadView("admin/admin.phtml","Login Administrador");
        } else {
        $this->loadView("admin/admin.phtml","Login Administrador");
        }
    }

    public function animales(){
        $this->Comprobador();
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
        $this->Comprobador();
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
        $this->Comprobador();
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
        $this->Comprobador();
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
        $this->Comprobador();
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
        $this->Comprobador();
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
        $this->Comprobador();
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
        $this->Comprobador();
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

    public function tipoAnimal(){
        $this->Comprobador();
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
        $this->Comprobador();
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

    public function registraUsuario(){
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
            if($objAdmin == false){
                $error = "Usuario ya en el sistema";
                header("location: ".BASE_URL. "admin/mostrarData?error=".$error);
            }
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
            $detalles = $_POST['detalle'];
            $objAdmin->modificaUsuario($cedula,$nombre,$rol,$direccion,$contrasenia,
                                        $activo,$tlf, $detalles,$_SESSION['iduser']);
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

    public function inactivaUsuario(){
        $this->Comprobador();
        $objAdmin = $this->loadModel("AdminModel");
        if(!isset($_POST['accion']) || !isset($_POST['decision']) || !isset($_POST['modificacion'])){
            return header("location: ".BASE_URL."admin/mostrarData");
        }
        $cedula_user = $_POST['modificacion'];
        if($_POST['accion'] == "Activar"){
            $decision = 1;
        } elseif ($_POST['accion'] == "Inactivar"){
            $decision = 0;
        }

        $objAdmin->DecisionActivacionUsuario($cedula_user, $decision, $_SESSION['iduser']);
        return header("location: ".BASE_URL."admin/mostrarData");
    }

    public function inactivaVeterinario(){
        $this->Comprobador();
        $objAdmin = $this->loadModel("AdminModel");
        if(!isset($_POST['accion']) || !isset($_POST['decision']) || !isset($_POST['modificacion'])){
            return header("location: ".BASE_URL."admin/agregaVeterinarios?error");
        }
        $id_veterinario = $_POST['modificacion'];
        if($_POST['accion'] == "Activar"){
            $decision = 1;
        } elseif ($_POST['accion'] == "Inactivar"){
            $decision = 0;
        }

        $objAdmin->DecisionActivacionVeterinario($id_veterinario, $decision, $_SESSION['iduser']);
        return header("location: ".BASE_URL."admin/agregaVeterinarios");
    }

    public function inactivaPeludos(){
        $this->Comprobador();
        $objAdmin = $this->loadModel("AdminModel");
        if(!isset($_POST['accion']) || !isset($_POST['decision']) || !isset($_POST['modificacion'])){
            return header("location: ".BASE_URL."admin/animales?error");
        }
        $id_peludo = $_POST['modificacion'];
        if($_POST['accion'] == "Activar"){
            $decision = 1;
        } elseif ($_POST['accion'] == "Inactivar"){
            $decision = 0;
        }

        $objAdmin->DecisionActivacionPeludos($id_peludo, $decision, $_SESSION['iduser']);
        return header("location: ".BASE_URL."admin/animales");
    }

    public function inactivaAlbergue(){
        $this->Comprobador();
        $objAdmin = $this->loadModel("AdminModel");
        if(!isset($_POST['accion']) || !isset($_POST['decision']) || !isset($_POST['modificacion'])){
            return header("location: ".BASE_URL."admin/albergues?error");
        }
        $id_albergue = $_POST['modificacion'];
        if($_POST['accion'] == "Activar"){
            $decision = 1;
        } elseif ($_POST['accion'] == "Inactivar"){
            $decision = 0;
        }

        $objAdmin->DecisionActivacionAlbergues($id_albergue, $decision, $_SESSION['iduser']);
        return header("location: ".BASE_URL."admin/albergues");
    }
}

?>