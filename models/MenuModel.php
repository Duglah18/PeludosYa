<?php 

class MenuModel extends ConexionBD{
    //y esto dependiendo como se llame el archivo va a realizar una accion en
    //los controladores donde se llamen igual para mas ejemplos vaya a MenuController 
    //que alli se llaman estos.
    public function registrar(){
        $data['padre'] = "0";
        $data['nombre'] = "opcion 2";
        $data['url'] = "opcion3/mostrar";
        return $this->grabaData("mb_menu", $data);
    }

    public function actualizar(){
        $data['nombre'] = "actualizado";
        return $this->actualizaData("mb_menu", $data,"idmenu=1");
    }

    public function listar(){
        return $this->obtenData("SELECT * FROM mb_menu");
    }
    
}