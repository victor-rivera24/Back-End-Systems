<?php

$base = dirname(dirname(__FILE__));

include_once $base . '/DB/ConexionSurver.php';
include_once $base . '/Email/Email.php';
include_once $base . '/S-Developer/Dev_Empleado.php';
include_once $base . '/Whatsapp/WhatsappAlternate.php';

/**
 * Esta clase fue generarada para obtener de las encuestas del sistema de SURVER
 * 
 * @since 31/10/2022 se creó esta clase
 * @author Victor Rivera
 */
class Encuesta extends ConexionSurver
{

    /**
     * Registra la transacción del movimiento de la API.
     * 
     * @since 31/10/2022 se genero el método
     * @author Victor Rivera
     */   
    public function envioMensajePrueba()
	{
        try {

            $instancia_whatsApp = new WhatsappAlternate();
            $resultadoWhatsApp = $instancia_whatsApp->mensajePrueba();

        } catch (Exception $exc) {
        
            return $exc;
        }

	}


    /**
     * Retorna el listado del empleado que no han realizado la encuesta.
     * 
     * @since 31/10/2022 se genero el método
     * @author Victor Rivera
     */    
    public function consultaEmpleadoEncuesta()
	{
        $vIdEmpleado = null;
        $vEmpleado = null;
        $vCelular = null;
        $vRespuesta = null;

        $query = "SELECT 
	 
        e.id_encuesta
        ,e.nombre As Encuesta
        ,encuesta.validodesde
        ,encuesta.validohasta	
        ,ee.id_empresa
        ,empresa_nombre AS Empresa
        ,seg.nombre As Segmento
        ,emp.id_empleado	
        ,CONCAT(emp.paterno, ' ', emp.materno, ' ', emp.nombre) AS Empleado 
        ,e.celular AS Celular
        --,'5576100176'  AS Celular	
        --,encuesta.*
    
    FROM  refividrio.empresa_encuesta ee
        INNER JOIN refividrio.empresa empresa ON empresa.id_empresa = ee.id_empresa
        INNER JOIN refividrio.segmento seg ON seg.id_empresa = empresa.id_empresa
        INNER JOIN refividrio.empleado emp ON emp.id_segmento = seg.id_segmento AND emp.activo = true
          INNER JOIN refividrio.encuesta e  ON  e.id_encuesta = ee.id_encuesta 
        LEFT JOIN refividrio.empleado_encuesta ec ON emp.id_empleado = ec.id_empleado AND ec.id_encuesta = e.id_encuesta
        LEFT JOIN LATERAL (
            
            SELECT
                enc_emp.id_empresa
                ,enc.id_encuesta
                ,enc.nombre
                ,enc.validodesde
                ,enc.validohasta
                ,CURRENT_DATE AS FechaActual
                ,CURRENT_DATE-2 AS FechaActual
    
            FROM Encuesta AS enc
                INNER JOIN Empresa_Encuesta AS enc_emp
                    ON enc_emp.id_encuesta = enc.id_encuesta
                    AND enc_emp.id_empresa IN (2,3)
            WHERE
                enc.activo = true
                --AND (CURRENT_DATE-2) BETWEEN enc.validodesde::Date AND enc.validohasta::Date
                AND CURRENT_DATE BETWEEN enc.validodesde::Date AND enc.validohasta::Date

                --AND enc_e.termino = false
            ORDER BY enc.id_encuesta		
    
       ) AS encuesta		
            
        ON encuesta.id_empresa = ee.id_empresa
        AND encuesta.id_encuesta = e.id_encuesta
        
    WHERE  
        --ee.id_encuesta = 14
        ee.id_encuesta = encuesta.id_encuesta   
        AND ec.id_empleado IS NULL
        AND empresa.id_empresa  IN (2,3)
        
        AND emp.activo = true
        AND emp.perfilcalculo <> 'Estadia'
        AND emp.celular IS NOT NULL
        AND length(emp.celular) = 10	
    
    ORDER BY e.id_encuesta
            ,seg.id_empresa
            ,seg.nombre
            ,emp.paterno
            ,emp.materno
            ,emp.nombre
                    
        ";

    //     $query = "	SELECT 
    //     emp.empresa_nombre AS Empresa
    //     ,s.nombre AS Segmento
    //     ,e.id_empleado
    //     ,CONCAT(e.paterno, ' ', e.materno, ' ', e.nombre) AS empleado
    //     --,e.celular AS Celular
    //     ,'5576100176'  AS Celular
    //     ,encuesta.id_encuesta
        
    // FROM empleado AS e
    //     INNER JOIN segmento AS s
    //         ON s.id_segmento = e.id_segmento
    //     INNER JOIN empresa AS emp
    //         ON emp.id_empresa = s.id_empresa
    //         AND emp.empresa_activo = true
            
    //     LEFT JOIN LATERAL (
        
    //             SELECT
    //                 enc.id_encuesta
    //                 ,enc.nombre
    //                 ,enc.validodesde
    //                 ,enc.validohasta
    //                 ,CURRENT_DATE AS FechaActual
    //                 ,CURRENT_DATE-2 AS FechaActual
    //                 --,enc_emp.id_empresa
    
    //                 ,enc_e.termino
    //                 ,enc_e.fecha_creado
    
    //                 ,emp.empresa_nombre AS Empresa	
    //                 ,s.nombre AS Segmento
    //                 ,enc_e.id_empleado
    //                 ,CONCAT(e.paterno, ' ', e.materno, ' ', e.nombre) AS empleado
    //                 ,e.celular AS Celular	
    
    //             FROM Encuesta AS enc
    //                 INNER JOIN Empleado_Encuesta AS enc_e
    //                     ON enc_e.id_encuesta = enc.id_encuesta		
    //                 INNER JOIN Empleado AS e
    //                     ON e.id_empleado = enc_e.id_empleado	
    //                 INNER JOIN Segmento	AS s
    //                     ON s.id_segmento = e.id_segmento
    //                 INNER JOIN Empresa AS emp
    //                     ON emp.id_empresa = s.id_empresa
    //                     AND emp.empresa_activo = true
    //             WHERE
    //                 enc.activo = true
    //                 --AND enc.validodesde::Date >= (CURRENT_DATE-6) 
    //                 --AND (CURRENT_DATE-6) <= enc.validohasta::Date
    //                 AND (CURRENT_DATE-2) BETWEEN enc.validodesde::Date AND enc.validohasta::Date
    //                 --AND enc_e.termino = false
    //             ORDER BY enc.id_encuesta,Empresa,Segmento		
            
    //     ) AS encuesta		
        
    //     ON encuesta.id_empleado = e.id_empleado
            
    // WHERE 
    //     emp.id_empresa IN (2,3)
    //     AND e.activo = true
    //     AND e.perfilcalculo <> 'Estadia'
    //     AND e.celular IS NOT NULL
    //     AND length(e.celular) = 10
    //     AND encuesta.id_encuesta IS NULL 
        
    // ORDER BY emp.empresa_observaciones,Segmento ASC

    //             ";

		$stmt = ConexionSurver::abrirConexion()->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,]);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            echo $row['empleado']." ";
            echo " ". $row['celular']." ";
            echo "<br>";

            $vIdEmpleado =  $row['id_empleado'];
            $vEmpleado = $row['empleado'];
            $vCelular = $row['celular'];          
            
            if(isset($vCelular)){

                $vRespuesta = $this->registraNotificacionWhatsApp($vIdEmpleado,$vEmpleado,$vCelular);

            }
            // var_dump($vRespuesta);
        }

        ConexionSurver::cerrarConexion();
	}


     /**
     * Registra la transacción del movimiento de la API.
     * 
     * @since 31/10/2022 se genero el método
     * @author Victor Rivera
     */   
    public function registraNotificacionWhatsApp($vIdEmpleado,$vEmpleado,$vCelular)
	{
        try {

                $instancia_whatsApp = new WhatsappAlternate();
                $resultadoWhatsApp = $instancia_whatsApp->mensajeEncuestaFaltante($vEmpleado,$vCelular);

                try {

                    $agregar = "INSERT INTO empleado_notificacion (id_empleado,nombre_empleado,metodo_envio,movimiento,fecha_transaccion,respuesta)
                                             VALUES ($vIdEmpleado,'".$vEmpleado."','WhatsApp-Alternate','Encuesta-COVID',CURRENT_TIMESTAMP,'".$resultadoWhatsApp."')";
                    $stmt = ConexionSurver::abrirConexion()->prepare($agregar);

                    // $stmt->bindParam(":empresa", $vIDEmpresa, PDO::PARAM_INT);
                    // $stmt->bindParam(":nombre", $Nombre_Empleado, PDO::PARAM_STR);

                    $r = $stmt->execute();
                    //$result = $stmt -> fetchAll();

                    if($r){
                        return true;
                    }else{
                        return false;
                    }

                }catch (Exception $exc) {

                    return $exc;
                } 

        } catch (Exception $exc) {
        
            return $exc;
        }
        ConexionSurver::cerrarConexion();

	}

}

    /** HABILITAR CUANDO SE QUIERA EJECUTAR LOCALMENTE */
    // $metodo = new Encuesta();
    // $metodo->consultaEmpleadoEncuesta();


?>
