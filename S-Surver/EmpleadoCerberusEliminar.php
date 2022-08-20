<<?php

// $base = dirname(dirname(__FILE__));
// include_once $base . '/DB/ConexionCerberus.php';
// include_once $base . '/S-Surver/EmpleadoSurver.php';
// include_once $base . '/S-ADempiere/EmpleadoADempiere_RFV.php';


// class EmpleadoCerberusEliminar extends ConexionCerberus{

// 	public function SincronizadoCheckCerberus($idEmpleadoCerberus)
// 	{
//          try {
//             $actualizar = "UPDATE Empleado SET 
//                 actualizado = CURRENT_TIMESTAMP
//                 , sincronizado_surver = 1
//                 WHERE idEmpleado = $idEmpleadoCerberus ";
//             $stmt = ConexionCerberus::abrirConexion()->prepare($actualizar);

//             $r = $stmt->execute();
//             if($r){
//                 return true;

//             }else{
//                 return false;

//             }

//         } catch (Exception $exc) {
//             return $exc;
//         }
//         ConexionCerberus::cerrarConexion();
// 	}



//     public function actualizarPuestoCerberus($idEmpleado)
// 	{
//          try {
//             $actualizar = "UPDATE CambiosSurver SET 
//                 fechaAplicacion = CURRENT_TIMESTAMP
//                 , sincronizado = 1
//                 WHERE idEmpleado = $idEmpleado ";
//             $stmt = ConexionCerberus::abrirConexion()->prepare($actualizar);

//             $r = $stmt->execute();
//             if($r){
//                 return true;

//             }else{
//                 return false;

//             }

//         } catch (Exception $exc) {
//             return $exc;
//         }
//         ConexionCerberus::cerrarConexion();
// 	}


// }



?>