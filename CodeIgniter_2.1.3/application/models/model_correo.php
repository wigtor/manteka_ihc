<?php

/**
* Modelo principal para la administraci?n b?sica de correos electr?nicos.
*
* Permite ver, consultar, insertar y eliminar correos electr?nicos, en las tablas
* utilizadas por el controlador de correo.
*
* @package Correo
* @author Grupo 3
*
*/
class model_correo extends CI_Model
{
	/**
	* Obtiene los correos electr?nicos enviados por un usuario.
	*
	* Obtiene toda la informaci?n de los correos electr?nicos enviados por un usuario,
	* junto con la lista de estudiantes, profesores y ayudantes a los cuales se le ha
	* enviado cada uno de dichos correos.
	* La funci?n devuelve un array donde cada elemento (excepto el primero) corresponde a otro array formado
	* por 5 arrays que son:
	* 1. array cuyos valores son los datos del correo.
	* 2. array (estudiantes) formado por varios arrays donde cada array contiene los valores de un estudiante
	*    receptor del correo almacenado en 1.
	* 3. array (ayudantes) formado por varios arrays donde cada array contiene los valores de un ayudante
	*    receptor del correo almacenado en 1.
	* 4. array (profesores) formado por varios arrays donde cada array contiene los valores de un profesor
	*    receptor del correo almacenado en 1.
	* 5. array (coordinadores) formado por varios arrays donde cada array contiene los valores de un coordinador
	*    receptor del correo almacenado en 1.
	* El primer elemento del array devuelto por la funci?n corresponde a un entero que puede ser 1 ? -1 y se
	* utiliza para indicar el estado de la funci?n. (-1 indica que la obtención de los correos no se ejecut?
	* correctamente, y 1 indica que el resultado de la funci?n es totalmente válido.)
	* @param int $variable
	* @return array $listaCompleta
	*
	* @author: Claudio Rojas (CR) y Diego Garc?a (DGM). 
	*/
	public function VerCorreosUser($rut,$offset, $tipoUsuario, $texto, $textoFiltrosAvanzados)
	{
		try {
			$resultado=array();
			$de=array();
			$correos=array();
			$correo=array();

			//Constantes para facilitar saber que tipo de búsqueda se utiliza (El indice 0 no se usa en las búsquedas de correo, porque se usa para el checkbox)
			define("BUSCAR_POR_REMITENTE", 1); //De
			define("BUSCAR_POR_MENSAJE", 2); //Mensaje
			define("BUSCAR_POR_FECHA", 3);
			define("BUSCAR_POR_HORA", 4);

			$consultasLikes = '1';
			if (trim($texto) != '') {
				$consultasLikes = "(ASUNTO LIKE '%".$texto."%' 
					OR CUERPO_EMAIL LIKE '%".$texto."%' 
					OR nombre_destinatario LIKE '%".$texto."%' 
					OR FECHA LIKE '%".$texto."%' 
					OR HORA LIKE '%".$texto."%')";
			}
			else {
				if ($textoFiltrosAvanzados[BUSCAR_POR_REMITENTE] != '') {
					$consultasLikes = "nombre_destinatario LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_REMITENTE]."%'";
				}
				if ($textoFiltrosAvanzados[BUSCAR_POR_MENSAJE] != '') {
					$consultasLikes = "(ASUNTO LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_MENSAJE]."%' 
						OR CUERPO_EMAIL LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_MENSAJE]."%')";
				}
				if ($textoFiltrosAvanzados[BUSCAR_POR_FECHA] != '') {
					$consultasLikes = "FECHA LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_FECHA]."%'";

				}
				if ($textoFiltrosAvanzados[BUSCAR_POR_HORA] != '') {
					$consultasLikes = "HORA LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_HORA]."%'";
				}
			}

