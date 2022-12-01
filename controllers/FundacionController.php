<?php

class FundacionController extends GeneralController{
    /*==========TAREAS PARA FINALIZAR ESTE MODULO==========
	/	-Validaciones
	/	-Filtros de busqueda
	/	-Revisar en vistas si en algun lugar se muestra la fecha desordenada
	/	-En la vista de Ver a los animales colocar cantidad de pedidos de adopciones
	/	-Modificado el ver la fecha de ingreso de animales en ver animales fundacion
	==========TAREAS PARA FINALIZAR ESTE MODULO==========*/
	
	#Region Views
	/*****************************************************************
	*	Pertenece: FundacionController
	*	Nombre: Comprobador
	*	Función: Comprobar si alguien se encuentra logueado o si tiene el rol requerido
	*	Entradas: Session y Rol
	*	Salidas: Retorno a Pág. Principal.
	*****************************************************************/
    public function Comprobador(){
        if(!isset($_SESSION['usuario']) || $_SESSION['rol'] != 3){
           $_SESSION['Error'] = "Usted no posee el nivel suficiente para entrar aquí";
		   return header("location:" . BASE_URL);
        }
    }
	
	/******************************************************************
	*	Pertenece: FundacionController
	*	Nombre: agregaAlberg
	*	Función: Mostrar Vista
	*	Entradas: (Modifica): ID albergue
	*	Salidas: vista Agrega Albergue propio
	******************************************************************/
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
	
	/******************************************************************
	*	Pertenece: FundacionController
	*	Nombre: albergues
	*	Función: Mostrar Vista
	*	Salidas: Vista Albergues propios
	******************************************************************/
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
	
	/******************************************************************
	*	Pertenece: FundacionController
	*	Nombre: animales
	*	Función: Mostrar Vista
	*	Salidas: Vista Animales propios
	******************************************************************/
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
	
	/******************************************************************
	*	Pertenece: FundacionController
	*	Nombre: agregaAnimal
	*	Función: Mostrar Vista
	*	Entradas: (modificar): ID animal
	*	Salidas: Vista Agrega Animal
	******************************************************************/
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
	
	/******************************************************************
	*	Pertenece: FundacionController
	*	Nombre: verAdopciones
	*	Función: Mostrar Vista
	*	Salidas: Vista Adopciones De sus albergues
	******************************************************************/
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
    #endregion
	
