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
class Model_correo extends CI_Model
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
			define("BUSCAR_POR_DESTINATARIO", 1); //Para
			define("BUSCAR_POR_MENSAJE", 2); //Mensaje
			define("BUSCAR_POR_FECHAHORA", 3);

			$consultasLikes = '1';
			if (trim($texto) != '') {
				$consultasLikes = "(ASUNTO LIKE '%".$texto."%' 
					OR CUERPO_EMAIL LIKE '%".$texto."%' 
					OR nombre_destinatario LIKE '%".$texto."%' 
					OR FECHA_HORA_CORREO LIKE '%".$texto."%')";
			}
			else {
				if ($textoFiltrosAvanzados[BUSCAR_POR_DESTINATARIO] != '') {
					$consultasLikes = "nombre_destinatario LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_DESTINATARIO]."%'";
				}
				if ($textoFiltrosAvanzados[BUSCAR_POR_MENSAJE] != '') {
					$consultasLikes = "(ASUNTO LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_MENSAJE]."%' 
						OR CUERPO_EMAIL LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_MENSAJE]."%')";
				}
				if ($textoFiltrosAvanzados[BUSCAR_POR_FECHAHORA] != '') {
					$consultasLikes = "FECHA_HORA_CORREO LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_FECHAHORA]."%'";

				}
			}

			$queryHorrible = "SELECT T.ID_CORREO AS codigo, GROUP_CONCAT(T.nombre_destinatario) AS nombre_destinatario, ASUNTO AS asunto, CUERPO_EMAIL AS cuerpo_email, FECHA_HORA_CORREO AS fechaHora, (select ID_ADJUNTO from adjunto where T.ID_CORREO=adjunto.ID_CORREO limit 1) AS adjuntos
			 FROM 
			(SELECT carta.*, GROUP_CONCAT( CONCAT(NOMBRE1, \" \", APELLIDO1, \" \", APELLIDO2)) AS nombre_destinatario
			FROM carta
			LEFT JOIN carta_usuario ON carta_usuario.ID_CORREO = carta.ID_CORREO
			LEFT JOIN usuario ON usuario.RUT_USUARIO = carta_usuario.RUT_USUARIO
			WHERE carta.RUT_USUARIO = $rut
			AND ID_BORRADOR IS NULL
			AND ENVIADO_CARTA = TRUE
			GROUP BY carta.ID_CORREO )
			 AS T
			
			WHERE $consultasLikes

			GROUP BY T.ID_CORREO
			ORDER BY T.ID_CORREO DESC
			LIMIT $offset, 20"; //NIKAGANDO LA HAGO EN ACTIVERECORD!!!


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

			$this->db->where('ID_CORREO',$correo);
			$this->db->update('carta', array('ENVIADO_CARTA' => 0));


		}

	}
	/**
	* Elimina 1 o varios correos recibidos de la base de datos de la aplicación.
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
			$this->db->where('ID_CORREO',$correo);
			$this->db->where('RUT_USUARIO',$rut);
			$this->db->update('carta_user',array('RECIBIDA_CARTA_USUARIO' => 0));
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

			$this->db->select('ID_CORREO');
			$this->db->where('ID_BORRADOR', $correo); 
			//$this->db->order_by("COD2_CORREO", "desc"); 
			$this->db->limit(1);
			$query = $this->db->get('carta');
			
			
			foreach ($query->result() as $row)
			{
			   $cod= $row->ID_CORREO;
			}
			$this->db->where('ID_BORRADOR',$correo);
			$this->db->update('carta',array('ID_BORRADOR' => NULL));
			$this->db->delete('borrador', array('ID_BORRADOR' => $correo));
			$this->db->delete('carta_usuario', array('ID_CORREO' => $cod)); 
			$this->db->delete('carta', array('ID_CORREO' => $cod)); 
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
			//Constantes para facilitar saber que tipo de búsqueda se utiliza (El indice 0 no se usa en las búsquedas de correo, porque se usa para el checkbox)
			define("BUSCAR_POR_REMITENTE", 1); //De
			define("BUSCAR_POR_MENSAJE", 2); //Mensaje o asunto
			define("BUSCAR_POR_FECHAHORA", 3);

			$consultasLikes = "1";
			if (trim($texto) != '') {
				$consultasLikes = "(ASUNTO LIKE '%".$texto."%' OR CUERPO_EMAIL LIKE '%".$texto."%' OR NOMBRE1 LIKE '%".$texto."%' OR APELLIDO1 LIKE '%".$texto."%' OR APELLIDO2 LIKE '%".$texto."%' OR FECHA_HORA_CORREO LIKE '%".$texto."%')";
			}
			else {
				if ($textoFiltrosAvanzados[BUSCAR_POR_REMITENTE] != '') {
					$consultasLikes = "(NOMBRE1 LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_REMITENTE]."%'
						OR APELLIDO1 LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_REMITENTE]."%'
						OR APELLIDO2 LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_REMITENTE]."%')";
				}
				if ($textoFiltrosAvanzados[BUSCAR_POR_MENSAJE] != '') {
					$consultasLikes = "(ASUNTO LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_MENSAJE]."%' 
						OR CUERPO_EMAIL LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_MENSAJE]."%')";
				}
				if ($textoFiltrosAvanzados[BUSCAR_POR_FECHAHORA] != '') {
					$consultasLikes = "FECHA_HORA_CORREO LIKE '%".$textoFiltrosAvanzados[BUSCAR_POR_FECHA]."%'";

				}
			}

			$queryDeMierda = "SELECT carta.ID_CORREO AS codigo, NOMBRE1 AS nombre, APELLIDO1 AS apellido1, 
							APELLIDO2 AS apellido2, NO_LEIDA_CARTA_USUARIO AS no_leido, ASUNTO AS asunto, 
							CUERPO_EMAIL AS cuerpo_email, FECHA_HORA_CORREO AS fechaHora , 
							(select ID_ADJUNTO from adjunto where carta.ID_CORREO=adjunto.ID_CORREO limit 1) AS adjuntos
							FROM carta
							JOIN carta_usuario ON carta_usuario.ID_CORREO = carta.ID_CORREO
							JOIN usuario ON usuario.RUT_USUARIO = carta_usuario.RUT_USUARIO
							WHERE usuario.RUT_USUARIO = $rut
							AND ID_BORRADOR IS NULL
							AND RECIBIDA_CARTA_USUARIO = 1
							AND $consultasLikes

							ORDER BY T.ID_CORREO DESC
							LIMIT $offset, 20";
			$query = $this->db->query($queryDeMierda);
			//echo $this->db->last_query().'   ';return;
			if ($query == FALSE) {
				return array();
			}
			return $query->result_array();
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
	public function InsertarCorreo($asunto,$mensaje,$rut,$codCorreo,$rutRecept,$codigoBorrador,$adjuntos)
	{
		try
		{  $cod = ""; //En caso que no se defina
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
				$this->db->select('ID_CORREO');
				$this->db->where('COD2_CORREO', $codCorreo); 
				//$this->db->order_by("COD2_CORREO", "desc"); 
				$this->db->limit(1);
				$query = $this->db->get('carta');
				 $e = $this->db->_error_message(); 
				
				foreach ($query->result() as $row)
				{
				    $cod= $row->ID_CORREO;
				}
				$this->db->insert('carta', $this);

				$this->db->delete('adjunto', array('ID_CORREO' => $cod));

				if($adjuntos!="")
				foreach ($adjuntos as $adjunto) {
					$data = array(
				   
					   	'NOMBRE_LOGICO_ADJUNTO' => $adjunto[0] ,
					   	'NOMBRE_FISICO_ADJUNTO' => $adjunto[1] ,
					   	'ID_CORREO' => $cod,
					);

					$this->db->insert('adjunto', $data);
				}

				$this->db->_error_message(); 
				return 1;
			}else
			{

				$this->db->select('ID_CORREO');
				$this->db->where('COD_BORRADOR', $codigoBorrador); 
				//$this->db->order_by("COD2_CORREO", "desc"); 
				$this->db->limit(1);
				$query = $this->db->get('carta');
				
				
				foreach ($query->result() as $row)
				{
				   $cod= $row->ID_CORREO;
				}

				$this->db->delete('adjunto', array('ID_CORREO' => $cod));

				if($adjuntos!="")
				foreach ($adjuntos as $adjunto) {
					$data = array(
				   
					   	'NOMBRE_LOGICO_ADJUNTO' => $adjunto[0] ,
					   	'NOMBRE_FISICO_ADJUNTO' => $adjunto[1] ,
					   	'ID_CORREO' => $cod,
					);

					$this->db->insert('adjunto', $data);
				}

				$this->db->delete('cartar_ayudante', array('ID_CORREO' => $cod)); 
				$this->db->delete('cartar_estudiante', array('ID_CORREO' => $cod)); 
				$this->db->delete('cartar_user', array('ID_CORREO' => $cod)); 

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
	public function insertarBorrador($asunto,$mensaje,$rut,$codCorreo,$rutRecept,$codigoBorrador,$adjuntos)
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
			$this->db->select('ID_CORREO');
			$this->db->where('COD2_CORREO', $codCorreo); 
			//$this->db->order_by("COD2_CORREO", "desc"); 
			$this->db->limit(1);
			$query = $this->db->get('carta');
			
			
			foreach ($query->result() as $row)
			{
			   $cod= $row->ID_CORREO;
			}
			$data = array(
				   
				   'ID_CORREO' => $cod ,
				   'FECHA_BORRADOR' => date("Y-m-d") ,
				   'HORA_BORRADOR' => date("H:i:s"),
				);

			$this->db->insert('borrador', $data);

			$this->db->select('COD_BORRADOR');
			$this->db->where('ID_CORREO', $cod);
			$query2 = $this->db->get('borrador'); 
			foreach ($query2->result() as $row)
			{
				
				$this->db->set('COD_BORRADOR',$row->COD_BORRADOR);
				$this->db->where('ID_CORREO', $cod);
				$this->db->update('carta');
				return $row->COD_BORRADOR;
			    
			}
			

				$this->db->delete('adjunto', array('ID_CORREO' => $cod)); 				
				if($adjuntos!=""){
					$this->db->delete('adjunto', array('ID_CORREO' => $cod));
					foreach ($adjuntos as $adjunto) {
						$data = array(
					   
						   	'NOMBRE_LOGICO_ADJUNTO' => $adjunto[0] ,
						   	'NOMBRE_FISICO_ADJUNTO' => $adjunto[1] ,
						   	'ID_CORREO' => $cod,
						);

					$this->db->insert('adjunto', $data);
				} 	
				}

				
			}else
			{

				$this->db->select('ID_CORREO');
				$this->db->where('COD_BORRADOR', $codigoBorrador); 
				//$this->db->order_by("COD2_CORREO", "desc"); 
				$this->db->limit(1);
				$query = $this->db->get('carta');
				
				
				foreach ($query->result() as $row)
				{
				   $cod= $row->ID_CORREO;
				}
				$this->db->delete('cartar_ayudante', array('ID_CORREO' => $cod)); 
				$this->db->delete('cartar_estudiante', array('ID_CORREO' => $cod)); 
				$this->db->delete('cartar_user', array('ID_CORREO' => $cod)); 

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
				$this->db->delete('adjunto', array('ID_CORREO' => $cod)); 				

				if($adjuntos!="")
				foreach ($adjuntos as $adjunto) {
					$data = array(
				   
					   	'NOMBRE_LOGICO_ADJUNTO' => $adjunto[0] ,
					   	'NOMBRE_FISICO_ADJUNTO' => $adjunto[1] ,
					   	'ID_CORREO' => $cod,
					);

					$this->db->insert('adjunto', $data);
				}
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
				$this->db->select('ID_CORREO');
				$this->db->where('ID2_CORREO', $codCorreo); 
				//$this->db->order_by("ID2_CORREO", "desc"); 
				$this->db->limit(1);
				$query = $this->db->get('carta');
				 $e = $this->db->_error_message(); 
				
				foreach ($query->result() as $row)
				{
				    return $row->ID_CORREO;
				}
			}
			else{
				$this->db->select('ID_CORREO');
				$this->db->where('ID_BORRADOR', $codigoBorrador); 
				//$this->db->order_by("ID2_CORREO", "desc"); 
				$this->db->limit(1);
				$query = $this->db->get('carta');
				$e = $this->db->_error_message(); 
				
				foreach ($query->result() as $row)
				{
				    return $row->ID_CORREO;
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
			$this->db->where('RUT_USUARIO', $rut);
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
			$this->db->where('RUT_USUARIO', $rut);
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
			$this->db->select('COUNT(carta.ID_CORREO) AS resultado');
			$this->db->where('RUT_USUARIO', $rut);
			$this->db->where('ID_BORRADOR IS NULL');
			$this->db->where('ENVIADO_CARTA', TRUE);
			$query = $this->db->get('carta');
			$res = $query->row();
			return $res->resultado;
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
			$this->db->select('COUNT(carta.ID_CORREO) AS resultado');
			$this->db->where('carta_usuario.RUT_USUARIO', $rut);
			$this->db->where('ID_BORRADOR IS NULL');
			$this->db->where('RECIBIDA_CARTA_USUARIO',1);
			$this->db->join('carta_usuario','carta.ID_CORREO = carta_usuario.ID_CORREO');
			$query = $this->db->get('carta');
			$res = $query->row();
			return $res->resultado;
		}
		catch(Exception $e)
		{
			return -1;
		}
    }

    /**
	* Obtiene la cantidad de correos recibidos por el usuario y que no han sido leidos
	*
	* @param int $rut
	* @return int
	* @author Víctor Flores
	*
	*/
    public function cantidadRecibidosNoLeidos($rut)
	{
		try
		{
			$this->db->select('COUNT(carta.ID_CORREO) AS resultado');
			$this->db->join('carta_usuario','carta.ID_CORREO = carta_usuario.ID_CORREO');
			$this->db->where('carta_usuario.RUT_USUARIO', $rut);
			$this->db->where('ID_BORRADOR IS NULL');
			$this->db->where('RECIBIDA_CARTA_USUARIO', TRUE);
			$this->db->where('NO_LEIDA_CARTA_USUARIO', TRUE);
			$query = $this->db->get('carta');
			$res = $query->row();
			return $res->resultado;
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
			$this->db->select('COUNT(carta.ID_CORREO) AS resultado');
			$this->db->where('RUT_USUARIO', $rut);
			$this->db->where('ID_BORRADOR IS NOT NULL');
			$query = $this->db->get('carta');
			$res = $query->row();
			return $res->resultado;
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
			$this->db->select('(select COD_ADJUNTO from adjunto where borrador.ID_CORREO=adjunto.ID_CORREO limit 1)AS adjuntos');
			
			$this->db->join('borrador','carta.COD_BORRADOR = borrador.COD_BORRADOR');
			$this->db->where('RUT_USUARIO',$rut);
			$this->db->order_by("borrador.COD_BORRADOR", "desc"); 
			$this->db->limit( 20,$offset);
			$query = $this->db->get('carta');
			
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
	
	public function getAdjuntos($codigo)
	{
		try
		{
			$this->db->select('ID_ADJUNTO AS codAdjunto');
			$this->db->select('ID_CORREO');
			$this->db->select('NOMBRE_LOGICO_ADJ AS logico');
			$this->db->select('NOMBRE_FISICO_ADJ AS fisico');
			$this->db->where('ID_CORREO', $codigo);
			$query = $this->db->get('adjunto');
			if ($query == FALSE) {
				return array();
			}
			return $query->result();
		}
		catch(Exception $e)
		{
			return array();
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

			$this->db->select('ID_CORREO');
			$this->db->where('COD_BORRADOR', $codigo); 
			//$this->db->order_by("COD2_CORREO", "desc"); 
			$this->db->limit(1);
			$query = $this->db->get('carta');
			 $e = $this->db->_error_message(); 
			
			foreach ($query->result() as $row)
			{
			    $cod= $row->ID_CORREO;
			}
			$this->db->select('RUT_ESTUDIANTE AS rutRecept');
			$this->db->from('cartar_estudiante');
			$this->db->where('ID_CORREO',$cod);
			$query = $this->db->get();
			if ($query == FALSE) {
				return array();
			}
			$rutEst=$query->result();

			$rutAyu=array();
			$this->db->select('RUT_AYUDANTE AS rutRecept');
			$this->db->from('cartar_ayudante');
			$this->db->where('ID_CORREO',$cod);
			$query = $this->db->get();
			if ($query == FALSE) {
				return array();
			}
			$rutAyu=$query->result();

			$rutUser=array();
			$this->db->select('RUT_USUARIO AS rutRecept');
			$this->db->from('cartar_user');
			$this->db->where('ID_CORREO',$cod);
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
			$this->db->where('ID_CORREO',$cod);
			$query = $this->db->get();
			if ($query == FALSE) {
				return array();
			}
			$correoEst=$query->result();

			$correoAyu=array();

			$this->db->select('CORREO_AYUDANTE AS correo');
			$this->db->from('ayudante');
			$this->db->join('cartar_ayudante','cartar_ayudante.RUT_AYUDANTE = ayudante.RUT_AYUDANTE');
			$this->db->where('ID_CORREO',$cod);
			$query = $this->db->get();
			if ($query == FALSE) {
				return array();
			}
			$correoAyu=$query->result();

			
			
			$correoUser=array();

			$this->db->select('CORREO1_USER AS correo');
			$this->db->from('usuario');
			$this->db->join('cartar_user','cartar_user.RUT_USUARIO = usuario.RUT_USUARIO');
			$this->db->where('ID_CORREO',$cod);
			$query = $this->db->get();
			if ($query == FALSE) {
				return array();
			}
			$correoUser=$query->result();
			$correoRecept=array_merge($correoEst,$correoAyu,$correoUser);
			array_push($resultado, $correoRecept);

			$adjuntos=array();
			$this->db->select('NOMBRE_LOGICO_ADJUNTO as logico');
			$this->db->select('NOMBRE_FISICO_ADJUNTO as fisico');
			$this->db->from('adjunto');
			$this->db->where('ID_CORREO',$cod);
			$query = $this->db->get();
			if ($query == FALSE) {
				return array();
			}
			$adjuntos=$query->result();
			array_push($resultado, $adjuntos);
			return $resultado;

		}
		catch(Exception $e)
		{
			return -1;
		}
    }


    /**
	* Devuelve los datos del correo a ver en su contexto
	*
	* @param int $codigo
	* @param int $rut
	* @return array
	* @author Byron Lanas (BL)
	*
	*/
    public function cargarCorreo($codigo, $rut)
	{
		try
		{    
			$this->db->where('RUT_USUARIO', $rut);
			$this->db->where('ID_CORREO', $codigo);
			$this->db->update('carta_usuario', array('NO_LEIDO_CARTA_USER' => FALSE));


			$this->db->select('carta.ID_CORREO AS codigo');
			$this->db->select('ASUNTO AS asunto');
			$this->db->select('CUERPO_EMAIL AS cuerpo_email');
			$this->db->select('FECHA_HORA_CORREO AS fechaHora');
			$this->db->select('carta.RUT_USUARIO AS de');
			$this->db->select('NOMBRE1 AS nombre');
			$this->db->select('APELLIDO1 AS apellido1');
			$this->db->select('APELLIDO2 AS apellido2');
			$this->db->join('carta_usuario','carta_usuario.ID_CORREO = carta.ID_CORREO');
			$this->db->join('usuario','usuario.RUT_USUARIO = carta_usuario.RUT_USUARIO');
			$this->db->where('carta.ID_CORREO',$codigo);
			$this->db->where('carta_usuario.RUT_USUARIO',$rut);
			$query = $this->db->get('carta');
			
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
	* Marca el correo seleccionado como leído
	*
	* @param int $codigo
	* @param int $rut
	* @return boolean
	* @author Byron Lanas (BL)
	*
	*/
    public function marcarLeido($rut,$codigo)
	{
		try
		{    
			$this->db->where('ID_CORREO',$codigo);
			$this->db->where('RUT_USUARIO',$rut);
			$this->db->update('carta_usuario',array('NO_LEIDA_CARTA_USUARIO' => 0));
			return true;

		}
		catch(Exception $e)
		{
			return false;
		}
	}
}
?>