<?php
function sendComprobanteEmail($id_rvc){
	require_once './GLibfunciones.php';
	require_once './vendor/autoload.php';
	use PHPMailer\PHPMailer\PHPMailer;
	use Greenter\Model\Company\Company;
	use Greenter\Model\Sale\BaseSale;
	$conn=new GConector();
	$sql_empresa="SELECT nmbc_empe, 'R.U.C.' AS abrv_dfsical, nomb_empe, ndoc_empe, dir_empe, dist_empe, prov_empe, region_empe, '".web_empresa."' AS sitioweb, '".correo3."' AS email_emp FROM empemisor";
	if(!$result_emp=$conn->query($sql_empresa))
		die("Error al consultar empresar");
	if($result_emp->num_rows!=1)
		die("Ocurrio un problema al consultar datos de la empresa");
	$empresa=$result_emp->fetch_assoc();

	$stmt_venta=$conn->stmt_init();
	$sql_venta="SELECT rvta.id_cli, rvta.id_tipcmp, UPPER(rvta.tipodoccp_rvi) AS tipodoccp_rvi, LPAD(rvta.seriecp_rvi, 5, '0') AS seriecp_rvi, rvta.numcp_rvi, cl.nom_rzs_cli, cl.email_cli FROM regvtacaja AS rvta LEFT OUTER JOIN clientes AS cl ON cl.id_cli=rvta.id_cli WHERE rvta.id_rvc=?";
	if(!$stmt_venta->prepare($sql_venta))
		die("Error en la consulta para obtener datos del comprobante");
	if(!$stmt_venta->bind_param('i', $id_rvc))
		die("Error en el parametro para los datos del comprobante");
	$stmt_venta->execute();
	$stmt_venta->store_result();
	if($stmt_venta->num_rows!=1)
		die("No se econtro registro de comprobante para el id indicado");
	$stmt_venta->bind_result($id_cli, $id_tipcmp, $tipodoccp_rvi, $seriecp_rvi, $numcp_rvi, $nom_rzs_cli, $email_cli);
	$stmt_venta->fetch();
	$sale=new BaseSale();
	$sale->setTipoDoc($id_tipcmp)
		->setSerie($seriecp_rvi)
		->setCorrelativo($numcp_rvi)
		->setCompany(
			(new Company())
				->setRuc($empresa['ndoc_empe'])
		);
	try{
		if(empty($email_cli))
			throw new Exception("El email se encuentra vacio");
		$file_pdf=sprintf("%s%s.pdf", PATH_SUNAT, $sale->getName());
		if(!file_exists($file_pdf))
			throw new Exception("El archivo .pdf no existe");
		$mail = new PHPMailer();
		$mail->SetFrom(correo2, 'No Reply');
		$mail->AddAddress($email_cli, utf8_decode($nom_rzs_cli));
		$mail->Subject = sprintf("%s - ",$empresa['nomb_empe'], $tipodoccp_rvi);
		$mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
		$mail->MsgHTML("<h1>Testing HTML <strong>BODY</strong></h1>");
		$mail->AddAttachment($file_pdf);
		if(!$mail->Send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
			echo sprintf("Message sent to: %s", $email_cli);
		}  
	}catch(Exception $e){
		echo $e->getMessage();
	}
}
?>