<?php
class model_secciones extends CI_Model{
  /* function ValidarUsuario($rut,$password){         //   Consulta Mysql para buscar en la tabla Usuario aquellos usuarios que coincidan con el rut y password ingresados en pantalla de login
      $query = $this->db->where('RUT_USUARIO',$rut);   //   La consulta se efectúa mediante Active Record. Una manera alternativa, y en lenguaje más sencillo, de generar las consultas Sql.
      $query = $this->db->where('PASSWORD',md5($password));
      $query = $this->db->get('usuario'); //Acá va el nombre de la tabla
      return $query->row();    //   Devolvemos al controlador la fila que coincide con la búsqueda. (FALSE en caso que no existir coincidencias)
   }*/

   	function ObtenerTodasSecciones(){
   		/* SUMARIO DE LA FUNCIÓN:
   			La función simplemente obtiene desde la base de datos
   			todos los códigos de sección disponibles en el
   			sistema.

   			El resultado es entregado al controlador en forma de
   			array de cadenas, por tanto éste debe utilizar
   			un ciclo que le permita recorrer el array para
   			poder listar las secciones.
   		*/
   		$query = $this->db->get('seccion');
   		$ObjetoListaResultados = $query->result();
   		$StringResultados = array();
   		$contador = 0;
   		foreach ($ObjetoListaResultados as $row) {
   			$StringResultados[$contador] = $row->COD_SECCION;
            $contador++;
   		}
   		return $StringResultados;
   	}

   	/*function BuscarSeccion($seccion_buscada){

   	}*/
}
?>