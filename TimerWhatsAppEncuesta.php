<?php
   $date = date("Y-m-d");
   $base = dirname(dirname(__FILE__));

   if (isset($argv[1])) {
       print $argv[1];
       echo PHP_EOL;
       echo $date;
       echo PHP_EOL;
       $evento = $argv[1];
   }else {
     $evento = null;
   }
 
   require $base . '/Back-End-Systems/S-Surver/Encuesta.php';

  class TimerWhatsAppEncuesta{
 
    public function envioMensajePruebaIndivual(){
 
      $encuesta = new Encuesta();
      $encuesta->envioMensajePrueba();

    }

     public function envioMensajeEncuestaUsuarioFaltante(){
 
       $encuesta = new Encuesta();
       $encuesta->consultaEmpleadoEncuesta();
 
     }

  }
 
  switch($evento){
 
    case 'Prueba-WhatsApp': 
      $Timer = new TimerWhatsAppEncuesta();
      $Timer->envioMensajePruebaIndivual(); 

    break;

     case 'Encuesta-Covid': 
       $Timer = new TimerWhatsAppEncuesta();
       $Timer->envioMensajeEncuestaUsuarioFaltante(); 
 
     break; 
 
    }
?>    