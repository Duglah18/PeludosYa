<?php 
//Controlador donde se manejara las idas a login y register ademas de
//pedir sus funciones
class SessionController extends GeneralController{
    #Region Load views
    //prueba de la creacion de cadenas funciona :D
    // public function prueba(){
    //     $data['hola'] = "amigo";
    //     $data['columna2'] = "columna2prueba";
    //     echo $this->creaCadenaInsert($data,"bitacora");
    //     echo $this->creaCadenaUpdate("ajasi", $data, "igual = igual");
    // }

    public function login(){
        $this->loadView("session/login.phtml","Login");
    }

    public function register(){
        $this->loadView("session/register.phtml","Register");
    }
    
    public function catalogoAnimales(){
        $objSess = $this->loadModel("SessionModel");
        $pagina = isset($_GET['pagina'])? intval($_GET['pagina']): 1;
        $pagina = $pagina < 0? 1: $pagina;
        $qty = 5;
        $data['pagina'] = $pagina;
        $data['por_pagina'] = $qty;
        $data['totalregistro'] = $objSess->TotalAnimalesCatalogoSess();
        $data['animales'] =$objSess->obtenAnimales($pagina, $qty);
        $this->loadView("catalogo.phtml", "Ver Peluditos",$data);
    }

    public function catalogoVeterinarios(){
        //el mismo metodo ya existe en admin asi q mejor no creo otro metodo en session y ya
        $objSess = $this->loadModel("SessionModel");
        $pagina = isset($_GET['pagina'])? intval($_GET['pagina']): 1;
        $pagina = $pagina < 0? 1 : $pagina;
        $qty = 5;
        $data['pagina'] = $pagina;
        $data['por_pagina'] = $qty;
        $data['totalregistro'] = $objSess->TotalVeterinarios();
        $data['veterinarios'] = $objSess->consultarVeterinarios('',$pagina,$qty);
        $this->loadView("veterinarios.phtml","Ver Veterinarios",$data);
    }

    public function mascota(){
        $objSess = $this->loadModel("SessionModel");
        $identity = (isset($_GET['idanimal']))? $_GET['idanimal'] : "";
        $data['animal'] = $objSess->ObtenAnimalSelecc($identity);
        //el titulo se podria cambiar y poner el nombre del animal a ver
        $this->loadView("mascota.phtml", "Animal Detallado", $data);
    }

    public function veterinario(){
        $objSess = $this->loadModel("SessionModel");
        //aca si creare un metodo
        $identity = (isset($_GET['idveterinario']))? $_GET['idveterinario'] : "";
        $data['veterinario'] = $objSess->ObtenVeterinarioSelecc($identity);
        //el titulo se podria cambiar y poner el nombre del animal a ver
        $this->loadView("veterinario.phtml", "Veterinario Detallado", $data);
    }
	//Creado en la oficina 11/11/2022
	public function verUsuario(){
		$objSess = $this->loadModel("SessionModel");
		if (!isset($_GET['id_user'])){
			//error no estas mandando ningun usuario a ver detalladamente
            echo "NO MANDASTE USUARIO";
		}
		$buscar = $objSess->consultaUsuarioEspecifico($_SESSION['iduser']);
		if ($buscar == "No existe"){
			//error este usuario no existe
            echo "ESTE USUARIO NO EXISTE";
		}
		$data['datosUsuario'] = $buscar;
		$this->loadView("session/usuario.phtml", "Ver mi Usuario", $data);
		//a futuro lo puedes cambiar a cualquier otra cosa como que le saque su nombre o algo;
	}
	
	public function modifica_user(){
		if (!isset($_POST['accion']) || !isset($_POST['cedula']) || !isset($_POST['nombre']) || !isset($_POST['direccion']) || !isset($_POST['contrasenia']) || !isset($_POST['telefono'])){
		//error no llega nada
        echo "NO SE ESTAN ENVIANDO DATOS";
		}
		$cedula = $_POST['cedula'];
		$nombre = $_POST['nombre'];
		$Direccion = $_POST['direccion'];
		$contra = $_POST['contrasenia'];
		$telefono = $_POST['telefono'];
		
		if($cedula == "" || $nombre == "" || $Direccion == "" || $contra == "" || $telefono == ""){
			//error estan vacios
		}
		$fusion = $cedula . ";" . $nombre . ";" . $Direccion . ";" . $contra . ";" . $telefono;
		$fusion = explode(";", $fusion);
		$data['usuario'] = $fusion;
		// $data['cedula'] = $cedula;
		// $data['nombre'] = $nombre;
		// $data['direccion'] = $Direccion;
		// $data['contrasenia'] = $contra;
		// $data['telefono'] = $telefono;
		$this->loadView("session/modificausuario.phtml","Modifica Tu usuario", $data);
	}
    #Endregion

