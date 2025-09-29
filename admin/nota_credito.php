<?php
require_once './class/vendor/autoload.php';
use Greenter\Model\Sale\Document;
use Greenter\Model\Sale\Note;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;
use Greenter\Ws\Services\SunatEndpoints;
use Greenter\Model\Client\Client;
use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;

function sendXMLNotaCredito($id_rvc, $id_ncred, $desc_ncred)
{
  require_once './class/GLibfunciones.php';
  $conn=new GConector();
  $respuesta=array("success"=>false, "message"=>"");
  $util = GUtil::getInstance();
  $note = new Note();
  $sql_comprobante=sprintf("SELECT rvc.id_cli, cli.id_tipdoc, tdi.cod_tipdoc, tdi.abrev_tipdoc, cli.dni_ruc_cli, cli.nom_rzs_cli, 
	cli.direcc_cli, cli.id_ubi, ubi.cod_ubi, ubi.regi_ubi, IFNULL(ubi.dist_ubi, cli.lugar_cli) AS distrito_cli, cli.tlfcel_cli, 
	cli.email_cli, rvc.id_pla, rvc.fechaemi_rvi, rvc.horaemi_rvi, LPAD(rvc.seriecp_rvi,4,'0') AS seriecp_rvi, 
	LPAD(rvc.numcp_rvi, 8, '0') AS numcp_rvi, rvc.codcpg_rvi, rvc.formapago_rvi, 
	IF(rvc.baseimpopgrv_rvi=0.00, calcular_subtotal(rvc.importetot_rvi, 18.00, '0'), rvc.baseimpopgrv_rvi) AS baseimpopgrv_rvi, 
	rvc.igv_rvi, rvc.importetot_rvi, rvc.id_tipcmp, tcp.cod_tipcmp, tcp.desc_tipcmp, 
	CONCAT_WS('-', CONCAT( IF(tcp.cod_tipcmp='01', 'F', 'B'), LPAD(rvc.seriecp_rvi, 3, '0')), LPAD(rvc.numcp_rvi, 8, '0') ) AS doc_sunat, 
	'PEN' AS tipo_moneda, rvc.estado_rvc, rvc.causanul_rvc, rvc.id_undc, rvc.id_ncred, nc.cod_ncred, 
	IF(nc.cod_ncred='10', CONCAT_WS(': ',nc.desc_ncred, '%s'), nc.desc_ncred) AS descrip_rvi 
	FROM regvtacaja AS rvc  
	LEFT OUTER JOIN clientes AS cli ON cli.id_cli=rvc.id_cli 
	LEFT OUTER JOIN tipodocident AS tdi ON tdi.id_tipdoc=cli.id_tipdoc 
	LEFT OUTER JOIN ubigeo AS ubi ON ubi.id_ubi=cli.id_ubi 
	LEFT OUTER JOIN tipocomprob AS tcp ON tcp.id_tipcmp=rvc.id_tipcmp 
	LEFT OUTER JOIN codnotacred AS nc ON nc.id_ncred=%d 
	WHERE rvc.id_rvc =?", $desc_ncred, $id_ncred);
  if (!$stmt_compr=$conn->prepare($sql_comprobante)) throw new GException("Vaya! ocurrio un problema en el sistema.<br/>Consulte con el Soporte de sistemas", $conn->error, $conn->errno);
  if (!$stmt_compr->bind_param('i', $id_rvc)) throw new GException("Vaya! ocurrio un problema en el sistema.<br/>Consulte con el Soporte de sistemas", $conn->error, $conn->errno);
  $stmt_compr->execute();
  $stmt_compr->store_result();
  if($stmt_compr->num_rows!=1) die("No hay compras registradas con este codigo");
  $stmt_compr->bind_result($id_cli, $id_tipdoc, $cod_tipdoc, $abrev_tipdoc, $dni_ruc_cli, $nom_rzs_cli, $direcc_cli, 
	$id_ubi, $cod_ubi, $regi_ubi, $distrito_cli, $tlfcel_cli, $email_cli, $id_pla, $fechaemi_rvi, $horaemi_rvi, $seriecp_rvi, 
	$numcp_rvi, $codcpg_rvi, $formapago_rvi, $baseimpopgrv_rvi, $igv_rvi, $importetot_rvi, $id_tipcmp, $cod_tipcmp, $desc_tipcmp, 
	$doc_sunat, $tipo_moneda, $estado_rvc, $causanul_rvc, $id_undc, $id_ncred, $cod_ncred, $descrip_rvi);
  $stmt_compr->fetch();
	$sql_correlativo=sprintf("SELECT IFNULL(MAX(numcorr_ncred),0) AS num_corr FROM `regvtacaja` WHERE seriecp_rvi=%d", $seriecp_rvi);
	$result=$conn->query($sql_correlativo);
	$num_correlativo=0;
	if($result->num_rows==1)
	{
		$row=$result->fetch_assoc();
		$num_correlativo=$row['num_corr'];
	}
  $sql_details="SELECT rgv.descrip_rvi, rgv.id_pro, pr.abrv_pro, rgv.id_udint, uint.cod_udint, 
	1 AS cantidad, 18.00 AS mto_impuesto, rgv.importetot_rvi AS importetot_detail, 
	rgv.baseimpopgrv_rvi AS base_impuesto, rgv.id_cdaf, afe.cod_cdaf 
	FROM regventas AS rgv 
	LEFT OUTER JOIN productos AS pr ON pr.id_pro=rgv.id_pro 
	LEFT OUTER JOIN undinternac AS uint ON uint.id_udint=rgv.id_udint 
	LEFT OUTER JOIN codafect AS afe ON afe.id_cdaf=rgv.id_cdaf 
	WHERE rgv.seriecp_rvi=? AND rgv.numcp_rvi=? AND rgv.codcpg_rvi=?";
  $stmt_details=$conn->stmt_init();
  if(!$stmt_details=$conn->prepare($sql_details)) throw new GException("Vaya! ocurrio un problema en el sistema.<br/>Consulte con el Soporte de sistemas", $conn->error, $conn->errno);
  if(!$stmt_details->bind_param('iii', $seriecp_rvi, $numcp_rvi, $codcpg_rvi)) throw new GException("Vaya! ocurrio un problema en el sistema.<br/>Consulte con el Soporte de sistemas", $conn->error, $conn->errno);
  $stmt_details->execute();
  $stmt_details->store_result();
  if($stmt_details->num_rows==0) die("Este comprobante no posee detalles de ventas");
	$numdocafectado=sprintf("%s",str_pad($num_correlativo+1,8,'0',STR_PAD_LEFT));
	//A??adido para generar una nota de credito valida
	if ($desc_tipcmp=="Boleta de Venta")
	{
		$serie_nota_credito="B".substr("0000".$seriecp_rvi,-3);
	}
	else
	{
		$serie_nota_credito="F".substr("0000".$seriecp_rvi,-3);
	}
	//Tipo de comprobante: Nota de Credito = 07
		//Modificado por JUAN (04-05-2019) --------------------------------------
		//Modificado por JUAN (11-05-2019) Para setMtoIGV=0 y setTotalImpuestos=0 por EXONERADO
		echo "NC:".$serie_nota_credito."-".$numdocafectado."<br>";
		$note
    ->setUblVersion('2.1')
    ->setFechaEmision(new DateTime())
    ->setTipoDoc('07')
    ->setSerie($serie_nota_credito)
    ->setCorrelativo($numdocafectado)
    ->setTipoMoneda($tipo_moneda)
    ->setTipDocAfectado($cod_tipcmp)
    ->setNumDocfectado($doc_sunat)
    ->setCodMotivo($cod_ncred)
    ->setDesMotivo($descrip_rvi)
    ->setClient(
      (new Client())
      ->setTipoDoc($cod_tipdoc)
      ->setNumDoc($dni_ruc_cli)
      ->setRznSocial(utf8_encode($nom_rzs_cli))
      ->setAddress((new Address())
      ->setDireccion($direcc_cli))        
    )
    ->setMtoImpVenta($importetot_rvi)//mto impuesto+ventas
    /*->setMtoOperGravadas($baseimpopgrv_rvi)//mto ventas*/
	->setMtoOperExoneradas($baseimpopgrv_rvi) //Modificado para Exoneracion
    ->setMtoIGV(0)//Modificado de: $baseimpopgrv_rvi*(18/100) a 0
    ->setTotalImpuestos(0)//Modificado de: $baseimpopgrv_rvi*(18/100) a 0
    ->setMtoOperInafectas(0)
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
		//Fin de modificación ---------------------------------------------------
  $stmt_details->bind_result($descrip_rvi, $id_pro, $abrv_pro, $id_udint, $cod_udint, $cantidad, 
	$mto_impuesto, $importetot_detail, $base_impuesto, $id_cdaf, $cod_cdaf);
  $a_items=array();
  $i=0;
  while($stmt_details->fetch())
	{
    $item{$i} = new SaleDetail();
		//Modificado por JUAN (11-05-2019) Para setIgv de ($base_impuesto*($mto_impuesto/100)) a 0
		//setTotalImpuestos de ($base_impuesto*($mto_impuesto/100)) a 0 
		//y setMtoPrecioUnitario de $base_impuesto+($base_impuesto*($mto_impuesto/100)) a 
		//($cantidad*$base_impuesto) por EXONERADO
    $item{$i}->setCodProducto($id_pro)
      ->setUnidad($cod_udint)
      ->setCantidad($cantidad)
      ->setDescripcion($abrv_pro)
      ->setMtoBaseIgv($base_impuesto)
      ->setPorcentajeIgv($mto_impuesto)
      ->setIgv(0)
      ->setTipAfeIgv($cod_cdaf)
      ->setTotalImpuestos(0)
      ->setMtoValorVenta($base_impuesto)
      ->setMtoValorUnitario(($cantidad*$base_impuesto))
      ->setMtoPrecioUnitario(($cantidad*$base_impuesto));
    $a_items[]=&$item{$i};
    $i++;
  }
  $legend = new Legend();
  $legend->setCode('1000')
    ->setValue(sprintf('SON %s SOLES', num2letras($importetot_rvi)));
  $note->setDetails($a_items)
    ->setLegends([$legend]);
  // Envio a SUNAT.
  $see = $util->getSee(SunatEndpoints::FE_BETA);
  //$see = $util->getSee(SunatEndpoints::FE_PRODUCCION);
  $res = $see->send($note);
  $util->writeXml($note, $see->getFactory()->getLastXml());
  if($res->isSuccess()) 
	{
    $cdr = $res->getCdrResponse();
		$respuesta['codigo_cdr']=$cdr->getCode();
		$respuesta['respuesta_cdr']=$cdr->getDescription();
    $util->writeCdr($note, $res->getCdrZip());
    $respuesta['success']=true;
		$respuesta['num_corr']=$num_correlativo+1;
  }
	else
	{
    $respuesta['message']=$res->getError();
		vard($res->getError(),"Valor de res->getError():");
		$respuesta['num_corr']=NULL;
  }
  vard($res,"Valor de res de envio:");
  return $respuesta;
}
if(isset($_GET['id_rvc']))
{
	//$result=sendXMLNotaCredito($_GET['id_rvc']); $id_ncred, $desc_ncred
	$result=sendXMLNotaCredito($_GET['id_rvc'], $_GET['id_ncred'], $_GET['desc_ncred']);
	var_dump($result);
}