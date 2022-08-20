<?php

$base = dirname(dirname(__FILE__));

include_once $base . '/DB/ConexionADempiere_SUP.php';

class OrdenVentaADempiereSUP extends ConexionADempiereSUP
{

    public function actualizaCampoLineaOrdenVenta()
	{
        try {

            $query = "UPDATE adempiere.C_OrderLine SET Link_OrderLine_ID = null WHERE Link_OrderLine_ID IS NOT NULL";
            $stmt = ConexionADempiereSUP::abrirConexion()->prepare($query);
            
    
            if($stmt->execute()){
                return true;
     
            }else{
                return false;
     
            }


        }catch(Exception $exc){

            return $exc;

        }

        ConexionADempiereSUP::cerrarConexion();
	}



}

?>