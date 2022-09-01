<?php

$base = dirname(dirname(__FILE__));

include_once $base . '/DB/ConexionADempiere_RFV.php';
include_once $base . '/S-Developer/Dev_Empleado.php';
include_once $base . '/Email/Email.php';
include_once $base . '/WebServiceADempiere/WS_RFV.php';

class EmpleadoADempiereRFV extends ConexionADempiereRFV
{

    public function consultaUsuarioADempiere()
	{
        $data = [];
        $vDistribuidor = null;
        $vRespuesta = null;

        $query = "
        SELECT
        --*
        cb.C_BPartner_ID
        ,cb.Value AS CodigoProveedor
        ,cb.Name||' '||cb.Name2||' '||cb.Description AS NombreCompleto 
        ,cb.TaxID AS RFC
        ,cb.Isactive AS Activo
        
        --Empleado
        ,usr.AD_User_ID 
        ,usr.Name AS usuario
        --,emp.Name||' '||emp.Name2 AS NombreCompleto 
        --,emp.NationalCode AS CURP
        --,emp.SSCode AS NSS
        ,usr.Isactive AS Activo
        
        
        FROM C_BPartner AS cb
            INNER JOIN AD_User AS usr
                ON usr.C_BPartner_ID  = cb.C_BPartner_ID
                AND usr.Isactive = 'Y'
                AND usr.IsInternalUser = 'Y'
            
        WHERE
        
        cb.C_BP_Group_ID = 1000002
        AND cb.Isactive = 'Y'
        
        ORDER BY NombreCompleto ASC
        ";

		$stmt = ConexionADempiereRFV::abrirConexion()->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,]);
        //$sentencia = $base_de_datos->prepare($consulta, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,]);

        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo $row['nombreEmpleado']." ";
            echo " ". $row['apPatEmpleado']." ";
            echo " ". $row['apMatEmpleado']." ";
            echo "<br>";
            //$log = new Dev_Log();
            //$log->agregarLog($vMovimiento,$vSolicitud,$vDistribuidor,json_encode($row),$vRespuesta,$vMedio);
        }

        return $data;

        ConexionADempiereRFV::cerrarConexion();
	}

    
    /** 
     * Es metodo obtiene los empleados activos que existen
     * @param Integer $vEmpresa
     * @param Integer $vEmpleado
     * @param String $vRFC
     * @param String $vCURP
     * 
     * @return DataTable Muestra de la consulta. 
     * @author Victor Rivera
    */
    public function consultaEmpleadoADempiere($vEmpresa,$vEmpleado,$vRFC,$vCURP)
	{

        (int) $HR_Employee_ID = null;
        $Nombre_Empleado = null;
        $CURP = null;
        $RFC = null;
        $Activo = null;

        $query = "SELECT
        --*
        cb.C_BPartner_ID
        ,cb.Value AS CodigoProveedor
        ,cb.Name||' '||cb.Name2||' '||cb.Description AS NombreCompleto 
        ,cb.TaxID AS RFC
        ,cb.Isactive AS Activo
        
        --Empleado
        ,emp.HR_Employee_ID 
        ,emp.Name||' '||emp.Name2 AS NombreCompleto 
        ,emp.NationalCode AS CURP
        ,emp.SSCode AS NSS
        ,emp.Isactive AS Activo
        
        
        FROM C_BPartner AS cb
            INNER JOIN HR_Employee AS emp
                ON emp.C_BPartner_ID  = cb.C_BPartner_ID
                --AND emp.Isactive = 'Y'
            
        WHERE
        
        cb.C_BP_Group_ID = 1000002
        AND cb.TaxID = '".$vRFC."'
        AND emp.NationalCode = '".$vCURP."'
        --AND cb.Isactive = 'Y'
        ";

		$stmt = ConexionADempiereRFV::abrirConexion()->prepare($query);
        //$sentencia = $base_de_datos->prepare($consulta, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,]);

        $stmt -> execute();
        $resultado = $stmt -> fetchAll();

        foreach ($resultado as $fila) {

            $Nombre_Empleado = $fila['nombrecompleto'];
            $HR_Employee_ID = $fila['hr_employee_id'];
            $CURP = $fila['curp'];
            $RFC = $fila['rfc'];

            $WS_RFV = new WebServiceADempiereRFV();
            $r = $WS_RFV->bajaEmpleado($vEmpresa,$vEmpleado,$HR_Employee_ID);         
        } 

        return true;

        ConexionADempiereRFV::cerrarConexion();
	}



    /** 
     * En este metodo obtiene los usuarios activos.
     * @param Integer $vEmpresa
     * @param Integer $vEmpleado
     * @param String $vRFC
     * @param String $vCURP
     * 
     * @return DataTable Muestra de la consulta. 
     * @author Victor Rivera
    */
    public function consultaEmpleadoUsuarioADempiere($vEmpresa,$vEmpleado,$vRFC,$vCURP)
	{

        (int) $AD_User_ID = null;
        $Nombre_Empleado = $vEmpleado;
        //$CURP = $vCURP;
        $RFC = $vRFC;

        $query = "SELECT 
        GetColumnValue(cb.AD_Client_ID,'AD_Client','Name') AS Empresa
        ,cb.Value AS Codigo
        ,cb.Name ||' '||cb.Name2||' '||cb.Description AS SocioNegocio
        ,cb.TaxID AS RFC
        ,cb.Isactive AS ActivoSocio
        ,us.AD_User_ID
        ,us.Name AS Usuario
        ,us.Isactive AS ActivoUsuario
        --,string_to_array(us.Name,' ')::VARCHAR[]
        --,array_length (string_to_array(us.Name,' ')::VARCHAR[],1)
        --,us.*
    FROM C_BPartner AS cb
        LEFT JOIN AD_User AS us
            ON us.C_BPartner_ID = cb.C_BPartner_ID
            AND us.IsInternalUser = 'Y'
    WHERE
        cb.C_BP_Group_ID = 1000002
        AND us.Name ILIKE '%.%'
        --AND us.Isactive = 'Y'
        AND cb.TaxID = '".$vRFC."'
        AND array_length (string_to_array(us.Name,' ')::VARCHAR[],1) = 1";



		$stmt = ConexionADempiereRFV::abrirConexion()->prepare($query);
        //$sentencia = $base_de_datos->prepare($consulta, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,]);

        $stmt -> execute();
        $resultado = $stmt -> fetchAll();

        foreach ($resultado as $fila) {

            $Nombre_Empleado = $fila['socionegocio'];
            $AD_User_ID = $fila['ad_user_id'];
            //$CURP = $fila['curp'];
            $RFC = $fila['rfc'];

            $WS_RFV = new WebServiceADempiereRFV();
            $r = $WS_RFV->desactivarUsuarioDirecto($vEmpresa,$vEmpleado,$AD_User_ID);         
        } 

        return true;

        ConexionADempiereRFV::cerrarConexion();
	}



    /** 
     * En este metodo obtiene los usuarios activos.
     * @param Integer $vEmpresa
     * @param Integer $vEmpleado
     * @param String $vRFC
     * @param String $vCURP
     * 
     * @return DataTable Muestra de la consulta. 
     * @author Victor Rivera
    */
    public function consultaSocioNegocioEmpleadoADempiere($vEmpresa,$vEmpleado,$vRFC,$vCURP)
	{

        (int) $C_BPartner_ID = null;
        $Nombre_Empleado = $vEmpleado;
        //$CURP = $vCURP;
        $RFC = $vRFC;

        $query = "SELECT 
        GetColumnValue(cb.AD_Client_ID,'AD_Client','Name') AS Empresa
        ,cb.C_BPartner_ID
        ,cb.Value AS Codigo
        ,cb.Name ||' '||cb.Name2||' '||cb.Description AS SocioNegocio
        ,cb.TaxID AS RFC
        ,cb.Isactive AS ActivoSocio
    FROM C_BPartner AS cb

    WHERE
        cb.C_BP_Group_ID = 1000002
        AND cb.TaxID = '".$vRFC."'
        ";



		$stmt = ConexionADempiereRFV::abrirConexion()->prepare($query);
        //$sentencia = $base_de_datos->prepare($consulta, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,]);

        $stmt -> execute();
        $resultado = $stmt -> fetchAll();

        foreach ($resultado as $fila) {

            $Nombre_Empleado = $fila['socionegocio'];
            $C_BPartner_ID = $fila['c_bpartner_id'];
            //$CURP = $fila['curp'];
            $RFC = $fila['rfc'];

            $WS_RFV = new WebServiceADempiereRFV();
            $r = $WS_RFV->desactivarSocioNegocioDirecto($vEmpresa,$vEmpleado,$C_BPartner_ID);         
        } 

        return true;

        ConexionADempiereRFV::cerrarConexion();
	}




}

// $orden = new EmpleadoCerberus();
// $orden->obtenerEmpleadoIncidenciaBaja();



?>