<?php
 
class Model_actividades_masivas extends CI_Model {
 
	public function agregarActividadMasiva($nombre, $instancias) {
		$this->db->trans_start();

		//0 insertar modulo
		$data = array(
				'NOMBRE_ACT' => $nombre
				);
		$confirmacion0 = $this->db->insert('actividad_masiva', $data);
		
		$id_actividad = $this->db->insert_id();
		
		//4 insertar equipo profesores
		if (is_array($instancias)) {
			foreach($instancias as $instancia) {
				$data = array(
					'FECHA_ACT' => $instancia->fecha,
					'LUGAR_ACT' => $instancia->lugar,
					'ID_ACT' => $id_actividad
					);
				$datos = $this->db->insert('instancia_actividad_masiva', $data);
			}
		}
		//fin inserciones
		
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			return FALSE;
		}
		else{
			return TRUE;
		}
	}
	

	public function eliminarActividadMasiva($id_actividad) {

		$this->db->trans_start();

		//Elimino el módulo temático
		$this->db->where('ID_ACT', $id_actividad);
		$datos = $this->db->delete('actividad_masiva');

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			return FALSE;
		}
		else{
			return TRUE;
		}
    }

    
	public function getAllActividadesMasivas()
	{
		$this->db->select('ID_ACT AS id');
		$this->db->select('NOMBRE_ACT AS nombre');
		$this->db->order_by('NOMBRE_ACT','asc');
		$query = $this->db->get('actividad_masiva');
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}


	public function getInstanciasActividadMasiva($id_actividad) {
		$this->db->select('FECHA_ACT AS fecha');
		$this->db->select('LUGAR_ACT AS lugar');
		$this->db->select('ID_INSTANCIA_ACTIVIDAD_MASIVA AS id');
		$this->db->where('ID_ACT', $id_actividad);
		$query = $this->db->get('instancia_actividad_masiva');
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}
	
	public function getActividadesByFilter($texto, $textoFiltrosAvanzados) {
		$this->db->select('NOMBRE_ACT AS nombre');
		$this->db->select('ID_ACT AS id');
		$this->db->order_by('NOMBRE_ACT', 'asc');

		if ($texto != "") {
			$this->db->where("(NOMBRE_ACT LIKE '%".$texto."%')");
		}
		else {
			//Sólo para acordarse
			define("BUSCAR_POR_NOMBRE", 0);
			$this->db->like("NOMBRE_ACT", $textoFiltrosAvanzados[BUSCAR_POR_NOMBRE]); //(inutil ya que existe sólo un campo de búsqueda)
		}
		$query = $this->db->get('actividad_masiva');
		//echo $this->db->last_query();
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}

