<?php

$base = dirname(dirname(__FILE__));
include_once $base . '/DB/ConexionDeveloper.php';
include_once $base . '/S-Surver/EmpleadoSurver.php';
include_once $base . '/S-ADempiere/EmpleadoADempiere_RFV.php';


class Empleado extends ConexionDeveloper{

        /** INICIO APARTADO DE CERBERUS */

	public function consultaEmpleadoCerberus($vMovimiento,$vIDEmpresa,$vIDEmpleado,$Nombre_Empleado,$vActivo,$vNSS,$vRFC,$vCURP,$vFechaIncidencia,$vNumeroSemana){

                // echo $vIDEmpleado;

                try {
                        $consulta = "SELECT * FROM c_empleado WHERE tipo_movimiento = '".$vMovimiento."' AND id_empresa = :empresa  AND id_empleado = :empleado AND semana = :semana ;";
                        $stmt = ConexionDeveloper::abrirConexion()->prepare($consulta);

                        $stmt->bindParam(":empresa", $vIDEmpresa, PDO::PARAM_INT);
                        $stmt->bindParam(":empleado", $vIDEmpleado, PDO::PARAM_INT);
                        $stmt->bindParam(":semana", $vNumeroSemana, PDO::PARAM_INT);

                        $stmt->execute();
                        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($resultado as $fila) {

                                echo $fila['id_empresa'] . "<br>";
                                echo $fila['id_empleado'] . "<br>";
                                //echo $fila;
                        }

                        if($resultado){
                                return true;
                        }else{
                                $this->agregarEmpleadoCerberus($vMovimiento,$vIDEmpresa,$vIDEmpleado,$Nombre_Empleado,$vActivo,$vNSS,$vRFC,$vCURP,$vFechaIncidencia,$vNumeroSemana);
                                return false;
                        }
                        //var_dump($resultado);

                        return $resultado;

    
                } catch (Exception $exc) {
    
                    return $exc;
                }

        }

	public function agregarEmpleadoCerberus($vMovimiento,$vIDEmpresa,$vIDEmpleado,$Nombre_Empleado,$vActivo,$vNSS,$vRFC,$vCURP,$vFechaIncidencia,$vNumeroSemana)
	{
                try {

                        $agregar = "INSERT INTO c_empleado (creado,id_empresa,id_empleado,nombre,nss,curp,rfc,activo,fecha_incidencia,procesado,tipo_movimiento,semana)
                                                 VALUES (CURRENT_TIMESTAMP,:empresa,:empleado,:nombre,:nss,:curp,:rfc,:activo,:fecha,false,:movimiento,:semana)";
                        $stmt = ConexionDeveloper::abrirConexion()->prepare($agregar);

                        $stmt->bindParam(":empresa", $vIDEmpresa, PDO::PARAM_INT);
                        $stmt->bindParam(":empleado", $vIDEmpleado, PDO::PARAM_INT);
                        $stmt->bindParam(":nombre", $Nombre_Empleado, PDO::PARAM_STR);
                        $stmt->bindParam(":activo", $vActivo, PDO::PARAM_STR);
                        $stmt->bindParam(":nss", $vNSS, PDO::PARAM_STR);
                        $stmt->bindParam(":rfc", $vRFC, PDO::PARAM_STR);
                        $stmt->bindParam(":curp", $vCURP, PDO::PARAM_STR);
                        $stmt->bindParam(":fecha", $vFechaIncidencia, PDO::PARAM_STR);
                        $stmt->bindParam(":movimiento", $vMovimiento, PDO::PARAM_STR);
                        $stmt->bindParam(":semana", $vNumeroSemana, PDO::PARAM_INT);

                        $r = $stmt->execute();
                        //$result = $stmt -> fetchAll();

                        if($r){
                                return true;

                        }else{
                                return false;

                        }

                } catch (Exception $exc) {
    
                return $exc;
            } 

	}

	public function actualizarEmpleadoCerberus($Movimiento,$vIDEmpresa,$vIDEmpleado,$vRespuesta)
	{
                try {

                        $actualizar = "UPDATE c_empleado SET 
                        actualizado = CURRENT_TIMESTAMP
                        , procesado = true 
                        , respuesta = '".$vRespuesta."'
                        WHERE id_empresa = $vIDEmpresa AND id_empleado = $vIDEmpleado AND tipo_movimiento = '".$Movimiento."' ";
                        $stmt = ConexionDeveloper::abrirConexion()->prepare($actualizar);

                        $r = $stmt->execute();
                        //$result = $stmt -> fetchAll();

                        if($r){
                                return true;

                        }else{
                                return false;

                        }

                } catch (Exception $exc) {
    
                return $exc;
            } 

	}        

        /** FIN APARTADO DE CERBERUS */



        /** INICIO TABLA EMPLEADO BASE DE DATOS SISTEMAS */

	public function consultaDeveloperEmpleadoCerberus($vMovimiento){

                try {                       
                        (int) $vEmpresa = null;
                        (int) $vEmpleado = null;
                        $vRFC = null;
                        $vCURP = null;
                        $vNSS = null;

                        
                        $consulta = "SELECT *,extract(week from CURRENT_DATE) FROM c_empleado WHERE tipo_movimiento = '".$vMovimiento."' AND procesado = false AND semana = extract(week from CURRENT_DATE);";
                        $stmt = ConexionDeveloper::abrirConexion()->prepare($consulta);

                        $stmt->execute();
                        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($resultado as $fila) {

                                echo $fila['id_empresa'] . "<br>";
                                echo $fila['id_empleado'] . "<br>";

                                $vEmpresa = $fila['id_empresa'];
                                $vEmpleado = $fila['id_empleado'];
                                $vRFC = $fila['rfc'];
                                $vCURP = $fila['curp'];


                                if($vMovimiento == "Baja-EmpleadoUsuario-Surver"){

                                        $empleado_surver = new EmpleadoSurver();
                                        $r = $empleado_surver->consultaEmpleadoSurver($vEmpresa,$vEmpleado);

                                }else if($vMovimiento == "Baja-Empleado-ADempiere"){

                                        $empleado_adempiere = new EmpleadoADempiereRFV();
                                        $r = $empleado_adempiere->consultaEmpleadoADempiere($vEmpresa,$vEmpleado,$vRFC,$vCURP);


                                }else if($vMovimiento == "Baja-EmpleadoUsuario-ADempiere"){

                                        $usuario_adempiere = new EmpleadoADempiereRFV();
                                        $r = $usuario_adempiere->consultaEmpleadoUsuarioADempiere($vEmpresa,$vEmpleado,$vRFC,$vCURP);

                                }

                        }

                        return $resultado;

    
                } catch (Exception $exc) {
    
                    return $exc;
                }

        }

        /** FIN TABLA EMPLEADO BASE DE DATOS SISTEMAS */

}


// $empleado = new Empleado();
// $empleado->consultaDeveloperEmpleadoCerberus('Baja-EmpleadoUsuario-ADempiere');



?>