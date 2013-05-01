<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Php extends CI_Controller {

  function login()
   {
		
      if(!isset($_POST['inputRut'])){   //   Si no recibimos ningún valor proveniente del formulario, significa que el usuario reci?n ingresa.   
         $this->load->view('login');      //   Por lo tanto le presentamos la pantalla del formulario de ingreso.
      }
      else{                        //   Si el usuario ya pasó por la pantalla inicial y presionó el botón "Ingresar"
         $this->form_validation->set_rules('inputRut','','required');      //   Configuramos las validaciones ayudandonos con la librer?a form_validation del Framework Codeigniter
         $this->form_validation->set_rules('inputPassword','password','required');
         if(($this->form_validation->run()==FALSE)){ //   Verificamos si el usuario super? la validaci?n
            $this->load->view('login'); //   En caso que no, volvemos a presentar la pantalla de login
         }
         else{ //   Si ambos campos fueron correctamente rellanados por el usuario,
            $this->load->model('model_usuario');
            $ExisteUsuarioyPassoword=$this->model_usuario->ValidarUsuario($_POST['inputRut'],$_POST['inputPassword']);   //   comprobamos que el usuario exista en la base de datos y la password ingresada sea correcta
            if($ExisteUsuarioyPassoword){   // La variable $ExisteUsuarioyPassoword recibe valor TRUE si el usuario existe y FALSE en caso que no. Este valor lo determina el modelo.
				      $newdata = array(
                   'rut'  => $ExisteUsuarioyPassoword->RUT_USUARIO,
                   'email'     => $ExisteUsuarioyPassoword->CORREO1_USER,
                   'tipo_usuario' => $ExisteUsuarioyPassoword->ID_TIPO,
                   'logged_in' => TRUE
              );
				      $this->session->set_userdata($newdata);
				
				      redirect('/Correo/', 'index');
				    }
            else{   //   Si no logró validar
               //$data['error']="Rut o password incorrecta, por favor vuelva a intentar";
		          $this->session->unset_userdata('rut');
		          $this->session->unset_userdata('email');
              $this->session->unset_userdata('tipo_usuario');
		          $this->session->unset_userdata('loggued_in');
              redirect('/Login/', 'refresh'); //   Lo regresamos a la pantalla de login y pasamos como par?metro el mensaje de error a presentar en pantalla
            }
         }
      }
   }
   
   function logout() {
		$this->load->library('session');
		$this->load->helper('url');
		$this->session->unset_userdata('rut');
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('loggued_in');
		redirect('/Login/', 'refresh'); //   Lo regresamos a la pantalla de login y pasamos como par?metro el mensaje de error a presentar en pantalla
   }
}
?>