<?php
class model_secciones extends CI_Model{


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

 
}
?>