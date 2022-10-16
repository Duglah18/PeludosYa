<?php 
    //busca el globalizar el $objFudnd
class FundacionController extends GeneralController{
    #Region Views
    public function agregaAlberg(){
        $objFund = $this->loadModel("FundacionModel");
        $data['userfund'] = $objFund->consultaUser();
        $this->loadView("fundacion/agalbergue.phtml","Agregar Albergue",$data);
    }

    public function agregaAnimal(){
        $objFund = $this->loadModel("FundacionModel");
        $data['tipoanimal'] = $objFund->consultaTipoAnimal();
        if(isset($_POST['tipoanimal'])){
            $busqueda_animal= $_POST['tipoanimal'];
        $data['raza'] = $objFund->consultaRazaAnimal($busqueda_animal);
        }
        $data['tamano'] = $objFund->consultaTamanoAnimal();
        $data['albergues'] = $objFund->consultaAlbergue();
        $this->loadView("fundacion/agAnimal.phtml","Agregar Animal",$data);
    }
    #endregion
    #Region Metods/functions
    public function registraFundacion(){//funciona 9/10
        $objFund = $this->loadModel("FundacionModel");
        $Nombre = $_POST['nombre'];
        $direccion = $_POST['direccion'];
        $cedula = $_POST['cedula_user'];
        $objFund->registraAlbergue("albergue",$cedula,$Nombre,$direccion,1);
        $this->agregaAlberg();
    }

    public function registraAnimal(){//ahora si
        $objFund = $this->loadModel("FundacionModel");
        $nombre = $_POST['nombre'];
        $fechanac= $_POST['fecha'];
        /*----------------------Empezamos el tratamiento de img----------------------------*/
        //esto es lo q queria automatizar pq vamos a tener q hacer esto cada q queramos guardar una img
        $fecha_paratmp = new DateTime();
        $imgtxt = (isset($_FILES['img']['name']))?$_FILES['img']['name']:"";
        $nombreArchivo =($imgtxt!="")?$fecha_paratmp->getTimestamp()."_".$_FILES['img']['name']:"imagen.jpg";
        $image= $_FILES['img']['tmp_name'];
        if ($image!=""){
            move_uploaded_file($image,"./img/animales/".$nombreArchivo);
        }
        /*----------------------Terminado el tratamiento de img----------------------------*/
        $descrip= $_POST['descrip'];
        $fecha_ing= "Now()";
        $raza_id= $_POST['raza'];
        $tamanio_id= $_POST['tamano'];
        $albergue_id= $_POST['albergue'];
        $visible = 1;
        $objFund->registraAnimal('animal', $nombre, $fechanac, $nombreArchivo, $descrip, $fecha_ing, $raza_id,$tamanio_id, $albergue_id, $visible);
        $this->agregaAnimal();
    }
    #endregion
}

?>