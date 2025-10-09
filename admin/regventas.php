<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
/* Variables de busqueda de regventas: id_rvi, id_cli, id_pro, tipopla_rvi, id_pla, fechaemi_rvi, fechaven_rvi, tipodoccp_rvi, seriecp_rvi, numcp_rvi, descrip_rvi, formapago_rvi, baseimpopgrv_rvi, baseimpopngrv_rvi, isc_rvi, igv_rvi, importetot_rvi, id_usr, numcont_rvi, numcel_rvi, codpqt_rvi, codcpg_rvi, zona_rvi */
$var0=$var1=$var2=$var3=$var4=$var5=$var6=$var7=$var8=$var9=$var10=$var11=$var12=$var13=$var14=$var15=$var16=$var17=$var18=$var19=$var20=$var21=$var22=$var23="";
$numreg="";
//$ambito_busqueda="Todo";
$ambito_busqueda="Normal";
/*COMANDOS SQL:
Actualizar Recargas a Rec.PDV : UPDATE `regventas` SET `tipopla_rvi` = 'Rec.PDV' WHERE (`tipopla_rvi` = "Recargas") AND (`descrip_rvi` = "Transferencia PDV")
Actualizar Recargas a Rec.Normal : UPDATE `regventas` SET `tipopla_rvi` = 'Rec.Normal' WHERE (`tipopla_rvi` = "Recargas") AND (`descrip_rvi` <> "Transferencia PDV") */
$consulta_inicial = "SELECT *, 
					 CONCAT(regventas.id_cli,':',clientes.nom_rzs_cli) AS clie, 
					 CONCAT_WS(':',regventas.id_pro,productos.abrv_pro,productos.imei_pro,productos.icc_pro) AS prod, 
					 productos.tipo_cat AS grupo, 
					 productos.clase_cat AS tipo, 
					 CONCAT(regventas.id_pla,':',planes.abrv_pla) AS plan 
					 FROM regventas 
					 LEFT JOIN clientes ON regventas.id_cli=clientes.id_cli 
					 LEFT JOIN productos ON regventas.id_pro=productos.id_pro 
					 LEFT JOIN planes ON regventas.id_pla=planes.id_pla";
