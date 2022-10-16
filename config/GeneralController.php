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
        require_once 'views/EstanadarView.phtml';
    }

    // public function imgs($procedimiento, $img = SQLT_BLOB, $imgname, $direcc){//total no se pudo
    //     $nomimgs = (isset($imgname))? $imgname:"";
    //     $tmpimg = $img['tmp_name'];
    //     $fecha = new datetime();
    //     $nombreArchivo=($nomimgs!="")?$fecha->getTimestamp()."_".$img['name']:"imagen.jpg";
    //     if ($tmpimg!=""){
    //         move_uploaded_file($tmpimg, "../img/" . $direcc . $nombreArchivo);
    //     }
    //     // switch ($procedimiento){
    //     //     case "insertar":
    //     //         break;
    //     //     case "actualizar":
    //     //         break;
    //     // }
    //     echo $nombreArchivo;
    //     return $nomimgs;
    // }
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