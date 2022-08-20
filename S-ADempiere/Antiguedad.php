<?php

$base = dirname(dirname(__FILE__));

include_once $base . '/DB/ConexionBD.php';
include_once $base . '/Email/Email.php';
include_once $base . '/Whatsapp/WhatsappBird.php';
include_once $base . '/Dev/Dev_Log.php';

class Antiguedad extends ConexionDB
{

    public function antiguedadSaldos($vMovimiento,$vSolicitud,$vMedio)
	{
        $data = [];
        $vDistribuidor = null;
        $vRespuesta = null;

        $query = "

        SELECT
        *
        FROM(
        
        SELECT
       
           getColumnValue(i.AD_Client_ID,'AD_Client','Name') AS Compania
           ,getColumnValue(i.AD_Org_ID,'AD_Org','Name') AS Organizacion
           ,cb.Name AS SocioNegocio
           ,cb.So_CreditLimit AS CreditoSocio
           ,i.C_Invoice_ID
           ,i.DocumentNo AS Factura
           ,c.DocumentNo AS Orden
           ,i.DateInvoiced:: Date AS FechaFactura	
           ,i.GrandTotal AS TotalFactura
           ,mon.ISO_Code AS MonedaFac
           ,(SELECT EXTRACT (days FROM (now()::Date) - i.dateinvoiced) ) AS DiasGral
           ,i.dateinvoiced::date + COALESCE(d.netdays,0) AS FechaVencimiento
           ,COALESCE(tcl.netdays,0) AS DiasCliente --Cliente
           ,COALESCE(tpr.netdays,0) AS DiasProveedor --Proveedor 	
           ,us.AD_User_ID
           ,us.EMail AS Correo
           ,us.Phone2 AS Celular
               
           ,CASE
           WHEN i.IssoTrx = 'Y' THEN
               CASE
                     WHEN getColumnValue(i.C_DocType_ID, 'C_DocType', 'DocBaseType') IN ('ARI') THEN
       
                       i.GrandTotal
       
                     WHEN getColumnValue(i.C_DocType_ID, 'C_DocType', 'DocBaseType') IN ('ARC') THEN
       
                       i.GrandTotal * -1			   
               END					   
                              
           WHEN i.IssoTrx = 'N' THEN				   
                              
               CASE
                     WHEN getColumnValue(i.C_DocType_ID, 'C_DocType', 'DocBaseType') IN ('API') THEN
       
                       i.GrandTotal
       
                     WHEN getColumnValue(i.C_DocType_ID, 'C_DocType', 'DocBaseType') IN ('APC') THEN
       
                       i.GrandTotal * -1					   
       
               END					   
                              
            END AS Total
                 
            
       ,COALESCE(
       
           CASE
       
           WHEN i.IssoTrx = 'Y' THEN
                       
                           CASE
                               WHEN getColumnValue(i.C_DocType_ID, 'C_DocType', 'DocBaseType')='ARI' THEN
       
                                i.GrandTotal - 
                               SUM(CASE 
                                   WHEN i.C_Currency_ID <> nM.MonedaAsig THEN 
                                       RF_CurrencyGral(nM.FechaAsig,nM.MonedaAsig,i.C_Currency_ID,nM.MontosPagados)  
                                   ELSE 
                                       COALESCE(nM.MontosPagados,0) 
                               END)
       
                               WHEN getColumnValue(i.C_DocType_ID, 'C_DocType', 'DocBaseType')='ARC' THEN
       
                                            (i.GrandTotal *-1)
                                           - ( 
                                           SUM(CASE 
                                               WHEN i.C_Currency_ID <> nM.MonedaAsig THEN 
                                                   RF_CurrencyGral(nM.FechaAsig,nM.MonedaAsig,i.C_Currency_ID,nM.MontosPagados)  
                                               ELSE 
                                                   COALESCE(nM.MontosPagados,0) 
                                               END)	
                                               )						
                                
                           END																														
           END,0) AS Cobrar		
           
           
       -------------------------------------------------------------------------------- Periodo 4 ----------------------------------------------------------------------
       ,
       COALESCE(
       
       CASE WHEN -1 >= CASE 
                           WHEN (ni.DisCountDate::Date + esq.NetDays) IS NOT NULL THEN 
                                (ni.DisCountDate::Date + esq.NetDays) 
                           ELSE 
                               (i.dateinvoiced::date + COALESCE(d.netdays,0)) 
                        END - CURRENT_DATE::Date  
           THEN
       
           CASE 
               WHEN i.IssoTrx = 'Y' THEN
               
                               CASE
                                   WHEN getColumnValue(i.C_DocType_ID, 'C_DocType', 'DocBaseType')='ARI' THEN
       
                                       true											   
                                                          
       --                             WHEN getColumnValue(i.C_DocType_ID, 'C_DocType', 'DocBaseType')='ARC' THEN
       
       -- 	                            	(i.GrandTotal *-1)
       -- 									- ( 
       -- 									SUM(CASE 
       -- 										WHEN i.C_Currency_ID <> nM.MonedaAsig THEN 
       -- 											RF_CurrencyGral(nM.FechaAsig,nM.MonedaAsig,i.C_Currency_ID,nM.MontosPagados)  
       -- 										ELSE 
       -- 											COALESCE(nM.MontosPagados,0) 
       -- 										END)	
       -- 										)                            	
                                       
                               END
               END
                                                                                                                                                                               
       END
       
       ,false) AS BloquearSocio
            
                                                                                                       
       FROM C_Invoice AS i
           INNER JOIN C_Currency AS mon
               ON mon.C_Currency_ID = i.C_Currency_ID
           INNER JOIN C_BPartner AS cb
               ON cb.C_BPartner_ID = i.C_BPartner_ID
           INNER JOIN AD_User AS us
               ON us.C_BPartner_ID = cb.C_BPartner_ID	 
           LEFT JOIN C_PaymentTerm AS d 
               ON d.AD_Client_ID=i.AD_Client_ID 
               AND d.C_PaymentTerm_ID=i.C_PaymentTerm_ID
           LEFT JOIN C_PaymentTerm AS tcl
               ON 	tcl.C_PaymentTerm_ID = cb.C_PaymentTerm_ID
           LEFT JOIN C_PaymentTerm AS tpr
               ON 	tpr.C_PaymentTerm_ID = cb.PO_PaymentTerm_ID	
               
           LEFT JOIN C_InvoicePaySchedule AS ni
               ON ni.C_Invoice_ID = i.C_Invoice_ID
               AND ni.IsValid = 'Y'
               AND ni.Isactive = 'Y'	
           
           LEFT JOIN(
                    C_PaymentTerm AS esq 
                       INNER JOIN C_PaySchedule AS eq
                           ON eq.C_PaymentTerm_ID = esq.C_PaymentTerm_ID		
                    )
               ON ni.C_PaySchedule_ID = eq.C_PaySchedule_ID			   
                          
           LEFT JOIN LATERAL(
               
           SELECT
           
           al.C_Invoice_ID 
           ,ah.DateTrx::Date AS FechaAsig
           ,ah.C_Currency_ID AS MonedaAsig		
           ,SUM(al.amount) AS MontosPagados			
                                
       FROM C_AllocationLine AS al
             
       LEFT JOIN C_AllocationHdr AS ah
           ON al.C_AllocationHdr_ID=ah.C_AllocationHdr_ID
               
       WHERE	
       
           ah.DocStatus IN ('CO','CL')	
           AND al.Isactive = 'Y'
               
       GROUP BY al.C_AllocationHdr_ID
                ,al.C_Invoice_ID
                ,MonedaAsig
                ,FechaAsig
               
           ) AS nM
           
           ON i.C_Invoice_ID = nM.C_Invoice_ID
           
       
       LEFT JOIN C_Order AS c
           ON c.C_Order_ID = i.C_Order_ID	
       
       WHERE
       
           i.IsPaid='N'
       --AND NOT i.C_DocType_ID IN (1000531,1000528,1000614,1000637,1000638,1000710,1000714)								 
           AND i.AD_Client_ID=1000000
           AND i.AD_Org_ID=1000032
           AND i.IssoTrx = 'Y'
           AND i.docstatus in ('CO','CL')
           AND i.C_Currency_ID = 130
           AND cb.C_BP_Group_ID = 1000054
           --AND cb.C_BPartner_ID = (SELECT C_BPartner_ID FROM adempiere.AD_User WHERE AD_User_ID = idUsuario)
           AND getColumnValue(i.C_DocType_ID, 'C_DocType', 'DocBaseType')='ARI'
       
       GROUP BY 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,cb.name,esq.netdays,ni.discountdate			   
       
       ORDER BY MonedaFac
               ,i.AD_Org_ID DESC
               ,cb.name ASC
               ,BloquearSocio ASC
            
            ) AS nM
            
            WHERE nM.BloquearSocio = true      
                                        ";

		$stmt = ConexionDB::abrirConexion()->prepare($query);
        $stmt -> execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $vDistribuidor =  $row['socionegocio'];

            // $correo = new Email();
            // $correo->enviarNotificacionCorreoBloqueoAdmin($row['socionegocio'],$row['correo'],$row['celular'],$row['orden'],$row['cobrar']);
            // $vRespuesta = $correo->enviarNotificacionCorreoBloqueo($row['socionegocio'],$row['correo'],$row['celular'],$row['orden'],$row['cobrar']);

            if($vMedio == "Email"){

                $correo = new Email();
                $vRespuesta = $correo->enviarNotificacionCorreoBloqueo($row['socionegocio'], $row['correo'], $row['celular'],$row['orden'],$row['cobrar']);
                $correo->enviarNotificacionCorreoBloqueoAdmin($row['socionegocio'], $row['correo'], $row['celular'],$row['orden'],$row['cobrar']);
    

            }elseif ($vMedio == "WhatsApp"){

                $w = new WhatsappBird();
                $vRespuesta = $w->mensajePagoPendiente($row['socionegocio'], $row['celular'],$row['orden'],$row['cobrar']);

            }

            $data[] = [
                'solicitud' => $vSolicitud,
                'razonsocial' => $vDistribuidor,
                'correo' => $row['correo'],
                'celular' => $row['celular'],
                'respuesta' => $vRespuesta ,
            ];


            $log = new Dev_Log();
            $log->agregarLog($vMovimiento,$vSolicitud,$vDistribuidor,json_encode($row),$vRespuesta,$vMedio);

        }

        var_dump ($data);

        return $data;


        ConexionDB::cerrarConexion();
	}



}

// $antiguedad = new Antiguedad();
// $antiguedad->antiguedadSaldos('ADempiere','Antiguedad Saldos','Email');
// $antiguedad->antiguedadSaldos('ADempiere','Antiguedad Saldos','WhatsApp');





?>