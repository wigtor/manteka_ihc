<?php
class model_profesor extends CI_Model{
	function __construct()
    {
        parent::__construct();
    }
	
	//Función get que obtiene profesores, si se le da un argumento obtiene cantidad de profesores
	/*$this->db->select('*');
	$this->db->from('blogs');
	$this->db->join('comments', 'comments.id = blogs.id');
	$query = $this->db->get();
	$data = $this->db->query("SELECT *	FROM profesor"); // the entries for the relevant month and year
	    return $data->result_array();
	*/
	function ValidarUsuario($rut,$password){         //   Consulta Mysql para buscar en la tabla Usuario aquellos usuarios que coincidan con el rut y password ingresados en pantalla de login
      $query = $this->db->where('RUT_USUARIO',$rut);   //   La consulta se efectúa mediante Active Record. Una manera alternativa, y en lenguaje más sencillo, de generar las consultas Sql.
      $query = $this->db->where('PASSWORD',md5($password));
      $query = $this->db->get('usuario'); //Acá va el nombre de la tabla
      return $query->row();    //   Devolvemos al controlador la fila que coincide con la búsqueda. (FALSE en caso que no existir coincidencias)
   }
}
?>
