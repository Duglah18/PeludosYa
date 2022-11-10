<?php 
//este sera el controlador de la pag de home de la pag la 1era pag q se visitara
//si no introduces nada en la URL ps
class HomeController extends GeneralController{
    public function home()
    {
      $this->loadView("home.phtml","Inicio");
    }
    public function destroy_session(){
      if(isset($_SESSION['usuario'])){
        $objAdmin = $this->loadModel("AdminModel");
        $objAdmin->registraCierraSesion($_SESSION['iduser']);
        session_destroy();
        header("refresh: ". 0);
        $this->loadView("home.phtml","inicio");
      }//literalmente sin lo de abajo la pag no carga al recargarse xD
      $this->loadView("home.phtml","inicio");
    }
}

?>