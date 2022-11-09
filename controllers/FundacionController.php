<?php 
    //busca el globalizar el $objFund
class FundacionController extends GeneralController{
    #Region Views
    public function agregaAlberg(){
        //hay que quitar el model porque este select es para seleccionar
        //a que usuario guardarle el albergue
        $objFund = $this->loadModel("FundacionModel");
        if (isset($_POST['accion'])){
            $data['userfund'] = $objFund->consultaUser();
            $data['albergue'] = $objFund->consultaAlberguePorID($_POST['modificacion']);
            $this->loadView("fundacion/agalbergue.phtml","Modificar Albergue",$data);
        } else {
            $data['userfund'] = $objFund->consultaUser();
            $this->loadView("fundacion/agalbergue.phtml","Agregar Albergue",$data);
        }
    }

    public function albergues(){
        $objFund = $this->loadModel("FundacionModel");
        $data['userfund'] = $objFund->consultaAlbergue($_SESSION['iduser']);
        $this->loadview("fundacion/veralbergues.phtml","Ver albergues",$data);
    }

    public function animales(){
        $objFund = $this->loadModel("FundacionModel");
        $pagina = isset($_GET['pagina'])? intval($_GET['pagina']): 1;
        $pagina = $pagina < 0? 1: $pagina;
        $qty = 10;
        $data['pagina'] = $pagina;
        $data['por_pagina'] = $qty;
        $data['totalregistro'] = $objFund->TotalConsultaAnimales($_SESSION['iduser']);
        $data['useranimales'] = $objFund->consultaAnimales($_SESSION['iduser'],$pagina,$qty);
        $data['albergues'] = $objFund->consultaAlbergue($_SESSION['iduser']);
        $this->loadView("fundacion/veranimales.phtml","Ver Animales",$data);
    }

    public function agregaAnimal(){
        $objFund = $this->loadModel("FundacionModel");
        $objAdmin = $this->loadModel("AdminModel");
        if (isset($_POST['accion']) && $_POST['accion'] == 'Modificar'){
            $data['tipoanimal'] = $objFund->consultaTipoAnimal();
            $data['raza'] = $objFund->consultaRazaAnimal('');
            $data['tamano'] = $objFund->consultaTamanoAnimal();
            $data['albergues'] = $objFund->consultaAlbergue($_SESSION['iduser']);
            $data['animales'] = $objAdmin->consultarAnimal($_POST['modificacion']);
            $this->loadView("fundacion/agAnimal.phtml","Modificar Animal",$data);
        } else {
        $data['tipoanimal'] = $objFund->consultaTipoAnimal();
        if(isset($_POST['tipoanimal'])){
            $busqueda_animal= $_POST['tipoanimal'];
        $data['raza'] = $objFund->consultaRazaAnimal($busqueda_animal);
        }
        $data['tamano'] = $objFund->consultaTamanoAnimal();
        $data['albergues'] = $objFund->consultaAlbergue($_SESSION['iduser']);
        $this->loadView("fundacion/agAnimal.phtml","Agregar Animal",$data);
        }
    }
    
    public function verAdopciones(){
        //aca mismo a futuro podriamos hacer un if te llega una variable especifica
        //se hace en este mismo metodo el filtrar por las completadas, etc.
        $objFund = $this->loadModel("FundacionModel");
        $data['adopciones'] = $objFund->consultaAdopciones($_SESSION['iduser']);
        $this->loadView("fundacion/adopciones.phtml","Ver Adopciones",$data);
    }

    public function modificaAdopcion(){
        if(!isset($_POST['accion'])){
            return $this->verAdopciones();
        }
        $objFund = $this->loadModel("FundacionModel");
        $data['adopcion'] = $objFund->consultaAdopcionEspecifica($_POST['modificacion']);
        $data['estado_adop'] = $objFund->consultaEstadosAdopciones();
        $this->loadView("fundacion/modAdopcion.phtml","Modifica La Adopcion",$data);
    }
    #endregion
    #Region Metods/functions
    public function registraFundacion(){//funciona 9/10
        $objFund = $this->loadModel("FundacionModel");
        if(isset($_POST['accion']) == 'Modificar'){
            $id_albergue = $_POST['identificador'];
            $Nombre = $_POST['nombre'];
            $direccion = $_POST['direccion'];
            $cedula = $_POST['cedula_user'];
            $activo = $_POST['activo'];
            $objFund->modificaAlbergue($id_albergue, $Nombre, $cedula, $direccion, 
                                        $activo, $_SESSION['iduser']);
            if($_SESSION['rol'] == "1"){//revisa esto
                // $objAdmin = $this->loadModel("FundacionModel");
                // $data['alberguesAdmin'] = $objAdmin->consultaAlbergue('');
                header("location: ".BASE_URL."admin/albergues");
            } 
            header("location: ".BASE_URL."fundacion/albergues");
        } else {
            $Nombre = $_POST['nombre'];
            $direccion = $_POST['direccion'];
            $cedula = $_POST['cedula_user'];
            $objFund->registraAlbergue("albergue",$cedula,$Nombre,$direccion,1);
            if($_SESSION['rol'] == "1"){
                header("location: ".BASE_URL."admin/albergues");
            } else {
                header("location: ".BASE_URL."fundacion/albergues");
            }
        }
    }

