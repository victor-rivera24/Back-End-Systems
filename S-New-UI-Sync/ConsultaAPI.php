<?php
$base = dirname(dirname(__FILE__));
include_once $base . '/DB/ConexionNewIDSync.php';
include_once $base . '/S-ADempiere/servicioProducto.php';

class ConsultaApi extends ConexionNewUISync
{

    public function consultaServicioApi()
	{
        try { 
            $url ='http://localhost/api-adempiere/v1/cerberus/consultaXml';
            $autorizacion = '[C3RB3RU$_3d524a53c110e4c22463b10ed32cef9d]';

            $ch = curl_init($url);
            // $jsonData = array(
            //     'API_KEY'=>'surver_$MGsecretkey$Surver$NodeJS&ApiCerberus',
            //     'id_empleado' => 1,
            //     'rol' =>  'KOSTEN'
            // ); 

            // $jsonDataEncoded = json_encode($jsonData);
            // curl_setopt($ch, CURLOPT_POST, 1);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_POSTFIELDS, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml', 'Api-key:' . $autorizacion));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5); 
            $result = curl_exec($ch); 
            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
            if ( $status !== 201 && $status !== 200 ) { 
                return  ("Error: call to URL $url failed with status $status, response $result, curl_error " . curl_error($ch) . ", curl_errno " . curl_errno($ch));
            }
            curl_close($ch);

            $xml = simplexml_load_string($result);
            if(!empty($result)){
                $developer = new ConsultaApi();
                $r = $developer->insertaXML($result);
            } else {
                echo 'NO es posible encotnrar un archivo xml';
            }

        } catch (\Throwable $th) {
            echo $th;
            return false;
        }
	}

