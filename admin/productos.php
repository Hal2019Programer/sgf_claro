<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
$id_pro=$cod_pro=$id_cat=$serie_pro=$imei_pro=$icc_pro=$numcel_pro=$precio_pro=$fechreg_pro=$activ_pro=$id_usr=$abrv_pro=$zona_pro=$tipo_cat=$clase_cat=$ultreg_pro=$marca_cat=$modelo_cat=$preciodesc_pro=$id_prv=$precionormal_prv=$precioespecial_prv=null;
$precio_anterior_pro=$fecha_anterior_pro=$id_anterior_prv=$precio_antes_anterior_pro=$fecha_antes_anterior_pro=$id_antes_anterior_prv=null;
$proveedor_anterior=$proveedor_antes_anterior=null;
$numreg=$id_actual=$vbzn=$vbgr=$vbtp=$vbac=$ultreg_recarga=null;
$vbpr=$busqueda_catalogo=null;
$cantactual=0;
//$ambito_busqueda="Normal";
if (isset($_GET["id"])) { 
	if (!isset($_POST["btnGrl"])) $_POST["btnGrl"]="Buscar ID";
	$bus=$_GET["id"]; $btn=$_POST["btnGrl"]; }
inicializa_funcion_busca_datos_Ajax();
inicializa_ventana_busqueda();
//Datos iniciales para control de accesos de perfil
$resultado_perfil_accesos = Null; $datos = array();
cargar_datos_perfil($Conexion,$ident_usuario,"Productos",$resultado_perfil_accesos,$datos,$categ_usuario,$nivel_usuario,$zona_usuario);
verificar_procesos_de_boton($resultado_perfil_accesos);
?>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Productos");?></head>
	<body>
		<div>
			<?php //cabecera02("Gestión de los productos de almacén"); menu02();?>
			<div style="width:1310px;">
				<?php cabecera04(0,"Productos en Almacén"); menu02(); sl(1);?>
				<!--<center><h1>Productos en Almacén</h1></center><hr>-->
				<?php
                $sql  = mysqli_query ($Conexion,"SELECT * FROM productos p LEFT JOIN proveedores r ON p.id_prv=r.id_prv ORDER BY id_pro DESC LIMIT 10") or die ("Error al traer los datos de la tabla productos.");
                $filas=mysqli_num_rows($sql);
				//$tabla=array(array()); obtener_matriz($sql,$tabla,$filas);
				if (empty($fechreg_pro)) $fechreg_pro=date("d-m-Y");
				//---------------------------------------------- BOTONES ----------------------------------------------
				if(isset($_POST["btnGrl"]))
				{
					if (!isset($_GET["id"])) { $btn=$_POST["btnGrl"]; $bus=$_POST["txt_id_pro_bus"]; }
					//---------------------------------------------- BUSCAR ID ----------------------------------------------
					if($btn=="Buscar ID")
					{
						if ($bus<>"")
						{
							$sql= mysqli_query($Conexion,"SELECT * FROM productos p LEFT JOIN proveedores r ON p.id_prv=r.id_prv WHERE id_pro='$bus'") or die ("Error al traer los datos de productos con WHERE id_pro.");
							if(mysqli_num_rows($sql)>0)
							{	
								$resul=mysqli_fetch_array($sql,MYSQLI_ASSOC);
								$id_pro=$resul["id_pro"];
								$cod_pro=$resul["cod_pro"];
								$id_cat=$resul["id_cat"];
								$serie_pro=$resul["serie_pro"];
								$imei_pro=$resul["imei_pro"];
								$icc_pro=$resul["icc_pro"];
								$numcel_pro=$resul["numcel_pro"];
								$precio_pro=$resul["precio_pro"];
								$fechreg_pro=invFech($resul["fechreg_pro"],"-");
								$activ_pro=$resul["activ_pro"];
								$id_usr=$resul["id_usr"];
								$abrv_pro=$resul["abrv_pro"];
								$zona_pro=$resul["zona_pro"];
								$tipo_cat=$resul["tipo_cat"];
								$clase_cat=$resul["clase_cat"];
								$ultreg_pro=$resul["ultreg_pro"];
								$preciodesc_pro=$resul["preciodesc_pro"];
								$id_prv=$resul["id_prv"];
								$precionormal_prv=$resul["precionormal_prv"];
								$precioespecial_prv=$resul["precioespecial_prv"];
								$precio_anterior_pro=$resul["precio_anterior_pro"];
								$fecha_anterior_pro=invFech($resul["fecha_anterior_pro"],"-");
								$id_anterior_prv=$resul["id_anterior_prv"]; $proveedor_anterior=valfield($Conexion,"proveedores","nom_rzs_prv","id_prv",$id_anterior_prv);
								$precio_antes_anterior_pro=$resul["precio_antes_anterior_pro"];
								$fecha_antes_anterior_pro=invFech($resul["fecha_antes_anterior_pro"],"-");
								$id_antes_anterior_prv=$resul["id_antes_anterior_prv"]; $proveedor_antes_anterior=valfield($Conexion,"proveedores","nom_rzs_prv","id_prv",$id_antes_anterior_prv);
							}
							else
							{
								mensaje("No se encuentra el registro");
							}
						}
						else
						{
							mensaje("Falta el id para la búsqueda de registros"); header("Location: productos.php"); exit;
						}
					}
					//---------------------------------------------- BUSCAR IMEI ----------------------------------------------
					if($btn=="Buscar IMEI")
					{
						$imei_pro_bus=$_POST["txt_imei_pro_bus"];
						if ($imei_pro_bus<>"")
						{
							$busca_asterisco=substr($imei_pro_bus,0,1);
							if ($busca_asterisco=="*")
							{
								$longcad=strlen($imei_pro_bus);
								$cadena_busqueda=substr($imei_pro_bus,1,$longcad-1);
								$longit_busqueda=$longcad-1;
								$cadena_consulta="SELECT * FROM productos p LEFT JOIN proveedores r ON p.id_prv=r.id_prv WHERE right(p.imei_pro,'$longit_busqueda')='$cadena_busqueda' ORDER BY p.id_pro DESC LIMIT 1000";
								$sql = mysqli_query ($Conexion,$cadena_consulta) or die ("Error al traer los datos de busqueda de IMEI de la tabla productos.");
							}
							else
							{
								$cadena_consulta="SELECT * FROM productos p LEFT JOIN proveedores r ON p.id_prv=r.id_prv WHERE p.imei_pro='$imei_pro_bus' ORDER BY p.id_pro DESC LIMIT 1000";
								$sql = mysqli_query ($Conexion,$cadena_consulta) or die ("Error al traer los datos de busqueda de IMEI de la tabla productos.");
							}
						}
						else
						{
							echo "<script> alert('Falta el Imei para la búsqueda de registros.'); location.href = 'productos.php'; </script>";
						}
						//$ambito_busqueda="Todo";
					}
					//---------------------------------------------- BUSCAR ICC ----------------------------------------------
					if($btn=="Buscar ICC")
					{
						$bus=$_POST["txt_icc_pro_bus"];
						if ($bus<>"")
						{
							$busca_asterisco=substr($bus,0,1);
							if ($busca_asterisco=="*")
							{
								$longcad=strlen($bus);
								$cadena_busqueda=substr($bus,1,$longcad-1);
								$longit_busqueda=$longcad-1;
								$cadena_consulta="SELECT * FROM productos p LEFT JOIN proveedores r ON p.id_prv=r.id_prv WHERE right(p.icc_pro,'$longit_busqueda')='$cadena_busqueda' ORDER BY p.id_pro DESC LIMIT 1000";
								$sql = mysqli_query ($Conexion,$cadena_consulta) or die ("Error al traer los datos de busqueda de ICC de la tabla productos.");
							}
							else
							{
								$cadena_consulta="SELECT * FROM productos p LEFT JOIN proveedores r ON p.id_prv=r.id_prv WHERE p.icc_pro='$bus' ORDER BY p.id_pro DESC LIMIT 1000";
								$sql = mysqli_query ($Conexion,$cadena_consulta) or die ("Error al traer los datos de busqueda de ICC de la tabla productos.");
							}
						}
						else
						{
							echo "<script> alert('Falta el ICC para la búsqueda de registros.'); location.href = 'productos.php'; </script>";
						}
						//$ambito_busqueda="Todo";
					}
					//---------------------------------------------- BUSCAR SERIE ----------------------------------------------
					if($btn=="Buscar Serie")
					{
						$bus=$_POST["txt_serie_pro_bus"];
						if ($bus<>"")
						{
							$busca_asterisco=substr($bus,0,1);
							if ($busca_asterisco=="*")
							{
								$longcad=strlen($bus);
								$cadena_busqueda=substr($bus,1,$longcad-1);
								$longit_busqueda=$longcad-1;
								$cadena_consulta="SELECT * FROM productos p LEFT JOIN proveedores r ON p.id_prv=r.id_prv WHERE right(p.serie_pro,'$longit_busqueda')='$cadena_busqueda' ORDER BY p.id_pro DESC LIMIT 1000";
								$sql = mysqli_query ($Conexion,$cadena_consulta) or die ("Error al traer los datos de busqueda de Serie de la tabla productos.");
							}
							else
							{
								$cadena_consulta="SELECT * FROM productos p LEFT JOIN proveedores r ON p.id_prv=r.id_prv WHERE p.serie_pro='$bus' ORDER BY p.id_pro DESC LIMIT 1000";
								$sql = mysqli_query ($Conexion,$cadena_consulta) or die ("Error al traer los datos de busqueda de Serie de la tabla productos.");
							}
						}
						else
						{
							echo "<script> alert('Falta la Serie para la búsqueda de registros.'); location.href = 'productos.php'; </script>";
						}
						$ambito_busqueda="Todo";
					}
					//---------------------------------------------- BUSCAR ZONA/GRUPO/TIPO ----------------------------------------------
					if($btn=="Buscar Zona/Grupo/Tipo")
					{
						$zona=$_POST["cmb_zona_pro_bus"];$vbzn=$zona;
						$grup=$_POST["cmb_tipo_cat_bus"];$vbgr=$grup;
						$tipo=$_POST["cmb_clase_cat_bus"];$vbtp=$tipo;
						$actv=$_POST["cmb_activ_pro_bus"];$vbac=$actv;
						$prov=$_POST["cmb_id_prv_bus"];$vbpr=$prov;
						$catalogo=$_POST["cmb_busca_id_cat"];$busqueda_catalogo=$catalogo;
						$sql_where="";
						if (!empty($zona)) $sql_where=$sql_where."(p.zona_pro='$zona') AND ";
						if (!empty($grup)) $sql_where=$sql_where."(p.tipo_cat='$grup') AND ";
						if (!empty($tipo)) $sql_where=$sql_where."(p.clase_cat='$tipo') AND ";
						if (strlen($actv)>0) $sql_where=$sql_where."(p.activ_pro='$actv') AND ";
						if (!empty($prov)) $sql_where=$sql_where."(p.id_prv='$prov') AND ";
						if (!empty($catalogo)) $sql_where=$sql_where."(p.id_cat='$catalogo') AND ";
						$sql_where=trim($sql_where);
						$sql_where=substr($sql_where, 0, strlen($sql_where)-4);
						if (!empty($sql_where))
						{
							$sql_where="SELECT * FROM productos p LEFT JOIN proveedores r ON p.id_prv=r.id_prv WHERE ".$sql_where." ORDER BY p.id_pro DESC LIMIT 1000";
							$sql= mysqli_query ($Conexion,$sql_where) or die ("Error al filtrar Zona/Grupo/Tipo/Activo de la tabla productos.");
						}
						//$ambito_busqueda="Todo";
					}
					
					//---------------------------------------------- AGREGAR ----------------------------------------------
					if($btn=="Agregar Individual")
					{

						// SELECT * FROM `productos` WHERE id_cat="347" ORDER BY id_pro DESC;
						// Se debe insertar buscando el mismo producto en la misma categoria y obteniendo los 2 ultimos precios
						$idp=$_POST["txt_id_pro"];
						$cdp=""; //$_POST["txt_cod_pro"];//Codigo de producto
						$id_cat=$_POST["cmb_id_cat"]; //Id de catalogo
						$ser=$_POST["txt_serie_pro"]; if (empty($ser)) { $cad_ser=""; } else { $cad_ser=" serie_pro='$ser', "; }//Serie de producto
						$ime=$_POST["txt_imei_pro"]; if (empty($ime)) { $cad_ime=""; } else { $cad_ime=" imei_pro='$ime', "; }//Imei de producto
						$icc=$_POST["txt_icc_pro"]; if (empty($icc)) { $cad_icc=""; } else { $cad_icc=" icc_pro='$icc', "; }//Icc de producto
						$ncl=$_POST["txt_numcel_pro"];
						$prp=$_POST["txt_precio_pro"];//Precio de producto
						$fpr=invFech($_POST["txt_fechreg_pro"],"-");
						$acp=$_POST["cmb_activ_pro"];
						//Modificado por JUAN 18-10-2018 --------------------------------------------
						$abp=valfield($Conexion,"catalogo","marca_cat","id_cat",$id_cat)." ".valfield($Conexion,"catalogo","modelo_cat","id_cat",$id_cat); //abreviatura (abrv_pro) con marca_cat+modelo_cat
						$znp=$_POST["cmb_zona_pro"];
						$gpc=valfield($Conexion,"catalogo","tipo_cat","id_cat",$id_cat);
						$tpc=valfield($Conexion,"catalogo","clase_cat","id_cat",$id_cat);
						//$urg=$_POST["txt_ultreg_pro"];
						$marca_cat=valfield($Conexion,"catalogo","marca_cat","id_cat",$id_cat);
						$modelo_cat=valfield($Conexion,"catalogo","modelo_cat","id_cat",$id_cat);
						//---------------------------------------------------------------------------
						$preciodesc_pro=$_POST["txt_preciodesc_pro"]; if(empty($preciodesc_pro)) $preciodesc_pro=$prp;
						$id_prv=$_POST["cmb_id_prv"];
						$precionormal_prv=$_POST["txt_precionormal_prv"]; if(empty($precionormal_prv)) $precionormal_prv=$prp;
						$precioespecial_prv=$_POST["txt_precioespecial_prv"]; if(empty($precioespecial_prv)) $precioespecial_prv=$prp;
						buscar_ultimos_precios($precio_anterior_pro,$fecha_anterior_pro,$id_anterior_prv,$precio_antes_anterior_pro,$fecha_antes_anterior_pro,$id_antes_anterior_prv);
						//$proveedor1=valfield($Conexion,"proveedores","nom_rzs_prv","id_prv",$id_anterior_prv);
						//$proveedor2=valfield($Conexion,"proveedores","nom_rzs_prv","id_prv",$id_antes_anterior_prv);
						//mensaje("Ultimo precio: $precio_anterior_pro, Fecha ultimo precio: $fecha_anterior_pro, Proveedor: $proveedor1, Precio anterior: $precio_antes_anterior_pro, Fecha antes anterior: $fecha_antes_anterior, Proveedor: $proveedor2");
						// Busca y desactiva el registro si es una recarga virtual
						if ($tpc=="Rec.Virtual")
						{
							//Obtiene nuevo código para la recarga
							$ultreg_recarga=valfieldlast($Conexion,"productos","cod_pro","tipo_cat","Recarga");
							$cadizq=substr($ultreg_recarga,2,4);
							$newnum=$cadizq+1;
							$concat="RV".substr("0000".$newnum,strlen("0000".$newnum)-4,4);
							$cdp=$concat;
							// Busca el codigo de producto de la recarga virtual actual activa
							$cadena_sql_recargas="SELECT id_pro FROM productos WHERE (tipo_cat='Recarga') AND (activ_pro=1) AND (zona_pro='$znp')";
							$regactact_recvir = mysqli_query ($Conexion,$cadena_sql_recargas) or die("Error al agregar datos");
							$regactrvr=mysqli_fetch_array($regactact_recvir);
							$id_actual = $regactrvr[0];
							// Desactiva el registro si es una recarga virtual
							if (!empty($id_actual))
							{
								$cadena_pro="UPDATE productos SET activ_pro=0 WHERE id_pro=$id_actual";
								mysqli_query ($Conexion,$cadena_pro) or die("Error al actualizar datos a productos");
								// Busca el ultimo registro activo del kardex para obtener el saldo de recargas
								$lista_egresos_recarga = mysqli_query ($Conexion,"SELECT cantactual_kar FROM kardex WHERE (id_pro='$id_actual') AND (tiporeg_kar='E') AND (activ_kar=1)") or die("Error al agregar datos");
								$filas_kardex=mysqli_num_rows($lista_egresos_recarga);
								if ($filas_kardex==0) $lista_egresos_recarga = mysqli_query ($Conexion,"SELECT cantactual_kar FROM kardex WHERE (id_pro='$id_actual') AND (tiporeg_kar='I') AND (activ_kar=1)") or die("Error al agregar datos");
								$registro=mysqli_fetch_array($lista_egresos_recarga);
								$cantactual = $registro[0];
								//Desactiva los registros activo segun id de producto del kardex
								$cadena_pro="UPDATE kardex SET activ_kar=0 WHERE id_pro=$id_actual";
								mysqli_query ($Conexion,$cadena_pro) or die("Error al actualizar datos a productos");
							}
						}
						if (verificar_datos_vacios($fpr,$acp,$znp,$id_cat,$ime,$icc,$ser,$prp,$id_prv))
						{
							//Agregar datos a productos
							//$cadena_sql="INSERT INTO productos SET cod_pro='$cdp', id_cat='$id_cat', serie_pro='$ser', imei_pro='$ime', icc_pro='$icc', numcel_pro='$ncl', precio_pro='$prp', fechreg_pro='$fpr', activ_pro=$acp, id_usr='$ident_usuario', abrv_pro='$abp', zona_pro='$znp', tipo_cat='$gpc', clase_cat='$tpc', marca_cat='$marca_cat', modelo_cat='$modelo_cat',preciodesc_pro='$preciodesc_pro', id_prv='$id_prv', precionormal_prv='$precionormal_prv', precioespecial_prv='$precioespecial_prv', precio_anterior_pro='$precio_anterior_pro', fecha_anterior_pro='$fecha_anterior_pro', id_anterior_prv='$id_anterior_prv', precio_antes_anterior_pro='$precio_antes_anterior_pro', fecha_antes_anterior_pro='$fecha_antes_anterior_pro', id_antes_anterior_prv='$id_antes_anterior_prv'";
							$cadena_sql="INSERT INTO productos SET cod_pro='$cdp', id_cat='$id_cat', ".$cad_ser.$cad_ime.$cad_icc." numcel_pro='$ncl', precio_pro='$prp', fechreg_pro='$fpr', activ_pro=$acp, id_usr='$ident_usuario', abrv_pro='$abp', zona_pro='$znp', tipo_cat='$gpc', clase_cat='$tpc', marca_cat='$marca_cat', modelo_cat='$modelo_cat',preciodesc_pro='$preciodesc_pro', id_prv='$id_prv', precionormal_prv='$precionormal_prv', precioespecial_prv='$precioespecial_prv', precio_anterior_pro='$precio_anterior_pro', fecha_anterior_pro='$fecha_anterior_pro', id_anterior_prv='$id_anterior_prv', precio_antes_anterior_pro='$precio_antes_anterior_pro', fecha_antes_anterior_pro='$fecha_antes_anterior_pro', id_antes_anterior_prv='$id_antes_anterior_prv'";
							//echo $cadena_sql; sl(1);
							mysqli_query ($Conexion,$cadena_sql) or die("Error al agregar datos a la tabla de productos.");
							$idp=mysqli_insert_id($Conexion);
							//Calcula datos para agregar a kardex
							$idpk=$idp;//id_pro;
							$fchi=$fpr;//fechreg_pro
							$cpri=$prp;//precio_pro * $cpri carga en el Kardex a cantregistrada_kar y canactual_kar
							$cpri=$cpri+$cantactual;// Se suma al $cpri (cantidad actual) la cantidad anterior del Kardex
							$iusr=$ident_usuario;//id_usr
							//Actualiza el valor de ultreg_pro: ultimo registro con precio o cantidad del producto (usado para recargas)
							$cadena_sql="UPDATE productos SET ultreg_pro='$cpri' WHERE id_pro=$idp";
							mysqli_query($Conexion, $cadena_sql) or die("Error al modificar datos");
							//Añade a kardex los datos calculados del producto
							if ($gpc=="Recarga")
							{
								$cadena_sql="INSERT INTO kardex (tipodoc_kar, numdoc_kar, id_pro, feching_kar, fechsal_kar, cantanterior_kar, cantregistrada_kar, cantactual_kar, costoproding_kar, id_rvi, id_cmp, id_usr, tiporeg_kar, zona_pro, activ_kar) VALUES ('Reporte de Inv.','0001','".$idpk."','".$fchi."','0000-00-00','0','".$cpri."','".$cpri."','".$cpri."','0','0','".$iusr."','I','".$znp."','1')";
							}
							else
							{
								$cadena_sql="INSERT INTO kardex (tipodoc_kar, numdoc_kar, id_pro, feching_kar, fechsal_kar, cantanterior_kar, cantregistrada_kar, cantactual_kar, costoproding_kar, id_rvi, id_cmp, id_usr, tiporeg_kar, zona_pro, activ_kar) VALUES ('Reporte de Inv.','0001','".$idpk."','".$fchi."','0000-00-00','0','1','1','".$cpri."','0','0','".$iusr."','I','".$znp."','1')";
							}
							mysqli_query ($Conexion,$cadena_sql) or die("Error al agregar datos a Kardex");
							echo "<script> alert('Se insertó correctamente'); location.href = 'productos.php'; </script>";
							//$idp=$cdp=$id_cat=$ser=$ime=$icc=$ncl=$prp=$fpr=$acp=$znp=$gpc=$tpc=$urg="";
						}
						else
						{
							echo "<script> alert('No hay datos suficientes para agregar registro.\\nRevise: Imei o Icc o Serie, y fecha, activo, zona, precio, proveedor y catalogo.'); location.href = 'productos.php'; </script>";
						}
					}
					//---------------------------------------------- MODIFICAR ----------------------------------------------
					if ($btn=="Modificar")
					{
						$id_pro=$_POST["txt_id_pro"];//id_producto
						$cod_pro=""; //$_POST["txt_cod_pro"];//codigo
						$id_cat=$_POST["cmb_id_cat"];//catalogo
						$serie_pro=$_POST["txt_serie_pro"]; if (empty($serie_pro)) { $cad_serie_pro=" serie_pro=null, "; } else { $cad_serie_pro=" serie_pro='$serie_pro', "; }//serie
						$imei_pro=$_POST["txt_imei_pro"]; if (empty($imei_pro)) { $cad_imei_pro=" imei_pro=null, "; } else { $cad_imei_pro=" imei_pro='$imei_pro', "; }//imei
						$icc_pro=$_POST["txt_icc_pro"]; if (empty($icc_pro)) { $cad_icc_pro=" icc_pro=null, "; } else { $cad_icc_pro=" icc_pro='$icc_pro', "; }//icc
						$numcel_pro=$_POST["txt_numcel_pro"];
						$precio_pro=$_POST["txt_precio_pro"];//precio
						$fechreg_pro=invFech($_POST["txt_fechreg_pro"],"-");
						$activ_pro=$_POST["cmb_activ_pro"];//prod_activo
						//id_usr=$ident_usuario;
						//Modificado por JUAN 18-10-2018 --------------------------------------------
						$abrv_pro=valfield($Conexion,"catalogo","marca_cat","id_cat",$id_cat)." ".valfield($Conexion,"catalogo","modelo_cat","id_cat",$id_cat); //abreviatura (abrv_pro) con marca_cat+modelo_cat
						$zona_pro=$_POST["cmb_zona_pro"];
						$tipo_cat=valfield($Conexion,"catalogo","tipo_cat","id_cat",$id_cat);//tipo catalogo (tipo_cat)
						$clase_cat=valfield($Conexion,"catalogo","clase_cat","id_cat",$id_cat); //clase catalogo (clase_cat)
						$ultreg_pro=$_POST["txt_ultreg_pro"];
						$marca_cat=valfield($Conexion,"catalogo","marca_cat","id_cat",$id_cat);
						$modelo_cat=valfield($Conexion,"catalogo","modelo_cat","id_cat",$id_cat);
						//---------------------------------------------------------------------------
						$preciodesc_pro=$_POST["txt_preciodesc_pro"]; if(empty($preciodesc_pro)) $preciodesc_pro=$precio_pro;
						$id_prv=$_POST["cmb_id_prv"];
						$precionormal_prv=$_POST["txt_precionormal_prv"]; if(empty($precionormal_prv)) $precionormal_prv=$precio_pro;
						$precioespecial_prv=$_POST["txt_precioespecial_prv"]; if(empty($precioespecial_prv)) $precioespecial_prv=$precio_pro;
						buscar_ultimos_precios($precio_anterior_pro,$fecha_anterior_pro,$id_anterior_prv,$precio_antes_anterior_pro,$fecha_antes_anterior_pro,$id_antes_anterior_prv);
						$proveedor1=valfield($Conexion,"proveedores","nom_rzs_prv","id_prv",$id_anterior_prv);
						$proveedor2=valfield($Conexion,"proveedores","nom_rzs_prv","id_prv",$id_antes_anterior_prv);
						//mensaje("Ultimo precio: $precio_anterior_pro, Fecha ultimo precio: $fecha_anterior_pro, Proveedor: $proveedor1, Precio anterior: $precio_antes_anterior_pro, Fecha antes anterior: $fecha_antes_anterior_pro, Proveedor: $proveedor2");
						//Consulta registro actual
						$cadena_sql = "SELECT id_pro, tipo_cat, activ_pro FROM productos WHERE (id_pro='$id_pro')";
						$sql_prod_actual = mysqli_query($Conexion, $cadena_sql) or die ("Error al borrar el registro");
						$d = mysqli_fetch_array($sql_prod_actual,MYSQLI_ASSOC);
						$id_prod = $d["id_pro"]; $tipo_catl = $d["tipo_cat"]; $activ_prod = $d["activ_pro"];


						//Inicia actualización
						//if (!empty($fechreg_pro) AND !is_null($activ_pro) AND !empty($zona_pro) AND !empty($id_cat) AND (!empty($imei_pro) OR !empty($icc_pro) OR !empty($serie_pro)))
						if (verificar_datos_vacios($fechreg_pro,$activ_pro,$zona_pro,$id_cat,$imei_pro,$icc_pro,$serie_pro,$precio_pro,$id_prv))
						{
							//----------------------------------- Servicios -----------------------------------
							if ($tipo_cat=="Servicios")
							{
								if ($activ_pro==1)
								{
									//$cadena_sql = "UPDATE productos SET cod_pro='$cod_pro', id_cat='$id_cat', serie_pro='$serie_pro', imei_pro='$imei_pro', icc_pro='$icc_pro', numcel_pro='$numcel_pro', precio_pro='$precio_pro', fechreg_pro='$fechreg_pro', activ_pro=$activ_pro, id_usr='$ident_usuario', abrv_pro='$abrv_pro', tipo_cat='$tipo_cat', clase_cat='$clase_cat', ultreg_pro='$ultreg_pro', marca_cat='$marca_cat', modelo_cat='$modelo_cat', preciodesc_pro='$preciodesc_pro', id_prv='$id_prv', precionormal_prv='$precionormal_prv', precioespecial_prv='$precioespecial_prv', precio_anterior_pro='$precio_anterior_pro', fecha_anterior_pro='$fecha_anterior_pro', id_anterior_prv='$id_anterior_prv', precio_antes_anterior_pro='$precio_antes_anterior_pro', fecha_antes_anterior_pro='$fecha_antes_anterior_pro', id_antes_anterior_prv='$id_antes_anterior_prv' WHERE id_pro=$id_pro";
									$cadena_sql = "UPDATE productos SET cod_pro='$cod_pro', id_cat='$id_cat', ".$cad_serie_pro.$cad_imei_pro.$cad_icc_pro." numcel_pro='$numcel_pro', precio_pro='$precio_pro', fechreg_pro='$fechreg_pro', activ_pro=$activ_pro, id_usr='$ident_usuario', abrv_pro='$abrv_pro', tipo_cat='$tipo_cat', clase_cat='$clase_cat', ultreg_pro='$ultreg_pro', marca_cat='$marca_cat', modelo_cat='$modelo_cat', preciodesc_pro='$preciodesc_pro', id_prv='$id_prv', precionormal_prv='$precionormal_prv', precioespecial_prv='$precioespecial_prv', precio_anterior_pro='$precio_anterior_pro', fecha_anterior_pro='$fecha_anterior_pro', id_anterior_prv='$id_anterior_prv', precio_antes_anterior_pro='$precio_antes_anterior_pro', fecha_antes_anterior_pro='$fecha_antes_anterior_pro', id_antes_anterior_prv='$id_antes_anterior_prv' WHERE id_pro=$id_pro";
									mysqli_query($Conexion, $cadena_sql) or die("Error al modificar datos de productos");
									echo "<script> alert('Se modificó correctamente los datos'); location.href = 'productos.php'; </script>";
								}
								else
								{
									echo "<script> alert('No se puede actualizar a inactivo un servicio...'); location.href = 'productos.php'; </script>";
								}
							}
							//----------------------------------- Diferente a Servicios y Recargas -----------------------------------
							if ($tipo_cat<>"Servicios" AND $tipo_cat<>"Recarga")
							{
								//$cadena_sql = "UPDATE productos SET cod_pro='$cod_pro', id_cat='$id_cat', serie_pro='$serie_pro', imei_pro='$imei_pro', icc_pro='$icc_pro', numcel_pro='$numcel_pro', precio_pro='$precio_pro', fechreg_pro='$fechreg_pro', activ_pro=$activ_pro, id_usr='$ident_usuario', abrv_pro='$abrv_pro', zona_pro='$zona_pro', tipo_cat='$tipo_cat', clase_cat='$clase_cat', ultreg_pro='$ultreg_pro', marca_cat='$marca_cat', modelo_cat='$modelo_cat', preciodesc_pro='$preciodesc_pro', id_prv='$id_prv', precionormal_prv='$precionormal_prv', precioespecial_prv='$precioespecial_prv', precio_anterior_pro='$precio_anterior_pro', fecha_anterior_pro='$fecha_anterior_pro', id_anterior_prv='$id_anterior_prv', precio_antes_anterior_pro='$precio_antes_anterior_pro', fecha_antes_anterior_pro='$fecha_antes_anterior_pro', id_antes_anterior_prv='$id_antes_anterior_prv' WHERE id_pro=$id_pro";
								$cadena_sql = "UPDATE productos SET cod_pro='$cod_pro', id_cat='$id_cat', ".$cad_serie_pro.$cad_imei_pro.$cad_icc_pro." numcel_pro='$numcel_pro', precio_pro='$precio_pro', fechreg_pro='$fechreg_pro', activ_pro=$activ_pro, id_usr='$ident_usuario', abrv_pro='$abrv_pro', zona_pro='$zona_pro', tipo_cat='$tipo_cat', clase_cat='$clase_cat', ultreg_pro='$ultreg_pro', marca_cat='$marca_cat', modelo_cat='$modelo_cat', preciodesc_pro='$preciodesc_pro', id_prv='$id_prv', precionormal_prv='$precionormal_prv', precioespecial_prv='$precioespecial_prv', precio_anterior_pro='$precio_anterior_pro', fecha_anterior_pro='$fecha_anterior_pro', id_anterior_prv='$id_anterior_prv', precio_antes_anterior_pro='$precio_antes_anterior_pro', fecha_antes_anterior_pro='$fecha_antes_anterior_pro', id_antes_anterior_prv='$id_antes_anterior_prv' WHERE id_pro=$id_pro";
								mysqli_query($Conexion, $cadena_sql) or die("Error al modificar datos de productos");
								$cadena_sql = "UPDATE kardex SET activ_kar=$activ_pro, zona_pro='$zona_pro' WHERE id_pro=$id_pro";
								mysqli_query($Conexion, $cadena_sql) or die("Error al modificar datos de productos");
								echo "<script> alert('Se modificó correctamente los datos del producto.'); location.href = 'productos.php'; </script>";
							}
							//----------------------------------- Recargas -----------------------------------
							if ($tipo_cat=="Recarga")
							{
								if ($activ_prod==0 AND $activ_pro==0)
								{
									//$cadena_sql = "UPDATE productos SET cod_pro='$cod_pro', id_cat='$id_cat', serie_pro='$serie_pro', imei_pro='$imei_pro', icc_pro='$icc_pro', numcel_pro='$numcel_pro', precio_pro='$precio_pro', fechreg_pro='$fechreg_pro', activ_pro=$activ_pro, id_usr='$ident_usuario', abrv_pro='$abrv_pro', tipo_cat='$tipo_cat', clase_cat='$clase_cat', ultreg_pro='$ultreg_pro', preciodesc_pro='$preciodesc_pro', id_prv='$id_prv', precionormal_prv='$precionormal_prv', precioespecial_prv='$precioespecial_prv', precio_anterior_pro='$precio_anterior_pro', fecha_anterior_pro='$fecha_anterior_pro', id_anterior_prv='$id_anterior_prv', precio_antes_anterior_pro='$precio_antes_anterior_pro', fecha_antes_anterior_pro='$fecha_antes_anterior_pro', id_antes_anterior_prv='$id_antes_anterior_prv' WHERE id_pro=$id_pro";
									$cadena_sql = "UPDATE productos SET cod_pro='$cod_pro', id_cat='$id_cat', ".$cad_serie_pro.$cad_imei_pro.$cad_icc_pro." numcel_pro='$numcel_pro', precio_pro='$precio_pro', fechreg_pro='$fechreg_pro', activ_pro=$activ_pro, id_usr='$ident_usuario', abrv_pro='$abrv_pro', tipo_cat='$tipo_cat', clase_cat='$clase_cat', ultreg_pro='$ultreg_pro', preciodesc_pro='$preciodesc_pro', id_prv='$id_prv', precionormal_prv='$precionormal_prv', precioespecial_prv='$precioespecial_prv', precio_anterior_pro='$precio_anterior_pro', fecha_anterior_pro='$fecha_anterior_pro', id_anterior_prv='$id_anterior_prv', precio_antes_anterior_pro='$precio_antes_anterior_pro', fecha_antes_anterior_pro='$fecha_antes_anterior_pro', id_antes_anterior_prv='$id_antes_anterior_prv' WHERE id_pro=$id_pro";
									mysqli_query($Conexion, $cadena_sql) or die("Error al modificar datos de productos.");
									$cadena_sql = "UPDATE kardex SET activ_kar=$activ_pro WHERE id_pro=$id_pro";
									mysqli_query($Conexion, $cadena_sql) or die("Error al modificar datos de productos.");
									echo "<script> alert('Se modificó correctamente los datosde la tabla productos.'); location.href = 'productos.php'; </script>";
								}
								if ($activ_prod==1 AND $activ_pro==0)
								{
									echo "<script> alert('No se puede actualizar a inactivo una recarga activa...'); location.href = 'productos.php'; </script>";
								}
								if ($activ_prod==1 AND $activ_pro==1)
								{
									//$cadena_sql = "UPDATE productos SET cod_pro='$cod_pro', id_cat='$id_cat', serie_pro='$serie_pro', imei_pro='$imei_pro', icc_pro='$icc_pro', numcel_pro='$numcel_pro', precio_pro='$precio_pro', fechreg_pro='$fechreg_pro', activ_pro=$activ_pro, id_usr='$ident_usuario', abrv_pro='$abrv_pro', tipo_cat='$tipo_cat', clase_cat='$clase_cat', ultreg_pro='$ultreg_pro', preciodesc_pro='$preciodesc_pro', id_prv='$id_prv', precionormal_prv='$precionormal_prv', precioespecial_prv='$precioespecial_prv', precio_anterior_pro='$precio_anterior_pro', fecha_anterior_pro='$fecha_anterior_pro', id_anterior_prv='$id_anterior_prv', precio_antes_anterior_pro='$precio_antes_anterior_pro', fecha_antes_anterior_pro='$fecha_antes_anterior_pro', id_antes_anterior_prv='$id_antes_anterior_prv' WHERE id_pro=$id_pro";
									$cadena_sql = "UPDATE productos SET cod_pro='$cod_pro', id_cat='$id_cat', ".$cad_serie_pro.$cad_imei_pro.$cad_icc_pro." numcel_pro='$numcel_pro', precio_pro='$precio_pro', fechreg_pro='$fechreg_pro', activ_pro=$activ_pro, id_usr='$ident_usuario', abrv_pro='$abrv_pro', tipo_cat='$tipo_cat', clase_cat='$clase_cat', ultreg_pro='$ultreg_pro', preciodesc_pro='$preciodesc_pro', id_prv='$id_prv', precionormal_prv='$precionormal_prv', precioespecial_prv='$precioespecial_prv', precio_anterior_pro='$precio_anterior_pro', fecha_anterior_pro='$fecha_anterior_pro', id_anterior_prv='$id_anterior_prv', precio_antes_anterior_pro='$precio_antes_anterior_pro', fecha_antes_anterior_pro='$fecha_antes_anterior_pro', id_antes_anterior_prv='$id_antes_anterior_prv' WHERE id_pro=$id_pro";
									mysqli_query($Conexion, $cadena_sql) or die("Error al modificar datos de productos.");
									$cadena_sql = "UPDATE kardex SET activ_kar=$activ_pro WHERE id_pro=$id_pro AND activ_kar=1";
									mysqli_query($Conexion, $cadena_sql) or die("Error al modificar datos de productos.");
									echo "<script> alert('Se modificó correctamente los datos de la tabla productos.'); location.href = 'productos.php'; </script>";
								}
								if ($activ_prod==0 AND $activ_pro==1)
								{
									echo "<script> alert('No se puede actualizar a activo una recarga inactiva...'); location.href = 'productos.php'; </script>";
								}
							}
							$id_pro=$cod_pro=$id_cat=$serie_pro=$imei_pro=$icc_pro=$numcel_pro=$precio_pro=$fechreg_pro=$activ_pro=$zona_pro=$tipo_cat=$clase_cat=$ultreg_pro=$id_prod=$tipo_catl=$activ_prod="";
						}
						else
						{
							echo "<script> alert('No hay datos para modificar'); location.href = 'productos.php'; </script>";
						}
					}
					//---------------------------------------------- ELIMINAR ----------------------------------------------
					if($btn=="Eliminar")
					{
						//$nrg=$_POST["txtnumreg"];
						$id_pro_borrar=$_POST["txt_id_pro"];
						//if ($nrg<>"" && $id_pro_borrar<>"")
						if ($id_pro_borrar<>"")
						{
							$cadena_sql = "DELETE FROM productos WHERE id_pro=$id_pro_borrar";
							//mensaje($cadena_sql);
							mysqli_query($Conexion, $cadena_sql) or die ("Error al borrar el registro de la tabla productos por id_pro.");
							echo "<script> alert('Borrado de registro efectuado, actualizando datos...'); location.href = 'productos.php'; </script>";
							$sql = mysqli_query ($Conexion,"SELECT * FROM productos p LEFT JOIN proveedores r ON p.id_prv=r.id_prv ORDER BY id_pro DESC LIMIT 10") or die ("Error al traer los datos de la tabla productos después de eliminar un registro.");
							//$tabla=array(array()); obtener_matriz($sql,$tabla,$filas);
						}
						else
						{
							echo "<script> alert('No hay datos de registro para borrar'); location.href = 'productos.php'; </script>";
						}
					}
					//---------------------------------------------- ACTUALIZAR ----------------------------------------------
					if($btn=="Actualizar")
					{
						header("Location: productos.php"); exit;
					}
					
					//---------------------------------------------- REVISAR ENLACES DESDE PRODUCTO A KARDEX, REGVENTAS Y REGCAJA ----------------------------------------------
					if($btn=="Revisar Enlaces")
					{
						$idpro=$_POST["txt_id_pro_bus"];
						if (!empty($idpro)) $sql_producto = mysqli_query($Conexion,"SELECT * FROM productos WHERE id_pro='$idpro'") or die ("Error al consultar productos");
						$resul_productos = mysqli_fetch_array($sql_producto,MYSQLI_ASSOC);
						$id_prod=$resul_productos["id_pro"];
						$abrv_prod=$resul_productos["abrv_pro"];
						$activo_prod=$resul_productos["activ_pro"];
						echo "PRODUCTO<br>";
						echo "Id Producto : ",$id_prod,"| Descripción abreviada : ",$abrv_prod,"| Activo : ",$activo_prod,"<br>";
						echo "-------------------------------------------------------------------------------------------------------------------------------------------------------------------- <br>";
						$sql_kardex = mysqli_query($Conexion,"SELECT * FROM kardex WHERE tiporeg_kar='E' AND id_pro='$idpro'") or die ("Error al consultar kardex de E");
						$filas=mysqli_num_rows($sql_kardex);
						if ($filas>0)
						{
							while($resul_kardex = mysqli_fetch_array($sql_kardex,MYSQLI_ASSOC))
							{
								$id_kardex=$resul_kardex["id_kar"];
								$id_producto=$resul_kardex["id_pro"];
								$tipodocumento=$resul_kardex["tipodoc_kar"];
								$numerodoc=$resul_kardex["numdoc_kar"];
								$registroventa=$resul_kardex["id_rvi"];
								$zona=$resul_kardex["zona_pro"];
								echo "KARDEX<br>";
								echo "Id Kardex : ",$id_kardex,"| Id Producto : ",$id_producto,"| Tipo de documento de venta : ",$tipodocumento,"| Nº de doc. : ",$numerodoc,"|Id Venta : ",$registroventa,"| Zona : ",$zona,"<br>";
							}
							echo "-------------------------------------------------------------------------------------------------------------------------------------------------------------------- <br>";
							$doc=explode("-", $numerodoc); $doc1=$doc[0]; $doc2=$doc[1];
							$sql_ventas = mysqli_query($Conexion,"SELECT * FROM regventas WHERE seriecp_rvi='$doc1' AND numcp_rvi='$doc2'") or die ("Error al consultar ventas");
							echo "REGISTRO DE VENTAS<br>";
							while($resul_ventas = mysqli_fetch_array($sql_ventas,MYSQLI_ASSOC))
							{
								$id_ventas=$resul_ventas["id_rvi"];
								$id_producto=$resul_ventas["id_pro"];
								$seriedoc=$resul_ventas["seriecp_rvi"];
								$numerodoc=$resul_ventas["numcp_rvi"];
								$importe_venta=$resul_ventas["importetot_rvi"];
								$codigopago=$resul_ventas["codcpg_rvi"];
								echo "Id Venta : ",$id_ventas,"| Id Producto : ",$id_producto,"| Serie : ",$seriedoc,"| Nº de doc. : ",$numerodoc,"| Monto Vta. : ",$importe_venta,"| Codigo Venta : ",$codigopago,"<br>";
							}
							echo "-------------------------------------------------------------------------------------------------------------------------------------------------------------------- <br>";
							$sql_caja = mysqli_query($Conexion,"SELECT * FROM regvtacaja WHERE codcpg_rvi='$codigopago'") or die ("Error al consultar caja");
							while($resul_caja = mysqli_fetch_array($sql_caja,MYSQLI_ASSOC))
							{
								$id_caja=$resul_caja["id_rvc"];
								$codigopago=$resul_caja["codcpg_rvi"];
								$seriedoc=$resul_caja["seriecp_rvi"];
								$numerodoc=$resul_caja["numcp_rvi"];
								$importe_venta=$resul_caja["importetot_rvi"];
								$registropago=$resul_caja["rgpag_rvc"];
								echo "REGISTRO DE CAJA<br>";
								echo "Id Caja : ",$id_caja,"| Código Venta : ",$codigopago,"| Serie : ",$seriedoc,"| Nº de doc. : ",$numerodoc,"| Monto vta. : ",$importe_venta,"| Estado de pago : ",$registropago,"<br>";
							}
							echo "-------------------------------------------------------------------------------------------------------------------------------------------------------------------- <br>";
						}
					}
					if($btn=="Agregar Bloque ICC")
					{
						echo "<script> location.href = 'prodbloq.php'; </script>";
					}
				}
				?>
				<?php
				//---------------------------------------------- CONTEO DE DATOS PARA FORMULARIO ----------------------------------------------
				$vzona=$vgrupo=$vtipo=$vactv=$vprov=$conteo_catalogo=0;
				$vz=$vg=$vt=$va=$vp=$var_conteo_catalogo="";
				if (isset($_POST["cmb_zona_pro_bus"])) $vz=$_POST["cmb_zona_pro_bus"];
				if (isset($_POST["cmb_tipo_cat_bus"])) $vg=$_POST["cmb_tipo_cat_bus"];
				if (isset($_POST["cmb_clase_cat_bus"])) $vt=$_POST["cmb_clase_cat_bus"];
				if (isset($_POST["cmb_activ_pro_bus"])) $va=$_POST["cmb_activ_pro_bus"];
				if (isset($_POST["cmb_id_prv_bus"])) $vp=$_POST["cmb_id_prv_bus"]; //mensaje("vp:".$vp);
				if (isset($_POST["cmb_busca_id_cat"])) $var_conteo_catalogo=$_POST["cmb_busca_id_cat"];
				mysqli_data_seek($sql, 0); 
				while($resul = mysqli_fetch_array($sql,MYSQLI_ASSOC))
				{
					if($resul["zona_pro"]==$vz) $vzona++;
					if($resul["tipo_cat"]==$vg) $vgrupo++;
					if($resul["clase_cat"]==$vt) $vtipo++;
					if($resul["activ_pro"]==$va) $vactv++;
					if($resul["id_prv"]==$vp) $vprov++;
					if($resul["id_cat"]==$var_conteo_catalogo) $conteo_catalogo++;
				}
				?>
				<!------------------------------------------------ FORMULARIO ---------------------------------------------->
				<form name="usuario" action="" method="post">
					<table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed;">
						<tr>
							<td style="width:45%;padding-top:3px;padding-bottom:3px;border:0px;margin:0px;"><?php
							lblnormExt("ID:","","etq5",""); txtnrmstl("txt_id_pro_bus","width:60px;");
							lblnormExt("IMEI:","","etq5","width:35px;"); txtnrmstl("txt_imei_pro_bus","width:130px;");
							lblnormExt("ICC:","","etq5","width:25px;"); txtnrmstl("txt_icc_pro_bus","width:140px;");
							lblnormExt("Serie:","","etq5","width:35px;"); txtnrmstl("txt_serie_pro_bus","width:100px;");?>
							</td>
							<td style="width:55%;padding-top:3px;padding-bottom:3px;border:0px;margin:0px;"><?php
							lblnormExt("Zona(".$vzona.")","","etq5","width:70px;"); cmbfieldJs_span("spn_zona","cmb_zona_pro_bus",$Conexion,"SELECT nomb_zna FROM zona WHERE activo_zna='S'",$vbzn,"","nomb_zna");
							lblnormExt("Grupo(".$vgrupo.")","","etq5","width:80px;"); cmbfieldJs_span("div_select_grupo","cmb_tipo_cat_bus",$Conexion,"SELECT desc_tipo_prosrv FROM tipo_prod_serv WHERE activo_tipo_prosrv='S'",$vbgr,"","desc_tipo_prosrv");
							lblnormExt("Tipo(".$vtipo.")","","etq5","width:70px;");	cmbfieldJs_span("div_select_tipo","cmb_clase_cat_bus",$Conexion,"SELECT desc_clase_prosrv FROM clase_prod_serv WHERE activo_clase_prosrv='S'",$vbtp,"","desc_clase_prosrv");
							lblnormExt("Activo(S/N)(".$vactv.")","","etq5","Width:120px"); cmbnormal("cmb_activ_pro_bus", $vbac, "1", "0"); ?>
							</td>
						</tr>
						<tr>
							<td style="width:45%;padding:0px;border:0px;margin:0px;"><?php
							if (activar_boton($datos,$resultado_perfil_accesos,"Buscar ID")) { btnnormal("btnGrl", "Buscar ID"); }
							if (activar_boton($datos,$resultado_perfil_accesos,"Buscar IMEI")) { btnnormal("btnGrl", "Buscar IMEI"); }
							if (activar_boton($datos,$resultado_perfil_accesos,"Buscar ICC")) { btnnormal("btnGrl", "Buscar ICC"); }
							if (activar_boton($datos,$resultado_perfil_accesos,"Buscar Serie")) { btnnormal("btnGrl", "Buscar Serie"); } ?>
							</td>
							<td style="width:55%;padding:0px;border:0px;margin:0px;"><?php
							lblnormExt("Catalogo(".$conteo_catalogo.")","","etq5","Width:125px"); cmbfieldJs_span("spn_busca_catalogo","cmb_busca_id_cat",$Conexion,"SELECT id_cat, tipo_cat, abrv_cat FROM catalogo",$busqueda_catalogo,"","id_cat","tipo_cat","abrv_cat"); boton_busqueda("spn_busca_catalogo", "productos.busca_catalogo_filtrar.php"); sl(1);
							lblnormExt("Proveedores(".$vprov.")","","etq5","Width:125px"); cmbfieldJs_span("spn_proveedor","cmb_id_prv_bus",$Conexion,"SELECT id_prv,nom_rzs_prv FROM proveedores",$vbpr,"","id_prv","nom_rzs_prv");
							if (activar_boton($datos,$resultado_perfil_accesos,"Buscar Zona/Grupo/Tipo")) { btnnormal("btnGrl", "Buscar Zona/Grupo/Tipo"); } ?>
							</td>
						</tr>
					</table><hr>
					<div class="formulario">
						<div id="colizq" style=" float:left; width:26%;"><?php txtoculto("txtnumreg",$numreg);
							lblnorm("ID:","etq2"); txtrdonly("txt_id_pro",$id_pro); sl(1);
							lblnorm("Imei:","etq2"); txtvalue("txt_imei_pro",$imei_pro,25); sl(1);
							lblnorm("Icc:","etq2"); txtvalue("txt_icc_pro",$icc_pro,25); sl(1);
							lblnormExt("Serie:","","etq2","width:140px;"); txtvalue("txt_serie_pro",$serie_pro,25); sl(1);
							lblnorm("Número de celular:","etq2"); txtvalue("txt_numcel_pro",$numcel_pro,12); sl(1);
							lblnorm("Fecha:","etq2"); txtrdonly("txt_fechreg_pro",$fechreg_pro); ?>
						</div>
						<div id="centro" style=" float:left; width:26%;"><?php
							lblnorm("Activo(S/N):","etq2"); cmbnormal("cmb_activ_pro", $activ_pro, "1", "0"); sl(1);
							lblnorm("Zona:","etq2"); cmbfieldJs_span("spn_zona","cmb_zona_pro",$Conexion,"SELECT nomb_zna FROM zona WHERE activo_zna='S'",$zona_pro,"","nomb_zna"); sl(1);
							lblnorm("Precio Normal S/ :","etq2"); txtvalue("txt_precio_pro",$precio_pro,10); sl(1);
							lblnorm("Precio Desct. S/ :","etq2"); txtvalue("txt_preciodesc_pro",$preciodesc_pro,10); sl(1);
							lblnormExt("Ult.regis.(prec./cant.):","","etq5","width:140px;"); txtvalstl("txt_ultreg_pro", $ultreg_pro, 10, "width:100px;"); ?>
						</div>
						<div id="colder"  style=" float:left; width:48%;"><?php
							lblnormExt("Catálogo:","","etq2","width:70px;"); combo_select("div_catalogo","cmb_id_cat",$Conexion,"SELECT * FROM catalogo WHERE activo_cat='S'",$id_cat,"id_cat","tipo_cat","abrv_cat"); boton_busqueda("div_catalogo", "productos.busca_catalogo.php"); sl(1);
							lblnorm("Proveedor:","etq2"); cmbfieldJs_span("spn_proveedor","cmb_id_prv",$Conexion,"SELECT id_prv,nom_rzs_prv FROM proveedores",$id_prv,"","id_prv","nom_rzs_prv"); sl(1);
							lblnorm("Prec.Norm.Prov. S/ :","etq2"); txtvalue("txt_precionormal_prv",$precionormal_prv,10); sl(1);
							lblnorm("Prec.Espe.Prov. S/ :","etq2"); txtvalue("txt_precioespecial_prv",$precioespecial_prv,10); sl(1);
							lblnormExt("Prec.anter.1 = ","","etq5","width:90px;"); echo $precio_anterior_pro;
							lblnormExt("Fech.anter.1 = ","","etq5","width:90px;"); echo $fecha_anterior_pro;
							lblnormExt("Prov.anter.1 = ","","etq5","width:90px;"); echo $proveedor_anterior; sl(1);
							lblnormExt("Prec.anter.2 = ","","etq5","width:90px;"); echo $precio_antes_anterior_pro;
							lblnormExt("Fech.anter.2 = ","","etq5","width:90px;"); echo $fecha_antes_anterior_pro;
							lblnormExt("Prov.anter.2 = ","","etq5","width:90px;"); echo $proveedor_antes_anterior; ?>
						</div><div style="clear:both"></div><hr>
						<div><?php
							if (activar_boton($datos,$resultado_perfil_accesos,"Agregar Individual")) { if (($categ_usuario=="Prog") OR ($categ_usuario=="Gern") OR ($categ_usuario=="Supr" AND $nivel_usuario=="sup")	OR ($categ_usuario=="Almc" AND $nivel_usuario=="sup")) btnnormal("btnGrl", "Agregar Individual"); }
							if (activar_boton($datos,$resultado_perfil_accesos,"Agregar Bloque ICC")) { if (($categ_usuario=="Prog") OR ($categ_usuario=="Gern") OR ($categ_usuario=="Supr" AND $nivel_usuario=="sup")	OR ($categ_usuario=="Almc" AND $nivel_usuario=="sup")) btnnormal("btnGrl", "Agregar Bloque ICC"); }
							if (activar_boton($datos,$resultado_perfil_accesos,"Modificar")) { if (($categ_usuario=="Prog") OR ($categ_usuario=="Gern")) btnnormal("btnGrl", "Modificar"); }
							if (activar_boton($datos,$resultado_perfil_accesos,"Eliminar")) { if (($categ_usuario=="Prog") OR ($categ_usuario=="Gern")) btnnormal("btnGrl", "Eliminar"); }
							if (activar_boton($datos,$resultado_perfil_accesos,"Actualizar")) { btnnormal("btnGrl", "Actualizar"); }?>
						</div>
					</div>
					<hr>
				</form>
				<!---------------------------------------------- LISTADO DE DATOS EN TABLAS ---------------------------------------------->
				<?php
				tblanchovariable_05($Conexion,"margin-left:0px;","height:200px;",$sql,"tblnormal","productos.php",
				"ID:id_pro:55:idLink|",
				"Grupo:tipo_cat:60:N",
				"Tipo:clase_cat:80:N",
				"Catálogo de productos:id_cat:260:valfield|catalogo|abrv_cat|id_cat",
				"Serie:serie_pro:110:N",
				"Imei:imei_pro:130:N",
				"Icc:icc_pro:145:N",
				"Prec.S/.:precio_pro:60:N",
				"Fecha:fechreg_pro:80:invFech|",
				"Act:activ_pro:30:N",
				"Zona:zona_pro:70:N",
				"Prov.:nom_rzs_prv:150:N");?>
			</div><?php scroll_doble("div1", "div2"); ?>
			<div class="piepag"><?php pie_pagina();?></div>
		</div>
	</body>
