<?php

$base = dirname(dirname(__FILE__));

include_once $base . '/DB/ConexionADempiere_RFV.php';
include_once $base . '/S-Developer/Dev_Empleado.php';
// include_once $base . '/WebServiceADempiere/WS_Empleado_RFV.php';
include_once $base . '/WebServiceADempiere/WS_RFV.php';
include_once $base . '/Email/Email.php';

class RFV_OrdenVenta extends ConexionADempiereRFV{

    public function ordenVentaEcommerce()
	{

        $data = [];
        $vIdOrden = null;

        $query = "
        SELECT
        c.*
        ,cML.C_Order_ID
        ,cML.locationtype
        FROM C_Order AS c
            LEFT JOIN LATERAL (
                    SELECT
                
                        C_Order_ID
                        ,locationtype
                
                    FROM I_OrderML
    
                    GROUP BY 1,2
                              ) AS cML
            ON cML.C_Order_ID = c.C_Order_ID
            AND COALESCE(cML.locationtype,'') <> 'fulfillment'
    
        WHERE
            c.DocStatus IN ('DR')
            AND c.AD_Org_ID = 1000032
            AND c.C_DocTypeTarget_ID = 1000823
            AND c.CreatedBy = 100
            --AND c.C_Order_ID = 1265956           
        ";


		$stmt = ConexionADempiereRFV::abrirConexion()->prepare($query);
        $stmt -> execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

            $vIdOrden =  $row['c_order_id'];
            // $data[] = [
            //     'solicitud' => $vSolicitud,
            //     'razonsocial' => $vDistribuidor,
            //     'correo' => $row['correo'],
            //     'celular' => $row['celular'],
            //     'respuesta' => $vRespuesta ,
            // ];

            // $log = new Dev_Log();
            // $log->agregarLog($vMovimiento,$vSolicitud,$vDistribuidor,json_encode($row),$vRespuesta,$vMedio);
            $WS_RFV = new WebServiceADempiereRFV();
            $r = $WS_RFV->completarOrdenesVentaEcommerce($vIdOrden);  

        }

        return $data;

        ConexionADempiereRFV::cerrarConexion();
	}

}

?>