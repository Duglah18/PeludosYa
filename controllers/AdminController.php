<?php 

class AdminController extends GeneralController{
	/*==========TAREAS PARA FINALIZAR ESTE MODULO==========
	/	-Validaciones Varias
	/	-En la vista de Ver a los animales colocar cantidad de pedidos de adopciones
	==========TAREAS PARA FINALIZAR ESTE MODULO==========*/
	
    #Region Views
	/*****************************************************************
	*	Pertenece: AdminController
	*	Nombre: Comprobador
	*	Función: Comprobar si alguien se encuentra logueado o si tiene el rol requerido
	*	Salidas: Retorno a Pág. Principal.
	*****************************************************************/
    public function Comprobador(){
        if(!isset($_SESSION['usuario']) || $_SESSION['rol'] != "1"){
            $_SESSION['Error'] = "Usted no posee el nivel suficiente para entrar aquí";
			return header("location: ".BASE_URL);
        }
    }

	/*****************************************************************
	*	Pertenece: AdminController
	*	Nombre: index
	*	Función: Mostrar Vista
	*	Salidas: Vista login Admin
	*****************************************************************/
    public function index(){
        if (isset($_SESSION['usuario'])){
            $objAdmin = $this->loadModel("AdminModel");
            $objAdmin->registraCierraSesion($_SESSION['iduser']);
            session_destroy();
            header("refresh: " . 0);
            $this->loadView("admin/admin.phtml","Administrador | Login");
        } else {
        $this->loadView("admin/admin.phtml","Administrador | Login");
        }
    }

	/*****************************************************************
	*	Pertenece: AdminController
	*	Nombre: animales
	*	Función: Mostrar Vista
	*	Salidas: Vista Animales
	*****************************************************************/
    public function animales(){
        $this->Comprobador();
        $objAdmin = $this->loadModel("AdminModel");//probar ya que modifique y ahora tambien existen estos metodos en adminModel
        $pagina = isset($_GET['pagina'])? intval($_GET['pagina']): 1;
        $pagina = $pagina < 0? 1: $pagina;
        $qty = 10;
        $data['pagina'] = $pagina;
        $data['por_pagina'] = $qty;
        $data['totalregistro'] = $objAdmin->TotalConsultaAnimales('');
        $data['animalesAdmin'] = $objAdmin->consultaAnimales('',$pagina,$qty);
        //atras envie nada para que me arroje todo
        $this->loadView("admin/veranimales.phtml","Administrador | Ver Animales",$data);
    }

	/*****************************************************************
	*	Pertenece: AdminController
	*	Nombre: albergues
	*	Función: Mostrar Vista
	*	Salidas: Vista Albergues
	*****************************************************************/
    public function albergues(){
        $this->Comprobador();
        $objAdmin = $this->loadModel("FundacionModel");
        $pagina = isset($_GET['pagina'])? intval($_GET['pagina']): 1;
        $pagina = $pagina < 0? 1: $pagina;
        $qty = 10;
        $data['pagina'] = $pagina;
        $data['por_pagina'] = $qty;
        $data['totalregistro'] = $objAdmin->TotalconsultaAlbergues('');
        $data['alberguesAdmin'] = $objAdmin->consultaAlbergue('', $pagina, $qty);
        $this->loadView("admin/veralbergues.phtml","Administrador | Ver Albergues",$data);
    }
	
	/*****************************************************************
	*	Pertenece: AdminController
	*	Nombre: adopciones
	*	Función: Mostrar Vista
	*	Salidas: Vista adopciones
	*****************************************************************/
    public function adopciones(){
        $this->Comprobador();
        $objAdmin = $this->loadmodel("AdminModel");
		$filtro = isset($_GET ['filtro'])? $_GET['filtro']: "";
		$filtro = $filtro == "0"? "": $filtro;
        $pagina = isset($_GET['pagina'])? intval($_GET['pagina']): 1;
        $pagina = $pagina < 0? 1: $pagina;
        $qty = 10;
		$data['filtro'] = $filtro;
        $data['pagina'] = $pagina;
        $data['por_pagina'] = $qty;
        if (!isset($_POST['AlbergueEsp']) || $_POST['AlbergueEsp'] == "0"){
            $data['totalregistro'] = $objAdmin->TotalconsultaAdopciones('',$filtro);
            $data['adopciones'] = $objAdmin->consultaAdopciones('',$pagina, $qty, $filtro);
            $data['albergues'] = $objAdmin->consultaAlbergues();
            $this->loadView("admin/verAdopciones.phtml","Ver adopciones",$data);
        } elseif(isset($_POST['AlbergueEsp']) && $_POST['AlbergueEsp'] != "0") {
            $data['Busqueda'] = $_POST['AlbergueEsp'];
            $data['totalregistro'] = $objAdmin->TotalconsultaAdopciones($_POST['AlbergueEsp'],$filtro);
            $data['adopciones'] = $objAdmin->consultaAdopciones($_POST['AlbergueEsp'],$pagina, $qty, $filtro);
            $data['albergues'] = $objAdmin->consultaAlbergues();
            $this->loadView("admin/verAdopciones.phtml","Administrador | Ver adopciones",$data);
        }
        
    }

