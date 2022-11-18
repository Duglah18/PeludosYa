<?php 
class HomeController extends GeneralController{
    
	/******************************************************************
	*	Pertenece: HomeController
	*	Nombre: home
	*	Función: Mostrar Vista
	*	Salidas: Vista Principal 
	******************************************************************/
	public function home()
    {
      $this->loadView("home.phtml","Inicio");
    }
	
	/******************************************************************
	*	Pertenece: HomeController
	*	Nombre: destroy_session
	*	Función: Mostrar Vista
	*	Salidas: Cerrar Sesion
	******************************************************************/
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