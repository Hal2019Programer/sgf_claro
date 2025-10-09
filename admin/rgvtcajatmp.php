<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
include("../library/datos.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
$id_rvi=$id_cli=$id_pro=$tipopla_rvi=$id_pla=$fechaemi_rvi=$fechaven_rvi=$tipodoccp_rvi=$seriecp_rvi=$numcp_rvi=$descrip_rvi=$formapago_rvi=$baseimpopgrv_rvi=$baseimpopngrv_rvi=$isc_rvi=$igv_rvi=$importetot_rvi=$numcont_rvi=$numcel_rvi=$codpqt_rvi=$codcpg_rvi=$rgpag_rvc="";
$numreg="";
$vincbv=$vincfc="";
$vsubtt=$valigv=0;
if (isset($_GET['ccp']))
{
	$btn="Buscar";
	$ccp=$_GET['ccp'];
}
else
{
	$btn="";
	$ccp="";
}
?>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Registro de Ventas Caja(TMP)");?></head>
	<body>
		<div style="width:985px;">
			<!--<header>
				<article style="height:140px; background-color:white;"><img id="logo" src="../imagenes/logo_base.png"></article>
			</header>-->
			<div style="width:985px;">
				<?php cabecera04(0,"Registro de Pago de Caja");sl(1);?>
				<!--<center><h1>Registro de Pago de Caja</h1></center><hr>-->
				<?php
				$sql= mysqli_query($Conexion,"SELECT * FROM rgvtatmp WHERE zona_rvi='$zona_usuario'") or die ("Error al traer los datos");
				$vincbv=incr_comp_bv($Conexion,$zona_usuario);
				$vincfc=incr_comp_fc($Conexion,$zona_usuario);
				//---------------------------------------------------------- Botones ----------------------------------------------------------
				if(isset($_POST["btnGrl"]))
				{
					$btn=$_POST["btnGrl"];
					//---------------------------------------------------------- Cobrar ----------------------------------------------------------
					if($btn=="Cobrar")
					{
						cargar_datos_desde_formulario($idc, $fev, $fvv, $ccp, $tdv, $srv, $ncv, $dsv, $fpv, $pag, $bgr, $bng, $isc, $igv, $itv);
						if (verificar_codcpg_rvi_existente_y_estado_rvc_anulado($Conexion, $ccp))
						{
							if (!empty($ccp) && $tdv<>"" && $srv<>"" && $ncv<>"" && $dsv<>"" && $fpv<>"" && $pag<>"")
							{
								if (verificar_comprobante_duplicado($Conexion, $ccp, $tdv, $srv, $ncv))
								{
									obtener_datos_cliente($Conexion, $idc, $correo_cliente, $id_ubigeo, $id_tipo_documento);
									if (verificar_tipo_documento_cliente_x_comprobante($Conexion,$tdv,$id_tipo_documento))
									{
										if (verificar_ubigeo_y_correocliente($id_ubigeo, $correo_cliente))
										{
											//Actualiza tabla rgvtatmp con datos del comprobante y de los productos
											actualizar_registro_de_venta_temporal_rgvtatmp($Conexion, $tdv, $srv, $ncv, $dsv, $fpv, $pag, $ccp);
											//Actualiza regvtacaja con datos de venta final
											insertar_datos_comprobante_en_regvtacaja($Conexion, $idc, $fev, $fvv, $ccp, $tdv, $srv, $ncv, $dsv, $fpv, $bgr, $bng, $isc, $igv, $itv, $ident_usuario, $pag, $zona_usuario, $id_ubigeo, $id_tipo_documento);
											$last_id_rvc = devuelve_ultimo_id_rvc_creado($Conexion, $ccp, $srv, $ncv);
											if (!empty($last_id_rvc))
											{
												// Actualiza tabla datprinctmp con datos del cliente y del comprobante
												actualizar_registro_datos_principal_datprinctmp($Conexion, $tdv, $srv, $ncv, $dsv, $fpv, $pag, $ccp);
												/* Completa los procesos de venta final:
												- Traslada datos de rgvtatmp a regventas. 
												- Elimina los temporales de datprinctmp, rgvtatmp y codcomp.
												- Genera archivo XML y envia los datos a SUNAT para generar el comprobante electrónico.*/
												finalizar_venta($Conexion,$ident_usuario,$ccp,$last_id_rvc);
												// Genera PDF y envia correo con PDF adjunto.
												//generar_pdf_y_enviar_mail($last_id_rvc);
												// Abre ventanas para impresion de comprobantes: BV o Fact
												echo "<script> window.open('../admin/regvtacaja_imp.php?id=$last_id_rvc', '_blank', 'width=350, height=650, left=0, top=0, menubar=no, toolbar=no, scrollbars=yes, resizable=no, status=no'); </script>";
												echo "<script> window.close(); </script>";
											}
											else
											{
												mensaje("No se puede continuar con la venta, existe un error en el registro de ventas.");
											}
										}
										else
										{
											echo "<script> alert('El cliente no tiene un codigo de ubigeo válido o le falta un correo electrónico válido. Vuelva a reingresarlos!'); location.href = 'rgvtcajatmp.php'; </script>";
										}
									}
									else
									{
										echo "<script> alert('El cliente no tiene el documento de identidad (DNI o RUC) correspondiente con el comprobante. Vuelva a revisarlo!'); location.href = 'rgvtcajatmp.php'; </script>";
									}
								}
								else
								{
									echo "<script> alert('Ya existe un codigo de comprobante de pago o serie-numero de comprobante con ese mismo número, ¡Vuelva a ingresarlo!...'); location.href = 'rgvtcajatmp.php'; </script>";
								}
							}
							else
							{
								echo "<script> alert('No hay datos para el comprobante de pago. ¡No se puede continuar!'); location.href = 'rgvtcajatmp.php'; </script>";
							}
						}
						else
						{
							echo "<script> alert('Ya se hizo el cobro del comprobante de pago. ¡No se puede realizar la misma operación!'); window.close(); </script>";
						}
					}
					//---------------------------------------------------------- Reimpresion ----------------------------------------------------------
					if($btn=="Reimpresión")
					{
						/*Recoge datos principales:
						codcpg_rvi = para filtrar registros por codigo de comprobante de pago
						numcp_rvi = para actualizar el numero del comprobante de pago fisico */
						$ccp=$_POST["txtccp"];//codcpg_rvi
						$ncv=$_POST["txtncv"];//numcp_rvi
						// Actualizar regventas solo para numero del comprobante de pago
						$cadena_sql0 = "UPDATE regventas SET numcp_rvi='$ncv' WHERE codcpg_rvi='$ccp'";
						mysqli_query($Conexion, $cadena_sql0) or die("Error al modificar datos");
						//Actualizar regvtacaja solo para numero del comprobante de pago
						$cadena_sql1="UPDATE regvtacaja SET numcp_rvi='$ncv' WHERE codcpg_rvi='$ccp'";
						mysqli_query ($Conexion,$cadena_sql1) or die("Error al agregar datos");
						//Abre ventana de impresion de boletas temporal
						echo "<script> window.open('../admin/rgvtcajaimpbol_tmp.php?comprobante=$ccp', '_blank', 'width=1280, height=800, left=0, top=0, menubar=no, toolbar=no, scrollbars=yes, resizable=no, status=no'); </script>";
						echo "<script> window.close(); </script>";
					}
					//---------------------------------------------------------- Buscar ----------------------------------------------------------
					if($btn=="Buscar")
					{
						$ccp=$_POST["txtbus"];
						if ($ccp<>"")
						{
							$sql= mysqli_query ($Conexion,"SELECT * from rgvtatmp WHERE codcpg_rvi='$ccp'") or die ("Error al traer los datos");
							$num_filas=mysqli_num_rows($sql);
							if($num_filas>0)
							{	
								mysqli_data_seek($sql, 0); 
								$resul=mysqli_fetch_array($sql, MYSQLI_ASSOC);
								$id_rvi=$resul["id_rvi"];
								$id_cli=$resul["id_cli"];
								$fechaemi_rvi=$resul["fechaemi_rvi"];
								$fechaven_rvi=$resul["fechaven_rvi"];
								$codcpg_rvi=$resul["codcpg_rvi"];
								// Sumar todos los datos de la tabla rgvtatmp del total de los productos
								$sql_suma = mysqli_query($Conexion,"SELECT SUM(importetot_rvi) AS total FROM rgvtatmp WHERE codcpg_rvi='$ccp'");	
								$dato = mysqli_fetch_array($sql_suma, MYSQLI_ASSOC);
								$importetot_rvi=$dato["total"];//total
								// Obtiene datos de comprobante de pago de datprinctmp
								$sql_datprinctmp= mysqli_query ($Conexion,"SELECT * from datprinctmp WHERE codcpg_rvi='$ccp'") or die ("Error al traer los datos");
								$num_filas=mysqli_num_rows($sql_datprinctmp);
								if($num_filas>0)
								{
									mysqli_data_seek($sql_datprinctmp, 0); 
									$resul=mysqli_fetch_array($sql_datprinctmp, MYSQLI_ASSOC);
									$tipodoccp_rvi=$resul["tipodoccp_rvi"];
									$seriecp_rvi=$resul["seriecp_rvi"];
									$numcp_rvi=$resul["numcp_rvi"];
									$descrip_rvi=$resul["descrip_rvi"];
									$formapago_rvi=$resul["formapago_rvi"];
									$rgpag_rvc=$resul["rgpag_rvc"];
								}
								if (!empty($tipodoccp_rvi))
								{
									if ($tipodoccp_rvi=="Boleta de venta")
									{
										$baseimpopgrv_rvi=$importetot_rvi;
										$baseimpopngrv_rvi=0;
										$isc_rvi=0;
										$igv_rvi=0;
									}
									else
									{
										//$baseimpopgrv_rvi=$importetot_rvi/1.18;//Sub Total
										$baseimpopgrv_rvi=$importetot_rvi;//Sub Total Exonerado
										$baseimpopngrv_rvi=0;
										$isc_rvi=0;
										$igv_rvi=0;//IGV Exonerado
									}
								}
								else
								{
									$baseimpopgrv_rvi=$baseimpopngrv_rvi=$isc_rvi=$igv_rvi=0;
								}
								// $vsubtt=round($importetot_rvi/1.18,2);//Sub Total
								// $valigv=$importetot_rvi-$vsubtt;//IGV
								$vsubtt=$importetot_rvi;//Sub Total
								$valigv=0;//IGV
							}
							else
							{
								echo "<script> alert('No se encuentra el registro'); location.href = 'rgvtcajatmp.php'; </script>";
							}
						}
						else
						{
							echo "<script> alert('Falta el id para la búsqueda de registros'); location.href = 'rgvtcajatmp.php'; </script>";
						}
					}
					//---------------------------------------------------------- BuscaReg.Final ----------------------------------------------------------
					if($btn=="BuscaReg.Final")
					{
						$ccp=$_POST["txtbus"];
						if ($ccp<>"")
						{
							$sql= mysqli_query ($Conexion,"SELECT * from regventas WHERE codcpg_rvi='$ccp'") or die ("Error al traer los datos");
							$num_filas=mysqli_num_rows($sql);
							if($num_filas>0)
							{	
								mysqli_data_seek($sql, 0); 
								$resul=mysqli_fetch_array($sql, MYSQLI_ASSOC);
								$id_rvi=$resul["id_rvi"];
								$id_cli=$resul["id_cli"];
								$fechaemi_rvi=$resul["fechaemi_rvi"];
								$fechaven_rvi=$resul["fechaven_rvi"];
								$tipodoccp_rvi=$resul["tipodoccp_rvi"];
								$seriecp_rvi=$resul["seriecp_rvi"];
								$numcp_rvi=$resul["numcp_rvi"];
								$descrip_rvi=$resul["descrip_rvi"];
								$formapago_rvi=$resul["formapago_rvi"];
								$codcpg_rvi=$resul["codcpg_rvi"];
								$rgpag_rvc=$resul["rgpag_rvc"];
								// Sumar todos los datos de la tabla rgvtatmp del total de los productos
								$sql_suma = mysqli_query($Conexion,"SELECT SUM(importetot_rvi) AS total FROM regventas WHERE codcpg_rvi='$ccp'");	
								$dato = mysqli_fetch_array($sql_suma, MYSQLI_ASSOC);
								$importetot_rvi=$dato["total"];
								if (!empty($tipodoccp_rvi))
								{
									if ($tipodoccp_rvi=="Boleta de venta")
									{
										$baseimpopgrv_rvi=$importetot_rvi; $baseimpopngrv_rvi=0; $isc_rvi=0; $igv_rvi=0;
									}
									else
									{
										$baseimpopgrv_rvi=$importetot_rvi;	$baseimpopngrv_rvi=0; $isc_rvi=0;	$igv_rvi=0;
									}
								}
								else
								{
									$baseimpopgrv_rvi=$baseimpopngrv_rvi=$isc_rvi=$igv_rvi=0;
								}
							}
							else
							{
								echo "<script> alert('No se encuentra el registro'); location.href = 'rgvtcajatmp.php'; </script>";
							}
						}
						else
						{
							echo "<script> alert('Falta el id para la búsqueda de registros'); location.href = 'rgvtcajatmp.php'; </script>";
						}
					}
					//---------------------------------------------------------- Actualizar ----------------------------------------------------------
					if($btn=="Actualizar")
					{
						echo "<script> location.href = 'rgvtcajatmp.php'; </script>";
					}
					//---------------------------------------------------------- Imprimir ----------------------------------------------------------
					if($btn=="Imprimir")
					{
						// Considerar en configuración de IE/Herramientas/Imprimir/Configurar páginas modificar los siguientes parámetros
						// para evitar que aparezcan el nombre de archivo, numero de página, URL y fecha:
						// Encabezado: Titulo y Personalizdo, escoger Vacío
						// Pié de página: URL y Fecha, escoger Vacío
						$ccp=$_POST["txtccp"];//codcpg_rvi
						$tdv=$_POST["cmbtdv"];//tipodoccp_rvi
						//echo "<script> alert('$tdv'); </script>";
						if ($tdv=="Boleta de venta")
						{
							echo "<script> window.open('../admin/rgvtcajaimpbol.php?comprobante=$ccp', '_blank', 'width=1280, height=800, left=0, top=0, menubar=no, toolbar=no, scrollbars=yes, resizable=no, status=no'); </script>";
						}
						if ($tdv=="Factura")
						{
							echo "<script> window.open('../admin/rgvtcajaimpfac.php?comprobante=$ccp', '_blank', 'width=1280, height=800, left=0, top=0, menubar=no, toolbar=no, scrollbars=yes, resizable=no, status=no'); </script>";
						}
					}
					//---------------------------------------------------------- Cliente ----------------------------------------------------------
					if($btn=="Actualizar Clientes")
					{
						$id_cli=$_POST["txtcli"];
						echo "<script> window.open('../admin/clientes_actualizar.php?id_cli=$id_cli', '_blank', 'width=1245, height=550, left=0, top=0, menubar=no, toolbar=no, scrollbars=yes, resizable=no, status=no'); </script>";
					}
					if ($btn=="Anular Venta")
					{
						// Datos retenidos en datprinctmp
						if ($nivel_usuario=="tot")
						{
							$sqldtt= mysqli_query ($Conexion,"SELECT * FROM datprinctmp") or die ("Error al traer los datos de datprinctmp.");
						}
						else
						{
							$sqldtt= mysqli_query ($Conexion,"SELECT * FROM datprinctmp WHERE id_usr='$ident_usuario'") or die ("Error al traer los datos de datprinctmp.");
						}
						$datos=mysqli_num_rows($sqldtt);
						cancelar_venta($Conexion,$datos,$ident_usuario);
						mysqli_query($Conexion, "DELETE FROM selprovta WHERE id_usr='$ident_usuario'") or die ("Error al eliminar registro al cancelar venta en selprovta.");
						echo "<script> window.close(); </script>";
					}
				}
				//Busca el codigo de comprobante (codcpg_rvi) cargado directamente en el link del archivo
				if ($btn=="Buscar" AND !empty($ccp))
				{
					buscar_codcpg($Conexion,$ccp,$vincbv,$vincfc,$id_rvi,$id_cli,$fechaemi_rvi,$fechaven_rvi,$tipodoccp_rvi,$seriecp_rvi,$numcp_rvi,$descrip_rvi,$formapago_rvi,
					$baseimpopgrv_rvi,$baseimpopngrv_rvi,$isc_rvi,$igv_rvi,$codcpg_rvi,$rgpag_rvc,$importetot_rvi,$descrip_cli_tmp,$vsubtt,$valigv);
				}
				?>
				<!---------------------------------------------------------- Formulario ---------------------------------------------------------->
				<form name="usuario" action="" method="post">
					<div><?php 
						lblnorm("Buscar Código Comprobante de Pago:","etq8"); txtnrmstl("txtbus","width:50px;");
						btnnormal("btnGrl", "Buscar"); btnnormal("btnGrl", "Actualizar"); btnnormal("btnGrl", "Actualizar Clientes"); lblspace(2); 
						if ($nivel_usuario<>"tot")	{ btnnormal("btnGrl", "Cobrar"); } lblspace(2); btnnormal("btnGrl", "Anular Venta"); echo "<hr>"; 
						txtoculto("txtnumreg",$numreg); txtoculto("txt_vincbv",$vincbv); txtoculto("txt_vincfc",$vincfc);
						txtoculto("txt_vsubtt",$vsubtt); txtoculto("txt_valigv",$valigv);?>
					</div>
					<div class="formulario">
						<div><?php 
							lblnorm("ID.RV.:","etq2"); txtronstl("txtid",$id_rvi,"width:50px;");
							lblnorm("Cliente:","etq14"); txtronstl("txtcli",$id_cli,"width:50px;"); echo valfldmul($Conexion, "clientes", "id_cli", $id_cli, "nom_rzs_cli", "dni_ruc_cli", "direcc_cli", "lugar_cli"); echo "<br>";
							lblnorm("Fecha de emisión:","etq2"); txtronstl("txtfev",$fechaemi_rvi,"width:80px;"); lblspace(3);
							lblnorm("Fecha de venta:","etq5"); txtronstl("txtfvv",$fechaven_rvi,"width:80px;"); lblspace(3);
							lblnorm("Cod. Comprob. Pago:","etq5"); txtronstl("txtccp",$codcpg_rvi,"width:50px;"); echo "<br>";?>
						</div><hr>
						<div id="colizq" style="float:left; width:50%;"><?php 
							lblnorm("Documento:","etq2"); cmbnormal_onchg("cmbtdv", $tipodoccp_rvi, "Boleta de venta", "Factura"); echo "<br>";
							$seriecp_rvi=num_serie_doc($zona_usuario); // Obtiene el numero de serie de boleta y factura
							//$seriecp_rvi=1; // El numero de serie es unico y solo se diferenciará por la zona o almacen
							lblnorm("Serie:","etq2"); txtronstl("txtsrv",$seriecp_rvi,"width:30px;"); lblspace(1);
							lblnorm("N°:","etq5"); txtronstl("txtncv",$numcp_rvi,"width:50px;"); echo "<br>";
							lblnorm("Descripción:","etq2"); txtvalue("txtdsv",$descrip_rvi,50); echo "<br>";
							lblnorm("Forma de pago:","etq2"); cmbnormal("cmbfpv", $formapago_rvi, "Contado"); echo "<br>";
							lblnorm("Estado de pago:","etq2"); cmbnormal("cmbpag", $rgpag_rvc, "Pagado", "NoPago");?>
						</div>
						<div id="colder" style="float:left; width:50%;"><?php 
							lblnorm("Bas.imp.prod. grv.:","etq2"); txtrdonly("txtbgr",$baseimpopgrv_rvi); echo "<br>";
							lblnorm("Bas.imp.prod. no grv.:","etq2"); txtrdonly("txtbng",$baseimpopngrv_rvi); echo "<br>";
							lblnorm("ISC:","etq2"); txtrdonly("txtisc",$isc_rvi); echo "<br>";
							lblnorm("IGV:","etq2"); txtrdonly("txtigv",$igv_rvi); echo "<br>";
							lblnorm("Importe total:","etq2"); txtrdonly("txtitv",$importetot_rvi);?>
						</div>
						<div style="clear:both"></div>
					</div>
					<hr>
				</form> <!-- Fin de formulario -->
				<!-- Inicio de listado de datos de usuario -->	
				<center>
					<div style="width:100%; overflow:auto; height:160px;">
						<table border='0' cellspacing='0' cellpadding='0' class="tblnormal">
							<tr style="display:table-header-group;">
							<th>ID</th>
							<th>Cliente</th>
							<th>Producto</th>
							<th>Tipo Plan</th>
							<th>Plan</th>
							<th>Fecha de Venta</th>
							<th>Cód. Comp.Pago</th>
							<th>Docum.</th>
							<th>Serie</th>
							<th>Número</th>
							<th>Descripción</th>
							<th>Importe</th>
							<th>Estad.Pago</th>
							<th>Nº Contrato</th>
							<th>Nº Celular</th>
							<th>Cód. Paquete</th>
							<th>Estado</th>
							</tr>
							<?php
							mysqli_data_seek($sql, 0); 
							while($resul = mysqli_fetch_array($sql))
							{
							$id_rvi=$resul[0];//id_rvi
							$id_cli=$resul[1];//id_cli
							$id_pro=$resul[2];//id_pro
							$tipopla_rvi=$resul[3];//tipopla_rvi
							$id_pla=$resul[4];//id_pla
							$fechaven_rvi=$resul[6];//fechaven_rvi
							$codcpg_rvi=$resul[21];//codcpg_rvi
							$tipodoccp_rvi=$resul[7];//tipodoccp_rvi
							$seriecp_rvi=$resul[8];//seriecp_rvi
							$numcp_rvi=$resul[9];//numcp_rvi
							$descrip_rvi=$resul[10];//descrip_rvi
							$importetot_rvi=$resul[16];//importetot_rvi
							$rgpag_rvc=$resul[22];//rgpag_rvc
							$numcont_rvi=$resul[18];//numcont_rvi
							$numcel_rvi=$resul[19];//numcel_rvi
							$codpqt_rvi=$resul[20];//codpqt_rvi
							$rgpag_rvc=$resul[22];//rgpag_rvc
							?>
							<tr align='center' style="display:table-header-group;">
							<td><?php echo $id_rvi ?></td>
							<td><?php echo $id_cli.":".valfield($Conexion,"clientes","nom_rzs_cli","id_cli",$id_cli); ?></td>
							<td><?php echo $id_pro.":".valfield($Conexion,"productos","abrv_pro","id_pro",$id_pro); ?></td>
							<td><?php echo $tipopla_rvi ?></td>
							<td><?php echo $id_pla.":".valfield($Conexion,"planes","abrv_pla","id_pla",$id_pla); ?></td>
							<td><?php echo $fechaven_rvi ?></td>
							<td><?php echo $codcpg_rvi ?></td>
							<td><?php echo $tipodoccp_rvi ?></td>
							<td><?php echo $seriecp_rvi ?></td>
							<td><?php echo $numcp_rvi ?></td>
							<td><?php echo $descrip_rvi ?></td>
							<td><?php echo $importetot_rvi ?></td>
							<td><?php echo $rgpag_rvc ?></td>
							<td><?php echo $numcont_rvi ?></td>
							<td><?php echo $numcel_rvi ?></td>
							<td><?php echo $codpqt_rvi ?></td>
							<td><?php echo $rgpag_rvc ?></td>
							</tr>
							<?php
							}
							?>
						</table>
						<br>
					</div>	
				</center> <!-- Fin de listado de datos de usuario -->
			</div><!--Fin de main-col-->
			<div class="clr"></div>
			<div class="piepag"><?php pie_pagina();?></div>
		</div><!--Fin de container-->
	</body>
</html>
<!---------------------------------------------- Funciones JavaScript ---------------------------------------------->
<script language=JavaScript>
	function clear_textbox(objeto)
	/* Funcion que limpia el cuadro de texto del objeto elegido en un boton.*/
	{
		objeto.value = "";
	}
	function seleccionar_valor(valor)
	/* Selecciona el incremento segun el tipo de comprobante elegido: boleta de venta o factura.
	La variable valor contiene el tipo de documento.*/
	{
		if (valor == null || valor.length == 0 || /^\s+$/.test(valor) )
		{
			document.getElementsByName("txtncv")[0].value="";
		}
		else
		{
			if (valor=="Boleta de venta")
			{
				var_inc=document.getElementsByName("txt_vincbv")[0].value;
				document.getElementsByName("txtncv")[0].value=var_inc;
			}
			if (valor=="Factura")
			{
				var_inc=document.getElementsByName("txt_vincfc")[0].value;
				var_sub=document.getElementsByName("txt_vsubtt")[0].value;
				var_igv=document.getElementsByName("txt_valigv")[0].value;
				document.getElementsByName("txtncv")[0].value=var_inc;
				document.getElementsByName("txtbgr")[0].value=var_sub;
				document.getElementsByName("txtigv")[0].value=var_igv;
			}
		}
	}
</script>
<!--------------------------------------------------- Funciones PHP --------------------------------------------------->
<?php
/* Genera un botón para limpiar un control cuadro de texto con nombre $nombreboton */
function clr_boton($nombreboton)
{ ?>
	<input type="button" name=boton1 onclick=clear_textbox(this.form.<?php echo $nombreboton;?>) value="X" style="border-radius:5px; height:17px; border:1px; background-color:rgb(230,180,100); color:rgb(255,255,255);"/>	
<?php
}
/* Genera espacios forzados en blanco según la cantidad indicada en $espacios */
function lblspace($espacios)
{ ?>
	<span> <?php for ($x=1; $x<=$espacios; $x++) echo "&nbsp;"; ?> </span>
<?php
}
function incr_comp_bv($conx,$zona)
{
	$numdoc="";
	if (!empty($zona))
	{
		$consultaultnum= mysqli_query ($conx,"SELECT * FROM regvtacaja WHERE (zona_rvi='$zona' AND tipodoccp_rvi='Boleta de venta') ORDER BY numcp_rvi DESC") or die ("Error en incremento de boleta de venta ".$zona);
		mysqli_data_seek($consultaultnum, 0); 
		$r = mysqli_fetch_array($consultaultnum,MYSQLI_ASSOC);
		$numdoc=$r["numcp_rvi"];
		$numdoc=$numdoc+1;
		return $numdoc;
	}
}
function incr_comp_fc($conx,$zona)
{
	$numdoc="";
	if (!empty($zona))
	{
		$consultaultnum= mysqli_query ($conx,"SELECT * FROM regvtacaja WHERE (zona_rvi='$zona' AND tipodoccp_rvi='Factura') ORDER BY numcp_rvi DESC") or die ("Error en incremento de factura ".$zona);
		mysqli_data_seek($consultaultnum, 0); 
		$r = mysqli_fetch_array($consultaultnum,MYSQLI_ASSOC);
		$numdoc=$r["numcp_rvi"];
		$numdoc=$numdoc+1;
		return $numdoc;
	}
}
function tipo_comprobante($tc)
{
	if ($tc=="Boleta de venta")
	{
		return 2;
	}
	if ($tc=="Factura")
	{
		return 1;
	}
}
function unidad_comercial($zona)
{
	$id_undc=0;
	if (!empty($zona))
	{
		switch ($zona)
		{
			case "JUNCD05":
				$id_undc=1;
				break;
			case "JUNDL39":
				$id_undc=2;
				break;
			case "JUNDL43":
				$id_undc=3;
				break;
			case "PRE_DL39":
				$id_undc=4;
				break;
			//case "PRE_DL43":
			//	$id_undc=6;
			//	break;
			case "JUNCD12":
				$id_undc=5;
				break;	
			case "Almacen1":
				$id_undc=7;
				break;
			case "Almacen2":
				$id_undc=8;
				break;
			case "Almacen3":
				$id_undc=9;
				break;
			case "Almacen4":
				$id_undc=10;
				break;
			case "Almacen5":
				$id_undc=11;
				break;
			case "JUNDA29":
				$id_undc=6;
				break;
		}
		return $id_undc;
	}
}
function verificar_tipo_documento_cliente_x_comprobante($conx,$tipodoccp_rvi,$id_tipo_documento)
{
	$estado_documento=false;
	if ($tipodoccp_rvi=="Boleta de venta" AND $id_tipo_documento==2) { $estado_documento=true; }
	if ($tipodoccp_rvi=="Factura" AND $id_tipo_documento==4) { $estado_documento=true; }
	return $estado_documento;
}
function buscar_codcpg($Conexion,$ccp,$vincbv,$vincfc,&$id_rvi,&$id_cli,&$fechaemi_rvi,&$fechaven_rvi,&$tipodoccp_rvi,&$seriecp_rvi,&$numcp_rvi,
&$descrip_rvi,&$formapago_rvi,&$baseimpopgrv_rvi,&$baseimpopngrv_rvi,&$isc_rvi,&$igv_rvi,&$codcpg_rvi,&$rgpag_rvc,&$importetot_rvi,&$descrip_cli_tmp,&$vsubtt,&$valigv)
{
	$sql=mysqli_query($Conexion,"SELECT * FROM rgvtatmp WHERE codcpg_rvi='$ccp'") or die ("Error al traer los datos de rgvtatmp por ccp.");
	$num_filas=mysqli_num_rows($sql);
	if($num_filas>0)
	{	
		mysqli_data_seek($sql, 0); 
		$resul=mysqli_fetch_array($sql, MYSQLI_ASSOC);
		$id_rvi=$resul["id_rvi"];
		$id_cli=$resul["id_cli"];
		$fechaemi_rvi=$resul["fechaemi_rvi"];
		$fechaven_rvi=$resul["fechaven_rvi"];
		$codcpg_rvi=$resul["codcpg_rvi"];
		// Sumar todos los datos de la tabla rgvtatmp del total de los productos
		$sql_suma=mysqli_query($Conexion,"SELECT SUM(importetot_rvi) AS total FROM rgvtatmp WHERE codcpg_rvi='$ccp'");	
		$dato=mysqli_fetch_array($sql_suma, MYSQLI_ASSOC);
		$importetot_rvi=$dato["total"];//total
		// Obtiene datos de comprobante de pago de datprinctmp
		$sql_datprinctmp= mysqli_query ($Conexion,"SELECT * FROM datprinctmp WHERE codcpg_rvi='$ccp'") or die ("Error al traer los datos de datprinctmp.");
		$num_filas=mysqli_num_rows($sql_datprinctmp);
		if($num_filas>0)
		{
			mysqli_data_seek($sql_datprinctmp, 0); 
			$resul=mysqli_fetch_array($sql_datprinctmp, MYSQLI_ASSOC);
			$tipodoccp_rvi=$resul["tipodoccp_rvi"];
			$seriecp_rvi=$resul["seriecp_rvi"];
			$numcp_rvi=$resul["numcp_rvi"];
			$descrip_rvi="Venta";
			$formapago_rvi="Contado";
			$rgpag_rvc="Pagado";
			//$descrip_cli_tmp=$resul["descrip_cli_tmp"];
		}
		if (fijar_tipocomprobante_cliente($Conexion,$id_cli)=='DNI')
		{
			$tipodoccp_rvi="Boleta de venta";
		}
		else
		{
			$tipodoccp_rvi="Factura";
		}
		if (!empty($tipodoccp_rvi))
		{
			if ($tipodoccp_rvi=="Boleta de venta")
			{
				$baseimpopgrv_rvi=$importetot_rvi;
				$baseimpopngrv_rvi=0;
				$isc_rvi=0;
				$igv_rvi=0;
				$numcp_rvi=$vincbv;
			}
			else
			{
				$baseimpopgrv_rvi=$importetot_rvi;//Sub Total Exonerado
				$baseimpopngrv_rvi=0;
				$isc_rvi=0;
				$igv_rvi=0;//IGV Exonerado
				$numcp_rvi=$vincfc;
			}
		}
		else
		{
			$baseimpopgrv_rvi=$baseimpopngrv_rvi=$isc_rvi=$igv_rvi=0;
		}
		// $vsubtt=round($importetot_rvi/1.18,2);//Sub Total
		// $valigv=$importetot_rvi-$vsubtt;//IGV
		$vsubtt=$importetot_rvi;//Sub Total
		$valigv=0;//IGV
	}
	else
	{
		echo "<script> alert('No se encuentra el registro en rgvtatmp.'); location.href = 'rgvtcajatmp.php'; </script>";
	}
}
function fijar_tipocomprobante_cliente($Conexion,$id_cli)
{
	$consulta_cliente="SELECT a.id_tipdoc, b.abrev_tipdoc FROM clientes a LEFT JOIN tipodocident b ON a.id_tipdoc=b.id_tipdoc WHERE id_cli='$id_cli'";
	$resultado=mysqli_query($Conexion,$consulta_cliente);
	$num_filas=mysqli_num_rows($resultado);
	if ($num_filas>0)
	{
		$dato=mysqli_fetch_array($resultado, MYSQLI_ASSOC);
		$tipo=$dato["abrev_tipdoc"];
		return $tipo;
	}
	else
	{
		return "";
	}
}
function verificar_comprobante_duplicado($Conexion, $codigo_comprobante_pago, $tipo_documento, $serie, $numero)
{
	$consulta = mysqli_query ($Conexion,"SELECT id_rvc, codcpg_rvi, tipodoccp_rvi, seriecp_rvi, numcp_rvi FROM regvtacaja WHERE codcpg_rvi='$codigo_comprobante_pago' OR (tipodoccp_rvi='$tipo_documento' AND (seriecp_rvi='$serie' AND numcp_rvi='$numero'))") or die ("Error al traer los datos de consulta de duplicados de regvtacaja.");
	if (mysqli_num_rows($consulta) == 0) { return true; }
	else { return false; }
}
function obtener_datos_cliente($Conexion, $id_cliente, &$correo_cliente, &$id_ubigeo, &$id_tipo_documento)
{
	$consulta = "SELECT id_cli, email_cli, id_ubi, id_tipdoc FROM clientes WHERE id_cli='$id_cliente'";
	$resultado = mysqli_query($Conexion,$consulta);
	if (mysqli_num_rows($resultado) > 0)
	{
		$registro = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
		$correo_cliente = $registro["email_cli"];
		$id_ubigeo = $registro["id_ubi"];
		$id_tipo_documento = $registro["id_tipdoc"];
	}
	else
	{
		$correo_cliente = "";
		$id_ubigeo = "";
		$id_tipo_documento = "";
	}
}
function verificar_codcpg_rvi_existente_y_estado_rvc_anulado($Conexion, $codigo_de_comprobante)
{
	$consulta = mysqli_query ($Conexion,"SELECT * FROM regvtacaja WHERE (codcpg_rvi='$codigo_de_comprobante') AND (estado_rvc<>'anulado')") or die ("Error al traer los datos de regvtacaja al verificar codigo de comprobante y estado anulado.");
	if (mysqli_num_rows($consulta) == 0) {	return true; }
	else { return false; }
}
function devuelve_ultimo_id_rvc_creado($Conexion, $codigo_comprobante, $serie, $numero)
{
	$consulta = mysqli_query($Conexion,"SELECT id_rvc FROM regvtacaja WHERE codcpg_rvi='$codigo_comprobante' AND seriecp_rvi='$serie' AND numcp_rvi='$numero'") or die("Error al buscar id_rvc en regvtacaja luego de insertar un registro.");
	if (mysqli_num_rows($consulta)>0)
	{
		$registro = mysqli_fetch_array($consulta, MYSQLI_ASSOC);
		return $registro["id_rvc"];
	}
	else { return "";	}
}
function cargar_datos_desde_formulario(&$id_cliente, &$fecha_emision, &$fecha_venta, &$codigo_comprobante, &$tipo_documento_comprobante, &$serie_comprobante, &$numero_comprobante, &$descripcion_venta, &$forma_de_pago, &$estado_de_pago, &$base_imponible_producto_gravado, &$base_imponible_producto_no_gravado, &$impuesto_selectivo_consumo, &$igv, &$importe_total_venta)
{
	$id_cliente=$_POST["txtcli"];//id_cli
	$fecha_emision=$_POST["txtfev"];//fechaemi_rvi
	$fecha_venta=$_POST["txtfvv"];//fechaven_rvi
	$codigo_comprobante=$_POST["txtccp"];//codcpg_rvi
	$tipo_documento_comprobante=$_POST["cmbtdv"];//tipodoccp_rvi
	$serie_comprobante=$_POST["txtsrv"];//seriecp_rvi
	$numero_comprobante=$_POST["txtncv"];//numcp_rvi 
	$descripcion_venta=$_POST["txtdsv"];//descrip_rvi
	$forma_de_pago=$_POST["cmbfpv"];//formapago_rvi (Contado, Credito, ...)
	$estado_de_pago=$_POST["cmbpag"];//rgpag_rvc (Pagado, NoPago)
	$base_imponible_producto_gravado=$_POST["txtbgr"];//baseimpopgrv_rvi
	$base_imponible_producto_no_gravado=$_POST["txtbng"];//baseimpopngrv_rvi
	$impuesto_selectivo_consumo=$_POST["txtisc"];//isc_rvi
	$igv=$_POST["txtigv"];//igv_rvi
	$importe_total_venta=$_POST["txtitv"];//importetot_rvi
	//Modificado por JUAN (10-02-2019): $bgr=$itv e $igv=0 debido a que estan EXONERADOS
	$base_imponible_producto_gravado=$importe_total_venta;
	$igv=0.00;
}
function verificar_ubigeo_y_correocliente($id_ubigeo, $correo_cliente)
{
	if (!empty($id_ubigeo) AND !empty($correo_cliente))
	{
		return true;
	}
	else
	{
		return false;
	}
}
function insertar_datos_comprobante_en_regvtacaja($Conexion, $idc, $fev, $fvv, $ccp, $tdv, $srv, $ncv, $dsv, $fpv, $bgr, $bng, $isc, $igv, $itv, $ident_usuario, $pag, $zona_usuario, $id_ubigeo, $id_tipo_documento)
{
	date_default_timezone_set("America/Lima");
	insertarsql($Conexion,"Error al insertar registro en regvtacaja.","regvtacaja",
	"id_cli", $idc,
	"fechaemi_rvi", $fev,
	"horaemi_rvi", date("H:i:s"),
	"fechaven_rvi", $fvv,
	"codcpg_rvi", $ccp,
	"tipodoccp_rvi", $tdv,
	"seriecp_rvi", $srv,
	"numcp_rvi", $ncv,
	"descrip_rvi", $dsv,
	"formapago_rvi", $fpv,
	"baseimpopgrv_rvi", $bgr,
	"baseimpopngrv_rvi", $bng,
	"isc_rvi", $isc,
	"igv_rvi", $igv,
	"importetot_rvi", $itv,
	"id_usr", $ident_usuario,
	"rgpag_rvc", $pag,
	"zona_rvi", $zona_usuario,
	"cee_rvc", 0,
	"id_ubi", $id_ubigeo,
	"id_undc", unidad_comercial($zona_usuario),
	"id_tipcmp", tipo_comprobante($tdv),
	"id_empe", '1',
	"id_tipdoc", $id_tipo_documento,
	"id_elad", '1');
}
function generar_pdf_y_enviar_mail($id_rvc)
{
	require_once './comprobante.php';
	$generatePDF=generatePDFComprante($id_rvc);
	//	Si se genera correctamente el PDF se envía el correo $response_email=sendComprobanteEmail($id_rvc).
	//	De lo contrario se muestra el error de $generatePDF.
	if(!$generatePDF['status'])
	{
		echo sprintf("<div display='none'>%s</div>", $generatePDF['error']);
		echo "No se ha generado el PDF correctamente.<br>";
	}
	else
	{
		echo "Se ha generado el PDF correctamente.<br>";
		$response_email=sendComprobanteEmail($id_rvc);
		if (!$response_email['status'])
		{
			echo "No se ha enviado un mail de manera correcta.<br>", $response_email['error'];
			var_dump($response_email); echo "<br>";
		}
		else
		{
			echo "Se ha enviado un mail de manera correcta.<br>";
			echo sprintf("<div display='none'>%s</div>", $response_email['error']);
			var_dump($response_email); echo "<br>";
		}
	}
}
function actualizar_registro_de_venta_temporal_rgvtatmp($Conexion, $tdv, $srv, $ncv, $dsv, $fpv, $pag, $ccp)
{
	$cadena = "UPDATE rgvtatmp SET 
	tipodoccp_rvi='$tdv', 
	seriecp_rvi='$srv', 
	numcp_rvi='$ncv', 
	descrip_rvi='$dsv', 
	formapago_rvi='$fpv', 
	rgpag_rvc='$pag' 
	WHERE codcpg_rvi='$ccp'";
	mysqli_query($Conexion, $cadena) or die("Error al actualizar datos en rgvtatmp durante el proceso de Cobrar la venta.");
}
function actualizar_registro_datos_principal_datprinctmp($Conexion, $tdv, $srv, $ncv, $dsv, $fpv, $pag, $ccp)
{
	$cadena = "UPDATE datprinctmp SET 
	tipodoccp_rvi='$tdv', 
	seriecp_rvi='$srv', 
	numcp_rvi='$ncv', 
	descrip_rvi='$dsv', 
	formapago_rvi='$fpv', 
	rgpag_rvc='$pag' 
	WHERE codcpg_rvi='$ccp'";
	mysqli_query ($Conexion,$cadena) or die("Error al actualizar datos en datprinctmp durante el proceso de Cobrar la venta.");
}
?>