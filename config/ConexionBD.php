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

    
    // public function grabaBitacora($data){
    //     $columnas = array_keys($data);
    //     $sql = "INSERT INTO bitacoras (usuario_bit, modulo_afectado, accion_realizada, valor_anterior, valor_actual, fecha_accion) ";
    //     $contadorData = count($data) - 1;
    //     for ($i=0; $i < count($data); $i++) { 
    //         if($data[$columnas[$i]] != "Now()"){
    //             $sql .= "'" . str_replace("'","&#39;", $data[$columnas[$i]]) . (($i != $contadorData)? "', ": "')");
    //         /*si quieres que seann en mayusculas rodea $data[$columnas[$i]] 
    //         con strtoupper($data[Scolumnas[$i))]*/
    //         } else {
    //             $sql .= " " . str_replace("","&#39;", $data[$columnas[$i]]) . (($i != $contadorData)? ", ": ")");
    //         }
    //         //Se agrego este if si estas escribiendo Now() para registrar la fecha en la q ingresas esto
    //         //si es now no se pondra entre comillas pq es un comando para agarrar la fecha
    //     }
    //     $conn = $this->conectar();
    //     $resultado = mysqli_query($conn,$sql) or die ("Error");
    //     if ($resultado){
    //         return mysqli_insert_id($conn);
    //     }
    //     return false;
    // }

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
            $sql .= strval($columnas[$i] . "=" . $data[$columnas[$i]] . (($i != $contadorColumnas)? ", ": ""));
        }//puede q lo convierta de entero a string y por eso salen esos numeros creos
        $sql .= " WHERE " . $filtro;
        return $sql;
    }
}