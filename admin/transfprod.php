<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
/* Variables de busqueda: id_pro, cod_pro, id_cat, serie_pro, imei_pro, icc_pro, numcel_pro, precio_pro, fechreg_pro, activ_pro, id_usr, abrv_pro, zona_pro, tipo_cat, clase_cat */
$var0=$var1=$var2=$var3=$var4=$var5=$var6=$var7=$var8=$var9=$var10=$var11=$var12=$var13=$var14="";
/* id_trs, id_pro, fech_trs, id_usr, abrv_pro, sergr_trs, numgr_trs, znaorig_trs, znadest_trs, tipo_cat, clase_cat */
$vtidt=$vt_id_pro=$vt_fech_trs=$vtusr=$vt_abrv_pro=$vt_sergr_trs=$vt_numgr_trs=$vt_znaorig_trs=$vt_znadest_trs=$vt_tipo_cat=$vt_clase_cat=$vt_monto_transf=$cantactual="";
$numreg=$id_actual="";
$cantregist="";
$ambito_busqueda="Normal";
$vbzn="";
$vbgr="";
$vbtp="";
$vbac="";
//Datos iniciales para control de accesos de perfil
$resultado_perfil_accesos = Null; $datos = array();
cargar_datos_perfil($Conexion,$ident_usuario,"Transferencias",$resultado_perfil_accesos,$datos,$categ_usuario,$nivel_usuario,$zona_usuario);
verificar_procesos_de_boton($resultado_perfil_accesos);
?>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Transferencias");?></head>
	<body>
		<div>
			<?php //cabecera02("Transferencia de productos"); menu02();?>
			<div style="width:1310px;">
				<?php cabecera04(0,"Transferencias de Productos"); menu02(); sl(1);?>
				<!--<center><h1>Transferencias de Productos</h1></center><hr>-->
				<?php
				if (($categ_usuario=="Prog") OR ($categ_usuario=="Gern")) {	$sql= mysqli_query ($Conexion,"SELECT * FROM productos WHERE activ_pro=1") or die ("Error al traer los datos"); }
				else { $sql= mysqli_query ($Conexion,"SELECT * FROM productos WHERE (activ_pro=1) AND (zona_pro='$zona_usuario')") or die ("Error al traer los datos"); }
				$tabla=array(array()); obtener_matriz($sql,$tabla,$filas);
				if (empty($var8)) $var8=date("d-m-Y");
				if(isset($_POST["btnGrl"]))
				{
					$btn=$_POST["btnGrl"];$bus=$_POST["txtbus"];
					if($btn=="Cargar ID")
					{
						if ($bus<>"")
						{	$numreg=busca_id($tabla,$filas,$bus);
							if($numreg>=0)
							{	
								mysqli_data_seek($sql, $numreg); $r=mysqli_fetch_array($sql,MYSQLI_ASSOC);
								$var0=$r["id_pro"];	$var1=$r["cod_pro"]; $var2=$r["id_cat"]; $var3=$r["serie_pro"]; $var4=$r["imei_pro"]; $var5=$r["icc_pro"];
								$var6=$r["numcel_pro"];	$var7=$r["precio_pro"]; $var9=$r["activ_pro"]; $var10=$r["id_usr"];
								$var11=$r["abrv_pro"]; $var12=$r["zona_pro"]; $var13=$r["tipo_cat"]; $var14=$r["clase_cat"];
								// Se obtiene la ultima cantidad actual del egreso del producto
								$cantactual=valfield($Conexion,"productos","ultreg_pro","id_pro",$var0);
							}
							else
							{	
								echo "<script> alert('No se encuentra el registro para el ID buscado'); </script>";
							}
						}
						else
						{	
							echo "<script> alert('Falta el id para la búsqueda de registros'); location.href = 'transfprod.php'; </script>";
						}
					}
					if($btn=="Buscar IMEI")
					{
						$bus=$_POST["txtbim"];
						if ($bus<>"")
						{
							$busca_asterisco=substr($bus,0,1);
							if ($busca_asterisco=="*")
							{
								buscalongitud($bus, $cadena_busqueda, $longit_busqueda);
								if (($categ_usuario=="Prog") OR ($categ_usuario=="Gern")) { $cadena_consulta="SELECT * FROM productos WHERE right(imei_pro,'$longit_busqueda')='$cadena_busqueda'"." AND (activ_pro=1)"; }
								else { $cadena_consulta="SELECT * FROM productos WHERE right(imei_pro,'$longit_busqueda')='$cadena_busqueda'"." AND (activ_pro=1) AND (zona_pro='$zona_usuario')"; }
								$sql = mysqli_query ($Conexion,$cadena_consulta) or die ("Error al traer los datos");
							}
							else
							{
								if (($categ_usuario=="Prog") OR ($categ_usuario=="Gern")) { $cadena_consulta="SELECT * FROM productos WHERE imei_pro='$bus'"." AND (activ_pro=1)"; }
								else { $cadena_consulta="SELECT * FROM productos WHERE imei_pro='$bus'"." AND (activ_pro=1) AND (zona_pro='$zona_usuario')"; }
								$sql = mysqli_query ($Conexion,$cadena_consulta) or die ("Error al traer los datos");
							}
						}
						else
						{
							echo "<script> alert('Falta el Imei para la búsqueda de registros'); location.href = 'transfprod.php'; </script>";
						}
					}
					if($btn=="Buscar ICC")
					{
						$bus=$_POST["txtbic"];
						if ($bus<>"")
						{
							$busca_asterisco=substr($bus,0,1);
							if ($busca_asterisco=="*")
							{
								buscalongitud($bus, $cadena_busqueda, $longit_busqueda);
								if (($categ_usuario=="Prog") OR ($categ_usuario=="Gern")) { $cadena_consulta="SELECT * FROM productos WHERE right(icc_pro,'$longit_busqueda')='$cadena_busqueda'"." AND (activ_pro=1)"; }
								else { $cadena_consulta="SELECT * FROM productos WHERE right(icc_pro,'$longit_busqueda')='$cadena_busqueda'"." AND (activ_pro=1) AND (zona_pro='$zona_usuario')"; }
								$sql = mysqli_query ($Conexion,$cadena_consulta) or die ("Error al traer los datos");
							}
							else
							{
								if (($categ_usuario=="Prog") OR ($categ_usuario=="Gern")) { $cadena_consulta="SELECT * FROM productos WHERE icc_pro='$bus'"." AND (activ_pro=1)"; }
								else { $cadena_consulta="SELECT * FROM productos WHERE icc_pro='$bus'"." AND (activ_pro=1) AND (zona_pro='$zona_usuario')"; }
								$sql = mysqli_query ($Conexion,$cadena_consulta) or die ("Error al traer los datos");
							}
						}
						else
						{
							echo "<script> alert('Falta el Imei para la búsqueda de registros'); location.href = 'transfprod.php'; </script>";
						}
					}
					if($btn=="Buscar Serie")
					{
						$bus=$_POST["txtbse"];
						if ($bus<>"")
						{
							$busca_asterisco=substr($bus,0,1);
							if ($busca_asterisco=="*")
							{
								buscalongitud($bus, $cadena_busqueda, $longit_busqueda);
								if (($categ_usuario=="Prog") OR ($categ_usuario=="Gern")) { $cadena_consulta="SELECT * FROM productos WHERE right(serie_pro,'$longit_busqueda')='$cadena_busqueda'"." AND (activ_pro=1)"; }
								else { $cadena_consulta="SELECT * FROM productos WHERE right(serie_pro,'$longit_busqueda')='$cadena_busqueda'"." AND (activ_pro=1) AND (zona_pro='$zona_usuario')"; }
								$sql = mysqli_query ($Conexion,$cadena_consulta) or die ("Error al traer los datos");
							}
							else
							{
								if (($categ_usuario=="Prog") OR ($categ_usuario=="Gern")) { $cadena_consulta="SELECT * FROM productos WHERE serie_pro='$bus'"." AND (activ_pro=1)"; }
								else { $cadena_consulta="SELECT * FROM productos WHERE serie_pro='$bus'"." AND (activ_pro=1) AND (zona_pro='$zona_usuario')"; }
								$sql = mysqli_query ($Conexion,$cadena_consulta) or die ("Error al traer los datos");
							}
						}
						else
						{
							echo "<script> alert('Falta el Imei para la búsqueda de registros'); location.href = 'transfprod.php'; </script>";
						}
					}
					//---------------------------------------------- BUSCAR ZONA/GRUPO/TIPO ----------------------------------------------
					if($btn=="Buscar Zona/Grupo/Tipo")
					{
						$zona=$_POST["cmbbzn"];$vbzn=$zona;
						$grup=$_POST["cmbtpc"];$vbgr=$grup;
						$tipo=$_POST["cmbclc"];$vbtp=$tipo;
						$actv=$_POST["cmbbac"];$vbac=$actv;
						$sql_where="";
						if (!empty($zona)) $sql_where=$sql_where."(zona_pro='$zona') AND ";
						if (!empty($grup)) $sql_where=$sql_where."(tipo_cat='$grup') AND ";
						if (!empty($tipo)) $sql_where=$sql_where."(clase_cat='$tipo') AND ";
						if (strlen($actv)>0) $sql_where=$sql_where."(activ_pro='$actv') AND ";
						$sql_where=trim($sql_where);
						$sql_where=substr($sql_where, 0, strlen($sql_where)-4);						
						if (!empty($sql_where))
						{
							
							if (($categ_usuario=="Prog") OR ($categ_usuario=="Gern"))
							{	
								$sql_main = "SELECT * FROM productos WHERE activ_pro=1"; 
							}
							else 
							{ 
								$sql_main = "SELECT * FROM productos WHERE (activ_pro=1) AND (zona_pro='$zona_usuario')"; 
							}
							$sql_where = $sql_main." AND ".$sql_where;
							$sql = mysqli_query ($Conexion,$sql_where) or die ("Error al filtrar Zona/Grupo/Tipo");
						}
						$ambito_busqueda="Todo";
					}
					//---------------------------------------------- Transferencia de producto ----------------------------------------------
					if ($btn=="Transferir")
					{
						$vt_id_pro=$_POST["txtid"];//id_pro
						$vt_fech_trs=$_POST["txtfpr"];$vt_fech_trs=invFech($vt_fech_trs,"-");//fech_trs
						$vt_abrv_pro=$_POST["txtabrv"];//abrv_pro
						$vt_sergr_trs=$_POST["txtsgr"];//sergr_trs
						$vt_numgr_trs=$_POST["txtngr"];//numgr_trs
						$vt_znaorig_trs=$_POST["txtzno"];//znaorig_trs
						$vt_znadest_trs=$_POST["cmbznd"];//znadest_trs
						$vt_tipo_cat=$_POST["txttcat"];//tipo_cat
						$vt_clase_cat=$_POST["txtccat"];//clase_cat
						$vt_monto_transf=$_POST["txtmnt"];//Monto de transferencia de recargas
						if ($vt_znadest_trs<>"" && $vt_sergr_trs<>"" && $vt_numgr_trs<>"")
						{
							$tiporeg=valfield($Conexion,"productos","tipo_cat","id_pro",$vt_id_pro);
							if ($tiporeg=="Recarga")
							{
								// Se obtiene la ultima cantidad del producto origen
								$cantactual_origen=valfield($Conexion,"productos","ultreg_pro","id_pro",$vt_id_pro);
								//Calculo de descuento de recarga de la zona origen en el kardex
								$cant_anterior = $cantactual_origen; $cant_registrada = $vt_monto_transf; $cant_actual = $cant_anterior - $cant_registrada;
								//Actualizar el saldo de ultreg_pro de productos
								updatesql($Conexion,"UPDATE productos SET ultreg_pro='$cant_actual' WHERE id_pro=$vt_id_pro","Error al modificar Productos para datos origen");
								//Obtiene id_kar del (E)greso activo para el id_pro del producto
								$v_id_kar_activ = vconsulta($Conexion,"SELECT id_kar FROM kardex WHERE id_pro='$vt_id_pro' AND tiporeg_kar='E' AND activ_kar='1'");
								if ($v_id_kar_activ<>-1) updatesql($Conexion,"UPDATE kardex SET activ_kar=0 WHERE id_kar=$v_id_kar_activ","Error al modificar Kardex para desactivar egreso activo");
								//Registrar (E)greso en kardex para el almacen origen y colocar saldo actual
								insertarsql($Conexion,"Error al insertar registro en kardex","kardex","tipodoc_kar",'Guía de Remis.',"numdoc_kar",$vt_sergr_trs."-".$vt_numgr_trs,"id_pro",$vt_id_pro,"feching_kar",'0000-00-00',"fechsal_kar",$vt_fech_trs,"cantanterior_kar",$cant_anterior,"cantregistrada_kar",$cant_registrada,"cantactual_kar",$cant_actual,"costoproding_kar",'0.00',"id_rvi",'0',"id_cmp",'0',"id_usr",$ident_usuario,"tiporeg_kar",'E',"zona_pro",$vt_znaorig_trs,"activ_kar",'1');
								//Obtener saldo actual del almacen destino
								$v_saldo_destino = vconsulta($Conexion,"SELECT ultreg_pro FROM productos WHERE activ_pro='1' AND tipo_cat='Recarga' AND zona_pro='$vt_znadest_trs'");
								//Calcula nuevo saldo del producto en almacen destino
								$cant_anterior = $v_saldo_destino; $cant_registrada = $vt_monto_transf;	$cant_actual = $cant_anterior + $cant_registrada;
								//Generar nuevo codigo automatico tipo Recarga en almacen de productos destino
								$ultreg_recarga=valfieldlast($Conexion,"productos","cod_pro","tipo_cat","Recarga");
								$cadizq=substr($ultreg_recarga,2,4); $newnum=$cadizq+1; $codpro="RV".substr("0000".$newnum,strlen("0000".$newnum)-4,4);
								//Busca codigo de producto tipo recarga activo de almacen destino
								$v_id_pro_destino = vconsulta($Conexion,"SELECT id_pro FROM productos WHERE activ_pro=1 AND tipo_cat='Recarga' AND zona_pro='$vt_znadest_trs'");
								$v_id_cat_destino = vconsulta($Conexion,"SELECT id_cat FROM productos WHERE activ_pro=1 AND tipo_cat='Recarga' AND zona_pro='$vt_znadest_trs'");
								$v_clase_cat_destino = vconsulta($Conexion,"SELECT clase_cat FROM productos WHERE activ_pro=1 AND tipo_cat='Recarga' AND zona_pro='$vt_znadest_trs'");
								//Actualiza producto del almacen destino a inactivo
								updatesql($Conexion,"UPDATE productos SET activ_pro=0 WHERE id_pro=$v_id_pro_destino","Error al modificar Productos para datos destino");
								updatesql($Conexion,"UPDATE kardex SET activ_kar=0 WHERE id_pro=$v_id_pro_destino","Error al modificar Kardex para datos destino");
								//Insertar nuevo registro de recarga en productos del almacen destino
								insertarsql($Conexion,"Error al insertar registros en productos","productos","cod_pro", $codpro,"id_cat", $v_id_cat_destino,"serie_pro", '',"imei_pro", '',"icc_pro", '',"numcel_pro", '',"precio_pro", $vt_monto_transf,"fechreg_pro", $vt_fech_trs,"activ_pro", '1',"id_usr", $ident_usuario,"abrv_pro", $vt_abrv_pro,"zona_pro", $vt_znadest_trs,"tipo_cat", 'Recarga',"clase_cat", $v_clase_cat_destino,"ultreg_pro",$cant_actual);
								//Obtiene nuevo id_pro de recarga activa del almacen destino
								$v_id_pro_destino = vconsulta($Conexion,"SELECT id_pro FROM productos WHERE tipo_cat='Recarga' AND activ_pro='1' AND zona_pro='$vt_znadest_trs'");
								//Inserta un registro (I) en Kardex con la fecha y numero de documento de salida de monto de recarga
								insertarsql($Conexion,"Error al insertar registros en kardex","kardex","tipodoc_kar",'Guía de Remis.',"numdoc_kar",$vt_sergr_trs."-".$vt_numgr_trs,"id_pro",$v_id_pro_destino,"feching_kar",$vt_fech_trs,"fechsal_kar",'0000-00-00',"cantanterior_kar",$cant_anterior,"cantregistrada_kar",$cant_registrada,"cantactual_kar",$cant_actual,"costoproding_kar",$vt_monto_transf,"id_rvi",'0',"id_cmp",'0',"id_usr",$ident_usuario,"tiporeg_kar",'I',"zona_pro",$vt_znadest_trs,"activ_kar",'1');
								//Genera nuevo registro en transfprod
								insertarsql($Conexion,"Error al insertar registros en transfprod de recarga virtual","transfprod","id_pro",$vt_id_pro,"fech_trs", $vt_fech_trs,"id_usr", $ident_usuario,"abrv_pro", $vt_abrv_pro,"sergr_trs", $vt_sergr_trs,"numgr_trs", $vt_numgr_trs,"znaorig_trs", $vt_znaorig_trs,"znadest_trs", $vt_znadest_trs,"tipo_cat", $vt_tipo_cat,"clase_cat", $vt_clase_cat);
								echo "<script> alert('Se realizó la transferencia de datos correctamente'); location.href = 'transfprod.php'; </script>";
							}
							if ($tiporeg<>"Recarga")
							{
								$cadena_sql = "UPDATE productos SET zona_pro='$vt_znadest_trs' WHERE id_pro=$vt_id_pro";
								mysqli_query($Conexion, $cadena_sql) or die("Error al modificar productos");							
								$cadena_sql="UPDATE kardex SET zona_pro='$vt_znadest_trs' WHERE id_pro=$vt_id_pro";
								mysqli_query ($Conexion,$cadena_sql) or die("Error al modificar Kardex");
								$cadena_sql="INSERT INTO transfprod (id_pro, fech_trs, id_usr, abrv_pro, sergr_trs, numgr_trs, znaorig_trs, znadest_trs, tipo_cat, clase_cat) VALUES ('".$vt_id_pro."','".$vt_fech_trs."','".$ident_usuario."','".$vt_abrv_pro."','".$vt_sergr_trs."','".$vt_numgr_trs."','".$vt_znaorig_trs."','".$vt_znadest_trs."','".$vt_tipo_cat."','".$vt_clase_cat."')";
								mysqli_query ($Conexion,$cadena_sql) or die("Error al agregar datos a registro de transferencias en otros productos");
								echo "<script> alert('Se modificó realizo la transferencia de datos correctamente'); location.href = 'transfprod.php'; </script>";
							}
						}
						else
						{
							echo "<script> alert('No hay datos para transferir'); location.href = 'transfprod.php'; </script>";
						}
					}
					//Actualizar pantalla
					if($btn=="Actualizar")
					{					
						echo "<script> location.href = 'transfprod.php'; </script>";
					}
					
					if($btn=="Guia Remision")
					{					
						echo "<script> location.href = 'transfprod_gr.php'; </script>";
					}
				}
				?>
				<form name="usuario" action="" method="post">
					<?php
					lblnorm("ID:","etq5"); txtnrmstl("txtbus","width:50px;"); 
					if (activar_boton($datos,$resultado_perfil_accesos,"Cargar ID")) { btnnormal("btnGrl", "Cargar ID"); }
					lblnorm("IMEI:","etq12"); txtnrmstl("txtbim","width:100px;"); 
					if (activar_boton($datos,$resultado_perfil_accesos,"Buscar IMEI")) { btnnormal("btnGrl", "Buscar IMEI"); }
					lblnorm("ICC:","etq12");txtnrmstl("txtbic","width:100px;"); 
					if (activar_boton($datos,$resultado_perfil_accesos,"Buscar ICC")) { btnnormal("btnGrl", "Buscar ICC"); }
					lblnorm("Serie:","etq12");txtnrmstl("txtbse","width:100px;"); 
					if (activar_boton($datos,$resultado_perfil_accesos,"Buscar Serie")) { btnnormal("btnGrl", "Buscar Serie"); } ?><br>
					<span id="etq5"style="width:233px;">Zona:</span>
					<?php 
					//cmbnormal("cmbbzn", $vbzn, "JUNCD05", "JUNDL39", "JUNDL43", "PRE_DL39", "PRE_DL43", "JUNCD12", "Almacen1", "Almacen2", "Almacen3", "Almacen4", "Almacen5", "JUNDA29"); 
					cmbfieldJs_span("spn_zona","cmbbzn",$Conexion,"SELECT nomb_zna FROM zona WHERE activo_zna='S'",$vbzn,"","nomb_zna"); 
					?>
					<span id="etq4">Grupo:</span><?php 
					//cmbnormal("cmbtpc", $vbgr, "Equipo", "Modem", "Chip", "Recarga", "Tableta", "Servicios", "Accesorios", "Otros");
					cmbfieldJs("div_select_grupo","cmbtpc",$Conexion,"SELECT desc_tipo_prosrv FROM tipo_prod_serv WHERE activo_tipo_prosrv='S'",$vbgr,"","desc_tipo_prosrv");
					?>
					<span id="etq4">Tipo:</span><?php 
					//cmbnormal("cmbclc", $vbtp, "Handset", "Smartphone", "Modem", "PackConnect", "SIM Mobile", "BSmart", "BFree", "BCombo", "Uni","Kit BVoz","Kit BData","Kit BitelUNIV", "Kit Bfono", "Router", "Rec.Tarjeta", "Rec.Virtual", "Tablet", "SD Card", "Auricular", "CarcasaSmpl", "CarcasaTapa", "ProtectPant", "Migracion", "CambioPlan", "BajaLinea", "Desbloqueo", "Reconfigur.", "Otros");
					cmbfieldJs("div_select_tipo","cmbclc",$Conexion,"SELECT desc_clase_prosrv FROM clase_prod_serv WHERE activo_clase_prosrv='S'",$vbtp,"","desc_clase_prosrv");
					?>
					<span id="etq2">Activo(S/N):</span><?php cmbnormal("cmbbac", $vbac, "1", "0"); 
					if (activar_boton($datos,$resultado_perfil_accesos,"Buscar Zona/Grupo/Tipo")) { btnnormal("btnGrl", "Buscar Zona/Grupo/Tipo"); } ?>
					<br><hr>
					<!-- Cuadros de texto oculto que contienen variables -->
					<?php txtoculto("txtnumreg",$numreg); txtoculto("txtabrv",$var11); txtoculto("txttcat",$var13); txtoculto("txtccat",$var14);?>
					<!-- Cuadros de texto de solo lectura, para usarse en la transferencia -->
					<?php
					if (!empty($var2)) $var2=$var2.":".valfield($Conexion,"catalogo","abrv_cat","id_cat",$var2);
					lblnorm("ID:","etq5"); txtronstl("txtid",$var0,"width:50px;");
					lblnorm("Cód. Prod.:","etq4"); txtronstl("txtcdp",$var1,"width:75px;");
					lblnorm("Catálogo:","etq4"); txtronstl("txtidc",$var2,"width:240px;"); 
					//if ($cantactual<>0) { lblnorm("Recarga disponible:","etq2"); txtronstl("txtcna",$cantactual,"width:80px;"); } verificar su uso
					?><br>
					<?php
					lblnorm("Serie:","etq5"); txtronstl("txtser",$var3,"width:140px;");
					lblnorm("Imei:","etq12"); txtronstl("txtime",$var4,"width:140px;");
					lblnorm("Icc:","etq12"); txtronstl("txticc",$var5,"width:140px;");
					lblnorm("Fecha:","etq12"); txtronstl("txtfpr",$var8,"width:90px;");
					lblnorm("Zona origen:","etq4"); txtronstl("txtzno", $var12,"width:90px;");
					?>
					<br><hr>
					<?php lblnorm("Zona destino:","etq5"); 
					//cmbnormal("cmbznd", $vt_znadest_trs, "JUNCD05", "JUNDL39", "JUNDL43", "PRE_DL39", "PRE_DL43", "JUNCD12", "Almacen1", "Almacen2", "Almacen3", "Almacen4", "Almacen5", "JUNDA29");
					cmbfieldJs_span("spn_zona","cmbznd",$Conexion,"SELECT nomb_zna FROM zona WHERE activo_zna='S'",$vt_znadest_trs,"","nomb_zna"); 
					?>
					<?php lblnorm("Serie de Guía Remis.:","etq3"); txtvalstl("txtsgr",$vt_sergr_trs,2,"width:25px;");?>
					<?php lblnorm("Núm. de Guía Remis.:","etq3"); txtvalstl("txtngr",$vt_numgr_trs,12,"width:60px;");?>
					<?php lblnorm("Monto transf.:","etq4"); txtvalstl("txtmnt",$vt_monto_transf,12,"width:60px;");?><span style="display:inline-block; width:45px;"></span>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Transferir")) { btnnormal("btnGrl", "Transferir"); } ?>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Actualizar")) { btnnormal("btnGrl", "Actualizar"); } ?>
					<?php btnnormal("btnGrl", "Guia Remision"); ?>
					<br><hr>
				</form> <!-- Fin de formulario -->
				<!-- Inicio de listado de datos de usuario -->
				<?php tblanchovariable($Conexion,"margin-left:0px;","height:250px;",$sql,"tblnormal",$ambito_busqueda,
				"ID:id_pro:50:N",
				"Cód.:cod_pro:60:N",
				"Grupo:tipo_cat:80:N",
				"Catálogo de productos:id_cat:260:valfield|catalogo|abrv_cat|id_cat",
				"Serie:serie_pro:120:N",
				"Imei:imei_pro:120:N",
				"Icc:icc_pro:150:N",
				"Fecha:fechreg_pro:80:invFech|",
				"Zona Origen:zona_pro:120:N",
				"Activo:activ_pro:60:N",
				"Precio:precio_pro:100:N",
				"Monto Actual:ultreg_pro:100:N"); ?>
				<!-- Fin de listado de datos de usuario -->
			</div><!--Fin de main-col-->
			<?php scroll_doble("div1", "div2"); ?>
		<article class="piepag"><?php pie_pagina();?></article>
	</body>
</html>