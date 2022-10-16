<?php 

class AdminController extends GeneralController{
    #Region Views
    public function index(){
        echo "estoy en Admin controller en el metodo index()<br>";
        $data['bandera'] = 4;
        $data['programacion'] = 43;
        $this->loadView("admin/admin.phtml","Login Administrador", $data);
    }
    
    //Vista Agregar usuarios Admin
    public function agregaUsuarios(){
        echo "estoy en Admin Controller en el metodo agregaUsuarios()<br>";
        $objAdmin = $this->loadModel("AdminModel");
        $data['dataRoles'] = $objAdmin->ConsultaRoles();
        $this->loadView("admin/agusaurios.phtml","Agrega usuarios como Admin", $data);
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
            $data['dataAdmin'] = $objAdmin->listar();
            $this->loadView("admin/adIndex.phtml","Administrador Logueado",$data);
    }
    //aca se registran los usuarios por el Admin
    public function registraUsuario(){//falta telefono 
        $cedula = $_POST['cedula'];
        $nombre = $_POST['nombre'];
        $rol = $_POST['rol'];
        $direccion = $_POST['direccion'];
        $contrasenia = $_POST['contrasenia'];
        $tlf = $_POST['telefono'];
        $objAdmin = $this->loadModel("AdminModel");
        $objAdmin->registrarUsuario("usuarios",$cedula,$nombre,$rol,$direccion,$contrasenia, "1", $tlf);
        //mientras carga mostrarData agregar una pantalla de carga
        $this->mostrarData();
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
}

?>