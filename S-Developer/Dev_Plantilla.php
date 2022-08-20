<?php

$base = dirname(dirname(__FILE__));
//echo $base;

include_once $base . '/DB/ConexionDeveloper.php';
include_once $base . '/Email/Email.php';
//include_once $base . '/Dev/Dev_Log.php';

class PlantillaCorreo extends ConexionDeveloper
{
    //protected  $date = date("Y-m-d");
    private $fechaActual;
    private $ruta;
    private $carpeta = '/PDF-ADempiere/';

    public function __construct(){

        $this->fechaActual = date("Y-m-d"); // error is on this line
        $this->ruta =  dirname(dirname(__FILE__));

    }

    public function obtenerListadoPlantilla($vMovimiento,$vInforme)
	{
        $data = array();
        $contador = 0;
        $Encabezado = null;
        $Asunto = null;
        $Descripcion = null;
        $Parametro = null;
        $nombreInforme = ($this->fechaActual."_".$vInforme);
        //echo $nombreInforme;

        $query = "
        SELECT

	p.Nombre AS Plantilla
	,pt.Tipo AS Tipo
	,pl.Nombre AS Nombre
	,pl.Correo AS Correo
	,p.encabezado AS Encabezado
	,p.asunto AS Asunto
	,p.descripcion AS Descripcion
	,p.parametro AS Parametro

	FROM plantilla_correo AS p
		INNER JOIN pantilla_correo_lineas AS pl
			ON pl.id_plantilla_correo = p.id_plantilla_correo
			AND pl.activo = true
		INNER JOIN plantilla_tipo AS pt
			ON pt.id_plantilla_tipo = p.id_plantilla_tipo
	WHERE
		p.activo = true
		AND pt.tipo = 'Baja-Empleado'

	ORDER BY pl.id_plantilla_correo_lineas ASC
        ";

		$stmt = ConexionNewUISync::abrirConexion()->prepare($query);
        $stmt -> execute();
        $resultado = $stmt -> fetchAll();

        foreach ($resultado as $fila) {
            $Encabezado = $fila['encabezado'];
            $Asunto = $fila['asunto'];
            $Descripcion = $fila['descripcion'];
            $Parametro = $fila['parametro'];
            $data[$contador] = [
                'nombre' => $fila['nombre'],
                'correo' => $fila['correo'],
                "count" => $contador
            ];

            $contador++;
        }   

        //var_dump($data);
    
                echo "El fichero existe"."<br>";
                $correoElectronico = new Email();
                $resultadoCorreoElectronico = $correoElectronico->enviarInformeExistenciasCEvsZCS($Encabezado,$Asunto,$Descripcion,$archivoPDF,$data);
                echo $resultadoCorreoElectronico;
    
        //return $data;
        ConexionDeveloper::cerrarConexion();
	}

}

//$plantilla = new PlantillaCorreo();
//$plantilla->obtenerListadoPlantilla("INF_CEvsZCS","Informe_CEvsZCS.pdf");

?>