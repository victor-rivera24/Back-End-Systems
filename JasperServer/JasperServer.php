<?php
$base = dirname(dirname(__FILE__));

include_once $base . '/Librerias/phpclient/autoload.php'; //local

use Jaspersoft\Client\Client; //Local
use Jaspersoft\Exception\RESTRequestException;

class JasperServer{

    private  $HOST = "http://64.227.19.26:51541/jasperserver";
    private  $USER ="DesarrolloAdmin";
    private  $PASSWORD = "Dev_JasperSoft#20";

    public function informeComparacionExistenciasCEvsZCS($vParametro,$vNombreReporte)
	{
        try {
            /*
            $almacen =  (isset($datos->almacen)?$datos->almacen:'0');
            $producto =  (isset($datos->producto)?$datos->producto:'');
            */
            
            $archivo = $vNombreReporte;

            $variable = explode(",",$vParametro);

            // echo $num[0];
            // echo "<br>";
            // echo $num[1];
            // echo "<br>";
            // echo $num[2];

            $params = array(
                'AD_Client_ID' => (int) $variable[0],
                'AD_Org_ID' => (int) $variable[1],
                'M_Warehouse_ID' => (int)  $variable[2]
                );

            //var_dump($params);

            // $params2 = array(
            //         'AD_Client_ID' => 1000000,
            //         'AD_Org_ID' => 1000007,
            //         'M_Warehouse_ID' => 1000051
            //     );

            // var_dump($params2);


            $c = new Client($this->HOST,$this->USER,$this->PASSWORD);
            $c->setRequestTimeout(1600);
            $report = $c->reportService()->runReport('/reports/ADempiere/RFV/RF_WareHouseComaration_CEv2', 'xls', null, null,  $params);
            
            /*
            header('Access-Control-Allow-Origin: *');
            header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
            header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');             
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename=Demo.pdf');
            */

            /** CREACION DEL PDF Y GUARDAR EL RUTA DESIGNADA */ 
            $directorio = dirname(dirname(__FILE__)).'/PDF-ADempiere/';
            file_put_contents($directorio . ($archivo),$report);

            return true;

            } catch (Throwable $th) {

                return $th;
            }   

	}


    public function informeUltimoMovimientoProducto($vParametro,$vNombreReporte)
	{
        try {
            
            $archivo = $vNombreReporte;
            $variable = explode(",",$vParametro);

            $params = array(
                'AD_Client_ID' => (int) $variable[0],
                'AD_Org_ID' => (int) $variable[1],
                'M_Warehouse_ID' => (int)  $variable[2]
                );

            $c = new Client($this->HOST,$this->USER,$this->PASSWORD);
            $c->setRequestTimeout(1600);
            $report = $c->reportService()->runReport('/reports/ADempiere/RFV/RF_LastProductMovement_VM', 'xls', null, null,  $params);

            /** CREACION DEL PDF Y GUARDAR EL RUTA DESIGNADA */ 
            $directorio = dirname(dirname(__FILE__)).'/PDF-ADempiere/';
            file_put_contents($directorio . ($archivo),$report);

            return true;

            } catch (Throwable $th) {

                return $th;
            }   

	}


    public function informeProductoCero($vParametro,$vNombreReporte)
	{
        try {
            
            $archivo = $vNombreReporte;
            $variable = explode(",",$vParametro);

            $params = array(
                'AD_Client_ID' => (int) $variable[0],
                'AD_Org_ID' => (int) $variable[1],
                'M_Warehouse_ID' => (int)  $variable[2]
                );

            $c = new Client($this->HOST,$this->USER,$this->PASSWORD);
            $c->setRequestTimeout(1600);
            $report = $c->reportService()->runReport('/reports/ADempiere/RFV/RF_EmptyStockv3', 'xls', null, null,  $params);
            
            /** CREACION DEL PDF Y GUARDAR EL RUTA DESIGNADA */ 
            $directorio = dirname(dirname(__FILE__)).'/PDF-ADempiere/';
            file_put_contents($directorio . ($archivo),$report);

            return true;

            } catch (Throwable $th) {

                return $th;
            }   

	}


    public function informeProductoLogiflekk($vParametro,$vNombreReporte)
	{
        try {
            
            $archivo = $vNombreReporte;
            $variable = explode(",",$vParametro);

            // $params = array(
            //     'AD_Client_ID' => (int) $variable[0],
            //     'AD_Org_ID' => (int) $variable[1],
            //     'M_Warehouse_ID' => (int)  $variable[2]
            //     );

            $params = null;

            $c = new Client($this->HOST,$this->USER,$this->PASSWORD);
            $c->setRequestTimeout(1600);
            $report = $c->reportService()->runReport('/reports/ADempiere/RFV/RFV_ProductsLogiflekk', 'xls', null, null,  $params);
            
            /** CREACION DEL PDF Y GUARDAR EL RUTA DESIGNADA */ 
            $directorio = dirname(dirname(__FILE__)).'/PDF-ADempiere/';
            file_put_contents($directorio . ($archivo),$report);

            return true;

            } catch (Throwable $th) {

                return $th;
            }   

	}


}

