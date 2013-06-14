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
	* param int $variable
	* return array $listaCompleta
	*
	* @author: Claudio Rojas (CR) y Diego Garc?a (DGM). 
	*/
	public function VerCorreosUser($variable,$offset)
	{
		try
		{
			/* Se obtienen todos los correos enviados por un usuario. */
			$sql="SELECT * FROM carta  WHERE rut_usuario='$variable' AND COD_BORRADOR IS NULL ORDER BY COD_CORREO DESC LIMIT $offset,5";
			$datos=mysql_query($sql);
			$listaCompleta=array();
			while($row=mysql_fetch_array($datos))
			{
				$lista = array();
				$correo = array();
				$correo['cod_correo']=$row['COD_CORREO'];
				$correo['rut_usuario']=$row['RUT_USUARIO'];
				$correo['id_plantilla']=$row['ID_PLANTILLA'];
				$correo['hora']=$row['HORA']; 
				$correo['fecha']=$row['FECHA'];
				$correo['cuerpo_email']=$row['CUERPO_EMAIL'];
				$correo['asunto']=$row['ASUNTO'];
				array_push($lista,$correo);
				
				/* Para cada correo se obtienen los destinatarios agrupados por categor?a. */
				$codigo=$row['COD_CORREO'];
				$sql1="SELECT RUT_ESTUDIANTE FROM cartar_estudiante WHERE COD_CORREO='$codigo'";
				$sql2="SELECT RUT_AYUDANTE FROM cartar_ayudante WHERE COD_CORREO='$codigo'";
				$sql3="SELECT RUT_USUARIO FROM cartar_user WHERE COD_CORREO='$codigo'";
				$rutDestinoEstudiantes=array();
				$rutDestinoAyudantes=array();
				$rutDestinoUsuarios=array();
				$datos1=mysql_query($sql1);
				while($row1=mysql_fetch_array($datos1))
					array_push($rutDestinoEstudiantes,$row1['RUT_ESTUDIANTE']);
				$datos2=mysql_query($sql2); 
				while($row2=mysql_fetch_array($datos2))
					array_push($rutDestinoAyudantes,$row2['RUT_AYUDANTE']);
				$datos3=mysql_query($sql3); 
				while($row3=mysql_fetch_array($datos3))
					array_push($rutDestinoUsuarios,$row3['RUT_USUARIO']);
				$estudiantes=array();
				
				/* Para cada destinatario estudiante del correo actual se obtienen los datos de
				del estudiante. */
				foreach($rutDestinoEstudiantes as $rutEstudiante)
				{
					$sqlEstudiante="SELECT * FROM estudiante WHERE RUT_ESTUDIANTE='$rutEstudiante'";
					$datosEstudiante=mysql_query($sqlEstudiante);
					while($rowDatosEstudiante=mysql_fetch_array($datosEstudiante))
					{
						$estudiante=array();
						$estudiante['rut_estudiante']=$rowDatosEstudiante['RUT_ESTUDIANTE'];
						$estudiante['cod_carrera']=$rowDatosEstudiante['COD_CARRERA'];
						$estudiante['cod_seccion']=$rowDatosEstudiante['COD_SECCION'];
						$estudiante['nombre1_estudiante']=$rowDatosEstudiante['NOMBRE1_ESTUDIANTE'];
						$estudiante['nombre2_estudiante']=$rowDatosEstudiante['NOMBRE2_ESTUDIANTE'];
						$estudiante['apellido_paterno']=$rowDatosEstudiante['APELLIDO1_ESTUDIANTE'];
						$estudiante['apellido_materno']=$rowDatosEstudiante['APELLIDO2_ESTUDIANTE'];
						$estudiante['correo_estudiante']=$rowDatosEstudiante['CORREO_ESTUDIANTE'];
						array_push($estudiantes,$estudiante);
					}
				}
				$ayudantes=array();
				
				/* Para cada destinatario ayudante del correo actual se obtienen los datos de
				del ayudante. */
				foreach($rutDestinoAyudantes as $rutAyudante)
				{
					$sqlAyudante="SELECT * FROM ayudante WHERE RUT_AYUDANTE='$rutAyudante'";
					$datosAyudante=mysql_query($sqlAyudante);
					while($rowDatosAyudante=mysql_fetch_array($datosAyudante))
					{
						$ayudante=array();
						$ayudante['rut_ayudante']=$rowDatosAyudante['RUT_AYUDANTE'];
						$ayudante['nombre1_ayudante']=$rowDatosAyudante['NOMBRE1_AYUDANTE'];
						$ayudante['nombre2_ayudante']=$rowDatosAyudante['NOMBRE2_AYUDANTE'];
						$ayudante['apellido_paterno']=$rowDatosAyudante['APELLIDO1_AYUDANTE'];
						$ayudante['apellido_materno']=$rowDatosAyudante['APELLIDO2_AYUDANTE'];
						$ayudante['correo_ayudante']=$rowDatosAyudante['CORREO_AYUDANTE'];
						array_push($ayudantes,$ayudante);
					}
				}
				$profesores=array();
				$coordinadores=array();
				
				/* Para cada destinatario profesor o coordinador del correo actual se obtienen los datos de
				del profesor o coordinador. */
				foreach($rutDestinoUsuarios as $rutUsuario)
				{
					$sqlProfesor="SELECT * FROM profesor WHERE RUT_USUARIO2='$rutUsuario'";
					$datosProfesor=mysql_query($sqlProfesor);

					while($rowDatosProfesor=mysql_fetch_array($datosProfesor))
					{
						$profesor=array();
						$profesor['rut_usuario2']=$rowDatosProfesor['RUT_USUARIO2'];
						$profesor['nombre1_profesor']=$rowDatosProfesor['NOMBRE1_PROFESOR'];
						$profesor['nombre2_profesor']=$rowDatosProfesor['NOMBRE2_PROFESOR'];
						$profesor['apellido1_profesor']=$rowDatosProfesor['APELLIDO1_PROFESOR'];
						$profesor['apellido2_profesor']=$rowDatosProfesor['APELLIDO2_PROFESOR'];
						$profesor['telefono_profesor']=$rowDatosProfesor['TELEFONO_PROFESOR'];
						$profesor['tipo_profesor']=$rowDatosProfesor['TIPO_PROFESOR'];
						array_push($profesores,$profesor);
					}
					$sqlCoordinador="SELECT * FROM coordinador WHERE RUT_USUARIO3='$rutUsuario'";
					$datosCoordinador=mysql_query($sqlCoordinador);
					while($rowDatosCoordinador=mysql_fetch_array($datosCoordinador))
					{
						$coordinador=array();
						$coordinador['rut_usuario3']=$rowDatosCoordinador['RUT_USUARIO3'];
						$coordinador['nombre1_coordinador']=$rowDatosCoordinador['NOMBRE1_COORDINADOR'];
						$coordinador['nombre2_coordinador']=$rowDatosCoordinador['NOMBRE2_COORDINADOR'];
						$coordinador['apellido1_coordinador']=$rowDatosCoordinador['APELLIDO1_COORDINADOR'];
						$coordinador['apellido2_coordinador']=$rowDatosCoordinador['APELLIDO2_COORDINADOR'];
						$coordinador['telefono_coordinador']=$rowDatosCoordinador['TELEFONO_COORDINADOR'];
						array_push($coordinadores,$coordinador);
					}
				}
				array_push($lista, $estudiantes);
				array_push($lista, $ayudantes);
				array_push($lista, $profesores);
				array_push($lista, $coordinadores);
				array_push($listaCompleta, $lista);
			}
			/* Se agrega la variable de estado 1 al array que ser? retornado. */
			array_unshift($listaCompleta,1);
			
			return $listaCompleta;
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
	* @return array $resultados
	* @author Diego Garc?a (DGM)
	*
	*/
	public function EliminarCorreo($correos)
	{
		$resultados1=array();
		$resultados2=array();
		$resultados3=array();
		$resultados4=array();
		$resultadosFinales=array();
		foreach($correos as $correo)
		{
			$sqlEliminarCorreoEstudiante="DELETE FROM cartar_estudiante WHERE COD_CORREO='$correo'";
			$resultados1[$correo][$resultado]=mysql_query($sqlEliminarCorreoEstudiante);
			$sqlEliminarCorreoAyudante="DELETE FROM cartar_ayudante WHERE COD_CORREO='$correo'";
			$resultados2[$correo][$resultado]=mysql_query($sqlEliminarCorreoAyudante);
			$sqlEliminarCorreoUsuario="DELETE FROM cartar_user WHERE COD_CORREO='$correo'";
			$resultados3[$correo][$resultado]=mysql_query($sqlEliminarCorreoUsuario);
			$sqlEliminarCorreo="DELETE FROM carta WHERE COD_CORREO='$correo'";
			$resultados4[$correo][$resultado]=mysql_query($sqlEliminarCorreo);
		}
		array_push($resultadosFinales,$resultados1);
		array_push($resultadosFinales,$resultados2);
		array_push($resultadosFinales,$resultados3);
		array_push($resultadosFinales,$resultados4);
		return $resultadosFinales;
	}
	
	/**
	* Elimina 1 o varios borradores de la base de datos de la aplicación.
	*
	* Para cada borrador se elimina los datos de dicho borrador en la
	* tabla carta.
	* En el array de entrada se especifican los identificadores de todos
	* los correos a eliminar.
	* En el array de salida se especifica el resultado de la consulta de
	* de la eliminaci?n para cada correo. 
	*
	* @param array $correos
	* @return array $resultados
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
				$this->db->update('carta',array('COD_BORRADOR' => NULL,'FECHA'=> date("Y-m-d"),'HORA'=>date("H:i:s")));
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
			$this->db->from('carta');
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
}
?>