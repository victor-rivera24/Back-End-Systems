<?php

$base = dirname(dirname(__FILE__));
include_once $base . '/S-Developer/Dev_Empleado.php';

class WebServiceADempiereRFV {

    // private $url = 'http://172.16.102.91/api-adempiere/v1/rfv/';
   private $url = 'https://apps-ws.refividrio.com.mx/api-adempiere/v1/rfv/';
   private $api = '[1cf52083b56d226d6852904586ba04f0]' ;


    public function bajaEmpleado($vEmpresa,$vEmpleado,$vID){

      try {
          
          $url = $this->url.'desactivarEmpleadoDirecto?vID='.$vID;
          $ch = curl_init($url);
          
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'GET');
          curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type: application/json','Api-Key:'.$this->api));
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $result = curl_exec($ch);
          $status = curl_getinfo($ch,CURLINFO_HTTP_CODE);

          
          if ( $status !== 201 && $status !== 200 ) { 
              return  ("Error: call to URL $url failed with status $status, response $result, curl_error " . curl_error($ch) . ", curl_errno " . curl_errno($ch));
          }
          curl_close($ch);

          $respuesta =  json_decode($result);

        //   var_dump($respuesta);
        //   var_dump($respuesta->data);

            if( $respuesta->status == 'success' ){
                $ID = json_encode($respuesta);
                $developer = new Empleado();
                $developer->actualizarEmpleadoCerberus('Baja-Empleado-ADempiere',$vEmpresa,$vEmpleado,$ID);
            }

          return $respuesta;


      } catch (\Throwable $th) {
          echo $th;
          return false;
      }

  }



    public function desactivarUsuarioDirecto($vEmpresa,$vEmpleado,$vID){

      try {
          
          $url = $this->url.'desactivarUsuarioDirecto?vID='.$vID;
          $ch = curl_init($url);
          
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'GET');
          curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type: application/json','Api-Key:'.$this->api));
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $result = curl_exec($ch);
          $status = curl_getinfo($ch,CURLINFO_HTTP_CODE);

          
          if ( $status !== 201 && $status !== 200 ) { 
              return  ("Error: call to URL $url failed with status $status, response $result, curl_error " . curl_error($ch) . ", curl_errno " . curl_errno($ch));
          }
          curl_close($ch);

          $respuesta = json_decode($result);

            if( $respuesta->status == 'success' ){
                $ID = json_encode($respuesta);
                $developer = new Empleado();
                $developer->actualizarEmpleadoCerberus('Baja-EmpleadoUsuario-ADempiere',$vEmpresa,$vEmpleado,$ID);
            }

          return $respuesta;


      } catch (\Throwable $th) {
          echo $th;
          return false;
      }

  }

  public function desactivarSocioNegocioDirecto($vEmpresa,$vEmpleado,$vID){

    try {
        
        $url = $this->url.'desactivarSocioNegocioDirecto?vID='.$vID;
        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'GET');
        curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type: application/json','Api-Key:'.$this->api));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $status = curl_getinfo($ch,CURLINFO_HTTP_CODE);

        
        if ( $status !== 201 && $status !== 200 ) { 
            return  ("Error: call to URL $url failed with status $status, response $result, curl_error " . curl_error($ch) . ", curl_errno " . curl_errno($ch));
        }
        curl_close($ch);

        $respuesta = json_decode($result);

          if( $respuesta->status == 'success' ){
              $ID = json_encode($respuesta);
              $developer = new Empleado();
              $developer->actualizarEmpleadoCerberus('Baja-EmpleadoUsuario-ADempiere',$vEmpresa,$vEmpleado,$ID);
          }

        return $respuesta;


    } catch (\Throwable $th) {
        echo $th;
        return false;
    }

}


  public function completarOrdenesVentaEcommerce($vID){

    try {
        
        $url = $this->url.'completaOrdenVenta?vID='.$vID;
        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'GET');
        curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type: application/json','Api-Key:'.$this->api));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $status = curl_getinfo($ch,CURLINFO_HTTP_CODE);

        
        if ( $status !== 201 && $status !== 200 ) { 
            return  ("Error: call to URL $url failed with status $status, response $result, curl_error " . curl_error($ch) . ", curl_errno " . curl_errno($ch));
        }
        curl_close($ch);
        return json_decode($result);

    } catch (\Throwable $th) {
        echo $th;
        return false;
    }

}



}

?>