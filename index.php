<?php
//Esta es la URL para cuando quieras usar un link para linkear a assets
//para no cambiar muchas lineas de muchos docs solo esto y ya
define("URL_ASSETS", "http://" . $_SERVER['HTTP_HOST'] . "/proyecto_con_isra/PeludosYa/assets/");
//Este es la URL base para los links que no requieran assets.
define("BASE_URL", "http://" . $_SERVER['HTTP_HOST']) . "/mvc/";

$__url = explode("/", $_SERVER['REQUEST_URI']);

/*Este If que yo lo llamo mini controlador es basicamente dependiendo de 
$__url[Este valor] te va a mandar a una pag dependiendo del valor, explicacion
mvc recuerdas q todo se maneja por la url? ps aca la url se trata como un array y 
cuando le mandamos el nombre de el controlador al que nos meteremos a General controller 
lo hacemos por aqui entonces dependiendo de si tienes el proyecto dentro de htdocs/proyecto
ps estos valores no te sirven coloca nada mas el 3 y el 4
si quieres ver la pagina que te mostre pon esto: /index.php/Aboutus/index luego de el nombre
de la carpeta en el navegador*/
if (isset($__url[4 /*aca el 3*/ ]) && isset($__url[5 /*aca el 4*/ ])) {
    $__controlador = ucwords($__url[4 /*aca el 3*/ ]) . "Controller";
    $__metodo = explode("?", $__url[5 /*aca el 4*/ ])[0];
} else {
    $__controlador = "InicioController";
    $__metodo = "index";
}

require_once 'controllers/' . $__controlador . '.php';

$__objControl = new $__controlador();
$__objControl->$__metodo();

/*
  require_once("config/config.php");
  require_once("helpers/helpers.php");
  require_once("libraries/fpdf/fpdf.php");

  $url = !empty($_GET['url']) ? $_GET['url'] : 'home/home';
  $arrUrl = explode("/", $url);
  $controller = $arrUrl[0];
  $method = $arrUrl[0];
  $params = "";

  if (!empty($arrUrl[1]))
  {
    if ($arrUrl[1] != "")
    {
      $method = $arrUrl[1];
    }
  }

  if (!empty($arrUrl[2]))
  {
    if ($arrUrl[2] != "")
    {
      for ($i = 2; $i < count($arrUrl); $i++)
      {
        $params .= $arrUrl[$i] . ",";
      }
      $params = trim($params, ",");
    }
  }

  require_once("libraries/core/autoload.php");
  require_once("libraries/core/load.php");*/