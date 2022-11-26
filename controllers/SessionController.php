<?php 

class SessionController extends GeneralController{
	/*==========TAREAS PARA FINALIZAR ESTE MODULO==========
	/	-Filtros de busqueda Animal 
	/	-Filtros de busqueda Veterinario
	/	-Probar Modificar usuario propio
	/	-Validaciones? 
	==========TAREAS PARA FINALIZAR ESTE MODULO==========*/
	
	
    #Region Load views
	/*****************************************************************
	*	Pertenece: SessionController
	*	Nombre: Comprobador
	*	Función: Comprobar si alguien se encuentra logueado
	*	Entradas: Session
	*	Salidas: Retorno a Pág. Principal.
	*****************************************************************/
    public function Comprobador(){//aqui esta inverso a los demas
        if(isset($_SESSION['usuario'])){
            return header("location:" . BASE_URL);
        }
    }
	
	public function ComprobarLogueo(){
		if(!isset($_SESSION['usuario'])){
			$_SESSION['Error'] = "No esta logueado";
			return header("location: " .BASE_URL);
		}
	}
	
	/******************************************************************
	*	Pertenece: SessionController
	*	Nombre: login
	*	Función: Mostrar Vista 
	*	Salidas: Vista login
	******************************************************************/
    public function login(){
        $this->Comprobador();
        $this->loadView("session/login.phtml","Login");
    }

	/******************************************************************
	*	Pertenece: SessionController
	*	Nombre: register
	*	Función: Mostrar Vista
	*	Salidas: Vista register
	******************************************************************/
    public function register(){
        $this->Comprobador();
        $this->loadView("session/register.phtml","Register");
    }
    
	/******************************************************************
	*	Pertenece: SessionController
	*	Nombre: catalogoAnimales
	*	Función: Mostrar Vista
	*	Salidas: Vista catalogo animales
	******************************************************************/
    public function catalogoAnimales(){
        $objSess = $this->loadModel("SessionModel");
        $objAdmin = $this->loadModel("AdminModel");
		$filtro = isset($_GET['filtro']) ? $_GET['filtro'] : "";
		$filtro = $filtro == "0"? "": $filtro;
		$pagina = isset($_GET['pagina'])? intval($_GET['pagina']): 1;
        $pagina = $pagina < 0? 1: $pagina;
        $qty = 5;
        $data['filtro'] = $filtro;
        $data['pagina'] = $pagina;
        $data['por_pagina'] = $qty;
		$data['tiposDeAnimal'] = $objAdmin->consultaTipoAnimal();
        $data['totalregistro'] = $objSess->TotalAnimalesCatalogoSess($filtro);
        $data['animales'] =$objSess->obtenAnimales($pagina, $qty,$filtro);
        $this->loadView("catalogo.phtml", "Ver Peluditos",$data);
    }

	/******************************************************************
	*	Pertenece: SessionController
	*	Nombre: catalogoFundaciones
	*	Función: Mostrar Vista
	*	Salidas: Vista Fundaciones
	******************************************************************/
	public function catalogoFundaciones(){
		$objSess = $this->loadModel("SessionModel");
		$pagina = isset($_GET['pagina'])? intval($_GET['pagina']): 1;
        $pagina = $pagina < 0? 1: $pagina;
        $qty = 5;
        $data['pagina'] = $pagina;
        $data['por_pagina'] = $qty;
        $data['totalregistro'] = $objSess->TotalconsultaFundaciones();
        $data['fundaciones'] =$objSess->consultaFundaciones($pagina, $qty);
        $this->loadView("fundaciones.phtml", "Ver Fundaciones",$data);
	}

	/******************************************************************
	*	Pertenece: SessionController
	*	Nombre: catalogoVeterinarios
	*	Función: Mostrar Vista
	*	Salidas: Vista Veterinarios
	******************************************************************/
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
	
