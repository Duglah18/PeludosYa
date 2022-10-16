<?php

class MenuController extends GeneralController{//aqui basicamente se llaman a las vistas y modelos

    public function index(){
        $data['bandera'] = 1;
        $data['programacion'] = 4;
        $this->loadView("menu/index.phtml","Inicio", $data);
    }

    public function listar(){
        $objMenu = $this->loadModel("MenuModel");
        $data['dataMenu'] = $objMenu->listar();
        $this->loadView("menu/listar.phtml","Listar", $data);
    }

    public function actualizar(){
        $objMenu = $this->loadModel("MenuModel");
        echo $objMenu->actualizar();
    }

    public function nuevo(){
        $objMenu = $this->loadModel("MenuModel");
        echo $objMenu->registrar();
    }

    public function mostrar(){
        echo "estoy en MenuController en el metodo mostrar()<br>";
    }

}