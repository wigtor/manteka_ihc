<?php
class Model_calificaciones extends CI_Model {

	public function agregarCalificacion($rut_profesor, $rut, $nota, $comentario, $id_evaluacion) {

		$this->db->trans_start();

		$this->db->select('VALOR_NOTA');
		$this->db->select('COMENTARIO_NOTA');
		$this->db->where('RUT_USUARIO', $rut);
		$this->db->where('ID_EVALUACION', $id_evaluacion);
		$primeraResp = $this->db->get('nota');
		//echo $this->db->last_query().'    ';
		if ($primeraResp == FALSE) {
			$this->db->trans_complete();
			return FALSE;
		}
		if ($primeraResp->num_rows() > 0) {
			//Se intenta updatear si es que existe esa asistencia

			$this->db->flush_cache();
			if ($comentario === NULL) {
				$data1 = array('VALOR_NOTA' => $nota
				);
			}
			else {
				$data1 = array('VALOR_NOTA' => $nota,
					'COMENTARIO_NOTA' => $comentario
				);
			}
			$this->db->where('RUT_USUARIO', $rut);
			$this->db->where('ID_EVALUACION', $id_evaluacion);
			$this->db->update('nota', $data1);
			//Si hubo cambios, entonces hago insert en auditoría
			if ($this->db->affected_rows() > 0) {
				$row_original = $primeraResp->row();
				$notaOri = $row_original->VALOR_NOTA;
				$comentarioOri = $row_original->COMENTARIO_NOTA;
				$datos_auditoria = array('RUT_USUARIO' => $rut_profesor, 
					'NOMBRE' => 'UPDATE', 
					'DATO_PRE_CAMBIO' => 'VALOR_NOTA=`'.$notaOri.'`, '.'COMENTARIO_NOTA=`'.$comentarioOri.'`', 
					'DATO_POST_CAMBIO' => 'VALOR_NOTA=`'.$nota.'`, '.'COMENTARIO_NOTA=`'.$comentario.'`', 
					'TABLA_MODIFICADA'=> 'nota', 
					'QUERY'=> $this->db->last_query());
				$this->db->flush_cache();
				$this->db->insert('auditoria', $datos_auditoria);
			}
		}
		else {
			//Se intenta insertar si no existe registro
			$this->db->flush_cache();
			$data2 = array('RUT_USUARIO' =>$rut,
				'ID_EVALUACION' => $id_evaluacion,
				'VALOR_NOTA' => $nota,
				'COMENTARIO_NOTA' => $comentario
			);
			$this->db->insert('nota', $data2);
			//echo $this->db->last_query().'    ';

			$datos_auditoria = array('RUT_USUARIO' => $rut_profesor, 
					'NOMBRE' => 'INSERT', 
					'DATO_PRE_CAMBIO' => NULL,
					'DATO_POST_CAMBIO' => 'VALOR_NOTA=`'.$nota.'`, '.'COMENTARIO_NOTA=`'.$comentario.'`', 
					'TABLA_MODIFICADA'=> 'nota', 
					'QUERY'=> $this->db->last_query());
			$this->db->flush_cache();
			$this->db->insert('auditoria', $datos_auditoria);
			//echo $this->db->last_query().'    ';
		}

		//echo $this->db->last_query();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			return FALSE;
		}
		else{
			return TRUE;
		}
	}


	public function getEvaluacionesBySeccionAndProfesorAjax($id_seccion, $rut_profesor, $esCoordinador, $modulosTematicosEnQueEsLider, $mostrarTodas) {
		$this->db->select('evaluacion.ID_EVALUACION AS id');
		$this->db->select('CONCAT(\'Nota: \', NOMBRE_MODULO) AS nombre', FALSE);
		$this->db->select('FECHA_PLANIFICADA AS fecha_planificada');
		$this->db->select('TRUE AS editable', FALSE);
		$this->db->select('modulo_tematico.ABREVIATURA AS abreviatura');
		$this->db->join('modulo_tematico', 'evaluacion.ID_MODULO_TEM = modulo_tematico.ID_MODULO_TEM');
		$this->db->join('sesion_de_clase', 'modulo_tematico.ID_MODULO_TEM = sesion_de_clase.ID_MODULO_TEM');
		$this->db->join('planificacion_clase', 'sesion_de_clase.ID_SESION = planificacion_clase.ID_SESION');
		$this->db->join('seccion', 'planificacion_clase.ID_SECCION = seccion.ID_SECCION');
		if (($esCoordinador == FALSE) && ($mostrarTodas == FALSE)) {
			if (count($modulosTematicosEnQueEsLider) < 1) {
				$this->db->join('ayu_profe', 'planificacion_clase.ID_AYU_PROFE = ayu_profe.ID_AYU_PROFE');
				$this->db->where('ayu_profe.PRO_RUT_USUARIO', $rut_profesor);
			}
			foreach ($modulosTematicosEnQueEsLider as $modulo_tematico) {
				$this->db->or_where('modulo_tematico.ID_MODULO_TEM', $modulo_tematico->id);
			}
		}
		$this->db->where('seccion.ID_SECCION', $id_seccion);
		$this->db->order_by('evaluacion.ID_EVALUACION');
		$this->db->group_by('evaluacion.ID_EVALUACION');
		$query = $this->db->get('evaluacion');
		//echo $this->db->last_query();
		if ($query == FALSE) {
			return array();
		}
		$resultado = $query->result();
		return $resultado;
	}


	public function cantidadCalificacionesBySeccionAndModuloTem($id_seccion, $id_modulo_tem) {
		$this->db->select('COUNT( DISTINCT evaluacion.ID_EVALUACION ) AS resultado');
		$this->db->join('modulo_tematico', 'evaluacion.ID_MODULO_TEM = modulo_tematico.ID_MODULO_TEM', 'LEFT OUTER');
		$this->db->join('sesion_de_clase', 'modulo_tematico.ID_MODULO_TEM = sesion_de_clase.ID_MODULO_TEM', 'LEFT OUTER');
		$this->db->join('planificacion_clase', 'sesion_de_clase.ID_SESION = planificacion_clase.ID_SESION', 'LEFT OUTER');
		$this->db->join('seccion', 'planificacion_clase.ID_SECCION = seccion.ID_SECCION', 'LEFT OUTER');
		if ($id_modulo_tem != NULL) {
			$this->db->where('modulo_tematico.ID_MODULO_TEM', $id_modulo_tem);
		}
		$this->db->where('seccion.ID_SECCION', $id_seccion);
		$query = $this->db->get('evaluacion');
		if ($query == FALSE) {
			return 0;
		}
		//echo $this->db->last_query().'  ';
		return $query->row()->resultado;
	}

	public function getCalificacionesEstudianteByModuloTematico($rut_estudiante, $id_modulotem) {
		$this->db->select('nota.VALOR_NOTA AS nota');
		$this->db->select('evaluacion.ID_EVALUACION AS id_evaluacion');
		$this->db->join('nota', 'evaluacion.ID_EVALUACION = nota.ID_EVALUACION', 'LEFT OUTER');
		$this->db->where('nota.RUT_USUARIO', $rut_estudiante);
		if ($id_modulotem !== NULL) {
			$this->db->where('evaluacion.ID_MODULO_TEM', $id_modulotem);
		}
		$this->db->order_by('evaluacion.ID_MODULO_TEM');
		$query = $this->db->get('evaluacion');
		//echo $this->db->last_query().'  ';
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}


	public function getComentariosCalificacionesEstudianteByModuloTematico($rut_estudiante, $id_modulotem) {
		$this->db->select('nota.COMENTARIO_NOTA AS comentario');
		$this->db->select('evaluacion.ID_EVALUACION AS id_evaluacion');
		$this->db->join('nota', 'evaluacion.ID_EVALUACION = nota.ID_EVALUACION', 'LEFT OUTER');
		$this->db->where('nota.RUT_USUARIO', $rut_estudiante);
		if ($id_modulotem !== NULL) {
			$this->db->where('evaluacion.ID_MODULO_TEM', $id_modulotem);
		}
		$query = $this->db->get('evaluacion');
		//echo $this->db->last_query().'  ';
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}


	public function calculaPromedio($rut_estudiante) {
		$this->db->select('CAST(AVG(nota.VALOR_NOTA) AS DECIMAL (10,1)) AS promedio', FALSE);
		$this->db->join('evaluacion', 'nota.ID_EVALUACION = evaluacion.ID_EVALUACION', 'LEFT OUTER');
		$this->db->where('nota.RUT_USUARIO', $rut_estudiante);
		$this->db->where('nota.VALOR_NOTA IS NOT NULL', NULL);
		$query = $this->db->get('nota');
		//echo $this->db->last_query();
		if ($query == FALSE) {
			return array();
		}
		if ($query->num_rows() > 0) {
			$promedio = $query->row()->promedio;
			if ($promedio == NULL)
				return "";
			return $promedio;
		}
		return "";
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
					$header[] = "<br>La cantidad de elementos de la cabecera no es válida";
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

					//Hago un insert o update por cada sesión de clase
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

						$abreviaturaModuloTem = $header[$i];
						if ($abreviaturaModuloTem == "FIN") { //PROMEDIO FINAL NO SE AGREGA COMO CALIFICACIÓN
							continue;
						}
						$id_modulo_tem = $this->findModuloTemByAbreviatura($abreviaturaModuloTem);
						if ($id_modulo_tem == NULL) {
							$linea[] = "<br>El módulo temático no es válido";
							//$stack[count($stack)] = $linea;
							$hayErrores = TRUE;
							continue;
						}
						$id_evaluacion = $this->findEvaluacionByModuloTematico($id_modulo_tem);
						if ($id_evaluacion == NULL) {
							$linea[] = "<br>No se ha encontrado una evaluación para el módulo temático: ".$abreviaturaModuloTem.", revise si el estudiante se cambió de sección";
							//$stack[count($stack)] = $linea;
							$hayErrores = TRUE;
							continue;
						}
						
						$rut_estudiante = $this->findEstudianteByRut($data['RUT']);
						if ($rut_estudiante == NULL) {
							$linea[] = "<br>No se ha encontrado el estudiante con RUT: ".$data['RUT'].", revise si el estudiante fue eliminado del sistema";
							//$stack[count($stack)] = $linea;
							$hayErrores = TRUE;
							continue;
						}

						if ($data[$abreviaturaModuloTem] !== "") { //Los blancos no se agregan, ni se modifican
							$nota = $data[$abreviaturaModuloTem];
							$nota = str_replace(',', '.', $nota); 
							if (preg_match ('/^([123456]([\.][0-9])?)|[7]([\.][0])?$/', $nota)) {
								//echo 'es válido:'.$nota.'  ';
								//echo 'RP:'.$rutProfesor.' Rut: '.$data['RUT'].' nota: '.$nota.' id_evaluacion: '.$id_evaluacion.'         ';
								if ($this->tienePermisosPonerCalificacion($rutProfesor, $rut_estudiante, $id_modulo_tem, $esCoordinador)) {
									$this->agregarCalificacion($rutProfesor, $data['RUT'], $nota, NULL, $id_evaluacion);
								}
								else {
									//echo ' fail ';
									$linea[] = "<br>No tiene permisos para poner la calificación al estudiante";
									//$stack[count($stack)] = $linea;
									$hayErrores = TRUE;
									continue;
								}
							}
							else {
								//echo 'Inválido:'.$nota.'  ';
								$linea[] = "<br>El formato de nota ingresado no es válido";
								//$stack[count($stack)] = $linea;
								$hayErrores = TRUE;
								continue;
							}
						}
					}
					
					$this->db->trans_complete();
					if ($this->db->trans_status() === FALSE) {
						$linea[] = "<br>Ha ocurrido un error en la base de datos al agregar la calificación";
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

	//$id_seccion, $rut_profesor, $esCoordinador, $modulosTematicosEnQueEsLider, $mostrarTodas
	private function tienePermisosPonerCalificacion($rutProfesor, $rut_estudiante, $id_modulo_tem, $esCoordinador) {
		$this->db->select('evaluacion.ID_EVALUACION AS id');
		$this->db->join('modulo_tematico', 'evaluacion.ID_MODULO_TEM = modulo_tematico.ID_MODULO_TEM');
		$this->db->join('sesion_de_clase', 'modulo_tematico.ID_MODULO_TEM = sesion_de_clase.ID_MODULO_TEM');
		$this->db->join('planificacion_clase', 'sesion_de_clase.ID_SESION = planificacion_clase.ID_SESION');
		$this->db->join('seccion', 'planificacion_clase.ID_SECCION = seccion.ID_SECCION');
		$this->db->join('estudiante', 'seccion.ID_SECCION = estudiante.ID_SECCION');
		
		if (!$esCoordinador) {
			$this->db->join('ayu_profe', 'planificacion_clase.ID_AYU_PROFE = ayu_profe.ID_AYU_PROFE');
			$this->db->where('ayu_profe.PRO_RUT_USUARIO', $rutProfesor);
		}
		/*
		if (($esCoordinador == FALSE) && ($mostrarTodas == FALSE)) {
			if (count($modulosTematicosEnQueEsLider) < 1) {
				$this->db->join('ayu_profe', 'planificacion_clase.ID_AYU_PROFE = ayu_profe.ID_AYU_PROFE');
				$this->db->where('ayu_profe.PRO_RUT_USUARIO', $rutProfesor);
			}
			foreach ($modulosTematicosEnQueEsLider as $modulo_tematico) {
				$this->db->or_where('modulo_tematico.ID_MODULO_TEM', $modulo_tematico->id);
			}
		}
		*/
		$this->db->where('estudiante.RUT_USUARIO', $rut_estudiante);
		$this->db->where('modulo_tematico.ID_MODULO_TEM', $id_modulo_tem);
		$this->db->group_by('evaluacion.ID_EVALUACION');
		$query = $this->db->get('evaluacion');
		//echo $this->db->last_query();
		if ($query == FALSE) {
			return FALSE;
		}
		if ($query->num_rows() > 0) {
			//echo ' bien ';
			return TRUE;
		}
		return FALSE;
	}
	
	private function findModuloTemByAbreviatura($abreviaturaModuloTem) {
		$this->db->select('modulo_tematico.ID_MODULO_TEM');
		$this->db->where('modulo_tematico.ABREVIATURA', $abreviaturaModuloTem);
		$query = $this->db->get('modulo_tematico');
		if ($query->num_rows() > 0) {
			$primeraResp = $query->row();
			if ($primeraResp->ID_MODULO_TEM == NULL) {
				return -1;
			}
			return $primeraResp->ID_MODULO_TEM;
		}
		else {
			return NULL;
		}
	}

	private function findEvaluacionByModuloTematico($id_modulo_tem) {
		$this->db->select('evaluacion.ID_EVALUACION');
		$this->db->where('evaluacion.ID_MODULO_TEM', $id_modulo_tem);
		$query = $this->db->get('evaluacion');
		if ($query->num_rows() > 0) {
			$primeraResp = $query->row(); //POSIBLE ERROR SI LLEGAN A EXISTIR MÁS DE 2 EVALUACIONES POR MODULO TEMÁTICO
			return $primeraResp->ID_EVALUACION;
		}
		else {
			return NULL;
		}
	}
	
	private function findEstudianteByRut($rut_estudiante) {
		$this->db->select('estudiante.RUT_USUARIO');
		$this->db->where('estudiante.RUT_USUARIO', $rut_estudiante);
		$query = $this->db->get('estudiante');
		if ($query->num_rows() > 0) {
			$primeraResp = $query->row();
			return $primeraResp->RUT_USUARIO;
		}
		else {
			return NULL;
		}
	}
}

?>
