<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
// Variables de busqueda: id_cli, nom_rzs_cli, dni_ruc_cli, tlfcel_cli, direcc_cli, lugar_cli, prscont_cli, tlfcel_prscont_cli, fechreg_cli, id_usr, tipo_cli, zona_cli
/*$var0=$var1=$var2=$var3=$var4=$var5=$var6=$var7=$var8=$var9=$var10=$var11=$id_tipdoc=$cod_ubigeo="";
$email_cli="";*/
$var0=$var1=$var2=$var8=$var9="";
$var4="Satipo";
$id_tipdoc=2;
$var3="-";
$email_cli="ECOSITI.VENTAS@GMAIL.COM";
$var10="Gral";
$var5="-";
$var11=$zona_usuario;
$cod_ubigeo=1238;
$var6="-";
$var7="-";
?>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Clientes");?></head>
	<body>
		<div>
			<div style="width:1200px;">
				<?php cabecera04(0,"Cliente Nuevo");sl(1)?>
				<!--<center><h1>Cliente Nuevo</h1></center><hr>-->
				<?php
				if ($zona_usuario=="Total") { $sql= mysqli_query ($Conexion,"SELECT * FROM clientes LIMIT 100") or die ("Error al traer los datos"); }
				else { $sql= mysqli_query ($Conexion,"SELECT * FROM clientes WHERE zona_cli='$zona_usuario' LIMIT 100") or die ("Error al traer los datos"); }
				// Obtener_matriz traslada los datos de la consulta $sql a la matriz $tabla
				$tabla=array(array()); obtener_matriz($sql,$tabla,$filas); 
				if (empty($var8)) $var8=date("d-m-Y");
				$uso_botones=isset($_POST["btnGrl"]);
				if($uso_botones) // isset determina si el botón bntGrl (asociado a Buscar, Nuevo, Modificar,	Eliminar) esta definido o tiene valor NULL
				{
					// Si btnGrl tiene datos almacena en $btn el nombre del boton y en $bus el valor de Buscar ID  para las siguientes acciones
					$btn=$_POST["btnGrl"];
					if($btn=="Agregar")
					{
						$id=$_POST["txtid"];
						$nrs=trim($_POST["txtnrs"]);
						$drc=trim($_POST["txtdrc"]);
						$tcl=trim($_POST["txttcl"]);
						$dir=trim($_POST["txtdir"]);
						$lug=$_POST["txtlug"];
						$prs=$_POST["txtprs"];
						$tpr=$_POST["txttpr"];
						$fch=invFech($_POST["txtfch"],"-");
						$tpc=$_POST["cmbtcl"];
						$zna=$_POST["cmbzna"];
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
								mysqli_query ($Conexion,"INSERT INTO clientes (nom_rzs_cli, dni_ruc_cli, 
								tlfcel_cli, direcc_cli, lugar_cli, prscont_cli, tlfcel_prscont_cli, 
								fechreg_cli, id_usr, tipo_cli, zona_cli, id_tipdoc, id_ubi, email_cli) 
								VALUES ('".$nrs."','".$drc."','".$tcl."','".$dir."','".$lug."','".$prs."',
								'".$tpr."','".$fch."','".$ident_usuario."','".$tpc."','".$zna."','".$v_id_tipdoc."',
								'".$v_id_ubi."','".$v_email_cli."')") or die("Error al agregar datos");
								echo "<script> alert('Se agrego correctamente los datos del nuevo cliente.'); window.close(); </script>";
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
							}
							else
							{
								echo "<script> alert('La cantidad de caracteres del tipo de documento no coincide.'); location.href = 'clientes_nuevo.php'; </script>";
							}
						}
						else
						{
							echo "<script> alert('No hay datos suficientes para agregar el registro del cliente.'); location.href = 'clientes_nuevo.php'; </script>";
						}
					}
					if($btn=="Actualizar")
					{
						echo "<script> location.href = 'clientes_nuevo.php'; </script>";
					}
				}
				?>
			<!-- Inicio de formulario -->
			<form name="usuario" action="" method="post">
			<div id="colizq" style=" float:left; width:26%;">
				<div><span>ID:&nbsp;</span><input type="text" name="txtid" style="background:rgb(220,220,255); width:90px;" readonly="readonly" value="<?php echo $var0?>"/></div>
				<div><span>Nombre/Raz.Social:&nbsp;</span><input type="text" name="txtnrs" style="width:139px;" value="<?php echo $var1?>"/></div>
				<div><span>Tipo Doc.:&nbsp;</span><?php cmbfield("cmb_id_tipdoc",$Conexion,"SELECT * FROM tipodocident",$id_tipdoc,"id_tipdoc","abrev_tipdoc");?></div>
				<div><span>N°.Doc:&nbsp;</span><input type="text" name="txtdrc" style="width:139px;" value="<?php echo $var2?>"/></div>
				<div><span>Dirección:&nbsp;</span><input type="text" name="txtdir" style="width:139px;" value="<?php echo $var4?>"/></div>
			</div>
			<div id="colder" style=" float:left; width:26%;">	
				<div><span>Teléfono/Celular:&nbsp;</span><input type="text" name="txttcl" style="width:160px;" value="<?php echo $var3?>"/></div>
				<div><span>Correo Electrón.:&nbsp;</span><input type="text" name="txteml" style="width:160px;" value="<?php echo $email_cli?>"/></div>
				<div><span>Tipo de cliente:&nbsp;</span><?php cmbnormal("cmbtcl", $var10, "Gral", "PtVt");?></div>
				<div><span>Zona:&nbsp;</span><?php cmbnormal("cmbzna", $var11, "PDV_JXU4");?></div>
				<div><span>Lugar:&nbsp;</span><input type="text" name="txtlug" style="width:160px;" value="<?php echo $var5?>"/></div>
			</div>
			<div id="colders"  style=" float:left; width:43%;">		
				<div><span>Ubigeo:&nbsp;</span><?php cmbfield("cmb_cod_ubigeo",$Conexion,"SELECT * FROM ubigeo WHERE id_ubi>=1144 AND id_ubi<=1277",$cod_ubigeo,"id_ubi","regi_ubi","prov_ubi","dist_ubi");?></div>
				<div><span style="width:148px;">Persona de contacto:&nbsp;</span><input type="text" name="txtprs"  value="<?php echo $var6?>"/></div>
				<div><span style="width:148px;">Tlf/Cel. pers.contac.:&nbsp;</span><input type="text" name="txttpr"  value="<?php echo $var7?>"/></div>
				<div><span style="width:148px;">Fecha:&nbsp;</span><input type="text" name="txtfch"  value="<?php echo $var8?>"/></div>
			</div>
			<div style="clear:both"></div>
			<hr>
			<input type="submit" name="btnGrl" value="Agregar"/>
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