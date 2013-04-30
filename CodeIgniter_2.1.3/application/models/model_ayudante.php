<?php
class Model_ayudante extends CI_Model {
   public $rut_ayudante = 0;
    var $nombre1_ayudante = '';
    var $nombre2_ayudante = '';
    var $apellido1_ayudante='';
    var $apellido2_ayudante='';    
    var $correo_ayudante='';

//OPERACIÓN PARA INGRESAR AYUDANTE    
public function InsertarAyudante() {
        $this->rut_ayudante = $_POST['rut_ayudante'];
        $this->nombre1_ayudante = $_POST['nombre1_ayudante'];
        $this->nombre2_ayudante = $_POST['nombre2_ayudante'];
        $this->apellido1_ayudante = $_POST['apellido1_ayudante'];
        $this->apellido2_ayudante = $_POST['apellido2_ayudante'];
        $this->correo_ayudante = $_POST['correo_ayudante'];

        // inserta los campos guardados en la tabla ayudante
        $this->db->insert('AYUDANTE', $this);
    }

// OPERACIÓN PARA ELIMINAR AYUDANTE
    public function EliminarAyudante($rut_ayudante)
    {
        $db->query("DELETE FROM AYUDANTE WHERE rut_ayudante = '$rut_ayudante' ");
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
		$sql="SELECT * FROM AYUDANTE ORDER BY APELLIDO1_AYUDANTE"; //código MySQL
		$datos=mysql_query($sql); //enviar código MySQL
		$contador = 0;
		$lista;
		while ($row=mysql_fetch_array($datos)) { //Bucle para ver todos los registros
			$lista[$contador][0] = $row['RUT_AYUDANTE'];
			$lista[$contador][1] = $row['NOMBRE1_AYUDANTE'];
			$lista[$contador][2] = $row['NOMBRE2_AYUDANTE'];
			$lista[$contador][3] = $row['APELLIDO1_AYUDANTE'];
			$lista[$contador][4] = $row['APELLIDO2_AYUDANTE'];
			$lista[$contador][5] = $row['CORREO_AYUDANTE'];
			$contador = $contador + 1;
		}
		return $lista;
		}


///////////////////////////////////////7
        $this->rut_ayudante = $_POST['rut_ayudante'];
        $this->nombre1_ayudante = $_POST['nombre1_ayudante'];
        $this->nombre2_ayudante = $_POST['nombre2_ayudante'];
        $this->apellido1_ayudante = $_POST['apellido1_ayudante'];
        $this->apellido2_ayudante = $_POST['apellido2_ayudante'];
        $this->correo_ayudante = $_POST['correo_ayudante'];

////////////////////////////////////////77


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