	/******************************************************************
	*	Pertenece: SessionController
	*	Nombre: mascota
	*	Función: Mostrar Vista
	*	Salidas: Vista mascota Detallada
	******************************************************************/
    public function mascota(){
        $objSess = $this->loadModel("SessionModel");
        $identity = (isset($_GET['idanimal']))? $_GET['idanimal'] : "";
        $data['animal'] = $objSess->ObtenAnimalSelecc($identity);
        //el titulo se podria cambiar y poner el nombre del animal a ver
        $this->loadView("mascota.phtml", "Peludo " .$data['animal'][0]['nombre'], $data);
    }
	
	/******************************************************************
	*	Pertenece: SessionController
	*	Nombre: veterinario
	*	Función: Mostrar Vista
	*	Salidas: Vista veterinario
	******************************************************************/
    public function veterinario(){
        $objSess = $this->loadModel("SessionModel");
        //aca si creare un metodo
        $identity = (isset($_GET['idveterinario']))? $_GET['idveterinario'] : "";
        $data['veterinario'] = $objSess->ObtenVeterinarioSelecc($identity);
        //el titulo se podria cambiar y poner el nombre del animal a ver
        $this->loadView("veterinario.phtml", "Veterinario " . $data['veterinario'][0]['nombre'], $data);
    }
	
	/******************************************************************
	*	Pertenece: SessionController
	*	Nombre: verUsuario
	*	Función: Mostrar Vista
	*	Salidas: Vista Usuario
	******************************************************************/
	public function verUsuario(){
		$this->ComprobarLogueo();
		$objSess = $this->loadModel("SessionModel");
		if (!isset($_GET['id_user'])){
			//error no estas mandando ningun usuario a ver detalladamente
			$_SESSION['Error'] = "No se envio ningun Usuario";
            header("location: ".BASE_URL);
		}
		$buscar = $objSess->consultaUsuarioEspecifico($_SESSION['iduser']);
		if ($buscar == "No existe"){
			//error este usuario no existe
			$_SESSION['Error'] = "El usuario enviado es Inexistente";
            header("location: ".BASE_URL);
		}
		$data['datosUsuario'] = $buscar;
		$this->loadView("session/usuario.phtml", "Ver mi Usuario", $data);
	}
	
	/******************************************************************
	*	Pertenece: SessionController
	*	Nombre: modifica_user
	*	Función: Mostrar Vista
	*	Salidas: Vista Modificar mi usuario
	******************************************************************/
	public function modifica_user(){
		$this->ComprobarLogueo();
		if (!isset($_POST['accion']) || !isset($_POST['cedula']) || !isset($_POST['nombre']) || 
			!isset($_POST['direccion']) || !isset($_POST['contrasenia']) || !isset($_POST['telefono'])){
		//error no llega nada
			$_SESSION['Error'] = "No se enviaron Datos";
			header("location: ".BASE_URL);
		}
		$cedula = $_POST['cedula'];
		$nombre = $_POST['nombre'];
		$Direccion = $_POST['direccion'];
		$contra = $_POST['contrasenia'];
		$telefono = $_POST['telefono'];
		
		if($cedula == "" || $nombre == "" || $Direccion == "" || $contra == "" || $telefono == ""){
			$_SESSION['Error'] = "Ninguno de los datos no pueden estar vacios";
            return header("location: ".BASE_URL);
		}
		$fusion = $cedula . ";" . $nombre . ";" . $Direccion . ";" . $contra . ";" . $telefono;
		$fusion = explode(";", $fusion);
		$data['usuario'] = $fusion;
		$this->loadView("session/modificausuario.phtml","Modifica Tu usuario", $data);
	}
    #Endregion