	/*****************************************************************
	*	Pertenece: AdminController
	*	Nombre: agregaAnimales
	*	Función: Mostrar Vista
	*	Entradas: (Modificar): Id de animal y accion = Modificar
	*	Salidas: Vista agrega/modifica Animal
	*****************************************************************/
    public function agregaAnimales(){
        $this->Comprobador();
        $objAdmin = $this->loadModel("AdminModel");
        if (isset($_POST['accion']) && $_POST['accion'] == 'Modificar'){
            $data['raza'] = $objAdmin->consultaRazaAnimal('');
            $data['tipoanimal'] = $objAdmin->consultaTipoAnimal();
            $data['tamano'] = $objAdmin->consultaTamanoAnimal();
            $data['albergues'] = $objAdmin->consultaAlbergues();
            $ammodificar = (isset($_POST['modificacion']))? $_POST['modificacion']: "";
            $data['animales'] = $objAdmin->consultarAnimal($ammodificar);
            $this->loadView("admin/agAnimal.phtml","Administrador | Modifica el Animal", $data);
        }else {
            $data['tipoanimal'] = $objAdmin->consultaTipoAnimal();
            if(isset($_POST['tipoanimal'])){
                $busqueda_animal= $_POST['tipoanimal'];
            $data['raza'] = $objAdmin->consultaRazaAnimal($busqueda_animal);
            }
            $data['tamano'] = $objAdmin->consultaTamanoAnimal();
            $data['albergues'] = $objAdmin->consultaAlbergues();
            $this->loadView("admin/agAnimal.phtml","Administrador | Agregar Animal",$data);
        }
    }
    
    /*****************************************************************
	*	Pertenece: AdminController
	*	Nombre: agregaUsuarios
	*	Función: Mostrar Vista
	*	Entradas: (Modificar): Id de Usuario y accion = Modificar
	*	Salidas: Vista agrega/modifica Usuario
	*****************************************************************/
	public function agregaUsuarios(){
        $this->Comprobador();
        $objAdmin = $this->loadModel("AdminModel");
        if(isset($_POST['accion']) && $_POST['accion'] == 'Modificar'){
            $data['usuario'] = $objAdmin->consultaUsuario($_POST['modificacion']);
            $data['dataRoles'] = $objAdmin->ConsultaRoles();
            $this->loadView("admin/agusaurios.phtml","Administrador | Modifica el usuario", $data);
        } else {
        $data['dataRoles'] = $objAdmin->ConsultaRoles();
        $this->loadView("admin/agusaurios.phtml","Administrador | Agrega usuarios", $data);
        }
    }
	
	/*****************************************************************
	*	Pertenece: AdminController
	*	Nombre: agregaVeterinarios
	*	Función: Mostrar Vista
	*	Entradas: (Modificar): Id de Veterinario, accion = Modificar
	*	Salidas: Vista agrega/modifica Veterinario
	*****************************************************************/
    public function agregaVeterinarios(){
        $this->Comprobador();
        $objAdmin = $this->loadmodel("AdminModel");
        if (isset($_POST['accion']) && $_POST['accion'] == 'Modificar'){
            $pagina = isset($_GET['pagina'])? intval($_GET['pagina']): 1;
            $pagina = $pagina < 0? 1: $pagina;
            $qty = 10;
            $data['pagina'] = $pagina;
            $data['por_pagina'] = $qty;
            $data['totalregistro'] = $objAdmin->TotalVeterinariosConsults();
            $data['Veterinarios'] = $objAdmin->consultarVeterinarios('',$pagina,$qty);
            $data['vtrModificar'] = $objAdmin->consultarVeterinarios($_POST['modificacion'],$pagina,$qty);
            $this->loadView("admin/agVeterinario.phtml", "Administrador | Modifica Veterinario como Admin",$data);
        } else {
            $pagina = isset($_GET['pagina'])? intval($_GET['pagina']): 1;
            $pagina = $pagina < 0? 1: $pagina;
            $qty = 10;
            $data['pagina'] = $pagina;
            $data['por_pagina'] = $qty;
            $data['totalregistro'] = $objAdmin->TotalVeterinariosConsults();
            $data['Veterinarios'] = $objAdmin->consultarVeterinarios('',$pagina,$qty);
            $this->loadView("admin/agVeterinario.phtml", "Administrador | Agrega Veterinarios como Admin",$data);
        }
    }
	
