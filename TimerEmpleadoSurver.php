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
 
   require $base . '/Back-End-Systems/S-Surver/EmpleadoFelizCumple.php';

  class TimerEmpleadoSurver{
 
     public function notificarEmpleadoFelizCumple(){
 
       $surver = new EmpleadoFelizCumple();
       $surver->consultaEmpleadoFelizCumple();
 
     }

  }
 
  switch($evento){
 
     case 'Feliz-Cumple': 
       $Timer = new TimerEmpleadoSurver();
       $Timer->notificarEmpleadoFelizCumple(); 
 
     break; 
 
    }
?>    