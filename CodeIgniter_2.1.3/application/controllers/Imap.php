<?php 
$inbox         = imap_open('{imap.gmail.com:993/imap/ssl}INBOX', 'diego.gomez.lira@gmail.com', 'aA205243'); 

$emails = imap_search($inbox, 'SUBJECT "Delivery Status Notification (Failure)" UNSEEN'); 


if($emails == ''){

}else{
    foreach($emails as $email_number) {
  $message = imap_body($inbox, $email_number);
  $str = strstr($message,'Ver mensaje en su contexto:');
  $str = substr($str, 27);

    $this->load->model('model_rebotes');
    $resultado = $this->model_rebotes->eliminarRebote($str);
    $this->model_rebotes->notificacionRebote($resultado['cuerpo'],$resultado['rut']);
}
}
imap_close($inbox);
?>