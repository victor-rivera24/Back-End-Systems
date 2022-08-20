<?php 
setlocale(LC_MONETARY, 'es_MX');

class FormatoHTML{
	 	
    private $_empresa = "RFV TRUCK PARTS AND ACCESSORIES SA DE CV";
    private $_direccion = "Carretera Federal México Pachuca KM 30, Col. La Esmeralda, 55765 Tecámac, Estado de México, México";
    private $_contacto = "¿Dudas? Contáctanos a través de WhatsApp 55-5175-7108 o al correo servicio.distribuidor@refividrio.com.mx";

	public function notificacionHTMLBloqueo($cliente,$orden,$monto){

		$deuda = number_format($monto,2,".",",");

		$mensajeHTML ='
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
			
						<div class="card mb-3">
							<div class="card-body" style="text-align:center">
		
									<div class="d-flex justify-content-center">
											<img src="https://dev.refividrio.com.mx/complemento/ecommerce/LogoRF.jpg" width="300" height="100"> 		
									</div>
									<div class="d-flex justify-content-center">
											<img src="https://dev.refividrio.com.mx/complemento/ecommerce/Bloqueo.jpeg" width="600" height="500"> 
									</div>
		
		
							</div>
						</div>
			
						<div class="card" style="text-align:center">
							<br>
							<div class="card-header">
												<p>Estimado: <strong>'.$cliente.'</strong><p> 
												<p>¿Cómo estás? Espero que muy bien.</p>
												<p>
												Te escribo porque no se ha recibido el pago de pedido '.$orden.'  e importe $'.$deuda.'.</p>
		
												<p>Te agradezco si puedes efectuar el pago lo antes posible.</p>
		
												<p>Un cordial saludo.</p>
												<p></p>
												<br><br>

							</div>
		
							<div class="card-body" style="text-align:center">
								<div class="justify-content-center">
									<p>Titular de la cuenta: <strong>RFV TRUCK PARTS AND ACCESSORIES SA DE CV</strong><p> 
									<p>Detalles de la cuenta: <strong>No. Cuenta: 0116523536</strong><p>
									<p>No. Cuenta CLABE: <strong>012180001165235368</strong></p>
									<p>Dirección del banco: <strong>Bancomer</strong></p>
									<p>Importe: <strong>$'.$deuda.'</strong><p> 
		
									<p>El número de orden: <strong>'.$orden.'</strong> deberá aparecer en los detalles de la transferencia bancaria.</p>    
								</div>
								<br><br>

							</div>
		
							<div class="card-footer" style="text-align:center; font-weight: bold;">
											<div>
											Visita el ecommerce para <a href="https://aromatizantes.refividrio.com.mx/shop/Home">distribuidores</a>
											</div>
											<br>
											<div>
											'.$this->_contacto.'
											</div>
											<br>
											<div  style="text-align:center; color: #1E90FF;font-weight: bold;">
											<h5 class="d-flex justify-content-center"><strong>'.$this->_empresa.'</strong></h5>
											'.$this->_direccion.'
											</div>
		
							</div>
		
						</div>
			
					</div>
			</body>
		</html>					
				';

		return $mensajeHTML;
		
        }
        


		public function notificacionHTMLRecogerPedido($_cliente,$_orden,$_entrega,$_sucursal){
	
			$mensajeHTML ='
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
				
							<div class="card mb-3">
								<div class="card-body" style="text-align:center">
		
										<div class="d-flex justify-content-center">
												<div class="col-md-auto">
												<img src="https://dev.refividrio.com.mx/complemento/ecommerce/LogoRF.jpg" width="300" height="100"> 
												</div>
										</div>	
								</div>
							</div>
				
							<div class="card" style="text-align:center">

								<div class="card-header">
									<p>Distribuidor: <strong>'.$_cliente.'</strong><p> 
								</div>

								<div class="card-body" >
									<div>
										<p>El pedido <strong>'. $_orden .'</strong> con número de entrega <strong> ' .$_entrega. '</strong>, ya se encuentra disponible en sucursal.<p>
										<p> '.$_sucursal.' </p>
	
									</div>
								</div>

								<div class="card-footer" style="text-align:center; font-weight: bold;">
									<div>
									Visita el ecommerce para <a href="https://aromatizantes.refividrio.com.mx/shop/Home">distribuidores</a>
									</div>
									<br>
									<div>
									'.$this->_contacto.'
									</div>
									<br>
									<div  style="text-align:center; color: #1E90FF;font-weight: bold;">
									<h5 class="d-flex justify-content-center"><strong>'.$this->_empresa.'</strong></h5>

									'.$this->_direccion.'

									</div>


								</div>

							</div>
				
						</div>
				</body>
			</html>								
					';
	
			return $mensajeHTML;
			
			}


