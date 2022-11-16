<?php 

class FundacionController extends GeneralController{
    /*==========TAREAS PARA FINALIZAR ESTE MODULO==========
	/	-Validaciones
	/	-Filtros de busqueda
	/	-Revisar en vistas si en algun lugar se muestra la fecha desordenada
	/	-En la vista de Ver a los animales colocar cantidad de pedidos de adopciones
	-Modificado el ver la fecha de ingreso de animales en ver animales fundacion
	==========TAREAS PARA FINALIZAR ESTE MODULO==========*/
	
	#Region Views
    public function Comprobador(){
        if(!isset($_SESSION['usuario']) || $_SESSION['rol'] != 3){
           return header("location:" . BASE_URL);
        }
    }

    public function agregaAlberg(){
        $this->Comprobador();
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
        $this->Comprobador();
        $objFund = $this->loadModel("FundacionModel");
        $pagina = isset($_GET['pagina'])? intval($_GET['pagina']): 1;
        $pagina = $pagina < 0? 1: $pagina;
        $qty = 10;
        $data['pagina'] = $pagina;
        $data['por_pagina'] = $qty;
        $data['totalregistro'] = $objFund->TotalconsultaAlbergues($_SESSION['iduser']);
        $data['userfund'] = $objFund->consultaAlbergue($_SESSION['iduser'],$pagina,$qty);
        $this->loadview("fundacion/veralbergues.phtml","Ver albergues",$data);
    }

    public function animales(){
        $this->Comprobador();
        $objFund = $this->loadModel("FundacionModel");
        $pagina = isset($_GET['pagina'])? intval($_GET['pagina']): 1;
        $pagina = $pagina < 0? 1: $pagina;
        $qty = 10;
        $data['pagina'] = $pagina;
        $data['por_pagina'] = $qty;
        $data['totalregistro'] = $objFund->TotalConsultaAnimales($_SESSION['iduser']);
        $data['useranimales'] = $objFund->consultaAnimales($_SESSION['iduser'],$pagina,$qty);
        $data['albergues'] = $objFund->consultaAlbergue($_SESSION['iduser'],$pagina,$qty);
        $this->loadView("fundacion/veranimales.phtml","Ver Animales",$data);
    }

    public function agregaAnimal(){
        $this->Comprobador();
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
                $data['animal_selecc'] = $data['raza'][0]['nombredeTanimal'];
            }
            $data['tamano'] = $objFund->consultaTamanoAnimal();
            $data['albergues'] = $objFund->consultaAlbergue($_SESSION['iduser']);
            $this->loadView("fundacion/agAnimal.phtml","Agregar Animal",$data);
        }
    }
    
    public function verAdopciones(){
        $this->Comprobador();
        $objFund = $this->loadModel("FundacionModel");
        $pagina = isset($_GET['pagina'])? intval($_GET['pagina']): 1;
        $pagina = $pagina < 0? 1: $pagina;
        $qty = 10;
        $data['pagina'] = $pagina;
        $data['por_pagina'] = $qty;
        $data['totalregistro'] = $objFund->TotalconsultaAdopciones($_SESSION['iduser']);
        $data['adopciones'] = $objFund->consultaAdopciones($_SESSION['iduser'],$pagina,$qty);
        $this->loadView("fundacion/adopciones.phtml","Ver Adopciones",$data);
    }

    public function modificaAdopcion(){
        $this->Comprobador();
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
    public function registraFundacion(){//funciona 9/10/2022
        $objFund = $this->loadModel("FundacionModel");
        if(!isset($_POST['accion'])){//es mejor asi
            return header("location: ".BASE_URL);
        }
        if($_POST['accion'] == 'Modificar'){
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
        } elseif ($_POST['accion'] == 'Agregar') {
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
        if(!isset($_POST['accion'])|| !isset($_POST['nombre']) || !isset($_POST['raza']) || !isset($_POST['descrip'])){
           $Error = "No se enviaron Datos";
		   return header("location: ".BASE_URL."fundacion/animales");
        
		}
		
		if (!is_int($_POST['fecha']) || $_POST['fecha'] < 0 ){
			$Error = "Año de Nacimiento Incorrecto";
			return header("location: ".BASE_URL."fundacion/animales?error=".$Error);
			
		}
		
        if ($_POST['accion'] == 'Agregar'){
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
            return header("location: ".BASE_URL."fundacion/animales");
        } elseif ($_POST['accion'] == 'Modificar') {
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
            return header("location: ".BASE_URL."fundacion/animales");
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
            $razon = "Registro Usuario";
        }
        elseif($_GET['accion'] == 'Cancelada'){
            $accion = 2;
            $razon = $_GET['razoncancelado'];
        }
        $objFund->decisionAdopcion($eleccion, $accion, $razon,$_GET['usuario']);
        return header("location: ".BASE_URL."fundacion/verAdopciones");
    }

    public function inactivaPeludos(){
        $this->Comprobador();
        $objAdmin = $this->loadModel("FundacionModel");
        if(!isset($_POST['accion']) || !isset($_POST['decision']) || !isset($_POST['modificacion'])){
            return header("location: ".BASE_URL."fundacion/animales?error");
        }
        $id_peludo = $_POST['modificacion'];
        if($_POST['accion'] == "Activar"){
            $decision = 1;
        } elseif ($_POST['accion'] == "Inactivar"){
            $decision = 0;
        }

        $objAdmin->DecisionActivacionPeludos($id_peludo, $decision, $_SESSION['iduser']);
        return header("location: ".BASE_URL."fundacion/animales");
    }

    public function inactivaAlbergue(){
        $this->Comprobador();
        $objAdmin = $this->loadModel("FundacionModel");
        if(!isset($_POST['accion']) || !isset($_POST['decision']) || !isset($_POST['modificacion'])){
            return header("location: ".BASE_URL."fundacion/albergues?error");
        }
        $id_albergue = $_POST['modificacion'];
        if($_POST['accion'] == "Activar"){
            $decision = 1;
        } elseif ($_POST['accion'] == "Inactivar"){
            $decision = 0;
        }

        $objAdmin->DecisionActivacionAlbergues($id_albergue, $decision, $_SESSION['iduser']);
        return header("location: ".BASE_URL."fundacion/albergues");
    }
    #endregion
}
?>