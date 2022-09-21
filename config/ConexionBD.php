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
        $data['estado'] = 1;
        $columnas = array_keys($data);
        $sql = "INSERT INTO " . $tabla . "(";
        for ($i=0; $i < count($columnas) ; $i++) { 
            $sql .= $columnas[$i] . ",";
        }
        $sql .= "fechacreacion) ";
        $sql .= "VALUES (";
        for ($i=0; $i < count($data); $i++) { 
            $sql .= "'" . str_replace("'","&#39;", $data[$columnas[$i]]) . "',";
            /*si quieres que seann en mayusculas rodea $data[$columnas[$i]] 
            con strtoupper($data[Scolumnas[$i))]*/
        }
        $sql .= "Now())";
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
        for ($i=0; $i < count($columnas); $i++) { 
            $sql .= $columnas[$i] . "='" . htmlentities($data[$columnas[$i]], ENT_QUOTES, 'UTF-8') . "',";
        }
        $sql .= "fechamodificacion=Now()";
        $sql .= " WHERE " . $filtro;
        $conn = $this->conectar();
    $resultado = mysqli_query($conn,$sql) or die("Error"/*mysql_error()*/);
        if ($resultado) {
            return true;
        }
        return false;
    }

}