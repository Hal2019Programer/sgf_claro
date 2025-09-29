<?php
require_once './class/vendor/autoload.php';
use Greenter\Model\Sale\BaseSale;
use Greenter\Model\Client\Client;
use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use PHPMailer\PHPMailer\PHPMailer;

if(isset($_GET['id_rvc']))
{
	if ($_GET['method']=='generar') $respuesta=generatePDFComprante($_GET['id_rvc']);
	else $respuesta=sendComprobanteEmail($_GET['id_rvc']);
	var_dump($respuesta);
}

function generatePDFComprante($id_rvc)
{
   require_once './class/GLibfunciones.php';
	try
	{
		$response=false;
		$conn=new GConector();
		$sql_empresa="SELECT nmbc_empe, 'R.U.C.' AS abrv_dfsical, nomb_empe, ndoc_empe, dir_empe, dist_empe, prov_empe, region_empe, '".web_empresa."' AS sitioweb, '".correo3."' AS email_emp FROM empemisor";
		if(!$result_emp=$conn->query($sql_empresa))
			throw new Exception("Error al consultar empresar");
		if($result_emp->num_rows!=1)
			throw new Exception("Ocurrio un problema al consultar datos de la empresa");
		$empresa=array_combine(array("razon_social","abrev_doc_fiscal", "nombre_empresa", "num_doc_fiscal", "direccion", "distrito", "provincia", "departamento", "sitioweb", "email"), $result_emp->fetch_assoc());
		var_dump($id_rvc);
		
		/*DATOS DE COMPROBANTE*/
		$stmt_venta=$conn->stmt_init();
		//$sql_venta="SELECT rvta.id_cli, rvta.fechaemi_rvi, rvta.id_tipcmp, UPPER(rvta.tipodoccp_rvi) AS tipodoccp_rvi, LPAD(rvta.seriecp_rvi, 3, '0') AS seriecp_rvi, LPAD(rvta.numcp_rvi, 8, '0') AS numcp_rvi, rvta.codcpg_rvi, rvta.formapago_rvi, IF(rvta.baseimpopgrv_rvi=0.00, calcular_subtotal(rvta.importetot_rvi, 18.00, '0'), rvta.baseimpopgrv_rvi) AS baseimpopgrv_rvi, IF(rvta.igv_rvi=0.00, rvta.importetot_rvi-calcular_subtotal(rvta.importetot_rvi, 18.00, '0'),rvta.igv_rvi) AS igv_rvi, rvta.importetot_rvi, rvta.id_usr, CONCAT_WS('-', CONCAT(IF(tcomp.cod_tipcmp='01', 'F', 'B'), LPAD(rvta.seriecp_rvi, 3,'0')), LPAD(rvta.numcp_rvi, 8,'0')) AS num_documento FROM regvtacaja AS rvta INNER JOIN tipocomprob AS tcomp ON tcomp.id_tipcmp=rvta.id_tipcmp WHERE rvta.id_rvc=?";
		$sql_venta="SELECT rvta.id_cli, rvta.fechaemi_rvi, rvta.id_tipcmp, UPPER(rvta.tipodoccp_rvi) AS tipodoccp_rvi, LPAD(rvta.seriecp_rvi, 3, '0') AS seriecp_rvi, LPAD(rvta.numcp_rvi, 8, '0') AS numcp_rvi, rvta.codcpg_rvi, rvta.formapago_rvi, IF(rvta.baseimpopgrv_rvi=0.00, calcular_subtotal(rvta.importetot_rvi, 18.00, '0'), rvta.baseimpopgrv_rvi) AS baseimpopgrv_rvi, rvta.igv_rvi AS igv_rvi, rvta.importetot_rvi, rvta.id_usr, CONCAT_WS('-', CONCAT(IF(tcomp.cod_tipcmp='01', 'F', 'B'), LPAD(rvta.seriecp_rvi, 3,'0')), LPAD(rvta.numcp_rvi, 8,'0')) AS num_documento FROM regvtacaja AS rvta INNER JOIN tipocomprob AS tcomp ON tcomp.id_tipcmp=rvta.id_tipcmp WHERE rvta.id_rvc=?";
		if (!$stmt_venta->prepare($sql_venta))
			throw new Exception("Error en la consulta para obtener datos del comprobante");
		if (!$stmt_venta->bind_param('i', $id_rvc))
			throw new Exception("Error en el parametro para los datos del comprobante");
		$stmt_venta->execute();
		$stmt_venta->store_result();
		if ($stmt_venta->num_rows!=1)
			throw new Exception("No se encontro registro de comprobante para el id indicado (datos del comprobante)");
		$stmt_venta->bind_result($id_cli, $fechaemi_rvi, $id_tipcmp, $tipodoccp_rvi, $seriecp_rvi, $numcp_rvi, $codcpg_rvi, $formapago_rvi, $baseimpopgrv_rvi, $igv_rvi, $importetot_rvi, $id_usr, $num_documento);
		$stmt_venta->fetch();
		$venta=array("desc_comprobante"=>$tipodoccp_rvi, "num_serie"=>$seriecp_rvi, "num_comprobante"=>$numcp_rvi, "condicion_pago"=>$formapago_rvi, "subtotal"=>$baseimpopgrv_rvi, "importe_igv"=>$igv_rvi, "total"=>$importetot_rvi, "importe_letra"=>num2letras($importetot_rvi), "detalles"=>array());

		/*DATOS DE LA SUCURSAL */
		$stmt_consulta=$conn->stmt_init();
		$sql_sucursal="SELECT suc.direccion_undc FROM usuarios AS u  LEFT OUTER JOIN undcomerc AS suc ON suc.id_undc=u.id_undc WHERE u.id_usr=?";
		if (!$stmt_consulta->prepare($sql_sucursal))
			throw new Exception("Error en la consulta para obtener datos de la sucursal");
		if(!$stmt_consulta->bind_param('i', $id_usr))
			throw new Exception("Error en el parametro para los datos de la sucursal");
		$stmt_consulta->execute();
		$stmt_consulta->store_result();
		if($stmt_consulta->num_rows!=1)
			throw new Exception("No se encontro registro de sucursal para el usuario del comprobante");
		$stmt_consulta->bind_result($direccion_undc);
		$stmt_consulta->fetch();
		$empresa['sucursal']=array("direccion"=>$direccion_undc, "distrito"=>"", "provincia"=>"", "departamento"=>"");

		/*DATOS DEL CLIENTE*/
		$sql_cliente="SELECT c.nom_rzs_cli, c.id_tipdoc, td.abrev_tipdoc, c.dni_ruc_cli, c.direcc_cli, c.tlfcel_cli, c.email_cli FROM clientes AS c LEFT OUTER JOIN tipodocident AS td ON td.id_tipdoc=c.id_tipdoc WHERE c.id_cli=?";
		if (!$stmt_consulta->prepare($sql_cliente))
			throw new Exception("Error en la consulta para obtener datos del Cliente");
		if (!$stmt_consulta->bind_param('i', $id_cli))
			throw new Exception("Error en parametros para datos del Cliente");
		$stmt_consulta->execute();
		$stmt_consulta->store_result();
		if ($stmt_consulta->num_rows!=1)
			throw new Exception("No se encontro registro de cliente del comprobante");
		$stmt_consulta->bind_result($nom_rzs_cli, $id_tipdoc, $abrev_tipdoc, $dni_ruc_cli, $direcc_cli, $tlfcel_cli, $email_cli);
		$stmt_consulta->fetch();
		$cliente=array("razon_social"=>$nom_rzs_cli, "direccion"=>$direcc_cli, "abrev_doc_identidad"=>$abrev_tipdoc, "num_doc_identidad"=>$dni_ruc_cli);
		
		/*DETALLE DE LA VENTA*/
		$sql_detalle="SELECT rvtd.id_pro, pr.abrv_pro, 1 AS cantidad, rvtd.baseimpopgrv_rvi, rvtd.igv_rvi, rvtd.importetot_rvi, rvtd.id_udint FROM regventas AS rvtd LEFT OUTER JOIN productos AS pr ON pr.id_pro=rvtd.id_pro WHERE rvtd.seriecp_rvi=? AND rvtd.numcp_rvi=? AND rvtd.codcpg_rvi=?";
		if (!$stmt_venta->prepare($sql_detalle))
			throw new Exception("Error en la consulta para obtener datos del comprobante");
		if (!$stmt_venta->bind_param('iii', $seriecp_rvi, $numcp_rvi, $codcpg_rvi))
			throw new Exception("Error en el parametro para los datos del comprobante");
		$stmt_venta->execute();
		$stmt_venta->store_result();
		if ($stmt_venta->num_rows==0)
			throw new Exception("No se contraron detalles de ventas en este comprobante");
		$stmt_venta->bind_result($id_pro, $abrv_pro, $cantidad, $baseimpopgrv_rvi, $igv_rvi, $importetot_rvi, $id_udint);
		
		$a_detalles=array();
		if ($tipodoccp_rvi=="BOLETA DE VENTA")
		{
			while($stmt_venta->fetch())
			{
				array_push($a_detalles, array("id_pro"=>$id_pro, "descripcion"=>$abrv_pro, "cantidad"=>$cantidad, "precio"=>$baseimpopgrv_rvi+$igv_rvi, "mto_impuesto"=>$igv_rvi, "total"=>$importetot_rvi, $id_udint));
			}
		}
		else
		{
			while($stmt_venta->fetch())
			{
				array_push($a_detalles, array("id_pro"=>$id_pro, "descripcion"=>$abrv_pro, "cantidad"=>$cantidad, "precio"=>$baseimpopgrv_rvi, "mto_impuesto"=>$igv_rvi, "total"=>$importetot_rvi, $id_udint));
			}
		}
		 
		var_dump($seriecp_rvi);
		$venta["detalles"]=$a_detalles;
		$sale=new BaseSale();
		$sale->setFechaEmision(DateTime::createFromFormat('Y-m-d', $fechaemi_rvi))
			  ->setTipoDoc(str_pad($id_tipcmp,2,'0', STR_PAD_LEFT))
			  ->setSerie(str_pad($seriecp_rvi, 3,'0', STR_PAD_LEFT ))
			  ->setCorrelativo(str_pad($numcp_rvi,8,'0', STR_PAD_LEFT))
			  ->setClient(
					(new Client())
						 ->setTipoDoc($id_tipdoc)
						 ->setNumDoc($dni_ruc_cli)
						 ->setRznSocial(utf8_encode($nom_rzs_cli))
						 ->setAddress(
								(new Address())
									->setDireccion($direcc_cli)
						 )
			  )
			  ->setCompany(
					(new Company())
						 ->setRuc($empresa['num_doc_fiscal'])
						 ->setNombreComercial($empresa['razon_social'])
						 ->setRazonSocial(razon_social_empresa)
						 ->setAddress((new Address())
						 ->setUbigueo('120101')
						 ->setDistrito($empresa['distrito'])
						 ->setProvincia($empresa['provincia'])
						 ->setDepartamento($empresa['departamento'])
						 ->setUrbanizacion('-')
						 ->setCodLocal('0001')
						 ->setDireccion($empresa['direccion'])
					)        
			  );
		if (!defined('PATH_SUNAT'))
			define('PATH_SUNAT', __DIR__.'/../datasunat/');
		if (!file_exists(PATH_SUNAT))
			throw new Exception("Directorio (".PATH_SUNAT.") no existe");
		$path_saved=sprintf("%s%s.pdf", PATH_SUNAT, $sale->getName());
		if (file_exists($path_saved))
			throw new Exception("Fichero ya se encuentra en el Directorio");
		//$renderer = new GQrRender();
		$renderer = new QrRender();
		$renderer->getImage($sale);
		$twig = new GTemplate();
		$comprobante_html=$twig->render('comprobante.html', array(
			'empresa'=>$empresa, 
			'cliente'=>$cliente, 
			'venta'=>$venta, 
			'num_comprobante'=>$num_documento,
			'razon_social_empresa'=>razon_social_empresa,
			'web_empresa'=>web_empresa));
		$oReport= new GReports('P', 'mm', 'A4', true, 'UTF-8', false);
		$oReport->SetMargins(5, 10, 5, TRUE);
		$oReport->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$oReport->SetAutoPageBreak(TRUE, 25);
		$oReport->AddPage();
		$oReport->WriteHTML($comprobante_html, true, false, true, false, '');
		$oReport->Output($path_saved, 'F');
		$oReport->Close();
		$response['status']=true;
	}
	catch (Exception $e)
	{
		$response['status']=false;
		$response['error']=$e->getMessage();
	}
	return $response;
}

