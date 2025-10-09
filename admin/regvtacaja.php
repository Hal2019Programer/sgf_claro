<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
/* Variables de busqueda de regvtacaja: id_rvc, id_cli, tipopla_rvi, id_pla, fechaemi_rvi, fechaven_rvi, codcpg_rvi, tipodoccp_rvi, seriecp_rvi, numcp_rvi, descrip_rvi, formapago_rvi, baseimpopgrv_rvi, baseimpopngrv_rvi, isc_rvi, igv_rvi, importetot_rvi, id_usr, rgpag_rcv, zona_rvi, estado_rvc */
$var0=$var1=$var2=$var3=$var4=$var5=$var6=$var7=$var8=$var9=$var10=$var11=$var12=$var13=$var14=$var15=$var16=$var17=$var18=$var19=$var20=$numreg="";
$ambito_busqueda="Normal";
$consulta_inicial = "SELECT *, 
					CONCAT(regvtacaja.id_cli,':',clientes.nom_rzs_cli) AS clie, 
					CONCAT(regvtacaja.id_pla,':',planes.abrv_pla) AS plan 
					FROM regvtacaja 
					LEFT JOIN clientes ON regvtacaja.id_cli=clientes.id_cli 
					LEFT JOIN planes ON regvtacaja.id_pla=planes.id_pla";
