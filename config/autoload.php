<?php
	/*****************************************************************
	*	Nombre: spl_autoload_register
	*	Función: Cargar automaticamente los archivos en config/
	*	Entradas: Nombre de archivo
	*	Salidas: Require archivos en /config
	*****************************************************************/ 
    spl_autoload_register(function($class)
    {
      if(file_exists("config/".$class.".php"))
      {
        require_once("config/".$class.".php");
      }
    });
?>