    #Regiond Metods with Functions
    public function login_user(){
        $cedula = $_POST['cedula'];
        $contrasenia = $_POST['pass'];
        $objUser = $this->loadModel("SessionModel");
        $validar = $objUser->loginUser($cedula,$contrasenia);
        if ($validar != true){//verifica si existe en la Bd el usuario
            //aca deberia regresarte al login y decirte:
            //campos erroneos o algo invalidos o algo erroneo
            die("No esta registrado");
        }
        if ($validar[0]['activo'] < 1){//verifica si no esta baneado
            //aca deberia regresarte al login y decirte:
            //tu cuenta se encuentra bloqueada
            die ("usted esta bloqueado");
        } 
        switch($validar[0]['rol_id']){
            //se verifica el rol si es admin el q introduces ps te manda a loguearte como admin
            case 1:
                //ya te ingresa a admin si te logueas como admin directamente
                $_SESSION['usuario'] = $validar[0]['nombre'];
                $_SESSION['rol'] = $validar[0]['rol_id'];
                $_SESSION['iduser'] = $validar[0]['cedula'];
                header("location: " . BASE_URL. "admin/mostrarData");
                break;
            case 2:
            case 3:
            case 4:
                $_SESSION['usuario'] = $validar[0]['nombre'];
                $_SESSION['iduser'] = $validar[0]['cedula'];
                $_SESSION['rol'] = $validar[0]['rol_id'];
                $data['user'] = $objUser->loginUser($cedula, $contrasenia);
                //como todos iran a home pero logueados todo esto no sirve
                $this->loadView("home.phtml","Inicio", $data);
                break;
            default: 
                
                break;
        }
    }

    public function register_user(){//funcion para registrarse como usuario
        $cedu = $_POST['cedula'];
        $nom = $_POST['nombre'];
        $dirc = $_POST['direccion'];
        $contra = $_POST['contrasenia'];
        $telefono = $_POST['telefono'];
        $objUser = $this->loadModel("SessionModel");
        //este verifica y registra
        $verificacion = $objUser->registerUser($cedu,$nom,$dirc,$contra,$telefono);
        if ($verificacion = "Usuario ya registrado"){
            $data['error'] = "Este usuario ya esta Registrado";
            $this->loadView("session/register.phtml","Register",$data);
            die();
        } else {
            $_SESSION['usuario'] = $verificacion[0]['nombre'];
            $_SESSION['iduser'] = $verificacion[0]['cedula'];
            $_SESSION['rol'] = $verificacion[0]['rol_id'];
            $data['user'] = $objUser->loginUser($cedu, $contra);
            $this->loadView("home.phtml","Inicio", $data);
        }
    }

    public function adopcion_peticion(){
    if($_POST['usuario'] == "" || $_POST['idanimal'] == ""){
        //si usuario no existe o esta vacio ps xD
        $this->catalogoAnimales();
        //aca se cargaria otra vista enviando mensaje de error
        } else {
            $usuario = $_POST['usuario'];
            $idAnimal = $_POST['idanimal'];
            $objSess = $this->loadModel("SessionModel");
            //en teoria esto ya funciona
            $resultado = $objSess->registraPeticionAdopcion($idAnimal, $usuario);
            if ($resultado){  
                $data['peticion'] = $objSess->retornaResponsable($usuario);
                $this->loadView("peticion.phtml","Peticion Realizada",$data);
                $_POST['usuario'] = "";
                $_POST['idanimal'] = "";
            }
        }
    }
	
	public function modificarmiUsuario(){
		if(!isset($_POST['cedula'])){
			$_POST['Error'] = "No se especifico a quien modificar"; //esto funcionaria? sino por get se puede
			//error retorna
		}
        $objSess = $this->loadModel("SessionModel");
        $Nombre = $_POST['nombre'];
        $Direccion = $_POST['direccion'];
        $contrasenia = $_POST['contrasenia'];
        $telefono = $_POST['telefono'];
        $objSess->modificaUsuario($_SESSION['iduser'], $Nombre, $Direccion,$contrasenia, $telefono);
        header("location: ".BASE_URL."session/verUsuario");
	}
    #Endregion
}
?>