$consulta_inicial_orden = " ORDER BY id_rvc DESC LIMIT 10"; //obtiene lista de registros iniciales hasta 10
//Variables para mantener filtro
$v_tpg=$v_epg="";
//Datos iniciales para control de accesos de perfil
$resultado_perfil_accesos = Null; $datos = array();
cargar_datos_perfil($Conexion,$ident_usuario,"Ventas Caja",$resultado_perfil_accesos,$datos,$categ_usuario,$nivel_usuario,$zona_usuario);
verificar_procesos_de_boton($resultado_perfil_accesos);
$variable_idLink="";
cargar_id_busqueda($variable_idLink);
?>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Registro de Ventas CAJA");?></head>
	<body>
		<div>
			<?php //cabecera02("Registro de Ventas CAJA"); menu02();?>
			<div style="width:1310px;">
				<?php cabecera04(0,"Gestión de Registro de Ventas Caja"); menu02(); sl(1);?>
				<!--<center><h1>Registro de Ventas Caja</h1></center><hr>-->
				<?php
				$cadena_sql = $consulta_inicial." WHERE 1".$consulta_inicial_orden;
				if ($zona_usuario<>"Total") $cadena_sql = $consulta_inicial." WHERE 1"." AND zona_rvi='$zona_usuario' ".$consulta_inicial_orden;
				$sql = mysqli_query ($Conexion,$cadena_sql) or die ("Error al traer los datos de registro de caja");
				$tabla=array(array()); obtener_matriz($sql,$tabla,$filas);
				if (empty($var4)) $var4=date("Y-m-d");
				if (empty($var5)) $var5=date("Y-m-d");
				//-------------------------------------------------------- Botones --------------------------------------------------------
				if(isset($_POST["btnGrl"]))
				{
					$btn=$_POST["btnGrl"];$bus=$_POST["txtbus"];
					//-------------------------------------------------------- Pagar --------------------------------------------------------
					if($btn=="Pagar")
					{
						echo "<script> window.open('../admin/rgvtcajatmp.php', '_blank', 'width=985, height=620, left='+(screen.width-985)/2+', top='+((screen.height-620)/2-40)+', menubar=no, toolbar=no, scrollbars=yes, resizable=no, status=no'); </script>"; 
					}
					//-------------------------------------------------------- Buscar --------------------------------------------------------
					if($btn=="Buscar")
					{
						if ($bus<>"")
						{
							$sql_regvtacaja = mysqli_query($Conexion,"SELECT * FROM regvtacaja WHERE id_rvc='$bus'") or die ("Error al traer los datos de regvtacaj.");
							$numreg = mysqli_num_rows($sql_regvtacaja);
							if($numreg>=0)
							{	
								$resul=mysqli_fetch_array($sql_regvtacaja,MYSQLI_ASSOC);
								$var0=$resul["id_rvc"];//id_rvc
								$var1=$resul["id_cli"];//id_cli
								$var2=$resul["tipopla_rvi"];//tipopla_rvi
								$var3=$resul["id_pla"];//id_pla
								$var4=$resul["fechaemi_rvi"];//fechaemi_rvi
								if (empty($var4)) $var4=date("Y-m-d");
								$var5=$resul["fechaven_rvi"];//fechaven_rvi
								if (empty($var5)) $var5=date("Y-m-d");
								$var6=$resul["codcpg_rvi"];//codcpg_rvi
								$var7=$resul["tipodoccp_rvi"];//tipodoccp_rvi
								$var8=$resul["seriecp_rvi"];//seriecp_rvi
								$var9=$resul["numcp_rvi"];//numcp_rvi
								$var10=$resul["descrip_rvi"];//descrip_rvi
								$var11=$resul["formapago_rvi"];//formapago_rvi
								$var12=$resul["baseimpopgrv_rvi"];//baseimpopgrv_rvi
								$var13=$resul["baseimpopngrv_rvi"];//baseimpopngrv_rvi
								$var14=$resul["isc_rvi"];//isc_rvi
								$var15=$resul["igv_rvi"];//igv_rvi
								$var16=$resul["importetot_rvi"];//importetot_rvi
								$var17=$resul["id_usr"];//id_usr
								$var18=$resul["rgpag_rvc"];//rgpag_rvc
								$var19=$resul["zona_rvi"];//zona_rvi
								$var20=$resul["estado_rvc"];//estado_rvc
							}
							else
							{
								echo "<script> alert('No se encuentra el registro'); </script>";
							}
						}
						else
						{
							echo "<script> alert('Falta el id para la búsqueda de registros'); location.href = 'regvtacaja.php'; </script>";
						}
					}
					//-------------------------------------------------------- Agregar --------------------------------------------------------
					/*if($btn=="Agregar")
					{			
						$idr=$_POST["txtid"];//id_rvc
						$idc=$_POST["cmbidc"];//id_cli
						$tip=$_POST["cmbtip"];//tipopla_rvi
						$ipl=$_POST["cmbipl"];//id_pla
						$fev=$_POST["txtfev"];//fechaemi_rvi
						$fvv=$_POST["txtfvv"];//fechaven_rvi
						$ccp=$_POST["txtccp"];//codcpg_rvi
						$tdv=$_POST["cmbtdv"];//tipodoccp_rvi
						$srv=$_POST["txtsrv"];//seriecp_rvi	
						$ncv=$_POST["txtncv"];//numcp_rvi
						$dsv=$_POST["txtdsv"];//descrip_rvi
						$fpv=$_POST["cmbfpv"];//formapago_rvi
						$bgr=$_POST["txtbgr"];//baseimpopgrv_rvi
						$bng=$_POST["txtbng"];//baseimpopngrv_rvi
						$isc=$_POST["txtisc"];//isc_rvi
						$igv=$_POST["txtigv"];//igv_rvi
						$itv=$_POST["txtitv"];//importetot_rvi
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
						if ($idc<>"" && $ccp<>"" && $fvv<>"" && $ncv<>"" && $itv<>"")
						{
							$cadena_sql="INSERT INTO regvtacaja (id_cli, tipopla_rvi, id_pla, fechaemi_rvi, fechaven_rvi, codcpg_rvi, tipodoccp_rvi, seriecp_rvi, numcp_rvi, descrip_rvi, formapago_rvi, baseimpopgrv_rvi, baseimpopngrv_rvi, isc_rvi, igv_rvi, importetot_rvi, id_usr) VALUES ('".$idc."','".$tip."','".$ipl."','".$fev."','".$fvv."','".$ccp."','".$tdv."','".$srv."','".$ncv."','".$dsv."','".$fpv."','".$bgr."','".$bng."','".$isc."','".$igv."','".$itv."','".$ident_usuario."')";
							mysqli_query ($Conexion,$cadena_sql) or die("Error al agregar datos");
							echo "<script> alert('Se insertó correctamente'); location.href = 'regvtacaja.php'; </script>";
							$idr=$idc=$tip=$ipl=$fev=$fvv=$ccp=$tdv=$srv=$ncv=$dsv=$fpv=$bgr=$bng=$isc=$igv=$itv="";
						}
						else
						{
							echo "<script> alert('No hay datos para agregar registros'); location.href = 'regvtacaja.php'; </script>";
						}
					}*/
					//-------------------------------------------------------- Modificar --------------------------------------------------------
					/*if ($btn=="Modificar")
					{
						$idr=$_POST["txtid"];//id_rvc
						$idc=$_POST["cmbidc"];//id_cli
						$tip=$_POST["cmbtip"];//tipopla_rvi
						$ipl=$_POST["cmbipl"];//id_pla
						$fev=$_POST["txtfev"];//fechaemi_rvi
						$fvv=$_POST["txtfvv"];//fechaven_rvi
						$ccp=$_POST["txtccp"];//codcpg_rvi
						$tdv=$_POST["cmbtdv"];//tipodoccp_rvi
						$srv=$_POST["txtsrv"];//seriecp_rvi	
						$ncv=$_POST["txtncv"];//numcp_rvi
						$dsv=$_POST["txtdsv"];//descrip_rvi
						$fpv=$_POST["cmbfpv"];//formapago_rvi
						$bgr=$_POST["txtbgr"];//baseimpopgrv_rvi
						$bng=$_POST["txtbng"];//baseimpopngrv_rvi
						$isc=$_POST["txtisc"];//isc_rvi
						$igv=$_POST["txtigv"];//igv_rvi
						$itv=$_POST["txtitv"];//importetot_rvi
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
						if ($idc<>"" && $ccp<>"" && $fvv<>"" && $ncv<>"" && $itv<>"")
						{
							$cadena_sql = "UPDATE regvtacaja SET id_cli='$idc', tipopla_rvi='$tip', id_pla='$ipl', fechaemi_rvi='$fev', fechaven_rvi='$fvv', codcpg_rvi='$ccp', tipodoccp_rvi='$tdv', seriecp_rvi='$srv', numcp_rvi='$ncv', descrip_rvi='$dsv', formapago_rvi='$fpv', baseimpopgrv_rvi='$bgr', baseimpopngrv_rvi='$bng', isc_rvi='$isc', igv_rvi='$igv', importetot_rvi='$itv', id_usr='$ident_usuario' WHERE id_rvc=$idr";
							mysqli_query($Conexion, $cadena_sql) or die("Error al modificar datos");
							echo "<script> alert('Se modificó correctamente los datos');</script>";
							$idr=$idc=$tip=$ipl=$fev=$fvv=$ccp=$tdv=$srv=$ncv=$dsv=$fpv=$bgr=$bng=$isc=$igv=$itv="";
							echo "<script> location.href = 'regvtacaja.php'; </script>";
						}
						else
						{
							echo "<script> alert('No hay datos para modificar'); location.href = 'regvtacaja.php'; </script>";
						}
					}*/
					//-------------------------------------------------------- Eliminar --------------------------------------------------------
					/*if($btn=="Eliminar")
					{
						$nrg=$_POST["txtnumreg"];$id=$_POST["txtid"];
						if ($nrg<>"" && $id<>"")
						{
							$cadena_sql = "DELETE FROM regvtacaja WHERE id_rvc=$idr";
							mysqli_query($Conexion, $cadena_sql) or die ("Error al borrar el registro");
							echo "<script> alert('Borrado de registro efectuado, actualizando datos...'); location.href = 'regvtacaja.php'; </script>";
							$sql = mysqli_query ($Conexion,"SELECT * from regvtacaja") or die ("Error al traer los datos");
							$tabla=array(array()); obtener_matriz($sql,$tabla,$filas);
						}
						else
						{
							echo "<script> alert('No hay datos de registro para borrar'); location.href = 'regvtacaja.php'; </script>";
						}
					}*/
					//-------------------------------------------------------- Actualizar --------------------------------------------------------
					if($btn=="Actualizar")
					{
						echo "<script> location.href = 'regvtacaja.php'; </script>";
					}
					//-------------------------------------------------------- Anular --------------------------------------------------------
					/*if($btn=="Anular")
					{
						$idr=$_POST["txtid"];//id_rvc
						$ccp=$_POST["txtccp"];//codcpg_rvi
						if ($idr<>"")
						{
							$cadena_sql1 = "UPDATE regvtacaja SET estado_rvc='anulado' WHERE id_rvc=$idr";
							mysqli_query($Conexion, $cadena_sql1) or die("Error al modificar datos");
							// Actualizar rgvtatmp para limpiar los datos de comprobante de pago
							$cadena_sql0 = "UPDATE rgvtatmp SET tipodoccp_rvi=NULL, seriecp_rvi=NULL, numcp_rvi=NULL, descrip_rvi=NULL, formapago_rvi=NULL, rgpag_rvc=NULL WHERE codcpg_rvi='$ccp'";
							mysqli_query($Conexion, $cadena_sql0) or die("Error al modificar datos");
							$cadena_sql2 = "UPDATE datprinctmp SET numcp_rvi=NULL WHERE codcpg_rvi='$ccp'";
								mysqli_query ($Conexion,$cadena_sql2) or die("Error al agregar datos");
							echo "<script> alert('Se anuló correctamente el documeento');</script>";
							$idr="";
							echo "<script> location.href = 'regvtacaja.php'; </script>";
						}
						else
						{
							echo "<script> alert('No hay datos para anular'); location.href = 'regvtacaja.php'; </script>";
						}
					}*/
					//-------------------------------------------------------- Eliminar --------------------------------------------------------
					/*if($btn=="Eliminar")
					{
						$nrg=$_POST["txtnumreg"];$id=$_POST["txtid"];
						if ($nrg<>"" && $id<>"")
						{
							$cadena_sql = "DELETE FROM regvtacaja WHERE id_rvc=$idr";
							mysqli_query($Conexion, $cadena_sql) or die ("Error al borrar el registro");
							echo "<script> alert('Borrado de registro efectuado, actualizando datos...'); location.href = 'regvtacaja.php'; </script>";
							$sql = mysqli_query ($Conexion,"SELECT * from regvtacaja") or die ("Error al traer los datos");
							$tabla=array(array()); obtener_matriz($sql,$tabla,$filas);
						}
						else
						{
							echo "<script> alert('No hay datos de registro para borrar'); location.href = 'regvtacaja.php'; </script>";
						}
						echo "<script> location.href = 'regvtacaja.php'; </script>";
					}*/
					//-------------------------------------------------------- Pagar Crédito --------------------------------------------------------
					if($btn=="Pag.Cred.")
					{
						$nrg=$_POST["txtnumreg"];$epg=$_POST["cmbpag"];$idr=$_POST["txtid"];
						$fechapag=date("Y-m-d");
						if ($nrg<>"" && $idr<>"")
						{
							$cadena_sql = "UPDATE regvtacaja SET rgpag_rvc='$epg', fechapag_rvc='$fechapag' WHERE id_rvc='$idr'";
							mysqli_query($Conexion, $cadena_sql) or die ("Error al actualizar registro de pagos...");
							echo "<script> alert('Registro de pagos actualizado...'); location.href = 'regvtacaja.php'; </script>";
						}
						else
						{
							echo "<script> alert('No hay datos de registro para actualizar'); location.href = 'regvtacaja.php'; </script>";
						}
						echo "<script> location.href = 'regvtacaja.php'; </script>";
					}
					//-------------------------------------------------------- Filtrar --------------------------------------------------------
					if($btn=="Filtrar")
					{
						$vtpg=$_POST["cmbtpg"];$v_tpg=$vtpg;
						$vepg=$_POST["cmbepg"];$v_epg=$vepg;
						$txtNomApe=$_POST["txtNomApe"];
						$txtDNI=$_POST["txtDNI"];
						$sql_where="";
						if (!empty($vtpg)) $sql_where=$sql_where."(formapago_rvi='$vtpg') AND ";
						if (!empty($vepg)) $sql_where=$sql_where."(rgpag_rvc='$vepg') AND ";
						if (!empty($txtNomApe)) $sql_where=$sql_where."(nom_rzs_cli LIKE '%$txtNomApe%') AND ";
						if (!empty($txtDNI)) $sql_where=$sql_where."(dni_ruc_cli='$txtDNI') AND ";
						$sql_where=trim($sql_where);
						$sql_where=substr($sql_where, 0, strlen($sql_where)-4);
						if (!empty($sql_where))
						{
							if ($zona_usuario<>"Total") { $sql_where = $consulta_inicial." WHERE ".$sql_where." AND zona_rvi='$zona_usuario' ".$consulta_inicial_orden; }
							else { $sql_where = $consulta_inicial." WHERE ".$sql_where.$consulta_inicial_orden; }
							$sql= mysqli_query ($Conexion,$sql_where) or die ("Error al traer los datos cuando se filtra.");
						}
					}
					//-------------------------------------------------------- Imprimir FormaTCK --------------------------------------------------------
					if($btn=="Imprimir FormaTCK")
					{
						$id_rvc=$_POST["txtid"];
						if (!empty($id_rvc))
						{
							echo "<script> window.open('../admin/regvtacaja_imp.php?id=$id_rvc', '_blank', 'width=1280, height=800, left=0, top=0, menubar=no, toolbar=no, scrollbars=yes, resizable=no, status=no'); </script>";
						}
						else
						{
							echo "<script> alert('No se ha cargado datos de comprobante para imprimir.'); location.href = 'regvtacaja.php'; </script>";
						}
					}
				}
				?>
			<!-------------------------------------------------------- Formulario -------------------------------------------------------->
			<form name="usuario" action="" method="post">
				<span id="etq5">Buscar ID:&nbsp;</span><?php txtnrmstl("txtbus","width:40px;"); 
				if (activar_boton($datos,$resultado_perfil_accesos,"Buscar")) { btnnormal("btnGrl", "Buscar"); }
				if (activar_boton($datos,$resultado_perfil_accesos,"Actualizar")) { btnnormal("btnGrl", "Actualizar"); }
				if (activar_boton($datos,$resultado_perfil_accesos,"Imprimir FormaTCK")) { btnnormal("btnGrl", "Imprimir FormaTCK"); } ?>
				<span id="etq4">Tip.Pag.:&nbsp;</span><?php cmbnormal("cmbtpg", $v_tpg, "Contado");?>
				<span id="etq5">Est.Pag.:&nbsp;</span><?php cmbnormal("cmbepg", $v_epg, "Pagado", "NoPago");?>
				<span id="etq5">Nomb.Ape.:&nbsp;</span><?php txtnrmstl("txtNomApe","width:250px;")?>
				<span id="etq5">DNI:&nbsp;</span><?php txtnrmstl("txtDNI","width:80px;")?>
				<?php if (activar_boton($datos,$resultado_perfil_accesos,"Filtrar")) { ?> <span id="etq5"><?php btnnormal("btnGrl", "Filtrar");?></span> <?php } ?>
				<hr>
				<?php txtoculto("txtnumreg",$numreg);?>
				<div class="formulario">
					<span>ID:</span><?php txtrdonly01("txtid",$var0);?>
					<span>Cliente:</span><?php txtrdonly01("txtcli",$var1); echo valfldmul($Conexion, "clientes", "id_cli", $var1, "nom_rzs_cli", "dni_ruc_cli", "direcc_cli", "lugar_cli");?>
					<div><span>Fecha de emisión:</span><?php txtrdonly("txtfev",$var4);?>
					<span id="etq5">Fecha de venta:</span><?php txtrdonly("txtfvv",$var5);?>
					<span id="etq5">Cod. Comprob. Pago:</span><?php txtrdonly01("txtccp",$var6);?></div>
					<hr>
					<div id="colizq"  style=" float:left; width:30%;">
						<div><span>Documento:</span><?php txtrdonly("cmbtdv", $var7);?></div>
						<div><span>Serie:</span><?php txtrdonly("txtsrv",$var8);?></div>
						<div><span>Nº de documento:</span><?php txtrdonly("txtncv",$var9);?></div>
						<div><span>Descripción:</span><?php txtrdonly("txtdsv",$var10);?></div>
					</div>
					<div id="colder"  style=" float:left; width:35%;">
						<div><span style=" width:200px;">Forma de pago:</span><?php txtrdonly("cmbfpv", $var11);?></div><?php
						if ($zona_usuario<>"Total") { ?>
							<div><span style=" width:200px;">Estado de pago:</span><?php txtrdonly("cmbpag", $var18);?></div><?php
						}
						else { ?>
							<div><span style=" width:200px;">Estado de pago:</span><?php cmbnormal("cmbpag", $var18, "Pagado", "NoPago");?></div><?php 
						} ?>
						<div><span style=" width:200px;">Bas.imp.prod. grv.:</span><?php txtrdonly("txtbgr",$var12);?></div>
						<div><span style=" width:200px;">Bas.imp.prod. no grv.:</span><?php txtrdonly("txtbng",$var13);?></div>
					</div>
					<div id="colders"  style=" float:left; width:35%;">		
						<div><span>ISC:</span><?php txtrdonly("txtisc",$var14);?></div>
						<div><span>IGV:</span><?php txtrdonly("txtigv",$var15);?></div>
						<div><span>Importe total:</span><?php txtrdonly("txtitv",$var16);?></div>
						<div><span>Estado:</span><?php txtrdonly("txtest",$var20);?></div>
					</div>
					<div style="clear:both"></div>
				</div>
				<hr>
			</form> <!-- Fin de formulario -->
	<!-- Inicio de listado de datos de usuario -->	
	<?php
	/*tblanchovariable($Conexion,"margin-left:0px;","height:200px;",$sql,"tblnormal",$ambito_busqueda,
	"ID:id_rvc:55:N",
	"Cliente:clie:380:N",
	"Fech.Vta.:fechaven_rvi:130:N",
	"Cód.Cpg.:codcpg_rvi:65:N",
	"TipoPago:formapago_rvi:80:N",
	"Estad.Pago:rgpag_rvc:90:N",
	"Fch.Pag.:fechapag_rvc:80:N",
	"Docum.:tipodoccp_rvi:105:N",
	"Serie:seriecp_rvi:40:N",
	"Número:numcp_rvi:60:N",
	"Descripción:descrip_rvi:250:N",
	"Importe S/.:importetot_rvi:90:N",
	"Tip.Vta.:tipopla_rvi:80:N",
	"Plan:plan:170:N",
	"Zona:zona_rvi:80:N",
	"Estado:estado_rvc:60:N");*/
	tblanchovariable_05($Conexion,"margin-left:0px;","height:200px;",$sql,"tblnormal","regvtacaja.php",
	"ID:id_rvc:55:idLink|",
	"Cliente:clie:380:N",
	"Fech.Vta.:fechaven_rvi:130:N",
	"Cód.Cpg.:codcpg_rvi:65:N",
	"TipoPago:formapago_rvi:80:N",
	"Estad.Pago:rgpag_rvc:90:N",
	"Fch.Pag.:fechapag_rvc:80:N",
	"Docum.:tipodoccp_rvi:105:N",
	"Serie:seriecp_rvi:40:N",
	"Número:numcp_rvi:60:N",
	"Descripción:descrip_rvi:250:N",
	"Importe S/.:importetot_rvi:90:N",
	"Tip.Vta.:tipopla_rvi:80:N",
	"Plan:plan:170:N",
	"Zona:zona_rvi:80:N",
	"Estado:estado_rvc:60:N");
	?>
</div><!--Fin de main-col-->
<?php scroll_doble("div1", "div2"); ?>
	<article class="piepag"><?php pie_pagina();?></article>
  </body>
</html>
<?php
//--------------------------------------------------------------------------------------------------------------
function cargar_id_busqueda(&$variable_idLink)
{
	if (isset($_GET["id"]))
	{ 
		$variable_idLink=$_GET["id"];
		if (!isset($_POST["btnGrl"]))
		{
			$_POST["btnGrl"]="Buscar";
			$_POST["txtbus"]=$variable_idLink;
		}
	} 
	else 
	{ 
		$variable_idLink="";
	}
}
?>