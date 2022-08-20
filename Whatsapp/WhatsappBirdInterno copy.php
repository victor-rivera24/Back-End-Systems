<?php 

class WhatsappBirdInternoDemo{

    private $url = "https://conversations.messagebird.com/v1/send";
    private $channel = "3bc3cd4a-8d9c-4278-b90b-e16f713f3b23";  // CANAL DE WHATSAPPS
    private $espacio_nombres = "6d9ed156_697a_43b6_a928_13253b13fcab";
    private $language = "es_MX"; //IDIOMA DE PLANTILLA WHATSAPPS
    private $token = "qmdRu7pd4nEoIA0HP7nmosdne";
    // private $token = "TxdyQCnYEM3tz80aM0iYQSeP6";
    private $urlMedia = "https://apps.refividrio.com.mx/resources/amoresens/CUPON_DE_REGALO.png";

    public function asdasdasdasd()
    {

        // $contacto = "+52".$vCelular;
        $contacto = "+525576100176";

        // $vMensaje = "*¡Feliz cumpleaños ".$vEmpleado." !* 🎂🎉🎊";
        // $vMensaje = "*".$vEmpleado."* En Refividrio®️ agradecemos que formes parte de nuestro equipo de trabajo, y como un pequeño detalle por tu cumpleaños (que fue en enero o febrero), compartimos contigo el siguiente cupón de descuento. Tienes todo el mes de marzo para hacerlo válido. ¡Ten un excelente día!";
        

        $jsonobj = '
        {
            "content": {
              "hsm": {
                "language": {
                  "code": "'.$this->language.'"
                  ,"policy": "deterministic"

                },
                "components": [
                  {
                    "type": "body",
                    "parameters": [
                      {
                        "type": "text",
                        "text": "sadasdasdasdasd"
                      }
                    ]
                  }
                ],
                "namespace": "'.$this->espacio_nombres.'",
                "templateName": "rfv_marketing"
              }
            },
            "to": "'.$contacto.'",
            "type": "hsm",
            "from": "'.$this->channel.'"
          }
        ';

        echo "<br>";
        print_r($jsonobj);

        
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonobj);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: AccessKey '. $this->token.'','Content-Type: application/json; charset=utf-8'));
        $result = curl_exec($ch);
        curl_close($ch);

        print_r ($result);

        return $result;

    }
                
}

$msg = new WhatsappBirdInternoDemo();
$msg->asdasdasdasd();

