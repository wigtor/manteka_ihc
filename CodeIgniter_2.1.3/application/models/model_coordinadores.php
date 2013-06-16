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
class model_coordinadores extends CI_Model{
  /* function ValidarUsuario($rut,$password){         //   Consulta Mysql para buscar en la tabla Usuario aquellos usuarios que coincidan con el rut y password ingresados en pantalla de login
      $query = $this->db->where('RUT_USUARIO',$rut);   //   La consulta se efectúa mediante Active Record. Una manera alternativa, y en lenguaje más sencillo, de generar las consultas Sql.
      $query = $this->db->where('PASSWORD',md5($password));
      $query = $this->db->get('usuario'); //Acá va el nombre de la tabla
      return $query->row();    //   Devolvemos al controlador la fila que coincide con la búsqueda. (FALSE en caso que no existir coincidencias)
   }*/


      /**
      * Obtiene una lista con todos los coordinadores y su informacion de usuario.
      *
      * Obtiene una listac con todos los coordinadores uniendo su informacion con la presente en la tabla usuarios.
      *
      * @param none
      * @return array $datos  datos de los coordinadores
      */
   	function ObtenerTodosCoordinadores(){
   		/* SUMARIO DE LA FUNCIÓN:
   			La función simplemente obtiene desde la base de datos
   			todos las coordinaciones disponibles en el
   			sistema.

   			El resultado es entregado al controlador en forma de
   			array de objetos, por tanto éste debe recorrer el
            array y transformar los objetos en filas para
            obtener la información correspondiente.
   		*/
		
		$this->db->select('*');
		$this->db->from('coordinador');	
		$this->db->join('usuario', 'coordinador.RUT_USUARIO3 = usuario.RUT_USUARIO');
		$query = $this->db->get();
		
   		/*$query = $this->db->get('coordinador');¨*/
   		$ObjetoListaResultados = $query->result_array();
		/*'id'=>1 , 'nombre'=>"asd", 'rut'=>"1213451-1", 'contrasena'=>"asd", 'correo1'=>"correo1",'correo2'=>"correo2",'fono'=>"81234567",
		*/
		$datos = array();
		$contador = 0;		
		foreach ($ObjetoListaResultados as $row) {
                        $datos[$contador] = array(
								'id'=>intval($row['RUT_USUARIO3']),
								'rut'=>$row['RUT_USUARIO3'],
                                'nombre'=> $row['APELLIDO1_COORDINADOR']." ".$row['APELLIDO2_COORDINADOR']." ".$row['NOMBRE1_COORDINADOR']." ".$row['NOMBRE2_COORDINADOR'],
                                'fono'=> intval($row['TELEFONO_COORDINADOR']),
								        'correo1'=>$row['CORREO1_USER'],
								        'correo2'=>$row['CORREO2_USER'],
                        );
                        $contador++;
		}
   		return $datos;
   	}


   /**
   * Obtiene una lista con todos los modulos para un corrdinador
   *
   * Con el rut como parametro de entrada obtiene todo los módules correspondientes para un coordinador.   
   *
   * @param int $id identificador primario para el coordinador consultado
   * @return array $ObjetoListaResultados arreglo con los modulos para el coordinador de la entrada
   */
	function GetModulos($id){
		$this->db->select('COD_MODULO_TEM');
		$this->db->from('modulo_tematico');
		$this->db->where('RUT_USUARIO2', $id);
		$query = $this->db->get();
		$ObjetoListaResultados = $query->result_array();
		return $ObjetoListaResultados;		
	}	
	

