<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
//Recoge variable con datos del formulario padre para usarlo en la impresión
$id=$_GET['id'];
$f=0.5;//factor de pixeles
$a=540;//ancho en pixeles
$consulta_comprobante=sql_comprobante($id);
?>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Impresión de Comprobante");?></head>
	<body style="background-color:white; color:black;">
		<div id="main-col3" style="width:270px; height:610px; font-size:<?php echo tf(24,$f);?>px; padding-left:10px; padding-right:10px;">
			<?php
			//----------------------------------------------------------- Consultar -----------------------------------------------------------
			date_default_timezone_set('America/Lima');
			$sql= mysqli_query ($Conexion,$consulta_comprobante) or die ("Error al realizar la consulta en de regvtacaja para comprobantes");
			$num_filas=mysqli_num_rows($sql);
			if($num_filas>0)
			{
				mysqli_data_seek($sql, 0);
				$r=mysqli_fetch_array($sql, MYSQLI_ASSOC);
				//Datos de cabecera
				$id_rvc=$r["id_rvc"];
				$fechaemi_rvi=$r["fechaemi_rvi"];
				$horaemi_rvi=$r["horaemi_rvi"];
				$seriecp_rvi=$r["seriecp_rvi"];
				$numcp_rvi=$r["numcp_rvi"];
				$tipodoccp_rvi=$r["tipodoccp_rvi"];
				$id_undc=$r["id_undc"]; 
				$desc_undc=$r["desc_undc"];
				$id_usr=$r["id_usr"];
				$nomb_usr=$r["nomb_usr"];
				$tipo_comprobante=tipocomprob($tipodoccp_rvi);
				$numero_comprobante=serie_numero_comprob($tipodoccp_rvi,$seriecp_rvi,$numcp_rvi);
				$nom_rzs_cli=$r["nom_rzs_cli"];
				$dni_ruc_cli=$r["dni_ruc_cli"]; if ($dni_ruc_cli=="00000000") $dni_ruc_cli="";
				$direcc_cli=$r["direcc_cli"]; if ($direcc_cli=="-") $direcc_cli="";
				//Datos del total y del pie de reporte impreso
				$importetot_caja=$r["importetot_caja"];
				$igv_caja=$r["igv_caja"];
				$nombre_empresa=$r["nomb_empe"];
				$numero_documento=$r["ndoc_empe"];
				$direccion_empresa=$r["dir_empe"];
				$distrito_empresa=$r["dist_empe"];
				$zona_rvi=$r["zona_rvi"];
				if ($zona_rvi=="JUNCD12")
				{
					$direccion_empresa="Jr. Progreso 256";
					$distrito_empresa="San Ramón";
				}
				?>
				<!---------------------------------------------------- FORMULARIO -------------------------------------------------->
				<form name="usuario" action="" method="post">
					<!----------------------------------CABECERA---------------------------------->
					<div style="width:260px; height:52px; margin-left:auto; margin-right:auto; background-image: url('../imagenes/logo_cabecera_heli_impresion.png');"></div>
					<div style="width:<?php echo tf($a,$f);?>px; text-align:center; font-family:Consolas; font-size:<?php echo tf(15,$f);?>px; font-weight:bold; height:<?php echo tf(75,$f);?>px;"> <?php
						//echo "<br>";
						echo $nombre_empresa,"<br>";
						echo "RUC ",$numero_documento,"<br>";
						echo $direccion_empresa," - ",$distrito_empresa,"<br>";?>
					</div>
					<div style="text-align:center; font-weight:bold;"><?php
						echo $tipo_comprobante.":".$numero_comprobante;?>
					</div>
					<div style="width:<?php echo tf($a,$f);?>px; text-align:center; height:25px;"><?php
						echo $desc_undc," <br>";
						echo "DISTRIBUIDOR AUTORIZADO";?>
					</div>
					<div style="width:<?php echo tf($a,$f);?>px; font-family:Consolas; text-align:center;"><?php 
						echo "----------------------------------------";?>
					</div>
					<div style="width:<?php echo tf($a,$f);?>px; text-align:center; height:145px;"><?php
						echo "<b>RCS (Sistema): </b>",substr("00000".(string)$id_rvc,-5),"<br>";
						echo "<b>USUARIO: </b>",substr("00".(string)$id_usr,-2),"-",$nomb_usr,"<br>";
						echo "<b>FECHA EMISIÓN: </b>",invFech($fechaemi_rvi,"-"),"<br>";
						//echo "<b>HORA EMISIÓN: </b>",date("H:i:s", time()),"<br>";
						echo "<b>HORA EMISIÓN: </b>",$horaemi_rvi,"<br>"; $font_size = (strlen($nom_rzs_cli) > 20) ? 'font-family:"Arial Narrow",Arial,sans-serif; font-stretch:condensed;' : null;
						echo "<b>CLIENTE: </b><span style='white-space:nowrap;$font_size;'>",$nom_rzs_cli, "</span><br>"; 
						echo "<b>DIRECCION: </b><span>",$direcc_cli, "</span><br>";
						echo "<b>RUC/DNI: </b>",$dni_ruc_cli, "<br>";?>
						<div style="width:<?php echo tf($a,$f);?>px; font-family:Consolas; text-align:center;"><?php 
						    echo "----------------------------------------";?>
					    </div>
					</div>
					<!----------------------------------CUERPO---------------------------------->
					<table border='0' cellspacing='0' cellpadding='0' style="table-layout:fixed; width:270px; font-family:Arial Narrow; font-size:10px;">
						<tr>
							<th width='18' style="background:RGB(255,255,255);">Cod.</th>
							<th width='79' style="background:RGB(255,255,255);">Descripción</th>
							<th width='5' style="background:RGB(255,255,255);">Cnt.</th>
							<th width='29' style="background:RGB(255,255,255);">P.U.</th>
							<th width='29' style="background:RGB(255,255,255);">Importe</th>
						</tr><?php
						$subtotal=0;
						mysqli_data_seek($sql, 0);
						while($r=mysqli_fetch_array($sql, MYSQLI_ASSOC))
						{ 
							$id_pro=$r["id_pro"];
							$abrv_pro=$r["abrv_pro"];
							$imei_pro=$r["imei_pro"]; if (empty($imei_pro) OR $imei_pro=="-" OR $imei_pro=="." OR $imei_pro==":" OR $imei_pro=="0") $imei_pro="";
							$icc_pro=$r["icc_pro"]; if (empty($icc_pro) OR $icc_pro=="-" OR $icc_pro=="." OR $icc_pro==":" OR $icc_pro=="0") $icc_pro="";
							$cod_imei_icc=$imei_pro.$icc_pro;
							if (empty($cod_imei_icc))
							{
								$cod_imei_icc="";
							}
							else
							{
								$cod_imei_icc="<br>".$cod_imei_icc;
							}
							$baseimpopgrv_rvi=$r["baseimpopgrv_rvi"];
							$importetot_rvi=$r["importetot_rvi"];
							?>
							<tr>
								<td width='18'><?php echo convert6car($id_pro);?></td>
								<td width='75'><?php echo $abrv_pro,$cod_imei_icc;?></td>
								<td width='7'><?php echo "1";?></td>
								<td width='30' style="text-align:right;"><?php echo number_format($baseimpopgrv_rvi, 2, '.', '');?></td> 
								<td width='30' style="text-align:right;"><?php echo number_format($baseimpopgrv_rvi*1, 2, '.', '');?></td>
							</tr><?php
							$subtotal=$subtotal+$baseimpopgrv_rvi*1;
						}?>
						<tr>
							<td colspan="5" style="font-family:Consolas; font-size:12px; padding:0px;">
							<?php echo "----------------------------------------";?></td>
						</tr>
						<tr>
							<td colspan="4" width='130' style="text-align:right;">Total S/</td>
							<td width='30' style="text-align:right;"><?php echo number_format($subtotal, 2, '.', '');?></td>
						</tr>
						<tr>
							<td colspan="4" width='130' style="text-align:right;">IGV S/</td>
							<td width='30' style="text-align:right;"><?php echo number_format($igv_caja, 2, '.', '');?></td> 
						</tr>
						<tr>
							<td colspan="4" width='130' style="text-align:right;">Importe Total S/</td>
							<td width='30' style="text-align:right;"><?php echo number_format($importetot_caja, 2, '.', '');?></td>
						</tr>
					</table>
					<div style="width:<?php echo tf($a,$f);?>px; font-family:Consolas; text-align:center;"><?php 
						echo "----------------------------------------<br>";?>
					</div>
					<div style="font-family:Arial Narrow; font-size:11px; Height:30px; display:table-cell; vertical-align:middle;">
						<?php echo "<b>SON: </b>",numtoletras($importetot_caja),"<br>";?>
					</div>
					<div style="width:<?php echo tf($a,$f);?>px; font-family:Consolas; text-align:center;">
						<?php echo "----------------------------------------<br>";?>
					</div>
					<!----------------------------------PIE---------------------------------->
					<div style="font-family:Consolas; font-size:<?php echo tf(23,$f);?>px; Height:50px; display:table-cell; vertical-align:middle;">
						<center><?php echo "Representación impresa del comprobante electrónico.";?></center>
					</div>
					<div style="width:<?php echo tf($a,$f);?>px; font-family:Consolas; text-align:center;">
						<?php echo "----------------------------------------<br>";?>
					</div>
					<div style="width:<?php echo tf($a,$f);?>px; font-family:Consolas; font-size:<?php echo tf(23,$f);?>px; height:80px; text-align:center; display:table-cell; vertical-align:middle;">
						<?php echo razon_social_rubro,"<br>";?>
						<?php echo "GRACIAS POR SU PREFERENCIA <br><br>";?>
					</div>
				</form>
				<!------------------------------------FIN DE FORMULARIO---------------------------------><?PHP
			}
			else
			{
			    //echo $consulta_comprobante."<br>";
				echo "<script> alert('No hay datos para imprimir el comprobante'); window.close(); </script>";
				//echo "<script> alert('No hay datos para imprimir el comprobante'); </script>";
			}
			?>
		</div>
	</body>
