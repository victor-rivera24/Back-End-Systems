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

require $base . '/Back-End-Systems/S-Surver/NotificacionIncidencias.php';

class TimerNotificacionIncidencias
{

    public function procesarNotificacionMes()
    {

        $encuesta = new NotificacionIncidencias();
        $encuesta->procesaNotificacion('enviaMailMes');
    }

    public function procesarNotificacionSemestral()
    {
        $encuesta = new NotificacionIncidencias();
        $encuesta->procesaNotificacion('enviaMail6Meses');
    }
}

switch ($evento) {

    case 'enviaMailMes':
        $Timer = new TimerNotificacionIncidencias();
        $Timer->procesarNotificacionMes();

        break;

    case 'enviaMail6Meses':
        $Timer = new TimerNotificacionIncidencias();
        $Timer->procesarNotificacionSemestral();

    break;
}


//  $proceso = new TimerNotificacionIncidencias();
// //  $proceso->procesarNotificacionMes();
//  $proceso->procesarNotificacionMes();