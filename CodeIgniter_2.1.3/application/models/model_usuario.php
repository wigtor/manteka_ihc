<?php
class model_usuario extends CI_Model{
   function ValidarUsuario($rut,$password){         //   Consulta Mysql para buscar en la tabla Usuario aquellos usuarios que coincidan con el rut y password ingresados en pantalla de login
      $query = $this->db->where('RUT_USUARIO',$rut);   //   La consulta se efect?a mediante Active Record. Una manera alternativa, y en lenguaje m?s sencillo, de generar las consultas Sql.
      $query = $this->db->where('PASSWORD_PRIMARIA',md5($password));
      //FALTA HACER QUE VALIDE USANDO LA PASSWORD TEMPORAL

      $query = $this->db->get('usuario'); //Acá va el nombre de la tabla
      $res = $query->row();
      if ($res) {
         return $res; // Devolvemos al controlador la fila que coincide con la b?squeda. (FALSE en caso que no existir coincidencias)
      }
      else { //Si no validó usando la password primaria, uso la password secundaria
         $this->db->stop_cache();
         $this->db->flush_cache();
         $this->db->stop_cache();
         $query = $this->db->where('RUT_USUARIO',$rut);
         $query = $this->db->where('PASSWORD_TEMPORAL',md5($password));
         $query = $this->db->where('VALIDEZ', date('Y-m-d'));
         $query = $this->db->get('usuario');
         return $query->row();
      }
   }
   
   function cambiarContrasegna($rut,$password_nva){
      $query = $this->db->where('RUT_USUARIO',$rut);   //   La consulta se efect?a mediante Active Record. Una manera alternativa, y en lenguaje m?s sencillo, de generar las consultas Sql.
      $query = $this->db->update('usuario', array('PASSWORD_PRIMARIA'=>$password_nva)); //Ac? va el nombre de la tabla
      return TRUE;
   }

   function setPassSecundaria($email, $new_pass_temp, $date_valid) {
      $query = $this->db->where('CORREO1_USER', $email);
      $query = $this->db->or_where('CORREO2_USER', $email);
      $this->db->set('VALIDEZ', $date_valid);
      $this->db->set('PASSWORD_TEMPORAL', md5($new_pass_temp));
      $this->db->update('usuario');
      //$query = "UPDATE usuario SET PASSWORD_TEMPORAL='".$new_pass_temp."', VALIDEZ='".$date_valid."' WHERE CORREO1_USER='".$email."' OR CORREO2_USER='".$email.'";
      if ($this->db->affected_rows() > 0) {
         return TRUE;
      }
      return FALSE;
   }

   function existe_mail($email) {
      $query = $this->db->where('CORREO1_USER', $email);
      $query = $this->db->or_where('CORREO2_USER', $email);
      $query =$this->db->get('usuario');
      return $query->row();
   }
}
?>
