<?php
$date = date("Y-m-d");
$base = dirname(dirname(__FILE__));

if (isset($argv[1])) {
    print $argv[1];
    echo PHP_EOL;
    echo $date;
    echo PHP_EOL;
    $evento = $argv[1];
} else {
    $evento = null;
}

require $base . '/Back-End-Systems/S-Surver/ServicioCambiosSurver.php';

class TimerActualizacionSurverPuesto
{
    public function procesoAutomaticoPuestoSurver(){
        $iniciarProceso = new ServicioCambiosSurver();
        $iniciarProceso->iniciarProceso();
    }
}

switch($evento){
    case 'actualizacionCerberus-Surver':
        $resultado = new TimerActualizacionSurverPuesto();
        $resultado -> procesoAutomaticoPuestoSurver();
    break;
}

$proceso = new TimerActualizacionSurverPuesto();
$proceso -> procesoAutomaticoPuestoSurver();