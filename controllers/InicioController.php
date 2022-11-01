<?php 

class InicioController extends GeneralController{

    public function index(){
        $data['bandera'] = 1;
        $data['programacion'] = 4;
        $this->loadView("menu/index.phtml","Inicio", $data);
    }

}

?>