</html>
<?php
function buscar_ultimos_precios(&$precio_anterior_pro,&$fecha_anterior_pro,&$id_anterior_prv,&$precio_antes_anterior_pro,&$fecha_antes_anterior_pro,&$id_antes_anterior_prv)
{
	global $Conexion, $idc, $id_cat, $id_pro;
	$idc = $id_cat; // Asignar el id_cat global para usarlo en la consulta
	if (empty($id_pro)) {
		// Si no se ha proporcionado un id_pro, se genera la consulta sin usar id_pro
			//$cadena_buscar_ultimos_precios = "SELECT id_pro, id_cat, precio_pro, fechreg_pro, id_prv FROM productos WHERE id_cat='$idc' GROUP BY id_cat, precio_pro ORDER BY id_pro DESC LIMIT 2";
			$cadena_buscar_ultimos_precios = "SELECT id_pro, id_cat, precio_pro, fechreg_pro, id_prv FROM productos WHERE id_cat='$idc' GROUP BY precio_pro, fechreg_pro ORDER BY id_pro DESC LIMIT 2";
	} else {
			$cadena_buscar_ultimos_precios = "SELECT id_pro, id_cat, precio_pro, fechreg_pro, id_prv FROM productos WHERE id_cat='$idc' AND id_pro<'$id_pro' GROUP BY precio_pro, fechreg_pro ORDER BY id_pro DESC LIMIT 2";
	}
	//mensaje($cadena_buscar_ultimos_precios);
	//$cadena_buscar_ultimos_precios = "SELECT id_pro, id_cat, precio_pro, fechreg_pro, id_prv FROM productos WHERE id_cat='$idc' AND id_pro<'$id_pro' GROUP BY id_cat, precio_pro ORDER BY id_pro DESC LIMIT 2";
	$sql_ultimos_precios = mysqli_query($Conexion, $cadena_buscar_ultimos_precios) or die ("Error al consultar productos para obtener los ultimos precios");
	if (mysqli_num_rows($sql_ultimos_precios) == 0)
	{
		// Si no hay registros, se retorna un precio por defecto
		$precio_anterior_pro = 0;
		$fecha_anterior_pro = "";
		$id_anterior_prv = 0;
		$precio_antes_anterior_pro = 0;
		$fecha_antes_anterior_pro = "";
		$id_antes_anterior_prv = 0;
	}
	if (mysqli_num_rows($sql_ultimos_precios) == 1)
	{
		// Si solo hay un registro, se retorna el precio del único registro encontrado
		$ultimos_precios = mysqli_fetch_array($sql_ultimos_precios,MYSQLI_ASSOC);
		$precio_anterior_pro = $ultimos_precios["precio_pro"];
		$fecha_anterior_pro = $ultimos_precios["fechreg_pro"];
		$id_anterior_prv = $ultimos_precios["id_prv"];
		// Se asigna un valor por defecto para el segundo precio
		$precio_antes_anterior_pro = 0;
		$fecha_antes_anterior_pro = "";
		$id_antes_anterior_prv = 0;
	}
	if (mysqli_num_rows($sql_ultimos_precios) == 2)
	{
		// Si hay dos registros, se retorna el precio de los dos ultimos precios
		// Ultimo precio
		mysqli_data_seek($sql_ultimos_precios, 0);
		$ultimos_precios = mysqli_fetch_array($sql_ultimos_precios,MYSQLI_ASSOC);
		$precio_anterior_pro = $ultimos_precios["precio_pro"];
		$fecha_anterior_pro = $ultimos_precios["fechreg_pro"];
		$id_anterior_prv = $ultimos_precios["id_prv"];
		// Precio antes del ultimo precio
		mysqli_data_seek($sql_ultimos_precios, 1);
		$ultimos_precios = mysqli_fetch_array($sql_ultimos_precios,MYSQLI_ASSOC);
		$precio_antes_anterior_pro = $ultimos_precios["precio_pro"];
		$fecha_antes_anterior_pro = $ultimos_precios["fechreg_pro"];
		$id_antes_anterior_prv = $ultimos_precios["id_prv"];
	}
}
function verificar_datos_vacios($fpr,$acp,$znp,$idc,$ime,$icc,$ser,$precio_pro,$id_prv)
{
	// Verifica si todos los campos requeridos están completos
	// Usar () para agrupar toda la expresión o usar && y || para condiciones ya que tienen mejor precedencia que AND y OR
	//$resultado = (!empty($fpr) AND !empty($acp) AND !empty($znp) AND !empty($idc) AND (!empty($ime) OR !empty($icc) OR !empty($ser)) AND !empty($precio_pro) AND !empty($id_prv));
	$resultado = (!empty($fpr) AND ($acp !== null AND $acp !== '') AND !empty($znp) AND !empty($idc) AND (!empty($ime) OR !empty($icc) OR !empty($ser)) AND !empty($precio_pro) AND !empty($id_prv));
	return $resultado;
}
?>