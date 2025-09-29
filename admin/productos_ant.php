<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
/* Variables de busqueda: id_pro, cod_pro, id_cat, serie_pro, imei_pro, icc_pro, numcel_pro, precio_pro, fechreg_pro, activ_pro, id_usr, abrv_pro, zona_pro, tipo_cat, clase_cat, ultreg_pro */
$var0=$var1=$var2=$var3=$var4=$var5=$var6=$var7=$var8=$var9=$var10=$var11=$var12=$var13=$var14=$var15=$numreg=$id_actual="";
$cantactual=0;
$vbzn=$vbgr=$vbtp=$vbac="";
$ambito_busqueda="Normal";
$ultreg_recarga="";
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
		<div  style="color:#0A2C4F">
			<?php cabecera02("Gestión de los productos de almacén"); menu02();?>
			<div id="main-col2"  style="width: 1310px;padding: 15px;margin-left:5px">
				<center style="font-size:20px;"><b>Productos en Almacén</b></center><br>
				<?php
				$sql= mysqli_query ($Conexion,"SELECT * FROM productos") or die ("Error al traer los datos");
				$tabla=array(array()); obtener_matriz($sql,$tabla,$filas);
				if (empty($var8)) $var8=date("d-m-Y");
				//---------------------------------------------- BOTONES ----------------------------------------------
				if(isset($_POST["btnGrl"]))
				{
					$btn=$_POST["btnGrl"];$bus=$_POST["txtbus"];
					//---------------------------------------------- BUSCAR ID ----------------------------------------------
					if($btn=="Buscar ID")
					{
						if ($bus<>"")
						{
							$numreg=busca_id($tabla,$filas,$bus);
							if($numreg>=0)
							{	
								mysqli_data_seek($sql, $numreg); 
								$resul=mysqli_fetch_array($sql);
								$var0=$resul[0];//id_pro
								$var1=$resul[1];//cod_pro
								$var2=$resul[2];//id_cat
								$var3=$resul[3];//serie_pro
								$var4=$resul[4];//imei_pro
								$var5=$resul[5];//icc_pro
								$var6=$resul[6];//numcel_pro
								$var7=$resul[7];//precio_pro
								$var8=invFech($resul[8],"-");//fechreg_pro
								$var9=$resul[9];//activ_pro
								$var10=$resul[10];//id_usr
								$var11=$resul[11];//abrv_pro
								$var12=$resul[12];//zona_pro
								$var13=$resul[13];//tipo_cat
								$var14=$resul[14];//clase_cat
								$var15=$resul[15];//ultreg_pro
							}
							else
							{
								echo "<script> alert('No se encuentra el registro'); </script>";
							}
						}
						else
						{
							echo "<script> alert('Falta el id para la búsqueda de registros'); location.href = 'productos.php'; </script>";
						}
					}
					//---------------------------------------------- BUSCAR IMEI ----------------------------------------------
					if($btn=="Buscar IMEI")
					{
						$bus=$_POST["txtbim"];
						if ($bus<>"")
						{
							$busca_asterisco=substr($bus,0,1);
							if ($busca_asterisco=="*")
							{
								$longcad=strlen($bus);
								$cadena_busqueda=substr($bus,1,$longcad-1);
								$longit_busqueda=$longcad-1;
								$cadena_consulta="SELECT * FROM productos WHERE right(imei_pro,'$longit_busqueda')='$cadena_busqueda'";
								$sql = mysqli_query ($Conexion,$cadena_consulta) or die ("Error al traer los datos");
							}
							else
							{
								$cadena_consulta="SELECT * FROM productos WHERE imei_pro='$bus'";
								$sql = mysqli_query ($Conexion,$cadena_consulta) or die ("Error al traer los datos");
							}
						}
						else
						{
							echo "<script> alert('Falta el Imei para la búsqueda de registros'); location.href = 'productos.php'; </script>";
						}
						$ambito_busqueda="Todo";
					}
					//---------------------------------------------- BUSCAR ICC ----------------------------------------------
					if($btn=="Buscar ICC")
					{
						$bus=$_POST["txtbic"];
						if ($bus<>"")
						{
							$busca_asterisco=substr($bus,0,1);
							if ($busca_asterisco=="*")
							{
								$longcad=strlen($bus);
								$cadena_busqueda=substr($bus,1,$longcad-1);
								$longit_busqueda=$longcad-1;
								$cadena_consulta="SELECT * FROM productos WHERE right(icc_pro,'$longit_busqueda')='$cadena_busqueda'";
								$sql = mysqli_query ($Conexion,$cadena_consulta) or die ("Error al traer los datos");
							}
							else
							{
								$cadena_consulta="SELECT * FROM productos WHERE icc_pro='$bus'";
								$sql = mysqli_query ($Conexion,$cadena_consulta) or die ("Error al traer los datos");
							}
						}
						else
						{
							echo "<script> alert('Falta el ICC para la búsqueda de registros'); location.href = 'productos.php'; </script>";
						}
						$ambito_busqueda="Todo";
					}
					//---------------------------------------------- BUSCAR SERIE ----------------------------------------------
					if($btn=="Buscar Serie")
					{
						$bus=$_POST["txtbse"];
						if ($bus<>"")
						{
							$busca_asterisco=substr($bus,0,1);
							if ($busca_asterisco=="*")
							{
								$longcad=strlen($bus);
								$cadena_busqueda=substr($bus,1,$longcad-1);
								$longit_busqueda=$longcad-1;
								$cadena_consulta="SELECT * FROM productos WHERE right(serie_pro,'$longit_busqueda')='$cadena_busqueda'";
								$sql = mysqli_query ($Conexion,$cadena_consulta) or die ("Error al traer los datos");
							}
							else
							{
								$cadena_consulta="SELECT * FROM productos WHERE serie_pro='$bus'";
								$sql = mysqli_query ($Conexion,$cadena_consulta) or die ("Error al traer los datos");
							}
						}
						else
						{
							echo "<script> alert('Falta la Serie para la búsqueda de registros'); location.href = 'productos.php'; </script>";
						}
						$ambito_busqueda="Todo";
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
							$sql_where="SELECT * FROM productos WHERE ".$sql_where;
							$sql= mysqli_query ($Conexion,$sql_where) or die ("Error al filtrar Zona/Grupo/Tipo");
						}
						$ambito_busqueda="Todo";
					}
					
					//---------------------------------------------- AGREGAR ----------------------------------------------
					if($btn=="Agregar Individual")
					{
						$idp=$_POST["txtid"];
						$cdp=""; //$_POST["txtcdp"];//Codigo de producto
						$idc=$_POST["txtidc"];//Id de catalogo
						$ser=$_POST["txtser"];
						$ime=$_POST["txtime"];
						$icc=$_POST["txticc"];
						$ncl=$_POST["txtncl"];
						$prp=$_POST["txtprp"];//Precio de producto
						$fpr=invFech($_POST["txtfpr"],"-");
						$acp=$_POST["cmbacp"];
						//Modificado por JUAN 18-10-2018 --------------------------------------------
						$abp=valfield($Conexion,"catalogo","marca_cat","id_cat",$idc)." ".valfield($Conexion,"catalogo","modelo_cat","id_cat",$idc); //abreviatura con marca_cat+modelo_cat
						$marca_cat=valfield($Conexion,"catalogo","marca_cat","id_cat",$idc);
						$modelo_cat=valfield($Conexion,"catalogo","modelo_cat","id_cat",$idc);
						//---------------------------------------------------------------------------
						$tct=valfield($Conexion,"catalogo","tipo_cat","id_cat",$idc); //valor de tipo recarga del catalogo
						$znp=$_POST["cmbzna"];
						$gpc=valfield($Conexion,"catalogo","tipo_cat","id_cat",$idc);
						$tpc=valfield($Conexion,"catalogo","clase_cat","id_cat",$idc);
						$urg=$_POST["txturg"];
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
						if (!empty($fpr) AND !is_null($acp) AND !empty($znp) AND !empty($idc) AND (!empty($ime) OR !empty($icc) OR !empty($ser)))
						{
							//Agregar datos a productos
							$cadena_sql="INSERT INTO productos (cod_pro, id_cat, serie_pro, imei_pro, icc_pro, numcel_pro, precio_pro, fechreg_pro, activ_pro, id_usr, abrv_pro, zona_pro, tipo_cat, clase_cat, marca_cat, modelo_cat) VALUES ('".$cdp."','".$idc."','".$ser."','".$ime."','".$icc."','".$ncl."','".$prp."','".$fpr."',".$acp.",'".$ident_usuario."','".$abp."','".$znp."','".$gpc."','".$tpc."','".$marca_cat."','".$modelo_cat."')";
							mysqli_query ($Conexion,$cadena_sql) or die("Error al agregar datos a productos");
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
							$idp=$cdp=$idc=$ser=$ime=$icc=$ncl=$prp=$fpr=$acp=$znp=$gpc=$tpc=$urg="";
						}
						else
						{
							echo "<script> alert('No hay datos para agregar registros'); location.href = 'productos.php'; </script>";
						}
					}
					//---------------------------------------------- MODIFICAR ----------------------------------------------
					if ($btn=="Modificar")
					{
						$idp=$_POST["txtid"];//id_producto
						$cdp=""; //$_POST["txtcdp"];//codigo
						$idc=$_POST["txtidc"];//catalogo
						$ser=$_POST["txtser"];
						$ime=$_POST["txtime"];
						$icc=$_POST["txticc"];
						$ncl=$_POST["txtncl"];
						$prp=$_POST["txtprp"];//precio
						$fpr=invFech($_POST["txtfpr"],"-");
						$acp=$_POST["cmbacp"];//prod_activo
						//Modificado por JUAN 18-10-2018 --------------------------------------------
						$abp=valfield($Conexion,"catalogo","marca_cat","id_cat",$idc)." ".valfield($Conexion,"catalogo","modelo_cat","id_cat",$idc); //abreviatura con marca_cat+modelo_cat
						$marca_cat=valfield($Conexion,"catalogo","marca_cat","id_cat",$idc);
						$modelo_cat=valfield($Conexion,"catalogo","modelo_cat","id_cat",$idc);
						//---------------------------------------------------------------------------
						$znp=$_POST["cmbzna"];
						$gpc=valfield($Conexion,"catalogo","tipo_cat","id_cat",$idc);//tipo_catalogo
						$tpc=valfield($Conexion,"catalogo","clase_cat","id_cat",$idc);
						$urg=$_POST["txturg"];
						//Consulta registro actual
						$cadena_sql = "SELECT id_pro, tipo_cat, activ_pro FROM productos WHERE (id_pro='$idp')";
						$sql_prod_actual = mysqli_query($Conexion, $cadena_sql) or die ("Error al borrar el registro");
						$d = mysqli_fetch_array($sql_prod_actual,MYSQLI_ASSOC);
						$id_prod = $d["id_pro"]; $tipo_catl = $d["tipo_cat"]; $activ_prod = $d["activ_pro"];
						//Inicia actualización
						if (!empty($fpr) AND !is_null($acp) AND !empty($znp) AND !empty($idc) AND (!empty($ime) OR !empty($icc) OR !empty($ser)))
						{
							//----------------------------------- Servicios -----------------------------------
							if ($gpc=="Servicios")
							{
								if ($acp==1)
								{
									$cadena_sql = "UPDATE productos SET cod_pro='$cdp', id_cat='$idc', serie_pro='$ser', imei_pro='$ime', icc_pro='$icc', numcel_pro='$ncl', precio_pro='$prp', fechreg_pro='$fpr', activ_pro=$acp, id_usr='$ident_usuario', abrv_pro='$abp', tipo_cat='$gpc', clase_cat='$tpc', ultreg_pro='$urg', marca_cat='$marca_cat', modelo_cat='$modelo_cat' WHERE id_pro=$idp";
									mysqli_query($Conexion, $cadena_sql) or die("Error al modificar datos de productos");
									echo "<script> alert('Se modificó correctamente los datos'); location.href = 'productos.php'; </script>";
								}
								else
								{
									echo "<script> alert('No se puede actualizar a inactivo un servicio...'); location.href = 'productos.php'; </script>";
								}
							}
							//----------------------------------- Diferente a Servicios y Recargas -----------------------------------
							if ($gpc<>"Servicios" AND $gpc<>"Recarga")
							{
								$cadena_sql = "UPDATE productos SET cod_pro='$cdp', id_cat='$idc', serie_pro='$ser', imei_pro='$ime', icc_pro='$icc', numcel_pro='$ncl', precio_pro='$prp', fechreg_pro='$fpr', activ_pro=$acp, id_usr='$ident_usuario', abrv_pro='$abp', zona_pro='$znp', tipo_cat='$gpc', clase_cat='$tpc', ultreg_pro='$urg', marca_cat='$marca_cat', modelo_cat='$modelo_cat' WHERE id_pro=$idp";
								mysqli_query($Conexion, $cadena_sql) or die("Error al modificar datos de productos");
								$cadena_sql = "UPDATE kardex SET activ_kar=$acp, zona_pro='$znp' WHERE id_pro=$idp";
								mysqli_query($Conexion, $cadena_sql) or die("Error al modificar datos de productos");
								echo "<script> alert('Se modificó correctamente los datos del producto.'); location.href = 'productos.php'; </script>";
							}
							//----------------------------------- Recargas -----------------------------------
							if ($gpc=="Recarga")
							{
								if ($activ_prod==0 AND $acp==0)
								{
									$cadena_sql = "UPDATE productos SET cod_pro='$cdp', id_cat='$idc', serie_pro='$ser', imei_pro='$ime', icc_pro='$icc', numcel_pro='$ncl', precio_pro='$prp', fechreg_pro='$fpr', activ_pro=$acp, id_usr='$ident_usuario', abrv_pro='$abp', tipo_cat='$gpc', clase_cat='$tpc', ultreg_pro='$urg' WHERE id_pro=$idp";
									mysqli_query($Conexion, $cadena_sql) or die("Error al modificar datos de productos");
									$cadena_sql = "UPDATE kardex SET activ_kar=$acp WHERE id_pro=$idp";
									mysqli_query($Conexion, $cadena_sql) or die("Error al modificar datos de productos");
									echo "<script> alert('Se modificó correctamente los datos'); location.href = 'productos.php'; </script>";
								}
								if ($activ_prod==1 AND $acp==0)
								{
									echo "<script> alert('No se puede actualizar a inactivo una recarga activa...'); location.href = 'productos.php'; </script>";
								}
								if ($activ_prod==1 AND $acp==1)
								{
									$cadena_sql = "UPDATE productos SET cod_pro='$cdp', id_cat='$idc', serie_pro='$ser', imei_pro='$ime', icc_pro='$icc', numcel_pro='$ncl', precio_pro='$prp', fechreg_pro='$fpr', activ_pro=$acp, id_usr='$ident_usuario', abrv_pro='$abp', tipo_cat='$gpc', clase_cat='$tpc', ultreg_pro='$urg' WHERE id_pro=$idp";
									mysqli_query($Conexion, $cadena_sql) or die("Error al modificar datos de productos");
									$cadena_sql = "UPDATE kardex SET activ_kar=$acp WHERE id_pro=$idp AND activ_kar=1";
									mysqli_query($Conexion, $cadena_sql) or die("Error al modificar datos de productos");
									echo "<script> alert('Se modificó correctamente los datos'); location.href = 'productos.php'; </script>";
								}
								if ($activ_prod==0 AND $acp==1)
								{
									echo "<script> alert('No se puede actualizar a activo una recarga inactiva...'); location.href = 'productos.php'; </script>";
								}
							}
							$idp=$cdp=$idc=$ser=$ime=$icc=$ncl=$prp=$fpr=$acp=$znp=$gpc=$tpc=$urg=$id_prod=$tipo_catl=$activ_prod="";
						}
						else
						{
							echo "<script> alert('No hay datos para modificar'); location.href = 'productos.php'; </script>";
						}
					}
					//---------------------------------------------- ELIMINAR ----------------------------------------------
					if($btn=="Eliminar")
					{
						$nrg=$_POST["txtnumreg"];$id=$_POST["txtid"];
						if ($nrg<>"" && $id<>"")
						{
							$cadena_sql = "DELETE FROM productos WHERE id_pro=$id";
							mysqli_query($Conexion, $cadena_sql) or die ("Error al borrar el registro");
							echo "<script> alert('Borrado de registro efectuado, actualizando datos...'); location.href = 'productos.php'; </script>";
							$sql = mysqli_query ($Conexion,"SELECT * from productos") or die ("Error al traer los datos");
							$tabla=array(array()); obtener_matriz($sql,$tabla,$filas);
						}
						else
						{
							echo "<script> alert('No hay datos de registro para borrar'); location.href = 'productos.php'; </script>";
						}
					}
					//---------------------------------------------- ACTUALIZAR ----------------------------------------------
					if($btn=="Actualizar")
					{
						echo "<script> location.href = 'productos.php'; </script>";
					}
					//---------------------------------------------- ACTUALIZAR KARDEX ----------------------------------------------
					//Activa y desactiva los registros de Kardex con 0 o 1 en función de los registros activos de Productos
					if($btn=="Actualizar Kardex")
					{
						/*//Selecciona productos
						$sql_productos = mysqli_query($Conexion,"SELECT id_pro FROM productos WHERE activ_pro=1") or die ("Error al borrar el registro");
						//Seleccionar kardex
						$sql_kardex = mysqli_query($Conexion,"SELECT id_kar, id_pro FROM kardex") or die ("Error al borrar el registro");
						while($resul_productos = mysqli_fetch_array($sql_productos,MYSQLI_ASSOC))
						{
							$idpp=$resul_productos["id_pro"];
							mysqli_data_seek($sql_kardex, 0); 
							while($resul_kardex = mysqli_fetch_array($sql_kardex,MYSQLI_ASSOC))
							{
								$idpk=$resul_kardex["id_pro"];
								if ($idpp==$idpk)
								{
									$sql_actualizar_kardex = "UPDATE kardex SET activ_kar='1' WHERE id_pro=$idpk";
									mysqli_query ($Conexion,$sql_actualizar_kardex) or die("Error al agregar datos");
								}
							}
						}*/
					}
					//---------------------------------------------- REVISAR KARDEX ----------------------------------------------
					if($btn=="Revisar Kardex")
					{
						/*$sql_producto = mysqli_query($Conexion,"SELECT * FROM productos") or die ("Error al borrar el registro");
						$filas=mysqli_num_rows($sql_producto);
						echo "Producto (registros existentes):",$filas,"<br>";*/
						/* Busca registros en Kardex iguales a Ingreso y que sean No vacio o No Nulos
						$sql_kardex = mysqli_query($Conexion,"SELECT * FROM kardex WHERE tiporeg_kar='I' AND (zona_pro IS NOT NULL OR zona_pro<>'')") or die ("Error al borrar el registro");*/
						/* Busca registros en Kardex iguales a Ingreso y que sean vacios o Nulos
						$sql_kardex = mysqli_query($Conexion,"SELECT * FROM kardex WHERE tiporeg_kar='I' AND (zona_pro IS NULL OR zona_pro='')") or die ("Error al borrar el registro");*/
						/* Busca registros en Kardex iguales a Ingreso y que sean vacios o Nulos*/
						/*$sql_kardex = mysqli_query($Conexion,"SELECT * FROM kardex WHERE tiporeg_kar='E'") or die ("Error al borrar el registro");
						$filas=mysqli_num_rows($sql_kardex);*/
						//echo "Kardex (registros de tipo I y zona No vacia o No Nulo):",$filas,"<br>";
						//echo "Kardex (registros de tipo I y zona vacia o Nulo):",$filas,"<br>";
						//echo "Kardex (registros de tipo I):",$filas,"<br>";
						/*echo "Kardex (registros de tipo E):",$filas,"<br>";*/
						/* Busca registros en Productos que sean iguales en codigo y cantidad con Kardex
						// Recorrido de productos
						mysqli_data_seek($sql_producto, 0);
						while($resul_productos = mysqli_fetch_array($sql_producto,MYSQLI_ASSOC))
						{
							$idpr=$resul_productos["id_pro"];
							echo "[PRODUCTOS] Id de producto:",$idpr;
							//Recorrido de kardex
							mysqli_data_seek($sql_kardex, 0);
							while($resul_kardex = mysqli_fetch_array($sql_kardex,MYSQLI_ASSOC))
							{
								$idpk=$resul_kardex["id_pro"];
								$idkr=$resul_kardex["id_kar"];
								if ($idpr==$idpk)
								{
									echo " [KARDEX] Id de kardex:",$idkr;
								}
							}
							echo "<br>";
						}*/
						/* Busca registros en Kardex que sean iguales en codigo y cantidad con Productos
						// Recorrido de kardex
						mysqli_data_seek($sql_kardex, 0);
						while($resul_kardex = mysqli_fetch_array($sql_kardex,MYSQLI_ASSOC))
						{
							$idpk=$resul_kardex["id_pro"];
							$idkr=$resul_kardex["id_kar"];
							$zpro=$resul_kardex["zona_pro"];
							echo "[KARDEX] Id de kardex:",$idkr," | Id de producto:",$idpk;
							//Recorrido de productos
							mysqli_data_seek($sql_producto, 0);
							while($resul_productos = mysqli_fetch_array($sql_producto,MYSQLI_ASSOC))
							{
								$idpr=$resul_productos["id_pro"];
								if ($idpr==$idpk)
								{
									echo " [PRODUCTOS] Id de producto:",$idpr;
								}
							}
							echo "<br>";
						}*/
						/* Busca registros en Productos que sean iguales en codigo y cantidad con Kardex
						// Recorrido de productos
						mysqli_data_seek($sql_producto, 0);
						while($resul_productos = mysqli_fetch_array($sql_producto,MYSQLI_ASSOC))
						{
							$idpr=$resul_productos["id_pro"];
							echo "[PRODUCTOS] Id de producto:",$idpr;
							//Recorrido de kardex
							mysqli_data_seek($sql_kardex, 0);
							while($resul_kardex = mysqli_fetch_array($sql_kardex,MYSQLI_ASSOC))
							{
								$idpk=$resul_kardex["id_pro"];
								$idkr=$resul_kardex["id_kar"];
								$zpro=$resul_kardex["zona_pro"];
								if ($idpr==$idpk)
								{
									echo " [KARDEX] Id de kardex:",$idkr;
									if (empty($zpro) OR $zpro=='') echo " [V] Id producto:",$idpk;
									if (!empty($zpro) OR $zpro<>'') echo " [NV] Id producto:",$idpk;
								}
							}
							echo "<br>";
						}*/
						/* Busca registros en Productos que sean iguales en codigo y cantidad con Kardex
						// Recorrido de productos
						$clv=0;
						mysqli_data_seek($sql_producto, 0);
						while($resul_productos = mysqli_fetch_array($sql_producto,MYSQLI_ASSOC))
						{
							$idpr=$resul_productos["id_pro"];
							//Recorrido de kardex
							mysqli_data_seek($sql_kardex, 0);
							while($resul_kardex = mysqli_fetch_array($sql_kardex,MYSQLI_ASSOC))
							{
								$idpk=$resul_kardex["id_pro"];
								$idkr=$resul_kardex["id_kar"];
								$zpro=$resul_kardex["zona_pro"];
								if ($idpr==$idpk)
								{
									echo "[PRODUCTOS] Id de producto:",$idpr," [KARDEX] Id de kardex:",$idkr," Id producto:",$idpk;
									$clv=1;
								}
							}
							if ($clv==1) { echo "<br>"; $clv=0; }
						}*/
					}
					//---------------------------------------------- REVISAR ENLACES DESDE PRODUCTO A KARDEX, REGVENTAS Y REGCAJA ----------------------------------------------
					if($btn=="Revisar Enlaces")
					{
						$idpro=$_POST["txtbus"];
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
				$vzona=$vgrupo=$vtipo=$vactv=0;
				$vz=$vg=$vt=$va="";
				if (isset($_POST["cmbbzn"])) $vz=$_POST["cmbbzn"];
				if (isset($_POST["cmbtpc"])) $vg=$_POST["cmbtpc"];
				if (isset($_POST["cmbclc"])) $vt=$_POST["cmbclc"];
				if (isset($_POST["cmbbac"])) $va=$_POST["cmbbac"];
				//id_pro, cod_pro, id_cat, serie_pro, imei_pro, icc_pro, numcel_pro, precio_pro, fechreg_pro, activ_pro, id_usr, abrv_pro, , tipo_cat, clase_cat
				mysqli_data_seek($sql, 0); 
				while($resul = mysqli_fetch_array($sql,MYSQLI_ASSOC))
				{
					if($resul["zona_pro"]==$vz) $vzona++;
					if($resul["tipo_cat"]==$vg) $vgrupo++;
					if($resul["clase_cat"]==$vt) $vtipo++;
					if($resul["activ_pro"]==$va) $vactv++;
				}
				?>
				<!------------------------------------------------ FORMULARIO ---------------------------------------------->
				<form name="usuario" action="" method="post">
					<?php
					lblnorm("ID:","etq5"); txtnrmstl("txtbus","width:80px;");
					lblnorm("IMEI:","etq12"); txtnrmstl("txtbim","width:100px;");
					lblnorm("ICC:","etq12");txtnrmstl("txtbic","width:100px;");
					lblnorm("Serie:","etq12");txtnrmstl("txtbse","width:100px;");?>
					<span id="etq12"style="width:80px;">Zona(<?php echo $vzona;?>):</span>
					<?php 
					//cmbnormal("cmbbzn", $vbzn, "JUNCD05", "JUNDL39", "JUNDL43", "PRE_DL39", "PRE_DL43", "JUNCD12", "Almacen1", "Almacen2", "Almacen3", "Almacen4", "Almacen5", "JUNDA29"); 
					cmbfieldJs_span("spn_zona","cmbbzn",$Conexion,"SELECT nomb_zna FROM zona WHERE activo_zna='S'",$vbzn,"","nomb_zna"); 
					?>
					<span id="etq4"style="width:80px;">Grupo(<?php echo $vgrupo;?>):</span><?php 
					//cmbnormal("cmbtpc", $vbgr, "Equipo", "Modem", "Chip", "Recarga", "Tableta", "Servicios", "Accesorios", "Otros");
					cmbfieldJs("div_select_grupo","cmbtpc",$Conexion,"SELECT desc_tipo_prosrv FROM tipo_prod_serv WHERE activo_tipo_prosrv='S'",$vbgr,"","desc_tipo_prosrv");
					?>
					<span id="etq4"style="width:80px;">Tipo(<?php echo $vtipo;?>):</span><?php 
					//cmbnormal("cmbclc", $vbtp, "Handset", "Smartphone", "Modem", "PackConnect", "SIM Mobile", "BSmart", "BFree", "BCombo", "Uni","Kit BVoz","Kit BData","Kit BitelUNIV", "Kit Bfono", "Router", "Rec.Tarjeta", "Rec.Virtual", "Tablet", "SD Card", "Auricular", "CarcasaSmpl", "CarcasaTapa", "ProtectPant", "Migracion", "CambioPlan", "BajaLinea", "Desbloqueo", "Reconfigur.", "Otros"); 
					cmbfieldJs("div_select_tipo","cmbclc",$Conexion,"SELECT desc_clase_prosrv FROM clase_prod_serv WHERE activo_clase_prosrv='S'",$vbtp,"","desc_clase_prosrv");?>
					<span id="etq2"style="width:120px;">Activo(S/N)(<?php echo $vactv;?>):</span><?php cmbnormal("cmbbac", $vbac, "1", "0");?>
					<?php
					echo "<br><hr>";
					if (activar_boton($datos,$resultado_perfil_accesos,"Buscar ID")) { btnnormal("btnGrl", "Buscar ID"); }
					if (activar_boton($datos,$resultado_perfil_accesos,"Buscar IMEI")) { btnnormal("btnGrl", "Buscar IMEI"); }
					if (activar_boton($datos,$resultado_perfil_accesos,"Buscar ICC")) { btnnormal("btnGrl", "Buscar ICC"); }
					if (activar_boton($datos,$resultado_perfil_accesos,"Buscar Serie")) { btnnormal("btnGrl", "Buscar Serie"); }
					if (activar_boton($datos,$resultado_perfil_accesos,"Buscar Zona/Grupo/Tipo")) { btnnormal("btnGrl", "Buscar Zona/Grupo/Tipo"); } ?>
					<br><hr>
					<?php txtoculto("txtnumreg",$numreg);?>
					<div id="colizq" style=" float:left; width:28%;">
					
						<span id="etq2">ID:</span><?php txtrdonly("txtid",$var0);?><br>
						<span id="etq2">Imei:</span><?php txtvalue("txtime",$var4,25);?><br>
						<span id="etq2">Icc:</span><?php txtvalue("txticc",$var5,25);?><br>
						<span id="etq2">Numero de celular:</span><?php txtvalue("txtncl",$var6,12);?><br>
					</div>
					<div id="colder" style=" float:left; width:28%;">	
					<span id="etq2">Fecha:</span><?php txtrdonly("txtfpr",$var8);?><br>
						<span id="etq2">Activo(S/N):</span><?php cmbnormal("cmbacp", $var9, "1", "0");?><br>
						<span id="etq2">Zona:</span>
						<?php 
						//cmbnormal("cmbzna", $var12, "JUNCD05", "JUNDL39", "JUNDL43", "PRE_DL39", "PRE_DL43", "JUNCD12", "Almacen1", "Almacen2", "Almacen3", "Almacen4", "Almacen5", "JUNDA29");
						cmbfieldJs_span("spn_zona","cmbzna",$Conexion,"SELECT nomb_zna FROM zona WHERE activo_zna='S'",$var12,"","nomb_zna"); 
						?><br>
						<span id="etq2">Precio S/.:</span><?php txtvalue("txtprp",$var7,10);?><br>
					</div>
					<div id="colders"  style=" float:left; width:44%;">		
						<span id="etq5"style="width:140px;">Ult.regis.(prec./cant.):</span><?php txtvalstl("txturg", $var15, 10, "width:100px;");?><br>
						<!--<span id="etq2"style="width:233px;">Codigo de Producto:</span><?php //txtvalue("txtcdp", $var1, 6);?><br>-->
						<span id="etq2" style="width:140px;">Serie:</span><?php txtvalue("txtser",$var3,25);?><br>
						<span id="etq2"style="width:70px;">Catálogo:</span><?php combo_select("div_catalogo","txtidc",$Conexion,"SELECT * FROM catalogo WHERE activo_cat='S'",$var2,"id_cat","tipo_cat","abrv_cat");
						boton_busqueda("div_catalogo", "productos.busca_catalogo.php");?>	<br>
					</div>
					<div style="clear:both"></div>
					<hr>
					<div>
						<?php
						if (activar_boton($datos,$resultado_perfil_accesos,"Agregar Individual")) { if (($categ_usuario=="Prog") OR ($categ_usuario=="Gern") OR ($categ_usuario=="Supr" AND $nivel_usuario=="sup")	OR ($categ_usuario=="Almc" AND $nivel_usuario=="sup")) btnnormal("btnGrl", "Agregar Individual"); }
						if (activar_boton($datos,$resultado_perfil_accesos,"Agregar Bloque ICC")) { if (($categ_usuario=="Prog") OR ($categ_usuario=="Gern") OR ($categ_usuario=="Supr" AND $nivel_usuario=="sup")	OR ($categ_usuario=="Almc" AND $nivel_usuario=="sup")) btnnormal("btnGrl", "Agregar Bloque ICC"); }
						if (activar_boton($datos,$resultado_perfil_accesos,"Modificar")) { if (($categ_usuario=="Prog") OR ($categ_usuario=="Gern")) btnnormal("btnGrl", "Modificar"); }
						if (activar_boton($datos,$resultado_perfil_accesos,"Eliminar")) { if (($categ_usuario=="Prog") OR ($categ_usuario=="Gern")) btnnormal("btnGrl", "Eliminar"); }
						if (activar_boton($datos,$resultado_perfil_accesos,"Actualizar")) { btnnormal("btnGrl", "Actualizar"); }
						?>
					</div>
					<hr>
				</form>
				<!---------------------------------------------- LSITADO DE DATOS EN TABLAS ---------------------------------------------->
				<?php
				tblanchovariable($Conexion,"margin-left:0px;","height:200px;",$sql,"tblnormal",$ambito_busqueda,"ID:id_pro:50:N","Cód.Prod.:cod_pro:70:N","Grupo:tipo_cat:80:N","Tipo:clase_cat:85:N","Catálogo de productos:id_cat:260:valfield|catalogo|abrv_cat|id_cat","Serie:serie_pro:115:N","Imei:imei_pro:115:N","Icc:icc_pro:150:N","Núm.Cel.:numcel_pro:100:N","Precio S/.:precio_pro:110:N","Fecha:fechreg_pro:80:invFech|","A.:activ_pro:30:N","Zona:zona_pro:70:N","Ult.Reg.Prec./Cant.:ultreg_pro:110:N");
				?>
			</div><!--Fin de main-col-->
			<?php scroll_doble("div1", "div2"); ?>
			<article id="tex">
	<?php pie_pagina();?>
	<br><br>
	</article>
	</body>
</html>