    #Region Metods/functions
	/*****************************************************************
	*	Pertenece: FundacionController
	*	Nombre: registraFundacion
	*	Función: Registra/modificaAlbergue
	*	Entradas: nombre, cedula propietario, direccion, activo
	*	Salidas: Ver albergues
	*****************************************************************/
    public function registraFundacion(){//funciona 9/10/2022
        $objFund = $this->loadModel("FundacionModel");
        $objAdmin = $this->loadModel("AdminModel");
        if(!isset($_POST['accion'])){
			$_SESSION['Error'] = "Ocurrio un error inesperado";
            return header("location: ".BASE_URL);
        }
		if(!isset($_POST['nombre']) || !isset($_POST['direccion']) || !isset($_POST['cedula_user'])){
			$_SESSION['Error'] = "No se enviaron datos";
			return header("location: ".BASE_URL."admin/albergues");
		}
		
		if($_POST['nombre'] == "" || $_POST['direccion'] == "" || $_POST['cedula_user'] == ""){
			$_SESSION['Error'] = "Los datos introducidos no son validos";
			return header("location: ".BASE_URL."admin/albergues");
		}
		
        if($_POST['accion'] == 'Modificar'){
			if (!isset($_POST['identificador'])){
				$_SESSION['Error'] = "No se envio un identificador de Albergue para modificar";
				return header("location: ".BASE_URL."admin/albergues");
			}

            $igualdad =$objAdmin->ValidarModificacionAlbergue($_POST['nombre'], $_POST['identificador']);

            if($igualdad){
                $_SESSION['Error'] = "Ya existe un Albergue con ese nombre.";
                if($_SESSION['rol'] == "1"){
                    return header("location: ".BASE_URL."admin/albergues");
                } 
                return header("location: " .BASE_URL."fundacion/albergues");
            }

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
				$_SESSION['Correct'] = "Se ha modificado el albergue con exito";
                return header("location: ".BASE_URL."admin/albergues");
            } 
			$_SESSION['Correct'] = "Se ha modificado el albergue con exito";
            header("location: ".BASE_URL."fundacion/albergues");
        } elseif ($_POST['accion'] == 'Agregar') {

            $igualdad =$objAdmin->ValidarAlbergue($_POST['nombre']);

            if($igualdad){
                $_SESSION['Error'] = "Ya existe un Albergue con ese nombre.";
                if($_SESSION['rol'] == "1"){
                    return header("location: ".BASE_URL."admin/albergues");
                } 
                return header("location: " .BASE_URL."fundacion/albergues");
            }

            $Nombre = $_POST['nombre'];
            $direccion = $_POST['direccion'];
            $cedula = $_POST['cedula_user'];
            $registrando = $objFund->registraAlbergue("albergue",$cedula,$Nombre,$direccion,1);
			if(is_bool($registrando) && $registrando  == false){
				$_SESSION['Error'] = "Ha ocurrido un error al registrar el albergue";
				return header("location: " .BASE_URL."admin/albergues");
			}
			
            if($_SESSION['rol'] == "1"){
				$_SESSION['Correct'] = "Se ha insertado el albergue con exito";
                return header("location: ".BASE_URL."admin/albergues");
            } else {
				$_SESSION['Correct'] = "Se ha insertado el albergue con exito";
                return header("location: ".BASE_URL."fundacion/albergues");
            }
        }
    }
	
	/*****************************************************************
	*	Pertenece: FundacionController
	*	Nombre: registraAnimal
	*	Función: registrar/modificar Animal
	*	Entradas: Nombre, fechanacimiento, raza, albergue
	*	Salidas: ver Animales
	*****************************************************************/
    public function registraAnimal(){//ahora si
		$this->Comprobador();
        $objFund = $this->loadModel("FundacionModel");
        $objAdmin = $this->loadModel("AdminModel");
        if(!isset($_POST['accion'])|| !isset($_POST['nombre']) || !isset($_POST['raza']) || !isset($_POST['descrip'])){
           $Error = "No se enviaron Datos";
		   $_SESSION['Error'] = "No se enviaron Datos";
		   return header("location: ".BASE_URL."fundacion/animales");
		}
		//ps no se q fecha ponerle de limite
		//y tampoco pudo haber nacido un año en el futuro
		//Hacer que la fecha sea entero
		/*Validacion del año de nacimiento del peludo*/
		if ($_POST['fecha'] < 0 || $_POST['fecha'] < 2009 || $_POST['fecha'] > intval(date('Y'))){
			$Error = "Año de Nacimiento Incorrecto";
			$_SESSION['Error'] = "Año de Nacimiento Incorrecto";
			return header("location: ".BASE_URL."fundacion/animales?error=".$Error);
			
		}
		
		if($_POST['nombre'] == "" || $_POST['raza'] == "0" || $_POST['fecha'] == ""){
			$_SESSION['Error'] = "Ha ocurrido un error";
			return header("location: ".BASE_URL."fundacion/animales");
		}
		
        if ($_POST['accion'] == 'Agregar'){

            $igualdad =$objAdmin->ValidarAnimal($_POST['nombre'],$_POST['albergue']);
		
            if($igualdad){
                $_SESSION['Error'] = "Ya existe un Animal con ese nombre en ese albergue.";
                return header("location: " .BASE_URL."fundacion/animales");
            }

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
			$_SESSION['Correct'] = "Se ha insertado el Peludo con exito";
            return header("location: ".BASE_URL."fundacion/animales");
        } elseif ($_POST['accion'] == 'Modificar') {

            $igualdad =$objFund->ValidarModificacionAnimal($_POST['nombre'], $_POST['albergue'], $_POST['id_animal']);
		
            if($igualdad){
                $_SESSION['Error'] = "Ya existe un animal con este nombre en el albergue seleccionado.";
                return header("location: " .BASE_URL."admin/animales");
            }

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
			$_SESSION['Correct'] = "Se ha Modificado al Peludo con exito";
            return header("location: ".BASE_URL."fundacion/animales");
        }
    }
	
	//MODIFICADO 18/11/2022
	/*****************************************************************
	*	Pertenece: FundacionController
	*	Nombre: destinoAdopcion
	*	Función: decide el destino de la adopcion si se completo o cancelo
	*	Entradas: accion, razon, usuario, eleccion
	*	Salidas: Ver adopciones
	*****************************************************************/
    public function destinoAdopcion(){
		$this->Comprobador();
        $objFund = $this->loadModel("FundacionModel");
		
        if(!isset($_GET['accion']) || !isset($_GET['modificacion'])){
			$_SESSION['Error'] = "No se enviaron Parametros";
            return $this->verAdopciones();
        }
		
		if($_GET['accion'] == "" || $_GET['accion'] != "Completada" || $_GET['accion'] != "Cancelada"){
			$_SESSION['Error'] = "No se enviaron los parametros correctos";
            return $this->verAdopciones();
        }
		
        $eleccion = $_GET['modificacion'];
        if($_GET['accion'] == 'Completada'){
            $accion = 3;
            $razon = "Registro Usuario";
        }
        elseif($_GET['accion'] == 'Cancelada'){
            $accion = 2;
            if($_GET['razoncancelado'] != ""){
                $razon = $_GET['razoncancelado'];
            } else {
                $razon = "Registro Usuario";
            }
        }
        $objFund->decisionAdopcion($eleccion, $accion, $razon,$_GET['usuario']);
		$_SESSION['Correct'] = "Se realizo la modificacion con exito";
        return header("location: ".BASE_URL."fundacion/verAdopciones");
    }
	
	/*****************************************************************
	*	Pertenece: FundacionController
	*	Nombre: inactivaPeludos
	*	Función: Desactiva/Activa Visibilidad Animales
	*	Entradas: accion, decision, id animal
	*	Salidas: ver animales
	*****************************************************************/
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
		$_SESSION['Correct'] = "Se realizo la modificacion con exito";
        return header("location: ".BASE_URL."fundacion/animales");
    }
	
	/*****************************************************************
	*	Pertenece: FundacionController
	*	Nombre: inactivaAlbergue
	*	Función: Desactiva/Activa Visibilidad Albergue
	*	Entradas: id albergue, decision, usuario
	*	Salidas: ver albergues
	*****************************************************************/
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
		$_SESSION['Correct'] = "Se realizo la modificacion con exito";
        return header("location: ".BASE_URL."fundacion/albergues");
    }
    #endregion
}
?>