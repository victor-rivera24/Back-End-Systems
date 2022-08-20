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
 
   require $base . '/Back-End-Systems/S-New-UI-Sync/PlantillaCorreo.php';

  class TimerInformesPDF{
 
     public function enviarInformesPDFs(){
 
       $plantilla = new PlantillaCorreo();
       $plantilla->obtenerListadoPlantilla("INF_CEvsZCS","Informe_CEvsZCS.xls");
 
     }

     public function enviarInformeUltimoMovimientoProducto(){
 
      $plantilla = new PlantillaCorreo();
      $plantilla->obtenerListadoPlantilla("INF_Ult_Mov","Informe_UltimoMovimientoProducto.xls");

    }  
 
    public function enviarInformeProductoCero(){
 
      $plantilla = new PlantillaCorreo();
      $plantilla->obtenerListadoPlantilla("INF_Existencia_Cero","Informe_ExistenciaCero.xls");

    } 

    public function enviarInformeProductoLogiflekk(){
 
      $plantilla = new PlantillaCorreo();
      $plantilla->obtenerListadoPlantilla("INF_Flekk","Informe_ExistenciaCero.xls");

    } 


  }
 
  switch($evento){
 
     case 'INF_CEvsZCS': 
       $InformeTimer = new TimerInformesPDF();
       $InformeTimer->enviarInformesPDFs(); 
 
     break;
 
     case 'INF_Ult_Mov': 
      $InformeTimer = new TimerInformesPDF();
      $InformeTimer->enviarInformeUltimoMovimientoProducto(); 

    break;

    case 'INF_Existencia_Cero': 
      $InformeTimer = new TimerInformesPDF();
      $InformeTimer->enviarInformeProductoCero(); 

    break;    
 
    case 'INF_Flekk': 
      $InformeTimer = new TimerInformesPDF();
      $InformeTimer->enviarInformeProductoLogiflekk(); 

    break;  


    }
?>    