    #Regiond Metods with Functions
	/*****************************************************************
	*	Pertenece: SessionController
	*	Nombre: login_user
	*	Función: Logueo del Usuario si esta logueado o no
	*	Entradas: Cedula, contraseña
	*	Salidas: Vista principal, vista admin
	*****************************************************************/
    public function login_user(){
		$this->Comprobador();
		if(!isset($_POST['cedula']) || !isset($_POST['pass'])){
			$_SESSION['Error'] = "Ha ocurrido un error";
			return header("location: ".BASE_URL."session/login");
		}
		
		if($_POST['cedula'] == "" || $_POST['pass'] == ""){
			$_SESSION['Error'] = "Ha ocurrido un error";
			return header("location: ".BASE_URL."session/login");
		}
		
        $cedula = $_POST['cedula'];
        $contrasenia = $_POST['pass'];
        $objUser = $this->loadModel("SessionModel");
        $validar = $objUser->loginUser($cedula,$contrasenia);
        if ($validar != true){//verifica si existe en la Bd el usuario
            //aca deberia regresarte al login y decirte:
            //campos erroneos o algo invalidos o algo erroneo
            $_SESSION['Error'] = "El usuario o la contraseña son incorrectos";
            return header("location: ".BASE_URL);
        }
        if ($validar[0]['activo'] < 1){//verifica si no esta baneado
            //aca deberia regresarte al login y decirte:
            //tu cuenta se encuentra bloqueada
            $Error = "Usuario Bloqueado.";
			$_SESSION['Error'] = "Su usuario se encuentra bloqueado";
            return header("location: ".BASE_URL."?error=". $Error);
        } 
        switch($validar[0]['rol_id']){
            //se verifica el rol si es admin el q introduces ps te manda a loguearte como admin
            case 1:
                //ya te ingresa a admin si te logueas como admin directamente
                $_SESSION['usuario'] = $validar[0]['nombre'];
                $_SESSION['rol'] = $validar[0]['rol_id'];
                $_SESSION['iduser'] = $validar[0]['cedula'];
                return header("location: " . BASE_URL. "admin/mostrarData");
                break;
            case 2:
            case 3:
            case 4:
                $_SESSION['usuario'] = $validar[0]['nombre'];
                $_SESSION['iduser'] = $validar[0]['cedula'];
                $_SESSION['rol'] = $validar[0]['rol_id'];
                $data['user'] = $objUser->loginUser($cedula, $contrasenia);
                //como todos iran a home pero logueados todo esto no sirve
                return $this->loadView("home.phtml","Inicio", $data);
                break;
            default: 
                $Error = "Ha ocurrido un error";
				$_SESSION['Error'] = "Ha ocurrido un error al loguearte.";
                return header("location: ".BASE_URL."?error=". $Error);    
                break;
        }
    }

	/*****************************************************************
	*	Pertenece: SessionController
	*	Nombre: register_user
	*	Función: usuario a registrarse
	*	Entradas: cedula, nombre, direccion, contrasenia, telefono
	*	Salidas: Vista principal usuario registrado y logueado
	*****************************************************************/
    public function register_user(){//funcion para registrarse como usuario
		$this->Comprobador();
		$objAdmin = $this->loadModel("AdminModel");
		if (!isset($_POST['cedula']) || !isset($_POST['nombre']) || !isset($_POST['direccion']) || !isset($_POST['contrasenia']) || !isset($_POST['telefono'])){
			$_SESSION['Error'] = "Ha ocurrido un error";
			return header("location: ".BASE_URL."session/register");
		}
		if($_POST['cedula'] == "" || $_POST['nombre'] == "" || $_POST['direccion'] == "" || $_POST['contrasenia'] == "" || $_POST['telefono'] == ""){
			$_SESSION['Error'] = "Ha ocurrido un error";
			return header("location: ".BASE_URL."session/register");
		}
		
		$igualdad =$objAdmin->ValidarUsuario($_POST['nombre'], $_POST['telefono']);

        if($igualdad){
            $_SESSION['Error'] = "Ya existe un Usuario con ese nombre o Telefono.";
            return header("location: " .BASE_URL."session/register");
        }

        $cedu = $_POST['cedula'];
        $nom = $_POST['nombre'];
        $dirc = $_POST['direccion'];
        $contra = $_POST['contrasenia'];
        $telefono = $_POST['telefono'];
        $objUser = $this->loadModel("SessionModel");
        //este verifica y registra
        $verificacion = $objUser->registerUser($cedu,$nom,$dirc,$contra,$telefono);
        if ($verificacion == "Usuario ya registrado"){
            $data['error'] = "Este usuario ya esta Registrado";
			$_SESSION['Error'] = "Usuario ya registrado en el sistema.";
            return $this->loadView("session/register.phtml","Register",$data);
        } else {
            $_SESSION['usuario'] = $verificacion[0]['nombre'];
            $_SESSION['iduser'] = $verificacion[0]['cedula'];
            $_SESSION['rol'] = $verificacion[0]['rol_id'];
            $data['user'] = $objUser->loginUser($cedu, $contra);
			$_SESSION['Correct'] = "Se ha registrado satisfactoriamente.";
            return $this->loadView("home.phtml","Inicio", $data);
        }
    }
	
