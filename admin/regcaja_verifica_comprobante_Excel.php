<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
//--------- Usado con el servicio billConsultService, actualmente inactivo --------------
//Librerias necesarias para la consulta de comprobantes de SUNAT
// require_once './class/vendor/autoload.php';
// use Greenter\Ws\Services\ConsultCdrService;
// use Greenter\Ws\Services\SoapClient;

$ambito_busqueda="Todo";
$cadenasql=conversion_a_consulta($_GET["v1"]);
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=archivo.xls");
?>
<!DOCTYPE HTML>
<html>
	<head><?php	pestanna_01($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Reporte de Ventas");?></head>
	<body>
		<div id="main-col2" style="padding:15px; margin-left:5px">
			<div style="font-size:10px"><?php nombre_comercial_empresa();?> : <?php echo gmdate("j F Y, g:i a",time()+3600*(-6+date("I")));?></div>
			<center><h2 style="color:#0A2C4F">Reporte de Registro de Caja(SUNAT)</h2></center> 
			<?php
			//--------- Usado con el servicio billConsultService, actualmente inactivo --------------
			// $wsdlUrl = 'https://e-factura.sunat.gob.pe/ol-it-wsconscpegem/billConsultService?wsdl';
			// $soap = new SoapClient($wsdlUrl);
			// $service = new ConsultCdrService();
			$token = obtener_token();
			$sql_catalogo= mysqli_query ($Conexion,$cadenasql) or die ("Error al traer los datos");
			//--------- Usado con el servicio billConsultService, actualmente inactivo --------------
			// tbl_verificar_comprobante_sunat_Excel($Conexion,"margin-left:0px;",$sql_catalogo,$ambito_busqueda,$soap,$service,
			// "ID:id_rvc:50:N",
			// "Fecha Emisión:fechaemi_rvi:100:N",
			// "Documento:tipodoccp_rvi:100:cod_comprobante|",
			// "Serie:id_rvc:50:serie_ce|",
			// "Numero:id_rvc:100:numero_ce|",
			// "Cliente:id_cli:200:valfield|clientes|nom_rzs_cli|id_cli",
			// "DNI/RUC:id_cli:100:valfield|clientes|dni_ruc_cli|id_cli",
			// "Estad.Comp.:estado_rvc:150:N",
			// "NotaCred.:estado_rvc:200:nota_credito|id_rvc",
			// "Validez Comp.:comprobante:150:verifica_comprobante|",
			// "IGV:estado_rvc:100:res_anulado|igv_rvi",
			// "Importe:estado_rvc:100:res_anulado|importetot_rvi");
			
			tbl_validez_comprobante_sunat_Excel($Conexion,"margin-left:0px;",$sql_catalogo,$ambito_busqueda,$token,
			"ID:id_rvc:50:N",
			"Fecha Emisión:fechaemi_rvi:100:N",
			"Documento:tipodoccp_rvi:100:cod_comprobante|",
			"Serie:id_rvc:50:serie_ce|",
			"Numero:id_rvc:100:numero_ce|",
			"Cliente:id_cli:200:valfield|clientes|nom_rzs_cli|id_cli",
			"DNI/RUC:id_cli:100:valfield|clientes|dni_ruc_cli|id_cli",
			"Estad.Comp.:estado_rvc:150:N",
			"NotaCred.:estado_rvc:200:nota_credito|id_rvc",
			"Validez Comp.:comprobante:250:verifica_comprobante|",
			"IGV:estado_rvc:100:res_anulado|igv_rvi",
			"Importe:estado_rvc:100:res_anulado|importetot_rvi");
			
			scroll_doble("div1", "div2");
			?>
		</div>
	</body>
</html>