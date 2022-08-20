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
 
   require $base . '/Back-End-Systems/S-ADempiere-Supreme/Orden_Venta_SUP.php';

  class TimerADempiereSUP{
 
     public function actualizaLineaOrdenVenta(){
 
       $OV = new OrdenVentaADempiereSUP();
       $OV->actualizaCampoLineaOrdenVenta();
 
     }

  }
 
  switch($evento){
 
     case 'OrdenVentaLinea': 
       $Timer = new TimerADempiereSUP();
       $Timer->actualizaLineaOrdenVenta(); 
 
     break;
 
    }
?>    