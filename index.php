<?php
session_start();
include_once("helpers/helpers.php");

require_once "config/autoload.php";

define("URL_ASSETS", "http://" . $_SERVER['HTTP_HOST'] . "/proyecto_con_isra/PeludosYa/assets");
//Este es la URL base para los links que no requieran assets.
define("URL_BASE", "http://" . $_SERVER['HTTP_HOST'] . "/proyecto_con_isra/PeludosYa/");
define("BASE_URL", "http://" . $_SERVER['HTTP_HOST'] . "/proyecto_con_isra/PeludosYa/index.php/");

$__url = explode("/", $_SERVER['REQUEST_URI']);

if (isset($__url[4 /*aca el 3*/ ]) && isset($__url[5 /*aca el 4*/ ])) {
    $__controlador = ucwords($__url[4 /*aca el 3*/ ]) . "Controller";
    $__metodo = explode("?", $__url[5 /*aca el 4*/ ])[0];
} else {
    $__controlador = "HomeController";
    $__metodo = "home";
}

require_once 'controllers/' . $__controlador . '.php';

if(!method_exists($__controlador,$__metodo)){//si el metodo no existe se redirige al inicio
  $__controlador = "HomeController";
  $__metodo = "home";
}

require_once 'controllers/' . $__controlador . '.php';
$__objControl = new $__controlador();
$__objControl->$__metodo();