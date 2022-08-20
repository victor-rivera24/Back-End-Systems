<?php
include("../DB/ConexionBD.php");
include_once('../Aromatizantes/AromasLD.php');
include_once('../Aromatizantes/AromasDF.php');
include_once('../Aromatizantes/AmorEsens.php');


header('Content-Type: text/html; charset=UTF-8');
ini_set('max_execution_time', 6000000000); //600 seconds = 10 minutes

class Producto extends ConexionDB
{

    public function productosDescripcionLD()
	{

        $query = "

        SELECT 
        Value AS Producto
        ,Elements AS DescripcionGeneral
        ,AdditionalInformation AS InformacionExtra
        ,TechnicalCharacteristics AS Caracteristicas
        ,UseMode AS ModoUso
        FROM M_Product 
        WHERE
        AD_Client_ID = 1000000
        AND Isactive = 'Y'
        AND Value LIKE 'P15%'
        AND Name NOT LIKE '%ANDALUCIA%'     
                                        ";

		$stmt = ConexionDB::abrirConexion()->prepare($query);
        $stmt -> execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo $row['producto']." ";
            echo " ". $row['descripciongeneral']." ";
            echo " ". $row['informacionextra']." ";
            echo " ". $row['caracteristicas']." ";
            echo " ". $row['modouso']."<br>";
            $MySQL = new AromasLD();
            $MySQL->actualizarDescripcionesLD("AromasLD",$row['producto'],$row['informacionextra'],$row['caracteristicas'],$row['modouso']);
        }

        ConexionDB::cerrarConexion();
	}

    public function productosDescripcionDF()
	{

        $query = "

        SELECT 
        Value AS Producto
        ,Elements AS DescripcionGeneral
        ,AdditionalInformation AS InformacionExtra
        ,TechnicalCharacteristics AS Caracteristicas
        ,UseMode AS ModoUso
        FROM M_Product 
        WHERE
        AD_Client_ID = 1000000
        AND Isactive = 'Y'
        AND Value LIKE 'P15%'
        AND Name LIKE '%ANDALUCIA%'     
                                        ";

		$stmt = ConexionDB::abrirConexion()->prepare($query);
        $stmt -> execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo $row['producto']." ";
            echo " ". $row['descripciongeneral']." ";
            echo " ". $row['informacionextra']." ";
            echo " ". $row['caracteristicas']." ";
            echo " ". $row['modouso']."<br>";
            $MySQL = new AromasDF();
            $MySQL->actualizarDescripcionesDF("AromasDF",$row['producto'],$row['informacionextra'],$row['caracteristicas'],$row['modouso']);
        }

        ConexionDB::cerrarConexion();
	}

    public function marcasLDProductos()
	{
        $query = "
                    SELECT 
                        mr.Name AS Marca
                    FROM M_Product AS mp
                        INNER JOIN M_Product_Group AS mr
                            ON mr.M_Product_Group_ID = mp.M_Product_Group_ID 
                    WHERE
                        mp.AD_Client_ID = 1000000
                        AND mp.Isactive = 'Y'
                        AND mp.Value LIKE 'P15%'
                        AND mp.Name NOT LIKE '%ANDALUCIA%' 
                    GROUP BY 1
                    ";

		$stmt = ConexionDB::abrirConexion()->prepare($query);
        $stmt -> execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo $row['producto']." ";
            echo " ". $row['descripciongeneral']." ";
            echo " ". $row['informacionextra']." ";
            echo " ". $row['caracteristicas']." ";
            echo " ". $row['modouso']."<br>";
            $MySQL = new AromasLD();
            $MySQL->actualizarMarcaLD("AromasLD",$row['marca']);
        }

        ConexionDB::cerrarConexion();
	}


    public function productosGeneral($vMovimiento)
	{
        $query = "
                SELECT

                mp.Value AS codigo
                ,mp.Name AS descripcion
                ,mp.Isactive AS activo
                ,GetColumnValue(mp.M_Product_Group_ID,'M_Product_Group','Name') AS Marca
                ,GetColumnValue(mp.M_Class_Intensity_ID,'M_Class_Intensity','Name') AS Intensidad
                ,GetColumnValue(mp.M_Class_Essences_ID,'M_Class_Essences','Name') AS Producto
				,mp.additionalinformation AS productoAdiccional
				,mp.technicalcharacteristics AS productoCaracteristica
				,mp.usemode AS ProductoUso

                FROM M_Product AS mp
                WHERE
                    mp.AD_Client_ID = 1000000
                    AND mp.Value LIKE 'P15%'
                    AND NOT mp.Value IN ('P15UN0978','P15UN0979','P15UN0980','P15UN0981','P15UN0982')
                    AND NOT (mp.additionalinformation IS NULL OR mp.technicalcharacteristics IS NULL OR mp.usemode IS NULL )

                    
                ORDER BY mp.Value
                --LIMIT 5
                    ";

		$stmt = ConexionDB::abrirConexion()->prepare($query);
        $stmt -> execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo $row['codigo']." ";
            echo " ". $row['descripcion']." ";
            echo " ". $row['marca']." ";
            echo " ". $row['intensidad']." ";
            echo "<br>";
            //echo " ". $row['modouso']."<br>";



            if($vMovimiento == "Marca"){

                $MySQL = new AmorEsens();
                $MySQL->insertarProductoCategoriaMarca("AmorEsens",$row['codigo'],$row['marca']);
    

            }elseif ($vMovimiento == "Intensidad"){

                $MySQL = new AmorEsens();
                $MySQL->insertarProductoCategoriaIntensidad("AmorEsens",$row['codigo'],$row['intensidad']);

            }elseif ($vMovimiento == "DescripcionTecnica"){

                $MySQL = new AmorEsens();
                $MySQL->insertarProductoTabs("AmorEsens",$row['codigo'],1,$row['productocaracteristica']);

            }elseif ($vMovimiento == "DescripcionAdiccional"){

                $MySQL = new AmorEsens();
                $MySQL->insertarProductoTabs("AmorEsens",$row['codigo'],2,$row['productoadiccional']);

            }elseif ($vMovimiento == "DescripcionUso"){

                $MySQL = new AmorEsens();
                $MySQL->insertarProductoTabs("AmorEsens",$row['codigo'],3,$row['productouso']);

            }


        }

        ConexionDB::cerrarConexion();
	}

    public function productosConDescuentos(){

        $query = "SELECT * FROM adempiere.ztemp ORDER BY producto ASC";

		$stmt = ConexionDB::abrirConexion()->prepare($query);
        $stmt -> execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo $row['producto']." ";
            //echo " ". $row['descripcion']." ";
            echo " ". $row['descuento']." ";
            echo " ". $row['descuento_real']."<br>";
            $MySQL = new AmorEsens();
            $MySQL->actualizarPrecioConDescuento("AmorEsens",$row['producto'],$row['descuento'],$row['descuento_real']);
        }

        ConexionDB::cerrarConexion();
	}



}

$productos = new Producto();
$productos->productosConDescuentos();

//$productos->productosGeneral('Intensidad');
//$productos->productosGeneral('Producto');
//$productos->productosGeneral('DescripcionUso');
//$productos->productosGeneral('DescripcionAdiccional');
//$productos->productosGeneral('DescripcionUso');





?>