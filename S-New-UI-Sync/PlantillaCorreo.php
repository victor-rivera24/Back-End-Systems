<?php

$base = dirname(dirname(__FILE__));
//echo $base;

include_once $base . '/DB/ConexionNewIDSync.php';
include_once $base . '/Email/Email.php';
//include_once $base . '/Dev/Dev_Log.php';
include_once $base . '/JasperServer/JasperServer.php'; //local

class PlantillaCorreo extends ConexionNewUISync
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

        $query = "SELECT

        p.Nombre AS Plantilla
        ,p.Tipo AS Tipo
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
        WHERE
            p.activo = true
            AND p.tipo = '".$vMovimiento."'
            
        ORDER BY pl.id_plantilla_correo_lineas ASC";

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

        if(empty($data)) {
            //Está vació
            echo "El Array Está vació"."<br>";

        } else {
            echo "El Array No Está vació"."<br>";

                /** CREACION DEL INFORME Y VALIDACION DEL ARCHIVO QUE EXISTA */


                if($vMovimiento == "INF_CEvsZCS"){
                    $Reporte = new JasperServer();
                    $resultadoReporte = $Reporte->informeComparacionExistenciasCEvsZCS($Parametro,$nombreInforme);
                }elseif ($vMovimiento == "INF_Ult_Mov"){
                    $Reporte = new JasperServer();
                    $resultadoReporte = $Reporte->informeUltimoMovimientoProducto($Parametro,$nombreInforme);
                }elseif ($vMovimiento == "INF_Existencia_Cero"){
                    $Reporte = new JasperServer();
                    $resultadoReporte = $Reporte->informeProductoCero($Parametro,$nombreInforme);
                }elseif ($vMovimiento == "INF_Flekk"){
                    $Reporte = new JasperServer();
                    $resultadoReporte = $Reporte->informeProductoLogiflekk($Parametro,$nombreInforme);
                }


                if($resultadoReporte == true){

                        echo "Se generó el informe"."<br>";

                        $directorio = $this->ruta . $this->carpeta;
                        $archivoPDF = $directorio.$nombreInforme;
                
                        if (file_exists($archivoPDF)) {
                
                            echo "El fichero existe"."<br>";
                            $correoElectronico = new Email();
                            $resultadoCorreoElectronico = $correoElectronico->enviarInformeExistenciasCEvsZCS($Encabezado,$Asunto,$Descripcion,$archivoPDF,$data);
                            echo $resultadoCorreoElectronico;
                
                        } else {
                            echo "El fichero no existe"."<br>";
                            //$Reporte = new JasperServer();
                            //$Reporte->informeComparacionExistenciasCEvsZCS($nombreInforme);
                        }

                }else{
                        echo "No se puedo generar el informe"."<br>";
                }

        }
        //return $data;
        ConexionNewUISync::cerrarConexion();
	}
    

}

//$plantilla = new PlantillaCorreo();
//$plantilla->obtenerListadoPlantilla("INF_CEvsZCS","Informe_CEvsZCS.pdf");

?>