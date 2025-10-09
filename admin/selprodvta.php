<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
sesion01($id_usr, $nick_usr, $nombre_usr, $apellido_usr, $nivel_usr, $zona_usr, $categ_usr);
conexiondb($Conexion);
/* Variables de busqueda: id_pro, abrv_pro, tipo_cat, clase_cat, codpqt_rvi, id_usr, id_cli, tipopla_rvi, id_pla, fechaemi_rvi, fechaven_rvi, codcpg_rvi, importetot_rvi, imprecef_rvi */
$var0=$var1=$var2=$var3=$var4=$var5=$var6=$var7=$var8=$var9=$var10=$var11=$var12=$var13=$numreg=$cantactual=$cla_pro=$tip_pro=$id_producto=$varmntrec="";
$var_ser_ime_icc="";
muestraDatos_x_innerHTML_Js()
?>
<script>
	function muestra_stock_juego(valor_combobox)
	{
		var id_pro = document.getElementById(valor_combobox).value;
		muestraDatos_x_innerHTML("lbl_saldo_stock_juego", id_pro, "selprodvta.obtener_stock_juego.php");
	}
	function CambiarValor(id_select)
	{
		var dato_seleccionado = document.getElementById(id_select).value
		if (dato_seleccionado == "Juego")
		{
			if (document.getElementById("txt_precio_juego")==null)
			{
				alert("No se ha selecionado un producto de Juego previamente.");
				document.getElementById("cmbtip").value="";
			}
			else
			{
				document.getElementById("txtimp").value = document.getElementById("txt_precio_juego").value
				document.getElementById("txtimp").readOnly=true;
				document.getElementById("txtimp").style.backgroundColor = "#E6E6FF";
			}
		}
		else
		{
			document.getElementById("txtimp").value = "";
		}
	}
