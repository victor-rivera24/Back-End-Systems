<?php
class PlantillaHtmlEnvio {


    public function correoHTMLenvio($Asunto,$Cuerpo,$RutaImagen){
        //                                <img src="https://amoresens.com.mx/publicidad/imagen/'.$RutaImagen.'" width="800" height="250">
        $html ='

        <html lang="es">
        <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title>Grupo Refividrio</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="robots" content="noindex">
        <meta name="googlebot" content="noindex">

        <!-- CSS only -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

        <!-- JS, Popper.js, and jQuery -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

        </head>
        <body>
            <br>
            <div class="container">
            
                <div class="card" style="text-align:center">
                    <div class="card-header">
                        <p><h1><strong>'.$Asunto.'</strong></h1><p> 
                    </div>

                    <div class="card-body" >
                        <div>
                            <p><h3>'. $Cuerpo .'</h3></p><br>
                            <center>
                                <img src="'.$RutaImagen.'" width="900" height="700">
                            </center>
                        </div>
                    </div>
                </div>

            </div>
        </body>
        </html>
        ';

        return $html;
    }


    public function notificacionFelizCumple($vMensaje){

        $mensajeHTML =
        '
        <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
        <head>
            <meta charset="utf-8">  
        <style> 
        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
            background: #f1f1f1;
        } 
        .primary{
            background: #f3a333;
        } 
        .bg_white{
            background: #ffffff;
        }
        .bg_light{
            background: #fafafa;
        }
        .bg_black{
            background: #000000;
        }
        .bg_dark{
            background: rgba(0,0,0,.8);
        }
        .email-section{
            padding:2.5em;
        } 
        .btn{
            padding: 10px 15px;
        }
        .btn.btn-primary{
            border-radius: 30px;
            background: #f3a333;
            color: #ffffff;
        } 
        h1,h2,h3,h4,h5,h6{
            font-family: "Playfair Display", serif;
            color: #000000;
            margin-top: 0;
        } 
        body{
            font-family: "Montserrat", sans-serif;
            font-weight: 400;
            font-size: 15px;
            line-height: 1.8;
            color: rgba(0,0,0,.4);
        } 
        a{
            color: #f3a333;
        }  
        .logo h1{
            margin: 0;
        }
        .logo h1 a{
            color: #000;
            font-size: 20px;
            font-weight: 700;
            text-transform: uppercase;
            font-family: "Montserrat", sans-serif;
        } 
        .hero{
            position: relative;
        } 
        .hero .text{
            color: rgba(255,255,255,.8);
        }
        .hero .text h2{
            color: #ffffff;
            font-size: 30px;
            margin-bottom: 0;
        } 
        .heading-section h2{
            color: #000000;
            font-size: 28px;
            margin-top: 0;
            line-height: 1.4;
        }
        .heading-section .subheading{
            margin-bottom: 20px !important;
            display: inline-block;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: rgba(0,0,0,.4);
            position: relative;
        }
        .heading-section .subheading::after{
            position: absolute;
            left: 0;
            right: 0;
            bottom: -10px;
            content: "";
            width: 100%;
            height: 2px;
            background: #f3a333;
            margin: 0 auto;
        } 
        .heading-section-white{
            color: rgba(255,255,255,.8);
        }
        .heading-section-white h2{
            font-size: 28px;
            font-family: 
            line-height: 1;
            padding-bottom: 0;
        }
        .heading-section-white h2{
            color: #ffffff;
        }
        .heading-section-white .subheading{
            margin-bottom: 0;
            display: inline-block;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: rgba(255,255,255,.4);
        } 
        .icon{
            text-align: center;
        }  
        .text-services{
            padding: 10px 10px 0; 
            text-align: center;
        }
        .text-services h3{
            font-size: 20px;
        } 
        .text-services .meta{
            text-transform: uppercase;
            font-size: 14px;
        } 
        .text-testimony .name{
            margin: 0;
        }
        .text-testimony .position{
            color: rgba(0,0,0,.3);

        }   
        .counter-text{
            text-align: center;
        }
        .counter-text .num{
            display: block;
            color: #ffffff;
            font-size: 34px;
            font-weight: 700;
        }
        .counter-text .name{
            display: block;
            color: rgba(255,255,255,.9);
            font-size: 13px;
        }  
        </style> 
        </head>
        <body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #222222;"> 
        <center style="width: 100%; background-color: #f1f1f1;">

            <div style="max-width: 800px; margin: 0 auto;" class="email-container"> 
            <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
                <tr>
                <td class="bg_white logo" style="text-align: center">
                    <h1><a href="">¡Feliz Cumpleaños!</a></h1>
                </td>
                </tr>
                
                <tr>
                <td class="bg_white logo" style="text-align: center">
                                    <img src="https://apps.refividrio.com.mx/resources/image/refividrio_logo.png" width="200px" />  
                </td>
                </tr>

                <tr>
                    <td class="bg_white">
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                            <td class="bg_dark email-section" style="text-align:center;">
                                <div class="heading-section heading-section-white"><br/>
                                <!--<span class="subheading">¡Feliz Cumpleaños!</span>
                                    <h2>Titulo</h2> --> 
                                    <img src="https://apps.refividrio.com.mx/resources/image/CUPON_DE_REGALO.png" width="500px" />  
                                <p>Este correo es una notificación de Refividrio no es necesaria una respuesta.</p>
                                </div>
                            </td>
                        </tr> 
                        <tr>
                            <td class="bg_light email-section">
                                <div class="heading-section" style="text-align: center; padding: 0 30px;">
                                     
