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
 
    require $base . '/Back-End-Systems/S-New-UI-Sync/ConsultaAPI.php';

    class TimerXML{
        public function ConsumirAPI(){
           $surver = new ConsultaApi();
           $surver->consultaServicioApi();
        }
    }
 
    switch($evento){
      case 'ConsumirApi': 
        $Timer = new TimerXML();
        $Timer->ConsumirAPI(); 
      break; 
    }

    $orden = new TimerXML();
    $orden->ConsumirAPI();
?>    