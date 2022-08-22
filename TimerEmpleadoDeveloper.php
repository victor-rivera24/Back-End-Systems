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
 
   require $base . '/Back-End-Systems/S-Developer/Dev_Empleado.php';

   /** En esta clase es para ejecutar las desactivacion por medio del CRONTAB */


  class TimerEmpleadoDeveloper{
 
     public function listadoEmpleadoBaja_Developer_Surver(){

       $empleado = new Empleado();
       $empleado->consultaDeveloperEmpleadoCerberus('Baja-EmpleadoUsuario-Surver');
 
     }

     public function listadoEmpleadoBaja_Developer_ADempiere(){

      $empleado = new Empleado();
      $empleado->consultaDeveloperEmpleadoCerberus('Baja-Empleado-ADempiere');

    }

    
    public function listadoUsuarioBaja_Developer_ADempiere(){

      $empleado = new Empleado();
      $empleado->consultaDeveloperEmpleadoCerberus('Baja-EmpleadoUsuario-ADempiere');

    }    


  }
 
  switch($evento){
 
    case 'Empleado_Developer': 
       $Timer = new TimerEmpleadoDeveloper();
       $Timer->listadoEmpleadoBaja_Developer_Surver(); 
 
    break;
   
    case 'Empleado_ADempiere': 
      $Timer = new TimerEmpleadoDeveloper();
      $Timer->listadoEmpleadoBaja_Developer_ADempiere(); 

    break;

    case 'Empleado_Usuario_ADempiere': 
      $Timer = new TimerEmpleadoDeveloper();
      $Timer->listadoUsuarioBaja_Developer_ADempiere(); 

    break;



    }
?>    