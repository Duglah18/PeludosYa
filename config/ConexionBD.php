<?php 

class ConexionBD {

    public function conectar(){
        $__server = "localhost";
        $__user = "root";
        $__pass = "";
        $__db = "peludosya";
        $__conex = mysqli_connect($__server, $__user, $__pass, $__db);
        if (!$__conex){
            die("Conection Failed: " . mysqli_connect_error());
        }
        return $__conex;
    }

    public function obtenData($consult){
        $__conn = $this->conectar();
        $__respuesta = mysqli_query($__conn, $consult) or die ("error");
        $__data = array();
        if ($__respuesta) {
            $resultado = mysqli_num_rows($__respuesta);
            for ($i=0; $i < $resultado; $i++) { 
                $__data[] = mysqli_fetch_array($__respuesta);
            }
        }
        return $__data;
    }

    public function grabaData($tabla,$data){
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
        $conn = $this->conectar();
        $resultado = mysqli_query($conn,$sql) or die ("Error");
        if ($resultado){
            return mysqli_insert_id($conn);
        }
        return false;
    }

    public function actualizaData($tabla, $data, $filtro){
        $columnas = array_keys($data);
        $sql = "UPDATE ". $tabla . " SET ";
        $contadorColumnas = count($columnas) - 1;
        for ($i=0; $i < count($columnas); $i++) { 
            $sql .= $columnas[$i] . "='" . htmlentities($data[$columnas[$i]], ENT_QUOTES, 'UTF-8') . (($i != $contadorColumnas)? "',": "'");
        }
        $sql .= " WHERE " . $filtro;
        $conn = $this->conectar();
        $resultado = mysqli_query($conn,$sql) or die("Error");
        if ($resultado) {
            return true;
        }
        return false;
    }

    /* ===================
        A futuro Crear:
        -Nuevo Grabadata para aquellas tablas q tienen imagenes ya que
         se le tiene que agregar un paso mas para guardar la imagen
        -Con lo anterior tener en mente de crear otro ActualizaData
         Para las imagenes igual
    /  ===================*/

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

}