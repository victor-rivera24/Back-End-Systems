<?php 

class WhatsappBirdInterno{

    private $endpoint = 'https://apps-ws.refividrio.com.mx:5252/';
    private $token = 'eyJhbGciOiJIUzI1NiJ9.dXN1YXJpb01lc3NhZ2VCaXJkV2hhdHNhcHA.k_9BpJn3XKh5U-j-IboLzrM2xf30KniPvaXNvZPsOgY';  
    private $urlMedia = "https://apps.refividrio.com.mx/resources/amoresens/CUPON_DE_REGALO.png";

    public function mensajeFelizCumple($vEmpleado,$vCelular){

      try {
          $response = null;
          $url = $this->endpoint.'happyBirthdayEmployee';
          $header = array("Content-Type: application/json","access-token: $this->token");
         
          $jsonData = array(
                            "vCelular" => $vCelular
                            ,"vNombre" => $vEmpleado
                          );

          $json = json_encode($jsonData);

          $ch = curl_init($url);
          curl_setopt($ch, CURLOPT_POST,1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
          curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $result =  curl_exec($ch);
          $status = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
          $status_endpoint = curl_error($ch);
          curl_close($ch);

          // var_dump ($result);

          if ( $status != 201 && $status != 200 ) {
              // return  ("Error: call to URL $url failed with status $status, response $result, curl_error " . $status_endpoint . ",curl_errno" . $status_endpoint );
              $response  = ("Error: call to URL $url failed with status $status, response $result, curl_error " . $status_endpoint . ",curl_errno" . $status_endpoint );

          }else{
              $response = $result;

          }

          // print_r (json_decode($result));
          // return json_decode($result);
          print_r($response);
          return $response;
          
      } catch (\Throwable $th) {
          echo $th;
          return false;
      }

  }
                
}

// $msg = new WhatsappBirdInterno();
// $msg->mensajeFelizCumple('VICTOR','5576100176');