$vbcli=$vbgrp=$vbtip=$vbtvt=$vbpla=$vbtdc=$vbzna=$vbcel=$vbndc=$vbfch=$vbidp=$vbcpg="";
//Datos iniciales para control de accesos de perfil
$resultado_perfil_accesos = Null; $datos = array();
cargar_datos_perfil($Conexion,$ident_usuario,"Registro de Ventas",$resultado_perfil_accesos,$datos,$categ_usuario,$nivel_usuario,$zona_usuario);
verificar_procesos_de_boton($resultado_perfil_accesos);
?>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Ventas");?></head>
	<body>
		<div>
			<?php //cabecera02("Registro de Ventas"); menu02();?>
			<div style="width:1310px;">
				<?php cabecera04(0,"Gestión de Registro de Ventas"); menu02(); sl(1);?>
				<!--<center><h1>Registro de ventas</h2></center><hr>-->
				<?php
				date_default_timezone_set("America/Lima");
				if (empty($vbfch)) $vbfch=date("d-m-Y");
				//---------------------------------------------------- CONSULTA INCIAL: Total o Usuario ----------------------------------------------------
				if ($zona_usuario=="Total")
				{
					$sql_regventas=mysqli_query ($Conexion,$consulta_inicial." ORDER BY id_rvi DESC LIMIT 10") or die ("Error al consulra de regventas");
				}
				else
				{
					$sql_regventas=mysqli_query ($Conexion,$consulta_inicial." WHERE zona_rvi='$zona_usuario'"." ORDER BY id_rvi DESC LIMIT 10") or die ("Error al traer los datos");
				}
				$tabla=array(array()); obtener_matriz($sql_regventas,$tabla,$filas);
				//---------------------------------------------------- BOTONES ----------------------------------------------------
				if(isset($_POST["btnGrl"]))
				{
					$btn=$_POST["btnGrl"];$bus=$_POST["txtbus"];
					//---------------------------------------------------- Venta Nueva ----------------------------------------------------
					if($btn=="Venta Nueva")
					{
						$sqlpaq= mysqli_query ($Conexion,"SELECT * FROM codcomprb WHERE id_usr='$ident_usuario'") or die ("Error al traer los datos");
						$conteo_filas=mysqli_num_rows($sqlpaq);
						if ($conteo_filas==0)
						{
							//Generar registro para id_usr e Id_codcpg
							$cadena_sql="INSERT INTO codcomprb (id_usr) VALUES ('".$ident_usuario."')";
							mysqli_query ($Conexion,$cadena_sql) or die("Error al agregar datos a codcomprb");
							//Leer el registro del usuario id_usr recientemnte creado
							$sqlpaq= mysqli_query ($Conexion,"SELECT * FROM codcomprb WHERE id_usr='$ident_usuario'") or die ("Error al traer los datos de comprb");
							$r=mysqli_fetch_array($sqlpaq,MYSQLI_ASSOC);
							$codcpg_rvc=$r["id_codcpg"];
						}
						else
						{
							$r=mysqli_fetch_array($sqlpaq,MYSQLI_ASSOC);
							$codcpg_rvc=$r["id_codcpg"];
						}
						
						$consulta_regvtacaja="SELECT * FROM regvtacaja WHERE codcpg_rvi='$codcpg_rvc'";
						$res_consulta_regvtacaja=mysqli_query ($Conexion,$consulta_regvtacaja) or die("Error al consultar en regvtacaja");
						$conteo_filas=mysqli_num_rows($res_consulta_regvtacaja);
						if ($conteo_filas>0)
						{
							$codigo_de_pago="Codigo de pago:".$codcpg_rvc;
							mensaje($codigo_de_pago);
							echo "<script> alert('Ya se tiene un registro de comprobante con el mismo codigo de pago. Consulte a Soporte Técnico para generar uno nuevo o distinto.'); </script>";
							$sql_delete_codcomprb="DELETE FROM codcomprb WHERE id_codcpg=$codcpg_rvc AND id_usr='$ident_usuario'";
							mysqli_query($Conexion, $sql_delete_codcomprb) or die("Error al eliminar registro de id_codcpg de codcomprb.");
						}
						else
						{
							echo "<script> window.open('../admin/rgvtatmp.php', '_blank', 'width=1100, height=615, left='+(screen.width-1100)/2+', top='+((screen.height-580)/2-30)+', menubar=no, toolbar=no, scrollbars=yes, resizable=no, status=no'); </script>"; 
						}
					}
					//---------------------------------------------------- Buscar ----------------------------------------------------
					if($btn=="Buscar")
					{
						if ($bus<>"")
						{
							$numreg=busca_id($tabla,$filas,$bus);
							if($numreg>=0)
							{	
								mysqli_data_seek($sql_regventas, $numreg); 
								$resul=mysqli_fetch_array($sql_regventas);
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
							echo "<script> alert('Falta el id para la búsqueda de registros'); location.href = 'regventas.php'; </script>";
						}
					}
					//---------------------------------------------------- Eliminar ----------------------------------------------------
					if($btn=="Eliminar")
					{
						$nrg=$_POST["txtnumreg"]; $id=$_POST["txtid"];
						if ($nrg<>"" && $id<>"")
						{
							$cadena_sql="DELETE FROM regventas WHERE id_rvi=$id";
							mysqli_query($Conexion, $cadena_sql) or die ("Error al borrar el registro");
							echo "<script> alert('Borrado de registro efectuado, actualizando datos...'); location.href = 'regventas.php'; </script>";
							if ($zona_usuario=="Total")
							{
								$sql_regventas= mysqli_query ($Conexion,$consulta_inicial." ORDER BY id_rvi DESC LIMIT 10") or die ("Error al traer los datos");
							}
							else
							{
								$sql_regventas= mysqli_query ($Conexion,$consulta_inicial." WHERE zona_rvi='$zona_usuario'"." ORDER BY id_rvi DESC LIMIT 10") or die ("Error al traer los datos");
							}
							$tabla=array(array()); obtener_matriz($sql_regventas,$tabla,$filas);
						}
						else
						{
							echo "<script> alert('No hay datos de registro para borrar'); location.href = 'regventas.php'; </script>";
						}
					}
					//---------------------------------------------------- Actualizar ----------------------------------------------------
					if($btn=="Actualizar")
					{
						echo "<script> location.href = 'regventas.php'; </script>";
					}
					//---------------------------------------------------- Filtrar ----------------------------------------------------
					if($btn=="Filtrar")
					{
						//---------------------------------------------------- Busca cliente ----------------------------------------------------
						$vb_cliente = $_POST["txtcli"]; $vbcli = $vb_cliente;
						if ($vb_cliente<>"") $cad_busca_cualquiera = " (clientes.nom_rzs_cli LIKE '%$vb_cliente%')"; else $cad_busca_cualquiera = " 1";
						//---------------------------------------------------- Busca grupo ----------------------------------------------------
						$vb_grupo = $_POST["cmbgrp"]; $vbgrp = $vb_grupo;
						if ($vb_grupo<>"") $cad_busca_grupo=" AND (productos.tipo_cat='$vb_grupo')"; else $cad_busca_grupo=" AND 1";
						//---------------------------------------------------- Busca tipo ----------------------------------------------------
						$vb_tipo = $_POST["cmbtip"]; $vbtip = $vb_tipo;
						if ($vb_tipo<>"") $cad_busca_tipo=" AND (productos.clase_cat='$vb_tipo')"; else $cad_busca_tipo=" AND 1";						
						//---------------------------------------------------- Busca tipo de venta ----------------------------------------------------
						$vb_tipventa = $_POST["cmbtvt"]; $vbtvt = $vb_tipventa;
						if ($vb_tipventa<>"") $cad_busca_tipoventa=" AND (regventas.tipopla_rvi='$vb_tipventa')"; else $cad_busca_tipoventa=" AND 1";
						//---------------------------------------------------- Busca plan ----------------------------------------------------
						$vb_plan = $_POST["cmbpla"]; $vbpla = $vb_plan;
						if (!empty($vb_plan)) $cad_busca_plan=" AND (planes.id_pla='$vb_plan')"; else $cad_busca_plan=" AND 1";
						//---------------------------------------------------- Busca tipo de documento ----------------------------------------------------
						$vb_tipodoc = $_POST["cmbtdc"]; $vbtdc = $vb_tipodoc;
						if ($vb_tipodoc<>"") $cad_busca_tipodoc=" AND (regventas.tipodoccp_rvi='$vb_tipodoc')"; else $cad_busca_tipodoc=" AND 1";
						//---------------------------------------------------- Busca zona ----------------------------------------------------
						$vb_zona = $_POST["cmbzon"]; $vbzna = $vb_zona;
						if ($vb_zona<>"") $cad_busca_zona=" AND (regventas.zona_rvi='$vb_zona')"; else $cad_busca_zona=" AND 1";
						//---------------------------------------------------- Busca celular ----------------------------------------------------
						$vb_celular = $_POST["txtcel"]; $vbcel = $vb_celular;
						if ($vb_celular<>"") $cad_busca_celular=" AND (regventas.numcel_rvi LIKE '%$vb_celular%')"; else $cad_busca_celular=" AND 1";
						//---------------------------------------------------- Busca documento ----------------------------------------------------
						$vb_documento = $_POST["txtndc"]; $vbndc = Trim($vb_documento);
						if (!empty($vb_documento))
						{ 
							$divsernum=explode("-", $vb_documento); 
							$vb_serie=$divsernum[0]; 
							$vb_numero=$divsernum[1]; 
						}
						else
						{ 
							$vb_serie=$vb_numero=""; 
						}	
						if ($vb_serie<>"") $cad_busca_serie=" AND (regventas.seriecp_rvi='$vb_serie')"; else $cad_busca_serie=" AND 1";
						if ($vb_numero<>"") $cad_busca_numero=" AND (regventas.numcp_rvi LIKE '%$vb_numero%')"; else $cad_busca_numero=" AND 1";
						//---------------------------------------------------- Busca fecha ----------------------------------------------------
						$vb_fechaventa = $_POST["txtfch"]; $vbfch = $vb_fechaventa; $vb_fechaventa = invFech($vbfch,"-");
						if ($vb_fechaventa<>"") $cad_busca_fechaventa=" AND (regventas.fechaven_rvi LIKE '%$vb_fechaventa%')"; else $cad_busca_fechaventa=" AND 1";
						//---------------------------------------------------- Busca fecha ----------------------------------------------------
						$vb_id_prod = $_POST["txtidp"]; $vbidp = $vb_id_prod;
						if ($vb_id_prod<>"") $cad_busca_id_prod=" AND (regventas.id_pro='$vb_id_prod')"; else $cad_busca_id_prod=" AND 1";
						//---------------------------------------------------- Codigo de pago ----------------------------------------------------
						$vb_codcpg = $_POST["txtcpg"]; $vbcpg = $vb_codcpg;
						if ($vb_codcpg<>"") $cad_busca_codcpg=" AND (regventas.codcpg_rvi='$vb_codcpg')"; else $cad_busca_codcpg=" AND 1";
						//---------------------------------------------------- Genera filtro final de la consulta ----------------------------------------------------
						if ($zona_usuario=="Total")
						{
							$cmbprod = $consulta_inicial." WHERE".$cad_busca_cualquiera.$cad_busca_grupo.$cad_busca_tipo.$cad_busca_tipoventa.$cad_busca_plan.$cad_busca_tipodoc.$cad_busca_zona.$cad_busca_celular.$cad_busca_serie.$cad_busca_numero.$cad_busca_fechaventa.$cad_busca_id_prod.$cad_busca_codcpg;
						}
						else
						{
							$cmbprod = $consulta_inicial." WHERE zona_rvi='$zona_usuario' AND".$cad_busca_cualquiera.$cad_busca_grupo.$cad_busca_tipo.$cad_busca_tipoventa.$cad_busca_plan.$cad_busca_tipodoc.$cad_busca_zona.$cad_busca_celular.$cad_busca_serie.$cad_busca_numero.$cad_busca_fechaventa.$cad_busca_id_prod.$cad_busca_codcpg;
						}						
						$sql_regventas= mysqli_query ($Conexion,$cmbprod) or die ("Error al seleccionar Filtros");
						$ambito_busqueda="Todo";
					}					
				}
				?>
				<!---------------------------------------------------- FORMULARIO ---------------------------------------------------->
				<form name="usuario" action="" method="post">
					<span>Buscar ID:&nbsp;</span><?php txtnrmstl("txtbus","width:50px;"); 
					if (activar_boton($datos,$resultado_perfil_accesos,"Buscar")) { btnnormal("btnGrl", "Buscar"); } ?>
					<?php //btnnormal("btnGrl", "Agregar");?>
					<?php //btnnormal("btnGrl", "Modificar");?>
					<?php 
					if (activar_boton($datos,$resultado_perfil_accesos,"Eliminar")) { if ($categ_usuario=="Prog") btnnormal("btnGrl", "Eliminar"); }?>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Actualizar")) { btnnormal("btnGrl", "Actualizar"); } ?>
					<span id="etq7"><?php if (activar_boton($datos,$resultado_perfil_accesos,"Venta Nueva")) { btnnormal("btnGrl", "Venta Nueva"); } ?></span><br><hr>
					<span id="etq1" >Cliente:</span><?php txtvalstl("txtcli",$vbcli,10,"width:100px;");?>
					<span id="etq5" style=" width:70px;">Grupo:</span><?php 
					cmbfieldJs("div_select_grupo","cmbgrp",$Conexion,"SELECT desc_tipo_prosrv FROM tipo_prod_serv WHERE activo_tipo_prosrv='S'",$vbgrp,"","desc_tipo_prosrv");?>
					<span id="etq5" style=" width:100px;">Tipo Prod.:</span><?php 
					cmbfieldJs("div_select_tipo","cmbtip",$Conexion,"SELECT desc_clase_prosrv FROM clase_prod_serv WHERE activo_clase_prosrv='S'",$vbtip,"","desc_clase_prosrv");?>
					<span id="etq5" style=" width:90px;">Tipo Vta.:</span><?php 
					cmbfieldJs_span("spn_select_tipVent","cmbtvt",$Conexion,"SELECT * FROM tipoventa WHERE activo_vtv='S'",$vbtvt,"","descrip_vtv");?>
					<span id="etq5" style=" width:67px;">Plan:</span><?php cmbfield("cmbpla", $Conexion, "SELECT * from planes WHERE activ_pla=1", $vbpla, "id_pla","abrv_pla");?>
					<span id="etq5" style=" width:100px;">Documento:</span><?php cmbnormal("cmbtdc", $vbtdc, "Boleta de venta", "Factura");?>
					<span id="etq5" style=" width:55px;">Zona:</span><?php 
					cmbfieldJs_span("spn_zona","cmbzon",$Conexion,"SELECT nomb_zna FROM zona WHERE activo_zna='S'",$vbzna,"","nomb_zna");?>
					<span id="etq5" style=" width:60px;">Celular:</span><?php txtvalstl("txtcel",$vbcel,9,"width:90px;");?>
					<span id="etq5" style=" width:130px;">Nº Doc.(Ser-Num):</span><?php txtvalstl("txtndc",$vbndc,7,"width:100px;");?>
					<span id="etq5" style=" width:90px;">Fecha Vta.:</span><?php txtvalstl("txtfch",$vbfch,10,"width:90px;");?>
					<span id="etq5" style=" width:70px;">Id Prod.:</span><?php txtvalstl("txtidp",$vbidp,6,"width:55px;");?>
					<span id="etq5" style=" width:70px;">Cod.Pago:</span><?php txtvalstl("txtcpg",$vbcpg,6,"width:55px;");?>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Filtrar")) { btnnormal("btnGrl", "Filtrar"); } ?><br><hr>
					<?php txtoculto("txtnumreg",$numreg);?>
					<div class="formulario">
						<div id="colizq"  style=" float:left; width:34%;margin-left:25px;">
							<div><span>ID:</span>	<?php txtrdonly("txtid",$var0);?></div>
							<div><span>Fecha de emisión:</span><?php txtvalue("txtfev",$var5,10);?></div>
							<div><span>Fecha de venta:</span><?php txtvalue("txtfvv",$var6,10);?></div>
							<div><span>Documento:</span><?php cmbnormal("cmbtdv", $var7, "Boleta de venta", "Factura");?></div>
							<div><span>Serie:</span><?php txtvalue("txtsrv",$var8,2);?></div>
						</div>
						<div id="colder"  style=" float:left; width:32%;">
							<div><span>Nº de documento:</span><?php txtvalue("txtncv",$var9,5);?></div>
							<div><span>Descripción:</span><?php txtvalue("txtdsv",$var10,50);?></div>
							<div><span>Forma de pago:</span><?php txtvalue("txtfpv",$var11,8);?></div>
							<div><span>Estado de pago:</span><?php cmbnormal("cmbpag", $var22, "Pagado", "NoPago");?></div>
							<div><span>Bas.imp.prod. grv.:</span><?php txtvalue("txtbgr",$var12,12);?></div>
						</div>
						<div id="colders"  style=" float:left; width:32%;">		
							<div><span style=" width:200px;">Bas.imp.prod. no grv.:</span><?php txtvalue("txtbng",$var13,12);?></div>
							<div><span style=" width:200px;">ISC:</span><?php txtvalue("txtisc",$var14,12);?></div>
							<div><span style=" width:200px;">IGV:</span><?php txtvalue("txtigv",$var15,12);?></div>
							<div><span style=" width:200px;">Importe total:</span><?php txtvalue("txtitv",$var16,12);?></div>
							<div><span style=" width:200px;">Zona:</span><?php 
							cmbfieldJs_span("spn_zona","cmbzna",$Conexion,"SELECT nomb_zna FROM zona WHERE activo_zna='S'",$var23,"","nomb_zna");?>
							</div>
						</div>
					</div>
					<hr>
				</form>
				<!---------------------------------------------- LISTADO DE DATOS EN TABLAS ---------------------------------------------->
				<?php
				tblanchovariable($Conexion,"margin-left:0px;","height:320px;",$sql_regventas,"tblnormal",$ambito_busqueda,"ID:id_rvi:50:N","Cliente:clie:180:N","Producto:prod:300:N","Tip.Vta.:tipopla_rvi:60:N","Fech.Vta.:fechaven_rvi:80:N","Docum.:tipodoccp_rvi:60:N","Serie:seriecp_rvi:30:N","Número:numcp_rvi:60:N","Descripción:descrip_rvi:180:N","Monto S/.:importetot_rvi:70:N","Cd.Cpg.:codcpg_rvi:50:N","Estad.:rgpag_rvc:40:N","Zona:zona_rvi:67:N");
				?>
			</div><!--Fin de main-col-->
			<?php scroll_doble("div1", "div2"); ?>
			<article class="piepag"><?php pie_pagina();?></article>
	</body>
</html>