			$queryHorrible = "SELECT T.COD_CORREO AS codigo, GROUP_CONCAT(T.nombre_destinatario) AS nombre_destinatario, ASUNTO AS asunto, CUERPO_EMAIL AS cuerpo_email, FECHA AS fecha, HORA AS hora FROM 
			(
			(SELECT carta.*, GROUP_CONCAT( CONCAT(NOMBRE1_COORDINADOR, \" \", APELLIDO1_COORDINADOR, \" \", APELLIDO2_COORDINADOR)) AS nombre_destinatario
			FROM carta
			LEFT JOIN cartar_user ON cartar_user.COD_CORREO = carta.COD_CORREO
			LEFT JOIN coordinador ON coordinador.RUT_USUARIO3 = cartar_user.RUT_USUARIO
			WHERE carta.RUT_USUARIO = $rut
			AND COD_BORRADOR IS NULL
			AND ENVIADO_CARTA =1
			GROUP BY carta.COD_CORREO )

			UNION

			(SELECT carta.*, GROUP_CONCAT( CONCAT(NOMBRE1_PROFESOR, \" \", APELLIDO1_PROFESOR, \" \", APELLIDO2_PROFESOR)) AS nombre_destinatario
			FROM carta
			LEFT JOIN cartar_user ON cartar_user.COD_CORREO = carta.COD_CORREO
			LEFT JOIN profesor ON profesor.RUT_USUARIO2 = cartar_user.RUT_USUARIO
			WHERE carta.RUT_USUARIO = $rut
			AND COD_BORRADOR IS NULL
			AND ENVIADO_CARTA =1
			GROUP BY carta.COD_CORREO )

			UNION

			(SELECT carta.*, GROUP_CONCAT( CONCAT(NOMBRE1_AYUDANTE, \" \", APELLIDO1_AYUDANTE, \" \", APELLIDO2_AYUDANTE)) AS nombre_destinatario
			FROM carta
			LEFT JOIN cartar_ayudante ON cartar_ayudante.COD_CORREO = carta.COD_CORREO
			LEFT JOIN ayudante ON ayudante.RUT_AYUDANTE = cartar_ayudante.RUT_AYUDANTE
			WHERE carta.RUT_USUARIO = $rut
			AND COD_BORRADOR IS NULL
			AND ENVIADO_CARTA =1
			GROUP BY carta.COD_CORREO )

			UNION

			(SELECT carta.*, GROUP_CONCAT( CONCAT(NOMBRE1_ESTUDIANTE, \" \", APELLIDO1_ESTUDIANTE, \" \", APELLIDO2_ESTUDIANTE)) AS nombre_destinatario
			FROM carta
			LEFT JOIN cartar_estudiante ON cartar_estudiante.COD_CORREO = carta.COD_CORREO
			LEFT JOIN estudiante ON estudiante.RUT_ESTUDIANTE = cartar_estudiante.RUT_ESTUDIANTE
			WHERE carta.RUT_USUARIO = $rut
			AND COD_BORRADOR IS NULL
			AND ENVIADO_CARTA =1
			GROUP BY carta.COD_CORREO )

			) AS T
			
			WHERE $consultasLikes

			GROUP BY T.COD_CORREO
			ORDER BY T.COD2_CORREO DESC
			LIMIT $offset, 5"; //NIKAGANDO LA HAGO EN ACTIVERECORD!!!


			$query = $this->db->query($queryHorrible);
			//echo $this->db->last_query().'   ';return;
			return $query->result();
		}
		catch(Exception $e)
		{
			$listaCompleta=array();
			
			/* Se agrega la variable de estado -1 al array que ser? retornado.
			Para indicar que la operaci?n no se realiz? correctamente. */
			array_unshift($listacompleta,-1);
			
			return $listaCompleta;
		}
	}
	
	/**
	* Elimina 1 o varios correos de la base de datos de la aplicaci?n.
	*
	* Para cada correo se elimina los datos de dicho correo en todas las
	* tablas que asocien correos a destinatarios y tambien en la tabla
	* principal de guardado de correos enviados.
	* En el array de entrada se especifican los identificadores de todos
	* los correos a eliminar.
	* En el array de salida se especifica el resultado de la consulta de
	* de la eliminaci?n para cada correo. 
	*
	* @param array $correos
	* @author Diego Garc?a (DGM) y Byron Lanas (BL) 
	*
	*/
	public function EliminarCorreo($correos)
	{

		foreach($correos as $correo)
		{

			$this->db->where('COD_CORREO',$correo);
			$this->db->update('carta',array('ENVIADO_CARTA' => 0));


		}

	}
	/**
	* Elimina 1 o varios borradores de la base de datos de la aplicación.
	*
	* Para cada borrador se elimina los datos de dicho borrador en la
	* tabla carta.
	* En el array de entrada se especifican los identificadores de todos
	* los correos a eliminar. 
	*
	* @param array $correos
	* @return int 1
	* @author Byron Lanas (BL)
	*
	*/
	public function EliminarRecibidos($correos,$rut)
	{

		foreach($correos as $correo)
		{	
			echo $correo;
			$this->db->where('COD_CORREO',$correo);
			$this->db->where('RUT_USUARIO',$rut);
			$this->db->update('cartar_user',array('RECIBIDO_CARTA_USER' => 0));
			//echo $this->db->last_query();
		}

		return 1;
	}

	/**
	* Elimina 1 o varios borradores de la base de datos de la aplicación.
	*
	* Para cada borrador se elimina los datos de dicho borrador en la
	* tabla carta.
	* En el array de entrada se especifican los identificadores de todos
	* los correos a eliminar. 
	*
	* @param array $correos
	* @return int 1
	* @author Byron Lanas (BL)
	*
	*/
	public function EliminarBorradores($correos)
	{

		foreach($correos as $correo)
		{	

			$this->db->select('COD_CORREO');
			$this->db->where('COD_BORRADOR', $correo); 
			//$this->db->order_by("COD2_CORREO", "desc"); 
			$this->db->limit(1);
			$query = $this->db->get('carta');
			
			
			foreach ($query->result() as $row)
			{
			   $cod= $row->COD_CORREO;
			}
			$this->db->where('COD_BORRADOR',$correo);
			$this->db->update('carta',array('COD_BORRADOR' => NULL));
			$this->db->delete('borrador', array('COD_BORRADOR' => $correo));
			$this->db->delete('cartar_ayudante', array('COD_CORREO' => $cod)); 
			$this->db->delete('cartar_estudiante', array('COD_CORREO' => $cod)); 
			$this->db->delete('cartar_user', array('COD_CORREO' => $cod)); 
			$this->db->delete('carta', array('COD_CORREO' => $cod)); 
		}

		return 1;
	}

	/**
	* Muestra los correos recibidos por el usuario
	*
	* @param int $rut
	* @param int $offset
	* @param string $texto
	* @param array $textoFiltrosAvanzados
	* @return array $listaCompleta
	* @author Byron Lanas (BL)
	*
	*/
	public function VerCorreosRecibidos($rut,$offset, $tipoUsuario, $texto, $textoFiltrosAvanzados)
	{
		try
		{
			$resultado=array();
			$de=array();
			$correos=array();
			$correo=array();

			//Constantes para facilitar saber que tipo de búsqueda se utiliza (El indice 0 no se usa en las búsquedas de correo, porque se usa para el checkbox)
			define("BUSCAR_POR_REMITENTE", 1); //De
			define("BUSCAR_POR_MENSAJE", 2); //Mensaje
			define("BUSCAR_POR_FECHA", 3);
			define("BUSCAR_POR_HORA", 4);

			//Mi query
			$this->db->select('carta.COD_CORREO AS codigo');
			$this->db->select('ASUNTO AS asunto');
			$this->db->select('CUERPO_EMAIL AS cuerpo_email');
			$this->db->select('FECHA AS fecha');
			$this->db->select('HORA AS hora');
			$this->db->select('carta.RUT_USUARIO AS de');
			$this->db->from('carta');
			$this->db->join('cartar_user','carta.COD_CORREO = cartar_user.COD_CORREO');
			$this->db->where('cartar_user.RUT_USUARIO',$rut);
			$this->db->where('COD_BORRADOR IS NULL');
			$this->db->where('RECIBIDO_CARTA_USER', 1);
			$this->db->order_by("COD2_CORREO", "desc");

			if ($tipoUsuario == TIPO_USR_COORDINADOR) { //Este es un entero: 1 o 2
				$this->db->select('NOMBRE1_COORDINADOR AS nombre');
				$this->db->select('APELLIDO1_COORDINADOR AS apellido1');
				$this->db->select('APELLIDO2_COORDINADOR AS apellido2');
				$this->db->join('coordinador', 'coordinador.RUT_USUARIO3 = carta.RUT_USUARIO');
				if (trim($texto) != '') {
					$this->db->where("(ASUNTO LIKE '%".$texto."%' OR CUERPO_EMAIL LIKE '%".$texto."%' OR NOMBRE1_COORDINADOR LIKE '%".$texto."%'OR APELLIDO1_COORDINADOR LIKE '%".$texto."%' OR APELLIDO2_COORDINADOR LIKE '%".$texto."%' OR FECHA LIKE '%".$texto."%' OR HORA LIKE '%".$texto."%')");
					/* //Quiero prioridad en los OR, por eso lo puse como una clausula where en la linea anterior
					$this->db->or_like("carta.ASUNTO", $texto);
					$this->db->or_like("carta.CUERPO_EMAIL", $texto);
					$this->db->or_like("NOMBRE1_COORDINADOR", $texto);
					$this->db->or_like("APELLIDO1_COORDINADOR", $texto);
					$this->db->or_like("APELLIDO2_COORDINADOR", $texto);
					*/
				}
				else { //Búsqueda avanzada por campos separados
					if ($textoFiltrosAvanzados[BUSCAR_POR_REMITENTE] != '') {
						$this->db->where("(NOMBRE1_COORDINADOR LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_REMITENTE]."%'OR APELLIDO1_COORDINADOR LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_REMITENTE]."%' OR APELLIDO2_COORDINADOR LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_REMITENTE]."%')");
					}
					if ($textoFiltrosAvanzados[BUSCAR_POR_MENSAJE] != '') {
						$this->db->where("(ASUNTO LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_MENSAJE]."%' OR CUERPO_EMAIL LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_MENSAJE]."%')");
					}
					if ($textoFiltrosAvanzados[BUSCAR_POR_FECHA] != '') {
						$this->db->where("(FECHA LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_FECHA]."%')");
					}
					if ($textoFiltrosAvanzados[BUSCAR_POR_HORA] != '') {
						$this->db->where("(HORA LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_HORA]."%')");
					}
				}
			}
			if ($tipoUsuario == TIPO_USR_PROFESOR) {//Este es un entero: 1 o 2
				$this->db->select('NOMBRE1_PROFESOR AS nombre');
				$this->db->select('APELLIDO1_PROFESOR AS apellido1');
				$this->db->select('APELLIDO2_PROFESOR AS apellido2');
				$this->db->join('profesor', 'profesor.RUT_USUARIO2 = carta.RUT_USUARIO');
				if (trim($texto) != '') {
					$this->db->where("(ASUNTO LIKE '%".$texto."%' OR CUERPO_EMAIL LIKE '%".$texto."%' OR NOMBRE1_PROFESOR LIKE '%".$texto."%'OR APELLIDO1_PROFESOR LIKE '%".$texto."%' OR APELLIDO2_PROFESOR LIKE '%".$texto."%')");
					/* //Quiero prioridad en los OR, por eso lo puse como una clausula where en la linea anterior
					$this->db->or_like("carta.ASUNTO", $texto);
					$this->db->or_like("carta.CUERPO_EMAIL", $texto);
					$this->db->or_like("NOMBRE1_PROFESOR", $texto);
					$this->db->or_like("APELLIDO1_PROFESOR", $texto);
					$this->db->or_like("APELLIDO2_PROFESOR", $texto);
					*/
				}
				else { //Busqueda avanzada por campos separados
					if ($textoFiltrosAvanzados[BUSCAR_POR_REMITENTE] != '') {
						$this->db->where("(APELLIDO1_PROFESOR LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_REMITENTE]."%'OR APELLIDO1_PROFESOR LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_REMITENTE]."%' OR APELLIDO2_PROFESOR LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_REMITENTE]."%')");
					}
					if ($textoFiltrosAvanzados[BUSCAR_POR_MENSAJE] != '') {
						$this->db->where("(ASUNTO LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_MENSAJE]."%' OR CUERPO_EMAIL LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_MENSAJE]."%')");
					}
					if ($textoFiltrosAvanzados[BUSCAR_POR_FECHA] != '') {
						$this->db->where("(FECHA LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_FECHA]."%')");
					}
					if ($textoFiltrosAvanzados[BUSCAR_POR_HORA] != '') {
						$this->db->where("(HORA LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_HORA]."%')");
					}

				}
			}
			$this->db->limit(5, $offset);
			$query = $this->db->get();
			//echo $this->db->last_query().'   ';return;
			return $query->result();
		}
		catch(Exception $e)
		{
			return -1;
		}
	}

	/**
	* Inserta un correo enviado a la base de datos o elimina el borrador si el correo ya existe.
	*
	* Permite insertar correos a la tabla "carta"
	* para su posterior consulta.
	* Si la inserci?n es correcta, la funci?n retorna 1, en
	* caso contrario, retornar? -1.
	*
	* @param string $asunto
	* @param string $mensaje
	* @param int $rut
	* @param int $tipo
	* @param date $codCorreo
	* @param int $rutRecept
	* @param int $codigoBorrador
	* @return int
	* @author Byron Lanas (BL)
	*
	*/
	public function InsertarCorreo($asunto,$mensaje,$rut,$codCorreo,$rutRecept,$codigoBorrador)
	{
		try
		{  
			date_default_timezone_set("Chile/Continental");
			if($codigoBorrador==-1){
				$this->COD2_CORREO=$codCorreo;
				$this->COD_BORRADOR=null;
				$this->ID_PLANTILLA=null;
				
				$this->RUT_USUARIO=$rut;
				
				
				$this->HORA = date("H:i:s");
				$this->FECHA = date("Y-m-d");
				$this->CUERPO_EMAIL = $mensaje;
				$this->ASUNTO=$asunto;
				$this->db->insert('carta', $this);
				$this->db->_error_message();  
				return 1;
			}else
			{

				$this->db->select('COD_CORREO');
				$this->db->where('COD_BORRADOR', $codigoBorrador); 
				//$this->db->order_by("COD2_CORREO", "desc"); 
				$this->db->limit(1);
				$query = $this->db->get('carta');
				
				
				foreach ($query->result() as $row)
				{
				   $cod= $row->COD_CORREO;
				}
				$this->db->delete('cartar_ayudante', array('COD_CORREO' => $cod)); 
				$this->db->delete('cartar_estudiante', array('COD_CORREO' => $cod)); 
				$this->db->delete('cartar_user', array('COD_CORREO' => $cod)); 

				$this->db->where('COD_BORRADOR',$codigoBorrador);
				$this->db->update('carta',array('COD_BORRADOR' => NULL,'FECHA'=> date("Y-m-d"),'HORA'=>date("H:i:s"),'ASUNTO'=>$asunto,'CUERPO_EMAIL'=>$mensaje,'COD2_CORREO'=>$codCorreo));
				$this->db->delete('borrador', array('COD_BORRADOR' => $codigoBorrador)); 
			}
			
		}
		catch(Exception $e)
		{
			return -1;
		}
    }

	/**
	* Inserta un borrador a la base de datos, para esto crea una instancia en la tabla carta y en sus destinatarios correspondientes.
	*
	* @param string asunto
	* @param string mensaje
	* @param int $rut
	* @param date $codCorreo
	* @param int $rutRecept
	* @param int $codigoBorrador
	* @return int
	* @author Byron Lanas (BL)
	*
	*/
	public function insertarBorrador($asunto,$mensaje,$rut,$codCorreo,$rutRecept,$codigoBorrador)
	{

		try
		{
			date_default_timezone_set("Chile/Continental");
			if ($codigoBorrador==-1) {

			$this->COD2_CORREO=$codCorreo;
			$this->COD_BORRADOR=null;
			$this->ID_PLANTILLA=null;
			
			$this->RUT_USUARIO=$rut;
			
			
			$this->HORA = date("H:i:s");
			$this->FECHA = date("Y-m-d");
			$this->CUERPO_EMAIL = $mensaje;
			$this->ASUNTO=$asunto;
			$this->db->insert('carta', $this);
			$this->db->select('COD_CORREO');
			$this->db->where('COD2_CORREO', $codCorreo); 
			//$this->db->order_by("COD2_CORREO", "desc"); 
			$this->db->limit(1);
			$query = $this->db->get('carta');
			
			
			foreach ($query->result() as $row)
			{
			   $cod= $row->COD_CORREO;
			}
			$data = array(
				   
				   'COD_CORREO' => $cod ,
				   'FECHA_BORRADOR' => date("Y-m-d") ,
				   'HORA_BORRADOR' => date("H:i:s"),
				);

			$this->db->insert('borrador', $data);

			$this->db->select('COD_BORRADOR');
			$this->db->where('COD_CORREO', $cod);
			$query2 = $this->db->get('borrador'); 
			foreach ($query2->result() as $row)
			{
				
				$this->db->set('COD_BORRADOR',$row->COD_BORRADOR);
				$this->db->where('COD_CORREO', $cod);
				$this->db->update('carta');
				return $row->COD_BORRADOR;
			    
			}
			
			}else
			{

				$this->db->select('COD_CORREO');
				$this->db->where('COD_BORRADOR', $codigoBorrador); 
				//$this->db->order_by("COD2_CORREO", "desc"); 
				$this->db->limit(1);
				$query = $this->db->get('carta');
				
				
				foreach ($query->result() as $row)
				{
				   $cod= $row->COD_CORREO;
				}
				$this->db->delete('cartar_ayudante', array('COD_CORREO' => $cod)); 
				$this->db->delete('cartar_estudiante', array('COD_CORREO' => $cod)); 
				$this->db->delete('cartar_user', array('COD_CORREO' => $cod)); 

				$data2 = array(
				   
				   
				   'FECHA_BORRADOR' => date("Y-m-d") ,
				   'HORA_BORRADOR' => date("H:i:s"),
				);
				$this->db->where('COD_BORRADOR',$codigoBorrador);
				$this->db->update('borrador', $data2);

				$this->db->set('CUERPO_EMAIL', $mensaje);
				$this->db->set('ASUNTO', $asunto);
				$this->db->where('COD_BORRADOR',$codigoBorrador);
				$this->db->update('carta');


			}

			
		    return $codigoBorrador;
			
			
			
		}
		catch(Exception $e)
		{
			return -1;
		}
    }

    /**
	* Obtiene el codigo del correo para poder insertar
	* en las tabalas asociadas al receptor.
	*
	* @param date $codCorreo
	* @param int $codBorrador
	* @return int
	* @author Byron Lanas (BL)
	*
	*/
    	public function getCodigo($codCorreo,$codigoBorrador)
	{
		try
		{	
			if($codigoBorrador==-1){
				$this->db->select('COD_CORREO');
				$this->db->where('COD2_CORREO', $codCorreo); 
				//$this->db->order_by("COD2_CORREO", "desc"); 
				$this->db->limit(1);
				$query = $this->db->get('carta');
				 $e = $this->db->_error_message(); 
				
				foreach ($query->result() as $row)
				{
				    return $row->COD_CORREO;
				}
			}
			else{
				$this->db->select('COD_CORREO');
				$this->db->where('COD_BORRADOR', $codigoBorrador); 
				//$this->db->order_by("COD2_CORREO", "desc"); 
				$this->db->limit(1);
				$query = $this->db->get('carta');
				 $e = $this->db->_error_message(); 
				
				foreach ($query->result() as $row)
				{
				    return $row->COD_CORREO;
				}
			}


		}
		catch(Exception $e)
		{
			return -1;
		}
    }
    /**
	* verifica si el receptor es un estudiante
	* 
	*
	* @param int rut
	* @return int
	* @author Byron Lanas (BL)
	*
	*/
    	public function getRutEst($rut)
	{
		try
		{
			$this->db->where('RUT_ESTUDIANTE', $rut);
			$this->db->from('estudiante');
			return $this->db->count_all_results();


		}
		catch(Exception $e)
		{
			return -1;
		}}
     /**
	* verifica si el receptor es un ayudante
	* 
	*
	* @param int rut
	* @return int
	* @author Byron Lanas (BL)
	*
	*/
    	public function getRutAyu($rut)
	{
		try
		{
			$this->db->where('RUT_AYUDANTE', $rut);
			$this->db->from('ayudante');
			return $this->db->count_all_results();


		}
		catch(Exception $e)
		{
			return -1;
		}}


     /**
	* verifica si el receptor es un usuario
	* 
	*
	* @param int rut
	* @return int
	* @author Byron Lanas (BL)
	*
	*/
    	public function getRutUser($rut)
	{
		try
		{
			$this->db->where('RUT_USUARIO', $rut);
			$this->db->from('usuario');
			return $this->db->count_all_results();


		}
		catch(Exception $e)
		{
			return -1;
		}}		
    /**
	* Obtiene la cantidad de correos enviados por el usuario
	*
	* @param int $rut
	* @return int
	* @author Byron Lanas (BL)
	*
	*/
    public function cantidadCorreos($rut)
	{
		try
		{
			$this->db->where('RUT_USUARIO', $rut);
			$this->db->where('COD_BORRADOR IS NULL');
			$this->db->where('ENVIADO_CARTA',1);
			$this->db->from('carta');
			return $this->db->count_all_results();
			


		}
		catch(Exception $e)
		{
			return -1;
		}
    }

/**
	* Obtiene la cantidad de correos recibidos por el usuario
	*
	* @param int $rut
	* @return int
	* @author Byron Lanas (BL)
	*
	*/
    public function cantidadRecibidos($rut)
	{
		try
		{
			$this->db->where('cartar_user.RUT_USUARIO', $rut);
			$this->db->where('COD_BORRADOR IS NULL');
			$this->db->where('RECIBIDO_CARTA_USER',1);
			$this->db->from('carta');
			$this->db->join('cartar_user','carta.COD_CORREO = cartar_user.COD_CORREO');
			return $this->db->count_all_results();
			


		}
		catch(Exception $e)
		{
			return -1;
		}
    }



    /**
	* Obtiene la cantidad de borradores correspondientes al usuario
	*
	* @param int $rut
	* @return int
	* @author Byron Lanas (BL)
	*
	*/
    public function cantidadBorradores($rut)
	{
		try
		{
			$this->db->where('RUT_USUARIO', $rut);
			$this->db->where('COD_BORRADOR IS NOT NULL');

			$this->db->from('carta');
			return $this->db->count_all_results();
			


		}
		catch(Exception $e)
		{
			return -1;
		}
    }

        /**
	* Muestra los borradores que se encuentran en la base de datos
	*
	* @param int $rut
	* @param int $offset
	* @return array
	* @author Byron Lanas (BL)
	*
	*/
    public function verBorradores($rut,$offset)
	{
		try
		{
			$this->db->select('borrador.COD_BORRADOR AS codigo');
			$this->db->select('ASUNTO AS asunto');
			$this->db->select('CUERPO_EMAIL AS cuerpo_email');
			$this->db->select('FECHA_BORRADOR AS fecha');
			$this->db->select('HORA_BORRADOR AS hora');
			
			$this->db->from('carta');
			$this->db->join('borrador','carta.COD_BORRADOR = borrador.COD_BORRADOR');
			$this->db->where('RUT_USUARIO',$rut);
			$this->db->order_by("borrador.COD_BORRADOR", "desc"); 
			$this->db->limit( 5,$offset);
			$query = $this->db->get();
			
			if ($query == FALSE) {
				return array();
			}
			return $query->result();
			


		}
		catch(Exception $e)
		{
			return -1;
		}
    }

    /**
	* devuelve el asunto, cuerpo y correos y rut de los destinatarios del borrador seleccionado
	*
	* @param int $codigo
	* @param int $rut
	* @return array
	* @author Byron Lanas (BL)
	*
	*/
    public function cargarBorrador($codigo,$rut)
	{
		try
		{
			$resultado=array();
			$this->db->select('ASUNTO AS asunto');
			$this->db->select('CUERPO_EMAIL AS cuerpo_email');
			
			$this->db->from('carta');
			$this->db->where('RUT_USUARIO',$rut);
			$this->db->where('COD_BORRADOR',$codigo);
			$query = $this->db->get();
			
			if ($query == FALSE) {
				return array();
			}
			array_push($resultado, $query->result());
			$rutRecept=array();
			$rutEst=array();

			$this->db->select('COD_CORREO');
			$this->db->where('COD_BORRADOR', $codigo); 
			//$this->db->order_by("COD2_CORREO", "desc"); 
			$this->db->limit(1);
			$query = $this->db->get('carta');
			 $e = $this->db->_error_message(); 
			
			foreach ($query->result() as $row)
			{
			    $cod= $row->COD_CORREO;
			}
			$this->db->select('RUT_ESTUDIANTE AS rutRecept');
			$this->db->from('cartar_estudiante');
			$this->db->where('COD_CORREO',$cod);
			$query = $this->db->get();
			if ($query == FALSE) {
				return array();
			}
			$rutEst=$query->result();

			$rutAyu=array();
			$this->db->select('RUT_AYUDANTE AS rutRecept');
			$this->db->from('cartar_ayudante');
			$this->db->where('COD_CORREO',$cod);
			$query = $this->db->get();
			if ($query == FALSE) {
				return array();
			}
			$rutAyu=$query->result();

			$rutUser=array();
			$this->db->select('RUT_USUARIO AS rutRecept');
			$this->db->from('cartar_user');
			$this->db->where('COD_CORREO',$cod);
			$query = $this->db->get();
			if ($query == FALSE) {
				return array();
			}
			$rutUser=$query->result();
			$rutRecept=array_merge($rutEst,$rutAyu,$rutUser);
			array_push($resultado, $rutRecept);


			$correoRecept=array();
			$correoEst=array();

			$this->db->select('CORREO_ESTUDIANTE AS correo');
			$this->db->from('estudiante');
			$this->db->join('cartar_estudiante','cartar_estudiante.RUT_ESTUDIANTE = estudiante.RUT_ESTUDIANTE');
			$this->db->where('COD_CORREO',$cod);
			$query = $this->db->get();
			if ($query == FALSE) {
				return array();
			}
			$correoEst=$query->result();

			$correoAyu=array();

			$this->db->select('CORREO_AYUDANTE AS correo');
			$this->db->from('ayudante');
			$this->db->join('cartar_ayudante','cartar_ayudante.RUT_AYUDANTE = ayudante.RUT_AYUDANTE');
			$this->db->where('COD_CORREO',$cod);
			$query = $this->db->get();
			if ($query == FALSE) {
				return array();
			}
			$correoAyu=$query->result();

			
			
			$correoUser=array();

			$this->db->select('CORREO1_USER AS correo');
			$this->db->from('usuario');
			$this->db->join('cartar_user','cartar_user.RUT_USUARIO = usuario.RUT_USUARIO');
			$this->db->where('COD_CORREO',$cod);
			$query = $this->db->get();
			if ($query == FALSE) {
				return array();
			}
			$correoUser=$query->result();
			$correoRecept=array_merge($correoEst,$correoAyu,$correoUser);
			array_push($resultado, $correoRecept);


			return $resultado;

		}
		catch(Exception $e)
		{
			return -1;
		}
    }
    /**
	* devuelve los datos del correo a ver en su contexto
	*
	* @param int $codigo
	* @param int $rut
	* @return array
	* @author Byron Lanas (BL)
	*
	*/
    public function cargarCorreo($codigo,$rut)
	{
		try
		{    
			$detalles=array();
			$de=array();
			$resultado=array();

			$this->db->select('carta.COD_CORREO AS codigo');
			$this->db->select('ASUNTO AS asunto');
			$this->db->select('CUERPO_EMAIL AS cuerpo_email');
			$this->db->select('FECHA AS fecha');
			$this->db->select('HORA AS hora');
			$this->db->select('carta.RUT_USUARIO AS de');
			$this->db->from('carta');
			$this->db->join('cartar_user','cartar_user.COD_CORREO = carta.COD_CORREO');
			$this->db->where('carta.COD_CORREO',$codigo);
			$this->db->where('cartar_user.RUT_USUARIO',$rut);
			$query = $this->db->get();
			
			if ($query == FALSE) {
				return array();
			}
			$detalles= $query->result();
			foreach ($query->result() as $row)
			{
				$this->db->select('NOMBRE1_COORDINADOR AS nombre');
				$this->db->select('APELLIDO1_COORDINADOR AS apellido1');
				$this->db->select('APELLIDO2_COORDINADOR AS apellido2');
				$this->db->where('RUT_USUARIO3',$row->de);
				$query1 = $this->db->get('coordinador');

				$this->db->select('NOMBRE1_PROFESOR AS nombre');
				$this->db->select('APELLIDO1_PROFESOR AS apellido1');
				$this->db->select('APELLIDO2_PROFESOR AS apellido2');
				$this->db->where('RUT_USUARIO2',$row->de);
				$query2 = $this->db->get('profesor');

				if($query1->num_rows() > 0)
				{				
					foreach ($query1->result() as $row1)
					{
						$de=array();
					   	array_push($de, $row1);					   	
					   	$resultado=  array_merge($detalles,$de); 
					}	
				}
				else if($query2->num_rows() > 0)
				{
					foreach ($query2->result() as $row2)
					{
						$de=array();
					   	array_push($de, $row2);
					   	$resultado=  array_merge($detalles,$de);					   
					}	
				}
				
				
			}
			return $resultado;

		}
		catch(Exception $e)
		{
			return -1;
		}
	}
}
?>