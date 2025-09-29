-<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors',1);
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE,OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require_once './class/vendor/autoload.php';
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Document;
use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;
use Greenter\Ws\Services\SunatEndpoints;
try {
    require_once './class/GLibfunciones.php';
    $response_json=array('success'=>false, "datos"=>array(), 'message'=>"Vaya!! estas intentando algo inusual en el sistema", 'codigo_cdr'=>FALSE, 'respuesta_cdr'=>'');
    $conn=new GConector();
    $sql_comprobante="SELECT rvc.id_cli, rvc.codcpg_rvi, cli.id_tipdoc, tdi.cod_tipdoc, tdi.desc_tipdoc, tdi.abrev_tipdoc, cli.dni_ruc_cli, cli.nom_rzs_cli, ub.cod_ubi, ub.regi_ubi, ub.prov_ubi, IFNULL(ub.dist_ubi, cli.lugar_cli) AS distrito_cli, cli.direcc_cli, cli.tlfcel_cli, cli.email_cli, rvc.id_tipcmp, tcomp.cod_tipcmp, tcomp.desc_tipcmp, CONCAT(IF(tcomp.cod_tipcmp='01', 'F', 'B'), LPAD(rvc.seriecp_rvi,3,'0')) AS seriecp_rvi, LPAD(rvc.numcp_rvi, 8,'0') AS numcp_rvi, rvc.fechaemi_rvi, rvc.horaemi_rvi, 'PEN' AS tipo_moneda, IF(rvc.baseimpopgrv_rvi=0.00, calcular_subtotal(rvc.importetot_rvi, 18.00, '0'), rvc.baseimpopgrv_rvi ) AS baseimpopgrv_rvi, rvc.igv_rvi, rvc.importetot_rvi FROM regvtacaja AS rvc LEFT OUTER JOIN clientes AS cli ON cli.id_cli=rvc.id_cli LEFT OUTER JOIN tipodocident AS tdi ON tdi.id_tipdoc=cli.id_tipdoc LEFT OUTER JOIN ubigeo AS ub ON ub.id_ubi=cli.id_ubi INNER JOIN tipocomprob AS tcomp ON tcomp.id_tipcmp=rvc.id_tipcmp WHERE rvc.id_rvc=?";
    if (!$stmt_compr=$conn->prepare($sql_comprobante))
        throw new GException("Vaya! ocurrio un problema en el sistema.<br/>Consulte con el Soporte de sistemas", $conn->error, $conn->errno);
    if (!$stmt_compr->bind_param('i', $_REQUEST['id_venta']))
        throw new GException("Vaya! ocurrio un problema en el sistema.<br/>Consulte con el Soporte de sistemas", $conn->error, $conn->errno);
    $stmt_compr->execute();
    $stmt_compr->store_result();
    if($stmt_compr->num_rows==1){
        $stmt_compr->bind_result($id_cli, $codcpg_rvi, $id_tipdoc, $cod_tipdoc, $desc_tipdoc, $abrev_tipdoc, $dni_ruc_cli, $nom_rzs_cli, $cod_ubi, $regi_ubi, $prov_ubi, $distrito_cli, $direcc_cli, $tlfcel_cli, $email_cli, $id_tipcmp, $cod_tipcmp, $desc_tipcmp, $seriecp_rvi, $numcp_rvi, $fechaemi_rvi, $horaemi_rvi, $tipo_moneda, $baseimpopgrv_rvi, $igv_rvi, $importetot_rvi);
        $stmt_compr->fetch();
        $sql_details="SELECT rgv.descrip_rvi, rgv.id_pro, pr.abrv_pro, rgv.id_udint, uint.cod_udint, 1 AS cantidad, 18.00 AS mto_impuesto, rgv.importetot_rvi AS importetot_detail, rgv.baseimpopgrv_rvi AS base_impuesto, rgv.id_cdaf, afe.cod_cdaf FROM regventas AS rgv LEFT OUTER JOIN productos AS pr ON pr.id_pro=rgv.id_pro LEFT OUTER JOIN undinternac AS uint ON uint.id_udint=rgv.id_udint LEFT OUTER JOIN codafect AS afe ON afe.id_cdaf=rgv.id_cdaf WHERE rgv.codcpg_rvi=?";
        if (!$stmt_details=$conn->prepare($sql_details))
            throw new GException("Vaya! ocurrio un problema en el sistema.<br/>Consulte con el Soporte de sistemas", $conn->error, $conn->errno);
        if (!$stmt_details->bind_param('i', $codcpg_rvi))
            throw new GException("Vaya! ocurrio un problema en el sistema.<br/>Consulte con el Soporte de sistemas", $conn->error, $conn->errno);
        $stmt_details->execute();
        $stmt_details->store_result();
        if($stmt_details->num_rows>0){
            $invoice = new Invoice();
            $invoice->setUblVersion('2.1')
            ->setTipoOperacion('0101')
            ->setTipoDoc($cod_tipcmp)
            ->setSerie($seriecp_rvi)
            ->setCorrelativo($numcp_rvi)
            ->setFechaEmision((new DateTime($fechaemi_rvi)))
            ->setTipoMoneda($tipo_moneda)
            ->setClient((new Client())
                        ->setTipoDoc($cod_tipdoc)
                        ->setNumDoc($dni_ruc_cli)
                        ->setRznSocial(utf8_encode($nom_rzs_cli))
                        ->setAddress((new Address())
                        ->setDireccion($direcc_cli))
            )
            ->setMtoIGV(18.00)//FACTOR IGV
            ->setMtoOperGravadas($baseimpopgrv_rvi)//Mto Sin IGV
            ->setTotalImpuestos(($baseimpopgrv_rvi*(18/100)))//IGV EN BASE AL SUBTOTAL
            ->setValorVenta($baseimpopgrv_rvi)//MTO venta SIN IGV
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
            $stmt_details->bind_result($descrip_rvi, $id_pro, $abrv_pro, $id_udint, $cod_udint, $cantidad, $mto_impuesto, $importetot_detail, $base_impuesto, $id_cdaf, $cod_cdaf);
            $a_items=array();
            $i=0;
            while($stmt_details->fetch()){
                $item{$i} = new SaleDetail();
                $item{$i}->setCodProducto($id_pro)
                ->setTipAfeIgv($cod_cdaf)
                ->setUnidad($cod_udint)
                ->setCantidad($cantidad)
                ->setDescripcion($abrv_pro)
                ->setPorcentajeIgv($mto_impuesto)
                ->setMtoBaseIgv($base_impuesto)
                ->setIgv(($base_impuesto*($mto_impuesto/100)))
                ->setTotalImpuestos(($base_impuesto*($mto_impuesto/100)))
                ->setMtoValorVenta($base_impuesto)
                ->setMtoValorUnitario(($cantidad*$base_impuesto))
                ->setMtoPrecioUnitario($base_impuesto+($base_impuesto*($mto_impuesto/100)));
                $a_items[]=&$item{$i};
                $i++;
            }
            $invoice->setDetails($a_items)->setLegends([(new Legend())->setCode('1000')->setValue(sprintf('Son %s %s', num2letras($importetot_rvi), "SOLES"))]);
            $util = GUtil::getInstance();
            $see = $util->getSee(SunatEndpoints::FE_BETA);
			//$see = $util->getSee(SunatEndpoints::FE_PRODUCCION);
            $res = $see->send($invoice);
            $util->writeXml($invoice, $see->getFactory()->getLastXml());
            $response_json['success']=$res->isSuccess();
            if($response_json['success']){
                $util->writeCdr($invoice, $res->getCdrZip());
                $cdr = $res->getCdrResponse();
                $response_json['codigo_cdr']=$cdr->getCode();
                $response_json['respuesta_cdr']=$cdr->getDescription();
            }else{
                $error=$res->getError();
				$response_json['message']=$error->getMessage();
			}
        }
    }
    echo json_encode($response_json);
} catch (Exception $e) {
    var_dump($e);
}
