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
 
   require $base . '/Back-End-Systems/S-ADempiere/OrdenVenta_RFV.php';

  class TimerADempiereRFV{
 
     public function buscaOrdenesVentaEcommereCompleta(){
 
       $orden = new RFV_OrdenVenta();
       $orden->ordenVentaEcommerce();
 
     }

  }
 
  switch($evento){
 
     case 'OrdenVentaEcommerce': 
       $Timer = new TimerADempiereRFV();
       $Timer->buscaOrdenesVentaEcommereCompleta(); 
 
     break;
 
    }
?>    