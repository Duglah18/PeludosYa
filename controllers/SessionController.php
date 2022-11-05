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
        $data['animales'] =$objSess->obtenAnimales();
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
    //adaptar a lo anterior
    //adaptado a login_user() asi q esto esta basura
    // public function redirectLogin($vista, $params = array()){//ir a la vista dependiendo de rol
    //     //params pasa los datos del usuario logeandose
    //     switch ($vista){
    //         case 1://admin
    //             $this->loadView("admin/admin.phtml","Admin");
    //             break;
    //         case 2://Usuario
    //             $this->loadView("home.phtml","Pag principal Log");
    //             break;
    //         case 3://Fundacion
    //             $this->loadView("fundacion/fundacion.phtml","Pag princ Fund log",$params);
    //             break;
    //         case 4://Vendedor
    //             $this->loadView("vendedor/vendedor.phtml","Pag Princ Vend Log");
    //             break;
    //         default:
    //             echo "papi pero entiendete q haces?";
    //             break;
    //     }
    // }
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
    #Endregion
}
?>