			public function notificacionHTMLMasivo($vDistribuidor){
	
				$mensajeHTML ='
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
					
								<div class="card mb-3">
									<div class="card-body" style="text-align:center">
			
											<div class="d-flex justify-content-center">
													<div class="col-md-auto">
													<img src="https://refividrio.com.mx/EcommerceDistribuidor/Generales/LogoRF.jpg" width="300" height="100"> 
													</div>
											</div>	
									</div>
								</div>
					
								<div class="card" style="text-align:center">
	
									<div class="card-header">
										<p>Distribuidor: <strong>'.$vDistribuidor.'</strong><p> 
									</div>
	
									<div class="card-body" >
										<div>
													<img src="https://refividrio.com.mx/EcommerceDistribuidor/Cursos/Capacitacionesv2.png" width="900" height="600"> 
		
										</div>
	
									</div>
	
									<div class="card-footer" style="text-align:center; font-weight: bold;">
										<div>
										Visita el ecommerce para <a href="https://aromatizantes.refividrio.com.mx/shop/Home">distribuidores</a>
										</div>
										<br>
										<div>
										'.$this->_contacto.'
										</div>
										<br>
										<div  style="text-align:center; color: #1E90FF;font-weight: bold;">
										<h5 class="d-flex justify-content-center"><strong>'.$this->_empresa.'</strong></h5>
										'.$this->_direccion.'
										</div>
	
	
									</div>
	
								</div>
					
							</div>
					</body>
				</html>							
						';
		
				return $mensajeHTML;
				
				}


				public function notificacionHTMLMasivov2($vDistribuidor){
	
					$mensajeHTML ='
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
						
									<div class="card mb-3">
										<div class="card-body" style="text-align:center">
				
												<div class="d-flex justify-content-center">
														<div class="col-md-auto">
														<img src="https://dev.refividrio.com.mx/complemento/ecommerce/LogoRF.jpg" width="300" height="100"> 
														</div>
												</div>	
										</div>
									</div>
						
									<div class="card">
		
										<div class="card-header"  style="text-align:center">
											<p>Estimado Distribuidor:<p><strong>'.$vDistribuidor.'</strong>
										</div>
		
										<div class="card-body"  style="text-align:center">
											<div>
												<p>REFIVIDRIO le invita a la reunión de Zoom programada.</p>
												<br>
												<p>Tema: <strong>CAPACITACIÓN SENSAODOR</strong></p>		
												<p>Hora: <strong>29 jul. 2021 11:00 a. m.</strong> Ciudad de México</p>		
											</div>
											<br>
	
											<div>
												<p>Para unirse a la reunión Zoom acceda al siguiente link:</p>		
												<p><a href="https://us02web.zoom.us/j/85411299749?pwd=RXZFS1lZTDdvN0hXS29TdHRsWGZadz09">Reunión vía Zoom</a></p>		
												<br>
	
												<p>Introduzca los siguientes datos:<p>
												<p><strong>ID de reunión: 854 1129 9749</strong></p>		
												<p><strong>Código de acceso: 024890</strong></p>		
			
											</div>
										</div>
		
										<div class="card-footer" style="text-align:center; font-weight: bold;">
											<div>
											Visita el ecommerce para <a href="https://aromatizantes.refividrio.com.mx/shop/Home">distribuidores</a>
											</div>
											<br>
											<div>
											'.$this->_contacto.'
											</div>
											<br>
											<div  style="text-align:center; color: #1E90FF;font-weight: bold;">
											<h5 class="d-flex justify-content-center"><strong>'.$this->_empresa.'</strong></h5>
		
											'.$this->_direccion.'
		
											</div>
		
		
										</div>
		
									</div>
						
								</div>
						</body>
					</html>									
							';
			
					return $mensajeHTML;
					
					}
					
					
		


}

        //$enviarCorreo = new FormatoHTML();
        //$enviarCorreo->notificacionHTMLMasivo("VICTOR");