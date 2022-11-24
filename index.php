<?php
//Se inicia Sesion Ya que siempre pasaremos por Index.php
session_start();

//Autoload de las clases y Funcionalidad de Reportes.
require_once "includes/Multicells.php";
require_once "config/autoload.php";
require_once "helpers/helpers.php";

/*----Url para el manejo de direcciones en la Página----*/
//URL para buscar los assets del proyecto para las vistas
define("URL_ASSETS", "http://" . $_SERVER['HTTP_HOST'] . "/proyecto_con_isra/PeludosYa/assets");
//URL para utilizar para buscar archivos especificos en el proyecto ej. Imagenes
define("URL_BASE", "http://" . $_SERVER['HTTP_HOST'] . "/proyecto_con_isra/PeludosYa/");
//URL para entrar en metodos y clases del proyecto
define("BASE_URL", "http://" . $_SERVER['HTTP_HOST'] . "/proyecto_con_isra/PeludosYa/index.php/");

//Se busca la URL y la dividimos
$__url = explode("/", $_SERVER['REQUEST_URI']);

//Tomamos el array de la Url y si verificamos que exista una clase y controllador correspondientes a lo indicado
if (isset($__url[4 /*aca el 3*/ ]) && isset($__url[5 /*aca el 4*/ ])) {
    $__controlador = ucwords($__url[4 /*aca el 3*/ ]) . "Controller";
    $__metodo = explode("?", $__url[5 /*aca el 4*/ ])[0];
} else { 
	//Si no se envia ningun controlador o clase se buscara por defecto Home
    $__controlador = "HomeController";
    $__metodo = "home";
}

//Tomamos los Controladores
require_once 'controllers/' . $__controlador . '.php';

//Si el metodo no existe se redirige al inicio
if(!method_exists($__controlador,$__metodo)){
  $__controlador = "HomeController";
  $__metodo = "home";
}

//Si existe todo y esta Correcto se busca y abre el controlador y metodos indicados
require_once 'controllers/' . $__controlador . '.php';
//Se crea el objeto para usar en el proyecto
$__objControl = new $__controlador();
$__objControl->$__metodo();