</html>
<?php
function tipocomprob($tipo)
{
	$descrip_tipo="";
	if ($tipo=="Boleta de venta")
	{
		$descrip_tipo="BOLETA ELECTRONICA";
	}
	if ($tipo=="Factura")
	{
		$descrip_tipo="FACTURA ELECTRONICA";
	}
	return $descrip_tipo;
}
function serie_numero_comprob($tipo,$serie,$numero)
{
	$inicial="";
	if ($tipo=="Boleta de venta")
	{
		$inicial="B";
	}
	if ($tipo=="Factura")
	{
		$inicial="F";
	}
	$ser=$inicial.substr("000".$serie, -3);
	$num=substr("00000000".$numero, -8);
	return $ser."-".$num;
}
function sql_comprobante($id)
{
	return "SELECT a.id_rvi, a.id_cli, a.id_pro, 
	a.baseimpopgrv_rvi, a.igv_rvi, a.importetot_rvi, a.id_udint, a.id_tipmnd, a.id_tipisc, a.id_cdaf, a.id_tipopr, a.descrip_rvi, 
	b.id_rvc, b.tipopla_rvi, b.id_pla, b.fechaemi_rvi, b.horaemi_rvi, b.fechaven_rvi, b.codcpg_rvi, b.tipodoccp_rvi, 
	b.seriecp_rvi, b.numcp_rvi, b.formapago_rvi, b.baseimpopngrv_rvi, b.isc_rvi, b.id_usr, b.rgpag_rvc, 
	b.zona_rvi, b.estado_rvc, b.fechapag_rvc, b.id_usr_anula, b.causanul_rvc, b.cee_rvc, b.causamant_rvc, 
	b.id_rvc, b.descrip_rvi AS descrip_caja, b.baseimpopgrv_rvi AS baseimpopgrv_caja, b.igv_rvi AS igv_caja, b.importetot_rvi AS importetot_caja, 
	b.id_ubi, b.id_undc, b.id_tipcmp, b.id_empe, b.id_tipdoc, b.id_elad, 
	c.cod_udint, 
	d.cod_tipmnd, 
	e.cod_tipisc, 
	f.cod_cdaf, 
	g.cod_tipopr, 
	h.cod_ubi, 
	i.codfiscal_undc, i.seriedoc_undc, i.desc_undc, 
	j.cod_tipcmp, 
	k.nomb_empe,k.nmbc_empe,k.ndoc_empe,k.id_ubi,k.dir_empe,k.urb_empe,k.dist_empe,k.prov_empe,k.region_empe,k.codpais_empe, 
	l.cod_tipdoc, 
	m.cod_elad, 
	n.dni_ruc_cli, n.nom_rzs_cli, n.direcc_cli, 
	o.abrv_pro, o.imei_pro, o.icc_pro, 
	p.nomb_usr 
	FROM regventas a 
	LEFT JOIN regvtacaja b ON (a.seriecp_rvi=b.seriecp_rvi AND a.numcp_rvi=b.numcp_rvi AND a.codcpg_rvi=b.codcpg_rvi) 
	LEFT JOIN undinternac c ON a.id_udint=c.id_udint 
	LEFT JOIN tipomoned d ON a.id_tipmnd=d.id_tipmnd 
	LEFT JOIN tiposistisc e ON a.id_tipisc=e.id_tipisc 
	LEFT JOIN codafect f ON a.id_cdaf=f.id_cdaf 
	LEFT JOIN tipoperac g ON a.id_tipopr=g.id_tipopr 
	LEFT JOIN ubigeo h ON b.id_ubi=h.id_ubi 
	LEFT JOIN undcomerc i ON b.id_undc=i.id_undc 
	LEFT JOIN tipocomprob j ON b.id_tipcmp=j.id_tipcmp 
	LEFT JOIN empemisor k ON b.id_empe=k.id_empe 
	LEFT JOIN tipodocident l ON b.id_tipdoc=l.id_tipdoc 
	LEFT JOIN elemadicion m ON b.id_elad=m.id_elad 
	LEFT JOIN clientes n ON a.id_cli=n.id_cli 
	LEFT JOIN productos o ON a.id_pro=o.id_pro 
	LEFT JOIN usuarios p ON b.id_usr=p.id_usr 
	WHERE id_rvc='$id'";
}
?>