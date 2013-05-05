<?php
class Model_ayudante extends CI_Model {
   public $rut_ayudante = 0;
    var $nombre1_ayudante = '';
    var $nombre2_ayudante = '';
    var $apellido1_ayudante='';
    var $apellido2_ayudante='';    
    var $correo_ayudante='';

//OPERACIÓN PARA INGRESAR AYUDANTE    
public function InsertarAyudante( $rut_ayudante, $nombre1_ayudante, $nombre2_ayudante, $apellido1_ayudante, $apellido2_ayudante, $correo_ayudante, $cod_profesor) {
		$data1 = array(					
					'RUT_AYUDANTE' => $rut_ayudante ,
					'NOMBRE1_AYUDANTE' => $nombre1_ayudante ,
					'NOMBRE2_AYUDANTE' => $nombre2_ayudante ,
					'APELLIDO_PATERNO' => $apellido1_ayudante ,
					'APELLIDO_MATERNO' => $apellido2_ayudante,
					'CORREO_AYUDANTE' => $correo_ayudante 
		);
        $datos1 = $this->db->insert('ayudante',$data1);
		
		$data2 = array(					
					'RUT_USUARIO2' => $cod_profesor,
					'RUT_AYUDANTE' => $rut_ayudante 
		);
        $datos2 = $this->db->insert('ayu_profe',$data2);
		
		
		if($datos1 && $datos2){
			return 1;
		}
		else{
			return -1;
		}
		
    }

// OPERACIÓN PARA ELIMINAR AYUDANTE
    public function EliminarAyudante($rut_ayudante)
    {
		$sql="DELETE FROM AYUDANTE WHERE RUT_AYUDANTE = '$rut_ayudante' "; //código MySQL
		$datos=mysql_query($sql); //enviar código MySQL
		if($datos == true){
			return 1;
		}
		else{
			return -1;
		}
    }
    
//OPERACIÓN PARA VER A UN AYUDANTE
    public function VerAyudante($rut_ayudante)
    {
$sql="SELECT * FROM AYUDANTE WHERE rut_ayudante = '$rut_ayudante' "; //código MySQL
  	$datos=mysql_query($sql); //enviar código MySQL
		$row=mysql_fetch_array($datos);
    $ayudante;
		$ayudante[0] = $row['RUT_AYUDANTE'];
		$ayudante[1] = $row['NOMBRE1_AYUDANTE'];
  	$ayudante[2] = $row['NOMBRE2_AYUDANTE'];
		$ayudante[3] = $row['APELLIDO1_AYUDANTE'];
  	$ayudante[4] = $row['APELLIDO2_AYUDANTE'];
		$ayudante[5] = $row['CORREO_AYUDANTE'];
		return $ayudante;
    }

//OPERACIÓN VER A TODOS LOS AYUDANTES
	public function VerTodosLosAyudantes()
	{
		$sql="SELECT * FROM AYUDANTE ORDER BY APELLIDO_PATERNO"; //código MySQL
		$datos=mysql_query($sql); //enviar código MySQL
		$contador = 0;
		$lista;
		while ($row=mysql_fetch_array($datos)) { //Bucle para ver todos los registros
			$lista[$contador][0] = $row['RUT_AYUDANTE'];
			$lista[$contador][1] = $row['NOMBRE1_AYUDANTE'];
			$lista[$contador][2] = $row['NOMBRE2_AYUDANTE'];
			$lista[$contador][3] = $row['APELLIDO_PATERNO'];
			$lista[$contador][4] = $row['APELLIDO_MATERNO'];
			$lista[$contador][5] = $row['CORREO_AYUDANTE'];
			$contador = $contador + 1;
		}
		
		return $lista;
		}
		
	public function VerTodosLosProfesores()
	{
		$sql="SELECT * FROM PROFESOR ORDER BY NOMBRE1_PROFESOR"; //código MySQL
		$datos=mysql_query($sql); //enviar código MySQL
		$contador = 0;
		$lista;
		while ($row=mysql_fetch_array($datos)) { //Bucle para ver todos los registros
			$lista[$contador][0] = $row['RUT_USUARIO2'];
			$lista[$contador][1] = $row['NOMBRE1_PROFESOR'];
			$lista[$contador][2] = $row['APELLIDO1_PROFESOR'];
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




//OPERACIÓN EDITAR AYUDANTE
    public function EditarAyudante($rut_ayudante)
    {
        $this->rut_ayudante = $_POST['rut_ayudante'];
        $this->nombre1_ayudante = $_POST['nombre1_ayudante'];
        $this->nombre2_ayudante = $_POST['nombre2_ayudante'];
        $this->apellido1_ayudante = $_POST['apellido1_ayudante'];
        $this->apellido2_ayudante = $_POST['apellido2_ayudante'];
        $this->correo_ayudante = $_POST['correo_ayudante'];

        // se modifican los datos del ayudante
        $this->db->update('AYUDANTE', $this);
    }
}

?>