	/*****************************************************************
	*	Pertenece: AdminController
	*	Nombre: agregaAlbergueAdmin
	*	Función: Mostrar Vista
	*	Entradas: (Modifica): id de albergue, accion = Modificar
	*	Salidas: Vista agrega/modifica Albergue 
	*****************************************************************/
    public function agregaAlbergueAdmin(){
        $this->Comprobador();
        //este model es para cargar el select
        $objFund = $this->loadModel("FundacionModel");
        if(isset($_POST['accion']) && $_POST['accion'] == 'Modificar'){
            $data['userfund'] = $objFund->consultaUser();
            $data['albergue'] = $objFund->consultaAlberguePorID($_POST['modificacion']);
            $this->loadView("admin/agalbergue.phtml","Administrador | Modificar Albergue",$data);
        } else {
            $data['userfund'] = $objFund->consultaUser();
            $this->loadView("admin/agalbergue.phtml","Administrador | Agregar Albergue",$data);
        }
    }
	
	/*****************************************************************
	*	Pertenece: AdminController
	*	Nombre: mostrarData
	*	Función: Mostrar Vista
	*	Salidas: Vista Usuarios del sistema
	*****************************************************************/
    public function mostrarData(){
        $this->Comprobador();
        $objAdmin = $this->loadModel("AdminModel");
		$filtro = isset($_GET['filtro'])?$_GET['filtro']: "";
        $pagina = isset($_GET['pagina'])? intval($_GET['pagina']): 1;
        $pagina = $pagina < 0? 1: $pagina;
        $qty = 10;
		$data['filtro'] = $filtro;
        $data['pagina'] = $pagina;
        $data['por_pagina'] = $qty;
        $data['totalregistro'] = $objAdmin->TotalUsuarios($filtro);
        $data['dataAdmin'] = $objAdmin->listar($pagina, $qty, $filtro);
        $this->loadView("admin/adIndex.phtml", "Administrador | Ver Usuarios",$data);
    }

    /*****************************************************************
	*	Pertenece: AdminController
	*	Nombre: tipoAnimal
	*	Función: Mostrar Vista
	*	Entradas: (Modifica): id tipo animal, accion = Modificar
	*	Salidas: Vista Ver/Agrega/Modifica Tipo Animal 
	*****************************************************************/
	public function tipoAnimal(){
        $this->Comprobador();
        $objAdmin = $this->loadModel("AdminModel");
        if (isset($_POST['accion']) && $_POST['accion'] == 'Modificar'){
			$pagina = isset($_GET['pagina'])? intval($_GET['pagina']): 1;
			$pagina = $pagina < 0? 1: $pagina;
			$qty = 10;
			$data['pagina'] = $pagina;
			$data['por_pagina'] = $qty;
			$data['totalregistro'] = $objAdmin->TotallistaTiposAnimal();
            $data['tAnimal'] = $objAdmin->listaTiposAnimal($_POST['modificacion'],$pagina, $qty);
            $data['dataTipos'] = $objAdmin->listaTiposAnimal('',$pagina, $qty);
            return $this->loadView("admin/adTAnimal.phtml", "Administrador | Modifica el Tipo de Animal", $data);
        }
		$pagina = isset($_GET['pagina'])? intval($_GET['pagina']): 1;
        $pagina = $pagina < 0? 1: $pagina;
        $qty = 10;
        $data['pagina'] = $pagina;
        $data['por_pagina'] = $qty;
        $data['totalregistro'] = $objAdmin->TotallistaTiposAnimal();
        $data['dataTipos'] = $objAdmin->listaTiposAnimal('',$pagina, $qty);
        $this->loadView("admin/adTAnimal.phtml", "Administrador | Tipos de Animal", $data);
    }

