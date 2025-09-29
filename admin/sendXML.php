<?php
require_once './class/vendor/autoload.php';
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Document;
use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;
use Greenter\Ws\Services\SunatEndpoints;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
function sendXMLSUNAT($id_rvc)
{
  try 
	{
		vard($id_rvc,"Variable id_rvc, ya dentro de TRY en la funcion SendXMLSUNAT");
		$id_rvc=(int) $id_rvc;
    require_once './class/GLibfunciones.php';
    $response_json=array('success'=>false, 'num_rows'=>-1, 'items'=>-1, 'datos'=>array(), 'message'=>"Vaya!! estas intentando algo inusual en el sistema", 'codigo_cdr'=>FALSE, 'respuesta_cdr'=>'', 'ticket'=>FALSE, 'archivo'=>'sendXML.php');
    $conn=new GConector();
	 //Añade fecha actual con formato de America/Lima
	 date_default_timezone_set("America/Lima");
		//Cabecera de comprobante
    $sql_comprobante="SELECT 
		rvc.id_cli, rvc.codcpg_rvi, cli.id_tipdoc, tdi.cod_tipdoc, tdi.desc_tipdoc, tdi.abrev_tipdoc, cli.dni_ruc_cli, cli.nom_rzs_cli, ub.cod_ubi, 
		ub.regi_ubi, ub.prov_ubi, IFNULL(ub.dist_ubi, cli.lugar_cli) AS distrito_cli, cli.direcc_cli, cli.tlfcel_cli, cli.email_cli, rvc.id_tipcmp, 
		tcomp.cod_tipcmp, tcomp.desc_tipcmp, CONCAT(IF(tcomp.cod_tipcmp='01', 'F', 'B'), LPAD(rvc.seriecp_rvi,3,'0')) AS seriecp_rvi, 
		LPAD(rvc.numcp_rvi, 8,'0') AS numcp_rvi, rvc.fechaemi_rvi, rvc.horaemi_rvi, 'PEN' AS tipo_moneda, 
		IF(rvc.baseimpopgrv_rvi=0.00, calcular_subtotal(rvc.importetot_rvi, 18.00, '0'), rvc.baseimpopgrv_rvi ) AS baseimpopgrv_rvi, 
		rvc.igv_rvi, rvc.importetot_rvi 
		FROM regvtacaja AS rvc 
		LEFT OUTER JOIN clientes AS cli ON cli.id_cli=rvc.id_cli 
		LEFT OUTER JOIN tipodocident AS tdi ON tdi.id_tipdoc=cli.id_tipdoc 
		LEFT OUTER JOIN ubigeo AS ub ON ub.id_ubi=cli.id_ubi 
		INNER JOIN tipocomprob AS tcomp ON tcomp.id_tipcmp=rvc.id_tipcmp 
		WHERE rvc.id_rvc=?";
		if (!$stmt_compr=$conn->prepare($sql_comprobante)) throw new GException("Vaya! ocurrio un problema en el sistema.<br/>Consulte con el Soporte de sistemas", $conn->error, $conn->errno);
		vard($stmt_compr, "Variable stmt_compr, luego de if (!stmt_compr=conn->prepare(sql_comprobante))");
    if (!$stmt_compr->bind_param('i', $id_rvc)) throw new GException("Vaya! ocurrio un problema en el sistema.<br/>Consulte con el Soporte de sistemas", $conn->error, $conn->errno);
		vard($stmt_compr->bind_param('i', $id_rvc),"Valor de stmt_compr->bind_param('i',id_rvc)");
    $valor_de_execute=$stmt_compr->execute();
		vard($valor_de_execute,"Variable valor_de_execute");
    $valor_de_store_result=$stmt_compr->store_result();
		vard($valor_de_store_result,"Variable valor_de_store_result");
		vard($stmt_compr,"Valor de stmt_compr luego del execute");
		$response_json['num_rows']=$stmt_compr->num_rows;
		vard($stmt_compr->num_rows,"Variable stmt_compr->num_rows");
		vard($response_json['num_rows'],"Variable response_json['num_rows']");
    if($stmt_compr->num_rows==1)
		{
			echo "Se ha ingresado a cuenta de datos para XML<br>";
      $stmt_compr->bind_result($id_cli, $codcpg_rvi, $id_tipdoc, $cod_tipdoc, $desc_tipdoc, $abrev_tipdoc, $dni_ruc_cli, $nom_rzs_cli, 
			$cod_ubi, $regi_ubi, $prov_ubi, $distrito_cli, $direcc_cli, $tlfcel_cli, $email_cli, $id_tipcmp, $cod_tipcmp, $desc_tipcmp, 
			$seriecp_rvi, $numcp_rvi, $fechaemi_rvi, $horaemi_rvi, $tipo_moneda, $baseimpopgrv_rvi, $igv_rvi, $importetot_rvi);
      $stmt_compr->fetch();
			//Detalle de comprobante
      $sql_details="SELECT rgv.descrip_rvi, rgv.id_pro, pr.abrv_pro, rgv.id_udint, uint.cod_udint, 1 AS cantidad, 18.00 AS mto_impuesto, 
			rgv.importetot_rvi AS importetot_detail, rgv.baseimpopgrv_rvi AS base_impuesto, rgv.igv_rvi AS igv_detail, rgv.id_cdaf, afe.cod_cdaf 
			FROM regventas AS rgv 
			LEFT OUTER JOIN productos AS pr ON pr.id_pro=rgv.id_pro 
			LEFT OUTER JOIN undinternac AS uint ON uint.id_udint=rgv.id_udint 
			LEFT OUTER JOIN codafect AS afe ON afe.id_cdaf=rgv.id_cdaf 
			WHERE rgv.codcpg_rvi=?";
      if (!$stmt_details=$conn->prepare($sql_details)) throw new GException("Vaya! ocurrio un problema en el sistema.<br/>Consulte con el Soporte de sistemas", $conn->error, $conn->errno);
      if (!$stmt_details->bind_param('i', $codcpg_rvi)) throw new GException("Vaya! ocurrio un problema en el sistema.<br/>Consulte con el Soporte de sistemas", $conn->error, $conn->errno);
      $stmt_details->execute();
      $stmt_details->store_result();
			$response_json['items']=$stmt_details->num_rows;
			//Modificado por Juan (18-02-2019)
			/*if ($cod_tipcmp=='03')
			{
				$baseimpopgrv_rvi=$baseimpopgrv_rvi/1.18;
			}*/
			//--------------------------------
	  echo "Inicio de cargado de datos de registros para enviar a SUNAT.<br>";
      if($stmt_details->num_rows>0)
			{
        $invoice = new Invoice();
					//Modificado por JUAN (06-05-2019) ----------------------------------------------
					$invoice->setUblVersion('2.1')
          ->setTipoOperacion('0101')
          ->setTipoDoc($cod_tipcmp) //01 Factura, 03 Boleta de venta
          ->setSerie($seriecp_rvi)
          ->setCorrelativo($numcp_rvi)
//          ->setFechaEmision((new DateTime($fechaemi_rvi)))
          ->setFechaEmision((new DateTime()))
          ->setFormaPago(new FormaPagoContado()) // FormaPago: Contado (modificado 08-03-2022)
          ->setTipoMoneda($tipo_moneda)
          ->setClient((new Client())
            ->setTipoDoc($cod_tipdoc)
            ->setNumDoc($dni_ruc_cli)
            ->setRznSocial(utf8_encode($nom_rzs_cli))
            ->setAddress((new Address())
              ->setDireccion($direcc_cli))
          )
          /*->setMtoIGV(18.00)//FACTOR IGV*/
		  ->setMtoIGV(0.00) //Impuesto 0
          /*->setMtoOperGravadas($baseimpopgrv_rvi)//Mto Sin IGV*/
          ->setMtoOperExoneradas($baseimpopgrv_rvi) //Modificado para Exoneracion
          ->setTotalImpuestos($igv_rvi)//IGV EN BASE AL SUBTOTAL. Reemplazado ($baseimpopgrv_rvi*(18/100)) por $igv_rvi
          ->setValorVenta($baseimpopgrv_rvi)//MTO venta SIN IGV
          ->setSubTotal($importetot_rvi)//Subtotal de venta (modificado 08-03-2022)
          ->setMtoImpVenta($importetot_rvi)//TOTAL DE VENTA IMPRESA
          ->setCompany(
            (new Company())
            ->setRuc(ruc_empresa)
            ->setNombreComercial(nombre_comercial)
            ->setRazonSocial(razon_social_empresa)
            ->setAddress((new Address())
              ->setUbigueo(ubigeo_empresa)
              ->setDistrito(distrito_empresa)
              ->setProvincia(provincia_empresa)
              ->setDepartamento(region_empresa)
              ->setUrbanizacion('-')
              ->setCodLocal('0001')
              ->setDireccion(direccion_empresa)
            )
          );
          echo "Fin de cargado de datos a invoice<br>";
          $stmt_details->bind_result($descrip_rvi, $id_pro, $abrv_pro, $id_udint, $cod_udint, $cantidad, $mto_impuesto, 
					$importetot_detail, $base_impuesto, $igv_detail, $id_cdaf, $cod_cdaf);
					//Modificado por Juan (18-02-2019)
					/*if ($cod_tipcmp=='03')
					{
						$base_impuesto=$base_impuesto/1.18;
					}*/
					//--------------------------------
          $a_items=array();
          $i=0;
          echo "Inicio de cargado de datos a a_items<br>";
          while($stmt_details->fetch())
					{
            $item{$i} = new SaleDetail();
            $item{$i}->setCodProducto($id_pro)
              ->setTipAfeIgv($cod_cdaf)
              ->setUnidad($cod_udint)
              ->setCantidad($cantidad)
              ->setDescripcion($abrv_pro)
              ->setPorcentajeIgv($mto_impuesto)
              ->setMtoBaseIgv($base_impuesto)
              ->setIgv($igv_detail) //Reemplazar ($base_impuesto*($mto_impuesto/100)) por $igv_detail
              ->setTotalImpuestos($igv_detail) //Reemplazar ($base_impuesto*($mto_impuesto/100)) por $igv_detail
              ->setMtoValorVenta($base_impuesto)
              ->setMtoValorUnitario($cantidad*$base_impuesto)
              ->setMtoPrecioUnitario($base_impuesto+$igv_detail); //Reemplazar ($base_impuesto*($mto_impuesto/100)) por $igv_detail
              $a_items[]=&$item{$i};
              $i++;
          }
          echo "Fin de cargado de datos a a_items<br>";
          $invoice->setDetails($a_items)->setLegends([(new Legend())->setCode('1000')->setValue(sprintf('Son %s %s', num2letras($importetot_rvi), "SOLES"))]);
          echo "Cargado de datos adicionales a invoice<br>";
          $util = GUtil::getInstance();
          echo "Inicio de envio de datos a SUNAT con getSee<br>";
          $see = $util->getSee(SunatEndpoints::FE_BETA);
          echo "Inicio de revision de mensajes de respuesta de SUNAT en variable see<br>";
		  //$see = $util->getSee(SunatEndpoints::FE_PRODUCCION);
					/*-----------------------------------------------------------------------------
					Manejo de error de envio al servidor de variable $res = $see->send($invoice);
					Si el resultado de $response_json['success']=$res->isSuccess(); es FALSO
					Entonces se vuelve a enviar mediante $res = $see->send($invoice);
					Si el resultado de $response_json['success']=$res->isSuccess(); es VERDAD
					Se termina el bucle de envio y se pasa a completar los demas procesos
					-------------------------------------------------------------------------------*/
					$mensaje_error="";
					$codigo_error="";
					$contar_envios=0;
					$control_while=TRUE;
					$mensaje_envio="Vacio";
					echo "Inicio de proceso de respuestas de envio de datos de SUNAT<br>";
					//Modificacion sobre el tiempo de espera de la respuesta del servidor SUNAT
					ini_set('default_socket_timeout', 600);
					//-----------------------------------------------------
					while ($control_while)
					{
					    echo "Ingreso a control de respuestas y mensaje en while<br>";
						$res=$see->send($invoice);
						echo "Asignacion de variable res con see->send(invoice)<br>";
						$response_json['success']=$res->isSuccess();
						echo "Asignacion de variable response_json[success] con res->isSuccess()<br>";
						if ($response_json['success'])
						{
							$mensaje_envio="Envio Ok.:".$contar_envios;
							$control_while=FALSE;
						}
						else
						{
							$error=$res->getError();
							$mensaje_error=$error->getMessage();
							$codigo_error=$error->getCode();
							$mensaje_otro="Otro envio:".$codigo_error."-".$mensaje_error;
							if ($mensaje_error=="Bad Gateway" AND $codigo_error=="HTTP")
							{
								$contar_envios++;
								if ($contar_envios>10)
								{
									$mensaje_envio="Envio FAIL:".$contar_envios;
									$control_while=FALSE;
								}
								sleep(5);
								$mensaje_error=""; $codigo_error="";
							}
							else
							{
							    $mensaje_envio=$mensaje_otro;
								$control_while=FALSE;
							}
						}
						echo "Fin de control de respuetas y mensaje en while<br>";
					}
					mensaje($mensaje_envio);
          //$res = $see->send($invoice);
          $util->writeXml($invoice, $see->getFactory()->getLastXml());
          //$response_json['success']=$res->isSuccess();
					vard($res->isSuccess(),"Valor de res->isSuccess():");
          if($response_json['success'])
					{
            $util->writeCdr($invoice, $res->getCdrZip());
            $cdr = $res->getCdrResponse();
            $response_json['codigo_cdr']=$cdr->getCode();
            $response_json['respuesta_cdr']=$cdr->getDescription();
          }
					else
					{
            $error=$res->getError();
						vard($res->getError(),"Valor de res->getError():");
            $response_json['message']=$error->getMessage();
						echo "Mensaje de error:",$error->getMessage(),"<br>";
						//$error->getMessage()='Bad Gateway'
						echo "Codigo de error:",$error->getCode(),"<br>";
						//$error->getCode()='HTTP'
          }
      }
    }
    vard($response_json,"Valor de response_json: ");
    return $response_json;
  } 
	catch (Exception $e) 
	{
    var_dump($e);
		vard($e,"Valor de e, obtenido de catch y en Exception");
  }
}
