<?php 

class FundacionModel extends ConexionBD{
    public function registraAlberg($tabla, $nombre, $direcc, $ced_us, $estat){
        $data['nombre'] = $nombre;
        $data['direccion'] = $direcc;
        $data['cedula_usuario'] = $ced_us;
        $data['activo'] = $estat;
        return $this->grabaData($tabla, $data);
    }

    public function consultaUser(){//esto a futuro abra q borrarlo luego esto es para mostrar
        //los usuarios a registrarles los albergues cuando halla sessions se quitara
        $resultados = $this->obtenData("SELECT cedula, rol_id, nombre FROM usuarios WHERE rol_id = 3");
        if ($resultados) {
            return $resultados;
        } else {
            return false;
        }
    }

    public function consultaAlbergue(){
        $resultados = $this->obtenData("SELECT id_albergue, nombre FROM albergue");
        if ($resultados){
            return $resultados;
        } else {
            return false;
        }
    }

    public function consultaTipoAnimal(){
        $resultados = $this->obtenData("SELECT id_tipo, nombre FROM tipo_animal");
        if ($resultados){
            return $resultados;
        } else {
            return false;
        }
    }

    public function consultaRazaAnimal($id_tipo){
        $resultados = $this->obtenData("SELECT id_raza, nombre FROM raza WHERE id_tipo_animal = '$id_tipo'");
        if ($resultados){
            return $resultados;
        } else {
            return false;
        }
    }

    public function consultaTamanoAnimal(){
        $resultados = $this->obtenData("SELECT id_tamanio, nombre FROM tamanio");
        if ($resultados){
            return $resultados;
        } else {
            return false;
        }
    }

    public function registraAlbergue($tabla, $rif, $nombre, $direccion, $estado){
        $data['nombre'] = $nombre;
        $data['direccion'] = $direccion;
        $data['cedula_usuario'] = $rif;
        $data['activo'] = $estado;
        return $this->grabaData($tabla,$data);
    }

    public function registraAnimal($tabla, $nom, $anionac, $nomimg, $descripcion, $fecha_ing, $id_raza, $tamano_id, $albergue, $visible){
        $data['nombre'] = $nom;
        $data['anio_nac'] = $anionac;
        $data['img'] = $nomimg;
        $data['descripcion'] = $descripcion;
        $data['fecha_ingreso'] = $fecha_ing;
        $data['raza_id'] = $id_raza;
        $data['tamanio_id'] = $tamano_id;
        $data['albergue_id'] = $albergue;
        $data['visible'] = $visible;
        return $this->grabaData($tabla, $data);
    }
}
?>