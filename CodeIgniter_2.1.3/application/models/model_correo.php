<?php
class model_correo extends CI_Model
{
	public function VerCorreosUser($variable)
	{
		try
		{
			$sql="SELECT * FROM carta WHERE rut_usuario3='$variable'";
			$datos=mysql_query($sql);
			$listaCompleta=array();
			while($row=mysql_fetch_array($datos))
			{
				$lista = array();
				$correo = array();
				$correo['cod_correo']=$row['COD_CORREO'];
				$correo['rut_usuario3']=$row['RUT_USUARIO3'];
				$correo['id_plantilla']=$row['ID_PLANTILLA'];
				$correo['hora']=$row['HORA']; 
				$correo['fecha']=$row['FECHA'];
				$correo['cuerpo_email']=$row['CUERPO_EMAIL'];
				$correo['asunto']=$row['ASUNTO'];
				array_push($lista,$correo);
				$codigo=$row['COD_CORREO'];
				$sql1="SELECT RUT_ESTUDIANTE FROM carta_estudiante WHERE COD_CORREO='$codigo'";
				$sql2="SELECT RUT_AYUDANTE FROM carta_ayudante WHERE COD_CORREO='$codigo'";
				$sql3="SELECT RUT_USUARIO FROM carta_user WHERE COD_CORREO='$codigo'";
				$rutDestinoEstudiantes=array();
				$rutDestinoAyudantes=array();
				$rutDestinoUsuarios=array();
				$datos1=mysql_query($sql1);
				while($row1=mysql_fetch_array($datos1))
					array_push($rutDestinoEstudiantes,$row1['RUT_ESTUDIANTE']);
				$datos2=mysql_query($sql2); 
				while($row2=mysql_fetch_array($datos2))
					array_push($rutDestinoAyudantes,$row['RUT_AYUDANTE']);
				$datos3=mysql_query($sql3); 
				while($row3=mysql_fetch_array($datos3))
					array_push($rutDestinoUsuarios,$row['RUT_USUARIO']);
				$estudiantes=array();
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
						$estudiante['apellido_paterno']=$rowDatosEstudiante['APELLIDO_PATERNO'];
						$estudiante['apellido_materno']=$rowDatosEstudiante['APELLIDO_MATERNO'];
						$estudiante['correo_estudiante']=$rowDatosEstudiante['CORREO_ESTUDIANTE'];
						array_push($estudiantes,$estudiante);
					}
				}
				$ayudantes=array();
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
						$ayudante['apellido_paterno']=$rowDatosAyudante['APELLIDO_PATERNO'];
						$ayudante['apellido_materno']=$rowDatosAyudante['APELLIDO_MATERNO'];
						$ayudante['correo_ayudante']=$rowDatosAyudante['CORREO_AYUDANTE'];
						array_push($ayudantes,$ayudante);
					}
				}
				$profesores=array();
				$coordinadores=array();
				foreach($rutDestinoUsuarios as $rutUsuario)
				{
					$sqlProfesor="SELECT * FROM profesor WHERE RUT_PROFESOR='$rutUsuario'";
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
					$sqlCoordinador="SELECT * FROM coordinador WHERE RUT_COORDINADOR='$rutUsuario'";
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
			array_unshift($listaCompleta,1);
			return $listaCompleta;
		}
		catch(Exception $e)
		{
			$listaCompleta=array();
			array_unshift($listacompleta,-1);
		}
	}
	
	public function EliminarCorreo($correos)
	{
		$resultados1=array();
		$resultados2=array();
		$resultados3=array();
		$resultados4=array();
		$resultadosFinales=array();
		foreach($correos as $correo)
		{
			$sqlEliminarCorreoEstudiante="DELETE FROM carta_estudiante WHERE COD_CORREO='$correo'";
			$resultados1[$correo][$resultado]=mysql_query($sqlEliminarCorreoEstudiante);
			$sqlEliminarCorreoAyudante="DELETE FROM carta_ayudante WHERE COD_CORREO='$correo'";
			$resultados2[$correo][$resultado]=mysql_query($sqlEliminarCorreoAyudante);
			$sqlEliminarCorreoUsuario="DELETE FROM carta_usuario WHERE COD_CORREO='$correo'";
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
	
	public function InsertarCorreo($asunto,$mensaje,$rut,$tipo,$date)
	{
		try
		{
			$this->COD_CORREO=$date;
			$this->RUT_USUARIO3=$rut;
			$this->ID_PLANTILLA=null;
			$this->HORA = date("H:i:s");
			$this->FECHA = date("Y-m-d");
			$this->CUERPO_EMAIL = $mensaje;
			$this->ASUNTO=$asunto;
			$this->db->insert('carta', $this);
			return 1;
		}
		catch(Exception $e)
		{
			return -1;
		}
    }
}
?>


