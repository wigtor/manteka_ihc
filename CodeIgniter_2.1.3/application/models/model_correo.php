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
      $lista[$contador][0] = $row['rut_usuario3'];        //Emisor
      $lista[$contador][1] = $row['asunto'];              //Asunto
      $lista[$contador][2] = $row['cuerpo_mail'];         //Cuerpo
      $lista[$contador][3] = $row['fecha'];               //Fecha
      $lista[$contador][4] = $row['hora'];                //Hora
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
}
?>


