<?php 

require_once ("config/GeneralController.php");

class AboutusController extends GeneralController{

    public function index(){
        echo "estoy en Aboutus controller en el metodo index()<br>";
        $data['bandera'] = 1;
        $data['programacion'] = 4;
        $this->loadView("aboutus/about-us.phtml","Material Kit 2 by Creative Tim", $data);
    }

}

?>