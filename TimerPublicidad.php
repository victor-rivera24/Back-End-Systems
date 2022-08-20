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
 
   require $base . '/Back-End-Systems/S-New-UI-Sync/AmorEsensPlantillaCorreo.php';

  class TimerPublicidad{
 
     public function procesarPublicidad($vID){
 
       $plantilla = new AmorEsensPlantillaCorreo();
       $plantilla->ObtenerCorreos($vID);
 
     }

  }
 
    switch($evento){
 
        case 'Diario': 
            $EnvioTimer = new TimerPublicidad();
            $EnvioTimer->procesarPublicidad(1); 
        break;

        case 'Mensual': 
            $EnvioTimer = new TimerPublicidad();
            $EnvioTimer->procesarPublicidad(2); 
        break;        
 
        case 'Semanal': 
          $EnvioTimer = new TimerPublicidad();
          $EnvioTimer->procesarPublicidad(3); 
      break;              
    }



?>    