function sendComprobanteEmail($id_rvc)
{
	$response['status']=false;
	require_once './class/GLibfunciones.php';
	require_once './class/vendor/autoload.php';
	require_once './class/vendor/phpmailer/phpmailer/src/PHPMailer.php';
	require_once './class/vendor/phpmailer/phpmailer/src/Exception.php';

	$conn=new GConector();
	$sql_empresa="SELECT nmbc_empe, 'R.U.C.' AS abrv_dfsical, nomb_empe, ndoc_empe, dir_empe, dist_empe, prov_empe, region_empe, '".web_empresa."' AS sitioweb, '".correo3."' AS email_emp FROM empemisor";
	if (!$result_emp=$conn->query($sql_empresa))
      throw new Exception("Error al consultar empresar");
	if ($result_emp->num_rows!=1)
      throw new Exception("Ocurrio un problema al consultar datos de la empresa");
	$empresa=$result_emp->fetch_assoc();
	$stmt_venta=$conn->stmt_init();
	$sql_venta="SELECT rvta.id_cli, rvta.fechaemi_rvi, LPAD(rvta.id_tipcmp,2,'0') AS id_tipcmp, UPPER(rvta.tipodoccp_rvi) AS tipodoccp_rvi, LPAD(rvta.seriecp_rvi, 3, '0') AS seriecp_rvi, LPAD(rvta.numcp_rvi,8,'0') AS numcp_rvi, rvta.importetot_rvi, cl.nom_rzs_cli, cl.email_cli, CONCAT_WS('-', CONCAT(IF(tcomp.cod_tipcmp='01', 'F', 'B'), LPAD(rvta.seriecp_rvi,3,'0')), LPAD(rvta.numcp_rvi, 8,'0')) AS num_documento FROM regvtacaja AS rvta LEFT OUTER JOIN clientes AS cl ON cl.id_cli=rvta.id_cli INNER JOIN tipocomprob AS tcomp ON tcomp.id_tipcmp=rvta.id_tipcmp WHERE rvta.id_rvc=?";
	if (!$stmt_venta->prepare($sql_venta))
      throw new Exception("Error en la consulta para obtener datos del comprobante");
	if (!$stmt_venta->bind_param('i', $id_rvc))
      throw new Exception("Error en el parametro para los datos del comprobante");
	$stmt_venta->execute();
	$stmt_venta->store_result();
	if ($stmt_venta->num_rows!=1)
      throw new Exception("No se econtro registro de comprobante para el id indicado");
	$stmt_venta->bind_result($id_cli, $fechaemi_rvi, $id_tipcmp, $tipodoccp_rvi, $seriecp_rvi, $numcp_rvi, $importetot_rvi, $nom_rzs_cli, $email_cli, $num_documento);
	$stmt_venta->fetch();
	$sale=new BaseSale();
	$sale->setTipoDoc(str_pad($id_tipcmp,2,'0', STR_PAD_LEFT))
		  ->setSerie($seriecp_rvi)
		  ->setCorrelativo($numcp_rvi)
		  ->setCompany(
				(new Company())
					->setRuc($empresa['ndoc_empe'])
		  );
	try
	{
		if (empty($email_cli))
			throw new Exception("El email se encuentra vacio");
		if (!defined('PATH_SUNAT'))
			define('PATH_SUNAT', __DIR__.'/../datasunat/');
		$file_pdf=sprintf("%s%s.pdf", PATH_SUNAT, $sale->getName());
		if (!file_exists($file_pdf))
			throw new Exception(sprintf("El archivo %s no existe", $file_pdf));
		$twig = new GTemplate();
		$emision=$twig->render('emision.html', array(
			'email'=>array(
				"razon_social"=>$nom_rzs_cli, 
				"tipo_comprobante"=>$tipodoccp_rvi, 
				"ruc_emisor"=>$empresa['ndoc_empe'], 
				"fec_emision"=>$fechaemi_rvi, 
				"total"=>$importetot_rvi, 
				"num_comprobante"=>$num_documento),
			'url_web_empresa'=>url_web_empresa,
			'web_empresa'=>web_empresa,
			'razon_social_empresa'=>razon_social_empresa));
		$mail = new PHPMailer();
		$mail->SetFrom(correo2, 'No Reply');
		// $correo_origen="hal9000.pe@gmail.com";
		// $mail->SetFrom($correo_origen, 'No Reply');
		$mail->AddAddress($email_cli, utf8_decode($nom_rzs_cli));
		$mail->Subject = sprintf("%s - ",$tipodoccp_rvi).$empresa['nomb_empe'];
		$mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
		$mail->MsgHTML($emision);
		$mail->AddAttachment($file_pdf);
		// echo "Correo enviado: ",$email_cli,"<br>";
		// echo "Correo origen: ", correo2, "<br>";
      $response['status']=$mail->Send();
      $response['error']=($response['status'])?"":sprintf("No se pudo enviar el correo a:  %s %s %s", $email_cli, " Error: ", $mail->ErrorInfo);
	}
	catch(Exception $e)
	{
      $response['status']=false;
      $response['error']=$e->getMessage();
	}
	return $response;
}

?>