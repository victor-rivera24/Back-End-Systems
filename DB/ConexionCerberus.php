<?php
 
$base = dirname(dirname(__FILE__));
include_once $base . '/Conexiones/Cerberus_Remoto.php';

class ConexionCerberus
{
    private $connect = null;

	public function abrirConexion()
	{
        if(!isset($connect)){

            try
            {
                //$connect = new PDO("pgsql:host=".config::$SERVER;.";port=".config::$PORT;.";dbname=".config::$DB;."", config::$USER;, config::$PASS;);
                $connect = new PDO("sqlsrv:server=".SERVIDOR_Cerberus.";database=".BASEDATOS_Cerberus."", USUARIO_Cerberus, CONTRASENIA_Cerberus);
                $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //$connect->exec('SET search_path TO '.ESQUEMA_New.'');
                //print_r($connect);
                return $connect;

            }
            catch(PDOException $e) 
            {
                echo 'Falló la conexión: ' . $e->getMessage();
                die();
            }
        }
	}

	public function cerrarConexion()
	{
        if(isset($connect)){
            $connect = null;
        }
	}

	public function obtenerConexion()
	{
        if(isset($connect)){
            echo "Conexion Establecida";
        }else{
            echo "No hay Conexion Establecida";

        }
	}

    // //serverName\instanceName, portNumber (por defecto es 1433)
    // $serverName = "172.16.107.112\\MSSQLSERVER, 1433"; 
    // $connectionInfo = array( "Database"=>"Zeus", "UID"=>"sa", "PWD"=>"Compac12");
    // $conn = sqlsrv_connect( $serverName, $connectionInfo);
    // if( $conn ) {
    //     echo "Conexión establecida.<br />";
    // }else{
    //     echo "Conexión no se pudo establecer.<br />";
    //     die( print_r( sqlsrv_errors(), true));
    // }
    // $query = "SELECT top(100)
    // nombreEmpleado
    // ,apPatEmpleado
    // ,apMatEmpleado FROM Empleado WHERE idEmpresa = 5 AND esActivo = 1";
    // $res =  sqlsrv_query($conn, $query, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET ));
    // if (0 !== sqlsrv_num_rows($res)){
    //     while ($fila = sqlsrv_fetch_array($res)) {
    //         echo "Personal: ".utf8_encode($fila['nombreEmpleado'])." "
    //             .utf8_encode($fila['apPatEmpleado'])." "
    //             .utf8_encode($fila['apMatEmpleado']);
    //         echo "<br>";
    //     }
    // }
}

// $conx = new ConexionCerberus();

// $conx->abrirConexion();
// $conx->obtenerConexion();



?>
