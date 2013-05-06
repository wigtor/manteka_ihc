<?php
 
class Model_estudiante extends CI_Model {
    public $rut_estudiante = 0;
    var $nombre1_estudiante = '';
    var $nombre2_estudiante  = '';
    var $apellido_paterno='';
    var $apellido_materno='';
    var $correo_estudiante='';
    var $cod_seccion='';
    var $cod_carrera='';

    public function InsertarEstudiante($rut_estudiante,$nombre1_estudiante,$nombre2_estudiante,$apellido_paterno,$apellido_materno,$correo_estudiante,$cod_seccion,$cod_carrera) 
	{
		$data = array(					
					'RUT_ESTUDIANTE' => $rut_estudiante ,
					'NOMBRE1_ESTUDIANTE' => $nombre1_estudiante ,
					'NOMBRE2_ESTUDIANTE' => $nombre2_estudiante ,
					'APELLIDO_PATERNO' => $apellido_paterno ,
					'APELLIDO_MATERNO' => $apellido_materno ,
					'CORREO_ESTUDIANTE' => $correo_estudiante ,
					'COD_SECCION' =>  $cod_seccion ,
					'COD_CARRERA' => $cod_carrera 
		);
        $datos = $this->db->insert('estudiante',$data);
		if($datos == true){
			return 1;
		}
		else{
			return -1;
		}
		
    }
	
	public function ActualizarEstudiante($rut_estudiante,$nombre1_estudiante,$nombre2_estudiante,$apellido_paterno,$apellido_materno,$correo_estudiante)
	{
		$data = array(					
					'NOMBRE1_ESTUDIANTE' => $nombre1_estudiante ,
					'NOMBRE2_ESTUDIANTE' => $nombre2_estudiante ,
					'APELLIDO_PATERNO' => $apellido_paterno ,
					'APELLIDO_MATERNO' => $apellido_materno ,
					'CORREO_ESTUDIANTE' => $correo_estudiante
		);
		$this->db->where('RUT_ESTUDIANTE', $rut_estudiante);
        $datos = $this->db->update('estudiante',$data);
		if($datos == true){
			return 1;
		}
		else{
			return -1;
		}		
    }

    public function EliminarEstudiante($rut_estudiante)
    {
		$sql="DELETE FROM ESTUDIANTE WHERE rut_estudiante = '$rut_estudiante' "; //código MySQL
		$datos=mysql_query($sql); //enviar código MySQL
		if($datos == true){
			return 1;
		}
		else{
			return -1;
		}
    }
    
//operaciones para ver y editar datos de un estudiante


    public function VerEstudiante($rut_estudiante)
    {

		$sql="SELECT * FROM ESTUDIANTE WHERE rut_estudiante = '$rut_estudiante' "; //código MySQL
		$datos=mysql_query($sql); //enviar código MySQL
		$row=mysql_fetch_array($datos);
		$estudiante[0] = $row['RUT_ESTUDIANTE'];
		$estudiante[1] = $row['NOMBRE1_ESTUDIANTE'];
		$estudiante[2] = $row['NOMBRE2_ESTUDIANTE'];
		$estudiante[3] = $row['APELLIDO_PATERNO'];
		$estudiante[4] = $row['APELLIDO_MATERNO'];
		$estudiante[5] = "nulo";//$row['CORREO_ESTUDIANTE'];
		$estudiante[6] = $row['COD_SECCION'];
		$estudiante[7] = $row['COD_CARRERA'];
		return $estudiante;
		
    }

	public function VerTodosLosEstudiantes()
	{
		
		$sql="SELECT * FROM ESTUDIANTE ORDER BY APELLIDO_PATERNO"; //código MySQL
		$datos=mysql_query($sql); //enviar código MySQL
		$contador = 0;
		$lista;
		while ($row=mysql_fetch_array($datos)) { //Bucle para ver todos los registros
			$lista[$contador][0] = $row['RUT_ESTUDIANTE'];
			$lista[$contador][1] = $row['NOMBRE1_ESTUDIANTE'];
			$lista[$contador][2] = $row['NOMBRE2_ESTUDIANTE'];
			$lista[$contador][3] = $row['APELLIDO_PATERNO'];
			$lista[$contador][4] = $row['APELLIDO_MATERNO'];
			$lista[$contador][5] = $row['CORREO_ESTUDIANTE'];
			$lista[$contador][6] = $row['COD_SECCION'];
			$lista[$contador][7] = $row['COD_CARRERA'];
			
			$contador = $contador + 1;
		}
		return $lista;
		}
	
    public function EditarEstudiante($rut_estudiante)
    {
        $this->rut_estudiante = $_POST['rut_estudiante'];
        $this->nombre1_estudiante = $_POST['nombre1_estudiante'];
        $this->nombre2_estudiante = $_POST['nombre2_estudiante'];
        $this->apellido_paterno = $_POST['apellido_paterno'];
        $this->apellido_materno = $_POST['apellido_materno'];
        $this->correo_estudiante = $_POST['correo_estudiante'];
        $this->cod_seccion = $_POST['cod_seccion'];
        $this->cod_carrera = $_POST['cod_carrera'];
        // se modifican los datos del estudiante
        $this->db->update('ESTUDIANTE', $this);
    }
	public function VerCarreras()
	{
		$sql="SELECT * FROM CARRERA"; //código MySQL
		$datos=mysql_query($sql); //enviar código MySQL
		$contador = 0;
		$lista;
		while ($row=mysql_fetch_array($datos)) { //Bucle para ver todos los registros
			$lista[$contador][0] = $row['COD_CARRERA'];
			$lista[$contador][1] = $row['NOMBRE_CARRERA'];
			
			$contador = $contador + 1;
		}
		
		return $lista;
	}
	
	public function VerSecciones()
	{
		$sql="SELECT COD_SECCION FROM SECCION"; //código MySQL
		$datos=mysql_query($sql); //enviar código MySQL
		$contador = 0;
		$lista;
		while ($row=mysql_fetch_array($datos)) { //Bucle para ver todos los registros
			$lista[$contador] = $row['COD_SECCION'];
			$contador = $contador + 1;
		}
		
		return $lista;
	}
	
}
 
?>
