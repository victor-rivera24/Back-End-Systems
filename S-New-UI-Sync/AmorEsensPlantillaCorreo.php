<?php

$base = dirname(dirname(__FILE__));
//echo $base;

include_once $base . '/DB/ConexionNewIDSync.php';
include_once $base . '/Email/Email.php';
//include_once $base . '/Dev/Dev_Log.php';
include_once $base . '/JasperServer/JasperServer.php'; //local
include_once $base . '/Whatsapp/WhatsappBird.php'; //local


class AmorEsensPlantillaCorreo extends ConexionNewUISync
{
    private $fechaActual;
    private $ruta;
    private $carpeta = '/PDF-ADempiere/';

    public function __construct(){

        $this->fechaActual = date("Y-m-d"); // error is on this line
        $this->ruta =  dirname(dirname(__FILE__));

    }


    public function ObtenerCorreos($vID)
	{
        $Encabezado = null;
        $Asunto = null;
        $Cuerpo = null;
        $Usuario = null;
        $Correo = null;
        $Celular = null;
        $Imagen = null;
        $Tipo = null;

        $query = "SELECT 
        r.nombre AS Recurrencia
        ,pt.nombre AS TipoPlantilla
        ,pc.nombre AS PlantillaNombre
        ,pcl.nombre AS Usuario
        ,pcl.correo AS Correo
        ,pcl.celular AS Celular
        ,CASE WHEN ed.tipo_formato = '1' THEN 'Whatsapp' ELSE 'Correo' END AS TipoEnvio
        ,CASE WHEN fc.nombre IS NOT NULL THEN fc.nombre ELSE fw.nombre END AS NombreFormato
        ,CASE WHEN fc.encabezado IS NOT NULL THEN fc.encabezado ELSE fw.encabezado END AS Encabezado
        ,CASE WHEN fc.asunto IS NOT NULL THEN fc.asunto ELSE fw.asunto END AS Asunto
        ,CASE WHEN fc.descripcion IS NOT NULL THEN fc.descripcion ELSE fw.cuerpo END AS Cuerpo
        ,CASE WHEN fw.footer IS NOT NULL THEN fw.footer ELSE 'NA'  END AS Footer
        ,CASE WHEN rtc.ruta IS NOT NULL THEN CONCAT(rtc.ruta, fc.imagen) ELSE CONCAT(rtw.ruta, fw.imagen) END AS RutaImagen
        ,e.nombre AS NombreEnvio
    
        FROM e_envio AS e
        INNER JOIN e_envio_detalle AS ed
            ON ed.e_envio_id = e.e_envio_id
        INNER JOIN e_plantilla_correo AS pc
            ON pc.e_plantilla_correo_id = e.e_plantilla_correo_id
        INNER JOIN e_plantilla_correo_linea AS pcl
            ON pcl.e_plantilla_correo_id = pc.e_plantilla_correo_id
        INNER JOIN e_plantilla_tipo AS pt
            ON pt.e_plantilla_tipo_id = pc.e_plantilla_tipo_id
        INNER JOIN e_recurrencia AS r
            ON r.e_recurrencia_id = pt.e_recurrencia_id
        LEFT JOIN e_formato_correo fc
            ON fc.e_formato_correo_id = ed.e_formato_correo_id
        LEFT JOIN e_formato_whatsapp fw
            ON fw.e_formato_whatsapp_id = ed.e_formato_whatsapp_id
        LEFT JOIN e_ruta AS rtc
            ON rtc.e_rutas_id = fc.e_rutas_id
        LEFT JOIN e_ruta AS rtw
            ON rtw.e_rutas_id = fw.e_rutas_id
        
    
        WHERE e.activo = true 
            AND pcl.activo = true 
            AND pc.activo = true 
            --AND ed.tipo_formato = '2'
            AND r.e_recurrencia_id = ".$vID."
                
        ORDER BY pcl.nombre";

		$stmt = ConexionNewUISync::abrirConexion()->prepare($query);
        $stmt -> execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $Encabezado = $row['encabezado'];
            $Asunto = $row['asunto'];
            $Cuerpo = $row['cuerpo'];
            $Usuario = $row['usuario'];
            $Correo = $row['correo'];
            $Celular = $row['celular'];
            $Imagen = $row['rutaimagen'];
            $Tipo = $row['tipoenvio'];

            if( $Tipo == "Correo" ){

                $envio = new Email();
                $resultadoenvio = $envio->enviarCorreo($Encabezado,$Asunto,$Cuerpo,$Usuario,$Correo,$Imagen);

            }else if( $Tipo == "Whatsapp"){

                $whatsapp = new WhatsappBird();
                $resultadowhatsapp = $whatsapp->mensajeRecojerPedido($Celular,$Imagen,$Cuerpo);

            }
            

        }

       
                
        ConexionNewUISync::cerrarConexion();
	}

}

// $envios = new AmorEsensPlantillaCorreo();
// $envios->ObtenerCorreos("Diario");


?>