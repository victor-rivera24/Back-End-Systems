<?php 

class WhatsappBird{

    private $url = "https://conversations.messagebird.com/v1/send";
    private $channel = "0918cbb1-86b7-4d6f-9959-153c2dd907f5";  
    private $espacio_nombres = "6d9ed156_697a_43b6_a928_13253b13fcab";
    private $language = "es_MX";
    private $token = "TxdyQCnYEM3tz80aM0iYQSeP6";

    public function mensajeRecojerPedido($vCelular,$vMedia,$vMensaje)
    {

        $contacto = "+52".$vCelular;

        // $jsonobj = '
        // {
        //     "content": {
        //       "hsm": {
        //         "language": {
        //           "code": "'.$this->language.'"
        //         },
        //         "components": [
        //           {
        //             "type": "body",
        //             "parameters": [
        //               {
        //                 "type": "text",
        //                 "text": "'.$vMensaje.'"
        //               }
        //             ]
        //           }
        //         ],
        //         "namespace": "'.$this->espacio_nombres.'",
        //         "templateName": "amoresens_general_texto"
        //       }
        //     },
        //     "to": "'.$contacto.'",
        //     "type": "hsm",
        //     "from": "'.$this->channel.'"
        //   }
        // ';


        $jsonobj = '
        {
            "content": {
              "hsm": {
                "language": {
                  "code": "'.$this->language.'"
                  ,"policy": "deterministic",

                },
                "components": [
                  {
                    "type": "header",
                    "parameters": [
                      {
                        "type": "video",
                        "video": {"url": "'.$vMedia.'" }
                      }
          
                    ]
                  },
                  {
                    "type": "body",
                    "parameters": [
                      {
                        "type": "text",
                        "text": "'.$vMensaje.'"
                      }
                    ]
                  }
                ],
                "namespace": "'.$this->espacio_nombres.'",
                "templateName": "amoresens_mensaje_generalv2"
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

// $msg = new WhatsappBird();
// $msg->mensajeRecojerPedido('VICTOR','5576100176','ORDEN-5965','ENT-6555','VENTAS TIZAYUCA');

