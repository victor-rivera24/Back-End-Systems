<?php

$base = dirname(dirname(__FILE__));

include_once $base . '/DB/ConexionSurver.php';
include_once $base . '/DB/ConexionCerberus.php';
include_once $base . '/Email/Email.php';
include_once $base . '/S-Developer/Dev_Empleado.php';
// include_once $base . '/S-Surver/EmpleadoCerberus.php';

class EmpleadoSurver extends ConexionSurver
{

    public function consultaEmpleadoSurver($vEmpresa,$vEmpleado)
	{
        (int) $vIdEmpresa = null;
        (int) $vIdEmpleadoCeberus = null;
        (int) $vIdEmpleadoSurver = null;

        $vRespuesta = null;

        $query = "SELECT 
        --*
        emp.id_empresa
        ,emp.id_empresa_cerberus
        ,CONCAT(e.nombre,'',e.paterno,'',e.materno) AS nombre_completo
        ,e.id_empleado
        ,e.id_cerberus_empleado
        
        FROM empleado AS e
            INNER JOIN Segmento AS s
                ON e.id_segmento =s.id_segmento
            INNER JOIN empresa AS emp
                ON emp.id_empresa = s.id_empresa
        
        WHERE 
        -- emp.id_empresa = :empresa
        emp.id_empresa_cerberus = :empresa
        AND e.id_cerberus_empleado = :empleado
        AND e.activo = true;
        ";

		$stmt = ConexionSurver::abrirConexion()->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,]);
        $stmt->bindParam(":empresa", $vEmpresa, PDO::PARAM_INT);
        $stmt->bindParam(":empleado", $vEmpleado, PDO::PARAM_INT);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            echo $row['nombre_completo']." ";
            echo " ". $row['id_empresa_cerberus']." ";
            echo " ". $row['id_cerberus_empleado']." ";
            echo " ". $row['id_empleado']." ";
            echo "<br>";

            $vIdEmpresa = $row['id_empresa_cerberus'];
            $vIdEmpleadoCeberus = $row['id_cerberus_empleado'];
            $vIdEmpleadoSurver = $row['id_empleado'];
            
            $vRespuesta =  $this->actualizarEmpleadoBaja($vIdEmpresa,$vIdEmpleadoCeberus,$vIdEmpleadoSurver);

        }

        ConexionSurver::cerrarConexion();
	}

    public function actualizarEmpleadoBaja($vIdEmpresa,$vIdEmpleadoCeberus,$vIdEmpleadoSurver)
	{
        try {

            $query = "UPDATE empleado SET activo = false, fecha_actualizado = CURRENT_TIMESTAMP, id_actualizadopor = 66 WHERE id_empleado = $vIdEmpleadoSurver ";

            $stmt = ConexionSurver::abrirConexion()->prepare($query);
            $r = $stmt->execute();
            //$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $developer = new Empleado();
            $developer->actualizarEmpleadoCerberus('Baja-EmpleadoUsuario-Surver',$vIdEmpresa,$vIdEmpleadoCeberus,null);
            
            if($r){
                return true;
            }else{
                return false;
            }

        } catch (Exception $exc) {
        
            return $exc;
        }
        ConexionSurver::cerrarConexion();
	}

    public function AgregarEmpleadoNuevo($idEmpleadoCerberus, $nombreEmpleado, $apPatEmpleado, $apMatEmpleado, $telcasa, $telcontacto, $correoPersonal, $genero_empleado, $usuario, $fechaNacimiento, $nss, $rfc, $fechaAlta, $perfilCalculo, $idEmpresa, $idDepartamento, 
                                            $idConpaq, $correo_verificado, $escolaridad, $puesto_empleado, $tabulador_empleado, $idSucursal, $area_conocimiento){

        try {
            $query = "SELECT * FROM SincEmpleadosNuevos(:idEmpleadoCerberus, :nombreEmpleado, :apPatEmpleado, :apMatEmpleado, :telcasa, :telcontacto, :correoPersonal, :genero_empleado, :usuario, :fechaNacimiento, :nss, :rfc, :fechaAlta, :perfilCalculo, :idEmpresa
                                                            , :idDepartamento, :idConpaq, :correo_verificado, :escolaridad, :puesto_empleado, :tabulador_empleado, :idSucursal, :area_conocimiento) ";

            $stmt = ConexionSurver::abrirConexion()->prepare($query);
            $stmt->bindParam(':idEmpleadoCerberus', $idEmpleadoCerberus, PDO::PARAM_INT);
            $stmt->bindParam(':nombreEmpleado', $nombreEmpleado, PDO::PARAM_STR);
            $stmt->bindParam(':apPatEmpleado', $apPatEmpleado, PDO::PARAM_STR);
            $stmt->bindParam(':apMatEmpleado', $apMatEmpleado, PDO::PARAM_STR);
            $stmt->bindParam(':telcasa', $telcasa, PDO::PARAM_STR);
            $stmt->bindParam(':telcontacto', $telcontacto, PDO::PARAM_STR);
            $stmt->bindParam(':correoPersonal', $correoPersonal, PDO::PARAM_STR);
            $stmt->bindParam(':genero_empleado', $genero_empleado,PDO::PARAM_STR);
            $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
            $stmt->bindParam(':fechaNacimiento', $fechaNacimiento, PDO::PARAM_STR);
            $stmt->bindParam(':nss', $nss, PDO::PARAM_STR);
            $stmt->bindParam(':rfc', $rfc, PDO::PARAM_STR);
            $stmt->bindParam(':fechaAlta', $fechaAlta, PDO::PARAM_STR);
            $stmt->bindParam(':perfilCalculo', $perfilCalculo, PDO::PARAM_STR);
            $stmt->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
            $stmt->bindParam(':idDepartamento', $idDepartamento, PDO::PARAM_INT);
            $stmt->bindParam(':idConpaq', $idConpaq, PDO::PARAM_STR);
            $stmt->bindParam(':correo_verificado', $correo_verificado, PDO::PARAM_STR);
            $stmt->bindParam(':escolaridad', $escolaridad, PDO::PARAM_STR);
            $stmt->bindParam(':puesto_empleado', $puesto_empleado, PDO::PARAM_STR);
            $stmt->bindParam(':tabulador_empleado', $tabulador_empleado, PDO::PARAM_STR);
            $stmt->bindParam(':idSucursal', $idSucursal, PDO::PARAM_INT);
            $stmt->bindParam(':area_conocimiento', $area_conocimiento, PDO::PARAM_STR);
            $res = $stmt->execute();

            $checkSincronizado = new EmpleadoCerberus();
            $checkSincronizado->SincronizadoCheckCerberus($idEmpleadoCerberus);

            if($res){
                return true;
            }else{
                echo 'Error';
                return false;
            }
        } catch (Exception $exc) {
            return $exc;
        }

        ConexionSurver::cerrarConexion();
    }

    public function ActualizacionPuesto($puesto, $idEmpleado){
        try {

            $query = "UPDATE empleado SET ev_puesto_id = (SELECT ev_puesto_id FROM refividrio.ev_puesto WHERE nombre_puesto = :puesto LIMIT 1), fecha_actualizado = CURRENT_TIMESTAMP, id_actualizadopor = 66 WHERE id_cerberus_empleado = :idempleado ";

            $stmt = ConexionSurver::abrirConexion()->prepare($query);
            $stmt->bindParam(':puesto', $puesto, PDO::PARAM_INT);
            $stmt->bindParam(':idempleado', $idEmpleado, PDO::PARAM_INT);
            $r = $stmt->execute();

            $actualizaPuesto = new EmpleadoCerberus();
            $actualizaPuesto->actualizarPuestoCerberus($idEmpleado);

            if($r){
                return true;
            }else{
                return false;
            }

        } catch (Exception $exc) {
        
            return $exc;
        }
        ConexionSurver::cerrarConexion();
        
    }



}


?>