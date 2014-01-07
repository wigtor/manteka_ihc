<?php
class Model_asistencia extends CI_Model {

	public function agregarAsistencia($rut_profesor, $rut, $asistio, $justificado, $comentario, $id_sesion_de_clase) {
		
		$this->db->trans_start();

		$this->db->select('PRESENTE_ASISTENCIA');
		$this->db->select('JUSTIFICADO_ASISTENCIA');
		$this->db->select('COMENTARIO_ASISTENCIA');
		$this->db->where('RUT_USUARIO', $rut);
		$this->db->where('ID_SESION', $id_sesion_de_clase);
		$primeraResp = $this->db->get('asistencia');
		//echo $this->db->last_query().'    ';
		if ($primeraResp == FALSE) {
			$this->db->trans_complete();
			return FALSE;
		}
		if ($primeraResp->num_rows() > 0) {
			//Se intenta updatear si es que existe esa asistencia

			$this->db->flush_cache();
			if ($comentario === NULL) {
				$data1 = array('PRESENTE_ASISTENCIA' => $asistio, 
					'JUSTIFICADO_ASISTENCIA' => $justificado);
			}
			else {
				$data1 = array('PRESENTE_ASISTENCIA' => $asistio, 
					'JUSTIFICADO_ASISTENCIA' => $justificado, 
					'COMENTARIO_ASISTENCIA' => $comentario);
			}

			$this->db->where('RUT_USUARIO', $rut);
			$this->db->where('ID_SESION', $id_sesion_de_clase);
			$this->db->update('asistencia', $data1);

			//Si hubo cambios, entonces hago insert en auditoría
			if ($this->db->affected_rows() > 0) {
				$row_original = $primeraResp->row();
				$asistioOri = $row_original->PRESENTE_ASISTENCIA;
				$justificadoOri = $row_original->JUSTIFICADO_ASISTENCIA;
				$comentarioOri = $row_original->COMENTARIO_ASISTENCIA;
				$datos_auditoria = array('RUT_USUARIO' => $rut_profesor, 
					'NOMBRE' => 'UPDATE', 
					'DATO_PRE_CAMBIO' => 'PRESENTE_ASISTENCIA=`'.$asistioOri.'`, '.'JUSTIFICADO_ASISTENCIA=`'.$justificadoOri.'`, '.'COMENTARIO_ASISTENCIA=`'.$comentarioOri.'`', 
					'DATO_POST_CAMBIO' => 'PRESENTE_ASISTENCIA=`'.$asistio.'`, '.'JUSTIFICADO_ASISTENCIA=`'.$justificado.'`, '.'COMENTARIO_ASISTENCIA=`'.$comentario.'`', 
					'TABLA_MODIFICADA'=> 'asistencia', 
					'QUERY'=> $this->db->last_query());
				$this->db->flush_cache();
				$this->db->insert('auditoria', $datos_auditoria);
			}
		}
		else {
			//Se intenta insertar si no existe registro
			$this->db->flush_cache();
			$data2 = array('RUT_USUARIO' => $rut, 
				'ID_SESION' => $id_sesion_de_clase,
				'PRESENTE_ASISTENCIA' => $asistio, 
				'JUSTIFICADO_ASISTENCIA' => $justificado, 
				'COMENTARIO_ASISTENCIA' => $comentario);
			$this->db->insert('asistencia', $data2);

			$datos_auditoria = array('RUT_USUARIO' => $rut_profesor, 
					'NOMBRE' => 'INSERT', 
					'DATO_PRE_CAMBIO' => NULL,
					'DATO_POST_CAMBIO' => 'PRESENTE_ASISTENCIA=`'.$asistio.'`, '.'JUSTIFICADO_ASISTENCIA=`'.$justificado.'`, '.'COMENTARIO_ASISTENCIA=`'.$comentario.'`', 
					'TABLA_MODIFICADA'=> 'asistencia', 
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


	public function getAsistenciaEstudianteByModuloTematico($rut_estudiante, $id_modulotem) {
		$this->db->flush_cache();
		$this->db->select('asistencia.PRESENTE_ASISTENCIA AS presente');
		$this->db->select('sesion_de_clase.ID_SESION AS id_sesion');
		$this->db->join('sesion_de_clase', 'asistencia.ID_SESION = sesion_de_clase.ID_SESION', 'LEFT OUTER');
		$this->db->join('estudiante', 'asistencia.RUT_USUARIO = estudiante.RUT_USUARIO', 'LEFT OUTER');
		$this->db->join('seccion', 'estudiante.ID_SECCION = seccion.ID_SECCION', 'LEFT OUTER');
		$this->db->join('planificacion_clase', 'seccion.ID_SECCION = planificacion_clase.ID_SECCION', 'LEFT OUTER');
		$this->db->where('asistencia.RUT_USUARIO', $rut_estudiante);
		$this->db->where('planificacion_clase.ID_SESION', 'sesion_de_clase.ID_SESION', FALSE);
		if ($id_modulotem !== NULL) {
			$this->db->where('sesion_de_clase.ID_MODULO_TEM', $id_modulotem);
		}
		$this->db->group_by('asistencia.ID_SESION');
		$this->db->order_by('NUM_SESION_SECCION');
		$query = $this->db->get('asistencia');
		//echo $this->db->last_query().' ';
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}


	public function getComentariosAsistenciaEstudianteByModuloTematico($rut_estudiante, $id_modulotem) {
		$this->db->flush_cache();
		$this->db->select('asistencia.COMENTARIO_ASISTENCIA AS comentario');
		$this->db->select('sesion_de_clase.ID_SESION AS id_sesion');
		$this->db->join('sesion_de_clase', 'asistencia.ID_SESION = sesion_de_clase.ID_SESION', 'LEFT OUTER');
		$this->db->join('estudiante', 'asistencia.RUT_USUARIO = estudiante.RUT_USUARIO', 'LEFT OUTER');
		$this->db->join('seccion', 'estudiante.ID_SECCION = seccion.ID_SECCION', 'LEFT OUTER');
		$this->db->join('planificacion_clase', 'seccion.ID_SECCION = planificacion_clase.ID_SECCION', 'LEFT OUTER');
		$this->db->where('asistencia.RUT_USUARIO', $rut_estudiante);
		$this->db->where('planificacion_clase.ID_SESION', 'sesion_de_clase.ID_SESION', FALSE);
		if ($id_modulotem !== NULL) {
			$this->db->where('sesion_de_clase.ID_MODULO_TEM', $id_modulotem);
		}
		$this->db->group_by('asistencia.ID_SESION');
		$this->db->order_by('NUM_SESION_SECCION');
		$query = $this->db->get('asistencia');
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}


	public function	getAsistenciaEstudiantesBySeccion($id_seccion, $rut_usuario){
		$this->db->select('estudiante.RUT_USUARIO AS rut');
		$this->db->where('estudiante.ID_SECCION', $id_seccion);
		$query = $this->db->get('estudiante');
		if ($query == FALSE) {
			return array();
		}
		$AllestudiantesSeccion = $query->result();
		//echo 'Cantiad: '.count($AllestudiantesSeccion).' ';
		$resultado = array();
		$i = 0;
		foreach ($AllestudiantesSeccion as $rut_estudiante) {
			$this->db->flush_cache();
			$this->db->select('estudiante.RUT_USUARIO AS rut');
			$this->db->select('NOMBRE1 AS nombre1');
			$this->db->select('NOMBRE2 AS nombre2');
			$this->db->select('APELLIDO1 AS apellido1');
			$this->db->select('APELLIDO2 AS apellido2');
			$this->db->select('TELEFONO AS telefono');
			$this->db->select('CORREO1_USER AS correo1');
			$this->db->select('CORREO2_USER AS correo2');
			$this->db->select('carrera.COD_CARRERA AS cod_carrera');
			$this->db->select('carrera.NOMBRE_CARRERA AS carrera');
			$this->db->select('asistencia.PRESENTE_ASISTENCIA AS presente');
			$this->db->select('asistencia.JUSTIFICADO_ASISTENCIA AS justificado');
			$this->db->select('asistencia.COMENTARIO_ASISTENCIA AS comentario');
			$this->db->select('estudiante.RUT_USUARIO AS id');
			$this->db->join('usuario', 'estudiante.RUT_USUARIO = usuario.RUT_USUARIO');
			$this->db->join('carrera', 'estudiante.COD_CARRERA = carrera.COD_CARRERA');
			$this->db->join('asistencia', 'estudiante.RUT_USUARIO = asistencia.RUT_USUARIO', 'LEFT OUTER');
			$this->db->where('estudiante.RUT_USUARIO', $rut_estudiante->rut);
			//$this->db->where('estudiante.ID_SECCION', $id_seccion);
			$this->db->where('asistencia.ID_SESION', $id_sesion);
			$query = $this->db->get('estudiante');
			//echo $this->db->last_query().' ';
			if ($query == FALSE) {
				return array();
			}
			if ($query->num_rows() > 0) {
				$resultado[$i] = $query->row();
			}
			else {
				$this->db->flush_cache();
				$this->db->select('estudiante.RUT_USUARIO AS rut');
				$this->db->select('NOMBRE1 AS nombre1');
				$this->db->select('NOMBRE2 AS nombre2');
				$this->db->select('APELLIDO1 AS apellido1');
				$this->db->select('APELLIDO2 AS apellido2');
				$this->db->select('TELEFONO AS telefono');
				$this->db->select('CORREO1_USER AS correo1');
				$this->db->select('CORREO2_USER AS correo2');
				$this->db->select('carrera.COD_CARRERA AS cod_carrera');
				$this->db->select('carrera.NOMBRE_CARRERA AS carrera');
				$this->db->select('estudiante.RUT_USUARIO AS id');
				$this->db->join('usuario', 'estudiante.RUT_USUARIO = usuario.RUT_USUARIO');
				$this->db->join('carrera', 'estudiante.COD_CARRERA = carrera.COD_CARRERA');
				//$this->db->join('asistencia', 'estudiante.RUT_USUARIO = asistencia.RUT_USUARIO', 'LEFT OUTER');
				$this->db->where('estudiante.RUT_USUARIO', $rut_estudiante->rut);
				$query = $this->db->get('estudiante');
				//echo $this->db->last_query().'    ';
				if ($query == FALSE) {
					return array();
				}

				$resultado[$i] = $query->row(); //Siempre debiese haber al menos un resultado
			}
			$i = $i+1;
		}


		return $resultado;
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

						$fechaClase = $header[$i];
						$fechaClaseAdaptada = $this->adaptFechaFormat($fechaClase);
						if ($fechaClaseAdaptada == NULL) {
							$linea[] = "<br>La fecha de la sesión de clase no tiene un formáto válido, debe ser dd-mm-yyyy";
							//$stack[count($stack)] = $linea;
							$hayErrores = TRUE;
							continue;
						}

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
						$id_sesion_de_clase = $this->findSesionByFechaAndSeccion($fechaClaseAdaptada, $id_seccion);
						if ($id_sesion_de_clase == NULL) {
							$linea[] = "<br>No se ha encontrado una sesión de clases para la fecha: ".$fechaClase." en la sección, revise si el estudiante se cambió de sección";
							//$stack[count($stack)] = $linea;
							$hayErrores = TRUE;
							continue;
						}

						if ($data[$fechaClase] !== "") { //Los blancos no se agregan, ni se modifican
							$asistio = $data[$fechaClase];
							if (preg_match ('/^[0]|[1]$/' , $asistio)) {
								//echo 'es válido:'.$asistio.'  ';
								//echo ' Rut: '.$data['RUT'].' asistió: '.$asistio.' id_seccion: '.$id_seccion.' id_sesion_de_clase: '.$id_sesion_de_clase.'         ';
								if ($this->tienePermisosPonerAsistencia($rutProfesor, $id_seccion, $id_sesion_de_clase, $esCoordinador)) {
									$this->agregarAsistencia($rutProfesor, $data['RUT'], $asistio, NULL, NULL, $id_sesion_de_clase);
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
						$linea[] = "<br>Ha ocurrido un error en la base de datos al agregar la asistencia";
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

//($id_seccion, $rut_profesor, $esCoordinador, $modulosTematicosEnQueEsLider, $mostrarTodas) 
	private function tienePermisosPonerAsistencia($rutProfesor, $id_seccion, $id_sesion_de_clase, $esCoordinador) {
		$this->db->select('sesion_de_clase.ID_SESION AS id');
		$this->db->select('NOMBRE_SESION AS nombre');
		$this->db->select('DESCRIPCION_SESION AS descripcion');
		$this->db->select('FECHA_PLANIFICADA AS fecha_planificada');
		$this->db->select('NUM_SESION_SECCION AS numero_sesion_global');
		$this->db->join('planificacion_clase', 'sesion_de_clase.ID_SESION = planificacion_clase.ID_SESION');
		$this->db->join('seccion', 'planificacion_clase.ID_SECCION = seccion.ID_SECCION');

		if (!$esCoordinador) {
			$this->db->join('ayu_profe', 'planificacion_clase.ID_AYU_PROFE = ayu_profe.ID_AYU_PROFE');
			$this->db->where('ayu_profe.PRO_RUT_USUARIO', $rutProfesor);
		}

		/*
		if (($esCoordinador == FALSE) && ($mostrarTodas == FALSE)) {
			if (count($modulosTematicosEnQueEsLider) < 1) {
				$this->db->join('ayu_profe', 'planificacion_clase.ID_AYU_PROFE = ayu_profe.ID_AYU_PROFE');
				$this->db->where('ayu_profe.PRO_RUT_USUARIO', $rut_profesor);
			}
			foreach ($modulosTematicosEnQueEsLider as $modulo_tematico) {
				$this->db->or_where('sesion_de_clase.ID_MODULO_TEM', $modulo_tematico->id);
			}
		}
		*/
		$this->db->where('seccion.ID_SECCION', $id_seccion);
		$this->db->where('sesion_de_clase.ID_SESION', $id_sesion_de_clase);
		$query = $this->db->get('sesion_de_clase');
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

	private function findSesionByFechaAndSeccion($fechaClase, $id_seccion) {
		$this->db->select('planificacion_clase.ID_SESION');
		$this->db->where('FECHA_PLANIFICADA', $fechaClase);
		$this->db->where('planificacion_clase.ID_SECCION', $id_seccion);
		$query = $this->db->get('planificacion_clase');
		if ($query->num_rows() > 0) {
			$primeraResp = $query->row(); //POSIBLE ERROR SI LLEGAN A EXISTIR MÁS DE 2 CLASES POR DÍA PARA UNA MISMA SECCIÓN
			return $primeraResp->ID_SESION;
		}
		else {
			return NULL;
		}
	}

	private function adaptFechaFormat($fecha) {
		if (preg_match ('/^\d{1,2}\/\d{1,2}\/\d{4}$/' , $fecha)) { //Busco estilo dd/mm/yyyy
			$fechaArray =  explode('/', $fecha);
			$fechaResultado = $fechaArray[2].'-'.$fechaArray[1].'-'.$fechaArray[0];
			return $fechaResultado;
		}
		else if (preg_match ('/^\d{1,2}-\d{1,2}-\d{4}$/' , $fecha)) { //Busco estilo dd-mm-yyyy
			$fechaArray =  explode('-', $fecha);
			$fechaResultado = $fechaArray[2].'-'.$fechaArray[1].'-'.$fechaArray[0];
			return $fechaResultado;
		}
		else if (preg_match ('/^\d{4}\/\d{1,2}\/\d{1,2}$/' , $fecha)) { //Busco estilo yyyy/mm/dd
			$fechaArray =  explode('/', $fecha);
			$fechaResultado = $fechaArray[0].'-'.$fechaArray[1].'-'.$fechaArray[2];
			return $fechaResultado;
		}
		else if (preg_match ('/^\d{4}-\d{1,2}-\d{1,2}$/' , $fecha)) { //Busco estilo yyyy-mm-dd
			$fechaArray =  explode('-', $fecha);
			$fechaResultado = $fechaArray[0].'-'.$fechaArray[1].'-'.$fechaArray[2];
			return $fechaResultado;
		}
		return NULL;
	}


}

?>
