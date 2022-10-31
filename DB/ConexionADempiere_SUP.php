<?php
 
$base = dirname(dirname(__FILE__));
include_once $base . '/Conexiones/ADempiere_SUPREME_Remoto.php';

class ConexionADempiereSUP
{

    private $connect = null;

	public function abrirConexion()
	{
        if(!isset($connect)){

            try
            {
                //$connect = new PDO("pgsql:host=".config::$SERVER;.";port=".config::$PORT;.";dbname=".config::$DB;."", config::$USER;, config::$PASS;);
                $connect = new PDO("pgsql:host=".SERVIDOR_RFV.";port=".PUERTO_RFV.";dbname=".BASEDATOS_RFV."", USUARIO_RFV, CONTRASENIA_RFV);
                $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $connect->exec('SET search_path TO '.ESQUEMA_RFV.'');
    
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
