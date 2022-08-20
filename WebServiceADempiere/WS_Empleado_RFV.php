<?php
$base = dirname(dirname(__FILE__));

include_once $base . '/Conexiones/WS_RFV.php';
include_once $base . '/S-Developer/Dev_Empleado.php';

class WebServiceADempiereRFV {

    private $url = WS_SERVIDOR_RFV;
    private $user = WS_USUARIO_RFV ;
    private $password = WS_CONTRASENIA_RFV;
    private $lang = WS_LANG_RFV;
    private $client = WS_Cliente_RFV;
    private $role = WS_Rol_RFV;
    private $organization = WS_Organizacion_RFV;
    private $warehouse = WS_Almacen_RFV;
    private $stage = WS_Stage_RFV;

    public function bajaEmpleado($vEmpresa,$vEmpleado,$HR_Employee_ID){

        $IdOrden = null;

                $XML = '
                <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:adin="http://3e.pl/ADInterface">
                <soapenv:Header/>
                <soapenv:Body>
                   <adin:updateData>
                      <adin:ModelCRUDRequest>
                         <adin:ModelCRUD>
                            <adin:serviceType>WS_Baja_Empleado</adin:serviceType>
                            <adin:TableName>HR_Employee</adin:TableName>
                            <adin:RecordID>'.$HR_Employee_ID.'</adin:RecordID>
                           <adin:Action>Update</adin:Action>
                            <adin:DataRow>                                      
                                  <adin:field column="IsActive">
                                    <adin:val>N</adin:val>
                                  </adin:field>
                            </adin:DataRow>
                         </adin:ModelCRUD>
                         <adin:ADLoginRequest>
                            <adin:user>'.$this->user.'</adin:user>
                            <adin:pass>'.$this->password.'</adin:pass>
                            <adin:lang>'.$this->lang.'</adin:lang>
                            <adin:ClientID>'.$this->client.'</adin:ClientID>
                            <adin:RoleID>'.$this->role.'</adin:RoleID>
                            <adin:OrgID>'.$this->organization.'</adin:OrgID>
                            <adin:WarehouseID>'.$this->warehouse.'</adin:WarehouseID>
                            <adin:stage>'.$this->stage.'</adin:stage>
                         </adin:ADLoginRequest>
                      </adin:ModelCRUDRequest>
                   </adin:createData>
                </soapenv:Body>
              </soapenv:Envelope>                
                ';


            $Url = $this->url;

                                
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $Url);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $XML);
            $resultado = curl_exec($ch);
            //echo $resultado ."<br />" ;
            curl_close($ch);
            //echo $ch;
            
            $datoXML = simplexml_load_string($resultado);
            $datoXML->registerXPathNamespace("ns1", "http://3e.pl/ADInterface");
            
            $response = $datoXML->xpath("//ns1:StandardResponse")[0];
            //$dataArray['detalleFraccion'] = (string) $response['RecordID'];
            //echo  $response . "<br>";
            //echo "ID Orden " . $response[0]['RecordID'] . "<br>";

            $IdOrden = (int) $response['RecordID'];

            echo $IdOrden . "<br>";

            if($IdOrden){
                $developer = new Empleado();
                $developer->actualizarEmpleadoCerberus('Baja-Empleado-ADempiere',$vEmpresa,$vEmpleado,$IdOrden);
            }

            $output = array('message' => $IdOrden);

            return $IdOrden;
        
    }


    public function completarOrdenesVentaEcommerce($vOrden){

      $respuesta = null;

              $XML = '
              <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:adin="http://3e.pl/ADInterface">
              <soapenv:Header/>
              <soapenv:Body>
                 <adin:setDocAction>
                    <adin:ModelSetDocActionRequest>
                       <adin:ModelSetDocAction>
                          <adin:serviceType>RF_Order_Complete_PS</adin:serviceType>
                          <adin:tableName>C_Order</adin:tableName>
                          <adin:recordID>'.$vOrden.'</adin:recordID>
                          <adin:docAction>CO</adin:docAction>
                       </adin:ModelSetDocAction>
                       <adin:ADLoginRequest>
                        <adin:user>'.$this->user.'</adin:user>
                        <adin:pass>'.$this->password.'</adin:pass>
                        <adin:lang>'.$this->lang.'</adin:lang>
                        <adin:ClientID>'.$this->client.'</adin:ClientID>
                        <adin:RoleID>'.$this->role.'</adin:RoleID>
                        <adin:OrgID>'.$this->organization.'</adin:OrgID>
                        <adin:WarehouseID>'.$this->warehouse.'</adin:WarehouseID>
                        <adin:stage>'.$this->stage.'</adin:stage>
                       </adin:ADLoginRequest>
                    </adin:ModelSetDocActionRequest>
                 </adin:setDocAction>
              </soapenv:Body>
           </soapenv:Envelope>            
              ';


          $Url = $this->url;

                              
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $Url);
          curl_setopt($ch, CURLOPT_VERBOSE, 1);
          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
          curl_setopt($ch, CURLOPT_POSTFIELDS, $XML);
          $resultado = curl_exec($ch);
          //echo $resultado ."<br />" ;
          curl_close($ch);
          //echo $ch;
          
          $datoXML = simplexml_load_string($resultado);
          $datoXML->registerXPathNamespace("ns1", "http://3e.pl/ADInterface");
          
          $response = $datoXML->xpath("//ns1:StandardResponse")[0];
          $respuesta = (int) $response['RecordID'];

          echo $respuesta . "<br>";

         //  if($IdOrden){
         //      $developer = new Empleado();
         //      $developer->actualizarEmpleadoCerberus('Baja-Empleado-ADempiere',$vEmpresa,$vEmpleado,$IdOrden);
         //  }

          $output = array('message' => $respuesta);

          return $respuesta;
      
  }


}

?>