<?php 

class InicioController extends GeneralController{

    public function index(){
        echo "estoy en InicioController en el metodo index()<br>";
        $data['bandera'] = 1;
        $data['programacion'] = 4;
        $this->loadView("menu/index.phtml","Inicio", $data);
    }

}

?>