	/*****************************************************************
	*	Pertenece: SessionController
	*	Nombre: adopcion_peticion
	*	Función: Pedir en adopcion a un animal
	*	Entradas: ID usuario, Id animal
	*	Salidas: Vista adopcion realizada
	*****************************************************************/
    public function adopcion_peticion(){
		$this->ComprobarLogueo();
        if(!isset($_POST['usuario']) || !isset($_POST['idanimal']) || $_POST['usuario'] == "" || $_POST['idanimal'] == ""){
        //si usuario no existe o esta vacio ps xD
			$_SESSION['Error'] = "Ocurrio un Error.";
            return header("location: ".BASE_URL."session/catalogoAnimales?error");
        //aca se cargaria otra vista enviando mensaje de error
        } else {
            $usuario = $_POST['usuario'];
            $idAnimal = $_POST['idanimal'];
            $objSess = $this->loadModel("SessionModel");
            //en teoria esto ya funciona
            $resultado = $objSess->registraPeticionAdopcion($idAnimal, $usuario);
			if($resultado == "Este Animal Ya fue adoptado"){//validacion de si ese animal ya esta adoptado
				$_SESSION['Error']  = "Este Animal Ya fue adoptado";
				return header("location: ".BASE_URL);
			}
            if ($resultado){  
			//aqui creo q si vuelves a recargar pag si se va a registrar de nuevo la peticion
                $data['peticion'] = $objSess->retornaResponsable($usuario);
                return $this->loadView("peticion.phtml","Peticion Realizada",$data);
            } else {
				$_SESSION['Error'] = "Ocurrio un error Intentelo de nuevo mas tarde";
				return header("location: ".BASE_URL);
			}
        }
    }
	
	/*****************************************************************
	*	Pertenece: SessionController
	*	Nombre: modificaUsuario
	*	Función: Modifica usuario propio
	*	Entradas: Cedula, nombre, direccion, contrasenia, telefono
	*	Salidas: Vista ver usuario
	*****************************************************************/
	public function modificarmiUsuario(){
		$this->ComprobarLogueo();
		$objAdmin = $this->loadModel("AdminModel");
		if(!isset($_POST['cedula']) || !isset($_POST['nombre']) || !isset($_POST['direccion']) || !isset($_POST['contrasenia']) || !isset($_POST['telefono'])){
			$_SESSION['Error'] = "Ocurrio un error.";
			return header("location: ".BASE_URL);
		}
		if($_POST['nombre'] == "" ||$_POST['direccion'] == "" || $_POST['contrasenia'] == "" || $_POST['telefono'] == ""){
			$_SESSION['Error'] = "No se enviaron datos para modificar";
			return header("location: ".BASE_URL);
		}

		$igualdad =$objAdmin->ValidarUsuario($_POST['nombre'], $_POST['telefono']);

        if($igualdad){
            $_SESSION['Error'] = "Ya existe un Usuario con ese nombre o Telefono.";
            return header("location: " .BASE_URL."session/register");
        }

        $objSess = $this->loadModel("SessionModel");
        $Nombre = $_POST['nombre'];
        $Direccion = $_POST['direccion'];
        $contrasenia = $_POST['contrasenia'];
        $telefono = $_POST['telefono'];
        $objSess->modificaUsuario($_SESSION['iduser'], $Nombre, $Direccion,$contrasenia, $telefono);
		$_SESSION['Correct'] = "Se ha actualizado tu usuario con exito";
        return header("location: ".BASE_URL."session/verUsuario");
	}
    #Endregion
}
?>