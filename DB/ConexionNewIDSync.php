<?php

$base = dirname(dirname(__FILE__));
include_once $base . '/Conexiones/NewIDSync_Remoto.php';

class ConexionNewUISync
{
    private $connect = null;

	public function abrirConexion()
	{
        if(!isset($connect)){

            try
            {
                //$connect = new PDO("pgsql:host=".config::$SERVER;.";port=".config::$PORT;.";dbname=".config::$DB;."", config::$USER;, config::$PASS;);
                $connect = new PDO("pgsql:host=".SERVIDOR_New.";port=".PUERTO_New.";dbname=".BASEDATOS_New."", USUARIO_New, CONTRASENIA_New);
                $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $connect->exec('SET search_path TO '.ESQUEMA_New.'');
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

}

// $conx = new ConexionDB();
// $conx->abrirConexion();


?>
