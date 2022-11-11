<?php
$base = dirname(dirname(__FILE__));

include_once $base . '/Email/Email.php';
include_once $base . '/Email/mailFaltas.php';
ini_set('memory_limit', -1);

class NotificacionIncidencias
{
    public static $url;
    public static $api_key;
    public static $meses;

    public static function inicializacion()
    {
        self::$url = 'https://apps.refividrio.com.mx:5858/api/';
        self::$api_key = 'surver_$MGsecretkey$Surver$NodeJS&ApiCerberus';
        self::$meses = ['N/A', 'ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];
    }

    /*** Consumo de Servicions con Api Cerberus */
    public function procesaNotificacion($accion)
    {
        $url = self::$url . 'AccesoNotificacion';

        try {
            $ch = curl_init($url);

            $jsonData = array(
                'API_KEY' => 'surver_$MGsecretkey$Surver$NodeJS&ApiCerberus',
                'generarAcceso' => true
            );

            $jsonDataEncoded = json_encode($jsonData);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            $result = curl_exec($ch);
            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($status !== 201 && $status !== 200) {
                return ("Error: call to URL $url failed with status $status, response $result, curl_error " . curl_error($ch) . ", curl_errno " . curl_errno($ch));
            }
            curl_close($ch);
            $result = json_decode($result);
            // return  json_decode($result);
        } catch (\Throwable $th) {
            echo $th;
            return false;
        }
        if ($accion == 'enviaMailMes') {
            NotificacionIncidencias::obtenerDatosMes($result->data->token, 'getByMonth');
        } else if ($accion == 'enviaMail6Meses') {
            NotificacionIncidencias::obtenerDatosMes($result->data->token, 'getBy6Month');
        }
    }

    public function obtenerDatosMes($token, $metodo)
    {
        try {
            $url = self::$url . $metodo;
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'token:' . $token));
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($ch);
            curl_close($ch);
            $result = json_decode($result, true);
            NotificacionIncidencias::AgruparColeccion($result, $token, $metodo);
        } catch (\Throwable $th) {
            echo $th;
            return false;
        }
    }

    public function obtenerLideres($idDepto, $token)
    {
        try {

            $url = self::$url . 'getLiderByID?idDepartamento=' . $idDepto;
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'token:' . $token));
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($ch);
            curl_close($ch);
            $result = json_decode($result, true);

            return $result;
        } catch (\Throwable $th) {
            echo $th;
            return false;
        }
    }

    public function agregarIncidencias($token, $parametros){
        try {
            $url = self::$url . 'NotificacionIncidencias';
            $ch = curl_init($url);
            $data_string = json_encode($parametros);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'token:' . $token));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            $result = curl_exec($ch);
            // echo json_encode($result);
            // return  json_decode($result);
            return true;
        } catch (\Throwable $th) {
            echo $th;
            return false;
        }

    }

    /** Validaciones  */
    public function validarExistencia($array, $valorBusqueda, $field = null)
    {
        foreach ($array as $value) {
            if ($field == null) {
                if ($value == $valorBusqueda) {
                    return true;
                }
            } else {
                if ($value[$field] == $valorBusqueda) {
                    return true;
                }
            }
        }
        return false;
    }

    public function buscarRegistro($array, $valorBusqueda, $field, $fieldRespuesta)
    {
        foreach ($array as $value) {
            if ($value[$field] == $valorBusqueda) {
                return $value[$fieldRespuesta];
            }
        }
        return false;
    }

    /** prcesamiento de datos  */
    public function AgruparColeccion($result, $token, $metodo)
    {
        $msgs = '';
        $arrayDepartamentos = array();
        foreach ($result['data'] as $incidencia) {
            $valor = NotificacionIncidencias::validarExistencia($arrayDepartamentos, $incidencia["idDepartamento"]);
            if ($valor === false) {
                $arrayDepartamentos[] =  $incidencia["idDepartamento"];
            }
        }

        foreach ($arrayDepartamentos as $idDepartamento) {
            $cadenaMail = "";
            $arrayEmpleados = array();

            foreach ($result['data'] as $incidencia) {
                $valor = NotificacionIncidencias::validarExistencia($arrayEmpleados, $incidencia["idEmpleado"]);

                if ($valor === false && $incidencia["idDepartamento"] == $idDepartamento) {
                    $arrayEmpleados[] =  $incidencia["idEmpleado"];
                }
            }

            $cadenaMail = '<h1>' . $this->buscarRegistro($result['data'], $idDepartamento, "idDepartamento", "nombreDepartamento") . '</h1>';
            foreach ($arrayEmpleados as $idEmpleado) {
                $cadenaMail .= '<h3> (' . $idEmpleado . ') ' . $this->buscarRegistro($result['data'], $idEmpleado, "idEmpleado", "nEmpleado") . '</h3>';
                foreach ($result['data'] as $incidencia) {
                    if ($incidencia["idEmpleado"] == $idEmpleado) {
                        $cadenaMail .= ('Falta: ' . $incidencia["fecha"] . '<br>');
                    }
                }
            }
            if ($cadenaMail != '') {

                $sendMail = false;
                $respuestaEmail = false;
                $tipoNotificacion = null;

                if($metodo == 'getByMonth'){ $tipoNotificacion = 'faltasMes'; } else { $tipoNotificacion = 'faltas6Meses'; }

                $lideres = NotificacionIncidencias::obtenerLideres($idDepartamento, $token);
                foreach ($lideres['data'] as $lider) {
                    $mensaje = new msgFaltas();

                    if ($metodo == 'getByMonth') {
                        $msgs = $mensaje->get_msg($cadenaMail, true, "MES DE " . self::$meses[$lider["mesActual"]]);
                        $respuestaEmail = $this->sendEmail(
                            $msgs,
                            $this->buscarRegistro($result['data'], $idDepartamento, "idDepartamento", "nombreDepartamento") . ": FALTAS (" . self::$meses[$lider["mesActual"]] . ")",
                            $lider["correoEmpresa"],
                            $lider["nEmpleado"]
                        );
                    } else {
                        $msgs = $mensaje->get_msg($cadenaMail, false, $lider["periodo"]);
                        $respuestaEmail = $this->sendEmail(
                            $msgs,
                            $this->buscarRegistro($result['data'], $idDepartamento, "idDepartamento", "nombreDepartamento") . ": FALTAS (" . $lider["periodo"] . ")",
                            $lider["correoEmpresa"],
                            $lider["nEmpleado"]
                        );
                    }
                }
            }
            if ($respuestaEmail == 'Correo Enviado') {
                $sendMail = true;
                echo $respuestaEmail, ' a: ', $lider["nEmpleado"], ' con correo: ', $lider["correoEmpresa"], '<br>';
            } else {
                echo 'Error al conectarse al servidor de correo';
            }

            if ($sendMail) {
                $index = 1;
                $totalParametros = array();
                foreach ($result['data'] as $incidencia) {
                    if ($incidencia["idDepartamento"] == $idDepartamento && $incidencia["esNotificado"] == 0) {
                        $params = array(
                            "idEmpleado" => $incidencia["idEmpleado"], "idLider" =>  $incidencia["idEmpleado"], "idIncidencia" =>  $incidencia["idIncidencia"], "tipoNotificacion" => $tipoNotificacion
                        );
                        $totalParametros[] = $params;
                    }
                    $index = $index + 1;
                }
                $insert = $this->agregarIncidencias($token,array("enviado"=>$totalParametros));
                if($insert){
                    echo 'Incidencias agregadas';
                } else {
                    echo 'incidencias no guardadas';
                }
            }
        }
    }


    public function sendEmail($msg, $subject, $correo, $empleado)
    {

        if (isset($correo)) {
            $instancia_correo = new Email();
            $resultadoCorreoElectronico = $instancia_correo->CorreoNotificacionIncidencias($msg, $subject, $correo, $empleado);
            return $resultadoCorreoElectronico;
        } else {
            return 'Usuario sin Correo';
        }
    }
}
NotificacionIncidencias::inicializacion();