	/*****************************************************************
	*	Pertenece: AdminController
	*	Nombre: razasAnimal
	*	Función: Mostrar Vista
	*	Entradas: (Modifica): id raza, accion = Modificar
	*	Salidas: Vista Ver/Agrega/Modifica Razas Animal 
	*****************************************************************/
    public function razasAnimal(){
        $this->Comprobador();
        $objAdmin = $this->loadModel("AdminModel");
        $objFund = $this->loadModel("FundacionModel");
        $pagina = isset($_GET['pagina'])? intval($_GET['pagina']): 1;
        $pagina = $pagina < 0? 1: $pagina;
        $qty = 10;
        if (isset($_POST['accion']) && $_POST['accion'] == 'Modificar'){
            $data['buscarazas'] = $objAdmin->listaRazas($_POST['modificacion'], $pagina, $qty);
            $data['pagina'] = $pagina;
            $data['por_pagina'] = $qty;
            $data['totalregistro'] = $objAdmin->TotallistaRazas();
            $data['dataRazas'] = $objAdmin->listaRazas('',$pagina, $qty);
            $data['tiposAnimales'] = $objFund->consultaTipoAnimal();
            return $this->loadView("admin/adRazas.phtml", "Administrador | Modifica la Raza de Animal", $data);
        }
        $data['pagina'] = $pagina;
        $data['por_pagina'] = $qty;
        $data['totalregistro'] = $objAdmin->TotallistaRazas();
        $data['dataRazas'] = $objAdmin->listaRazas('',$pagina, $qty);
        $data['tiposAnimales'] = $objFund->consultaTipoAnimal();
        $this->loadView("admin/adRazas.phtml", "Administrador | Razas de Animal", $data);
    }
	
	/*****************************************************************
	*	Pertenece: AdminController
	*	Nombre: Reportes
	*	Función: Mostrar Vista
	*	Salidas: Vista Cargar Reportes
	*****************************************************************/
	public function Reportes(){
		$this->Comprobador();
		//la verdad hay algunos cmb q podria hacer pero de pana alargaria demasiado los reportes
        /*Selects:
            -Razas
            -Tamaños
            -Albergue
            -Tipoanimal
         */
		$objAdmin = $this->loadModel("AdminModel");
		$objSess = $this->loadModel("SessionModel");
		$objFund = $this->loadModel("FundacionModel");
        /*------Peludos-----*/
        $data['Razas'] =  $objAdmin->consultaRazas();
        $data['tamanos'] = $objAdmin->consultaTamanoAnimal();
        $data['albergues'] = $objAdmin->consultaAlbergues();//id_albergue, nombre
        $data['tiposAni'] = $objAdmin->consultaTipoAnimal();
        /*------Usuarios-----*/
        $data['roles'] = $objAdmin->ConsultaRoles();

        /*------Inicios de sesion-----*/

        /*------Bitacora-----*/
		//Cargar literalmente todos los modelos porque hay selects pero hasta para regalar
		$this->loadView("admin/adReporte.phtml","Administrador | Reportes del Sistema",$data);
	}
    #endregion

	/*****************************************************************
	*	Pertenece: AdminController
	*	Nombre: consultaData
	*	Función: Comprobar el login del Admin
	*	Entradas: Nombre, Contraseña
	*	Salidas: Vista ver Usuarios, Admin logueado
	*****************************************************************/
    public function consultaData(){
        if(!isset($_POST['username']) || !isset($_POST['password'])){
            $error = "No se enviaron datos";
			$_SESSION['Error'] = "Error.";
			header("location: ".BASE_URL);
        }
        $user = $_POST['username'];
        $contra = $_POST['password'];
        $objAdmin = $this->loadModel("AdminModel");
        $dataAdmin = $objAdmin->consultarAdmin($user, $contra);
            if ($dataAdmin == False){
				$_SESSION['Error'] = "Error Usted no es administrador";
                die(header("location: ". BASE_URL));
            }
            //lo mismo de aca abajo hacer en login normal y register
            $_SESSION['usuario'] = $dataAdmin[0]['nombre'];
            $_SESSION['rol'] = $dataAdmin[0]['rol_id'];
            $_SESSION['iduser'] = $dataAdmin[0]['cedula'];
			$_SESSION['Correct'] = "Ha ingresado con exito al sistema";
            header("location: ". BASE_URL. "admin/mostrarData");
    }
	
