<?php 
/*Controlador general de las vistas*/
class GeneralController {
    
    public function loadModel($nombremodelo){//carga el modelo colocando el nombre del modelo 
        require_once 'models/' . $nombremodelo . '.php';
        return new $nombremodelo();
    }
    //carga las vistas colocando la vista que quieres ver
    //de igual forma puedes colocarle el titulo si quieres a la pagina que vas a ver y de paso
    //pasar parametros facilmente alli si te recomiendo ver los videos que yo vi para hacer esto.
    public function loadView($vista, $titulo, $parametros = array()){
        foreach (array_keys($parametros) as $key) {
            $$key = $parametros[$key];
        }
        require_once 'views/EstandarView.phtml';
    }
}