/*
	public function getInstanciasActividadesMasivas() {
		$this->db->select('NOMBRE_ACT AS nombre');
		$this->db->select('FECHA_ACT AS fecha');
		$this->db->select('LUGAR_ACT AS lugar');
		$this->db->select('instancia_actividad_masiva.ID_INSTANCIA_ACTIVIDAD_MASIVA AS id');
		$this->db->join('actividad_masiva', 'instancia_actividad_masiva.ID_ACT = actividad_masiva.ID_ACT');
		$query = $this->db->get('instancia_actividad_masiva');
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}
	*/

	public function getAsistenciasAndComentariosEstudiante($rut_estudiante) {
		$this->db->select('PRESENTE_ASIST_EVENTO AS presente');
		$this->db->select('COMENTARIO_ASIST_EVENTO AS comentario');
		$this->db->select('asistencia_actividad.RUT_USUARIO AS rut');
		$this->db->select('actividad_masiva.ID_ACT AS id');
		$this->db->join('instancia_actividad_masiva', 'actividad_masiva.ID_ACT = instancia_actividad_masiva.ID_ACT');
		$this->db->join('asistencia_actividad', 'instancia_actividad_masiva.ID_INSTANCIA_ACTIVIDAD_MASIVA = asistencia_actividad.ID_INSTANCIA_ACTIVIDAD_MASIVA');
		$this->db->where('asistencia_actividad.RUT_USUARIO', $rut_estudiante);
		$query = $this->db->get('actividad_masiva');
		if ($query == FALSE) {
			return array();
		}
		return $query->result();

	}

	public function getAsistenciaEstudiante($rut_estudiante) {
		$this->db->select('PRESENTE_ASIST_EVENTO AS presente');
		$this->db->select('asistencia_actividad.RUT_USUARIO AS rut');
		$this->db->select('actividad_masiva.ID_ACT AS id');
		$this->db->join('instancia_actividad_masiva', 'actividad_masiva.ID_ACT = instancia_actividad_masiva.ID_ACT');
		$this->db->join('asistencia_actividad', 'instancia_actividad_masiva.ID_INSTANCIA_ACTIVIDAD_MASIVA = asistencia_actividad.ID_INSTANCIA_ACTIVIDAD_MASIVA');
		$this->db->where('asistencia_actividad.RUT_USUARIO', $rut_estudiante);
		$query = $this->db->get('actividad_masiva');
		if ($query == FALSE) {
			return array();
		}
		return $query->result();

	}

	public function getComentariosAsistenciaEstudiante($rut_estudiante) {
		$this->db->select('COMENTARIO_ASIST_EVENTO AS comentario');
		$this->db->select('asistencia_actividad.RUT_USUARIO AS rut');
		$this->db->select('actividad_masiva.ID_ACT AS id');
		$this->db->join('instancia_actividad_masiva', 'actividad_masiva.ID_ACT = instancia_actividad_masiva.ID_ACT');
		$this->db->join('asistencia_actividad', 'instancia_actividad_masiva.ID_INSTANCIA_ACTIVIDAD_MASIVA = asistencia_actividad.ID_INSTANCIA_ACTIVIDAD_MASIVA');
		$this->db->where('asistencia_actividad.RUT_USUARIO', $rut_estudiante);
		$query = $this->db->get('actividad_masiva');
		if ($query == FALSE) {
			return array();
		}
		return $query->result();

	}

	public function getEventosConInstancias() {
		$this->db->select('NOMBRE_ACT AS nombre');
		$this->db->select('FECHA_ACT AS fecha');
		$this->db->select('LUGAR_ACT AS lugar');
		$this->db->select('actividad_masiva.ID_ACT AS id');
		$this->db->join('instancia_actividad_masiva', 'actividad_masiva.ID_ACT = instancia_actividad_masiva.ID_ACT');
		$this->db->group_by('actividad_masiva.ID_ACT');
		$this->db->order_by('actividad_masiva.ID_ACT');
		$query = $this->db->get('actividad_masiva');
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}
	
	public function agregarAsistencia($rut_profesor, $rut, $asistio, $justificado, $comentario, $id_actividad) {
		//POR AHORA LOS ESTUDIANTES DA LO MISMO A CUAL INSTANCIA DE ACTIVIDAD MASIVA VAN, SE CONSIDERA SÓLO LA PRIMERA
		$this->db->trans_start();

		$this->db->select('PRESENTE_ASIST_EVENTO');
		$this->db->select('JUSTIFICADO_ASIST_EVENTO');
		$this->db->select('COMENTARIO_ASIST_EVENTO');
		$this->db->select('instancia_actividad_masiva.ID_INSTANCIA_ACTIVIDAD_MASIVA AS id_instancia');
		$this->db->join('instancia_actividad_masiva', 'asistencia_actividad.ID_INSTANCIA_ACTIVIDAD_MASIVA = instancia_actividad_masiva.ID_INSTANCIA_ACTIVIDAD_MASIVA');
		$this->db->where('RUT_USUARIO', $rut);
		$this->db->where('instancia_actividad_masiva.ID_ACT', $id_actividad);
		$primeraResp = $this->db->get('asistencia_actividad');
		//echo $this->db->last_query().'    ';
		if ($primeraResp == FALSE) {
			$this->db->trans_complete();
			return FALSE;
		}
		if ($primeraResp->num_rows() > 0) {
			//Se intenta updatear si es que existe esa asistencia
			$row_original = $primeraResp->row();
			$id_primera_instancia = $row_original->id_instancia; 

			$this->db->flush_cache();
			if ($comentario === NULL) {
				$data1 = array('PRESENTE_ASIST_EVENTO' => $asistio, 
					'JUSTIFICADO_ASIST_EVENTO' => $justificado);
			}
			else {
				$data1 = array('PRESENTE_ASIST_EVENTO' => $asistio, 
					'JUSTIFICADO_ASIST_EVENTO' => $justificado, 
					'COMENTARIO_ASIST_EVENTO' => $comentario);
			}

			$this->db->where('RUT_USUARIO', $rut);
			$this->db->where('asistencia_actividad.ID_INSTANCIA_ACTIVIDAD_MASIVA', $id_primera_instancia);
			$this->db->update('asistencia_actividad', $data1);

			//Si hubo cambios, entonces hago insert en auditoría
			if ($this->db->affected_rows() > 0) {
				$asistioOri = $row_original->PRESENTE_ASIST_EVENTO;
				$justificadoOri = $row_original->JUSTIFICADO_ASIST_EVENTO;
				$comentarioOri = $row_original->COMENTARIO_ASIST_EVENTO;
				$datos_auditoria = array('RUT_USUARIO' => $rut_profesor, 
					'NOMBRE' => 'UPDATE', 
					'DATO_PRE_CAMBIO' => 'PRESENTE_ASIST_EVENTO=`'.$asistioOri.'`, '.'JUSTIFICADO_ASIST_EVENTO=`'.$justificadoOri.'`, '.'COMENTARIO_ASIST_EVENTO=`'.$comentarioOri.'`', 
					'DATO_POST_CAMBIO' => 'PRESENTE_ASIST_EVENTO=`'.$asistio.'`, '.'JUSTIFICADO_ASIST_EVENTO=`'.$justificado.'`, '.'COMENTARIO_ASIST_EVENTO=`'.$comentario.'`', 
					'TABLA_MODIFICADA'=> 'asistencia_actividad', 
					'QUERY'=> $this->db->last_query());
				$this->db->flush_cache();
				$this->db->insert('auditoria', $datos_auditoria);
			}
		}
		else {
			$this->db->flush_cache();
			//Se obtiene el id de la primera instancia disposible de la actividad masiva
			$this->db->select('instancia_actividad_masiva.ID_INSTANCIA_ACTIVIDAD_MASIVA AS id_instancia');
			$this->db->where('instancia_actividad_masiva.ID_ACT', $id_actividad);
			$primeraResp = $this->db->get('instancia_actividad_masiva');
			//echo $this->db->last_query().'    ';
			if ($primeraResp == FALSE) {
				$this->db->trans_complete();
				return FALSE;
			}
			$id_primera_instancia = NULL;
			if ($primeraResp->num_rows() > 0) {
				//Se intenta updatear si es que existe esa asistencia
				$row1 = $primeraResp->row();
				$id_primera_instancia = $row1->id_instancia; 
			}
			else {
				//NO SE ENCONTRÓ INSTANCIA PARA LA ACTIVIDAD MASIVA
				$this->db->trans_rollback();
				return FALSE;
			}
			
			//Se intenta insertar si no existe registro
			$this->db->flush_cache();
			$data2 = array('RUT_USUARIO' => $rut, 
				'ID_INSTANCIA_ACTIVIDAD_MASIVA' => $id_primera_instancia,
				'PRESENTE_ASIST_EVENTO' => $asistio, 
				'JUSTIFICADO_ASIST_EVENTO' => $justificado, 
				'COMENTARIO_ASIST_EVENTO' => $comentario);
			$this->db->insert('asistencia_actividad', $data2);

			$datos_auditoria = array('RUT_USUARIO' => $rut_profesor, 
					'NOMBRE' => 'INSERT', 
					'DATO_PRE_CAMBIO' => NULL,
					'DATO_POST_CAMBIO' => 'PRESENTE_ASIST_EVENTO=`'.$asistio.'`, '.'JUSTIFICADO_ASIST_EVENTO=`'.$justificado.'`, '.'COMENTARIO_ASIST_EVENTO=`'.$comentario.'`', 
					'TABLA_MODIFICADA'=> 'asistencia_actividad', 
					'QUERY'=> $this->db->last_query());
			$this->db->flush_cache();
			$this->db->insert('auditoria', $datos_auditoria);
			//echo $this->db->last_query().'    ';
		}

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			return FALSE;
		}
		else{
			return TRUE;
		}
	}

	public function getActividadesBySeccionAndProfesorForAsistencia($id_seccion, $rut_profesor, $esCoordinador, $modulosTematicosEnQueEsLider, $mostrarTodas) {
		return $this->getEventosConInstancias(); //A futuro se hará algún filtrado según profesor
	}

	public function cargaMasiva($archivo, $rutProfesor, $esCoordinador){

		if(!file_exists($archivo) || !is_readable($archivo)) {
			return FALSE;
		}

		$ff = fopen($archivo, "r");

		$header = array();
		$revisandoHeader = FALSE;
		$data = array();		
		$splitArray = array();
		$stack  = array();
		$c = 1;
		$flag = FALSE;
		while(($linea = fgets($ff)) !== FALSE) {

			//Se comprueba la cabecera del archivo, es decir, los nombres de las columnas
			if(!$revisandoHeader) { //Si está vacio
				$header = explode(';',trim($linea));
				if (count($header) <= 5) { //CANTIDAD DE COLUMNAS DEBE SER MAYOR A 5
					$header[] = "<br>La cantidad de elementos de la cabecera no es válida".count($header);
					$stack[$c] = $header;
					fclose($ff);
					unlink($archivo);
					return $stack;
				}
				if((strcmp($header[1], 'RUT') != 0) || (strcmp($header[2], 'PATERNO') != 0) || (strcmp($header[3], 'MATERNO') != 0) || (strcmp($header[4], 'NOMBRES') != 0)) {
					$header[] = "<br>La cabecera del archivo no es válida";
					$stack[$c] = $header;
					fclose($ff);
					unlink($archivo);
					return $stack;
				}
				$revisandoHeader = TRUE;
			}
			else { //Ahora que la cabecera está bien, se revisa el cuerpo
				$linea =  explode(';',$linea);
				if(($data = array_combine($header, $linea)) == FALSE) { //DEBE TENER EL MISMO LARGO QUE EL HEADER
					$linea[] = "<br>El numero de argumentos en la linea es incorrecto";
					$stack[$c] = $linea;
					fclose($ff);
					unlink($archivo);
					return $stack;
				}
				$data['RUT'] =  preg_replace('[\-]','',$data['RUT']); //Quito los guiones
				$data['RUT'] =  preg_replace('[\.]','',$data['RUT']); //Quito los puntos
				$validador = TRUE;//$this->validarDatos($data['RUT'],"rut");
				if(!$validador) {
					$linea[] = "<br>El rut del estudiante tiene caracteres no válidos";
					$stack[$c] = $linea;
					fclose($ff);
					unlink($archivo);
					return $stack;
				}
				/*
				$validador = $this->rutExiste($data['RUT']);
				if($validador == -1) {
					$linea[] = "<br>El rut de estudiante no existe en manteka";
					$stack[$c] = $linea;
					fclose($ff);
					unlink($archivo);
					return $stack;
				}
				*/
				$flag = TRUE;

			}
			$c++;
		}
		fclose($ff);
		$ffa = fopen($archivo, "r");

		//AHORA REALMENTE ABRO EL ARCHIVO PARA INSERTAR LUEGO QUE SE COMPROBÓ QUE TODO ESTÁ OK
		$header = array();
		$hayErrores = FALSE;
		$saltarEstudiante = FALSE;
		if ($flag) {
			while(($linea = fgets($ffa)) !== FALSE) {
				if(!$header) {
					$header = explode(';', trim($linea));
				}
				else {
					$hayErrores = FALSE;
					$this->db->trans_start();

					$linea =  explode(';', $linea);
					$data = array_combine($header, $linea);
					//Trimeo todos los elementos
					foreach ($data as $key => $value) {
						$data[$key] = trim($value);
					}

					//Hago un insert o update por cada actividad masiva
					$cantidadColumnas = count($header);
					$saltarEstudiante = FALSE;
					for($i = 5; $i < $cantidadColumnas; $i=$i+1) {
						if ($saltarEstudiante) {
							break;
						}
						if ($data['RUT'] !== "") {
							$data['RUT'] =  preg_replace('[\-]', '', $data['RUT']);
							$data['RUT'] =  preg_replace('[\.]', '', $data['RUT']);
						}

						$nombreActividad = $header[$i];
						$nombreActividad = strtoupper($nombreActividad);

						$id_seccion = $this->findSeccionByEstudiante($data['RUT']);
						if ($id_seccion == -1) {
							$linea[] = "<br>El estudiante no tiene sección asignada en el sistema";
							//$stack[count($stack)] = $linea;
							$hayErrores = TRUE;
							$saltarEstudiante = TRUE; //No se intenta insertar las demás fechas de asistencia para ese estudiante
							continue;
						}
						if ($id_seccion == NULL) {
							$linea[] = "<br>El estudiante no está registrado en el sistema";
							//$stack[count($stack)] = $linea;
							$hayErrores = TRUE;
							$saltarEstudiante = TRUE; //No se intenta insertar las demás fechas de asistencia para ese estudiante
							continue;
						}
						
						$id_actividad = $this->findIdActividadByNombre($nombreActividad);
						if ($id_actividad == NULL) {
							$linea[] = "<br>No se ha encontrado una instancia de la actividad : ".$nombreActividad;
							//$stack[count($stack)] = $linea;
							$hayErrores = TRUE;
							continue;
						}

						if ($data[$nombreActividad] !== "") { //Los blancos no se agregan, ni se modifican
							$asistio = $data[$nombreActividad];
							if (preg_match ('/^[0]|[1]$/' , $asistio)) {
								//echo 'es válido:'.$asistio.'  ';
								//echo ' Rut: '.$data['RUT'].' asistió: '.$asistio.' id_seccion: '.$id_seccion.' id_instancia_actividad: '.$id_instancia_actividad.'         ';
								if ($esCoordinador) {
									$this->agregarAsistencia($rutProfesor, $data['RUT'], $asistio, NULL, NULL, $id_actividad);
								}
								else {
									//echo ' mal ';
									$linea[] = "<br>No tiene permisos para poner la asistencia al estudiante";
									//$stack[count($stack)] = $linea;
									$hayErrores = TRUE;
									continue;
								}
							}
							else {
								//echo 'No es válido:'.$asistio.'  ';
								$linea[] = "<br>El formato de asistencia ingresado no es válido, debe ser 0 o 1";
								//$stack[count($stack)] = $linea;
								$hayErrores = TRUE;
								continue;
							}
							
						}
						
					}
					
					$this->db->trans_complete();
					if ($this->db->trans_status() === FALSE) {
						$linea[] = "<br>Ha ocurrido un error en la base de datos al agregar la asistencia de la actividad";
						$hayErrores = TRUE;
					}

					if ($hayErrores)
						$stack[count($stack)] = $linea;
					
				}

			}
		}
		else {
			fclose($ffa);
			unlink($archivo);
			return FALSE;
		}
		fclose($ffa);
		unlink($archivo);
		return $stack;
	}
	
	private function findIdActividadByNombre($nombreActividad) {
		$this->db->select('ID_ACT AS id');
		$this->db->where('UPPER(NOMBRE_ACT)', $nombreActividad);
		$query = $this->db->get('actividad_masiva');
		if ($query == FALSE) {
			return NULL;
		}
		if ($query->num_rows() > 0) {
			$primeraResp = $query->row();
			//echo ' '.$primeraResp->id.' ';
			return $primeraResp->id;
		}
		else {
			return NULL;
		}
	}
	
	
	//FUNCIÓN REPETIDA EN MODEL_ASISTENCIA
	private function findSeccionByEstudiante($rut_estudiante) {
		$this->db->select('estudiante.ID_SECCION');
		$this->db->where('RUT_USUARIO', $rut_estudiante);
		$query = $this->db->get('estudiante');
		if ($query->num_rows() > 0) {
			$primeraResp = $query->row();
			if ($primeraResp->ID_SECCION == NULL) {
				return -1;
			}
			return $primeraResp->ID_SECCION;
		}
		else {
			return NULL;
		}
	}

	public function getAsistenciaActividadesByEstudiante($rut_estudiante) {
		$this->db->select('actividad_masiva.ID_ACT');
		$this->db->join('instancia_actividad_masiva', 'actividad_masiva.ID_ACT=instancia_actividad_masiva.ID_ACT');
		$this->db->group_by('actividad_masiva.ID_ACT');
		$query = $this->db->get('actividad_masiva');
		if ($query == FALSE) {
			return array();
		}
		$allActividadesMasivas = $query->result();

		$this->db->flush_cache();
		$this->db->select('actividad_masiva.ID_ACT');
		$this->db->select('PRESENTE_ASIST_EVENTO AS presente');
		$this->db->join('instancia_actividad_masiva', 'instancia_actividad_masiva.ID_INSTANCIA_ACTIVIDAD_MASIVA=asistencia_actividad.ID_INSTANCIA_ACTIVIDAD_MASIVA', 'LEFT OUTER');
		$this->db->join('actividad_masiva', 'actividad_masiva.ID_ACT=instancia_actividad_masiva.ID_ACT', 'LEFT OUTER');
		$this->db->where('RUT_USUARIO', $rut_estudiante);
		$query = $this->db->get('asistencia_actividad');
		//echo $this->db->last_query().' ';
		if ($query == FALSE) {
			return array();
		}
		$actividades_presentes = $query->result();

		$resultado = array();
		foreach ($allActividadesMasivas as $actividad_masiva) {
			$encontrado = FALSE;
			$resultadoPresente = NULL;
			foreach ($actividades_presentes as $act_presente) {
				if ($act_presente->ID_ACT == $actividad_masiva->ID_ACT) {
					$encontrado = TRUE;
					$resultadoPresente = $act_presente->presente;
					break;
				}
			}
			if ($encontrado) {
				$resultado[] = $resultadoPresente;
			}
			else {
				$resultado[] = NULL;
			}
		}
		return $resultado;

		/*
		$this->db->select('PRESENTE_ASIST_EVENTO AS presente');
		$this->db->where('asistencia_actividad.RUT_USUARIO', $rut_estudiante);
		$query = $this->db->get('asistencia_actividad');
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
		*/
	}
}
?>