	/*****************************************************************
	*	Pertenece: AdminController
	*	Nombre: registraUsuario
	*	Función: Registra/Modifica Usuario desde Admin
	*	Entradas: (Modifica): id Usuario, Modificar | (Agregar): Agrega ||= Cedula, nombre, rol, direccion, telefono
	*	Salidas: Vista Ver usuarios
	*****************************************************************/
    public function registraUsuario(){
        $objAdmin = $this->loadModel("AdminModel");
		if(!isset($_POST['rol']) || $_POST['rol'] == "0"){
			//se podrian almacenar en Session y en estandar view se monta eso y que sea una paginita
			$_SESSION['Error'] = "Error no selecciono un Rol adecuado";
			header("location: ".BASE_URL. "admin/agregaUsuarios");
		}
		
		if(!isset($_POST['cedula']) || !isset($_POST['nombre']) || !isset($_POST['direccion']) || !isset($_POST['contrasenia']) ||!isset($_POST['telefono'])){
			$_SESSION['Error'] = "Error no se han enviado datos a ingresar";
			header("location: ".BASE_URL. "admin/agregaUsuarios");
		}
		
		if($_POST['cedula'] == "" || $_POST['nombre'] == "" || $_POST['rol'] == "" || $_POST['direccion'] == "" || $_POST['telefono'] == ""){
			$_SESSION['Error'] = "Error no se han enviado datos a ingresar";
			header("location: ".BASE_URL. "admin/agregaUsuarios");
		}
		
        if (isset($_POST['Agregar'])){
            $cedula = $_POST['cedula'];
            $nombre = $_POST['nombre'];
            $rol = $_POST['rol'];
            $direccion = $_POST['direccion'];
            $contrasenia = $_POST['contrasenia'];
            $tlf = $_POST['telefono'];
        
            $objAdmin->registrarUsuario("usuarios",$cedula,$nombre,$rol,$direccion,
                                        $contrasenia, "1", $tlf, $_SESSION['iduser']);
            if($objAdmin == false){
                $error = "Ha ocurrido un error";
				$_SESSION['Error'] = "Ha ocurrido un Error";
                return header("location: ".BASE_URL. "admin/mostrarData?error=".$error);
            }
            //mientras carga mostrarData agregar una pantalla de carga
			$_SESSION['Correct'] = "Se realizo agrego al usuario con exito";
            return header("location: ".BASE_URL. "admin/mostrarData");//solucion a recargar la pagina !!!!
        } elseif (isset($_POST['Modificar'])){//usa redireccionamiento header
            $cedula = $_POST['cedula'];
            $nombre = $_POST['nombre'];
            $rol = $_POST['rol'];
            $direccion = $_POST['direccion'];
            $contrasenia = $_POST['contrasenia'];
            $activo = $_POST['activo'];
            $tlf = $_POST['telefono'];
            $detalles = $_POST['detalle'];
            $objAdmin->modificaUsuario($cedula,$nombre,$rol,$direccion,$contrasenia,
                                        $activo,$tlf, $detalles,$_SESSION['iduser']);
			$_SESSION['Correct'] = "Se realizo la modificacion del usuario con exito";
            return header("location: ".BASE_URL. "admin/mostrarData");
        }
    }
	
	/*****************************************************************
	*	Pertenece: AdminController
	*	Nombre: agregaTipoanimal
	*	Función: Agrega/Modifica Tipo Animal Admin
	*	Entradas: (Agrega): datos | (Modifica): Id tipo, nombre nuevo
	*	Salidas: Vista tipoAnimal
	*****************************************************************/
    public function agregaTipoanimal(){
        $objAdmin = $this->loadModel("AdminModel");
		if(isset($_POST['nombreTipo']) && $_POST['nombreTipo'] == ""){
			$_SESSION['Error'] = "No ingreso un nombre para el Tipo de Animal";
			return header("location: ".BASE_URL."admin/tipoAnimal");
		}
        if(isset($_POST['accion']) && $_POST['accion'] == 'Modificar'){
            $identificador = $_POST['identificador'];
            $nombre = $_POST['nombreTipo'];
            $objAdmin->modificaTipoAnimal($identificador,$nombre, $_SESSION['iduser']);
            $_POST['accion'] = "";//Esto creo que se puede quitar
			$_SESSION['Correct'] = "Se realizo la modificacion del tipo de peludo con exito";
            return header("location: ".BASE_URL."admin/tipoAnimal");
        } elseif(isset($_POST['accion']) && $_POST['accion'] == 'Agregar') {
            $nombre = $_POST['nombreTipo'];
            $objAdmin->registraTipoAnimal('tipo_animal',$nombre, $_SESSION['iduser']);
			$_SESSION['Correct'] = "Se realizo agrego el tipo de peludo con exito";
            return header("location: ".BASE_URL."admin/tipoAnimal");
        }
		$_SESSION['Error'] = "Ocurrio un Error al intentar agregar la Tipo de Animal";
		return header("location: ".BASE_URL."admin/tipoAnimal");
    }
	
