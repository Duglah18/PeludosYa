<?php 
//Conexion de La Base de Datos
class ConexionBD {
	
	//Función de Conexión con la Base de Datos
	/*****************************************************************
	*	Pertenece: Conexion BD
	*	Nombre: conectar
	*	Función: Conexión con la Base de Datos
	*	Entradas: Ninguna
	*	Salidas: Conexion de la Base de Datos correcta o fallida.
	*****************************************************************/
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

	//Función de Consulta a la Base de Datos, para no repetir muchas veces mysqli_query
	/*****************************************************************
	*	Pertenece: Conexion BD
	*	Nombre: obtenData
	*	Función: Consultar a la base de Datos lo indicado por entrada
	*	Entradas: Consulta SQL SELECT String
	*	Salidas: lista solicitada en un arreglo
	*****************************************************************/
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
	
	//Función de Inserción en la Base de Datos, Se forma la instrucción automáticamente.
	/*****************************************************************
	*	Pertenece: Conexion BD
	*	Nombre: grabaData
	*	Función: Insertar en la Base de Datos lo ingresado
	*	Entradas: Tabla a insertar(String), Datos a insertar(Array)
	*	Salidas: Retorna el id ingresado o false
	*****************************************************************/
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

	//Función de Actualización en la Base de Datos, Se forma la instrucción automáticamente.
	/*****************************************************************
	*	Pertenece: Conexion BD
	*	Nombre: actualizaData
	*	Función: Actualiza datos de la Base de Datos por lo ingresado
	*	Entradas: Tabla a actualizar (string), Datos (Array), filtro donde se actualizara (string)
	*	Salidas: verdadero o falso.
	*****************************************************************/
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

	//Función que crea un Query de Inserción para guardar en bitacora.
	/*****************************************************************
	*	Pertenece: Conexion BD
	*	Nombre: creaCadenaInsert
	*	Función: Crear un SQL de Inserción para Bitacora
	*	Entradas: Datos(Array), Tabla(string)
	*	Salidas: consulta Sql formada
	*****************************************************************/
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
                $sql .= "" . str_replace("","&#39;", $data[$columnas[$i]]) . (($i != $contadorData)? ", ": ")");
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

	//Función que crea un Query de Actualización para guardar en bitacora.
	/*****************************************************************
	*	Pertenece: Conexion BD
	*	Nombre: creaCadenaUpdate
	*	Función: Crear un SQL de Actualización para Bitacora
	*	Entradas: Tabla(string), Datos(Array),filtro(string)
	*	Salidas: consulta Sql formada
	*****************************************************************/
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