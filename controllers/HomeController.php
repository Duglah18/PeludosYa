<?php 
//este sera el controlador de la pag de home de la pag la 1era pag q se visitara
//si no introduces nada en la URL ps
class HomeController extends GeneralController{
    public function home()
    {
      $this->loadView("home.phtml","inicio");
    }
}

?>