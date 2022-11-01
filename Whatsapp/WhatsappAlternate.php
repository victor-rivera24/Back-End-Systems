<?php 

/**
 * Esta clase fue generarada realizar peticiones a la API de WhatsApps Terceros
 * 
 * @since 31/10/2022 se creó esta clase
 * @author Victor Rivera
 */
class WhatsappAlternate{

    private $endpoint = 'https://apps-ws.refividrio.com.mx:6868/whatsapp/';
    private $token = 'eyJhbGciOiJIUzI1NiJ9.dXN1YXJpb01lc3NhZ2VCaXJkV2hhdHNhcHA.k_9BpJn3XKh5U-j-IboLzrM2xf30KniPvaXNvZPsOgY';  


    /**
     * Envía mensaje para comprobar la sesión activa.
     * 
     * @since 01/11/2022 se genero el método
     * @author Victor Rivera
     */       
    public function mensajePrueba()
    {

        try {
          $response = null;
          $url = $this->endpoint.'testService';
          // $header = array("Content-Type: application/json","access-token: $this->token");
          $header = array("Content-Type: application/json");

          $ch = curl_init($url);
        //   curl_setopt($ch, CURLOPT_POST,1);
        //   curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
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
  
    
    /**
     * Retorna el json con la respuesta de la petición.
     * 
     * @since 31/10/2022 se genero el método
     * @author Victor Rivera
     */       
    public function mensajeEncuestaFaltante($vNombre,$vCelular)
    {

        $p_Nombre = $vNombre;
        $p_Celular = $vCelular;
        $p_Mensaje = 'Estimado usuario *'.$p_Nombre.'*
Le recordamos realizar su encuesta covid. Para evitar que sean sancionados.
Este es un mensaje de automatico, por lo cual no emite respuesta.';
        

        try {
          $response = null;
          $url = $this->endpoint.'sendIndividualMessage';
          // $header = array("Content-Type: application/json","access-token: $this->token");
          $header = array("Content-Type: application/json");

          $jsonData = array(
                            "vPhone" => $p_Celular
                            ,"vMessage" => $p_Mensaje
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




                

    /** HABILITAR CUANDO SE QUIERA EJECUTAR LOCALMENTE */

$msg = new WhatsappAlternate();
// $msg->mensajePrueba();
$msg->mensajeEncuestaFaltante('Victor Rivera','5576100176');
