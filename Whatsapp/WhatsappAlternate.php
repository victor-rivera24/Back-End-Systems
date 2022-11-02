<?php 

/**
 * Esta clase fue generarada realizar peticiones a la API de WhatsApps Terceros
 * 
 * @since 31/10/2022 se creó esta clase
 * @author Victor Rivera
 */
class WhatsappAlternate{

    private $endpoint = 'https://apps-ws.refividrio.com.mx:6868/v1/whatsapp/';
    private $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzeXN0ZW0iOiJCQUNLLUVORC1TWVNURU0iLCJ1c2VyIjoidmljdG9yLnJpdmVyYSIsImlhdCI6MTY2NzM0NTQ2NH0._kGB3B3SLp46hlntbWpzwiK0mpqdotutvXnW1HctRoo';  


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
          $header = array("Content-Type: application/json","api-key: $this->token");
        //   $header = array("Content-Type: application/json");

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
        $p_Mensaje = 'Estimado colaborador *'.$p_Nombre.'*
Te recordamos responder tu *encuesta semanal COVID-19* este fin de semana. Para evitar que seas sancionado.
El link de ingreso es el siguiente:
https://surver.code-byte.com.mx/surver/

Dudas o soporte, vía WhatsApp al  55 6988 3029

Este es un mensaje automático, por lo cual no emite respuesta.
Saludos.
';
        

        try {
          $response = null;
          $url = $this->endpoint.'sendIndividualMessage';
          $header = array("Content-Type: application/json","api-key: $this->token");
        //   $header = array("Content-Type: application/json");

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

// $msg = new WhatsappAlternate();
// $msg->mensajeEncuestaFaltante('Victor Rivera','5576100176');
// $msg->mensajePrueba();