	/*****************************************************************
	*	Pertenece: AdminController
	*	Nombre: agregaRazaAnimal
	*	Función: Agrega/Modifica Razas de animal 
	*	Entradas: (Agrega): Datos animal | (Modifica): Id raza, nuevos datos
	*	Salidas: Vista RazasAnimal
	*****************************************************************/
    public function agregaRazaAnimal(){
        $objAdmin = $this->loadModel("AdminModel");
		if(isset($_POST['nombreRaza']) && $_POST['nombreRaza'] == ""){
			$_SESSION['Error'] = "No ingreso un nombre para la Raza";
			return header("location: ".BASE_URL."admin/razasAnimal");
		}
		if($_POST['tipoAnimal'] == "0"){
			$_SESSION['Error'] = "No selecciono un Tipo de Animal Valido";
			return header("location: ".BASE_URL."admin/razasAnimal");
		}
        if(isset($_POST['accion']) && $_POST['accion'] == 'Modificar'){
            $identificador = $_POST['identificador'];
            $nombre = $_POST['nombreRaza'];
            $TipoAnimal = $_POST['tipoanimal'];
            $objAdmin->modificaRaza($identificador, $nombre, $TipoAnimal, $_SESSION['iduser']);
            $_POST['accion'] = "";
			$_SESSION['Correct'] = "Se realizo la modificacion de la Raza exito";
            return header("location: ".BASE_URL."admin/razasAnimal");
        } elseif(isset($_POST['accion']) && $_POST['accion'] == 'Agregar'){
            $nombre = $_POST['nombreRaza'];
            $TipoAnimal = $_POST['tipoanimal'];
            $objAdmin->registraRazaAnimal('raza', $nombre, $TipoAnimal, $_SESSION['iduser']);
			$_SESSION['Correct'] = "Se realizo agrego la Raza con exito";
			return header("location: ".BASE_URL."admin/razasAnimal");
        }
		//esto es un por si acaso.
		$_SESSION['Error'] = "Ocurrio un Error al intentar agregar la Raza";
		return header("location: ".BASE_URL."admin/razasAnimal");
    }
	
