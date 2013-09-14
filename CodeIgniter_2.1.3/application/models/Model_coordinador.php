<?php
/**
* Este Archivo corresponde al modelo de la tabla coordinadores segun MVC en el proyecto Manteka.
*
* @package    Manteka
* @subpackage Models
* @author     Grupo 2 IHC 1-2013 Usach
*/


/**
* Clase model_coordinadores del proyecto manteka.
*
* En esta clase se detallan los metodos de el modelo necesarios para las operaciones crud de la tabla coordinadores.
*
* @package    Manteka
* @subpackage Models
* @author     Grupo 2 IHC 1-2013 Usach
*/
class Model_coordinador extends CI_Model {

	/**
	* Obtiene una lista con todos los coordinadores y su informacion de usuario.
	*
	* Obtiene una listac con todos los coordinadores uniendo su informacion con la presente en la tabla usuarios.
	*
	* @param none
	* @return array $datos  datos de los coordinadores
	*/
	function getAllCoordinadores() {
		/* SUMARIO DE LA FUNCIÓN:
		La función simplemente obtiene desde la base de datos
		todos las coordinaciones disponibles en el
		sistema.

		El resultado es entregado al controlador en forma de
		array de objetos, por tanto éste debe recorrer el
		array y transformar los objetos en filas para
		obtener la información correspondiente.
		*/
		$this->db->select('usuario.RUT_USUARIO AS id');
		$this->db->select('usuario.RUT_USUARIO AS rut');
		$this->db->select('NOMBRE1 AS nombre1');
		$this->db->select('NOMBRE1 AS nombre2');
		$this->db->select('APELLIDO1 AS apellido1');
		$this->db->select('APELLIDO2 AS apellido2');
		$this->db->select('TELEFONO AS fono');
		$this->db->select('CORREO1_USER AS email1');
		$this->db->select('CORREO2_USER AS email2');
		$this->db->join('usuario', 'coordinador.RUT_USUARIO = usuario.RUT_USUARIO');
		$query = $this->db->get('coordinador');
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}


