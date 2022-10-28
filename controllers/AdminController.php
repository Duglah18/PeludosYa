<?php 

class AdminController extends GeneralController{
    #Region Views
    public function index(){
        echo "estoy en Admin controller en el metodo index()<br>";
        //esta logica se puede usar en el buscar
        //q te mande a la misma pag pero q si recibe un parametro x q te haga algo diferente
        if (isset($_SESSION['usuario'])){
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
        $data['animalesAdmin'] = $objAdmin->consultaAnimales('');
        //atras envie nada para que me arroje todo
        $this->loadView("admin/veranimales.phtml","Ver Animales",$data);
    }

    public function albergues(){
        $objAdmin = $this->loadModel("FundacionModel");
        $data['alberguesAdmin'] = $objAdmin->consultaAlbergue('');
        //atras envie nada para que me arroje todo
        $this->loadView("admin/veralbergues.phtml","Ver Albergues",$data);
    }

    //Vista Agregar animales Admin
    //aun sin acabar por favor cambialo asi que cammbialo
    //agarra y copia el modelo y demas
    public function agregaAnimales(){
        $objAdmin = $this->loadModel("AdminModel");
        if (isset($_POST['accion']) && $_POST['accion'] == 'Modificar'){
            $data['raza'] = $objAdmin->consultaRazaAnimal('');
            $data['tipoanimal'] = $objAdmin->consultaTipoAnimal();
            $data['tamano'] = $objAdmin->consultaTamanoAnimal();
            $data['albergues'] = $objAdmin->consultaAlbergues();
            $data['animal'] = $objAdmin->consultarAnimal($_POST['modificacion']);
            $this->loadView("admin/agAnimal.phtml","Modifica el Animal desde Admmin", $data);
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
        echo "estoy en Admin Controller en el metodo agregaUsuarios()<br>";
        $data['dataRoles'] = $objAdmin->ConsultaRoles();
        $this->loadView("admin/agusaurios.phtml","Agrega usuarios como Admin", $data);
        }
    }
    
    public function agregaVeterinarios(){
        $objAdmin = $this->loadmodel("AdminModel");
        $data['Veterinarios'] = $objAdmin->consultarVeterinarios();
        $this->loadView("admin/agVeterinario.phtml", "Agrega Veterinarios como Admin",$data);
    }

    public function agregaAlbergueAdmin(){
        //este model es para cargar el select
        $objFund = $this->loadModel("FundacionModel");
        $data['userfund'] = $objFund->consultaUser();
        $this->loadView("admin/agalbergue.phtml","Agregar Albergue como Admin",$data);
    }

    public function mostrarData(){
        $objAdmin = $this->loadModel("AdminModel");
        $data['dataAdmin'] = $objAdmin->listar();
        $this->loadView("admin/adIndex.phtml", "Administrador registro usuario",$data);
    }

    public function tipoAnimal(){
        $objAdmin = $this->loadModel("AdminModel");
        $data['dataTipos'] = $objAdmin->listaTiposAnimal();
        $this->loadView("admin/adTAnimal.phtml", "Administrar Tipos de Animal", $data);
    }

    public function razasAnimal(){
        $objAdmin = $this->loadModel("AdminModel");
        $objFund = $this->loadModel("FundacionModel");
        $data['dataRazas'] = $objAdmin->listaRazas();
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
            $data['dataAdmin'] = $objAdmin->listar();
            $this->loadView("admin/adIndex.phtml","Administrador Logueado",$data);
    }

    // public function Closesession(){
    //     if (isset($_SESSION)){
    //         session_destroy();
    //     }
    //     $this->index();
    // }

    //aca se registran los usuarios por el Admin
    public function registraUsuario(){//falta telefono 
        $objAdmin = $this->loadModel("AdminModel");
        if (isset($_POST['Agregar'])){
            $cedula = $_POST['cedula'];
            $nombre = $_POST['nombre'];
            $rol = $_POST['rol'];
            $direccion = $_POST['direccion'];
            $contrasenia = $_POST['contrasenia'];
            $tlf = $_POST['telefono'];
        
            $objAdmin->registrarUsuario("usuarios",$cedula,$nombre,$rol,$direccion,$contrasenia, "1", $tlf);
            //mientras carga mostrarData agregar una pantalla de carga
            $this->mostrarData();
        } elseif (isset($_POST['Modificar'])){
            $cedula = $_POST['cedula'];
            $nombre = $_POST['nombre'];
            $rol = $_POST['rol'];
            $direccion = $_POST['direccion'];
            $contrasenia = $_POST['contrasenia'];
            $activo = $_POST['activo'];
            $tlf = $_POST['telefono'];
            $objAdmin->modificaUsuario($cedula,$nombre,$rol,$direccion,$contrasenia,$activo,$tlf);
            $this->mostrarData();
        }
    }

    public function agregaTipoanimal(){
        $nombre = $_POST['nombreTipo'];
        $objAdmin = $this->loadModel("AdminModel");
        $objAdmin->registraTipoAnimal('tipo_animal',$nombre);
        $this->tipoAnimal();
    }

    public function agregaRazaAnimal(){
        $nombre = $_POST['nombreRaza'];
        $TipoAnimal = $_POST['tipoanimal'];
        $objAdmin = $this->loadModel("AdminModel");
        $objAdmin->registraRazaAnimal('raza', $nombre, $TipoAnimal);
        $this->razasAnimal();
    }

    public function agregaAnimal(){//ahora si
        $objFund = $this->loadModel("AdminModel");
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
        $objFund->registraAnimal('animal', $nombre, $fechanac, $nombreArchivo, $descrip, $fecha_ing, $raza_id,$tamanio_id, $albergue_id, $visible);
        $this->agregaAnimales();
    }

    public function registraVeterinario(){
        $objAdmin = $this->loadModel("AdminModel");
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
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
            $objAdmin->registraVeterinario($nombre,$telefono,$direccion, $nombreArchivo,$adminRegistrando);
            $data['error'] = "Veterinario Agregado satisfactoriamente";//solo para avisar que se agrego supongo
            $this->loadView("admin/agVeterinario.phtml", "Agrega Veterinarios como Admin",$data);
            //ps al recargar se vuelve a guardar asi q vamos a tener q enviarlo a otra pag cada que agreguemos 
            //algo pq no encuentro otra forma de eliminar las variables luego de agregar
        } else {
            $data['error'] = "Estas enviando elementos vacios";
            $this->loadView("admin/agVeterinario.phtml", "Agrega Veterinarios como Admin",$data);
        }
    }
}

?>