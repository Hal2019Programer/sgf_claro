<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
// Variables de busqueda: id_cli, nom_rzs_cli, dni_ruc_cli, tlfcel_cli, direcc_cli, lugar_cli, prscont_cli, tlfcel_prscont_cli, fechreg_cli, id_usr, tipo_cli, zona_cli
$var0=$var1=$var2=$var3=$var4=$var5=$var6=$var7=$var8=$var9=$var10=$var11=$id_tipdoc=$cod_ubigeo="";
$email_cli="";
if (!isset($_POST["btnGrl"]))
{
	if (isset($_GET['id_cli']))
	{
		if (!empty($_GET['id_cli']))
		{
			$btn="Buscar";
			$bus=$_GET['id_cli'];
		}
	}
}
?>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Clientes");?></head>
	<body>
		<div>
			<div style="width:1200px;">
				<?php cabecera04(0,"Actualizar Datos de Clientes"); sl(1);?>
				<!--<center style="font-size:25px;color:#0A2C4F;"><b>Actualizar Clientes</b></center><br>-->
				<?php
				if ($zona_usuario=="Total") { $sql= mysqli_query ($Conexion,"SELECT * FROM clientes LIMIT 100") or die ("Error al traer los datos"); }
				else { $sql= mysqli_query ($Conexion,"SELECT * FROM clientes WHERE zona_cli='$zona_usuario' LIMIT 100") or die ("Error al traer los datos"); }
				// Obtener_matriz traslada los datos de la consulta $sql a la matriz $tabla
				$tabla=array(array()); obtener_matriz($sql,$tabla,$filas); 
				if (empty($var8)) $var8=date("d-m-Y");
				$uso_botones=isset($_POST["btnGrl"]);
				if($uso_botones OR !empty($_GET['id_cli'])) // isset determina si el botón bntGrl (asociado a Buscar, Nuevo, Modificar,	Eliminar) esta definido o tiene valor NULL
				{
					// Si btnGrl tiene datos almacena en $btn el nombre del boton y en $bus el valor de Buscar ID  para las siguientes acciones
					if (empty($btn)) $btn=$_POST["btnGrl"];
					if (empty($bus)) $bus=$_POST["txtbus"];
					// Obtiene los datos de Buscar ID y lo coloca en las cajas de texto
					if($btn=="Buscar")
					{
						if ($bus<>"")
						{
							//$numreg=busca_id($tabla,$filas,$bus);
							$sql_buscar= mysqli_query ($Conexion,"SELECT * FROM clientes WHERE id_cli='$bus'") or die ("Error al traer los datos");
							$filas=mysqli_num_rows($sql_buscar);
							//if($numreg>=0)
							if($filas>0)
							{	
								//mysqli_data_seek($sql, $numreg); 
								mysqli_data_seek($sql_buscar, 0); 
								//$resul=mysqli_fetch_array($sql);
								$resul=mysqli_fetch_array($sql_buscar);
								$var0=$resul[0];//id_cli
								$var1=$resul[1];//nom_rzs_cli
								$var2=$resul[2];//dni_ruc_cli
								$var3=$resul[3];//tlfcel_cli
								$var4=$resul[4];//direcc_cli
								$var5=$resul[5];//lugar_cli
								$var6=$resul[6];//prscont_cli
								$var7=$resul[7];//tlfcel_prscont_cli
								$var8=invFech($resul[8],"-");//fechreg_cli
								$var9=$resul[9];//id_usr
								$var10=$resul[10];//tipo_cli
								$var11=$resul[11];//zona_cli
								$id_tipdoc=$resul[12];//id_tipdoc
								$cod_ubigeo=$resul[13];//id_ubi
								$email_cli=$resul[14];//email_cli
							}
							else
							{
								echo "<script> alert('No se encuentra el registro.'); </script>";
							}
						}
						else
						{
							echo "<script> alert('Falta el id para la búsqueda de registros.'); location.href = 'clientes_actualizar.php'; </script>";
							//echo "<script> alert('Falta el id para la búsqueda de registros.'); </script>";
						}
					}
					if ($btn=="Modificar")
					{
						$id=$_POST["txtid"];//id_cli
						$nrs=trim($_POST["txtnrs"]);//nom_rzs_cli
						$drc=trim($_POST["txtdrc"]);//dni_ruc_cli
						$tcl=trim($_POST["txttcl"]);//tlfcel_cli
						$dir=trim($_POST["txtdir"]);//direcc_cli
						$lug=$_POST["txtlug"];//lugar_cli
						$prs=$_POST["txtprs"];//prscont_cli
						$tpr=$_POST["txttpr"];//tlfcel_prscont_cli
						$fch=invFech($_POST["txtfch"],"-");//fechreg_cli
						$tpc=$_POST["cmbtcl"];//tipo_cli
						$zna=$_POST["cmbzna"];//zona_cli
						$v_id_tipdoc=$_POST["cmb_id_tipdoc"];
						$v_id_ubi=$_POST["cmb_cod_ubigeo"];
						$v_email_cli=$_POST["txteml"];
						$verifdoc=validar_tipodocumento($v_id_tipdoc,$drc);
						if (!empty($nrs) AND !empty($v_id_tipdoc) AND !empty($drc)
						AND !empty($dir) AND !empty($tcl) AND !empty($v_email_cli)
						AND !empty($tpc) AND !empty($zna) AND !empty($v_id_ubi) AND !empty($fch))
						{
							if ($verifdoc=="1")
							{
								$cadena_sql = "UPDATE clientes SET nom_rzs_cli='$nrs', dni_ruc_cli='$drc', 
								tlfcel_cli='$tcl', direcc_cli='$dir', lugar_cli='$lug', prscont_cli='$prs', 
								tlfcel_prscont_cli='$tpr', fechreg_cli='$fch', id_usr='$ident_usuario', 
								tipo_cli='$tpc', zona_cli='$zna', id_tipdoc='$v_id_tipdoc', id_ubi='$v_id_ubi', 
								email_cli='$v_email_cli' WHERE id_cli=$id";
								mysqli_query($Conexion, $cadena_sql) or die("Error al modificar datos");
								$id="";
								$nrs="";
								$drc="";
								$tcl="";
								$dir="";
								$lug="";
								$prs="";
								$tpr="";
								$fch="";
								$tpc="";
								$zna="";
								$v_id_tipdoc="";
								$v_id_ubi="";
								$v_email_cli="";
								//echo "<script> alert('Se modificó correctamente los datos'); location.href = 'clientes_actualizar.php'; </script>";
								echo "<script> alert('Se modificó correctamente los datos'); window.close(); </script>";
							}
							else
							{
								echo "<script> alert('La cantidad de caracteres del tipo de documento no coincide.'); location.href = 'clientes_actualizar.php'; </script>";
							}
						}
						else
						{
							echo "<script> alert('Los datos principales del cliente para modificar no son suficientes. No se puede modificar.'); location.href = 'clientes_actualizar.php'; </script>";
						}
					}
					if($btn=="Actualizar")
					{
						echo "<script> location.href = 'clientes_actualizar.php'; </script>";
					}
				}
				?>
			<!-- Inicio de formulario -->
			<form name="usuario" action="" method="post">
			<span id="etq2">Buscar ID:</span><input type="text" name="txtbus"/><input type="submit" name="btnGrl"  value="Buscar"/>
			<?php lblnorm("Filtrar cliente(s):","etq2"); txtnrmstl("txtcli","width:100px;"); btnnormal("btnGrl", "Buscar Cliente");?>
			<br><hr> <!-- Salto de linea y linea de división -->
			<input type="hidden" name="txtnumreg" value="<?php echo $numreg ?>"/>
			<div id="colizq" style=" float:left; width:26%;">
				<div><span id="etq2">ID:</span><input type="text" name="txtid" style="background:rgb(220,220,255);" readonly="readonly" value="<?php echo $var0?>"/></div>
				<div><span id="etq2">Nombre/Raz.Social:</span><input type="text" name="txtnrs"  value="<?php echo $var1?>"/></div>
				<div><span id="etq2">Tipo Doc.:</span><?php cmbfield("cmb_id_tipdoc",$Conexion,"SELECT * FROM tipodocident",$id_tipdoc,"id_tipdoc","abrev_tipdoc");?></div>
				<div><span id="etq2">N°.Doc:</span><input type="text" name="txtdrc"  value="<?php echo $var2?>"/></div>
				<div><span id="etq2">Dirección:</span><input type="text" name="txtdir"  value="<?php echo $var4?>"/></div>
			</div>
			<div id="colder" style=" float:left; width:26%;">	
				<div><span id="etq2">Teléfono/Celular:</span><input type="text" name="txttcl"  value="<?php echo $var3?>"/></div>
				<div><span id="etq2">Correo Electrón.:</span><input type="text" name="txteml"  value="<?php echo $email_cli?>"/></div>
				<div><span id="etq2">Tipo de cliente:</span><?php cmbnormal("cmbtcl", $var10, "Gral", "PtVt");?></div>
				<div><span id="etq2">Zona:</span><?php cmbnormal("cmbzna", $var11, "JUNCD05", "JUNDL39", "JUNDL43", "PRE_DL39", "PRE_DL43", "JUNCD12", "Almacen1", "Almacen2", "Almacen3", "Almacen4", "Almacen5", "JUNDA29");?></div>
				<div><span id="etq2">Lugar:</span><input type="text" name="txtlug"  value="<?php echo $var5?>"/></div>
			</div>
			<div id="colders"  style=" float:left; width:43%;">		
				<div>
				    <span id="etq2">Ubigeo:</span>
				    <?php 
				        //cmbfield("cmb_cod_ubigeo",$Conexion,"SELECT * FROM ubigeo WHERE id_ubi>=1144 AND id_ubi<=1277",$cod_ubigeo,"id_ubi","regi_ubi","prov_ubi","dist_ubi");
				        cmbfield("cmb_cod_ubigeo",$Conexion,"SELECT * FROM ubigeo WHERE 1",$cod_ubigeo,"id_ubi","regi_ubi","prov_ubi","dist_ubi");
				    ?>
				</div>
				<div><span id="etq2" style="width:150px;">Persona de contacto:</span><input type="text" name="txtprs"  value="<?php echo $var6?>"/></div>
				<div><span id="etq2" style="width:150px;">Tlf/Cel. pers.contac.:</span><input type="text" name="txttpr"  value="<?php echo $var7?>"/></div>
				<div><span id="etq2" style="width:150px;">Fecha:</span><input type="text" name="txtfch"  value="<?php echo $var8?>"/></div>
			</div>
			<div style="clear:both"></div>
			<hr>
			<input type="submit" name="btnGrl" value="Modificar"/>
			<input type="submit" name="btnGrl" value="Actualizar"/>
			<br><hr>
			</form> <!-- Fin de formulario -->
</div><!--Fin de main-col-->
	<article class="piepag"><?php pie_pagina();?></article>
  </body>
</html>
<?php
function validar_tipodocumento($v_id_tipdoc,$drc)
{
	if ($v_id_tipdoc==2)
	{
		if (strlen($drc)==8)
		{
			return "1";
		}
		else
		{
			return "0";
		}			
	}
	if ($v_id_tipdoc==4)
	{
		if (strlen($drc)==11)
		{
			return "1";
		}
		else
		{
			return "0";
		}			
	}
}
?>