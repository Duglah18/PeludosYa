<?php
//el primer dato de header es para que el load view envie a la vista el titulo en lugar de
//mantener el mismo titulo siempre de Estandar View
function getHeader($titulo, $document) //retorna el head de una vista
{
  $include = "";
  switch($document) {
    case 'header'    : $include = "includes/headers/header.phtml"; break;
  }
  require_once($include);
}

function getNav($document)//retorna el nav de una vista
{
  $include = "";
  switch($document) {
    case 'nav' : $include = "includes/navs/nav.phtml"; break;
  }
  require_once($include);
}

function getFooter($document)//retorna el foot de una vista
{
  $include = "";
  switch($document) {
    case 'footer' : $include = "includes/footers/footer.phtml"; break;
  }
  require_once($include);
}

?>