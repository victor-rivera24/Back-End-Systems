<?php

class msgFaltas
{
	 	
	public function get_msg($mensaje,$mes,$periodo){  
		$tipos = "";
		if ($mes) {
			$tipos = "<p style='color:blue'>Los siguientes Colaboradores Cumplen con tres o más faltas en el mes Actual.</p>";
		}else{
			$tipos = "<p style='color:blue'>Los siguientes Colaboradores Cumplen con 5 o más faltas en los últimos 6 meses.</p>";
		}
        return  '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>Fatlas de Colaboradores.</title>
				<style type="text/css">
				body {margin: 0; padding: 0; min-width: 100%!important;}
				.content {width: 100%; max-width: 600px;}  
				</style>
			</head>
			<body   bgcolor="#f6f8f1" align="center" >
			<img src="https://surver.code-byte.com.mx/surver/img/logo.png" width="200px" />
			<h4>Periodo Consultado: '.$periodo.'</h4>
			<h1>Notificación de Faltas Refividrio</h1>
				'.$tipos.'
				'. $mensaje .'
			</body>
		</html>' ;
		}
}