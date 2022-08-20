<?php

$base = dirname(dirname(__FILE__));

include_once $base . '/DB/ConexionCerberus.php';
include_once $base . '/S-Surver/EmpleadoSurver.php';

class EmpleadoNuevosObtenidos extends ConexionCerberus
{
    public function EmpleadoNuevos($Movimiento)
	{
    // echo 'ENtrada;\n';
        $nombreEmpleado = null;
        $apMatEmpleado = null;
        $apPatEmpleado = null;
        (int) $idTipoUsuario = null;
        $esActivo = null;
        $usuario = null;
        $nss = null;
        $curp = null;
        $rfc = null;
        $nombreDepartamento = null;
        $nombreHorario = null;
        (int) $idSucursal = null;
        $actualizado = null;
        $creado = null;
        $fechaAlta = null;
        $fechaBaja = null;
        $puesto = null;
        $fechaNacimiento = null;
        $genero = null;
        $total = null;
        (int) $idEmpleado = null;
        (int) $idEmpleadoCerberus = null;
        $ultimoRegistro = null;
        $nombreEmpresa = null;
        $nombreSucursal = null;
        $correoPersonal = null;
        $telcasa = null;
        (int) $idEmpresa = null;
        $telcontacto = null;
        $perfilCalculo = null;
        (int) $idDepartamento = null;
        $escolaridad = null;
        $puesto_empleado = null;
        $nivel_empleado = null;
        $tabulador_empleado = null;
        $genero_empleado = null;
        $idConpaq = null;
        $usuario = null;
        (int) $correo_verificado = null;
        $area_conocimiento = null;

        $query = "SELECT *  FROM ( 
            SELECT nombreEmpleado,apMatEmpleado,apPatEmpleado,idTipoUsuario,e.esActivo,usuario,nss,curp,rfc,dep.nombreDepartamento  
            ,hr.nombreHorario,suc.idSucursal, e.actualizado,e.creado,e.fechaAlta,fechaBaja,puesto.puesto,e.fechaNacimiento,e.genero  
            , count(nss) OVER(PARTITION BY nss ORDER BY nss ASC) AS total,e.idEmpleado As idEmpleadoCerberus,ultregistro.registro As ultimoRegistro  
            ,empresa.nombreEmpresa,suc.nombreSucursal,e.correoPersonal,e.telcasa,e.idEmpresa
            ,e.telcontacto,e.perfilCalculo,e.idDepartamento,e.escolaridad,puesto.puesto AS puesto_empleado,nt.nivel AS nivel_empleado,tb.nombreTabulador AS tabulador_empleado
          ,e.genero AS genero_empleado, e.area_conocimiento AS area_conocimiento
            ,CASE 
              WHEN e.idEmpresa = 1 THEN 
                (SELECT TOP 1 codigoempleado FROM [CONTPAQ].[ctNM_RFHOODS].dbo.NOM10001 
                WHERE numerosegurosocial = nss AND estadoempleado IN ('A','R')) 
        
              WHEN e.idEmpresa = 2 THEN 
                    (SELECT TOP 1 codigoempleado FROM [CONTPAQ].[ctEBA_TRUCK_LINES].dbo.NOM10001 
                        WHERE numerosegurosocial = nss AND estadoempleado IN ('A','R')) 
        
              WHEN e.idEmpresa = 5 THEN 
                (SELECT TOP 1 codigoempleado FROM [CONTPAQ].[ctRFV_2022].dbo.NOM10001 
                    WHERE numerosegurosocial = nss AND estadoempleado IN ('A','R')) 
             
              WHEN e.idEmpresa = 9 THEN 
                (SELECT TOP 1 codigoempleado  FROM [CONTPAQ].[ctMEGAPARTESBAJIO].dbo.NOM10001
                    WHERE numerosegurosocial = nss AND estadoempleado IN ('A','R')) 
        
              WHEN e.idEmpresa = 8 THEN 
                (SELECT TOP 1 codigoempleado  FROM [CONTPAQ].[ctR-F_ADMINISTRAD].dbo.NOM10001 
                    WHERE numerosegurosocial = nss AND estadoempleado IN ('A','R')) 
              
              WHEN e.idEmpresa = 7 THEN 
                (SELECT TOP 1 codigoempleado  FROM [CONTPAQ].[ctREFIVIDRIO_GUAD].dbo.NOM10001 
                  WHERE numerosegurosocial = nss AND estadoempleado IN ('A','R')) 
        
              ELSE 
                NULL
              END	
                As idConpaq
              ,LOWER(CONCAT(e.nombreEmpleado, '.', e.apPatEmpleado)) AS usuarionombre
              ,LEN(correoPersonal) as correo_verificado
        
            FROM Empleado e  
            INNER JOIN Departamento dep ON dep.idDepartamento = e.idDepartamento   
            INNER JOIN Sucursal suc ON suc.idSucursal = e.idSucursal  AND suc.idSucursal NOT IN (19,23) 
            INNER JOIN Horario hr ON hr.idHorario = e.idHorario    
            INNER JOIN Empresa empresa ON empresa.idEmpresa = e.idEmpresa 
            LEFT JOIN Puesto puesto ON puesto.idPuesto = e.idPuesto
            LEFT JOIN NivelPuesto AS nt ON nt.idNivelPuesto = e.idNivelPuesto
            LEFT JOIN (
              Tabulador AS tb
                INNER JOIN TabuladorVersion AS tv
                  ON tb.idTabulador = tv.idTabulador
                INNER JOIN NivelPuesto AS n
                  ON n.idNivelPuesto = tb.idNivelPuesto
            )
                ON tb.idTabulador = e.idTabulador
            OUTER APPLY(   
                    SELECT  CASE WHEN MAX(fechaRegistro) IS NULL THEN '01/01/1800' ELSE MAX(fechaRegistro) END AS registro FROM Registro WHERE idEmpleado = e.idEmpleado   
            )as ultregistro
            WHERE
                (sincronizado_surver IS NULL OR sincronizado_surver = 0) AND 
                e.fechaAlta > '01/01/2021' 
                AND e.esActivo = 1 AND suc.esActivo = 1 
            AND e.idEmpresa <> 1
        ) As nm1    
        OUTER APPLY(  
                SELECT CASE WHEN MAX(fechaRegistro) IS NULL THEN '01/01/1800' ELSE MAX(fechaRegistro) END  as registro FROM Registro reg   
                    INNER JOIN Empleado ee ON reg.idEmpleado = ee.idEmpleado AND ee.idEmpresa <> 1 
                WHERE ee.nss = nm1.nss   
        )as ultregistroByNss   
        WHERE    
            nm1.ultimoRegistro =
            (CASE WHEN nm1.total > 1 THEN ultregistroByNss.registro ELSE nm1.ultimoRegistro END) AND nm1.idEmpresa != 9
        ";