	/**
	* Elimina un coordinador segun su rut.
	*
	* Funciòn que elimina un Coordinador con el rut como valor de entrada.
	*
	* @param string $rut rut segun el cual se buscará el coordinador para eliminar
	* @return none
	*/	
	function eliminarCoordinador($rut) {
		$this->db->where('RUT_USUARIO', $rut);
		$this->db->where('ID_TIPO', TIPO_USR_COORDINADOR);

		$this->db->trans_start();
		$res = $this->db->delete('usuario');
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE) {
			return FALSE;
		}
		else{
			return TRUE;
		}
	}


	/**
	* Modifica la password de un coordinador.
	*
	* Funciòn modifica la password de un cordinador, primero encuentra el coordinador luego
	* codifica la password con md5 y finalmente inserta lo obtenido a la tabla usuario
	*
	* @param string $id rut del coordinador al cual se le modificará el rut.
	* @param string $pass password nueva que desea utilizar.
	* @return none
	*/
	function modificarPassword($id, $pass) {
		$this->db->where('RUT_USUARIO',$id);
		$data = array('PASSWORD_PRIMARIA'=>md5($pass),);
		$this->db->update('usuario', $data);
	}


	/**
	* Modifica los datos de un Coordinador, no los de la tabla Usuario.
	*
	* Funciòn modifica los datos como el nombre, los emails y el teléfono para la tabla
	* Coordinadores, es importante señalar que no realiza el cambio para la tabla Usuarios,
	* esto se hace en la función siguiente.
	*
	* @param string $nombreNuevo nombre del coordinador que modificó sus datos.
	* @param string $rutActual rut del coordinador que modificó sus datos.
	* @param string $correo1Nuevo correo electrónico del coordinador que modificó sus datos.
	* @param string $correo2Nuevo cooreo electrónico alternativo del coordinador que modificó sus datos.
	* @param string $telefonoNuevo número de teléfono del coordinador que modificó sus datos.
	* @return none
	*/
	function actualizarCoordinador($rutActual,$nombre1, $nombre2, $apellido1, $apellido2, $correo1, $correo2, $fono) {
		$this->db->where('ID_TIPO', TIPO_USR_COORDINADOR);
		$this->db->where('RUT_USUARIO',$rutActual);
		$informacion = array(
				'NOMBRE1' => $nombre1,
				'NOMBRE2' => $nombre2,
				'APELLIDO1' => $apellido1,
				'APELLIDO2' => $apellido2,
				'TELEFONO' => $fono,
				'CORREO1_USER' => $correo1,
				'CORREO2_USER' => $correo2);

		$this->db->trans_start();
		$res = $this->db->update('usuario',$informacion);
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			return FALSE;
		}
		else{
			return TRUE;
		}
	}

	/**
	* Modifica los datos del Coordinador como Usuario.
	*
	* Luego de realizar la función de cambiar los datos en la tabla Coordinador, viene esta función
	* la cual cambia los datos del coordinador para la tabla usuario.
	*
	* @param string $rut rut del coordinador ingresado en el formulario.
	* @param int $tipo_usuario tipo de usuario del que se editó
	* @param int $telefono número telefónico del coordinador
	* @param string $mail1 correo electrónico del coordinador ingresado.
	* @param string $mail2 correo electrónico del coordinador ingresado.
	* @return none
	*/
	function cambiarDatosUsuario($rut, $tipo_usuario, $telefono, $mail1, $mail2) {
		$query = $this->db->where('RUT_USUARIO',$rut);
		$res = $this->db->update('usuario', array('CORREO1_USER'=>$mail1, 
		                                     'CORREO2_USER'=>$mail2, 'TELEFONO'=>$telefono));
		return $res;
	}


	/**
	* Agregar Coordinador.
	*
	* Función que ingresa todos los datos obtenidos del formulario a la base de datos, ingresando el coordinador
	* a la tabla tanto Usuario como Coordinador.
	*
	* @param string $nombre nombre del coordinador ingresado en el formulario.
	* @param string $rut rut del coordinador ingresado en el formulario.
	* @param string $contrasena contraseña del coordinador ingresada desde el formulario.
	* @param string $correo1 correo electrónico del coordinador ingresado.
	* @param string $correo2 cooreo electrónico alternativo del coordinador ingresado.
	* @param string $telefono número de teléfono del coordinador ingresado.
	* @return boolean TRUE o FALSE en caso de éxito o fracaso en la operación
	*/
	function agregarCoordinador($rut, $nombre1, $nombre2, $apellido1, $apellido2, $correo1, $correo2, $fono) {
		$data1 = array(
			'RUT_USUARIO' => $rut,
			'ID_TIPO' => TIPO_USR_COORDINADOR,
			'PASSWORD_PRIMARIA' => md5($rut),
			'CORREO1_USER' => $correo1,
			'CORREO2_USER' => $correo2,
			'NOMBRE1' => $nombre1 ,
			'NOMBRE2' => $nombre2 ,
			'APELLIDO1' => $apellido1 ,
			'APELLIDO2' => $apellido2,
			'TELEFONO' =>  $fono,
			'LOGUEABLE' => TRUE
		);
		$data2 = array('RUT_USUARIO' => $rut);

		$this->db->trans_start();
		$datos2 = $this->db->insert('usuario',$data1);

		$datos = $this->db->insert('coordinador',$data2);
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			return FALSE;
		}
		else{
			return TRUE;
		}
	}


	/**
	* Función que obtiene los coordinadores que coinciden con cierta búsqueda
	*
	* Esta función recibe un texto para realizar una búsqueda y un tipo de atributo por el cual filtrar.
	* Se realiza una consulta a la base de datos y se obtiene la lista de coordinadores que coinciden con la búsqueda
	* Esta búsqueda se realiza mediante la sentencia like de SQL.
	*
	* @param int $tipoFiltro Un valor entre 1 a 6 que indica el tipo de filtro a usar.
	* @param string $texto Es el texto que se desea hacer coincidir en la búsqueda
	* @return Se devuelve un array de objetos alumnos con sólo su nombre y rut
	* @author Víctor Flores
	*/
	public function getCoordinadoresByFilter($texto, $textoFiltrosAvanzados, $rutExcepto) {
		$this->db->select('usuario.RUT_USUARIO AS id');
		$this->db->select('NOMBRE1 AS nombre1');
		$this->db->select('APELLIDO1 AS apellido1');
		$this->db->select('APELLIDO2 AS apellido2');
		$this->db->join('usuario', 'coordinador.RUT_USUARIO = usuario.RUT_USUARIO');
		$this->db->order_by('APELLIDO1', 'asc');
		if ($rutExcepto != NULL) {
			$this->db->where('usuario.RUT_USUARIO !=', $rutExcepto);
		}
		$rut = $this->session->userdata['rut'];

		if ($texto != "") {
			$this->db->where("(usuario.RUT_USUARIO LIKE '%".$texto."%'  OR NOMBRE1 LIKE '%".$texto."%' OR NOMBRE2 LIKE '%".$texto."%' OR APELLIDO1 LIKE '%".$texto."%' OR APELLIDO2 LIKE '%".$texto."%')");
		}
		else {
			//Sólo para acordarse
			define("BUSCAR_POR_RUT", 0);
			define("BUSCAR_POR_NOMBRE", 1);
			define("BUSCAR_POR_APELLIDO", 2);
			$this->db->like("usuario.RUT_USUARIO", $textoFiltrosAvanzados[BUSCAR_POR_RUT]);
			if ($textoFiltrosAvanzados[BUSCAR_POR_NOMBRE] != '') {
			$this->db->where("(NOMBRE1 LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_NOMBRE]."%' OR NOMBRE2 LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_NOMBRE]."%')");

			}
			if ($textoFiltrosAvanzados[BUSCAR_POR_APELLIDO] != '') {
				$this->db->where("(APELLIDO1 = '%".$textoFiltrosAvanzados[BUSCAR_POR_APELLIDO]."%' OR APELLIDO2 LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_APELLIDO]."%')");

			}
		}
		$query = $this->db->get('coordinador');
		//echo $this->db->last_query();
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}


	/**
	* Obtiene los detalles de un coordinador
	* 
	* Se recibe un rut y se hace la consulta para obtener todos los demás atributos del coordinador
	* con ese rut. Los atributos del objeto obtenido son:
	* rut, nombre1, nombre2, apellido1, apellido2, fono, correo y correo2
	* 
	* @param int $rut El rut del coordinador que se busca
	* @return Se retorna un objeto cuyos atributos son los atributos del coordinador, FALSE si no se encontró
	*/
	public function getDetallesCoordinador($rut) {
		$this->db->select('coordinador.RUT_USUARIO AS id');
		$this->db->select('coordinador.RUT_USUARIO AS rut');
		$this->db->select('NOMBRE1 AS nombre1');
		$this->db->select('NOMBRE2 AS nombre2');
		$this->db->select('APELLIDO1 AS apellido1');
		$this->db->select('APELLIDO2 AS apellido2');
		$this->db->select('TELEFONO AS telefono');
		$this->db->select('CORREO1_USER AS correo1');
		$this->db->select('CORREO2_USER AS correo2');
		$this->db->join('usuario', 'coordinador.RUT_USUARIO = usuario.RUT_USUARIO');
		$this->db->where('usuario.RUT_USUARIO', $rut);
		$query = $this->db->get('coordinador');
		if ($query == FALSE) {
			return array();
		}
		return $query->row();
	}
}
?>
