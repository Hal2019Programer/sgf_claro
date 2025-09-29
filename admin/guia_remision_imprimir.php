<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
$id=$_GET['id'];
$f=0.5;//factor de pixeles
$a=1000;//ancho en pixeles
$consulta_comprobante=sql_comprobante($id);
?>
<style>
	table
	{
		padding:0px;
		margin:0px;
		border-collapse: none;
		border-style: hidden;
		border-color: black;
		border-spacing: 0px;
		border-width: thin;
	}
	tr
	{
		padding:0px;
		margin:0px;
		border-collapse: collapse;
		border-style: solid;
		border-color: black;
		border-spacing: 0px;
		border-width: thin;
	}
	td
	{
		padding:0px;
		margin:0px;
		border-collapse: collapse;
		border-style: hidden;
		border-color: black;
		border-spacing: 0px;
		border-width: thin;
		border-radius: 3px;
	}
	th
	{
		background:RGB(255,255,255); 
		border-style:solid; 
		border-width:thin; 
		border-radius:5px;
	}
</style>
<!DOCTYPE HTML>
<html style="background-color:RGB(255,255,255);">
	<head><?php //pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Impresión de Guia de Remision");?></head>
	<body>
		<div id="main-col3" style="width:708px; height:610px; font-size:<?php echo tf(24,$f);?>px; padding-left:10px; padding-right:10px;">
			<?php
			//----------------------------------------------------------- Consultar -----------------------------------------------------------
			date_default_timezone_set('America/Lima');
			$sql= mysqli_query ($Conexion,$consulta_comprobante) or die ("Error al realizar la consulta de guia_remision.");
			if(mysqli_num_rows($sql)>0)
			{
				mysqli_data_seek($sql, 0);
				$r=mysqli_fetch_array($sql, MYSQLI_ASSOC);
				//Datos de cabecera
				$id_gr_detalle=$r["id_gr_detalle"];
				$id_gr=$r["id_gr"];
				$serie_gr=$r["serie_gr"];
				$numero_gr=$r["numero_gr"];
				$fechtrasl_gr=$r["fechtrasl_gr"]; 
				$znaorig_gr=$r["znaorig_gr"];
				$znadest_gr=$r["znadest_gr"];
				$id_usr=$r["id_usr"];
				$usuario=$r["usuario"];
				$motivo_trasl_gr=$r["motivo_trasl_gr"];
				$ruc_transp_gr=$r["ruc_transp_gr"];
				$descrip_transp_gr=$r["descrip_transp_gr"];
				$marca_placa_transp_gr=$r["marca_placa_transp_gr"]; 
				$licen_conduc_transp_gr=$r["licen_conduc_transp_gr"];
				$montotransf_gr=$r["montotransf_gr"];
				//Datos de la empresa
				$nombre_empresa="ECOSITI S.A.C.";
				$ruc_empresa="20602109225";
				$direccion_distrito=$r["direc_zna_origen"]; $dd=explode("-",$direccion_distrito);
				$direccion_empresa=trim($dd[0]);	//$direccion_empresa="Jr. Manuel Prado Nro. 383";
				$distrito_empresa=trim($dd[1]); //$distrito_empresa="Satipo";
				$direc_origen=$r["direc_zna_origen"];
				$direc_destino=$r["direc_zna_destino"];
				?>
				
				<!---------------------------------------------------- FORMULARIO -------------------------------------------------->
				<form name="usuario" action="" method="post">
					<!----------------------------------CABECERA---------------------------------->
					<table style="width:100%;">
						<tr style="font-family:Consolas; font-size:12px; text-align:center;">
							<td style="width:240px;">
								<div style="height:80px; margin-left:auto; margin-right:auto; background-image:url('../imagenes/logo_cabecera_impresion.png'); padding-left:0px; padding-right:0px;"></div>
							</td >
							<td style="width:10px;">&nbsp;</td>
							<td style="border-style:solid;">
								<div style="text-align:center; font-family:Consolas; font-size:12px; font-weight:bold; height:50px;"><?php
									echo $nombre_empresa,"<br>";
									echo "RUC ",$ruc_empresa,"<br>";
									echo $direccion_empresa," - ",$distrito_empresa,"<br>";?>
								</div>
								<div style="text-align:center; font-weight:bold; font-size:16px;"><?php
									echo "GUIA DE REMISION:".num_zeros($serie_gr,3)."-".num_zeros($numero_gr,5);?>
								</div>
							</td>
						</tr>
					</table><br>
					<table style="width:100%;">
						<tr style="font-family:Consolas; font-size:12px; text-align:center; height:30px;">
							<td style="width:32%; border-style:solid;">
								<?php	echo "<b>RGR (Sistema): </b>",num_zeros($id_gr,5),"<br>";?>
							</td>
							<td style="width:1%"></td>
							<td style="width:32%; border-style:solid;">
								<?php echo "<b>USUARIO: </b>",$usuario,"<br>"; ?>
							</td>
							<td style="width:1%"></td>
							<td style="width:33%; border-style:solid;">
								<?php echo "<b>FECHA TRASLADO: </b>",invFech($fechtrasl_gr,"-"),"<br>";?>
							</td>
						</tr>
					</table><div style="height:5px;"></div>
					<table style="width:100%;">
						<tr style="height:30px;">
							<td style="width:49%; border-style:solid;">
								<div style="text-align:center;">
									<?php	echo "<b>ORIGEN: </b>",$znaorig_gr."<br>".$direc_origen, "<br>";?>
								</div>
							</td>
							<td style="width:1%"></td>
							<td style="width:50%; border-style:solid;">
								<div style="text-align:center;">
									<?php echo "<b>DESTINO: </b>",$znadest_gr."<br>".$direc_destino, "<br>"; ?>
								</div>
							</td>
						</tr>
					</table><div style="height:5px;"></div>
					<table style="width:100%;">
						<tr style="height:30px;">
							<td style="border-style:solid;">
								<div>
									<?php echo "<b>MOTIVO TRASLADO: </b>",$motivo_trasl_gr, "<br>";?>
								</div>
							</td>
						</tr>
					</table><div style="height:5px;"></div>
					<table style="width:100%;">
						<tr style="font-family:Arial Narrow; font-size:12px; text-align:center; height:30px;">
							<td style="width:20%; border-style:solid;">
								<div>
									<?php echo "<b>RUC TRANSP.: </b>",$ruc_transp_gr, "<br>"; ?>
								</div>
							</td>
							<td style="width:30%; border-style:solid;">
								<div>
									<?php echo "<b>TRANSP.: </b>",$descrip_transp_gr, "<br>"; ?>
								</div>
							</td>
							<td style="width:25%; border-style:solid;">
								<div>
									<?php echo "<b>MARCA/PLACA: </b>",$marca_placa_transp_gr, "<br>"; ?>
								</div>
							</td>
							<td style="width:25%; border-style:solid;">
								<div>
									<?php echo "<b>LICENC.CONDUCIR: </b>",$licen_conduc_transp_gr, "<br>"; ?>
								</div>
							</td>
						</tr>
					</table><br>
					<!----------------------------------CUERPO---------------------------------->
					<table style="width:100%; table-layout:fixed; font-family:Arial Narrow; font-size:12px;">
						<tr style="height:30px;">
							<th width='60'>Cod.</th>
							<th width='170'>Serie/Imei/Icc</th>
							<th width='260'>Descripción</th>
							<th width='25'>Cnt.</th>
						</tr><?php
						mysqli_data_seek($sql, 0);
						while($r=mysqli_fetch_array($sql, MYSQLI_ASSOC))
						{
							$id_pro=$r["id_pro"];
							$abrv_pro=$r["abrv_pro"];
							$serie_pro=$r["serie_pro"]; $serie_pro=revisar_vacio($serie_pro);
							$imei_pro=$r["imei_pro"]; $imei_pro=revisar_vacio($imei_pro);
							$icc_pro=$r["icc_pro"]; $icc_pro=revisar_vacio($icc_pro);
							$serie_imei_icc=$serie_pro.$imei_pro.$icc_pro;
							$cant_pro_gr=$r["cant_pro_gr"];
							?>
							<tr style="height:30px; border-style:solid;">
								<td width='60' style="padding-left:5px;"><?php echo convert6car($id_pro);?></td>
								<td width='170' style="padding-left:5px;"><?php echo $serie_imei_icc;?></td>
								<td width='260' style="padding-left:5px;"><?php echo $abrv_pro;?></td>
								<td width='25' style="padding-left:5px;"><?php echo $cant_pro_gr;?></td> 
							</tr><?php
						}?>
					</table><br><br><br><hr>
					<!----------------------------------PIE---------------------------------->
					<div style="width:100%; font-family:Consolas; font-size:12px; Height:50px; text-align:center; vertical-align:middle;">
						<center><?php echo "Representación impresa de la Guía de Remisión.";?></center>
					</div><br>
					<div style="font-family:Consolas; font-size:12px; height:80px; text-align:center; vertical-align:middle;">
						<?php echo razon_social_rubro,"<br>";?>
						<?php echo "GRACIAS POR SU PREFERENCIA <br><br>";?>
					</div>
				</form>
				<!------------------------------------FIN DE FORMULARIO---------------------------------><?PHP
			}
			else
			{
				echo "<script> alert('No hay datos para imprimir el comprobante'); window.close(); </script>";
				//echo "<script> alert('No hay datos para imprimir el comprobante'); </script>";
			}
			?>
		</div>
	</body>
