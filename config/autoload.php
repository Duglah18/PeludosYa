<?php 
    spl_autoload_register(function($class)
    {
      if(file_exists("config/".$class.".php"))
      {
        require_once("config/".$class.".php");
      }
    });

?>