</script>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nick_usr, $nivel_usr, $id_usr, $zona_usr, $categ_usr, "Selección de productos");?></head>
	<body>
		<?php //$ancho=855;?>
		<!--<div id="container" style="width:<?php //echo $ancho+30;?>px;">-->
		<div>
			<?php //cabecera03("Selección de productos");?>
			<?php //cabecera02("Selección de productos");?>
			<?php cabecera04(0,"Selección de productos");?>
			<!--<div id="main-col2" style="width:<?php //echo $ancho;?>px;">-->
			<div id="main-col2" style="width:100%;">
				<?php
				$sql= mysqli_query ($Conexion,"SELECT * from selprovta  WHERE id_usr='$id_usr'") or die ("Error al traer los datos");
				// Obtiene datos de codigo de paquete de codpaquete por usuario
				$sqlcpq= mysqli_query ($Conexion,"SELECT * from codpaquete WHERE id_usr='$id_usr'") or die ("Error al traer los datos");$datcpq=mysqli_fetch_array($sqlcpq);$var4=$datcpq[0];//id_codcpg
				//datosretenidos en datprinctmp
				$sqldtt= mysqli_query ($Conexion,"SELECT * from datprinctmp WHERE id_usr='$id_usr'") or die ("Error al traer los datos"); $datos=mysqli_num_rows($sqldtt);
				if ($datos>0)
				{
					$datlista=mysqli_fetch_array($sqldtt);
					$idc=$datlista[0];//id_cli
					$fem=$datlista[1];//fechaemi_rvi
					$fvn=$datlista[2];//fechaven_rvi
					$ccp=$datlista[3];//codcpg_rvi
				}
				$tabla=array(array()); obtener_matriz($sql,$tabla,$filas);
				$cmbprod="SELECT * from productos WHERE (activ_pro=1) AND (zona_pro='$zona_usr')";
				if(isset($_POST["btnGrl"]))
				{
					$btn=$_POST["btnGrl"];$bus=$_POST["txtbus"];
					if($btn=="Buscar")
					{
						if ($bus<>"")
						{
							$numreg=busca_id($tabla,$filas,$bus);
							if($numreg>=0)
							{	
								mysqli_data_seek($sql, $numreg); 
								$resul=mysqli_fetch_array($sql);
								$id_producto=$resul[0];//id_pro
								$var1=$resul[1];//abrv_pro
								$var2=$resul[2];//tipo_cat
								$var3=$resul[3];//clase_pro
								$var4=$resul[4];//codpqt_rvi
								$var5=$resul[5];//id_usr
								$var6=$resul[6];//id_cli
								$var7=$resul[7];//tipopla_rvi
								$var8=$resul[8];//id_pla
								$var9=$resul[9];//fechaemi_rvi
								$var10=$resul[10];//fechaemi_rvi
								$var11=$resul[11];//codcpg_rvi
								$var12=$resul[12];//importetot_rvi
								$var13=$resul[13];//imprecef_rvi
							}
							else
							{
								echo "<script> alert('No se encuentra el registro'); </script>";
							}
						}
						else
						{
							echo "<script> alert('Falta el id para la búsqueda de registros'); location.href = 'selprodvta.php'; </script>";
						}
					}
					if($btn=="Filtrar")
					{
						$busca=$_POST["txtsii"]; $var_ser_ime_icc=$busca;//Caracter de busqueda de serie, imei o icc
						if ($busca<>"")
						{
							$cad_busca_cualquiera=" ((serie_pro LIKE '%$busca%') OR (imei_pro LIKE '%$busca%') OR (icc_pro LIKE '%$busca%') OR (id_pro LIKE '%$busca%') OR (cod_pro LIKE '%$busca%') OR (tipo_cat LIKE '%$busca%') OR (clase_cat LIKE '%$busca%'))";
						}
						else
						{
							$cad_busca_cualquiera=" 1";
						}
						$cmbprod="SELECT * FROM productos WHERE (activ_pro=1) AND (zona_pro='$zona_usr') AND ".$cad_busca_cualquiera;
						// Obtiene id de producto, tipo y clase de producto
						$resultado_filtro = mysqli_query ($Conexion,$cmbprod) or die("Error al agregar datos");
						$resultado_regist = mysqli_fetch_array($resultado_filtro,MYSQLI_ASSOC);
						$ide_pro = $resultado_regist["id_pro"];
						$tip_pro = $resultado_regist["tipo_cat"];
						$cla_pro = $resultado_regist["clase_cat"];
						$urg_pro = $resultado_regist["ultreg_pro"];
						$id_producto = $_POST["cmbidp"]; $var_id_producto = $id_producto;
						if (!empty($id_producto))
						{
							$cad_busca_id_producto =" (id_pro='$id_producto')";
						}
						else
						{
							$cad_busca_id_producto =" 1";
						}
						$cmbprod="SELECT * FROM productos WHERE (activ_pro=1) AND (zona_pro='$zona_usr') AND ".$cad_busca_cualquiera." AND ".$cad_busca_id_producto;
						$resultado_filtro = mysqli_query ($Conexion,$cmbprod) or die("Error al agregar datos");
						$resultado_regist = mysqli_fetch_array($resultado_filtro,MYSQLI_ASSOC);
						$tip_pro = $resultado_regist["tipo_cat"];
						$urg_pro = $resultado_regist["ultreg_pro"];
						// Verifica si es recarga virtual
						if ($tip_pro=="Recarga")
						{
							// Se obtiene la ultima cantidad actual del egreso del producto
							$cantactual = $urg_pro;
						}	
					}
					if($btn=="Agregar")
					{
						$idp=$_POST["cmbidp"];//id_pro
						$abp=valfield($Conexion,"productos","abrv_pro","id_pro",$idp);//abrv_pro
						//$tpc=$_POST["cmbtpc"];//tipo_cat
						//$clc=$_POST["cmbclc"];//clase_cat
						$tpc=valfield($Conexion,"productos","tipo_cat","id_pro",$idp);//tipo_cat
						$clc=valfield($Conexion,"productos","clase_cat","id_pro",$idp);//clase_cat
						$cpq=$_POST["txtcpq"];//codpqt_rvi
						$tip=$_POST["cmbtip"];//tipopla_rvi
						$ipl=$_POST["cmbipl"];//id_pla_rvi
						$imp=$_POST["txtimp"];//importetot_rvi
						$ire=$_POST["txtier"];//imprecef_rvi
						
						if (isset($_POST["txt_estado_stock_juego"]))
						{
							$estado_stock_juego=$_POST["txt_estado_stock_juego"];
						}
						else
						{
							$estado_stock_juego="";
						}
						if ($estado_stock_juego=="Falso")
						{
							echo "<script>alert('No se puede agregar el producto.');</script>";
						}
						else
						{
							$res_ultreg_pro = mysqli_query ($Conexion,"SELECT ultreg_pro, tipo_cat FROM productos WHERE id_pro='$idp'");
							$res = mysqli_fetch_array($res_ultreg_pro,MYSQLI_ASSOC);
							$v_ultreg_pro = $res["ultreg_pro"];
							$v_tipo_cat = $res["tipo_cat"];
							if ($idp<>"" && $tpc<>"" && $clc<>"" && $tip<>"" && $imp<>"")
							{
								if ($v_tipo_cat=="Recarga")
								{
									$cadena_sql="INSERT INTO selprovta (id_pro, abrv_pro, tipo_cat, clase_cat, codpqt_rvi, id_usr, id_cli, tipopla_rvi, id_pla, fechaemi_rvi, fechaven_rvi, codcpg_rvi, importetot_rvi, imprecef_rvi) VALUES ('".$idp."','".$abp."','".$tpc."','".$clc."','".$cpq."','".$id_usr."','".$idc."','".$tip."','".$ipl."','".$fem."','".$fvn."','".$ccp."','".$imp."','".$ire."')";
									mysqli_query ($Conexion,$cadena_sql) or die("Error al agregar datos");
									//echo "<script> alert('Se insertó correctamente la recarga'); location.href = 'selprodvta.php'; </script>";
									echo "<script> location.href = 'selprodvta.php'; </script>";
								}
								else
								{
									$cadena_sql="INSERT INTO selprovta (id_pro, abrv_pro, tipo_cat, clase_cat, codpqt_rvi, id_usr, id_cli, tipopla_rvi, id_pla, fechaemi_rvi, fechaven_rvi, codcpg_rvi, importetot_rvi, imprecef_rvi) VALUES ('".$idp."','".$abp."','".$tpc."','".$clc."','".$cpq."','".$id_usr."','".$idc."','".$tip."','".$ipl."','".$fem."','".$fvn."','".$ccp."','".$imp."','".$ire."')";
									mysqli_query ($Conexion,$cadena_sql) or die("Error al agregar datos");
									//echo "<script> alert('Se insertó correctamente el producto'); location.href = 'selprodvta.php'; </script>";
									echo "<script> location.href = 'selprodvta.php'; </script>";
								}
								$idp=$tpc=$clc=$cpq=$tip=$ipl=$imp=$ire="";
							}
							else
							{
								echo "<script> alert('No hay datos para agregar registros'); location.href = 'selprodvta.php'; </script>";
							}
						}
					}
					if ($btn=="Modificar")
					{
						$id_pro_modificar=$_POST["txtCodProdBusq"];//id del producto que se quiere modificar
						$idp=$_POST["cmbidp"];//id_pro nuevo que se va a mopdificar
						$abp=valfield($Conexion,"productos","abrv_pro","id_pro",$idp);//abrv_pro
						//$tpc=$_POST["cmbtpc"];//tipo_cat
						//$clc=$_POST["cmbclc"];//clase_cat
						$tpc=valfield($Conexion,"productos","tipo_cat","id_pro",$idp);//tipo_cat
						$clc=valfield($Conexion,"productos","clase_cat","id_pro",$idp);//clase_cat
						$cpq=$_POST["txtcpq"];//codpqt_rvi
						$tip=$_POST["cmbtip"];//tipopla_rvi
						$ipl=$_POST["cmbipl"];//id_pla_rvi
						$imp=$_POST["txtimp"];//importetot_rvi
						$ire=$_POST["txtier"];//imprecef_rvi
						if ($idp<>"" && $tpc<>"" && $clc<>"")
						{
							// $cadena_sql = "UPDATE selprovta SET id_pro='$idp', abrv_pro='$abp', tipo_cat='$tpc', clase_cat='$clc', tipopla_rvi='$tip', id_pla='$ipl', importetot_rvi='$imp', imprecef_rvi='$ire' WHERE id_pro=$idp";
							$cadena_sql = "UPDATE selprovta SET id_pro='$idp', abrv_pro='$abp', tipo_cat='$tpc', clase_cat='$clc', tipopla_rvi='$tip', id_pla='$ipl', importetot_rvi='$imp', imprecef_rvi='$ire' WHERE id_pro=$id_pro_modificar";
							mysqli_query($Conexion, $cadena_sql) or die("Error al modificar datos");
							echo "<script> alert('Se modificó correctamente los datos'); location.href = 'selprodvta.php'; </script>";
							$idp=$tpc=$clc=$cpq=$tip=$ipl=$imp=$ire="";
						}
						else
						{
							echo "<script> alert('No hay datos para modificar'); location.href = 'selprodvta.php'; </script>";
						}
					}
					if($btn=="Eliminar")
					{
						$nrg=$_POST["txtnumreg"];$id=$_POST["cmbidp"];
						if ($nrg<>"" && $id<>"")
						{
							$cadena_sql = "DELETE FROM selprovta WHERE id_pro=$id";
							mysqli_query($Conexion, $cadena_sql) or die ("Error al borrar el registro");
							echo "<script> alert('Borrado de registro efectuado, actualizando datos...'); location.href = 'selprodvta.php'; </script>";
							$sql = mysqli_query ($Conexion,"SELECT * from selprovta") or die ("Error al traer los datos");
							$tabla=array(array()); obtener_matriz($sql,$tabla,$filas);
						}
						else
						{
							echo "<script> alert('No hay datos de registro para borrar'); location.href = 'selprodvta.php'; </script>";
						}
					}
					if($btn=="Actualizar")
					{
						echo "<script> location.href = 'selprodvta.php'; </script>";
					}
					if($btn=="Aceptar")
					{
						mysqli_data_seek($sql, 0); 
						while($resul = mysqli_fetch_array($sql))
						{
							/* Recoge todos los datos de la matriz de selprovta y
							los carga en las variables $var0, $var4 y $var5 */
							$var0=$resul[0];//id_pro *Para trsladar a rgvtatmp
							$var2=$resul[2];//tipo_cat
							$var3=$resul[3];//clase_cat
							$var4=$resul[4];//codpqt_rvi *Para trasladar a rgvtatmp
							$var5=$resul[5];//id_usr *Para trasladar a rgvtatmp
							$var6=$resul[6];
							$var7=$resul[7];
							$var8=$resul[8];
							$var9=$resul[9];
							$var10=$resul[10];
							$var11=$resul[11];
							$var12=$resul[12];//importetot_rvi
							$var13=$resul[13];//imprecef_rvi
							//Modificado por JUAN (10-025-2019): $bipgr=$var12 debido a que el IGV se exonera es decir vale 0
							$bipgr=$var12;
							$bipng=0;
							$impsc=0;
							$impgv=0.00;
							/*$bipgr=round($var12/1.18, 2);
							$bipng=0;
							$impsc=0;
							$impgv=$var12-$bipgr;*/
							// Genera la cadena para copiar los datos a la tabla rgvtatmp
							$cadena_sql="INSERT INTO rgvtatmp (id_pro, id_usr, codpqt_rvi, id_cli, tipopla_rvi, id_pla, fechaemi_rvi, fechaven_rvi, codcpg_rvi, importetot_rvi, baseimpopgrv_rvi, baseimpopngrv_rvi, isc_rvi, igv_rvi, zona_rvi, imprecef_rvi) VALUES ('".$var0."','".$var5."','".$var4."','".$var6."','".$var7."','".$var8."','".$var9."','".$var10."','".$var11."','".$var12."','".$bipgr."','".$bipng."','".$impsc."','".$impgv."','".$zona_usr."','".$var13."')";
							mysqli_query ($Conexion,$cadena_sql) or die("Error al agregar datos");
							//Genera cadena para desactivar los productos
							if (($var2<>"Servicios") AND ($var3<>"Rec.Virtual") AND ($var2<>"Juego"))
							{
								$cadena_pro="UPDATE productos SET activ_pro=0 WHERE id_pro=$var0";
								mysqli_query ($Conexion,$cadena_pro) or die("Error al agregar datos");
								//echo "<script> alert('Se trasladaron los datos correctamente'); </script>";
							}
						}
						// Al terminar la copia de datos se elimina los registros de selprovta
						$cadena_sql = "DELETE FROM selprovta WHERE id_usr='$id_usr'";
						mysqli_query($Conexion, $cadena_sql) or die ("Error al borrar el registros de selprovta");
						// Al terminar la copia de datos se elimina el codigo de paquete
						$cadena_sql = "DELETE FROM codpaquete WHERE id_usr='$id_usr'";
						mysqli_query($Conexion, $cadena_sql) or die ("Error al borrar el registros de codpaquete");
						//echo "<script> alert('Actualizando datos...'); </script>";
						// Y al final se cierra la ventana de selección de productos
						echo "<script> window.close(); </script>";
					}
					if($btn=="Cobrar")
					{
						mysqli_data_seek($sql, 0); 
						while($resul = mysqli_fetch_array($sql))
						{
							// Traslada datos de selprovta a $var0, $var2, ..
							cargar_datos($resul,$var0,$var2,$var3,$var4,$var5,$var6,$var7,$var8,$var9,$var10,$var11,$var12,$var13,$numcel_rvi);
							// Calcula el valor de variables de impuesto y otros del comprobante
							calcula_variables_comprobante($var12,$bipgr,$bipng,$impsc,$impgv);
							// Traslada los datos de selprovta a regvtatmp
							traslada_selprovta_a_rgvtatmp($Conexion,$var0,$var4,$var5,$var6,$var7,$var8,$var9,$var10,$var11,$var12,$bipgr,$bipng,$impsc,$impgv,$zona_usr,$var13,$numcel_rvi);
							// Desactivar los productos escogidos si son Servicios o Rec.Virtual
							desactivar_productos($Conexion,$var0,$var2,$var3);
						}
						// Elimina los registros de los productos seleccionados
						eliminar_registros_seleccionados($Conexion,$id_usr);
						//echo "<script> alert('Actualizando datos...'); </script>";
						$codcpg=$var11;
						echo "<script> window.open('../admin/rgvtcajatmp.php?ccp=$codcpg', '_blank', 'width=1050, height=800, top=30, left=50, menubar=no, toolbar=no, scrollbars=yes, resizable=no, status=no'); </script>"; 
						// Y al final se cierra la ventana de selección de productos
						echo "<script> window.close(); </script>";
					}
				}
				?>
				<form name="usuario" action="" method="post"><br>
					<span id="etq4">Buscar ID:</span><?php txtnormal("txtbus"); btnnormal("btnGrl", "Buscar");?>
					<span id="etq10">Cod. Paquete:</span><?php txtvalstl("txtcpq",$var4,5,"width:70px;");?><br><hr>	<?php
					txtoculto("txtnumreg",$numreg);
					txtoculto("txtCodProdBusq",$id_producto);?>
					<div class="formulario">
						<div>
							<span id="etq5">Serie/Imei/Icc/Id/Código/Grupo/Tipo:</span><?php txtvalstl("txtsii", $var_ser_ime_icc,21,"width:100px;");?>
							<?php btnnormal("btnGrl", "Filtrar");?><br>
							<span id="etq5">Producto:</span><?php
							cmbfieldJs("div_cmbidp","cmbidp",$Conexion,$cmbprod,"","onchange=\"muestra_stock_juego('cmbidp')\";","id_pro","cod_pro","abrv_pro","serie_pro","imei_pro","icc_pro");
							lblnormExt("", "", "lbl_saldo_stock_juego", "color:RGB(255,255,255); background-color:RGB(220,220,255);");
							if ($tip_pro=="Recarga") {						
								echo " CA: ".$cantactual;
								if ($cantactual<=200) {
									echo "<script> alert('Las recargas estan por debajo del límite mínimo. Solicite renovación antes de quedarse sin saldo.'); </script>";
								}
							} ?>
						</div>
						<div>
							<span id="etq4">Tipo de venta:</span><?php 
							cmbfieldJs_span("spn_select_tipVent","cmbtip",$Conexion,"SELECT * FROM tipoventa WHERE activo_vtv='S'",$var7,"onchange=\"CambiarValor('cmbtip')\";","descrip_vtv");?>
							<span id="etq5">Plan:</span><?php cmbfield("cmbipl", $Conexion, "SELECT * from planes WHERE activ_pla=1", $var8, "id_pla","abrv_pla");?>
							<span id="etq5">Importe S/.:</span><?php txtvalstl("txtimp",$var12,7,"width:80px;");?>
						</div>		
						<div><span id="etq5">Importe efectivo de recarga S/.:</span><?php txtvalstl("txtier",$var13,7,"width:80px;");?></div>
						<hr>
						<?php btnnormal("btnGrl", "Agregar");?>
						<?php btnnormal("btnGrl", "Modificar");?>
						<?php btnnormal("btnGrl", "Eliminar");?>
						<?php btnnormal("btnGrl", "Actualizar");?>
						<span id="etq6"><?php btnnormal("btnGrl", "Cobrar");?></span><br>
					</div><hr>
				</form> <!-- Fin de formulario -->
				<!-- Inicio de listado de datos de usuario -->	
				<center>
				<div style="width:100%; overflow:auto;">
				<table border='0' cellspacing='0' cellpadding='0' class="tblnormal">
					<tr style="display: table-row;">
					<th>Id.Prod.</th>
					<th>Abreviado</th>
					<th>Importe</th>
					<th>Grupo</th>
					<th>Tipo</th>
					<th>Cod.Pqt.</th>
					<th>Usuario</th>
					<th>Cliente</th>
					<th>Tipo Vta.</th>
					<th>Plan</th>
					<th>Fech.Emisión</th>
					<th>Fech.Venta</th>
					<th>Cod.Comprob.Pago</th>
					<th>Imp.Rec.PDV</th>
					</tr>
					<?php
					mysqli_data_seek($sql, 0); 
					while($resul = mysqli_fetch_array($sql))
					{
						$var0=$resul[0];
						$var1=$resul[1];
						$var2=$resul[2];
						$var3=$resul[3];
						$var4=$resul[4];
						$var5=$resul[5];
						$var6=$resul[6];
						$var7=$resul[7];
						$var8=$resul[8];
						$var9=$resul[9];
						$var10=$resul[10];
						$var11=$resul[11];
						$var12=$resul[12];
						$var13=$resul[13];
						if ($var8!=0) {$varplan=valfield($Conexion,"planes","abrv_pla","id_pla",$var8);} else {$varplan="";}
					?>
						<tr align='center'style="display: table-row;">
						<td><?php echo $var0 ?></td>
						<td><?php echo $var1 ?></td>
						<td><?php echo $var12 ?></td>
						<td><?php echo $var2 ?></td>
						<td><?php echo $var3 ?></td>
						<td><?php echo $var4 ?></td>
						<td><?php echo $var5 ?></td>
						<td><?php echo $var6.":".valfield($Conexion,"clientes","nom_rzs_cli","id_cli",$var6);?></td>
						<td><?php echo $var7 ?></td>
						<td><?php echo $var8.":".$varplan;?></td>
						<td><?php echo $var9 ?></td>
						<td><?php echo $var10 ?></td>
						<td><?php echo $var11 ?></td>
						<td><?php echo $var13 ?></td>
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
			<!--<div id="footer" style="width:<?php //echo $ancho+20;?>px;"><p><?php //pie_pagina();?></p></div>-->
			<!--Pie de página (footer)-->
			<div class="piepag"><p><?php pie_pagina();?></p></div>
		</div><!--Fin de container-->
	</body>
</html>
<?php
function cargar_datos($resul,&$var0,&$var2,&$var3,&$var4,&$var5,&$var6,&$var7,&$var8,&$var9,&$var10,&$var11,&$var12,&$var13,&$numcel_rvi)
{
	$var0=$resul[0];//id_pro *Para trsladar a rgvtatmp
	$var2=$resul[2];//tipo_cat
	$var3=$resul[3];//clase_cat
	$var4=$resul[4];//codpqt_rvi *Para trasladar a rgvtatmp
	$var5=$resul[5];//id_usr *Para trasladar a rgvtatmp
	$var6=$resul[6];
	$var7=$resul[7];
	$var8=$resul[8];
	$var9=$resul[9];
	$var10=$resul[10];
	$var11=$resul[11];//codcpg_rvi
	$var12=$resul[12];//importetot_rvi
	$var13=$resul[13];//imprecef_rvi
	$numcel_rvi=$resul[14];
}
function calcula_variables_comprobante($var12,&$bipgr,&$bipng,&$impsc,&$impgv)
{
	//$bipgr=round($var12/1.18, 2);
	$bipgr=$var12; //la baseimpopgrv_rvi es igual al monto total de venta por ser Exonerado
	$bipng=$impsc=0;
	$impgv=0; //El igv es = por ser Exonerado
}
function traslada_selprovta_a_rgvtatmp($Conexion,$var0,$var4,$var5,$var6,$var7,$var8,$var9,$var10,$var11,$var12,$bipgr,$bipng,$impsc,$impgv,$zona_usr,$var13,$numcel_rvi)
{
	$cadena_sql="INSERT INTO rgvtatmp (id_pro, id_usr, codpqt_rvi, id_cli, tipopla_rvi, id_pla, fechaemi_rvi, fechaven_rvi, codcpg_rvi, importetot_rvi, baseimpopgrv_rvi, baseimpopngrv_rvi, isc_rvi, igv_rvi, zona_rvi, imprecef_rvi, numcel_rvi) VALUES ('".$var0."','".$var5."','".$var4."','".$var6."','".$var7."','".$var8."','".$var9."','".$var10."','".$var11."','".$var12."','".$bipgr."','".$bipng."','".$impsc."','".$impgv."','".$zona_usr."','".$var13."','".$numcel_rvi."')";
	mysqli_query ($Conexion,$cadena_sql) or die("Error al agregar datos de selprovta a regvtatmp.");
}
function desactivar_productos($Conexion,$var0,$var2,$var3)
{
	if (($var2<>"Servicios") AND ($var3<>"Rec.Virtual") AND ($var2<>"Juego"))
	{
		$cadena_pro="UPDATE productos SET activ_pro=0 WHERE id_pro=$var0";
		mysqli_query ($Conexion,$cadena_pro) or die("Error al modificar el estado de los productos cuando se eligen en selprovta.");
		//echo "<script> alert('Se trasladaron los datos correctamente'); </script>";
	}
}
function eliminar_registros_seleccionados($Conexion,$id_usr)
{
	// Al terminar la copia de datos se elimina los registros de selprovta
	$cadena_sql = "DELETE FROM selprovta WHERE id_usr='$id_usr'";
	mysqli_query($Conexion, $cadena_sql) or die ("Error al borrar el registros de selprovta");
	// Al terminar la copia de datos se elimina el codigo de paquete
	$cadena_sql = "DELETE FROM codpaquete WHERE id_usr='$id_usr'";
	mysqli_query($Conexion, $cadena_sql) or die ("Error al borrar el registros de codpaquete");
}
?>