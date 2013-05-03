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

   /*
   *  Función para autentificarse en el sistema mediante una cuenta Google.
   *  El Controlador solicita la autentificación a Google.
   *  Una vez realizado esto, el usuario se autentifica normalmente.
   */
   function signInGoogle($provider){

    $this -> load -> helper('url');
    $this->load->library('session');
    $this -> load -> spark('oauth2/0.4.0');
   //si el proveedor pasado es foursquare
    if($provider == 'foursquare')
    {
        //$provider = $this -> oauth2 -> provider($provider, array(
        //'id' => 'tu_app_id_de_foursquare',
        //'secret' => 'tu_app_secret_de_foursquare', ));
       //si el proveedor pasado es google
    }else if($provider == 'google')
    {
        $provider = $this -> oauth2 -> provider($provider, array(
        'id' => '412900046548.apps.googleusercontent.com',
        'secret' => 'RN_R-d6BDT2XYwQdVHB5S9tO', ));
    }

    if (!$this -> input -> get('code')) {
        // By sending no options it'll come back here
        $url = $provider -> authorize();

        redirect($url);
    } else {
        try {
            // Have a go at creating an access token from the code
            $token = $provider -> access($this->input->get('code'));

            // Use this object to try and get some user details (username, full name, etc)
            $user = $provider->get_user_info($token); 

            // Here you should use this information to A) look for a user B) help a new user sign up with existing data.
            // If you store it all in a cookie and redirect to a registration page this is crazy-simple.
            //echo "<pre>Tokens: ";
            //var_dump($token);

            //echo "\n\nUser Info: ";
            //var_dump($user);
            $mail = $user['email'];
            echo "Mi correo es: ". $mail;
        } catch (OAuth2_Exception $e) {
            echo "Error";
            //show_error('That didnt work: ' . $e);
        }
    }

   }

}
?>