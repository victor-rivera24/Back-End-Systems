<?php
$base = dirname(dirname(__FILE__));
include_once $base . '/DB/ConexionADempiere_RFV.php';
include_once $base . '/S-New-UI-Sync/ConsultaAPI.php';


class ConsultaProducto extends ConexionADempiereRFV
{

    public function consultaProductoADempiere($producto, $ordenID, $canti)
	{
        $cantidad  =(int) $canti;
        echo $cantidad;
        try { 
            $url ='https://apps-ws.refividrio.com.mx/api-adempiere/v1/rfv/buscarProductoCodigo?producto='.$producto;
            $autorizacion = '[1cf52083b56d226d6852904586ba04f0]';
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Api-Key:' . $autorizacion));
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($ch);
            curl_close($ch);
            $result = json_decode( $result );

            if(!empty($result)){
                $productos = null;
                foreach ($result->data as $dataRes) {
                    $productos = array(
                        'id_producto' =>  $dataRes->m_product_id,
                        'codigo'=> $dataRes->codigo,
                        'cantidad'=> $cantidad,
                    );
                }
                $developer = new ConsultaProducto();
                $r = $developer->EnvioADempiere($productos);
            } else {
                echo 'NO se encontro el producto, por lo que no se ha realziado el envio a ADempiere';
            }

           
        } catch (\Throwable $th) {
            echo $th;
            return false;
        }

	}

    public function EnvioADempiere($productos)
	{
        try { 
            $url ='http://172.16.102.54/api-adempiere/v1/rfv/ordenVenta';
            $autorizacion = '[1cf52083b56d226d6852904586ba04f0]';
            $ch = curl_init($url);
            $jsonData = array(
                'vEmpresa_ID' => 1000000,
                'vOrganizacion_ID' => 10000002,
                'vSocio_ID' => 1001330,
                'vAlmacen_ID' => 1000161,
                'vTipoDocumento' => 1000030,
                'vDocumentoReferencia' => 'AXDDS56565AS',
                'vProductos' => array($productos)
            ); 
            $data_string = json_encode($jsonData);
            // echo $data_string;
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Api-key:' . $autorizacion));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5); 
            $result = curl_exec($ch); 
            curl_close($ch);
            $result = json_decode($result) ;
            if($result->status == 'success'){
                $respuesta = json_encode($result->data);
                $envio = new ConsultaApi();
                $r = $envio->RespuestaADempiere($respuesta);
            } else {
                echo 'NO se ha podido sincronizar con ADempiere';
            }

        } catch (\Throwable $th) {
            echo $th;
            return false;
        }

	}

  

}


?>
