<?php

$base = dirname(dirname(__FILE__));

include_once $base . '/DB/ConexionSurver.php';
include_once $base . '/Email/Email.php';
include_once $base . '/S-Developer/Dev_Empleado.php';
include_once $base . '/Whatsapp/WhatsappBirdInterno.php';

class EmpleadoFelizCumple extends ConexionSurver
{

    public function consultaEmpleadoFelizCumple()
	{
        $vIdEmpleado = null;
        $vEmpleado = null;
        $vFechaNacimiento = null;
        $vCorreoElectronico = null;
        $vCelular = null;
        $vRespuesta = null;

        $query = "	SELECT 
                        e.id_empleado
                        ,UPPER(CONCAT(e.nombre,' ',e.paterno,' ',e.materno)) AS nombre_empleado
                        ,refividrio.fecha_date_es(fecha_nacimiento) As fecha_nacimiento
                        ,e.correo
                        ,CASE WHEN length(celular) = 10 THEN celular ELSE NULL END AS celular
                    FROM refividrio.empleado e 
                        INNER JOIN refividrio.segmento AS S 
                            ON s.id_segmento = e.id_segmento 
                    WHERE 
                        s.id_empresa IN (1,2,3) 
                        --AND correo_verificado = true
                        AND e.activo = true 
                        AND correo IS NOT NULL AND correo <> ''
                        AND e.perfilcalculo <> 'Estadia'
                        AND EXTRACT(MONTH FROM CURRENT_DATE) = EXTRACT(MONTH FROM fecha_nacimiento) 
                        AND EXTRACT(DAY FROM CURRENT_DATE) = EXTRACT(DAY FROM fecha_nacimiento) ORDER BY EXTRACT(DAY FROM fecha_nacimiento)
                ";

		$stmt = ConexionSurver::abrirConexion()->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,]);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            echo $row['nombre_empleado']." ";
            echo " ". $row['fecha_nacimiento']." ";
            echo " ". $row['correo']." ";
            echo " ". $row['celular']." ";
            echo "<br>";

            $vIdEmpleado =  $row['id_empleado'];
            $vEmpleado = $row['nombre_empleado'];
            $vFechaNacimiento = $row['fecha_nacimiento'];
            $vCorreoElectronico = $row['correo'];
            $vCelular = $row['celular'];          
            
            $vRespuesta = $this->registraNotificacionCorreoElectronico($vIdEmpleado,$vEmpleado,$vCorreoElectronico,$vFechaNacimiento);

            if(isset($vCelular)){

                $vRespuesta = $this->registraNotificacionWhatsApp($vIdEmpleado,$vEmpleado,$vCelular);

            }

            // var_dump($vRespuesta);

        }

        ConexionSurver::cerrarConexion();
	}

    public function registraNotificacionCorreoElectronico($vIdEmpleado,$vEmpleado,$vCorreoElectronico,$vFechaNacimiento)
	{
        try {
                                 
            $query = "SELECT * FROM empleado_aniversario WHERE id_empleado = $vIdEmpleado AND movimiento = 'Correo Electrónico' AND fecha_movimiento::Date = CURRENT_DATE";

            $stmt = ConexionSurver::abrirConexion()->prepare($query);
            $r = $stmt->execute();
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if($resultado){

                return true;

            }else{

                $instancia_correo = new Email();
                $resultadoCorreoElectronico = $instancia_correo->enviarCorreoFelizCumple($vEmpleado,$vCorreoElectronico,$vFechaNacimiento);

                try {

                    $agregar = "INSERT INTO empleado_aniversario (id_empleado,nombre_empleado,movimiento,fecha_movimiento,respuesta)
                                             VALUES ($vIdEmpleado,'".$vEmpleado."','Correo Electrónico',CURRENT_TIMESTAMP,'".$resultadoCorreoElectronico."')";
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


                return false;
            }

        } catch (Exception $exc) {
        
            return $exc;
        }
        ConexionSurver::cerrarConexion();
	}

 
    public function registraNotificacionWhatsApp($vIdEmpleado,$vEmpleado,$vCelular)
	{
        try {
                                 
            $query = "SELECT * FROM empleado_aniversario WHERE id_empleado = $vIdEmpleado AND movimiento = 'WhatsApp' AND fecha_movimiento::Date = CURRENT_DATE";
            // print_r($query);

            $stmt = ConexionSurver::abrirConexion()->prepare($query);
            $r = $stmt->execute();
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // print_r($resultado);

            if($resultado){

                return true;

            }else{

                $instancia_whatsApp = new WhatsappBirdInterno();
                $resultadoWhatsApp = $instancia_whatsApp->mensajeFelizCumple($vEmpleado,$vCelular);

                try {

                    $agregar = "INSERT INTO empleado_aniversario (id_empleado,nombre_empleado,movimiento,fecha_movimiento,respuesta)
                                             VALUES ($vIdEmpleado,'".$vEmpleado."','WhatsApp',CURRENT_TIMESTAMP,'".$resultadoWhatsApp."')";
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


                return false;
            }

        } catch (Exception $exc) {
        
            return $exc;
        }
        ConexionSurver::cerrarConexion();

	}

}

    /** HABILITAR CUANDO SE QUIERA EJECUTAR LOCALMENTE */

    // $orden = new EmpleadoFelizCumple();
    // $orden->consultaEmpleadoFelizCumple();


?>