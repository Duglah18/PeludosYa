<?php 
//Controlador donde se manejara las idas a login y register ademas de
//pedir sus funciones
class SessionController extends GeneralController{
    #Region Load views
    public function login(){
        $this->loadView("session/login.phtml","Login");
    }

    public function register(){
        $this->loadView("session/register.phtml","Register");
    }
    
    public function redirectLogin($vista, $params = array()){//ir a la vista dependiendo de rol
        //params pasa los datos del usuario logeandose
        switch ($vista){
            case 1://admin
                $this->loadView("admin/admin.phtml","Admin");
                break;
            case 2://Usuario
                $this->loadView("home.phtml","Pag principal Log");
                break;
            case 3://Fundacion
                $this->loadView("fundacion/fundacion.phtml","Pag princ Fund log",$params);
                break;
            case 4://Vendedor
                $this->loadView("vendedor/vendedor.phtml","Pag Princ Vend Log");
                break;
            default:
                echo "papi pero entiendete q haces?";
                break;
        }
    }
    #Endregion

    #Regiond Metods with Functions
    public function login_user(){
        $cedula = $_POST['cedula'];
        $contrasenia = $_POST['pass'];
        $objUser = $this->loadModel("SessionModel");
        $validar = $objUser->loginUser($cedula,$contrasenia);
        //password_verify() 
        //password_hash()
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
        $data['user'] = $objUser->loginUser($cedula, $contrasenia);
        switch ($validar[0]['rol_id']){//se verifica el tipo de usuario que es
            //si eres vendedor a un lugar si usuario a otro y asi,
            //exceptuando que si eres admin supongo que no servira
            //se puede acortar mandando directamente en un case el 
            //id del rol
            case 1:
                echo "USTED ES ADMIN ESTE NO ES SU LUGAR";
                $this->redirectLogin(1);
                break;
            case 2:
                echo "USTED ES USUARIO";
                $this->redirectLogin(2);
                break;
            case 3:
                echo "USTED ES FUNDACION";
                $this->redirectLogin(3,$data);
                break;
            case 4:
                echo "USTED ES VENDEDOR";
                $this->redirectLogin(4);
                break;
            default:
                echo "Este Rol No existe";
                $this->redirectLogin(5);
                break;
        }
        //print_r($validar);//queria ver el array
        //se muestra si no esta baneado el usuario y si existe
        //aca se deberia ir a la pagina ya logueado
        echo "<br>" . "Esta logueado y no esta bloqueado";
        
    }

    public function register_user(){//funcion para registrarse como usuario
        $cedu = $_POST['cedula'];
        $nom = $_POST['nombre'];
        $dirc = $_POST['direccion'];
        $contra = $_POST['contrasenia'];
        $objUser = $this->loadModel("SessionModel");
        $objUser->registerUser($cedu,$nom,$dirc,$contra);
        //en creacion
        
    }
    #Endregion
}
?>