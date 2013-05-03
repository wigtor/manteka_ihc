<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Php extends CI_Controller {

  function login()
   {
		
      if(!isset($_POST['inputRut'])){   //   Si no recibimos ningún valor proveniente del formulario, significa que el usuario reci?n ingresa.   
         redirect('/Login/', 'index');
         //$this->load->view('login');      //   Por lo tanto le presentamos la pantalla del formulario de ingreso.
      }
      else{                        //   Si el usuario ya pasó por la pantalla inicial y presionó el botón "Ingresar"
         $this->form_validation->set_rules('inputRut','','required');      //   Configuramos las validaciones ayudandonos con la librer?a form_validation del Framework Codeigniter
         $this->form_validation->set_rules('inputPassword','password','required');
         if(($this->form_validation->run()==FALSE)){ //   Verificamos si el usuario super? la validaci?n
            redirect('/Login/', 'index');
            //$this->load->view('login'); //   En caso que no, volvemos a presentar la pantalla de login
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
    $rut = $this->session->userdata('rut'); //Se comprueba si el usuario tiene sesión iniciada
    if ($rut == TRUE) {
      redirect('/Correo/', 'index');         // En dicho caso, se redirige a la interfaz principal
    }

    $this -> load -> helper('url');
    $this->load->library('session');
    $this -> load -> spark('oauth2/0.4.0');
    //si el proveedor pasado es Google
    if($provider == 'google')
    {
        $provider = $this -> oauth2 -> provider($provider, array(
        'id' => '412900046548.apps.googleusercontent.com',
        'secret' => 'RN_R-d6BDT2XYwQdVHB5S9tO', ));
    }

    if (!$this -> input -> get('code')) {
        $url = $provider -> authorize();

        redirect($url);
    } else {
        try {
            // Se posee de un Token exitoso enviado por google
            $token = $provider -> access($this->input->get('code'));

            // Se obtiene la información del usuario (Nombre, mail, dirección, foto)
            $user = $provider->get_user_info($token); 

            // Correo del usuario ingresado
            $mail = $user['email'];
            
            //Cargando modelo para validar correo del usuario ingresado con algún registro en la db
            $this->load->model('model_usuario');
            
            /*
              * Verificando si existe algún usuario con dicho correo electrónico. 
              * Resultado de la consulta del modelo. Falso de no encontrar nada o
              * Las filas correspondientes a los usuarios que posean dicho mail.
            */
            $usuario = $this->model_usuario->existe_mail($mail);
            if ($usuario)
            {
              $newdata = array(
                   'rut'  => $usuario->RUT_USUARIO,
                   'email'     => $usuario->CORREO1_USER,
                   'tipo_usuario' => $usuario->ID_TIPO,
                   'logged_in' => TRUE
              );
              $this->session->set_userdata($newdata);
              redirect('/Correo/', 'index');         // En dicho caso, se redirige a la interfaz principal
            }
            else // En caso de no existir ningún usuario con correo = $mail
            {
              $datos_plantilla["titulo_msj"] = "Error";
              $datos_plantilla["cuerpo_msj"] = "El correo ingresado no se asocia a ningún usuario del sistema ManteKA";
              $datos_plantilla["tipo_msj"] = "alert-error";

              /* Finalmente muestro la vista que indica que esto fue realizado correctamente */
              $datos_plantilla["title"] = "ManteKA";
              $datos_plantilla["head"] = $this->load->view('templates/head', $datos_plantilla, true);
              $datos_plantilla["banner_portada"] = $this->load->view('templates/banner_portada', '', true);
              
              $datos_plantilla["redirectAuto"] = FALSE; //Esto indica si por javascript se va a redireccionar luego de 5 segundos
              $datos_plantilla["redirecTo"] = "Login/index"; //Acá se pone el controlador/metodo hacia donde se redireccionará
              //$datos_plantilla["redirecFrom"] = "Login/olvidoPass"; //Acá se pone el controlador/metodo desde donde se llegó acá, no hago esto si no quiero que el usuario vuelva
              $datos_plantilla["nombre_redirecTo"] = "Inicio de sesión"; //Acá se pone el nombre del sitio hacia donde se va a redireccionar
              //$this->load->view('templates/big_msj_deslogueado', $datos_plantilla);


            }

            
        } catch (OAuth2_Exception $e) {
            show_error('No se pudo loguear mediante Google :(: ' . $e);
        }
    }

   }

}
?>