</html>
<?php
function sql_comprobante($id)
{
	return "SELECT 
	a.id_gr_detalle, a.id_pro, a.cant_pro_gr, 
	b.id_gr, b.serie_gr, b.numero_gr, b.fechtrasl_gr, b.znaorig_gr, b.znadest_gr, b.id_usr, b.motivo_trasl_gr, b.ruc_transp_gr, b.descrip_transp_gr, b.marca_placa_transp_gr, b.licen_conduc_transp_gr, b.montotransf_gr, 
	CONCAT(c.id_usr,':',c.nomb_usr) AS usuario, 
   d.serie_pro, d.imei_pro, d.icc_pro, d.abrv_pro, 
	e.direc_zna AS direc_zna_origen, 
	f.direc_zna AS direc_zna_destino 
	FROM guia_remis_detalle a 
	LEFT JOIN guia_remis b ON a.id_gr=b.id_gr 
	LEFT JOIN usuarios c ON c.id_usr=b.id_usr 
   LEFT JOIN productos d ON a.id_pro=d.id_pro 
	LEFT JOIN zona e ON b.znaorig_gr=e.nomb_zna 
	LEFT JOIN zona f ON b.znadest_gr=f.nomb_zna 
	WHERE a.id_gr='$id'";
}
function num_zeros($numero,$num_zeros)
{
	$cad_zeros="";
	for ($i=0; $i<$num_zeros; $i++) $cad_zeros="0".$cad_zeros;
	return substr($cad_zeros.(string)$numero,-$num_zeros);
}
function revisar_vacio($dato)
{
	if (empty($dato) OR $dato=="-" OR $dato=="." OR $dato==":" OR $dato=="0") $dato="";
	return $dato;
}
?>