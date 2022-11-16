<?php
$base = dirname(dirname(__FILE__));


ini_set('memory_limit', -1);
include_once $base . '/DB/ConexionSurver.php';


class ServicioCambiosSurver extends ConexionSurver
{
    public static $url;
    public static $api_key;
    public static $meses;

    public static function inicializacion()
    {
        self::$url = 'http://localhost:5860/api/';
        self::$api_key = 'surver_$MGsecretkey$Surver$NodeJS&ApiCerberus';
    }

    /*** Consumo de Servicions con Api Cerberus */
    public function iniciarProceso()
    {
        $url = self::$url . 'login';

        try {
            $ch = curl_init($url);

            $jsonData = array(
                'API_KEY' => 'surver_$MGsecretkey$Surver$NodeJS&ApiCerberus',
                'id_empleado' => 0.1,
                'rol' => 'System'
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

        } catch (\Throwable $th) {
            echo $th;
            return false;
        }
      
        $resultado = ServicioCambiosSurver::obtenerDatos_Actualizar($result->data->token);
        return $resultado;
      
    }

    public function obtenerDatos_Actualizar($token)
    {
        try {
            $url = self::$url . 'ActualizacionPuestos';
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'token:' . $token));
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($ch);
            curl_close($ch);
            $result = json_decode($result, true);
            if( sizeof( $result["data"]) > 0){
                foreach ($result["data"] as $row) {
                    $respuesta = ServicioCambiosSurver::CambioCerberusSurver($row['idEmpleado'], $row['Puesto'], $row['RFC'], $row['idSucursal'], $row['idDepartamento']);
                    switch ($respuesta) {
                        case 'Actualizado':
                            ServicioCambiosSurver::ActualizarCambios($row['idEmpleado'],$row['idCambiosSurver'], $token);
                        break;
                        case 'Error':
                            echo $respuesta;
                        break;
                    }
                   
                }
            } else {
                echo '<br> Sin datos para actualizar...';
            }
           
        } catch (\Throwable $th) {
            echo $th;
            return false;
        }
    }

    public function CambioCerberusSurver($idEmpleado, $Puesto, $Rfc, $idSucursal, $idDepartamento)
	{
        try {

            $query = "UPDATE empleado SET ev_puesto_id = (SELECT ev_puesto_id FROM refividrio.ev_puesto WHERE nombre_puesto = :puesto LIMIT 1)
                                        , fecha_actualizado = CURRENT_TIMESTAMP
                                        , id_cerberus_empleado = :idempleado
                                        , rfc = :Rfc
                                        , id_segmento = (SELECT id_segmento FROM segmento WHERE id_cerberus = :idSucursal)
                                        , departamento_id = (SELECT departamento_id FROM departamento WHERE id_cerberus = :idDepartamento)
                                        WHERE (id_cerberus_empleado = :idempleado OR rfc = :Rfc)";

            $stmt = ConexionSurver::abrirConexion()->prepare($query);
            $stmt->bindParam(':puesto', $Puesto, PDO::PARAM_STR);
            $stmt->bindParam(':Rfc', $Rfc, PDO::PARAM_STR);
            $stmt->bindParam(':idempleado', $idEmpleado, PDO::PARAM_INT);
            $stmt->bindParam(':idSucursal', $idSucursal, PDO::PARAM_INT);
            $stmt->bindParam(':idDepartamento', $idDepartamento, PDO::PARAM_INT);
            $r = $stmt->execute();

            if($r){
                return 'Actualizado';
            }else{
                return 'Error';
            }

        } catch (Exception $exc) {
        
            return $exc;
        }
        ConexionSurver::cerrarConexion();
	}

    public function ActualizarCambios($empleado, $idTabla, $token)
    {
        try {
            $url = self::$url . 'ActualizacionCambiosSurver';
            $ch = curl_init($url);
            $datos = array(
                'idEmpleado' => $empleado,
                'idCambios' => $idTabla
            );
            $data_string = json_encode($datos);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'token:' . $token));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            $result = curl_exec($ch);
            curl_close($ch);

            $result = json_decode($result);
            if($result->status == 'success'){
                echo  'Actualizado Correctamente : '. $idTabla . '<br>';

            } else {
                echo  'Error al actualizar Tabla CambiosSurver';
            }
        } catch (\Throwable $th) {
            echo $th;
            return false;
        }
    }
    

}
ServicioCambiosSurver::inicializacion();
