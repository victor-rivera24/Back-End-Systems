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
 
   require $base . '/Back-End-Systems/S-Cerberus/EmpleadoCerberus.php';

  class TimerEmpleadoCerberus{
 
     public function procesar_Baja_EmpleadoUsuario_Surver(){
 
       $cerberus = new EmpleadoCerberus();
       $cerberus->obtenerEmpleadoIncidenciaBaja("Baja-EmpleadoUsuario-Surver");
 
     }

     public function procesar_Baja_Empleado_ADempiere(){
 
      $cerberus = new EmpleadoCerberus();
      $cerberus->obtenerEmpleadoIncidenciaBaja("Baja-Empleado-ADempiere");

    }


  }
 
  switch($evento){
 
     case 'Baja-EmpleadoUsuario-Surver': 
       $Timer = new TimerEmpleadoCerberus();
       $Timer->procesar_Baja_EmpleadoUsuario_Surver(); 
 
     break;

     case 'Baja-Empleado-ADempiere': 
      $Timer = new TimerEmpleadoCerberus();
      $Timer->procesar_Baja_Empleado_ADempiere(); 

    break;     
   
 
    }
?>    