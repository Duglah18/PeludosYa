<?php
//el primer dato de header es para que el load view envie a la vista el titulo en lugar de
//mantener el mismo titulo siempre de Estandar View
function getHeader($titulo, $document) //retorna el head de una vista
{
  $include = "";
  switch($document) {
    case 'headerAdmin'    : $include = "includes/headers/headerAdmin.phtml"; break;
    case 'headerUsuarios' : $include = "includes/headers/headerUsuarios.phtml"; break;
    case 'headerFundacion' : $include = "includes/headers/headerFundacion.phtml"; break;
  }
  require_once($include);
}

function getNav($document)//retorna el nav de una vista
{
  $include = "";
  switch($document) {
    case 'navAdmin' : $include = "includes/navs/navAdmin.phtml"; break;
    case 'navUsuarios': $include = "includes/navs/navUsuarios.phtml"; break;
    case 'navFundacion': $include = "includes/navs/navFundacion.phtml"; break;
  }
  require_once($include);
}

function getFooter($document)//retorna el foot de una vista
{
  $include = "";
  switch($document) {
    case 'footerAdmin' : $include = "includes/footers/footerAdmin.phtml"; break;
    case 'footerUsuarios': $include = "includes/footers/footerUsuarios.phtml"; break;
    case 'footerFundacion': $include = "includes/footers/footerFundacion.phtml"; break;
  }
  require_once($include);
}

?>