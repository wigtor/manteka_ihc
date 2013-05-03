<?php
 
class Carta extends CI_Model {
    int  rut_usuario = '';
    var nombre1_estudiante = '';
    var nombre2_estudiante  = '';
    var apellido_paterno='';
    var apellido_materno='';
    var correo_estudiante='';
    var cod_seccion='';
    var cod_carrera='';
 
// Modelo para insertar y eliminar un estudiante. No se si est? completamente correcto la verdad, no lo he podido probar
 
    public function InsertarEstudiante() {
        $this->rut_estudiante = $_POST['rut_estudiante'];
        $this->nombre1_estudiante = $_POST['nombre1_estudiante'];
        $this->nombre2_estudiante = $_POST['nombre2_estudiante'];
        $this->apellido_paterno = $_POST['apellido_paterno'];
        $this->apellido_materno = $_POST['apellido_materno'];
        $this->correo_estudiante = $_POST['correo_estudiante'];
        $this->cod_seccion = $_POST['cod_seccion'];
        $this->cod_carrera = $_POST['cod_carrera'];


        // inserta los campos guardados en la tabla estudiante
        $this->db->insert('ESTUDIANTE', $this);
    }

    public function EliminarEstudiante($rut_estudiante)
    {
        $db->query("DELETE FROM ESTUDIANTE WHERE rut_estudiante = '$rut_estudiante' ");
    }
    
//operaciones para ver y editar datos de un estudiante


    public function VerEstudiante($rut_estudiante)
    {
        $db->query("SELECT * FROM ESTUDIANTE WHERE rut_estudiante = '$rut_estudiante' ");
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
}
 
?>
