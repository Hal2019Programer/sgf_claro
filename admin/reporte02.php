<?php
include("../library/funcionA.php"); include("../library/funcionB.php"); include("../library/datos.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
$var_zona=$var_tdoc=$var_fpag=$valfecha=$fechact=$varfac=$var_rpag=$var_stad="";
$fechi=$var_fchdyi=$var_fchmsi=$var_fchani="";
$fechf=$var_fchdyf=$var_fchmsf=$var_fchanf="";
$cadsql="";$is=$ident_usuario;
$fecha_filtrada="";
//Datos iniciales para control de accesos de perfil
$resultado_perfil_accesos = Null; $datos = array();
cargar_datos_perfil($Conexion,$ident_usuario,"Reporte de Caja",$resultado_perfil_accesos,$datos,$categ_usuario,$nivel_usuario,$zona_usuario);
verificar_procesos_de_boton($resultado_perfil_accesos);
?>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Reporte 02");?></head>
	<body>
		<div>
			<?php //cabecera02("Reporte 02 (CAJA)"); menu02();?>
			<div style="width:1310px;">
				<?php cabecera04(0,"Reporte de Caja"); menu02(); sl(1);?>
				<!--<center><h1>Reporte de Caja</h1></center><hr>-->
				<?php
				date_default_timezone_set("America/Lima");
				$fchact=date("Y-m-d");
				$sql= mysqli_query ($Conexion,"SELECT * FROM regvtacaja WHERE fechaven_rvi='$fchact' ORDER BY seriecp_rvi ASC, numcp_rvi ASC") or die ("Error al traer datos de reporte de regvtacaja");
				$filas_regventas=mysqli_num_rows($sql);
				$sql_pagosdiv= mysqli_query ($Conexion,"SELECT * FROM pagosdiv WHERE fechareg_rpg='$fchact' ORDER BY seriedoc_rpg ASC, numdoc_rpg ASC") or die ("Error al traer datos de reporte de regvtacaja");
				separa_fecha($fchact, $var_fchdyf, $var_fchmsf, $var_fchanf);
				if(isset($_POST["btnGrl"]))
				{
					$btn=$_POST["btnGrl"];
					if($btn=="Filtrar")
					{
						$zona=$_POST["cmbzna"];$var_zona=$zona;//Zona
						$tdoc=$_POST["cmbtid"];$var_tdoc=$tdoc;//Tipo de documento
						$fpag=$_POST["cmbfpg"];$var_fpag=$fpag;//Forma de pago
						$rpag=$_POST["cmbrpg"];$var_rpag=$rpag;//Registro de pago
						$stad=$_POST["cmbstd"];$var_stad=$stad;//Estado anulado
						// Variables de fecha inicial dia, mes y año
						$fdyi=$_POST["cmbfdyi"];$var_fchdyi=$fdyi;
						$fmsi=$_POST["cmbfmsi"];$var_fchmsi=$fmsi;
						$fani=$_POST["cmbfani"];$var_fchani=$fani;
						// Variables de fecha final dia, mes y año
						$fdyf=$_POST["cmbfdyf"];$var_fchdyf=$fdyf;
						$fmsf=$_POST["cmbfmsf"];$var_fchmsf=$fmsf;
						$fanf=$_POST["cmbfanf"];$var_fchanf=$fanf;
						//Verifica que la fecha inicial no este vacia para asignarlo
						if (empty($fdyi) OR empty($fmsi) OR empty($fani)) $fechi=""; else $fechi=$fani."-".fech_nom_num($fmsi)."-".$fdyi;
						//Verifica que la fecha final no este vacia para asignarlo
						if (empty($fdyf) OR empty($fmsf) OR empty($fanf)) $fechf=""; else $fechf=$fanf."-".fech_nom_num($fmsf)."-".$fdyf;
						//Genera cadena de fechas limitado por rangos inicial y final
						$valfecha=comp_y_gener_fechas("fechaven_rvi",$fechi,$fechf);
						//Se añade para generar descarga de archivo de validez
						$valfecha_emision=comp_y_gener_fechas("a.fechaemi_rvi",$fechi,$fechf);
						$fecha_filtrada=trim(substr($valfecha_emision,0,strlen($valfecha_emision)-4));
						//----------------------------------------------------------------------------
						$sql_where="";
						//Genera cadena de filtro para consulta de regvtacaja
						if (!empty($zona)) $sql_where=$sql_where."(zona_rvi='$zona') AND ";
						if (!empty($tdoc)) $sql_where=$sql_where."(tipodoccp_rvi='$tdoc') AND ";
						if (!empty($fpag)) $sql_where=$sql_where."(formapago_rvi='$fpag') AND ";
						if (!empty($rpag)) $sql_where=$sql_where."(rgpag_rvc='$rpag') AND ";
						if (!empty($stad)) $sql_where=$sql_where."(estado_rvc='$stad') AND ";
						if (!empty($valfecha)) $sql_where=$sql_where.$valfecha;
						$sql_where=trim($sql_where);
						$sql_where=substr($sql_where, 0, strlen($sql_where)-4);
						//Genera cadena de filtro para consulta de pagosdiv
						$valfecha=comp_y_gener_fechas01($fechi,$fechf);
						$sql_pgdiv="";
						if (!empty($zona)) $sql_pgdiv=$sql_pgdiv."(zona_rpg='$zona') AND ";
						if (!empty($valfecha)) $sql_pgdiv=$sql_pgdiv.$valfecha;
						$sql_pgdiv=trim($sql_pgdiv);
						$sql_pgdiv=substr($sql_pgdiv, 0, strlen($sql_pgdiv)-4);
						if (!empty($sql_where))
						{
							//Cadena de consulta de regvtacaja por filtro
							// $sql_where="SELECT * FROM regvtacaja WHERE ".$sql_where." ORDER BY seriecp_rvi ASC, numcp_rvi ASC";
							
							//--------- Usado con el servicio billConsultService, actualmente inactivo --------------
							// $sql_where="SELECT id_rvc, id_cli, tipopla_rvi, id_pla, fechaemi_rvi, horaemi_rvi, fechaven_rvi, codcpg_rvi, tipodoccp_rvi, seriecp_rvi, numcp_rvi, descrip_rvi, formapago_rvi, baseimpopgrv_rvi, baseimpopngrv_rvi, isc_rvi, igv_rvi, importetot_rvi, id_usr, rgpag_rvc, zona_rvi, estado_rvc, fechapag_rvc, id_usr_anula, causanul_rvc, causamant_rvc, id_ubi, id_undc, id_tipcmp, id_empe, id_tipdoc, id_elad, cee_rvc, nombarch_rvc, ticketsunat_rvc, codigocdr_rvc, mensajecdr_rvc, id_ncred, desc_ncred, codcdr_ncred, mensjcdr_ncred, numcorr_ncred, id_ndeb, desc_ndeb, codcdr_ndeb, mensjcdr_ndeb, numcorr_ndeb, descrip_cli_tmp, CONCAT(tipodoccp_rvi,'-',seriecp_rvi,'-',numcp_rvi) AS comprobante FROM regvtacaja WHERE ".$sql_where." ORDER BY seriecp_rvi ASC, numcp_rvi ASC";
							
							$sql_where="SELECT id_rvc, id_cli, tipopla_rvi, id_pla, fechaemi_rvi, horaemi_rvi, fechaven_rvi, codcpg_rvi, tipodoccp_rvi, seriecp_rvi, numcp_rvi, descrip_rvi, formapago_rvi, baseimpopgrv_rvi, baseimpopngrv_rvi, isc_rvi, igv_rvi, importetot_rvi, id_usr, rgpag_rvc, zona_rvi, estado_rvc, fechapag_rvc, id_usr_anula, causanul_rvc, causamant_rvc, id_ubi, id_undc, id_tipcmp, id_empe, id_tipdoc, id_elad, cee_rvc, nombarch_rvc, ticketsunat_rvc, codigocdr_rvc, mensajecdr_rvc, id_ncred, desc_ncred, codcdr_ncred, mensjcdr_ncred, numcorr_ncred, id_ndeb, desc_ndeb, codcdr_ndeb, mensjcdr_ndeb, numcorr_ndeb, descrip_cli_tmp, CONCAT(tipodoccp_rvi,'-',seriecp_rvi,'-',numcp_rvi,'-',date_format(fechaemi_rvi, '%d/%m/%Y'),'-',importetot_rvi) AS comprobante FROM regvtacaja WHERE ".$sql_where." ORDER BY seriecp_rvi ASC, numcp_rvi ASC";
							$cadsql=$sql_where; //Contiene la cadena de consulta final usado en impresión
							$sql= mysqli_query ($Conexion,$sql_where) or die ("Error al traer los datos de regvtacaja al filtrar.");
							//Cadena de consulta de pagosdiv por filtro
							$sql_pgdiv="SELECT * FROM pagosdiv WHERE ".$sql_pgdiv." ORDER BY seriedoc_rpg ASC, numdoc_rpg ASC";
							$sql_pagosdiv= mysqli_query ($Conexion,$sql_pgdiv) or die ("Error al traer datos de reporte de pagos diversos");	
						}
					}
					if($btn=="Exportar Normal")
					{
						$consulta_exportar="SELECT * FROM regvtacaja WHERE fechaven_rvi='$varfac'";
						$consulta_activa=$_POST["txtcadsql"];
						if (!empty($consulta_activa))
						{
							$sql=mysqli_query($Conexion,$consulta_activa) or die ("Error al traer los datos de regventas");
							$filas_regventas=mysqli_num_rows($sql);
							$consulta_exportar=$consulta_activa;
						}
						if ($filas_regventas<=0)
						{
							echo "<script> alert('No hay datos para mostrar');</script>";
						}
						else
						{
							exportarn(conversion_de_consulta($consulta_exportar));	
						}
					}
					if($btn=="Exportar Sunat")
					{
						/*$consulta_exportar="SELECT 
						id_rvc, fechaemi_rvi, fechaven_rvi, tipodoccp_rvi, id_cli,
						estado_rvc, baseimpopgrv_rvi, baseimpopngrv_rvi, isc_rvi, igv_rvi,
						importetot_rvi, formapago_rvi, zona_rvi 
						FROM regvtacaja WHERE fechaven_rvi='$varfac'";*/
						$consulta_exportar="SELECT id_rvc, fechaemi_rvi, fechaven_rvi, tipodoccp_rvi, id_cli, estado_rvc, baseimpopgrv_rvi, baseimpopngrv_rvi, isc_rvi, igv_rvi, importetot_rvi, formapago_rvi, zona_rvi, seriecp_rvi, numcp_rvi, CONCAT(tipodoccp_rvi,'-',seriecp_rvi,'-',numcp_rvi) AS comprobante FROM regvtacaja WHERE fechaven_rvi='$varfac'";
						$consulta_activa=$_POST["txtcadsql"];
						if (!empty($consulta_activa))
						{
							$sql=mysqli_query($Conexion,$consulta_activa) or die ("Error al traer los datos de regventas");
							$filas_regventas=mysqli_num_rows($sql);
							$consulta_exportar=$consulta_activa;
						}
						if ($filas_regventas<=0)
						{
							echo "<script> alert('No hay datos para mostrar');</script>";
						}
						else
						{
							exportars(conversion_de_consulta($consulta_exportar));
						}
					}
					if($btn=="Exportar Verificación")
					{
						//--------- Usado con el servicio billConsultService, actualmente inactivo --------------
						//$consulta_exportar="SELECT id_rvc, fechaemi_rvi, fechaven_rvi, tipodoccp_rvi, id_cli, estado_rvc, baseimpopgrv_rvi, baseimpopngrv_rvi, isc_rvi, igv_rvi, importetot_rvi, formapago_rvi, zona_rvi, seriecp_rvi, numcp_rvi, CONCAT(tipodoccp_rvi,'-',seriecp_rvi,'-',numcp_rvi) AS comprobante  FROM regvtacaja WHERE fechaven_rvi='$varfac'";
						
						// $consulta_exportar="SELECT id_rvc, fechaemi_rvi, fechaven_rvi, tipodoccp_rvi, id_cli, estado_rvc, baseimpopgrv_rvi, baseimpopngrv_rvi, isc_rvi, igv_rvi, importetot_rvi, formapago_rvi, zona_rvi, seriecp_rvi, numcp_rvi, CONCAT(tipodoccp_rvi,'-',seriecp_rvi,'-',numcp_rvi,'-',fechaemi_rvi,'-',importetot_rvi) AS comprobante FROM regvtacaja WHERE fechaven_rvi='$varfac'";

						$consulta_activa=$_POST["txtcadsql"];
						if (!empty($consulta_activa))
						{
							$sql=mysqli_query($Conexion,$consulta_activa) or die ("Error al traer los datos de regventas");
							$filas_regventas=mysqli_num_rows($sql);
							$consulta_exportar=$consulta_activa;
							if ($filas_regventas<=0)
							{
								echo "<script> alert('No hay datos para mostrar.');</script>";
							}
							else
							{
								exportar_verificar_comprobantes(conversion_de_consulta($consulta_exportar));
							}
						}
						else
						{
							echo "<script> alert('No se ha filtrado los datos. No se puede continuar.\\nPrimero filtre los datos antes de Exportar Verificación.');</script>";
						}
						//----------------------------------------------------------------

					}
					if($btn=="Descargar Archivo Validez")
					{
						$datos_de_fecha=$_POST["txtfecha_filtrada"];
						if (empty($datos_de_fecha)) { $datos_de_fecha="a.fechaemi_rvi='".date("Y-m-d")."'"; }
						//----------------------------------------------------------------
						exportar_descargar_archivo_validez(conversion_de_consulta($datos_de_fecha));
					}
					if($btn=="Imprimir")
					{
						// Considerar en configuración de IE/Herramientas/Imprimir/Configurar páginas modificar los siguientes parámetros
						// para evitar que aparezcan el nombre de archivo, numero de página, URL y fecha:
						// Encabezado: Titulo y Personalizdo, escoger Vacío
						// Pié de página: URL y Fecha, escoger Vacío
						$ccf=$_POST["txtcadsql"];$cadsql=$ccf;//cadena de consulta final
						$znn=$_POST["cmbzna"];$var_zona=$znn;
						$tip=$_POST["cmbtip"];$var_tvta=$tip;
						$ufn=$_POST["cmbusr"];$var_usua=$ufn;
						$fid=$_POST["cmbfdyi"];$var_fchdyi=$fid;
						$fim=$_POST["cmbfmsi"];$var_fchmsi=$fim;
						$fia=$_POST["cmbfani"];$var_fchani=$fia;
						$ffd=$_POST["cmbfdyf"];$var_fchdyf=$ffd;
						$ffm=$_POST["cmbfmsf"];$var_fchmsf=$ffm;
						$ffa=$_POST["cmbfanf"];$var_fchanf=$ffa;
						$fin=$fid."/".$fim."/".$fia;
						$ffi=$ffd."/".$ffm."/".$ffa;
						$sql= mysqli_query ($Conexion,$ccf) or die ("Error al traer los datos");
						$ncf=conversion_de_consulta($ccf);
						//echo "<script> window.open('../admin/reporte01imp.php?cadconsulta=$ccf', '_blank', 'width=1280, height=800, left=0, top=0, menubar=no, toolbar=no, scrollbars=yes, resizable=no, status=no'); </script>";
						echo "<script> window.open('../admin/reporte01imp.php?cadconsulta=$ncf&vizona=$znn&vitip=$tip&viufn=$ufn&vifin=$fin&viffi=$ffi', '_blank', 'width=962, height=600, left=0, top=0, menubar=no, toolbar=yes, scrollbars=yes, resizable=no, status=no'); </script>";
					}
					if($btn=="Actualizar")
					{
						echo "<script> location.href = 'reporte02.php'; </script>";
					}
				}
				//----------------------------------------------- INICIO DE CONTEOS -----------------------------------------------
				// Inicialización de variables
				// ----------------------------------------------------------------------------------------------------------------
				//Cantidad x zonas
				//Monto x zonas
				$ctbv=$ctfc=0; //Cantidad x tipo de documento
				$mtbv=$mtfc=0; //Monto x tipo de documento
				$cfct=$cfcr=$cfdp=$cftj=0; //Cantidad x forma de pago
				$mfct=$mfcr=$mfdp=$mftj=0; //Monto x forma de pago
				$cean=$cabv=$cafc=$mean=0; //Cantidad y monto de anulados
				$cenr=$cnrb=$cnrf=$menr=0; //Cantidad y monto de normales
				$crnp=$cnbv=$cnfc=$mrnp=0; //Cantidad y monto de no pagos
				$crpg=$cpbv=$cpfc=$mrpg=0; //Cantidad y monto de pagados
				$ct=0;
				//Agregado por Juan (28-03-2019)----------------------------------
				$registro_x_zona=new conteo_zonas;
				$registro_x_zona->inicializar_lista($rz,$registro_x_zona->lista_zona);
				//----------------------------------------------------------------
				mysqli_data_seek($sql, 0); //Inicio de recordset de ventas caja
				// Recorre todo el recordset de regvtacaja para contar sus datos
				// ----------------------------------------------------------------------------------------------------------------
				while($resul = mysqli_fetch_array($sql, MYSQLI_ASSOC)) 
				{
					$it=$resul["importetot_rvi"];
					$zn=$resul["zona_rvi"];
					$td=$resul["tipodoccp_rvi"];
					$fp=$resul["formapago_rvi"];
					$rp=$resul["rgpag_rvc"];
					$st=$resul["estado_rvc"];
					//Registros por zona
					//Agregado por Juan (28-03-2019)----------------------------------
					$registro_x_zona->contar_a_lista($rz,$registro_x_zona->lista_zona,$zn,$it);
					//-------------------------------------------------------------				
					//Por tipo de documento
					if ($td=="Boleta de venta") { $ctbv++;$mtbv=$mtbv+$it; }
					if ($td=="Factura") { $ctfc++;$mtfc=$mtfc+$it; }
					//Por forma de pago
					if ($fp=="Contado") { $cfct++;$mfct=$mfct+$it; }
					//if ($fp=="Crédito") { $cfcr++;$mfcr=$mfcr+$it; }
					//if ($fp=="Depósito") { $cfdp++;$mfdp=$mfdp+$it; }
					//if ($fp=="Tarjeta") { $cftj++;$mftj=$mftj+$it; }
					//Por registro de pago
					if ($rp=="NoPago")
					{
						$crnp++; $mrnp=$mrnp+$it;
						if ($td=="Boleta de venta") $cnbv++;
						if ($td=="Factura") $cnfc++;
					}
					else
					{
						$crpg++; $mrpg=$mrpg+$it;
						if ($td=="Boleta de venta") $cpbv++;
						if ($td=="Factura") $cpfc++;
					}
					//Por estado
					if ($st=="anulado") 
					{
						$cean++;$mean=$mean+$it; 
						if ($td=="Boleta de venta") $cabv++;
						if ($td=="Factura") $cafc++;
					}
					else
					{
						$cenr++;$menr=$menr+$it; 
						if ($td=="Boleta de venta") $cnrb++;
						if ($td=="Factura") $cnrf++;
					}
					//Suma total
					$ct=$ct+$it;
				}
				// Inicialización de variables de pagos diversos
				// ----------------------------------------------------------------------------------------------------------------
				//Pagos diversos totales 
				/* $padel=0; //Pagos adelantados
				$cadel=0; */
				$pPayJoy=0; //Pago PayJoy
				$cPayJoy=0; 
				$pmens=0; //Pagos mensuales
				$cmens=0;
				$pt=0;
				//Agregado por Juan (28-03-2019)----------------------------------
				$pagosdiv_x_zona=new conteo_zonas;
				$pagosdiv_x_zona->inicializar_lista($pz,$pagosdiv_x_zona->lista_zona);
				//----------------------------------------------------------------
				mysqli_data_seek($sql_pagosdiv, 0); //Inicio de recordset de pagos diversos
				// Recorre todo el recordset de pagos diversos para obtener sus datos
				// ----------------------------------------------------------------------------------------------------------------
				while($resul = mysqli_fetch_array($sql_pagosdiv, MYSQLI_ASSOC)) 
				{
					$tp=$resul["tipo_rpg"];
					$mn=$resul["monto_rpg"];
					$fr=$resul["fechareg_rpg"];
					$zn=$resul["zona_rpg"];
					$us=$resul["id_usr"];
					//Registros por zona
					//Agregado por Juan (28-03-2019)----------------------------------
					$pagosdiv_x_zona->contar_a_lista($pz,$pagosdiv_x_zona->lista_zona,$zn,$mn);
					//-------------------------------------------------------------
					//Por tipo de pago
					if ($tp=="Pag.Mens.") { $cmens++;$pmens=$pmens+$mn; }
					//if ($tp=="Pag.Adel.") { $cadel++;$padel=$padel+$mn; }
					if ($tp=="PayJoy") { $cPayJoy++;$pPayJoy=$pPayJoy+$mn; }
					//Suma total
					$pt=$pt+$mn;
				}
				?>
				<form name="usuario" action="" method="post">
					<br>
					<?php txtoculto("txtcadsql",$cadsql);?><!-- txtcadsql contiene una cadena de consulta final usada cuando se imprime -->
					<?php txtoculto("txtfecha_filtrada",$fecha_filtrada);?>
					<span id="etq5">Zona:</span>
					<?php 
					cmbfieldJs_span("spn_zona","cmbzna",$Conexion,"SELECT nomb_zna FROM zona WHERE activo_zna='S'",$var_zona,"","nomb_zna"); 
					?>
					<span id="etq5">Tipo de docum.:</span><?php cmbnormal("cmbtid", $var_tdoc, "Boleta de venta", "Factura");?>
					<span id="etq5">Forma de pago:</span><?php cmbnormal("cmbfpg", $var_fpag, "Contado");?>
					<span id="etq5">Pagos:</span><?php cmbnormal("cmbrpg", $var_rpag, "Pagado", "NoPago");?>
					<span id="etq5">Estado:</span><?php cmbnormal("cmbstd", $var_stad, "anulado");?>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Filtrar")) { btnnormal("btnGrl", "Filtrar"); } ?>
					<?php //btnnormal("btnGrl", "Imprimir");?>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Actualizar")) { btnnormal("btnGrl", "Actualizar"); } ?>
					<br>
					<span id="etq5">Fecha Inicial:</span> <?php cmbday("cmbfdyi", $var_fchdyi);cmbmes("cmbfmsi", $var_fchmsi);cmbann("cmbfani", $var_fchani);?>
					<span id="etq5">Fecha Final:</span> <?php cmbday("cmbfdyf", $var_fchdyf);cmbmes("cmbfmsf", $var_fchmsf);cmbann("cmbfanf", $var_fchanf);?>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Exportar Normal")) { btnnormal("btnGrl","Exportar Normal"); } ?>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Exportar Sunat")) { btnnormal("btnGrl","Exportar Sunat"); } ?>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Exportar Verificación")) { btnnormal("btnGrl","Exportar Verificación"); } ?>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Descargar Archivo Validez")) { btnnormal("btnGrl","Descargar Archivo Validez"); } ?>
					<hr>
					<div class="formulario">
						<span id="etq3"  class="color_items" style="width:200px;">ZONA:</span><?php
						$registro_x_zona->mostrar_lista($rz,$registro_x_zona->lista_zona);?><br>
						<span id="etq3"  class="color_items" style="width:200px;">TIPO DE DOCs:</span>
							<span id="etq3"style="width:135px;">Boleta de venta=</span><?php echo "S/. ",$mtbv,"(",$ctbv,")";?>
							<span id="etq4"style="width:135px;">Factura=</span><?php echo "S/. ",$mtfc,"(",$ctfc,")";?> <br>
						<span id="etq3"  class="color_items" style="width:200px;">FORMA DE PAGO:</span>
							<span id="etq4"style="width:135px;">Contado=</span><?php echo "S/. ",$mfct,"(",$cfct,")";?><br>
						<span id="etq3" class="color_items" style="width:200px;">REGISTRO DE PAGO:</span>
							<span id="etq3"style="width:135px;">Total No pagados=</span><?php echo "S/. ",$mrnp,"(",$crnp,")";?> 
							<span id="etq4"style="width:135px;">Boletas=</span><?php echo $cnbv;?>
							<span id="etq4"style="width:135px;">Facturas=</span><?php echo $cnfc;?><br>
							<span id="etq3" style="width:339px;">Pagados=</span><?php echo "S/. ",$mrpg,"(",$crpg,")";?> 
							<span id="etq4"style="width:135px;">Boletas=</span><?php echo $cpbv;?>
							<span id="etq4"style="width:135px;">Facturas=</span><?php echo $cpfc;?><br>
						<span id="etq3"  class="color_items" style="width:200px;">ESTADO:</span>
							<span id="etq3"style="width:135px;">Total Anulados=</span><?php echo "S/. ",$mean,"(",$cean,")";?> 
							<span id="etq4"style="width:135px;">Boletas=</span><?php echo $cabv;?>
							<span id="etq4"style="width:135px;">Facturas=</span><?php echo $cafc;?><br>
							<span id="etq3"style="width:339px;">No anulados=</span><?php echo "S/. ",$menr,"(",$cenr,")";?> 
							<span id="etq4"style="width:135px;">Boletas=</span><?php echo $cnrb;?>
							<span id="etq4"style="width:135px;">Facturas=</span><?php echo $cnrf;?><br>
						<span id="etq3"  class="color_items" style="width:200px;">TOTAL DE VENTAS:</span><span id="etq3"><?php echo "S/. ",$ct-$mean;?></span><br><hr>
						<div style="width:15%; float:left;">
							<span id="etq5"  class="color_items" style="width:200px;">PAGOS DIVERSOS:</span>
						</div>
						<div style="width:25%; float:left;"><?php
						$pagosdiv_x_zona->mostrar_lista($pz,$pagosdiv_x_zona->lista_zona);?><br>
						</div>
						<div style="width:29%; float:left;">
							<span id="etq3">PayJoy =</span><?php echo " S/. ",$pPayJoy," (",$cPayJoy,")";?><br>
							<span id="etq3">Pago Mensual =</span><?php echo " S/. ",$pmens," (",$cmens,")";?><br>
						</div>
						<div style="width:26%; float:left;">
							<span id="etq5"  class="color_items" style="text-align:left;">TOTAL PAGOS:</span><?php echo " S/. ",$pt;?><br>
						</div>
						<div style="clear:both"></div><hr>
						<span id="etq5"  class="color_items" style="text-align:left;">TOTAL DE VENTAS + PAGOS DIVERSOS:</span><span id="etq4"><?php echo "S/. ",$ct+$pt-$mean;?></span>
					</div><hr>	
				</form>
				<div id="div1" style="width:100%; height:30px; overflow-x:hidden;">
					<table border='0' cellspacing='0' cellpadding='0' class="tblreporte01" style="table-layout:fixed; width:1410px;">
						<?php head_tbl("ID",30,"Cliente",160,"Fech.Venta",60,"Cód.Comp.",50,"Tipo Dóc.",90,"Serie",35,"Nº Dóc.",40,"Descripción",200,"FormaPago",60,"Importe",60,"Estado",80,"Situación",80);?>
					</table>
				</div>
				<div id="div2" style="width:100%; height:280px; overflow:auto;">
					<table border='0' cellspacing='0' cellpadding='0' class="tblreporte01" style="table-layout:fixed; width:1410px;">
						<col width="30"><col width="160"><col width="60"><col width="50"><col width="90"><col width="35"><col width="40"><col width="200"><col width="60"><col width="60"><col width="65"><col width="65">
						<?php
						mysqli_data_seek($sql, 0); 
						while($resul = mysqli_fetch_array($sql, MYSQLI_ASSOC))
						{
						$id_rcj=$resul["id_rvc"];// Id de registro de ventas de caja
						$id_cln=$resul["id_cli"]; // + RUC/DNI + Nombres + TelefonoContacto(postpago)
						$fc_ven=$resul["fechaven_rvi"]; // Fecha de venta
						$cd_cpg=$resul["codcpg_rvi"]; // Código de comprobante de pago
						$tp_doc=$resul["tipodoccp_rvi"]; // Tipo de documento de pago
						$ser_cp=$resul["seriecp_rvi"]; // Serie de documento de pago
						$num_cp=$resul["numcp_rvi"]; // Numero de documento de pago
						$descri=$resul["descrip_rvi"]; // Descripcion de documento de pago
						$formpg=$resul["formapago_rvi"]; // Forma de pago
						$im_tot=$resul["importetot_rvi"]; // Importe total
						$rg_pag=$resul["rgpag_rvc"];// Estado de pago
						//-------------------------------------------
						$st_pag=$resul["estado_rvc"]; // Anulado?
						$id_usu=$resul["id_usr"]; // + Nombre
						$zn_rgv=$resul["zona_rvi"]; // Zona del usuario
						?>
						<tr valign="top">
						<td><?php echo $id_rcj; ?></td>
						<td><?php echo $id_cln.":".valfield($Conexion,"clientes","nom_rzs_cli","id_cli",$id_cln);?></td>
						<td><?php echo $fc_ven; ?></td>
						<td><?php echo $cd_cpg; ?></td>
						<td><?php echo $tp_doc; ?></td>
						<td><?php echo $ser_cp; ?></td>
						<td><?php echo $num_cp; ?></td>
						<td><?php echo $descri; ?></td>
						<td><?php echo $formpg; ?></td>
						<!--<td style="text-align:right;"><?php //echo $im_tot; ?></td>-->
						<td style="text-align:right;">
						<?php 
						if($st_pag=="anulado")
						{
							echo 0;
						}
						else
						{
							echo $im_tot;
						}
						?>
						</td>
						<td><?php echo $rg_pag; ?></td>
						<td><?php echo $st_pag; ?></td>
						</tr>
						<?php
						}
						?>
					</table>
				</div>	
			<!-- Fin de listado de datos de usuario -->
			<?php scroll_doble("div1", "div2"); ?>
			</div><!--Fin de main-col-->
			<article class="piepag"><?php pie_pagina();?></article>
	</body>
</html>
<?php
function exportarn($dato)
{?>
	<script type="text/javascript">
		cadena="<?php echo $dato;?>";
		window.open("regcaja_e.php?v1="+cadena,"_blank");
	</script>
<?php
}
?>
<?php
function exportars($dato)
{	//global $is; $dato=cdpu($is,$dato);?>
	<script type="text/javascript">
		cadena="<?php echo $dato;?>";
		window.open("regcaja_s.php?v1="+cadena,"_blank");
	</script>
<?php
}
function exportar_verificar_comprobantes($dato)
{	//global $is; $dato=cdpu($is,$dato);?>
	<script type="text/javascript">
		cadena="<?php echo $dato;?>";
		window.open("regcaja_verifica_comprobante_Excel.php?v1="+cadena,"_blank");
	</script>
<?php
}
function exportar_descargar_archivo_validez($dato)
{	?>
	<script type="text/javascript">
		cadena="<?php echo $dato;?>";
		window.open("regcaja_descarga_archivo_validez.php?v1="+cadena,"_blank");
	</script>
<?php
}
?>