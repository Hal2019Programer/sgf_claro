<?php
include("../library/funcionA.php"); include("../library/funcionB.php"); include("../library/datos.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
require_once ('class/vendor/tecnickcom/tcpdf/tcpdf.php');
$consultasql=$_GET['cadconsulta'];
$where_as = $order_by = "";
//---------------------------------------------- Calculo de tamaño de elementos x factor ----------------------------------------------
$factor=0.65;
$anch_id_pro=45*$factor;
$anch_tipo_cat=65*$factor;
$anch_clase_cat=75*$factor;
$anch_id_cat=195*$factor;
$anch_imei_pro=125*$factor;
$anch_icc_pro=125*$factor;
$anch_precio_pro=50*$factor;
$anch_fechreg_pro=60*$factor;
$anch_activ_pro=25*$factor;
$anch_zona_pro=65*$factor;
$anch_nom_rzs_prv=110*$factor;
$anch_precionormal_prv=60*$factor;
$anch_precio_anterior_pro=60*$factor;
$anch_precio_antes_anterior_pro=60*$factor;
$anchtabla=$anch_id_pro+$anch_tipo_cat+$anch_clase_cat+$anch_id_cat+$anch_imei_pro+$anch_icc_pro+$anch_precio_pro+$anch_fechreg_pro+$anch_activ_pro+$anch_zona_pro+$anch_nom_rzs_prv+$anch_precionormal_prv+$anch_precio_anterior_pro+$anch_precio_antes_anterior_pro;
$estilo_maincol="width:".($anchtabla+10)."px; font-size:10px; padding:0px; margin:0px; font-family:Consolas;";
$estilo_tabla="table-layout:fixed; width:".$anchtabla."px;";
//---------------------------------------------- Consulta de productos con o sin filtro ----------------------------------------------
if (!empty($consultasql))
{
	$nuevo_consulta=conversion_a_consulta($consultasql);
	obtener_where_y_orderBy($nuevo_consulta, $where_as, $order_by);
	$sql= mysqli_query ($Conexion,$nuevo_consulta) or die ("Error al realizar la consulta filtrada");
}
else
{
	$varfac=date("Y-m-d");
	$sql= mysqli_query ($Conexion,"SELECT p.*, pr.* FROM productos p LEFT JOIN proveedores pr ON p.id_prv=pr.id_prv ORDER BY p.tipo_cat ASC, p.clase_cat ASC, p.marca_cat ASC, p.modelo_cat ASC, p.imei_pro ASC, p.icc_pro ASC, p.fechreg_pro DESC LIMIT 1000") or die ("Error al traer los datos de consulta de productos");
}
//---------------------------------------------- Calculo de conteos ----------------------------------------------
//conteo de zonas
$ct_act=$ct_nac=0;//conteo de activos y no activos
$ct_equ=$ct_mod=$ct_chp=$ct_rec=$ct_tab=$ct_srv=$ct_acc=$ct_otr=0;//conteo de grupos
$ct_hnd=$ct_sph=$ct_mdm=$ct_pck=$ct_smb=$ct_bsm=$ct_bfr=$ct_bcm=$ct_uni=$ct_rou=$ct_rtj=$ct_rvr=$ct_tbl=$ct_sdc=$ct_aur=$ct_crs=$ct_cst=$ct_prp=$ct_mgr=$ct_cmp=$ct_bjl=$ct_dsb=$ct_rcf=$ct_ots=0;//conteo de tipos
// Conteos de zonas, activos, tipos y clases
contar_cant_en_campo($Conexion, "zona_pro", "productos", $array_valor_de_zonas, $resultado_contar_zonas, $where_as, $order_by);
contar_cant_en_campo($Conexion, "activ_pro", "productos", $array_valor_de_activos, $resultado_contar_activos, $where_as, $order_by);
contar_cant_en_campo($Conexion, "tipo_cat", "productos", $array_valor_de_tipoCategoria, $resultado_contar_tipos, $where_as, $order_by);
contar_cant_en_campo($Conexion, "clase_cat", "productos", $array_valor_de_claseCategoria, $resultado_contar_clases, $where_as, $order_by);
cargar_en_variables_de_tipo_resultados_conteo($array_valor_de_tipoCategoria, $resultado_contar_tipos, 
$ct_equ, $ct_mod, $ct_chp, $ct_rec, $ct_tab, $ct_srv, $ct_acc, $ct_otr);
cargar_en_variables_de_clase_resultados_conteo($array_valor_de_claseCategoria, $resultado_contar_clases,
$ct_hnd, $ct_sph, $ct_mdm, $ct_pck, $ct_smb, $ct_bsm, $ct_bfr, $ct_bcm, $ct_uni, $ct_rou, $ct_rtj, $ct_rvr, $ct_tbl, $ct_sdc, 
$ct_aur, $ct_crs, $ct_cst, $ct_prp, $ct_mgr, $ct_cmp, $ct_bjl, $ct_dsb, $ct_rcf, $ct_kbv, $ct_kbf, $ct_kbd, $ct_kbu, $ct_ots);
$mostrar_resultados_zona = mostrar_resultados_conteo_PDF($array_valor_de_zonas, $resultado_contar_zonas);
$mostrar_resultados_activos =  mostrar_resultados_conteo_activos_PDF($array_valor_de_activos, $resultado_contar_activos);
mysqli_data_seek($sql, 0);
$fila_tr="";
while($r = mysqli_fetch_array($sql, MYSQLI_ASSOC))
{
	$vi_id_pro=$r["id_pro"];
	$vi_tipo_cat=$r["tipo_cat"];
	$vi_clase_cat=$r["clase_cat"];
	$vi_abrv_cat=$r["abrv_pro"];
	$vi_imei_pro=$r["imei_pro"];
	$vi_icc_pro=$r["icc_pro"];
	$vi_precio_pro=$r["precio_pro"];
	$vi_fechreg_pro=$r["fechreg_pro"];
	$vi_activ_pro=$r["activ_pro"];
	$vi_zona_pro=$r["zona_pro"];
	$fila_tr = $fila_tr."
	<tr valign='top' style='padding-top:0px; padding-bottom:0px; height: 5px;'>
	<td>$vi_id_pro</td>
	<td>$vi_tipo_cat</td>
	<td>$vi_clase_cat</td>
	<td>$vi_abrv_cat</td>
	<td>$vi_imei_pro</td>
	<td>$vi_icc_pro</td>
	<td>$vi_precio_pro</td>
	<td>$vi_fechreg_pro</td>
	<td>$vi_activ_pro</td>
	<td>$vi_zona_pro</td>
	</tr>";
}
?>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Impresion de reporte 03 PDF");?></head>
	<body>
		<?php
		$pagina='
		
			<h2 align="center">Reporte de Almacén</h3><br>
			<hr>
			<table border="0" cellspacing="0" cellpadding="0" style="font-size:9pt;">
				<tr>
					<th width="20%">
						<span id="etq1">ZONA:</span><br>'
						.$mostrar_resultados_zona.'
						<span id="etq1">EXISTENCIAS:</span><br>'
						.$mostrar_resultados_activos.'
					</th>
					<th width="20%">
						<span id="etq1">GRUPO:</span><br>
						<span id="etq4">Equipo=</span>'.$ct_equ.'<br>
						<span id="etq4">Modem=</span>'.$ct_mod.'<br>
						<span id="etq4">Chip=</span>'.$ct_chp.'<br>
						<span id="etq4">Recarga=</span>'.$ct_rec.'<br>
						<span id="etq4">Tableta=</span>'.$ct_tab.'<br>
						<span id="etq4">Servicios=</span>'.$ct_srv.'<br>
						<span id="etq4">Accesorios=</span>'.$ct_acc.'<br>
						<span id="etq4">Otros=</span>'.$ct_otr.'
					</th>
					<th width="60%">
						<span id="etq5">TIPO:</span><br>
						<span id="etq5">Handset=</span>'.$ct_hnd.'
						<span id="etq5" style="width:110px;">Smartphone=</span>'.$ct_sph.'<br>
						<span id="etq5">Modem=</span>'.$ct_mdm.'
						<span id="etq5" style="width:90px;">Router=</span>'.$ct_rou.'<br>
						<span id="etq5">PackConnect=</span>'.$ct_pck.'
						<span id="etq5" style="width:100px;">SIM Mobile=</span>'.$ct_smb.'
						<span id="etq5" style="width:80px;">BSmart=</span>'.$ct_bsm.'
						<span id="etq5" style="width:80px;">BFree=</span>'.$ct_bfr.'
						<span id="etq5" style="width:80px;">BCombo=</span>'.$ct_bcm.'
						<span id="etq5" style="width:50px;">Uni=</span>'.$ct_uni.'<br>
						<span id="etq5">Rec.Tarjeta=</span>'.$ct_rtj.'
						<span id="etq5" style="width:100px;">Rec.Virtual=</span>'.$ct_rvr.'<br>
						<span id="etq5">Tablet=</span>'.$ct_tbl.'<br>
						<span id="etq5">Migracion=</span>'.$ct_mgr.'
						<span id="etq5" style="width:105px;">CambioPlan=</span>'.$ct_cmp.'
						<span id="etq5" style="width:105px;">BajaLinea=</span>'.$ct_bjl.'
						<span id="etq5" style="width:120px;">Desbloqueo=</span>'.$ct_dsb.'
						<span id="etq5" style="width:110px;">Reconfigur=</span>'.$ct_rcf.'<br>
						<span id="etq5">SD Card=</span>'.$ct_sdc.'
						<span id="etq5" style="width:100px;">Auricular=</span>'.$ct_aur.'
						<span id="etq5" style="width:105px;">CarcasaSmpl=</span>'.$ct_crs.'
						<span id="etq5" style="width:105px;">CarcasaTapa=</span>'.$ct_cst.'
						<span id="etq5" style="width:105px;">ProtectPant=</span>'.$ct_prp.'<br>
						<span id="etq5">Otros=</span>'.$ct_ots.'
					</th>
				</tr>
			</table>
		<br>
		<div style="width:100%; font-size:7pt;">
			<table border="0" cellspacing="0" cellpadding="0" style="'.$estilo_tabla.'">
				<tr align="center" style="font-weight:bold;">
				<th width="'.$anch_id_pro.'" border="1">ID</th>
				<th width="'.$anch_tipo_cat.'" border="1">Grupo</th>
				<th width="'.$anch_clase_cat.'" border="1">Tipo</th>
				<th width="'.$anch_id_cat.'" border="1">Catálogo</th>
				<th width="'.$anch_imei_pro.'" border="1">IMEI</th>
				<th width="'.$anch_icc_pro.'" border="1">ICC</th>
				<th width="'.$anch_precio_pro.'" border="1">Precio</th>
				<th width="'.$anch_fechreg_pro.'" border="1">Fech.Reg.</th>
				<th width="'.$anch_activ_pro.'" border="1">Act.</th>
				<th width="'.$anch_zona_pro.'" border="1">Zona</th>
				</tr>'
				.$fila_tr.'
			</table>
		</div>';
		//echo $pagina,"<br>";
		ejemplo_PDF($pagina);?>
	</body>
</html>
<?php
function cargar_en_variables_de_clase_resultados_conteo($array_valor_de_campos, $resultado_de_conteos,
&$ct_hnd, &$ct_sph, &$ct_mdm, &$ct_pck, &$ct_smb, &$ct_bsm, &$ct_bfr, &$ct_bcm, &$ct_uni, &$ct_rou, &$ct_rtj, &$ct_rvr, &$ct_tbl, &$ct_sdc, 
&$ct_aur, &$ct_crs, &$ct_cst, &$ct_prp, &$ct_mgr, &$ct_cmp, &$ct_bjl, &$ct_dsb, &$ct_rcf, &$ct_kbv, &$ct_kbf, &$ct_kbd, &$ct_kbu, &$ct_ots)
{
	if (mysqli_num_rows($resultado_de_conteos)>0)
	{
		$fila = mysqli_fetch_array($resultado_de_conteos, MYSQLI_ASSOC);
		$ct_hnd=$fila["_Handset"];
		$ct_sph=$fila["_Smartphone"];
		$ct_mdm=$fila["_Modem"];
		$ct_pck=$fila["_PackConnect"];
		$ct_smb=$fila["_SIMMobile"];
		// $ct_bsm=$fila["_BSmart"];//*
		$ct_bfr=$fila["_BFree"];
		// $ct_bcm=$fila["_BCombo"];//*
		// $ct_uni=$fila["_Uni"];//*
		$ct_rou=$fila["_Router"];
		// $ct_rtj=$fila["_Rec_Tarjeta"];//*
		$ct_rvr=$fila["_Rec_Virtual"];
		$ct_tbl=$fila["_Tablet"];
		$ct_sdc=$fila["_SDCard"];
		$ct_aur=$fila["_Auricular"];
		$ct_crs=$fila["_CarcasaSmpl"];
		$ct_cst=$fila["_CarcasaTapa"];
		$ct_prp=$fila["_ProtectPant"];
		$ct_mgr=$fila["_Migracion"];
		// $ct_cmp=$fila["_CambioPlan"];//*
		$ct_bjl=$fila["_BajaLinea"];
		$ct_dsb=$fila["_Desbloqueo"];
		$ct_rcf=$fila["_Reconfigur_"];
		$ct_kbv=$fila["_KitBVoz"];
		// $ct_kbf=$fila["_KitBFono"];//*
		$ct_kbd=$fila["_KitBData"];
		$ct_kbu=$fila["_KitBitelUN"];
		$ct_ots=$fila["_Otros"];
	}
}
function cargar_en_variables_de_tipo_resultados_conteo($array_valor_de_campos, $resultado_de_conteos,
&$ct_equ, &$ct_mod, &$ct_chp, &$ct_rec, &$ct_tab, &$ct_srv, &$ct_acc, &$ct_otr) 
{
	if (mysqli_num_rows($resultado_de_conteos)>0)
	{
		$fila = mysqli_fetch_array($resultado_de_conteos, MYSQLI_ASSOC);
		$ct_equ=$fila["_Equipo"];
		$ct_mod=$fila["_Modem"];
		$ct_chp=$fila["_Chip"];
		$ct_rec=$fila["_Recarga"];
		$ct_tab=$fila["_Tableta"];
		$ct_srv=$fila["_Servicios"];
		$ct_acc=$fila["_Accesorios"];
		$ct_otr=$fila["_Otros"];
	}
}
function obtener_where_y_orderBy($nuevo_consulta, &$where_as, &$order_by)
{
	$posicion_where = strpos($nuevo_consulta, "WHERE");
	$posicion_order = strpos($nuevo_consulta, "ORDER BY");
	if ($posicion_where === false)
	{
		$where_as="";
	} 
	else 
	{
		$where_as = " ".trim(substr($nuevo_consulta, $posicion_where, $posicion_order-$posicion_where));
	}
	if ($posicion_order === false)
	{
		$order_by="";
	} 
	else 
	{
		$order_by = " ".trim(substr($nuevo_consulta, $posicion_order, strlen($nuevo_consulta)));
	}
}
function mostrar_resultados_conteo_PDF($array_valor_de_campos, $resultado_de_conteos)
{
	$mostrar_resultados_vertical="";
	if (mysqli_num_rows($resultado_de_conteos)>0)
	{
		$fila = mysqli_fetch_array($resultado_de_conteos, MYSQLI_ASSOC);
		for($i=0; $i<count($array_valor_de_campos); $i++)
		{
			$cantidad = $fila["$array_valor_de_campos[$i]"];
			$mostrar_resultados_vertical = $mostrar_resultados_vertical."<b>".quitar_Subraya_de_Inicio($array_valor_de_campos[$i]).":</b> ".$cantidad."<br>";
		}
	}
	$mostrar_resultados_vertical = substr($mostrar_resultados_vertical,0,strlen($mostrar_resultados_vertical)-4);
	return $mostrar_resultados_vertical;
}
function mostrar_resultados_conteo_activos_PDF($array_valor_de_campos, $resultado_de_conteos)
{
	$mostrar_resultados_vertical="";
	if (mysqli_num_rows($resultado_de_conteos)>0)
	{
		$fila = mysqli_fetch_array($resultado_de_conteos, MYSQLI_ASSOC);
		for($i=0; $i<count($array_valor_de_campos); $i++)
		{
			$cantidad = $fila["$array_valor_de_campos[$i]"];
			if (quitar_Subraya_de_Inicio($array_valor_de_campos[$i]) == "0")
			{
				$nombre_valor_datos = "No Activos";
			}
			else
			{
				$nombre_valor_datos = "Activos";
			}
			$mostrar_resultados_vertical = $mostrar_resultados_vertical."<b>".$nombre_valor_datos.":</b> ".$cantidad."<br>";
		}
	}
	$mostrar_resultados_vertical = substr($mostrar_resultados_vertical,0,strlen($mostrar_resultados_vertical)-4);
	return $mostrar_resultados_vertical;
}
function ejemplo_PDF($txt)
{
	//$Pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, "A4", true, 'UTF-8', false);
	$Pdf = new TCPDF('P', PDF_UNIT, "A4", true, 'UTF-8', false);
	// Elimina la linea de separación de la cabecera
	$Pdf->setPrintHeader(false);
	$Pdf->setPrintFooter(false);
	$Pdf->SetTopMargin(5);
	$Pdf->SetFooterMargin(0);
	//--------------------------------------------
	$Pdf->AddPage();
	// Establecer fuente 
	$Pdf->SetFont('helvetica', '', 7);
	//Establecer fecha
	date_default_timezone_set('America/Lima');
	$fecha = date('d-m-Y, h:i:s');
	$Pdf->Write(null, "HELICELL 2025 - ".$fecha, null, null, 'R', true);
	$Pdf->SetFont('helvetica', '', 10);
	$Pdf->WriteHTML($txt,true,0,true,0);
	// Enviar PDF en línea
	ob_end_clean();
	$Pdf->Output('pagina.pdf', 'I');
}
?>