<?php 
/*Controlador general de las vistas*/
class GeneralController {
    
    public function loadModel($nombremodelo){//carga el modelo colocando el nombre del modelo 
        require_once 'models/' . $nombremodelo . '.php';
        return new $nombremodelo();
    }
    //carga las vistas colocando la vista que quieres ver para ejemplos ve a MenuController
    //de igual forma puedes colocarle el titulo si quieres a la pagina que vas a ver y de paso
    //pasar parametros facilmente alli si te recomiendo ver los videos que yo vi para hacer esto.
    public function loadView($vista, $titulo, $parametros = array()){
        foreach (array_keys($parametros) as $key) {
            $$key = $parametros[$key];
        }
        require_once 'views/EstandarView.phtml';
    }
    //funcion que regresa la consulta insert?
    //esto ya no es necesario aqui es necesario es en conexion
    public function creaCadenaInsert($data, $tabla){
        $columnas = array_keys($data);
        $sql = "INSERT INTO " . $tabla . "(";
        $contadorColumnas = count($columnas) - 1;
        for ($i=0; $i < count($columnas) ; $i++) { 

            $sql .=  $columnas[$i] . (($i != $contadorColumnas)?", ": ") VALUES ( ");
        }
        $contadorData = count($data) - 1;
        for ($i=0; $i < count($data); $i++) { 
            if($data[$columnas[$i]] != "Now()"){
                $sql .= "'" . str_replace("'","&#39;", $data[$columnas[$i]]) . (($i != $contadorData)? "', ": "')");
            /*si quieres que seann en mayusculas rodea $data[$columnas[$i]] 
            con strtoupper($data[Scolumnas[$i))]*/
            } else {
                $sql .= " " . str_replace("","&#39;", $data[$columnas[$i]]) . (($i != $contadorData)? ", ": ")");
            }
            //Se agrego este if si estas escribiendo Now() para registrar la fecha en la q ingresas esto
            //si es now no se pondra entre comillas pq es un comando para agarrar la fecha
        }
        return $sql;
    }

    public function creaCadenaUpdate($tabla, $data, $filtro){
        $columnas = array_keys($data);
        $sql = "UPDATE ". $tabla . " SET ";
        $contadorColumnas = count($columnas) - 1;
        for ($i=0; $i < count($columnas); $i++) { 
            $sql .= $columnas[$i] . "='" . htmlentities($data[$columnas[$i]], ENT_QUOTES, 'UTF-8') . (($i != $contadorColumnas)? "',": "'");
        }
        $sql .= " WHERE " . $filtro;
        return $sql;
    }
    /*Podrias crear un controlador aca que aga el agregar a la BD a bitacora recibiendo lo q ingresas y ya */
}
/*
            $sentenciaSQL = $conexion->prepare("INSERT INTO libros (nombre,imagen,descripcion,precio) VALUES (:nombre,:imagen,:descrip,:precio)");
            $sentenciaSQL->bindParam(':nombre',$Nametxt);
            $sentenciaSQL->bindParam(':descrip',$Textxt);
            $sentenciaSQL->bindParam(':precio',$Pricetxt);

            $fecha= new DateTime();
            $nombreArchivo=($Imgtxt!="")?$fecha->getTimestamp()."_".$_FILES["textimg"]["name"]:"imagen.jpg";

            $tmpimg= $_FILES["textimg"]["tmp_name"];

            if ($tmpimg!="") {
                move_uploaded_file($tmpimg,"../../img/".$nombreArchivo);
            }

            $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
            $sentenciaSQL->execute();

            header("location:productos.php");*/ 

    /*======================================================================================================
    PARA NUEVO GRABA DATA, CONSULTA DATA, ELIMINA DATA Y ACTUALIZA DATA POR IMGS
        ADAPTAR LO SIGUIENTE:  
        esto es una condicional para entender si enviar o no q cosa te llega
        IMPORTANTE
    $Imgtxt = (isset($_FILES['textimg']['name']))?$_FILES['textimg']['name']:"";
    y colocar el form donde enviara la img enctype="multipart/form-data"

    AGREGA (INSERT):
     case "agregar":

            $sentenciaSQL = $conexion->prepare("INSERT INTO libros (nombre,imagen,descripcion,precio) VALUES (:nombre,:imagen,:descrip,:precio)");
            $sentenciaSQL->bindParam(':nombre',$Nametxt);
            $sentenciaSQL->bindParam(':descrip',$Textxt);
            $sentenciaSQL->bindParam(':precio',$Pricetxt);

            $fecha= new DateTime();
            $nombreArchivo=($Imgtxt!="")?$fecha->getTimestamp()."_".$_FILES["textimg"]["name"]:"imagen.jpg";

            $tmpimg= $_FILES["textimg"]["tmp_name"];

            if ($tmpimg!="") {
                move_uploaded_file($tmpimg,"../../img/".$nombreArchivo);
            }

            $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
            $sentenciaSQL->execute();

            header("location:productos.php");
            break;
    MODIFICA (UPDATE):
    case "modificar":
            //echo "presionaste modificar";
            $sentenciaSQL = $conexion->prepare("UPDATE libros SET nombre=:nombre, descripcion=:descrip, precio=:precio WHERE id=:id");
            $sentenciaSQL->bindParam(':nombre',$Nametxt);
            $sentenciaSQL->bindParam(':descrip',$Textxt);
            $sentenciaSQL->bindParam(':precio',$Pricetxt);
            $sentenciaSQL->bindParam(':id',$IDtxt);
            $sentenciaSQL->execute();

            if ($Imgtxt!="") {

                $fecha= new DateTime();
                $nombreArchivo=($Imgtxt!="")?$fecha->getTimestamp()."_".$_FILES["textimg"]["name"]:"imagen.jpg";
                $tmpimg= $_FILES["textimg"]["tmp_name"];

                move_uploaded_file($tmpimg,"../../img/".$nombreArchivo);

                $sentenciaSQL = $conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
                $sentenciaSQL->bindParam(':id',$IDtxt);
                $sentenciaSQL->execute();
                $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

                if (isset($libro["imagen"]) && ($libro["imagen"]!="imagen.jpg") ) {
                    if (file_exists("../../img/".$libro["imagen"])) {
                        unlink("../../img/".$libro["imagen"]);
                    }
                }

                $sentenciaSQL = $conexion->prepare("UPDATE libros SET imagen=:imagen WHERE id=:id");
                $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
                $sentenciaSQL->bindParam(':id',$IDtxt);
                $sentenciaSQL->execute();        
            }
            header("location:productos.php");
            break;
    ELIMINA (DELETE):
    case "Borrar":
            $sentenciaSQL = $conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
            $sentenciaSQL->bindParam(':id',$IDtxt);
            $sentenciaSQL->execute();
            $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

            if (isset($libro["imagen"]) && ($libro["imagen"]!="imagen.jpg") ) {
                if (file_exists("../../img/".$libro["imagen"])) {
                    unlink("../../img/".$libro["imagen"]);
                }
            }

            $sentenciaSQL = $conexion->prepare("DELETE FROM libros WHERE id=:id");
            $sentenciaSQL->bindParam(':id',$IDtxt);
            $sentenciaSQL->execute();
            header("location:productos.php");
            break;
*/