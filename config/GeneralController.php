<?php 
/*Controlador general de las vistas*/
class GeneralController {
    
	/*****************************************************************
	*	Pertenece: GeneralController
	*	Nombre: loadModel
	*	Función: Cargar Modelo
	*	Entradas: Nombre del modelo a cargar
	*****************************************************************/
    public function loadModel($nombremodelo){//carga el modelo colocando el nombre del modelo 
        require_once 'models/' . $nombremodelo . '.php';
        return new $nombremodelo();
    }
    
	/*****************************************************************
	*	Pertenece: GeneralController
	*	Nombre: loadModel
	*	Función: Mostrar Vistas
	*	Entradas: Direccion de la vista y nombre,Titulo, parametos que puedes enviar a mostrar 
	*****************************************************************/
	public function loadView($vista, $titulo, $parametros = array()){
        foreach (array_keys($parametros) as $key) {
            $$key = $parametros[$key];
        }
        require_once 'views/EstandarView.phtml';
    }
}