    public function registraAnimal(){//ahora si
        $objFund = $this->loadModel("FundacionModel");
        $objAdmin = $this->loadModel("AdminModel");
        if(!isset($_POST['nombre']) || !isset($_POST['raza']) || !isset($_POST['descrip'])){
            header("location: ".BASE_URL."fundacion/animales");
        }
        if (isset($_POST['accion']) && $_POST['accion'] == 'Agregar'){
            $nombre = $_POST['nombre'];
            $fechanac= $_POST['fecha'];
            /*----------------------Empezamos el tratamiento de img----------------------------*/
            //esto es lo q queria automatizar pq vamos a tener q hacer esto cada q queramos guardar una img
            $fecha_paratmp = new DateTime();
            $imgtxt = (isset($_FILES['img']['name']))?$_FILES['img']['name']:"";
            $nombreArchivo =($imgtxt!="")?$fecha_paratmp->getTimestamp()."_".$_FILES['img']['name']:"imagen.jpg";
            $image= $_FILES['img']['tmp_name'];
            if ($image!=""){
                move_uploaded_file($image,"./img/animales/".$nombreArchivo);
            }
            /*----------------------Terminado el tratamiento de img----------------------------*/
            $descrip= $_POST['descrip'];
            $fecha_ing= "Now()";
            $raza_id= $_POST['raza'];
            $tamanio_id= $_POST['tamano'];
            $albergue_id= $_POST['albergue'];
            $visible = 1;
            $objFund->registraAnimal('animal', $nombre, $fechanac, $nombreArchivo, $descrip, 
                                        $fecha_ing, $raza_id,$tamanio_id, $albergue_id, 
                                        $visible, $_SESSION['iduser']);
            header("location: ".BASE_URL."fundacion/animales");
        } elseif (isset($_POST['accion']) && $_POST['accion'] == 'Modificar') {
            $id_animal = $_POST['id_animal'];
            $nombre = $_POST['nombre'];
            $fechanac= $_POST['fecha'];
            $img_modificar = $_POST['imgmodificar'];
            /*----------------------Empezamos el tratamiento de img----------------------------*/
            //esto es lo q queria automatizar pq vamos a tener q hacer esto cada q queramos guardar una img
            $fecha_paratmp = new DateTime();
            $imgtxt = (isset($_FILES['img']['name']))?$_FILES['img']['name']:"";
            $nombreArchivo =($imgtxt!="")?$fecha_paratmp->getTimestamp()."_".$_FILES['img']['name']:"imagen.jpg";
            $image= $_FILES['img']['tmp_name'];
            move_uploaded_file($image,"./img/animales/".$nombreArchivo);
            
            $imagenEliminar = $objAdmin->consultarAnimal($id_animal);
                if($imagenEliminar[0]['img'] != $nombreArchivo){
                    if ($imagenEliminar[0]["img"]!="imagen.jpg") {
                        if (file_exists("./img/animales/".$imagenEliminar[0]["img"])) {
                            unlink("./img/animales/".$imagenEliminar[0]["img"]);
                        }
                    }
            } else {
                $nombreArchivo = $img_modificar;
            }
            /*----------------------Terminado el tratamiento de img----------------------------*/
            $descrip= $_POST['descrip'];
            $raza_id= $_POST['raza'];
            $tamanio_id= $_POST['tamano'];
            $albergue_id= $_POST['albergue'];
            $visible = $_POST['visible'];
            $objAdmin->modificaAnimal('animal', $id_animal,$nombre, $fechanac, 
                                        $nombreArchivo, $descrip, $raza_id,$tamanio_id, $albergue_id,
                                         $visible, $_SESSION['iduser']);
            header("location: ".BASE_URL."fundacion/animales");
        }
    }
    public function destinoAdopcion(){
        $objFund = $this->loadModel("FundacionModel");
        if(isset($_GET['accion']) == ""){
            return $this->verAdopciones();
        }
        if(!isset($_GET['accion']) || !isset($_GET['modificacion'])){
            return $this->verAdopciones();
        }
        $eleccion = $_GET['modificacion'];
        if($_GET['accion'] == 'Completada'){
            $accion = 3;
        }
        elseif($_GET['accion'] == 'Cancelada'){
            $accion = 2;
        }
        $objFund->decisionAdopcion($eleccion, $accion, $_GET['usuario']);
        header("location: ".BASE_URL."fundacion/verAdopciones");
    }
    #endregion
}

?>