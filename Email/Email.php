<?php

$base = dirname(dirname(__FILE__));

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// require "../Librerias/PHPMailer/src/Exception.php";
// require "../Librerias/PHPMailer/src/PHPMailer.php";
// require "../Librerias/PHPMailer/src/SMTP.php";
// require "../HTML/FormatoHTMLADempiere.php";

require $base . '/Librerias/PHPMailer/src/Exception.php';
require $base . '/Librerias/PHPMailer/src/PHPMailer.php';
require $base . '/Librerias/PHPMailer/src/SMTP.php';
require $base . '/HTML/FormatoHTMLADempiere.php';
require $base . '/HTML/EnvioCorreo.php';

class Email{

    // private $vDomain = "mail.refividrio.com.mx";
    // private $vUser = "desarrollo@refividrio.com.mx";
    // // private $vPassword = "D3$@rr0ll0$#20"; 
    // private $vPassword = "[D3$@rr0ll0$22_R3F1V1DR10$22]"; 

    // private $vUser = "desarrollo@rfv-truck-parts-accessories.com.mx";
    // private $vPassword = "[D3$@rr0ll0$22_R3F1V1DR10$22]";
    // private $vPassword = "[D3$@rr0ll0&Pr0gr@m@c10n]$22";


    // private $vUser = "victor.rivera@rfv-truck-parts-accessories.com.mx";
    // private $vPassword = "d3,r+il8Y.V8";


    private $vUser = "notificaciones@rfv-truck-parts-accessories.com.mx";
    private $vPassword = "]lV=~_RV06%B";    
    private $vDomain = "mail.rfv-truck-parts-accessories.com.mx";    

    
    public function enviarInformeExistenciasCEvsZCS($vEncabezado,$vAsunto,$vDescripcion,$vArchivo,$vDestinatarios){
          
        // $Encabezado ="Envío Automático de Informes Refividrio DevTI";
        // $Asunto = "Reporte Comparación de Existencias Comercio Exterior vs Zona Centro Sur.";
        $Encabezado =$vEncabezado;
        $Asunto = $vAsunto;
        $Descripcion = $vDescripcion;


          $Mail = new PHPMailer();	 

          //$FormatoHMTL = new FormatoHTML();
          //$HTML = $FormatoHMTL->notificacionHTMLBloqueo($cliente,$orden,$monto);
            
            try {
                    // Ajustes del Servidor
                    //$Mail->SMTPDebug = 0; // Comenta esto antes de producción
                    $Mail->CharSet = 'UTF-8';
                    $Mail->isSMTP();
                    // $Mail->Host="mail.refividrio.com.mx";
                    // $Mail->SMTPAuth = true;
                    // $Mail->Username="desarrollo@refividrio.com.mx";
                    // $Mail->Password="D3$@rr0ll0$#20";
                    // $Mail->Password="[D3$@rr0ll0$22_R3F1V1DR10$22]";
                    $Mail->Host = $this->vDomain;
                    $Mail->SMTPAuth = true;
                    $Mail->Username = $this->vUser;
                    $Mail->Password = $this->vPassword;
                    $Mail->SMTPSecure = "ssl";
                    $Mail->Port = 465;
                
                    // Destinatario
                    $Mail->setFrom($this->vUser, $Encabezado);
                    //$Mail->addAddress('vvrh.victor.rivera@gmail.com','Vic');

                    // //Recorrer Array
                    foreach ($vDestinatarios as $valor) {       
                      $email = $valor["correo"];
                      $nombre = $valor["nombre"];
                      $Mail->AddAddress($email, $nombre);
                      //$Mail->addAddress($destinatarios);
        
                    }
        
                    // Mensaje
                    $Mail->isHTML(true);
                    $Mail->addAttachment($vArchivo);
        
                    $Mail->Subject = $Asunto;
                    // $Mail->Body = '<b>Buen Día</b>
                    // Se envío archivo adjunto de la comparación de existencias.
                    // Saludos..';

                    $Mail->Body = $Descripcion;
                    //$Mail ->MsgHTML($HTML);
                    //$Mail->send();

                    if($Mail->send()){
                        $mensaje = 'Se Envío El Mensaje por Correo';

                    }else{
                        $mensaje = $Mail->ErrorInfo;;
                    }

                    return $mensaje;
    
                } catch (Exception $e) {

                    $mensaje = $Mail->ErrorInfo;

                    return $mensaje;
                }

        }
        
