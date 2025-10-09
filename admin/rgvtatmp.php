<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
include("../library/datos.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
/* Variables de busqueda de rgvtatmp: id_rvi, id_cli, id_pro, tipopla_rvi, id_pla, fechaemi_rvi, fechaven_rvi, tipodoccp_rvi, seriecp_rvi, numcp_rvi, descrip_rvi, formapago_rvi, baseimpopgrv_rvi, baseimpopngrv_rvi, isc_rvi, igv_rvi, importetot_rvi, id_usr, numcont_rvi, numcel_rvi, codpqt_rvi, codcpg_rvi, rgpag_rvc, zona_rvi, imprecef_rvi */
$var0=$var1=$var2=$var3=$var4=$var5=$var6=$var7=$var8=$var9=$var10=$var11=$var12=$var13=$var14=$var15=$var16=$var17=$var18=$var19=$var20=$var21=$var22=$var23=$var24="";
$numreg=$cliente=$cad_busca_cualquiera="";
//----------------------------------
$limitar_cliente1=" ORDER BY id_cli DESC LIMIT 0,5";
//----------------------------------
?>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Registro de Ventas(TMP)");?></head>
	<body>
		<div>
			<div>
				<?php cabecera04(0,"Venta Nueva");sl(1)?>
				<!--<center><h1>Venta Nueva</h1></center><hr>-->
				<?php
				date_default_timezone_set("America/Lima");
				if ($nivel_usuario=="tot")
				{
					$sql_rgvtatmp=mysqli_query($Conexion,"SELECT * FROM rgvtatmp") or die ("Error al traer los datos");
				}
				else
				{
					$sql_rgvtatmp=mysqli_query($Conexion,"SELECT * FROM rgvtatmp WHERE id_usr='$ident_usuario'") or die ("Error al traer los datos");
				}
				// Obtiene codigo unico de comprobante de pago para registro de ventas temporal
				$sqlcpg= mysqli_query ($Conexion,"SELECT * from codcomprb WHERE id_usr='$ident_usuario'") or die ("Error al traer los datos");
				$datcpg=mysqli_fetch_array($sqlcpg);$var21=$datcpg[0];//id_codcpg
				// Datos retenidos en datprinctmp
				if ($nivel_usuario=="tot")
				{
					$sqldtt= mysqli_query ($Conexion,"SELECT * from datprinctmp") or die ("Error al traer los datos");
				}
				else
				{
					$sqldtt= mysqli_query ($Conexion,"SELECT * from datprinctmp WHERE id_usr='$ident_usuario'") or die ("Error al traer los datos");
				}
				$datos=mysqli_num_rows($sqldtt);
				if ($datos>0)
				{
					$datlista=mysqli_fetch_array($sqldtt);
					//Datos de datprinctmp
					$var1=$datlista[0];//id_cli
					$var5=$datlista[1];//fechaemi_rvi
					$var6=$datlista[2];//fechaven_rvi
					$var21=$datlista[3];//codcpg_rvi
					$var7=$datlista[4];//tipodoccp_rvi
					$var8=$datlista[5];//seriecp_rvi
					$var9=$datlista[6];//numcp_rvi
					$var10=$datlista[7];//descrip_rvi
					$var11=$datlista[8];//formapago_rvi
					$var22=$datlista[9];//rgpag_rvc
					$var18=$datlista[10];//numcont_rvi
					$var19=$datlista[11];//numcel_rvi
					$var23=$datlista[12];//zona_rvi
					// Se obtiene de $zona_usuario   //zona_rvi
					// Se obtiene de ident_usuario   //id_usr
				}
				$tabla=array(array()); obtener_matriz($sql_rgvtatmp,$tabla,$filas);
				if (empty($var5)) $var5=date("Y-m-d");
				if (empty($var6)) $var6=date("Y-m-d");
				//---------------------------------------
				/*$filas=mysqli_num_rows($sql_rgvtatmp);
				echo $filas,"<br>";
				if ($filas<>0)
				{
					$resul=mysqli_fetch_array($sql_rgvtatmp);
					$var2=$resul[2];//id_pro
					echo $var2,"<br>";
					$cantanterior=valfieldlast($Conexion,"kardex","cantactual_kar","id_pro",$var2);
					echo "Valor de recargas en kardex (ultimo dato):",$cantanterior;
				}*/
				//---------------------------------------
				if(isset($_POST["btnGrl"]))
				{
					$btn=$_POST["btnGrl"];$bus=$_POST["txtbus"];
					//------------------------------------------------ AÑADIR --------------------------------------------
					if($btn=="Añadir Productos")
					{
						if ($zona_usuario=="Total")
						{
							$sqlpaq= mysqli_query ($Conexion,"SELECT * FROM datprinctmp") or die ("Error al traer los datos");
						}
						else
						{
							$sqlpaq= mysqli_query ($Conexion,"SELECT * FROM datprinctmp WHERE id_usr='$ident_usuario'") or die ("Error al traer los datos");
						}
						$conteo_filas=mysqli_num_rows($sqlpaq);
						if ($conteo_filas>0)
						{
							buscar_registro_pagado($Conexion,$ident_usuario,$rgpag_datprinctmp,$rgpag_rgvtatmp);
							if ($rgpag_datprinctmp=="Pagado" OR $rgpag_rgvtatmp=="Pagado")
							{
								mensaje("Ya no se puede añadir más productos, la venta ya se efectuó!.");
								echo "<script> location.href='rgvtatmp.php'; </script>";
							}
							else
							{
								// Generar codigo de paquete de productos en codpaquete
								$sqlcpq= mysqli_query ($Conexion,"SELECT * FROM codpaquete WHERE id_usr='$ident_usuario'") or die ("Error al traer los datos");
								$cont_fil_cpq=mysqli_num_rows($sqlcpq);
								if ($cont_fil_cpq==0)
								{
									$cadena_sql="INSERT INTO codpaquete (id_usr) VALUES ('".$ident_usuario."')";
									mysqli_query ($Conexion,$cadena_sql) or die("Error al agregar datos");
								}
								echo "<script> window.open('../admin/selprodvta.php', '_blank', 'width=1104, height=750, top=100, left=100, toolbar=no, menubar=no, scrollbars=yes, resizable=no, status=no'); </script>"; 
							}
						}
						else
						{
							echo "<script> alert('No hay datos principales: cliente, tipo de venta, plan... ¡Usar el botón Cargar Cliente!'); location.href='rgvtatmp.php'; </script>";
						}
					}
					//-------------------------------------------------- BUSCAR ------------------------------------------
					if($btn=="Buscar")
					{
						if ($bus<>"")
						{
							$numreg=busca_id($tabla,$filas,$bus);
							if($numreg>=0)
							{	
								mysqli_data_seek($sql_rgvtatmp, $numreg); 
								$resul=mysqli_fetch_array($sql_rgvtatmp);
								$var0=$resul[0];//id_rvi
								$var1=$resul[1];//id_cli
								$var2=$resul[2];//id_pro
								$var3=$resul[3];//tipopla_rvi
								$var4=$resul[4];//id_pla
								$var5=$resul[5];//fechaemi_rvi
								if (empty($var5)) $var5=date("Y-m-d");
								$var6=$resul[6];//fechaven_rvi
								if (empty($var6)) $var6=date("Y-m-d");
								$var7=$resul[7];//tipodoccp_rvi
								$var8=$resul[8];//seriecp_rvi
								$var9=$resul[9];//numcp_rvi
								$var10=$resul[10];//descrip_rvi
								$var11=$resul[11];//formapago_rvi
								$var12=$resul[12];//baseimpopgrv_rvi
								$var13=$resul[13];//baseimpopngrv_rvi
								$var14=$resul[14];//isc_rvi
								$var15=$resul[15];//igv_rvi
								$var16=$resul[16];//importetot_rvi
								$var17=$resul[17];//id_usr
								$var18=$resul[18];//numcont_rvi
								$var19=$resul[19];//numcel_usr
								$var20=$resul[20];//codpqt_rvi
								$var21=$resul[21];//codcpg_rvi
								$var22=$resul[22];//rgpag_rvc
								$var23=$resul[23];//zona_rvi
							}
							else
							{
								echo "<script> alert('No se encuentra el registro'); </script>";
							}
						}
						else
						{
							echo "<script> alert('Falta el id para la búsqueda de registros'); location.href = 'rgvtatmp.php'; </script>";
						}
					}
					//------------------------------------------------- AGREGAR -------------------------------------------
					if($btn=="Agregar")
					{
						$idv=$_POST["txtid"];//id_rvi
						$idc=$_POST["cmbidc"];//id_cli
						$idp=$_POST["cmbidp"];//id_pro
						$tip=$_POST["cmbtip"];//tipopla_rvi
						$ipl=$_POST["cmbipl"];//id_pla
						$fev=$_POST["txtfev"];//fechaemi_rvi
						$fvv=$_POST["txtfvv"];//fechaven_rvi
						$tdv=$_POST["txttdv"];//tipodoccp_rvi
						$srv=$_POST["txtsrv"];//seriecp_rvi
						if (empty($srv)) $srv=0;
						$ncv=$_POST["txtncv"];//numcp_rvi
						if (empty($ncv)) $ncv=0;
						$dsv=$_POST["txtdsv"];//descrip_rvi
						$fpv=$_POST["txtfpv"];//formapago_rvi
						$bgr=$_POST["txtbgr"];//baseimpopgrv_rvi
						$bng=$_POST["txtbng"];//baseimpopngrv_rvi
						$isc=$_POST["txtisc"];//isc_rvi
						$igv=$_POST["txtigv"];//igv_rvi
						$itv=$_POST["txtitv"];//importetot_rvi
						$nct=$_POST["txtnct"];//numcont_rvi
						$ncl=$_POST["txtncl"];//numcel_rvi
						$cpq=$_POST["txtcpq"];//codpqt_rvi
						$ccp=$_POST["txtccp"];//codcpg_rvi
						$pag=$_POST["txtpag"];//rgpag_rvc
						$zna=$_POST["txtzna"];//zona_rvi
						if ($idc<>"" && $idp<>"" && $fvv<>"" && $ncv<>"" && $itv<>"")
						{
							$cadena_sql="INSERT INTO rgvtatmp (id_cli, id_pro, tipopla_rvi, id_pla, fechaemi_rvi, fechaven_rvi, tipodoccp_rvi, seriecp_rvi, numcp_rvi, descrip_rvi, formapago_rvi, baseimpopgrv_rvi, baseimpopngrv_rvi, isc_rvi, igv_rvi, importetot_rvi, id_usr, numcont_rvi, numcel_rvi, codpqt_rvi, codcpg_rvi, rgpag_rvc, zona_rvi) VALUES ('".$idc."','".$idp."','".$tip."','".$ipl."','".$fev."','".$fvv."','".$tdv."',".$srv.",'".$ncv."','".$dsv."','".$fpv."','".$bgr."','".$bng."','".$isc."','".$igv."','".$itv."','".$ident_usuario."','".$nct."','".$ncl."','".$cpq."','".$ccp."','".$pag."','".$zona_usuario."')";
							mysqli_query ($Conexion,$cadena_sql) or die("Error al agregar datos");
							echo "<script> alert('Se insertó correctamente'); location.href = 'rgvtatmp.php'; </script>";
							$idv=$idc=$idp=$tip=$ipl=$fev=$fvv=$tdv=$srv=$ncv=$dsv=$fpv=$bgr=$bng=$isc=$igv=$itv=$nct=$ncl=$cpq=$ccp=$pag=$zna="";
						}
						else
						{
							echo "<script> alert('No hay datos para agregar registros'); location.href = 'rgvtatmp.php'; </script>";
						}
					}
					//---------------------------------------------------- MODIFICAR ----------------------------------------------------
					if ($btn=="Modificar")
					{
						$idv=$_POST["txtid"];//id_rvi
						$idc=$_POST["cmbidc"];//id_cli *modif
						$idp=$_POST["cmbidp"];//id_pro *modif
						$tip=$_POST["cmbtip"];//tipopla_rvi
						$ipl=$_POST["cmbipl"];//id_pla
						$fev=$_POST["txtfev"];//fechaemi_rvi
						$fvv=$_POST["txtfvv"];//fechaven_rvi *modif
						$tdv=$_POST["txttdv"];//tipodoccp_rvi
						$srv=$_POST["txtsrv"];//seriecp_rvi
						if (empty($srv)) $srv=0;
						$ncv=$_POST["txtncv"];//numcp_rvi *modif
						if (empty($ncv)) $ncv=0;
						$dsv=$_POST["txtdsv"];//descrip_rvi
						$fpv=$_POST["txtfpv"];//formapago_rvi
						$bgr=$_POST["txtbgr"];//baseimpopgrv_rvi
						$bng=$_POST["txtbng"];//baseimpopngrv_rvi
						$isc=$_POST["txtisc"];//isc_rvi
						$igv=$_POST["txtigv"];//igv_rvi
						$itv=$_POST["txtitv"];//importetot_rvi *modif
						$nct=$_POST["txtnct"];//numcont_rvi
						$ncl=$_POST["txtncl"];//numcel_rvi
						$cpq=$_POST["txtcpq"];//codpqt_rvi
						$ccp=$_POST["txtccp"];//codcpg_rvi
						$pag=$_POST["txtpag"];//rgpag_rvc
						$zna=$_POST["txtzna"];//zona_rvi
						//Calculo de los montos de productos gravados, no gravados, igv y total
						if ($tdv=="Boleta de venta")
						{
							$bgr=$itv; // base impositiva a productos gravados
							$bng=0; // base impisitiva a productos no gravados
							$isc=0; // impuesto selectivo al consumo
							$igv=0; // impuesto general a las ventas
						}
						else
						{
							$bgr=$itv/1.18; // base impositiva a productos gravados
							$bng=0; // base impisitiva a productos no gravados
							$isc=0; // impuesto selectivo al consumo
							$igv=$itv-$bgr; // impuesto general a las ventas
						}
						if ($idc<>"" && $idp<>"" && $fvv<>"" && $itv<>"")
						{
							$cadena_sql = "UPDATE rgvtatmp SET id_cli='$idc', id_pro='$idp', tipopla_rvi='$tip', id_pla='$ipl', fechaemi_rvi='$fev', fechaven_rvi='$fvv', tipodoccp_rvi='$tdv', seriecp_rvi='$srv', numcp_rvi='$ncv', descrip_rvi='$dsv', formapago_rvi='$fpv', baseimpopgrv_rvi='$bgr', baseimpopngrv_rvi='$bng', isc_rvi='$isc', igv_rvi='$igv', importetot_rvi='$itv', id_usr='$ident_usuario', numcont_rvi='$nct', numcel_rvi='$ncl', codpqt_rvi='$cpq', codcpg_rvi='$ccp', rgpag_rvc='$pag', zona_rvi='$zna' WHERE id_rvi=$idv";
							mysqli_query($Conexion, $cadena_sql) or die("Error al modificar datos");
							echo "<script> alert('Se modificó correctamente los datos');</script>";
							$idv=$idc=$idp=$tip=$ipl=$fev=$fvv=$tdv=$srv=$ncv=$dsv=$fpv=$bgr=$bng=$isc=$igv=$itv=$nct=$ncl=$cpq=$ccp=$pag=$zna="";	
							echo "<script> location.href = 'rgvtatmp.php'; </script>";
						}
						else
						{
							echo "<script> alert('No hay datos para modificar'); location.href = 'rgvtatmp.php'; </script>";
						}
					}
					//---------------------------------------------------- ELIMINAR ----------------------------------------------------
					if($btn=="Eliminar")
					{
						$nrg=$_POST["txtnumreg"];$id=$_POST["txtid"];
						if ($nrg<>"" && $id<>"")
						{
							$sql_borrado= mysqli_query ($Conexion,"SELECT * from rgvtatmp WHERE id_rvi='$id'") or die ("Error al traer los datos");
							$res_borrado=mysqli_fetch_array($sql_borrado, MYSQLI_ASSOC);
							$ind_borrado=$res_borrado["rgpag_rvc"];
							$idp_borrado=$res_borrado["id_pro"];
							if ($ind_borrado=="Pagado")
							{
								echo "<script> alert('No se puede eliminar el registro. ¡La venta ya se efectuó¡'); location.href = 'rgvtatmp.php'; </script>";
							}
							else
							{
								$cadena_sql = "DELETE FROM rgvtatmp WHERE id_rvi=$id";
								mysqli_query($Conexion, $cadena_sql) or die ("Error al borrar el registro");
								$cadena_pro="UPDATE productos SET activ_pro=1 WHERE id_pro=$idp_borrado";
								mysqli_query ($Conexion,$cadena_pro) or die("Error al agregar datos");
								echo "<script> alert('Borrado de registro efectuado, actualizando datos...'); location.href = 'rgvtatmp.php'; </script>";
								$sql_rgvtatmp = mysqli_query ($Conexion,"SELECT * FROM rgvtatmp") or die ("Error al traer los datos");
								$tabla=array(array()); obtener_matriz($sql_rgvtatmp,$tabla,$filas);
							}
						}
						else
						{
							echo "<script> alert('No hay datos de registro para borrar'); location.href = 'rgvtatmp.php'; </script>";
						}
					}
					//---------------------------------------------------- ACTUALIZAR ----------------------------------------------------
					if($btn=="Actualizar")
					{
						echo "<script> location.href = 'rgvtatmp.php'; </script>";
					}
					//---------------------------------------------------- CARGAR DATO PRINCIPAL ----------------------------------------------------
					if($btn=="Cargar Cliente")
					{
						// Datos a registrar por el vendedor
						$idc=$_POST["cmbidc"];//id_cli
						$fev=$_POST["txtfev"];//fechaemi_rvi
						$fvv=$_POST["txtfvv"];//fechaven_rvi
						$ccp=$_POST["txtccp"];//codcpg_rvi
						// Datos a registrar por el vendedor luego del pago
						$nct=NULL; //$_POST["txtnct"];//numcont_rvi
						$ncl=NULL; //$_POST["txtncl"];//numcel_rvi
						if (!empty($idc) AND !empty($ccp))
						{
							$cadena_sql="INSERT INTO datprinctmp (id_cli, fechaemi_rvi, fechaven_rvi, codcpg_rvi, numcont_rvi, numcel_rvi, zona_rvi, id_usr) VALUES ('".$idc."','".$fev."','".$fvv."','".$ccp."','".$nct."','".$ncl."','".$zona_usuario."','".$ident_usuario."')";
							mysqli_query ($Conexion,$cadena_sql) or die("Error al agregar datos");
							echo "<script> location.href = 'rgvtatmp.php'; </script>";
						}
						else
						{
							echo "<script> alert('No hay datos del cliente o del código de comprobante de pago. ¡Los datos principales deben ser completos!'); location.href='rgvtatmp.php'; </script>";
						}
					}
					//---------------------------------------------------- CANCELAR ----------------------------------------------------
					if($btn=="Cancelar")
					{
						cancelar_venta($Conexion,$datos,$ident_usuario);
						mysqli_query($Conexion, "DELETE FROM selprovta WHERE id_usr='$ident_usuario'") or die ("Error al eliminar registro al cancelar venta en selprovta.");
					}
					//---------------------------------------------------- FINALIZAR VENTA ----------------------------------------------------
					if($btn=="Finalizar Reg.Vta.")
					{
						//finalizar_venta($Conexion,$sql_rgvtatmp,$ident_usuario);
					}
					//---------------------------------------------------- BUSCAR CLIENTE ----------------------------------------------------
					if($btn=="Buscar Cliente")
					{
						$busca=$_POST["txtcli"];
						if ($busca<>"")
						{
							$cad_busca_cualquiera=" WHERE (nom_rzs_cli LIKE '%$busca%') OR (dni_ruc_cli LIKE '%$busca%')";
							$limitar_cliente1="";
						}
						else
						{
							$cad_busca_cualquiera="";
							$limitar_cliente1=" ORDER BY id_cli DESC LIMIT 0,5";
						}
					}
					if($btn=="Cliente Nuevo")
					{
						echo "<script> window.open('../admin/clientes_nuevo.php', '_blank', 'width=1245, height=465, left=0, top=0, menubar=no, toolbar=no, scrollbars=yes, resizable=no, status=no'); </script>";
					}
				}
				?>
			<form name="usuario" action="" method="post">
				<div><?php
					btnnormal("btnGrl", "Actualizar");
					btnnormal("btnGrl", "Cargar Cliente");
					btnnormal("btnGrl", "Cliente Nuevo");
					btnnormal("btnGrl", "Cancelar");
					btnnormal("btnGrl", "Añadir Productos");?>
				</div><hr>
				<?php txtoculto("txtnumreg",$numreg);?>
				<div><?php
				if (mysqli_num_rows($sql_rgvtatmp)>0) {
					mysqli_data_seek($sql_rgvtatmp, 0); 
					$datsuma=mysqli_fetch_array($sql_rgvtatmp);
					$varsuma=$datsuma[21];//codcpg_rvi
					$resultado = mysqli_query($Conexion,"SELECT SUM(importetot_rvi) AS total FROM rgvtatmp WHERE codcpg_rvi='$varsuma'");
					$dato = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
					$sumatot=$dato["total"];
				}
				else {
					$sumatot=0;
				} ?>
				</div>
				<?php lblnorm("Filtrar cliente(s):","etq5"); txtnrmstl("txtcli","width:100px;"); btnnormal("btnGrl", "Buscar Cliente");?>
				<?php lblnorm("Fecha de emisión:","etq2"); txtronstl("txtfev",$var5,"width:80px;");?>
				<?php lblnorm("Fecha de venta:","etq5"); txtronstl("txtfvv",$var6,"width:80px;");?>
				<?php lblnorm("Cód.Comprob.Pago:","etq5"); txtronstl("txtccp",$var21,"width:60px;");?><?php
				$datos=mysqli_num_rows($sqldtt);
				if ($datos==0) { ?>
					<div><span id="etq5">Cliente:</span><?php cmb_cliente("cmbidc", $Conexion, "SELECT * FROM clientes".$cad_busca_cualquiera.$limitar_cliente1, $var1, "id_cli", "nom_rzs_cli", "dni_ruc_cli", "direcc_cli", "lugar_cli");?></div> <?php
				}
				else { ?>
					<div><?php txtronstl("txtfev",$var1,"width:80px;");
					echo valfield($Conexion,"clientes","nom_rzs_cli","id_cli",$var1),",    ";
					echo "DNI:",valfield($Conexion,"clientes","dni_ruc_cli","id_cli",$var1),",    ";
					echo valfield($Conexion,"clientes","direcc_cli","id_cli",$var1),",    ";
					echo valfield($Conexion,"clientes","lugar_cli","id_cli",$var1);
					?></div> <?php
				} ?><hr>
				<div class="formulario">
					<div id="colizq" style=" float:left; width:35%;">
						<div><span id="etq2">Documento:</span><?php txtrdonly("txttdv",$var7);?></div>
						<div><span id="etq2">Serie:</span><?php txtrdonly("txtsrv",$var8);?></div><?php
						if (empty($var9)) { ?>
							<div><span style="background:var(--color-gris-claro); color:var(--color-gris-mas-oscuro); height:24.4px; display:inline-block;">Nº de documento:</span><?php txtrdonly("txtncv",$var9);?></div><?php
						}
						else { ?>
							<div><span id="etq2">Nº de documento:</span><?php txtrdonly("txtncv",$var9);?></div><?php
						} ?>
						<div><span id="etq2">Descripción:</span><?php txtrdonly("txtdsv",$var10);?></div>
					</div>
					<div id="colder"  style=" float:left; width:36%;">
						<div><span id="etq2">Forma de pago:</span><?php txtrdonly("txtfpv", $var11);?></div>
						<div><span id="etq2">Estado de pago:</span><?php txtrdonly("txtpag", $var22);?></div>
						<div><span id="etq2">Importe total:</span><?php txtvalue("txtitv",$sumatot,13);?></div>
						<div><span id="etq2">Zona:</span><?php txtrdonly("txtzna", $var23);?></div>
					</div>
					<div style="clear:both"></div><hr>
					<span id="etq5">ID Registro:</span><?php txtnormal("txtbus"); btnnormal("btnGrl", "Buscar"); btnnormal("btnGrl", "Eliminar");?>
					<span id="etq5">Registro:</span>	<?php txtrdonly("txtid",$var0);?>
					<b>Producto: </b><?php if(!empty($var2)) echo valfield($Conexion,"productos","abrv_pro","id_pro",$var2);?>
				</div>
				<hr>
			</form> <!-- Fin de formulario -->
	<!-- Inicio de listado de datos de usuario -->	
	<center>
	<div style="width:100%; overflow:auto;">
		<table border='0' cellspacing='0' cellpadding='0' class="tblnormal">
			<th>ID</th>
			<th>Cliente</th>
			<th>Producto</th>
			<th>Tipo Venta</th>
			<th>Plan</th>
			<th>Fecha de Venta</th>
			<th>Docum.</th>
			<th>Serie</th>
			<th>Número</th>
			<th>Descripción</th>
			<th>Importe</th>
			<th>Estad.Pago</th>
			<!--<th>Nº Contrato</th>
			<th>Nº Celular</th>-->
			<th>Cód. Paquete</th>
			<th>Cód. Comp.Pago</th>
			<th>Zona</th>
			</tr>
			<?php
			mysqli_data_seek($sql_rgvtatmp, 0); 
			while($resul = mysqli_fetch_array($sql_rgvtatmp))
			{
				$var0=$resul[0];
				$var1=$resul[1];
				$var2=$resul[2];
				$var3=$resul[3];
				$var4=$resul[4];
				$var6=$resul[6];
				$var7=$resul[7];
				$var8=$resul[8];
				$var9=$resul[9];
				$var10=$resul[10];
				$var16=$resul[16];
				//$var18=$resul[18]; numcont_rvi
				//$var19=$resul[19]; numcel_rvi
				$var20=$resul[20];
				$var21=$resul[21];
				$var22=$resul[22];
				$var23=$resul[23];
			?>
				<tr align='center'>
				<td><?php echo $var0 ?></td>
				<td><?php echo $var1.":".valfield($Conexion,"clientes","nom_rzs_cli","id_cli",$var1); ?></td>
				<td><?php echo $var2.":".valfield($Conexion,"productos","abrv_pro","id_pro",$var2); ?></td>
				<td><?php echo $var3 ?></td>
				<td><?php echo $var4.":".valfield($Conexion,"planes","abrv_pla","id_pla",$var4); ?></td>
				<td><?php echo $var6 ?></td>
				<td><?php echo $var7 ?></td>
				<td><?php echo $var8 ?></td>
				<td><?php echo $var9 ?></td>
				<td><?php echo $var10 ?></td>
				<td><?php echo $var16 ?></td>
				<td><?php echo $var22 ?></td>
				<!--<td><?php //echo $var18 ?></td>
				<td><?php //echo $var19 ?></td>-->
				<td><?php echo $var20 ?></td>
				<td><?php echo $var21 ?></td>
				<td><?php echo $var23 ?></td>
				</tr>
			<?php
			}
			?>
		</table>
		<br>
	</div>	
	</center> <!-- Fin de listado de datos de usuario -->
	</div><!--Fin de main-col-->
	<div class="piepag"><?php pie_pagina();?></div>
    </div><!--Fin de container-->
  </body>
</html>