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
    $rutdestino = '';
    $lista;
    while ($row=mysql_fetch_array($datos)) { //Bucle para ver todos los registros
      $lista[$contador][0] = $row['COD_CORREO'];        //Emisor
      $lista[$contador][1] = $row['RUT_USUARIO3'];              //Asunto
      $lista[$contador][2] = $row['HORA'];               //Fecha
      $lista[$contador][3] = $row['FECHA'];                //Hora
      //$lista[$contador][4] = $row['CUERPO_EMAIL'];                //Hora
      $lista[$contador][4] = $row['ASUNTO'];                //Hora

      $codigo = $row['COD_CORREO'];      
      
      $sql1="SELECT * FROM `carta_estudiante` WHERE COD_CORREO='$codigo'" ; //código MySQL
      $datos1=mysql_query($sql1); //enviar código MySQL
      $i=0; 
      while($row=mysql_fetch_array($datos1)){
        $rutdestino[$i] = $row['RUT_ESTUDIANTE'];
        $i++;  
      }

      $lista[$contador][5]=$row['RUT_ESTUDIANTE'];

      /*$sql11="SELECT * FROM `estudiante` WHERE RUT_ESTUDIANTE='$rutestd'" ; //código MySQL
      $datos11=mysql_query($sql11);
      if($row=mysql_fetch_array($datos11)){
        $lista[$contador][5] = $row['NOMBRE1_ESTUDIANTE'];
        $lista[$contador][6] = $row['APELLIDO_PATERNO'];
      }*/
      $contador = $contador + 1;
    }

    if($contador==0){
      $lista[$contador][0] = '';
      $lista[$contador][1] = '';
      $lista[$contador][2] = '';
      $lista[$contador][3] = '';   
      $lista[$contador][4] = '';
      $lista[$contador][5] = '';   
      //$lista[$contador][6] = '';  
    }
       
    return $lista;      
  }

  public function EliminarCorreoEst($correo){
    $sql="DELETE FROM 'CARTA_ESTUDIANTE' WHERE COD_CORREO = '$correo' "; //código MySQL
    $datos=mysql_query($sql); //enviar código MySQL
  }

  public function EliminarCorreo($correo){
    $sql="DELETE FROM 'CARTA_' WHERE COD_CORREO = '$correo' "; //código MySQL
    $datos=mysql_query($sql); //enviar código MySQL

  }

  public function InsertarCorreo($asunto,$mensaje,$rut,$tipo,$date){



        $this->rut_usuario3 =$rut;
        $this->asunto = $asunto;
        $this->cuerpo_email = $mensaje;
        $this->cod_correo = $date;

        $this->hora = date("H:i:s");
        $this->fecha = date("Y-m-d");

        // inserta los campos guardados en la tabla carta
        $this->db->insert('CARTA', $this);
    }
}
?>