    public function insertaXML($datosXML)
    {
        $Fecha = strtotime(date('Y-m-d h:m:s'));
        $guardar = new DOMDocument();
        $guardar->preserveWhiteSpace = false;
        $guardar->formatOutput = true;
        $guardar->loadXML($datosXML); //XML de prueba
        $guardar->encoding = "utf-8";
        $carpeta = date("Y-m-d");
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0777, true);
        }
        $ruta = $guardar->save($carpeta. '/empresa_' . $Fecha . '_.xml');
        
        $resultado = file_get_contents($carpeta . '/empresa_'. $Fecha . '_.xml');
        $archivo = pg_escape_bytea($resultado);

        $dom = new DOMDocument;
        $dom->loadXML($datosXML);
        $resXML = simplexml_import_dom($dom);

        $shipmentID = null;
        $OfficialStore = null;
        $BuyerNickname = null;
        $BuyerPhone = null;
        $LogisticType = null;
        $TrackingMethod = null;
        $TrackingNumber = null;
        $ShipmentStatus = null;
        $PaymentID = null;
        $PaymentType = null;
        $URL = null;
        $marketplace = 'NombreEmpresa';
        $sincronizado = false;

        if(!empty($resXML->Order[0]->shipmentID)){
            $shipmentID =  $resXML->Order[0]->ShipmentID;
        } else {
            $shipmentID = null;
        }
        if(!empty($resXML->Order[0]->OfficialStore)){
            $OfficialStore = $resXML->Order[0]->OfficialStore;
        } else {
            $OfficialStore = null;
        }

        if(!empty($resXML->Order[0]->BuyerNickname)){
            $BuyerNickname = $resXML->Order[0]->BuyerNickname;
        } else {
            $BuyerNickname = null;
        }
        if(!empty($resXML->Order[0]->BuyerPhone)){
            $BuyerPhone = $resXML->Order[0]->BuyerPhone;
        }
        
        if(!empty($resXML->Order[0]->LogisticType)){
            $LogisticType = $resXML->Order[0]->LogisticType;
        }
        
        if(!empty($resXML->Order[0]->TrackingMethod)){
            $TrackingMethod = $resXML->Order[0]->TrackingMethod;
        }
        
        if(!empty($resXML->Order[0]->TrackingNumber)){
            $TrackingNumber = $resXML->Order[0]->TrackingNumber;
        }
        
        if(!empty($resXML->Order[0]->ShipmentStatus)){
            $ShipmentStatus = $resXML->Order[0]->ShipmentStatus;
        }
        
        if(!empty($resXML->Order[0]->PaymentID)){
            $PaymentID = $resXML->Order[0]->PaymentID;
        }
       
        if(!empty($resXML->Order[0]->PaymentType)){
            $PaymentType = $resXML->Order[0]->PaymentType;
        }
        
        if(!empty($resXML->Order[0]->URL)){
            $URL = $resXML->Order[0]->URL;
        }
        
        try {

            $agregar = "INSERT INTO marketplace_xml(userid,seller_id, order_id, shipment_id, date_created, official_store, buyer_nickname, buyer_name, buyer_phone, buyer_street, buyer_city, buyer_state, buyer_country, buyer_zip_code
                            , logistic_type, tracking_method, tracking_number, sku, item_id, item_title, quantity, unit_price, total_amount, order_status, shipment_status, seller_nickname, shipment_cost, payment_id, payment_type, url, marketplace, sincronizado, archivo)
                VALUES ( :userid, :sellerid, :orderid, :ShipmentID, :DateCreated, :OfficialStore, :BuyerNickname, :BuyerName, :BuyerPhone, :BuyerStreet, :BuyerCity, :BuyerState, :BuyerCountry, :BuyerZipCode
                            , :LogisticType, :TrackingMethod, :TrackingNumber, :SKU, :ItemID, :ItemTitle, :Quantity,:UnitPrice, :TotalAmount, :OrderStatus, :ShipmentStatus, :SellerNickname, :ShipmentCost, :PaymentID, :PaymentType, :URL, '".$marketplace."', :sincronizado, '{$archivo}')"; //,  
            $stmt = ConexionNewUISync::abrirConexion()->prepare($agregar);
            $stmt->bindParam(":userid", $resXML->Order[0]->UserID, PDO::PARAM_INT);
            $stmt->bindParam(":sellerid",$resXML->Order[0]->SellerID, PDO::PARAM_INT);
            $stmt->bindParam(":orderid",$resXML->Order[0]->OrderID, PDO::PARAM_INT);
            $stmt->bindParam(":ShipmentID",$shipmentID, PDO::PARAM_INT);
            $stmt->bindParam(":DateCreated",$resXML->Order[0]->DateCreated, PDO::PARAM_STR);
            $stmt->bindParam(":OfficialStore",$OfficialStore, PDO::PARAM_STR);
            $stmt->bindParam(":BuyerNickname",$BuyerNickname, PDO::PARAM_STR);
            $stmt->bindParam(":BuyerName",$resXML->Order[0]->BuyerName, PDO::PARAM_STR);
            $stmt->bindParam(":BuyerPhone",$BuyerPhone, PDO::PARAM_STR);
            $stmt->bindParam(":BuyerStreet",$resXML->Order[0]->BuyerStreet, PDO::PARAM_STR);
            $stmt->bindParam(":BuyerCity",$resXML->Order[0]->BuyerCity, PDO::PARAM_STR);
            $stmt->bindParam(":BuyerState",$resXML->Order[0]->BuyerState, PDO::PARAM_STR);
            $stmt->bindParam(":BuyerCountry",$resXML->Order[0]->BuyerCountry, PDO::PARAM_STR);
            $stmt->bindParam(":BuyerZipCode",$resXML->Order[0]->BuyerZipCode, PDO::PARAM_INT);
            $stmt->bindParam(":LogisticType", $LogisticType, PDO::PARAM_STR);
            $stmt->bindParam(":TrackingMethod", $TrackingMethod, PDO::PARAM_STR);
            $stmt->bindParam(":TrackingNumber", $TrackingNumber, PDO::PARAM_STR);
            $stmt->bindParam(":SKU",$resXML->Order[0]->SKU, PDO::PARAM_STR);
            $stmt->bindParam(":ItemID",$resXML->Order[0]->ItemID, PDO::PARAM_INT);
            $stmt->bindParam(":ItemTitle",$resXML->Order[0]->ItemTitle, PDO::PARAM_STR);
            $stmt->bindParam(":Quantity",$resXML->Order[0]->Quantity, PDO::PARAM_INT);
            $stmt->bindParam(":UnitPrice",$resXML->Order[0]->UnitPrice, PDO::PARAM_INT);
            $stmt->bindParam(":TotalAmount",$resXML->Order[0]->TotalAmount, PDO::PARAM_INT);
            $stmt->bindParam(":OrderStatus",$resXML->Order[0]->OrderStatus, PDO::PARAM_STR);
            $stmt->bindParam(":ShipmentStatus", $ShipmentStatus, PDO::PARAM_STR);
            $stmt->bindParam(":SellerNickname",$resXML->Order[0]->SellerNickname, PDO::PARAM_STR);
            $stmt->bindParam(":ShipmentCost",$resXML->Order[0]->ShipmentCost, PDO::PARAM_INT);
            $stmt->bindParam(":PaymentID",$PaymentID, PDO::PARAM_INT);
            $stmt->bindParam(":PaymentType", $PaymentType, PDO::PARAM_STR);
            $stmt->bindParam(":URL", $URL, PDO::PARAM_STR);
            $stmt->bindParam(":sincronizado", $sincronizado, PDO::PARAM_BOOL);

            $r = $stmt->execute();

            if($r){
                $servicio = new ConsultaProducto();
                $r = $servicio->consultaProductoADempiere($resXML->Order[0]->SKU, $resXML->Order[0]->OrderID, $resXML->Order[0]->Quantity);
                return true;

            }else{
                return false;

            }

        } catch (Exception $exc) {

            return $exc;
        }
        ConexionNewUISync::cerrarConexion();
    }

    public function RespuestaADempiere($respuesta)
    {
        try {
            $actualizar = "UPDATE marketplace_xml SET respuesta= :respuesta  WHERE id_marketplace_xml = (SELECT MAX(id_marketplace_xml) FROM marketplace_xml) ";
            $stmt = ConexionNewUISync::abrirConexion()->prepare($actualizar);
            $stmt->bindParam(":respuesta",$respuesta, PDO::PARAM_STR);

            $r = $stmt->execute();
            echo $r;
            if($r){
                echo 'exito al enviar la respuesta';

            }else{
                echo 'NO se recibio una respuesta';
            }

        } catch (Exception $exc) {

            return $exc;
        }
        ConexionNewUISync::cerrarConexion();
    }

}


?>
