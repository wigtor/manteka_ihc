<?php
class model_correo extends CI_Model{

  /*public function VerCorreosUser($variable){
    $sql="SELECT * FROM ESTUDIANTE WHERE rut_estudiante = '$variable'" ; //código MySQL
    $datos=mysql_query($sql); //enviar código MySQL
    $contador = 0;
    $lista;
    while ($row=mysql_fetch_array($datos)) { //Bucle para ver todos los registros
      $lista[$contador][0] = $row['RUT_ESTUDIANTE'];
      $lista[$contador][1] = $row['NOMBRE1_ESTUDIANTE'];
      $lista[$contador][2] = $row['APELLIDO_PATERNO'];
      $lista[$contador][3] = $row['APELLIDO_MATERNO'];         
      $contador = $contador + 1;
    }

    if($contador==0){
      $lista[$contador][0] = '';
      $lista[$contador][1] = '';
      $lista[$contador][2] = '';
      $lista[$contador][3] = '';     
    }
       
    return $lista;      
  }*/

  public function VerCorreosUser($variable){
    $sql="SELECT * FROM CARTA WHERE rut_usuario3 = '$variable'" ; //código MySQL
    $datos=mysql_query($sql); //enviar código MySQL
    $contador = 0;
    $lista;
    while ($row=mysql_fetch_array($datos)) { //Bucle para ver todos los registros
      $lista[$contador][0] = $row['RUT_USUARIO3'];        //Emisor
      $lista[$contador][1] = $row['ASUNTO'];              //Asunto
      $lista[$contador][2] = $row['CUERPO_EMAIL'];         //Cuerpo
      $lista[$contador][3] = $row['FECHA'];               //Fecha
      $lista[$contador][4] = $row['HORA'];                //Hora
      $contador = $contador + 1;
    }

    if($contador==0){
      $lista[$contador][0] = '';
      $lista[$contador][1] = '';
      $lista[$contador][2] = '';
      $lista[$contador][3] = '';   
      $lista[$contador][4] = '';     
    }
       
    return $lista;      
  }

  public function EliminarCorreo($rut_estudiante){
    $sql="DELETE FROM ESTUDIANTE WHERE rut_estudiante = '$rut_estudiante' "; //código MySQL
    $datos=mysql_query($sql); //enviar código MySQL
  }
  public function InsertarCorreo($asunto,$mensaje,$rut,$tipo){

        $this->rut_usuario3 =$rut;
        $this->asunto = $asunto;
        $this->cuerpo_email = $mensaje;
        $this->cod_correo = date("mdHis");

        $this->hora = date("H:i:s");
        $this->fecha = date("Y-m-d");

        // inserta los campos guardados en la tabla carta
        $this->db->insert('CARTA', $this);
    }
}
?>