   /**
   * Obtiene una lista con todas las secciones para un modulo
   *
   * Función que obtiene todas las secciones para un módulo que a su vez tiene un profesor asocciado
   * la forma de retorno es una lista con todas las secciones correspondientes
   * @param int $id identificador primario para el modulo consultado
   * @return array $ObjetoListaResultados arreglo con las secciones para el modulo de la entrada
   */
	function GetSeccion($id){
		$this->db->select('COD_SECCION');
		$this->db->from('sesion');
		$this->db->where('COD_MODULO_TEM', $id);
		$query = $this->db->get();
		$ObjetoListaResultados = $query->result_array();	
		return $ObjetoListaResultados;	
	}
	
	
		/**
      * Obtiene una lista con todos los coordinadores para un criterio especifico
      *
      * @param string $etrada valor con el cual se compara el criterio.
      * @param string $criterio criterio segun el cual se hara la comparacion.
      * @return array $ObjetoListaResultados arreglo con los coordinadores para la consulta.
      */
   	function BuscarCoordinadores($entrada,$criterio){
         /* SUMARIO DE LA FUNCIÓN:
            La función obtiene desde la base de datos
            todos las coordinaciones disponibles en el
            sistema que cumplan

            El resultado es entregado al controlador en forma de
            array de objetos, por tanto éste debe recorrer el
            array y transformar los objetos en filas para
            obtener la información correspondiente.
         */

         /*Según el criterio del filtro, se configura la entrada de la consulta a la
            base de datos. Como se trata de una búsqueda, las sentencias de consulta
            utilizan LIKE en vez de WHERE, que exigiría una entrada exacta para producir
            resultados, algo poco probable. */

         switch ($criterio) {
            /*
               NOTA: escape_like_str debería impedir inyecciones SQL.
               Ya que no se ocupan comodines en la búsqueda, quizás
               escape() pueda hacer el mismo trabajo.
            */
            case 'e-mail':
               $this->db->like('CORREO1_USER',$this->db->escape_like_str($entrada));
               $this->db->or_like('CORREO2_USER',$this->db->escape_like_str($entrada));
               break;
            case 'rut':
               $this->db->like('RUT_USUARIO',$this->db->escape_like_str($entrada));
               break;
            case 'nombre':
               $this->db->like('COORD_NOMBRE',$this->db->escape_like_str($entrada));
               break;
            case 'telefono':
               $this->db->like('COORD_TELEFONO',$this->db->escape_like_str($entrada));
               break;
            case 'tipo': //será un criterio válido?
               $this->db->like('ID_TIPO',$this->db->escape_like_str($entrada));
               break;
            case 'id':
               $this->db->like('ID_COORD',$this->db->escape_like_str($entrada));
               break;
            default:
               //nada
               break;
         }
         //Ejecución consulta
         $ObjetoListaResultados=array();
         $this->db->get('coordinador');//equivale a this->db->from()
         $this->db->order_by('COORD_NOMBRE','asc');
         $ObjetoListaResultados = $this->db->result();
   	}
     
	 
      /**
      * Borra un coordinador segun su nombre o rut.
      *
	  * Funciòn que elimina un Coordinador con el o nombre como valor de entrada
	  *
      * @param string $nombre nombre segun el cual se buscará el coordinador para eliminar.
      * @param string $rut rut segun el cual se buscará el coordinador para eliminar
      * @return none
      */
      function borrarCoordinador($nombre,$rut){
         $this->db->where('COORD_NOMBRE',$nombre);
         $this->db->or_where('RUT_USUARIO',$rut);
         $this->db->delete('coordinador');
      }
	  
	  
	  /**
      * Borra un coordinador segun su rut.
      *
	  * Funciòn que elimina un Coordinador con el rut como valor de entrada,
	  * este elimina de la tabla usuario y la tabla coordinador.
	  *
      * @param string $array rut segun el cual se buscará el coordinador para eliminar
      * @return none
      */	
      function borrarCoordinadores($array){
         $this->db->where('RUT_USUARIO3',$array);
         $this->db->delete('coordinador');
         $this->db->where('RUT_USUARIO',$array);
         $this->db->delete('usuario');
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
      function modificarPassword($id, $pass){
         $this->db->where('RUT_USUARIO',$id);
         //$data = array('PASSWORD_PRIMARIA'=>$pass,);
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
      //no comtempla la modificacion de tipo de usuario.
      function modificarCoordinador($rutActual,$nombre1, $nombre2, $apellido1, $apellido2, $correo1, $correo2, $fono){
         //tabla coordinador
         $this->db->where('RUT_USUARIO3',$rutActual);
         $informacion = array(
                        'NOMBRE1_COORDINADOR' => $nombre1,
                        'NOMBRE2_COORDINADOR' => $nombre2,
                        'APELLIDO1_COORDINADOR' => $apellido1,
                        'APELLIDO2_COORDINADOR' => $apellido2,
                        'TELEFONO_COORDINADOR' => $fono);
         $this->db->update('coordinador',$informacion);
         //tabla usuario
         $this->db->where('RUT_USUARIO',$rutActual);
         $informacion_user = array(
                        'CORREO1_USER' => $correo1,
                        'CORREO2_USER' => $correo2,);
         $this->db->update('usuario',$informacion_user);
      
	  
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
      }
      function cambiarDatosUsuario($rut, $tipo_usuario, $telefono, $mail1, $mail2) {
         $query = $this->db->where('RUT_USUARIO',$rut);
         $query = $this->db->insert('usuario', array('CORREO1_USER'=>$mail1, 
                                                     'CORREO2_USER'=>$mail2));
         $this->db->stop_cache();
         $this->db->flush_cache();
         $this->db->stop_cache();
         if ($tipo_usuario == TIPO_USR_COORDINADOR) { //Coordinador, constante definida en archivo constants del framework
            $query = $this->db->where('RUT_USUARIO3',$rut);   //   La consulta se efect?a mediante Active Record. Una manera alternativa, y en lenguaje m?s sencillo, de generar las consultas Sql.
            $query = $this->db->update('coordinador', array('TELEFONO_COORDINADOR'=>$telefono)); //Acá va el nombre de la tabla
         }
         return TRUE;
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
      * @return none
      */
      function agregarCoordinador($rut, $nombre1 , $nombre2, $apellido1, $apellido2, $correo1, $correo2, $fono){
         $informacion_user = array('RUT_USUARIO'=> $rut,
                                    'ID_TIPO'=> TIPO_USR_COORDINADOR ,
                                    'PASSWORD_PRIMARIA'=>md5($rut) ,
                                    'CORREO1_USER'=>$correo1 ,
                                    'CORREO2_USER'=>$correo2 );
         $this->db->insert('usuario',$informacion_user);
         $informacion_coord = array('RUT_USUARIO3'          => $rut, 
                                    'NOMBRE1_COORDINADOR'   => $nombre1,
                                    'NOMBRE2_COORDINADOR'   => $nombre1,
                                    'APELLIDO1_COORDINADOR'   => $apellido1,
                                    'APELLIDO2_COORDINADOR'   => $apellido2,
                                    'TELEFONO_COORDINADOR'  => $fono);
         $this->db->insert('coordinador',$informacion_coord);
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
      public function getCoordinadoresByFilter($texto, $textoFiltrosAvanzados)
      {
         $this->db->select('RUT_USUARIO3 AS rut');
         $this->db->select('NOMBRE1_COORDINADOR AS nombre1');
         $this->db->select('APELLIDO1_COORDINADOR AS apellido1');
         $this->db->order_by('APELLIDO1_COORDINADOR', 'asc');

         if ($texto != "") {
            $this->db->like("RUT_USUARIO3", $texto);
            $this->db->or_like("NOMBRE1_COORDINADOR", $texto);
            $this->db->or_like("NOMBRE2_COORDINADOR", $texto);
            $this->db->or_like("APELLIDO1_COORDINADOR", $texto);
            $this->db->or_like("APELLIDO2_COORDINADOR", $texto);
         }
         else {
            //Sólo para acordarse
            define("BUSCAR_POR_RUT", 0);
            define("BUSCAR_POR_NOMBRE", 1);
            define("BUSCAR_POR_APELLIDO", 2);
            $this->db->like("RUT_USUARIO3", $textoFiltrosAvanzados[BUSCAR_POR_RUT]);
            if ($textoFiltrosAvanzados[BUSCAR_POR_NOMBRE] != '') {
               $this->db->where("(NOMBRE1_COORDINADOR LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_NOMBRE]."%' OR NOMBRE2_COORDINADOR LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_NOMBRE]."%')");
               
            }
            if ($textoFiltrosAvanzados[BUSCAR_POR_APELLIDO] != '') {
               $this->db->where("(APELLIDO1_COORDINADOR = '%".$textoFiltrosAvanzados[BUSCAR_POR_APELLIDO]."%' OR APELLIDO2_COORDINADOR LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_APELLIDO]."%')");
               
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
      $this->db->select('RUT_USUARIO3 AS rut');
      $this->db->select('NOMBRE1_COORDINADOR AS nombre1');
      $this->db->select('NOMBRE2_COORDINADOR AS nombre2');
      $this->db->select('APELLIDO1_COORDINADOR AS apellido1');
      $this->db->select('APELLIDO2_COORDINADOR AS apellido2');
      $this->db->select('TELEFONO_COORDINADOR AS fono');
      $this->db->select('CORREO1_USER AS correo');
      $this->db->select('CORREO2_USER AS correo2');
      $this->db->join('usuario', 'coordinador.RUT_USUARIO3 = usuario.RUT_USUARIO');
      $this->db->where('RUT_USUARIO3', $rut);
      $query = $this->db->get('coordinador');
      if ($query == FALSE) {
         return array();
      }
      return $query->row();
   }

   public function getAllCoordinadores(){
      $this->db->select('RUT_USUARIO3 AS rut');
      $this->db->select('NOMBRE1_COORDINADOR AS nombre1');
      $this->db->select('NOMBRE2_COORDINADOR AS nombre2');
      $this->db->select('APELLIDO1_COORDINADOR AS apellido1');
      $this->db->select('APELLIDO2_COORDINADOR AS apellido2');
      $this->db->select('CORREO1_USER AS correo');
      $this->db->from('coordinador');
      $this->db->join('usuario','coordinador.RUT_USUARIO3 = usuario.RUT_USUARIO');
      $this->db->order_by("APELLIDO1_COORDINADOR", "asc");
      $query = $this->db->get();
      if ($query == FALSE) {
         $query = array();
         return $query;
      }
      return $query->result();
   }

}
?>
