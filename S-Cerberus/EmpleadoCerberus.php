<?php

$base = dirname(dirname(__FILE__));

include_once $base . '/DB/ConexionCerberus.php';
include_once $base . '/S-Developer/Dev_Empleado.php';
include_once $base . '/Email/Email.php';

class EmpleadoCerberus extends ConexionCerberus
{

    // public function obtenerEmpleado()
	// {
    //     $data = [];
    //     $vDistribuidor = null;
    //     $vRespuesta = null;

    //     $query = "SELECT
    //     top(10)
    //     nombreEmpleado
    //     ,apPatEmpleado
    //     ,apMatEmpleado
    //     FROM Empleado WHERE idEmpresa = 5 AND esActivo = 1";

	// 	$stmt = ConexionCerberus::abrirConexion()->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,]);
    //     //$sentencia = $base_de_datos->prepare($consulta, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,]);

    //     $stmt->execute();

    //     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    //         echo $row['nombreEmpleado']." ";
    //         echo " ". $row['apPatEmpleado']." ";
    //         echo " ". $row['apMatEmpleado']." ";
    //         echo "<br>";
    //         //$log = new Dev_Log();
    //         //$log->agregarLog($vMovimiento,$vSolicitud,$vDistribuidor,json_encode($row),$vRespuesta,$vMedio);
    //     }

    //     return $data;

    //     ConexionCerberus::cerrarConexion();
	// }


    public function obtenerEmpleadoIncidenciaBaja($Movimiento)
	{

        (int) $IDEmpleado = null;
        (int) $IDEmpresa = null;
        $Nombre_Empresa = null;
        $Nombre_Empleado = null;
        $Nombre_Paterno = null;
        $NSS = null;
        $CURP = null;
        $RFC = null;
        $Activo = null;
        $IDIncidencia = null;
        $IDTipoIncidencia = null;
        $FechaIncidencia = null;
        $NumeroSemana = null;


        $vRespuesta = null;

        $query = "SELECT 
                    --*
                    emp.idEmpresa
                    ,emp.nombreEmpresa
                    ,e.idEmpleado
                    ,CONCAT(e.nombreEmpleado,' ',e.apPatEmpleado,' ',e.apMatEmpleado) AS EmpleadoCompleto
                    ,e.nss
                    ,e.curp
                    ,e.rfc
                    ,e.esActivo
                            
                    ,i.idIncidencia
                    ,i.idTipoIncidencia
                    ,i.fecha
                    ,periodo.*
                    --,DATEPART(WEEK, getdate())  - DATEPART(WEEK, DATEADD(MM, DATEDIFF(MM,0,getdate() ), 0))+ 1 AS SemanaMes
					,DATEPART(ISO_WEEK, getdate()) as NumeroSemana 
                                    
                    FROM Empleado AS e
                        INNER JOIN Empresa AS emp
                            ON emp.idEmpresa = e.idEmpresa
                        INNER JOIN Incidencia AS i
                            ON i.idEmpleado = e.idEmpleado
                            --AND i.idTipoIncidencia = 14
							AND i.idEmpresa = e.idEmpresa
						INNER JOIN TipoIncidencia AS ti
							ON ti.idTipoIncidencia = i.idTipoIncidencia
							AND ti.idtipoincidenciaNativo = 14
                        OUTER APPLY    -- = LEFT JOIN 
                        (
                        SELECT 
                        --TOP 1
                        inicioPeriodo
                        ,finPeriodo
                        FROM Periodo WHERE elementoSistema = 'ES' AND convert(varchar, getdate(), 23) BETWEEN inicioPeriodo AND finPeriodo
                        AND esActivo = 1
                        AND idEmpresa IN (1,2,5,8,10)
                        AND idEmpresa = emp.idEmpresa
                        ) AS periodo
                
                    WHERE 
                        e.esActivo = 1
                        AND e.idEmpresa IN (1,2,5,8,10)
                        AND i.fecha >= periodo.inicioPeriodo AND periodo.inicioPeriodo <= i.fecha
                        --AND e.idEmpleado = 4499
                                    
                    ORDER BY emp.nombreEmpresa
                            ,i.fecha ASC";

		$stmt = ConexionCerberus::abrirConexion()->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,]);
        //$sentencia = $base_de_datos->prepare($consulta, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,]);

        $stmt -> execute();
        $resultado = $stmt -> fetchAll();

        foreach ($resultado as $fila) {

            $IDEmpresa = $fila['idEmpresa'];
            $Nombre_Empresa = $fila['nombreEmpresa'];
            $IDEmpleado = $fila['idEmpleado'];
            $Nombre_Empleado = $fila['EmpleadoCompleto'];
            $NSS =$fila['nss'];
            $CURP = $fila['curp'];
            $RFC = $fila['rfc'];
            $Activo = $fila['esActivo'];
            $IDIncidencia = $fila['idIncidencia'];
            $IDTipoIncidencia = $fila['idTipoIncidencia'];
            $FechaIncidencia = $fila['fecha'];
            $NumeroSemana =  $fila['NumeroSemana'];

            //echo $Nombre_Empleado . "<br>";

            $developer = new Empleado();
            $r = $developer->consultaEmpleadoCerberus($Movimiento,$IDEmpresa,$IDEmpleado,$Nombre_Empleado,$Activo,$NSS,$RFC,$CURP,$FechaIncidencia,$NumeroSemana);         

        }  


        // while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //     $data[] = [
        //         'id_empresa' => $row['idEmpresa'],
        //         'nombre_empresa' => $row['nombreEmpresa'],
        //         'id_empleado' => $row['idEmpleado'],
        //         'nombre_empleado' => $row['nombreEmpleado'],
        //         'paterno' => $row['apPatEmpleado'],
        //         'materno' => $row['apMatEmpleado'],
        //         'curp' => $row['curp'],
        //         'rfc' => $row['rfc'],
        //         'activo' => $row['esActivo'],
        //         'id_incidencia' => $row['idIncidencia'],
        //         'id_tipo_incidencia' => $row['idTipoIncidencia'],      
        //         'fecha_incidencia' => $row['fecha'],     

        //     ];

            
        // }


        // $stmt->execute();
        // $result = $stmt->fetchAll();

        // foreach ($result as $row) {
        //     $data['id_empresa'] = $row['idEmpresa'];
        //     $data['nombre_empresa'] = $row['nombreEmpresa'];
        //     $data['id_empleado'] = $row['idEmpleado'];
        //     $data['nombre_empleado'] = $row['nombreEmpleado'];
        //     $data['paterno'] = $row['apPatEmpleado'];
        //     $data['materno'] = $row['apMatEmpleado'];
        //     $data['curp'] = $row['curp'];
        //     $data['rfc'] = $row['rfc'];
        //     $data['activo'] = $row['esActivo'];
        //     $data['id_incidencia'] = $row['idIncidencia'];
        //     $data['id_tipo_incidencia'] = $row['idTipoIncidencia'];
        //     $data['fecha_incidencia'] = $row['fecha'];

        // }

        return true;

        ConexionCerberus::cerrarConexion();
	}



}

// $orden = new EmpleadoCerberus();
// $orden->obtenerEmpleadoIncidenciaBaja('Baja-EmpleadoUsuario-Surver');



?>