        // public function enviarNotificacionRecogerPedido($_cliente,$_correo,$_orden,$_entrega,$_sucursal){
          
        //       $Encabezado ="Recoger tu pedido";
        //       $Asunto = "Ya puedes ir a recoger tu pedido.";
    
        //       $Mail = new PHPMailer();	 
    
        //       $FormatoHMTL = new FormatoHTML();
        //       $HTML = $FormatoHMTL->notificacionHTMLRecogerPedido($_cliente,$_orden,$_entrega,$_sucursal);
                
        //         try {
        //                 // Ajustes del Servidor
        //                 //$Mail->SMTPDebug = 0; // Comenta esto antes de producción
        //                 $Mail->CharSet = 'UTF-8';
        //                 $Mail->isSMTP();
        //                 $Mail->Host="mail.refividrio.com.mx";
        //                 $Mail->SMTPAuth = true;
        //                 $Mail->Username=$this->_email; 
        //                 $Mail->Password=$this->_password;
        //                 $Mail->SMTPSecure = "ssl";
        //                 $Mail->Port = 465;
                    
        //                 // Destinatario 
        //                 $Mail->setFrom($this->_email, $Encabezado);
        //                 $Mail->addAddress($_correo,$_cliente);
        //                 //$Mail->addAddress('vvrh.victor.rivera@gmail.com','Vic');
    
        //                 // //Recorrer array
        //                 // foreach ($destinatarios as $valor) {       
        //                 //   $email = $valor["email"];
        //                 //   $nombre = $valor["nombre"];
        
        //                 //   $Mail->AddAddress($email, $nombre);
        //                 //   //$Mail->addAddress($destinatarios);
            
        //                 // }
            
        //                 // Mensaje
        //                 $Mail->isHTML(true);
        //                 //$Mail->addAttachment($archivo);
            
        //                 $Mail->Subject = $Asunto;
        
        //                 $Mail ->MsgHTML($HTML);
            
        //                 //$Mail->send();
                    
        //                 if($Mail->send()){
        //                     $mensaje = 'Se Envío El Mensaje por Correo';
    
        //                 }else{
        //                     $mensaje = $Mail->ErrorInfo;;
        //                 }
        
        //                 return $mensaje;


        //             } catch (Exception $e) {
        //                 //echo "Algo salio mal al intentar enviar: {$Mail->ErrorInfo}";
        //                 $mensaje = $Mail->ErrorInfo;

        //                 return $mensaje;
        //             }
    
        // }

        public function enviarCorreo($Encabezado,$Asunto,$Cuerpo,$Usuario,$Correo,$RutaImagen){

            $Mail = new PHPMailer();	 
            $FormatoHMTL = new PlantillaHtmlEnvio();
            $HTML = $FormatoHMTL->correoHTMLenvio($Asunto,$Cuerpo,$RutaImagen);
                
            try {
                $Mail->CharSet = 'UTF-8';
                $Mail->isSMTP();
                $Mail->Host = $this->vDomain;
                $Mail->SMTPAuth = true;
                $Mail->Username = $this->vUser;
                $Mail->Password = $this->vPassword;
                $Mail->SMTPSecure = "ssl";
                $Mail->Port = 465;
                    

                // Destinatario 
                $Mail->setFrom($this->vUser, $Encabezado);
                $Mail->addAddress($Correo,$Usuario);
            
                // Mensaje
                $Mail->isHTML(true);
                $Mail->Subject = $Asunto;
                $Mail ->MsgHTML($HTML);
            
                if($Mail->send()){
                    $mensaje = 'Correo Enviado';
                    echo'Correo Enviado';
    
                }else{
                    echo 'Error';
                    echo $mensaje = $Mail->ErrorInfo;
                }
                return $mensaje;

            } catch (Exception $e) {
                $mensaje = $Mail->ErrorInfo;
                return $mensaje;
             }
        }


