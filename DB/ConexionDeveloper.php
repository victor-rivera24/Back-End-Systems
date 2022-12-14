<?php
 
$base = dirname(dirname(__FILE__));
include_once $base . '/Conexiones/Developer_Remoto.php';
//include_once("../Conexiones/default_dev_line.php");

class ConexionDeveloper
{

    private $connect = null;

	public function abrirConexion()
	{
        if(!isset($connect)){

            try
            {
                //$connect = new PDO("pgsql:host=".config::$SERVER;.";port=".config::$PORT;.";dbname=".config::$DB;."", config::$USER;, config::$PASS;);
                $connect = new PDO("pgsql:host=".SERVIDOR_Dev.";port=".PUERTO_Dev.";dbname=".BASEDATOS_Dev."", USUARIO_Dev, CONTRASENIA_Dev);
                $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $connect->exec('SET search_path TO '.ESQUEMA_Dev.'');
    
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