                                <h2>'. $vMensaje .'</h2>
                                </div> 
                            </td>
                        </tr><!-- end: tr --> 
                        </table> 
                    </td>
                    </tr><!-- end:tr -->
            <!-- 1 Column Text + Button : END -->
            </table> 
            </div>
        </center>
        </body>
        </html>    
        
        '							
        ;

            //     <div style="display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
            // &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
            // </div>            

        return $mensajeHTML;
        
        }


        public function notificacionIncidencias($vMensaje){

            $mensajeHTML =
            '
            <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
            <head>
                <meta charset="utf-8">  
            <style> 
            html,
            body {
                margin: 0 auto !important;
                padding: 0 !important;
                height: 100% !important;
                width: 100% !important;
                background: #f1f1f1;
            } 
            .primary{
                background: #f3a333;
            } 
            .bg_white{
                background: #ffffff;
            }
            .bg_light{
                background: #fafafa;
            }
            .bg_black{
                background: #000000;
            }
            .bg_dark{
                background: rgba(0,0,0,.8);
            }
            .email-section{
                padding:2.5em;
            } 
            .btn{
                padding: 10px 15px;
            }
            .btn.btn-primary{
                border-radius: 30px;
                background: #f3a333;
                color: #ffffff;
            } 
            h1,h2,h3,h4,h5,h6{
                font-family: "Playfair Display", serif;
                color: #000000;
                margin-top: 0;
            } 
            body{
                font-family: "Montserrat", sans-serif;
                font-weight: 400;
                font-size: 15px;
                line-height: 1.8;
                color: rgba(0,0,0,.4);
            } 
            a{
                color: #f3a333;
            }  
            .logo h1{
                margin: 0;
            }
            .logo h1 a{
                color: #000;
                font-size: 20px;
                font-weight: 700;
                text-transform: uppercase;
                font-family: "Montserrat", sans-serif;
            } 
            .hero{
                position: relative;
            } 
            .hero .text{
                color: rgba(255,255,255,.8);
            }
            .hero .text h2{
                color: #ffffff;
                font-size: 30px;
                margin-bottom: 0;
            } 
            .heading-section h2{
                color: #000000;
                font-size: 28px;
                margin-top: 0;
                line-height: 1.4;
            }
            .heading-section .subheading{
                margin-bottom: 20px !important;
                display: inline-block;
                font-size: 13px;
                text-transform: uppercase;
                letter-spacing: 2px;
                color: rgba(0,0,0,.4);
                position: relative;
            }
            .heading-section .subheading::after{
                position: absolute;
                left: 0;
                right: 0;
                bottom: -10px;
                content: "";
                width: 100%;
                height: 2px;
                background: #f3a333;
                margin: 0 auto;
            } 
            .heading-section-white{
                color: rgba(255,255,255,.8);
            }
            .heading-section-white h2{
                font-size: 28px;
                font-family: 
                line-height: 1;
                padding-bottom: 0;
            }
            .heading-section-white h2{
                color: #ffffff;
            }
            .heading-section-white .subheading{
                margin-bottom: 0;
                display: inline-block;
                font-size: 13px;
                text-transform: uppercase;
                letter-spacing: 2px;
                color: rgba(255,255,255,.4);
            } 
            .icon{
                text-align: center;
            }  
            .text-services{
                padding: 10px 10px 0; 
                text-align: center;
            }
            .text-services h3{
                font-size: 20px;
            } 
            .text-services .meta{
                text-transform: uppercase;
                font-size: 14px;
            } 
            .text-testimony .name{
                margin: 0;
            }
            .text-testimony .position{
                color: rgba(0,0,0,.3);
    
            }   
            .counter-text{
                text-align: center;
            }
            .counter-text .num{
                display: block;
                color: #ffffff;
                font-size: 34px;
                font-weight: 700;
            }
            .counter-text .name{
                display: block;
                color: rgba(255,255,255,.9);
                font-size: 13px;
            }  
            </style> 
            </head>
            <body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #222222;"> 
            <center style="width: 100%; background-color: #f1f1f1;">
    
                <div style="max-width: 800px; margin: 0 auto;" class="email-container"> 
                <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
                    <tr>
                    <td class="bg_white logo" style="text-align: center">
                        <h1><a href="">Notificación de Incidencias</a></h1>
                    </td>
                    </tr>
        
                    <tr>
                        <td class="bg_white">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                           
                            <tr>
                                <td class="bg_light email-section">
                                    <div class="heading-section" style="text-align: center; padding: 0 30px;">
                                         
                                    <h2>'. $vMensaje .'</h2>
                                    </div> 
                                </td>
                            </tr><!-- end: tr --> 
                            </table> 
                        </td>
                        </tr><!-- end:tr -->
                <!-- 1 Column Text + Button : END -->
                </table> 
                </div>
            </center>
            </body>
            </html>    
            
            '							
            ;
    
                //     <div style="display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
                // &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
                // </div>            
    
            return $mensajeHTML;
            
            }
}
