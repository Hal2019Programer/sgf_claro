<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
/* Variables de busqueda: id_kar, tipodoc_kar, numdoc_kar, id_pro, feching_kar, fechsal_kar, cantanterior_kar, cantregistrada_kar, cantactual_kar, costoproding_kar, id_rvi, id_cmp, id_usr, tiporeg_kar, zona_pro, activ_kar */
$var0=$var1=$var2=$var3=$var4=$var5=$var6=$var7=$var8=$var9=$var10=$var11=$var12=$var13=$var14=$var15=$numreg="";
$vzona=$vprod=$vrvta=$vrcmp='';
$ambito_busqueda="Normal";
//Datos iniciales para control de accesos de perfil
$resultado_perfil_accesos = Null; $datos = array();
cargar_datos_perfil($Conexion,$ident_usuario,"Kardex",$resultado_perfil_accesos,$datos,$categ_usuario,$nivel_usuario,$zona_usuario);
verificar_procesos_de_boton($resultado_perfil_accesos);
?>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Kardex");?></head>
	<body>
		<div>
			<?php //cabecera02("Kardex"); menu02();?>
			<div style="width:1310px;">
				<?php cabecera04(0,"Movimientos de almacén"); menu02(); sl(1);?>
				<!--<center><h1>Movimientos de almacén</h1></center><hr>-->
				<?php
				$sql= mysqli_query ($Conexion,"SELECT * from kardex") or die ("Error al traer los datos");
				$tabla=array(array()); obtener_matriz($sql,$tabla,$filas);
				if (empty($var4)) $var4=date("Y-m-d");
				if (empty($var5)) $var5="0000-00-00";
				//---------------------------------------------------- BOTONES ----------------------------------------------------
				if(isset($_POST["btnGrl"]))
				{
					$btn=$_POST["btnGrl"];$bus=$_POST["txtbus"];
					//---------------------------------------------------- BUSCAR ----------------------------------------------------
					if($btn=="Buscar")
					{
						if ($bus<>"")
						{
							$numreg=busca_id($tabla,$filas,$bus);
							if($numreg>=0)
							{	
								mysqli_data_seek($sql, $numreg); 
								$resul=mysqli_fetch_array($sql);
								$var0=$resul[0];//id_kar
								$var1=$resul[1];//tipodoc_kar
								$var2=$resul[2];//numdoc_kar
								$var3=$resul[3];//id_pro
								$var4=$resul[4];//feching_kar
								if (empty($var4)) $var4=date("Y-m-d");
								$var5=$resul[5];//fechsal_kar
								if (empty($var5)) $var5=date("Y-m-d");
								$var6=$resul[6];//cantanterior_kar
								$var7=$resul[7];//cantregistrada_kar
								$var8=$resul[8];//cantactual_kar
								$var9=$resul[9];//costoproding_kar
								$var10=$resul[10];//id_rvi
								$var11=$resul[11];//id_cmp
								$var12=$resul[12];//id_usr
								$var13=$resul[13];//tiporeg_kar
								$var14=$resul[14];//zona_pro
								$var15=$resul[15];//activ_kar
							}
							else
							{
								echo "<script> alert('No se encuentra el registro'); </script>";
							}
						}
						else
						{
							echo "<script> alert('Falta el id para la búsqueda de registros'); location.href = 'kardex.php'; </script>";
						}
					}
					//---------------------------------------------------- AGREGAR ----------------------------------------------------
					if($btn=="Agregar")
					{
						$idk=$_POST["txtid"];//id_kar
						$tdc=$_POST["cmbtdc"];//tipodoc_kar
						$ndc=$_POST["txtndc"];//numdoc_kar
						$idp=$_POST["cmbidp"];//id_pro
						$fik=$_POST["txtfik"];//feching_kar
						if (empty($fik)) $fik="0000-00-00";
						$fsk=$_POST["txtfsk"];//fechsal_kar
						if (empty($fsk)) $fsk="0000-00-00";
						$can=$_POST["txtcan"];//cantanterior_kar
						$cre=$_POST["txtcre"];//cantregistrada_kar
						$cac=$_POST["txtcac"];//cantactual_kar
						$cpi=$_POST["txtcpi"];//costoproding_kar
						$irv=$_POST["txtirv"];//id_rvi
						if (empty($irv)) $irv="0";
						$irc=$_POST["txtirc"];//id_cmp
						if (empty($irc)) $irc="0";
						$trg=$_POST["cmbtrg"];//tiporeg_kar
						if ($trg="I") $cac=$can+$cre; else $cac=$can-$cre;
						if ($tdc>"" && $ndc<>"" && $idp<>"")
						{
							$cadena_sql="INSERT INTO kardex (tipodoc_kar, numdoc_kar, id_pro, feching_kar, fechsal_kar, cantanterior_kar, cantregistrada_kar, cantactual_kar, costoproding_kar, id_rvi, id_cmp, id_usr, tiporeg_kar) VALUES ('".$tdc."','".$ndc."','".$idp."','".$fik."','".$fsk."','".$can."','".$cre."','".$cac."','".$cpi."','".$irv."','".$irc."','".$ident_usuario."','".$trg."')";
							mysqli_query ($Conexion,$cadena_sql) or die("Error al agregar datos");
							echo "<script> alert('Se insertó correctamente'); location.href = 'kardex.php'; </script>";
							$idk=$tdc=$ndc=$idp=$fik=$fsk=$can=$cre=$cac=$cpi=$irv=$irc=$trg="";
						}
						else
						{
							echo "<script> alert('No hay datos para agregar registros'); location.href = 'kardex.php'; </script>";
						}
					}
					//---------------------------------------------------- MODIFICAR ----------------------------------------------------
					if ($btn=="Modificar")
					{
						$idk=$_POST["txtid"];//id_kar
						$tdc=$_POST["cmbtdc"];//tipodoc_kar
						$ndc=$_POST["txtndc"];//numdoc_kar
						$idp=$_POST["cmbidp"];//id_pro
						$fik=$_POST["txtfik"];//feching_kar
						$fsk=$_POST["txtfsk"];//fechsal_kar
						$can=$_POST["txtcan"];//cantanterior_kar
						$cre=$_POST["txtcre"];//cantregistrada_kar
						$cac=$_POST["txtcac"];//cantactual_kar
						$cpi=$_POST["txtcpi"];//costoproding_kar
						$irv=$_POST["txtirv"];//id_rvi
						$irc=$_POST["txtirc"];//id_cmp
						$trg=$_POST["cmbtrg"];//tiporeg_kar
						$act=$_POST["txtact"];//activ_kar
						if ($tdc>"" && $ndc<>"" && $idp<>"")
						{
							$cadena_sql = "UPDATE kardex SET tipodoc_kar='$tdc', numdoc_kar='$ndc', id_pro='$idp', feching_kar='$fik', fechsal_kar='$fsk', cantanterior_kar='$can', cantregistrada_kar='$cre', cantactual_kar=$cac, costoproding_kar='$cpi', id_rvi='$irv', id_cmp='$irc', id_usr='$ident_usuario', tiporeg_kar='$trg', activ_kar=$act WHERE id_kar=$idk";
							mysqli_query($Conexion, $cadena_sql) or die("Error al modificar datos");
							echo "<script> alert('Se modificó correctamente los datos'); location.href = 'kardex.php'; </script>";
							$idk=$tdc=$ndc=$idp=$fik=$fsk=$can=$cre=$cac=$cpi=$irv=$irc=$trg="";
						}
						else
						{
							echo "<script> alert('No hay datos para modificar'); location.href = 'kardex.php'; </script>";
						}
					}
					//---------------------------------------------------- ELIMINAR ----------------------------------------------------
					if($btn=="Eliminar")
					{
						$nrg=$_POST["txtnumreg"];$id=$_POST["txtid"];
						if ($nrg<>"" && $id<>"")
						{
							$cadena_sql = "DELETE FROM kardex WHERE id_kar=$id";
							mysqli_query($Conexion, $cadena_sql) or die ("Error al borrar el registro");
							echo "<script> alert('Borrado de registro efectuado, actualizando datos...'); location.href = 'kardex.php'; </script>";
							$sql = mysqli_query ($Conexion,"SELECT * from kardex") or die ("Error al traer los datos");
							$tabla=array(array()); obtener_matriz($sql,$tabla,$filas);
						}
						else
						{
							echo "<script> alert('No hay datos de registro para borrar'); location.href = 'kardex.php'; </script>";
						}
					}
					//---------------------------------------------------- ACTUALIZAR ----------------------------------------------------
					if($btn=="Actualizar")
					{
						echo "<script> location.href = 'kardex.php'; </script>";
					}
					//---------------------------------------------------- FILTRAR ZONA/PRODUCTO/REGISTRO DE VENTA Y COMPRA ----------------------------------------------------
					if($btn=="Filtrar")
					{	
						$zna=$_POST["cmbzona"];$vzona=$zna;//zona
						$prd=$_POST["txtprod"];$vprod=$prd;//producto
						$vta=$_POST["txtrvta"];$vrvta=$vta;//registro de venta
						$cmp=$_POST["txtrcmp"];$vrcmp=$cmp;//registro de compra
						$sql_where="";
						if (!empty($zna)) $sql_where=$sql_where."(zona_pro='$zna') AND ";
						if (!empty($prd)) $sql_where=$sql_where."(id_pro='$prd') AND ";
						if (!empty($vta)) $sql_where=$sql_where."(id_rvi='$vta') AND ";
						if (!empty($cmp)) $sql_where=$sql_where."(id_cmp='$cmp') AND ";
						$sql_where=trim($sql_where);
						$sql_where=substr($sql_where, 0, strlen($sql_where)-4);						
						if (!empty($sql_where))
						{
							$sql_where="SELECT * FROM kardex WHERE ".$sql_where;
							$sql= mysqli_query ($Conexion,$sql_where) or die ("Error al filtrar Zona/Producto/Ventas/Compras");
						}
						$ambito_busqueda="Todo";
					}
				}
				?>
				<!---------------------------------------------------- FORMULARIO ---------------------------------------------------->
				<form name="usuario" action="" method="post">
					<span id="etq2">Buscar ID:</span><?php txtnormal("txtbus"); 
					if (activar_boton($datos,$resultado_perfil_accesos,"Buscar")) { btnnormal("btnGrl", "Buscar"); } ?><br><hr>
					<?php txtoculto("txtnumreg",$numreg);?>
					<div>
						<span id="etq2">ID:</span><?php txtronstl("txtid",$var0,"width:50px;");?>
						<span id="etq5" style="width:210px;">Tipo de registro:</span><?php cmbnormal("cmbtrg",$var13, "I", "E");?>
						<span id="etq5" style="width:250px;">Tipo de documento:</span><?php cmbnormal("cmbtdc",$var1, "Factura", "Boleta de venta", "Guía de Remis.", "Reporte de Inv.");?>
						<span id="etq5" style="width:165px;">Nº de documento:</span><?php txtvalstl("txtndc",$var2,15,"width:50px;");?>
						<span id="etq5" style="width:175px;">Cantidad actual:</span><?php txtvalstl("txtcac",$var8,4,"width:50px;");?><br>
						<span id="etq5" style="width:140px;">Fecha de ingreso:</span><?php txtvalstl("txtfik",$var4,10,"width:80px;");?>
						<span id="etq5" style="width:180px;">Fecha de salida:</span><?php txtvalstl("txtfsk",$var5,10,"width:80px;");?>
						<span id="etq2"style="width:200px;">Producto:</span><?php cmbfield("cmbidp",$Conexion,"SELECT * from productos",$var3,"id_pro","abrv_pro");?>
						<span id="etq1"style="width:120px;">Activo:</span><?php txtvalstl("txtact",$var15,1,"width:20px;");?><br>
						<span id="etq2">Cantidad anterior:</span><?php txtvalstl("txtcan",$var6,4,"width:50px;");?>
						<span id="etq5" style="width:210px;">Cantidad registrada:</span><?php txtvalstl("txtcre",$var7,4,"width:50px;");?>
						<span id="etq5" style="width:230px;">Costo producto inicial:</span><?php txtvalstl("txtcpi",$var9,12,"width:80px;");?>
						<span id="etq2"style="width:200px;">Registro de venta:</span><?php txtvalstl("txtirv",$var10,5,"width:50px;");?>
						<span id="etq2"style="width:175px;">Registro de compra:</span><?php txtvalstl("txtirc",$var11,5,"width:50px;");?>
						
					</div>
					<hr>
					<div>
						<span id="etq2">Zona:</span>
						<?php 
						//cmbnormal("cmbzona", $vzona, "JUNCD05", "JUNDL39", "JUNDL43", "PRE_DL39", "PRE_DL43", "JUNCD12", "Almacen1", "Almacen2", "Almacen3", "Almacen4", "Almacen5", "JUNDA29");
						cmbfieldJs_span("spn_zona","cmbzona",$Conexion,"SELECT nomb_zna FROM zona WHERE activo_zna='S'",$vzona,"","nomb_zna");
						?>
						<span id="etq5" style="width:90px;">Producto:</span><?php txtvalstl("txtprod",$vprod,5,"width:50px;");?>
						<span id="etq5" style="width:150px;">Registro de venta:</span><?php txtvalstl("txtrvta",$vrvta,5,"width:50px;");?>
						<span id="etq5" style="width:160px;">Registro de compra:</span><?php txtvalstl("txtrcmp",$vrcmp,5,"width:50px;");?>
						<?php if (activar_boton($datos,$resultado_perfil_accesos,"Filtrar")) { btnnormal("btnGrl", "Filtrar"); } ?>
					</div>
					<hr>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Agregar")) { btnnormal("btnGrl", "Agregar"); } ?>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Modificar")) { btnnormal("btnGrl", "Modificar"); } ?>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Eliminar")) { btnnormal("btnGrl", "Eliminar"); } ?>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Actualizar")) { btnnormal("btnGrl", "Actualizar"); } ?>
					<br><hr>
				</form>
				<!---------------------------------------------------- LISTADO DE DATOS DE USUARIO ---------------------------------------------------->	
				<?php
				tblanchovariable($Conexion,"margin-left:0px;","height:180px;",$sql,"tblnormal",$ambito_busqueda,"ID:id_kar:50:N","Tip.Rg.:tiporeg_kar:45:N","Tipo de documento:tipodoc_kar:130:N","Nº Doc.:numdoc_kar:60:N","Producto:id_pro:340:valfield|productos|abrv_pro|id_pro","Fecha Ing.:feching_kar:80:N","Fecha Sal.:fechsal_kar:80:N","Cant.Anter.:cantanterior_kar:90:N","Cant.Regis.:cantregistrada_kar:90:N","Cant.Actual:cantactual_kar:90:N","CostoProd.Ini.:costoproding_kar:110:N","Reg.Venta:id_rvi:90:N","Reg.Compra:id_cmp:93:N","Zona:zona_pro:85:N","Activo:activ_kar:60:N");
				scroll_doble("div1", "div2");
				?>
			</div><!--Fin de main-col-->
			<article class="piepag"><?php pie_pagina();?></article>
	</body>
</html>