		$stmt = ConexionCerberus::abrirConexion()->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,]);
        $stmt -> execute();
        $resultado = $stmt -> fetchAll();

        foreach ($resultado as $fila) {

          $nombreEmpleado = $fila['nombreEmpleado'];
          $apPatEmpleado = $fila['apPatEmpleado'];
          $apMatEmpleado = $fila['apMatEmpleado'];
          (int) $idTipoUsuario = $fila['idTipoUsuario'];
          $esActivo = $fila['esActivo'];
          $usuario = $fila['usuarionombre'];
          $nss = $fila['nss'];
          $curp = $fila['curp'];
          $rfc = $fila['rfc'];
          $nombreDepartamento = $fila['nombreDepartamento'];
          $nombreHorario = $fila['nombreHorario'];
          $idSucursal = $fila['idSucursal'];
          $actualizado = $fila['actualizado'];
          $creado = $fila['creado'];
          $fechaAlta = $fila['fechaAlta'];
          $fechaBaja = $fila['fechaBaja'];
          $puesto = $fila['puesto'];
          $fechaNacimiento = $fila['fechaNacimiento'];
          $genero = $fila['genero'];
          $total = $fila['total'];
          (int) $idEmpleado = $fila['idEmpleado'];
          (int) $idEmpleadoCerberus = $fila['idEmpleadoCerberus'];
          $ultimoRegistro = $fila['ultimoRegistro'];
          $nombreEmpresa = $fila['nombreEmpresa'];
          $nombreSucursal = $fila['nombreSucursal'];
          $correoPersonal = $fila['correoPersonal'];
          $telcasa = $fila['telcasa'];
          (int) $idEmpresa = $fila['idEmpresa'];
          $telcontacto = $fila['telcontacto'];
          $perfilCalculo = $fila['perfilCalculo'];
          (int) $idDepartamento = $fila['idDepartamento'];
          $escolaridad = $fila['escolaridad'];
          $puesto_empleado = $fila['puesto_empleado'];
          $nivel_empleado = $fila['nivel_empleado'];
          $tabulador_empleado = $fila['tabulador_empleado'];
          $genero_empleado = $fila['genero_empleado'];
          $idConpaq = $fila['idConpaq'];
          $correo_verificado = $fila['correo_verificado'];
          $area_conocimiento = $fila['area_conocimiento'];

          if ($Movimiento == "EmpleadoCerberus-Nuevo") {
           
            // echo "<br>", $idEmpleadoCerberus, ' ,',$nombreEmpleado, ' ,',$apPatEmpleado, ' ,',$apMatEmpleado, ' ,',$telcasa, ' ,',$telcontacto, ' ,',$correoPersonal, ' ,',$genero_empleado, ' ,',$usuario, ' ,',$fechaNacimiento, ' ,',$nss, ' ,',$rfc, 
            //         ' ,',$fechaAlta, ' ,',$perfilCalculo, ' ,',$idEmpresa, ' ,',$idDepartamento, ' ,',$idConpaq, ' ,',$correo_verificado, ' ,',$escolaridad, ' ,',$puesto_empleado, ' ,',$tabulador_empleado, ' ,',$idSucursal, ' ,',$area_conocimiento, 'cc' ,'<br>';

            $empleado_surver = new EmpleadoSurver();
            $r = $empleado_surver->AgregarEmpleadoNuevo($idEmpleadoCerberus, $nombreEmpleado, $apPatEmpleado, $apMatEmpleado, $telcasa, $telcontacto, $correoPersonal, $genero_empleado, $usuario, $fechaNacimiento, $nss, $rfc, $fechaAlta, $perfilCalculo, $idEmpresa, $idDepartamento, 
            $idConpaq, $correo_verificado, $escolaridad, $puesto_empleado, $tabulador_empleado, $idSucursal, $area_conocimiento);

          } else {
            echo "Sin empleados Nuevos";
          }

        }

        echo $resultado;
        return true;
        ConexionCerberus::cerrarConexion();

  }


  public function EmpleadoNuevoPuesto($Movimiento){
      
    $puesto = null;
    (int) $idEmpleado = null;

    $query = "SELECT s.idEmpleado, p.puesto, s.idPuesto
    FROM CambiosSurver AS s
    INNER JOIN Puesto AS p ON p.idPuesto = s.idPuesto
    WHERE sincronizado = 0";

    $stmt = ConexionCerberus::abrirConexion()->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,]);
    $stmt -> execute();
    $resultado = $stmt -> fetchAll();

    foreach ($resultado as $row) {
      $puesto = $row['puesto'];
      (int) $idEmpleado = $row['idEmpleado'];

      if($Movimiento == 'EmpleadoPuestoUpdate'){

        $empleado_surver = new EmpleadoSurver();
        $r = $empleado_surver->ActualizacionPuesto($puesto, $idEmpleado);
      }
    
    }
    return true;
    ConexionCerberus::cerrarConexion();

  }

}


?>