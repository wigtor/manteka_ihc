<?php
class model_usuario extends CI_Model{
   function ValidarUsuario($rut,$password){         //   Consulta Mysql para buscar en la tabla Usuario aquellos usuarios que coincidan con el rut y password ingresados en pantalla de login
      $query = $this->db->where('RUT_USUARIO',$rut);   //   La consulta se efect�a mediante Active Record. Una manera alternativa, y en lenguaje m�s sencillo, de generar las consultas Sql.
      $query = $this->db->where('PASSWORD_PRIMARIA',md5($password));
      $query = $this->db->get('usuario'); //Ac� va el nombre de la tabla
      return $query->row();    //   Devolvemos al controlador la fila que coincide con la b�squeda. (FALSE en caso que no existir coincidencias)
   }
}
?>