        public function enviarCorreoFelizCumple($vEmpleado,$vCorreo,$vFechaNacimiento){

            $Encabezado ="Grupo Refividrio Felicita a Sus Colaboradores";
            $Asunto = "Att:Grupo Refividrio";
            // ¡Feliz cumpleaños " . $vEmpleado ."!";

            $Mensaje  = "¡Feliz cumpleaños " . $vEmpleado ."!";
            // $Mensaje  = "Buen día " . $vEmpleado ."
            // <br>
            // En Refividrio®️ agradecemos que formes parte de nuestro equipo de trabajo, y como un pequeño detalle por tu cumpleaños (que fue en enero o febrero), compartimos contigo el siguiente cupón de descuento. Tienes todo el mes de marzo para hacerlo válido.
            // ¡Ten un excelente día!";


            $Mail = new PHPMailer();	 
            $FormatoHMTL = new PlantillaHtmlEnvio();
            $HTML = $FormatoHMTL->notificacionFelizCumple($Mensaje);
                
            try {
                $Mail->CharSet = 'UTF-8';
                $Mail->isSMTP();
                $Mail->Host = $this->vDomain;
                $Mail->SMTPAuth = true;
                $Mail->Username = $this->vUser;
                $Mail->Password = $this->vPassword;
                $Mail->SMTPSecure = "ssl";
                $Mail->Port = 465;
                    
                // Destinatario 
                $Mail->setFrom($this->vUser, $Encabezado);
                $Mail->addAddress($vCorreo, $vEmpleado);
                // $Mail->addAddress('vvrh.victor.rivera@gmail.com','Vic');

                // Mensaje
                $Mail->isHTML(true);
                $Mail->Subject = $Asunto;
                $Mail->MsgHTML($HTML);
            
                if($Mail->send()){
                   
                    echo 'Correo Enviado';
                    $mensaje = 'Correo Enviado';
    
                }else{
                    echo 'Error ' . $Mail->ErrorInfo;
                    $mensaje = $Mail->ErrorInfo;
                }

                return $mensaje;

            } catch (Exception $e) {
                $mensaje = $Mail->ErrorInfo;
                return $mensaje;
             }
        }

        public function CorreoNotificacionIncidencias($Cuerpo, $Asunto, $vCorreo, $vEmpleado){
            $Encabezado = 'Notificación de Incidencias.';
            $Mail = new PHPMailer();	 
            $FormatoHMTL = new PlantillaHtmlEnvio();
            $HTML = $FormatoHMTL->notificacionIncidencias($Cuerpo);
                
            try {
                $Mail->CharSet = 'UTF-8';
                $Mail->isSMTP();
                $Mail->Host = $this->vDomain;
                $Mail->SMTPAuth = true;
                $Mail->Username = $this->vUser;
                $Mail->Password = $this->vPassword;
                $Mail->SMTPSecure = "ssl";
                $Mail->Port = 465;
                    

                // Destinatario 
                $Mail->setFrom($this->vUser, $Encabezado);
                $Mail->addAddress($vCorreo,$vEmpleado);
            
                // Mensaje
                $Mail->isHTML(true);
                $Mail->Subject = $Asunto;
                $Mail ->MsgHTML($HTML);
            
                if($Mail->send()){
                    $mensaje = 'Correo Enviado';
                    
    
                }else{
                    $mensaje = $Mail->ErrorInfo;
                }
                return $mensaje;

            } catch (Exception $e) {
                $mensaje = $Mail->ErrorInfo;
                return $mensaje;
             }
        }

}

 //$correo = new Email();
 //$correo->enviarNotificacionDistribuidor("VICTOR");

?>
