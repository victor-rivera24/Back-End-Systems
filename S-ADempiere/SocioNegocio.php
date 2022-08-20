<?php

$base = dirname(dirname(__FILE__));

include_once $base . '/DB/ConexionBD.php';
include_once $base . '/Dev/Dev_Log.php';


class SocioNegocio extends ConexionDB
{

    public function listadoSocioNegocioBloqueo($vMovimiento,$vSolicitud,$vMedio)
	{
        try {

            $data = [];
            $vDistribuidor = null;
            $vRespuesta = null;

            $query = "SELECT 
                             cb.C_BPartner_ID
                             ,cb.TaxID AS RFC
                             ,cb.Name AS RazonSocial
                             ,us.AD_User_ID
                             ,us.EMail AS Correo
                             ,us.Phone2 AS Celular
                         FROM C_BPartner AS cb
                             INNER JOIN AD_User AS us
                                 ON us.C_BPartner_ID = cb.C_BPartner_ID
                         WHERE
                             cb.C_BP_Group_ID = 1000054
                             AND cb.Isactive = 'Y'";


            $stmt = ConexionDB::abrirConexion()->prepare($query);
            $stmt -> execute();


            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    $vDistribuidor =  $row['razonsocial'];
                    $vRespuesta =  $this->ejecutarBloqueoSocioNegocio($row['ad_user_id']);

                    $data[] = [
                        'solicitud' => $vSolicitud,
                        'razonsocial' => $vDistribuidor,
                        'correo' => $row['correo'],
                        'celular' => $row['celular'],
                        'respuesta' => $vRespuesta ,
                    ];


                    $log = new Dev_Log();
                    $log->agregarLog($vMovimiento,$vSolicitud,$vDistribuidor,json_encode($row),$vRespuesta,$vMedio);

            }

            //var_dump ($data);

            return $data;

        } catch (Exception $exc) {

            return $exc;
        }  

	}

    public function listadoSocioNegocioFlyers($vMovimiento,$vSolicitud,$vMedio)
	{
        try {

            $data = [];
            $vDistribuidor = null;
            $vRespuesta = null;

            $query = "SELECT 
                             cb.C_BPartner_ID
                             ,cb.TaxID AS RFC
                             ,cb.Name AS RazonSocial
                             ,us.AD_User_ID
                             ,us.EMail AS Correo
                             ,us.Phone2 AS Celular
                         FROM C_BPartner AS cb
                             INNER JOIN AD_User AS us
                                 ON us.C_BPartner_ID = cb.C_BPartner_ID
                         WHERE
                             cb.C_BP_Group_ID = 1000054
                             AND cb.Isactive = 'Y'";


            $stmt = ConexionDB::abrirConexion()->prepare($query);
            $stmt -> execute();


            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    $vDistribuidor =  $row['razonsocial'];
                    $vRespuesta =  $this->ejecutarBloqueoSocioNegocio($row['ad_user_id']);

                    $data[] = [
                        'solicitud' => $vSolicitud,
                        'razonsocial' => $vDistribuidor,
                        'correo' => $row['correo'],
                        'celular' => $row['celular'],
                        'respuesta' => $vRespuesta ,
                    ];


                    $log = new Dev_Log();
                    $log->agregarLog($vMovimiento,$vSolicitud,$vDistribuidor,json_encode($row),$vRespuesta,$vMedio);

            }

            var_dump ($data);

            return $data;

        } catch (Exception $exc) {

            return $exc;
        }  

	}


    public function ejecutarBloqueoSocioNegocio($vIDSocio)
	{
		$stmt = ConexionDB::abrirConexion()->prepare("SELECT * FROM rf_creditvalidate_ecommerce($vIDSocio)");
        $stmt -> execute();
        $r = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        //print_r( json_encode($r) );
        return json_encode($r);
        
	}   
    
    
    /** PENDIENTE POR DEFINIR */

    // public function buscarSocioNegocioBloqueado()
	// {
	// 	$stmt = ConexionDB::abrirConexion()->prepare("SELECT 
    //                                                     cb.C_BPartner_ID
    //                                                     ,cb.TaxID AS RFC
    //                                                     ,cb.Name AS RazonSocial
    //                                                     ,us.AD_User_ID
    //                                                     --,rf_creditvalidate_ecommerce(0)
    //                                                     FROM C_BPartner AS cb
    //                                                         INNER JOIN AD_User AS us
    //                                                             ON us.C_BPartner_ID = cb.C_BPartner_ID
    //                                                     WHERE
    //                                                     cb.C_BP_Group_ID = 1000054
    //                                                     AND cb.SOCreditStatus = 'S'
    //                                                     AND cb.Isactive = 'Y'");

    //     $stmt -> execute();

    //     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    //         echo $row['c_bpartner_id']." ";
    //         echo " ". $row['razonsocial']." ";
    //         echo " ". $row['ad_user_id']."<br>";
    //         //$this->ejecutarBloqueoSocioNegocio( $row['ad_user_id']);
    //     }

    //     ConexionDB::cerrarConexion();
	// }



    
    // public function ListadoSocioNegocioEmail($vMovimiento,$vMolicitud)
	// {

    //     $query = "
    //             SELECT 
    //                 cb.C_BPartner_ID
    //                 ,cb.TaxID AS RFC
    //                 ,cb.Name AS RazonSocial
    //                 ,us.AD_User_ID
    //                 ,us.EMail AS Correo
    //                 ,us.Phone2 AS Celular
    //             FROM C_BPartner AS cb
    //                 INNER JOIN AD_User AS us
    //                     ON us.C_BPartner_ID = cb.C_BPartner_ID
    //             WHERE
    //                 cb.C_BP_Group_ID = 1000054
    //                 AND cb.Isactive = 'Y'
    //              ";

	// 	$stmt = ConexionDB::abrirConexion()->prepare($query);

    //     $stmt -> execute();

    //     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    //         echo $row['razonsocial']." ";
    //         echo " ". $row['correo']." ";
    //         echo " ". $row['celular']." ";
    //         echo " ". $row['ad_user_id']."<br>";
    //         $correo = new Email();
    //         $correo->enviarNotificacionDistribuidor($row['razonsocial'], $row['correo'],$row['celular']);
    //     }

    //     ConexionDB::cerrarConexion();
	// }


}

// $socio = new SocioNegocio();
// $socio->listadoSocioNegocioBloqueo('ADempiere','Bloqueo','Interno');


//$socio->listadoSocioNegocioBloqueo('ADempiere','Flyers');


?>