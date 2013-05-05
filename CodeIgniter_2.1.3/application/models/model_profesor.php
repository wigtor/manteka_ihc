<?php
class Model_profesor extends CI_Model {
   public $rut_profesor = 0;
    var $nombre_profesor = '';
    var $nombre2_profesor ='';
    var $apellido_paterno ='';
    var $apellido_materno='';
    var $correo_prof1='';
    var $correo_prof2='';
    var $telefono='';
    var $tipo=''; // se refiere a si es profesor normal o coordinador
//OPERACIÓN PARA INGRESAR PROFESOR    
public function InsertarProfesor() {
        $this->rut_profesor = $_POST['rut_profesor'];
        $this->nombre_profesor = $_POST['nombre_profesor'];
        $this->apellido_paterno = $_POST['apellido_paterno'];
        $this->correo_prof1 = $_POST['correo_prof1'];
        $this->correo_prof2 = $_POST['correo_prof2'];
        $this->telefono = $_POST['telefono'];
        $this->tipo= $_POST['tipo'];

        // inserta los campos guardados en la tabla profesor
        $this->db->insert('PROFESOR', $this);
    }

// OPERACIÓN PARA ELIMINAR PROFESOR
    public function eliminarProfesor($rut_profesor)
    {
       $sql="DELETE FROM PROFESOR WHERE rut_usuario2 = '$rut_profesor' "; //código MySQL
        $datos=mysql_query($sql); //enviar código MySQL
        if($datos == true){
            return 1;
        }
        else{
            return -1;
        }
    }
    
//OPERACIÓN PARA VER A UN PROFESOR
    public function VerProfesor($rut_profesor)
    {
$sql="SELECT * FROM PROFESOR WHERE rut_profesor = '$rut_profesor' "; //código MySQL
		$datos=mysql_query($sql); //enviar código MySQL
		$row=mysql_fetch_array($datos);
		$profesor[0] = $row['RUT_USUARIO2'];
		$profesor[1] = $row['NOMBRE1_PROFESOR'];
        $profesor[2] = $row['NOMBRE2_PROFESOR'];
		$profesor[3] = $row['APELLIDO_PROFESOR'];
        $profesor[4] = $row['APELLIDO2_PROFESOR'];
		$profesor [5] = $row['TELEFONO_PROFESOR'];
		$profesor [6] = $row['TIPO_PROFESOR'];
		
		return $profesor;
    }

//OPERACIÓN VER A TODOS LOS PROFESORES
	public function VerTodosLosProfesores()
	{
		$sql="SELECT * FROM PROFESOR ORDER BY APELLIDO_PROFESOR"; //código MySQL
		$datos=mysql_query($sql); //enviar código MySQL
		$contador = 0;
		$lista;
		while ($row=mysql_fetch_array($datos)) { //Bucle para ver todos los registros
			/*$lista[$contador][0] = $row['RUT_PROFESOR'];
			$lista[$contador][1] = $row['NOMBRE_PROFESOR'];
			$lista[$contador][2] = $row['APELLIDO_PATERNO'];
			$lista[$contador][3] = $row['CORREO_PROF1'];
			$lista[$contador][4] = $row['CORREO_PROF2'];
			$lista[$contador][5] = $row['TELEFONO'];
			$lista[$contador][6] = $row['TIPO'];*/

           $lista[$contador][0] = $row['RUT_USUARIO2'];
           $lista[$contador][1] = $row['NOMBRE1_PROFESOR'];
           $lista[$contador][2] = $row['NOMBRE2_PROFESOR'];
           $lista[$contador][3] = $row['APELLIDO_PROFESOR'];
           $lista[$contador][4] = $row['APELLIDO2_PROFESOR'];
           $lista[$contador][5] = $row['TELEFONO_PROFESOR'];
            $lista[$contador][6]= $row['TIPO_PROFESOR'];
			$contador = $contador + 1;
		}
		return $lista;
		}

//OPERACIÓN EDITAR PROFESOR
    public function EditarProfesor($rut_profesor)
    {
        $this->rut_profesor = $_POST['rut_profesor'];
        $this->nombre_profesor = $_POST['nombre_profesor'];
        $this->apellido_paterno = $_POST['apellido_paterno'];
        $this->correo_prof1 = $_POST['correo_prof1'];
        $this->correo_prof2 = $_POST['correo_prof2'];
        $this->telefono = $_POST['telefono'];
        $this->tipo= $_POST['tipo'];

        // se modifican los datos del profesor
        $this->db->update('PROFESOR', $this);
    }
}

    
//}
?>