	/*****************************************************************
	*	Pertenece: AdminController
	*	Nombre: agregaAnimal
	*	Función: agrega/modifica Animal Admin
	*	Entradas: (Agrega): Datos Animal | (Modifica): Id, nuevos datos
	*	Salidas: Vista animales
	*****************************************************************/
    public function agregaAnimal(){
		//Hacer una validacion de si existe lo que se va a modificar antes de ingresar y antes de insertar
		//Verificar si existe un registro parecido al ingresado
		//hacer una consulta para ver si la raza existe o no
        $objFund = $this->loadModel("AdminModel");
		if($_POST['raza'] == "0"){
			$Error = "No selecciono una raza valida";//quitar
			$_SESSION['Error'] = "No selecciono una raza valida";
			return header("location: " .BASE_URL."admin/animales?error=".$Error);//quitar el if
		}
		
		if(!isset($_POST['nombre']) || !isset($_POST['fecha'])){
			$_SESSION['Error'] = "Ocurrio un error";
			return header("location: " .BASE_URL."admin/animales");
		}
		
		if($_POST['nombre'] == "" || $_POST['fecha'] == ""){
			$_SESSION['Error'] = "Ocurrio un error";
			return header("location: " .BASE_URL."admin/animales");
		}
		/*Validacion del año de nacimiento del peludo*/
		if (!is_int($_POST['fecha']) || $_POST['fecha'] < 0 || $_POST['fecha'] < 2009 || $_POST['fecha'] > intval(date('Y'))){
			$_SESSION['Error'] = "Año de Nacimiento Incorrecto";
			return header("location: ".BASE_URL."admin/animales");
			
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
                                    $fecha_ing, $raza_id,$tamanio_id, $albergue_id, $visible,
                                    $_SESSION['iduser']);
			$_SESSION['Correct'] = "Se realizo agrego al Peludo con exito";
            return header("location: ".BASE_URL."admin/animales");
        } elseif (isset($_POST['accion']) && $_POST['accion'] == 'Modificar'){
            $id_animal = $_POST['id_animal'];
            $nombre = $_POST['nombre'];
            $fechanac= $_POST['fecha'];
            $img_modificar = $_POST['imgmodificar'];
            /*----------------------Empezamos el tratamiento de img----------------------------*/
            $fecha_paratmp = new DateTime();
            $imgtxt = (isset($_FILES['img']['name']))?$_FILES['img']['name']:"";
            $nombreArchivo =($imgtxt!="")?$fecha_paratmp->getTimestamp()."_".$_FILES['img']['name']:"imagen.jpg";
            $image= $_FILES['img']['tmp_name'];
            move_uploaded_file($image,"./img/animales/".$nombreArchivo);

            $imagenEliminar = $objFund->consultarAnimal($id_animal);
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
            $objFund->modificaAnimal('animal', $id_animal,$nombre, $fechanac, $nombreArchivo, 
                                    $descrip, $raza_id,$tamanio_id, $albergue_id, $visible,
                                    $_SESSION['iduser']);
            $_SESSION['Correct'] = "Se realizo la modificacion del Peludo con exito";
			return header("location: ".BASE_URL."admin/animales");
        }
    }
	
	/*****************************************************************
	*	Pertenece: AdminController
	*	Nombre: registraVeterinario
	*	Función: Agrega/Modifica Veterinario Admin
	*	Entradas: (Agregar): Nombre, telefono, direccion, img | (Modifica): Id, Nuevos Datos
	*	Salidas: Vista Agrega Veterinarios
	*****************************************************************/
    public function registraVeterinario(){
        //creo que esto puede servir
		//Hacer una validacion de si existe lo que se va a modificar antes de ingresar y antes de insertar
		//Verificar si existe un registro parecido al ingresado
		if(!isset($_POST['nombre']) ||!isset($_POST['telefono']) || !isset($_POST['direccion'])){
			$_SESSION['Error'] = "Ocurrio un error al enviar los datos.";
			return header("location: " .BASE_URL. "admin/agregaVeterinarios");
		}
		if($_POST['nombre'] == "" || $_POST['telefono'] == "" || $_POST['direccion'] == ""){
			$_SESSION['Error'] = "Los datos no estan permitidos.";
			return header("location: " .BASE_URL. "admin/agregaVeterinarios");
		}
		
        $objAdmin = $this->loadModel("AdminModel");
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        if (isset($_POST['accion']) && $_POST['accion'] == 'Modificar'){
            $visible = isset($_POST['visible'])?$_POST['visible']:"";
			if($visible == ""){
				$_SESSION['Error'] = "Ocurrio un error";
				return header("location: ".BASE_URL."admin/agregaVeterinarios");
			}
            /*----------------------Tratamiento de Img------------------------------------------*/
            $img_modificar = $_POST['imgmodificar'];

            $id_veterinario = $_POST['vetIdentificador'];
            $fecha_paratmp = new DateTime();
            $imgtxt = (isset($_FILES['img']['name']))? $_FILES['img']['name']:"";
            $nombreArchivo =($imgtxt!="")?$fecha_paratmp->getTimestamp()."_".$_FILES['img']['name']:"imagen.jpg";
            $image = $_FILES['img']['tmp_name'];
            move_uploaded_file($image,"./img/veterinarios/".$nombreArchivo);

            $imagenEliminar = $objAdmin->consultarVeterinarios($id_veterinario);
                if($imagenEliminar[0]['img'] != $nombreArchivo){
                    if ($imagenEliminar[0]["img"]!="imagen.jpg"){//Se cumple?
                        if (file_exists("./img/veterinarios/".$imagenEliminar[0]["img"])) {
                            unlink("./img/veterinarios/".$imagenEliminar[0]["img"]);
                        }
                    }
                } else {
                    $nombreArchivo = $img_modificar;
                }
            /*-----------------------Terminando de Img------------------------------------------*/
            $objAdmin->modificaVeterinario($id_veterinario, $nombre, $telefono, $direccion, 
                                            $nombreArchivo, $visible, $_SESSION['iduser']);
            $_POST['accion'] = "";
			$_SESSION['Correct'] = "Se realizo la modificacion del veterinario con exito";
            return header("location: ".BASE_URL."admin/agregaVeterinarios");
        } elseif(isset($_POST['accion']) && $_POST['accion'] == 'Agregar') {
            if ($nombre != "" && $telefono != "" && $direccion != ""){
                /*----------------------Tratamiento de Img------------------------------------------*/
                $fecha_paratmp = new DateTime();
                $imgtxt = (isset($_FILES['img']['name']))? $_FILES['img']['name']:"";
                $nombreArchivo =($imgtxt!="")?$fecha_paratmp->getTimestamp()."_".$_FILES['img']['name']:"imagen.jpg";
                $image = $_FILES['img']['tmp_name'];
                if($image != ""){
                    move_uploaded_file($image,"./img/veterinarios/".$nombreArchivo);
                }
                /*-----------------------Terminando de Img------------------------------------------*/
                $adminRegistrando = $_POST['admin'];
                $objAdmin->registraVeterinario($nombre,$telefono,$direccion, 
                                                $nombreArchivo, $adminRegistrando);
				$_SESSION['Correct'] = "Se realizo agrego al veterinario con exito";
                return header("location: ".BASE_URL."admin/agregaVeterinarios");
            } else {
				$_SESSION['Error'] = "Ocurrio un error al agregar al Veterinario";
                return header("location: ".BASE_URL."admin/agregaVeterinarios");
                //añadir variable de error por get 
            }
        }
    }

	/*****************************************************************
	*	Pertenece: AdminController
	*	Nombre: inactivaUsuario
	*	Función: Bloquear/Desbloquear Usuario
	*	Entradas: ID usuario, Decision
	*	Salidas: Vista Mostrar Usuarios
	*****************************************************************/
    public function inactivaUsuario(){
        $this->Comprobador();
        $objAdmin = $this->loadModel("AdminModel");
        if(!isset($_POST['accion']) || !isset($_POST['decision']) || !isset($_POST['modificacion'])){
			$_SESSION['Error'] = "Ocurrio un error.";
            return header("location: ".BASE_URL."admin/mostrarData");
        }
        $cedula_user = $_POST['modificacion'];
        if($_POST['accion'] == "Activar"){
            $decision = 1;
        } elseif ($_POST['accion'] == "Inactivar"){
            $decision = 0;
        }

        $objAdmin->DecisionActivacionUsuario($cedula_user, $decision, $_SESSION['iduser']);
		$_SESSION['Correct'] = "Se realizo la modificacion con exito";
        return header("location: ".BASE_URL."admin/mostrarData");
    }

	/*****************************************************************
	*	Pertenece: AdminController
	*	Nombre: inactivaVeterinario
	*	Función: Activa/Desactiva visibilidad para los demas usuarios a veterinario
	*	Entradas: Id, Decision
	*	Salidas: Ver Veterinarios
	*****************************************************************/
    public function inactivaVeterinario(){
        $this->Comprobador();
        $objAdmin = $this->loadModel("AdminModel");
        if(!isset($_POST['accion']) || !isset($_POST['decision']) || !isset($_POST['modificacion'])){
			$_SESSION['Error'] = "Ocurrio un error.";
            return header("location: ".BASE_URL."admin/agregaVeterinarios?error");//Quita este if el de la vista
        }
        $id_veterinario = $_POST['modificacion'];
        if($_POST['accion'] == "Activar"){
            $decision = 1;
        } elseif ($_POST['accion'] == "Inactivar"){
            $decision = 0;
        }

        $objAdmin->DecisionActivacionVeterinario($id_veterinario, $decision, $_SESSION['iduser']);
		$_SESSION['Correct'] = "Se realizo la modificacion con exito";
        return header("location: ".BASE_URL."admin/agregaVeterinarios");
    }
	
	/*****************************************************************
	*	Pertenece: AdminController
	*	Nombre: inactivaPeludos
	*	Función: Activa/Desactiva visibilidad para los demas usuarios a Peludos
	*	Entradas: Id, Decision
	*	Salidas: Ver Animales
	*****************************************************************/
    public function inactivaPeludos(){
        $this->Comprobador();
        $objAdmin = $this->loadModel("AdminModel");
        if(!isset($_POST['accion']) || !isset($_POST['decision']) || !isset($_POST['modificacion'])){
			$_SESSION['Error'] = "Ocurrio un Error.";
            return header("location: ".BASE_URL."admin/animales?error");//ir a la vista y quitar ese if
        }
        $id_peludo = $_POST['modificacion'];
        if($_POST['accion'] == "Activar"){
            $decision = 1;
        } elseif ($_POST['accion'] == "Inactivar"){
            $decision = 0;
        }

        $objAdmin->DecisionActivacionPeludos($id_peludo, $decision, $_SESSION['iduser']);
		$_SESSION['Correct'] = "Se realizo la modificacion con exito";
        return header("location: ".BASE_URL."admin/animales");
    }
	
	/*****************************************************************
	*	Pertenece: AdminController
	*	Nombre: inactivaAlbergue
	*	Función: Activa/Desactiva visibilidad para los demas usuarios albergue
	*	Entradas: Id, Decision
	*	Salidas: Vista Alergues
	*****************************************************************/
    public function inactivaAlbergue(){
        $this->Comprobador();
        $objAdmin = $this->loadModel("AdminModel");
        if(!isset($_POST['accion']) || !isset($_POST['decision']) || !isset($_POST['modificacion'])){
			$_SESSION['Error'] = "Ocurrio un Error.";
            return header("location: ".BASE_URL."admin/albergues?error");//ir a la vista y quitar ese if
        }
        $id_albergue = $_POST['modificacion'];
        if($_POST['accion'] == "Activar"){
            $decision = 1;
        } elseif ($_POST['accion'] == "Inactivar"){
            $decision = 0;
        }

        $objAdmin->DecisionActivacionAlbergues($id_albergue, $decision, $_SESSION['iduser']);
		$_SESSION['Correct'] = "Se realizo la modificacion con exito";
        return header("location: ".BASE_URL."admin/albergues");
    }
}

?>