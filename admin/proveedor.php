<?php
/* Para evitar el error "Cannot send session cache limiter - headers already sent" codificar el archivo como UTF-8 sin BOM */
include("../library/funcionA.php"); include("../library/funcionB.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
/* Variables de busqueda: id_prv, nom_rzs_prv, dni_ruc_prv, tlfcel_prv, direcc_prv, lug_prv, prscont_prv, tlfcel_prscont_prv, fechreg_prv, id_usr */
$var0=$var1=$var2=$var3=$var4=$var5=$var6=$var7=$var8=$var9="";
//Datos iniciales para control de accesos de perfil
$resultado_perfil_accesos = Null; $datos = array();
cargar_datos_perfil($Conexion,$ident_usuario,"Proveedor",$resultado_perfil_accesos,$datos,$categ_usuario,$nivel_usuario,$zona_usuario);
verificar_procesos_de_boton($resultado_perfil_accesos);
?>
<!DOCTYPE HTML>
<html><!-- HTML inicia el contenido de toda la página -->
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Proveedores");?></head>
	<body><!-- Cuerpo de página -->
		<div>
			<div style="width:900px;">
				<?php cabecera04(0,"Gestión de Proveedores"); menu02(); sl(1);?>
				<!--<center><h1>Lista de Proveedores</h1></center><hr>-->
				<?php
				/* Inicio de busqueda de registros en base de datos */
				$sql= mysqli_query ($Conexion,"SELECT * from proveedores")	or die ("Error al traer los datos");
				$tabla=array(array()); obtener_matriz($sql,$tabla,$filas);// obtener_matriz traslada los datos de la consulta $sql a la matriz $tabla
				/* isset determina si el botón bntGrl (asociado a Buscar, Nuevo, Modificar,	Eliminar) esta definido o tiene valor NULL */
				if (empty($var8)) $var8=date("d-m-Y");
				if(isset($_POST["btnGrl"]))
				{
					/* Si btnGrl tiene datos almacena en $btn el nombre del boton y en $bus el valor de Buscar ID  para las siguientes acciones */
					$btn=$_POST["btnGrl"];
					$bus=$_POST["txtbus"];
					/* Obtiene los datos de Buscar ID y lo coloca en las cajas de texto */
					if($btn=="Buscar")
					{
						if ($bus<>"")
						{
							$numreg=busca_Id($tabla,$filas,$bus);
							if($numreg>=0)
							{
								mysqli_data_seek($sql, $numreg);
								$resul=mysqli_fetch_array($sql);
								$var0=$resul[0];//id_prv
								$var1=$resul[1];//nom_rzs_prv
								$var2=$resul[2];//dni_ruc_prv
								$var3=$resul[3];//tlfcel_prv
								$var4=$resul[4];//direcc_prv
								$var5=$resul[5];//lug_prv
								$var6=$resul[6];//prscont_prv
								$var7=$resul[7];//tlfcel_prscont_prv
								$var8=invFech($resul[8],"-");//fechreg_prv
								$var9=$resul[9];//id_usr
							}
							else
							{
								echo "<script> alert('No se encuentra el registro'); </script>";
							}
						}
						else
						{
							echo "<script> alert('Falta el id para la búsqueda de registros'); location.href = 'proveedor.php'; </script>";
						}
					}
					if($btn=="Agregar")
					{
						$id=$_POST["txtIdprov"];
						$nom_rzs=$_POST["txtNom_Rzs"];
						$dni_ruc=$_POST["txtDni_Ruc"];
						$tlfcel=$_POST["txtTlfcel"];
						$direcc=$_POST["txtDirecc"];
						$lug=$_POST["txtLug"];
						$prscont=$_POST["txtPrscont"];
						$tlfcel_prscont=$_POST["txtTlfcel_Prscont"];
						$fechareg=invFech($_POST["txtFechareg"],"-");
						if ($nom_rzs<>"" && $dni_ruc<>"" && $tlfcel<>""&& $direcc<>""&& $lug<>""&& $fechareg<>"")
						{
							mysqli_query ($Conexion,"INSERT INTO proveedores (nom_rzs_prv, dni_ruc_prv, tlfcel_prv, direcc_prv, lug_prv, prscont_prv, tlfcel_prscont_prv, fechreg_prv, id_usr) VALUES ('".$nom_rzs."','".$dni_ruc."','".$tlfcel."','".$direcc."','".$lug."','".$prscont."','".$tlfcel_prscont."','".$fechareg."','".$ident_usuario."')") or die("Error al agregar datos");
							echo "<script> alert('Se insertó correctamente'); location.href = 'proveedor.php'; </script>";
							$id=$nom_rzs=$dni_ruc=$tlfcel=$direcc=$lug=$prscont=$tlfcel_prscont=$fechareg="";
						}
						else
						{
							echo "<script> alert('No hay datos para agregar registros'); location.href = 'proveedor.php'; </script>";
						}
					}
					if ($btn=="Modificar")
					{
						$id=$_POST["txtIdprov"];//Id_prv
						$nom_rzs=$_POST["txtNom_Rzs"];//Nom_Rzs_prv
						$dni_ruc=$_POST["txtDni_Ruc"];//Dni_Ruc_prv
						$tlfcel=$_POST["txtTlfcel"];//tlfcel_prv
						$direcc=$_POST["txtDirecc"];//direcc_prv
						$lug=$_POST["txtLug"];//lug_prv
						$prscont=$_POST["txtPrscont"];//prscont_prv
						$tlfcel_prscont=$_POST["txtTlfcel_Prscont"];//tlfcel_prscont_prv
						$fechareg=invFech($_POST["txtFechareg"],"-");//fechreg_prv
						/* id_prv, nom_rzs_prv, dni_ruc_prv, tlfcel_prv, direcc_prv, lug_prv, prscont_prv, tlfcel_prscont_prv, fechreg_prv, id_usr */
						if ($nom_rzs<>"" && $dni_ruc<>"" && $tlfcel<>""&& $direcc<>""&& $lug<>""&& $fechareg<>"")
						{
							$cadena_sql = "UPDATE proveedores SET nom_rzs_prv='$nom_rzs', dni_ruc_prv='$dni_ruc', tlfcel_prv='$tlfcel', direcc_prv='$direcc', lug_prv='$lug', prscont_prv='$prscont', tlfcel_prscont_prv='$tlfcel_prscont', fechreg_prv='$fechareg', id_usr='$ident_usuario' WHERE id_prv=$id";
							mysqli_query($Conexion, $cadena_sql) or die("Error al modificar datos");
							echo "<script> alert('Se modificó correctamente los datos'); location.href = 'proveedor.php'; </script>";
							$id=$nom_rzs=$dni_ruc=$tlfcel=$direcc=$lug=$prscont=$tlfcel_prscont=$fechareg="";
						}
						else
						{
							echo "<script> alert('No hay datos para modificar'); location.href = 'proveedor.php'; </script>";
						}
					}
					if($btn=="Eliminar")
					{
						$nrg=$_POST["txtnumreg"];
						$id=$_POST["txtIdprov"];
						if ($nrg<>"" && $id<>"")
						{
							$cadena_sql = "DELETE FROM proveedores WHERE id_prv=$id";
							$rsb = mysqli_query($Conexion, $cadena_sql) or die ("error al modificar datos");
							echo "<script> alert('Borrado de registro efectuado, actualizando datos...'); location.href = 'proveedor.php'; </script>";
							$sql = mysqli_query ($Conexion,"SELECT * from proveedores") or die ("Error al traer los datos");
							$tabla=array(array());
							obtener_matriz($sql,$tabla,$filas);
						}
						else
						{
							echo "<script> alert('No hay datos de registro para borrar'); location.href = 'proveedor.php'; </script>";
						}
					}
					if($btn=="Actualizar")
					{
						echo "<script> location.href = 'proveedor.php'; </script>";
					}
				}
				?>
				<!-- Inicio de formulario -->
				<form name="usuario" action="" method="post">
					<span Id="etq2">Buscar ID:</span>&nbsp;<input type="text" name="txtbus" style="width:60px;"/>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Buscar")) { ?> <input type="submit" name="btnGrl"  value="Buscar"/> <?php } ?>
					<br><hr><!-- Salto de linea y linea de división -->
					<div class="formulario">
						<input type="hidden" name="txtnumreg" value="<?php echo $numreg ?>"/>
						<div id="colizq" style=" float:left; width:38%;">
							<div><span Id="etq2"style="width:140px;">ID:&nbsp;</span><input style="width:70px;" type="text" name="txtIdprov" style="background:rgb(220,220,255);" readonly="readonly" value="<?php echo $var0?>"/></div>
							<div><span Id="etq2" style="width:140px;">Nomb./Raz.Soc.:&nbsp;</span><input style="width:200px;" type="text" name="txtNom_Rzs"  value="<?php echo $var1?>"/></div>
							<div><span Id="etq2"style="width:140px;">DNI/RUC:&nbsp;</span><input style="width:100px;"type="text" name="txtDni_Ruc"  value="<?php echo $var2?>"/></div>
						</div>
						<div id="colder" style=" float:left; width:32%;">	
							<div><span Id="etq2"style="width:130px;">Teléfono/Celular:&nbsp;</span><input style="width:90px;"type="text" name="txtTlfcel"  value="<?php echo $var3?>"/></div>
							<div><span Id="etq2"style="width:130px;">Dirección:&nbsp;</span><input style="width:180px;"type="text" name="txtDirecc"  value="<?php echo $var4?>"/></div>
							<div><span Id="etq2"style="width:130px;">Lugar:&nbsp;</span><input style="width:140px;"type="text" name="txtLug"  value="<?php echo $var5?>"/></div>
						</div>
						<div id="colders"  style=" float:left; width:30%;">		
							<div><span Id="etq2" style="width:150px;">Person.contac.:&nbsp;</span><input style="width:130px;" type="text" name="txtPrscont"  value="<?php echo $var6?>"/></div>
							<div><span Id="etq2" style="width:150px;">Tlf/Cel.pers.cont.:&nbsp;</span><input style="width:90px;"type="text" name="txtTlfcel_Prscont"  value="<?php echo $var7?>"/></div>
							<div><span Id="etq2" style="width:150px;">Fecha:&nbsp;</span><input style="width:75px;" type="text" name="txtFechareg"  value="<?php echo $var8?>"/></div>
						</div>
					</div>
					<hr>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Agregar")) { ?> <input type="submit" name="btnGrl" value="Agregar"/> <?php } ?>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Modificar")) { ?> <input type="submit" name="btnGrl" value="Modificar"/> <?php } ?>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Eliminar")) { ?> <input type="submit" name="btnGrl" value="Eliminar"/> <?php } ?>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Actualizar")) { ?> <input type="submit" name="btnGrl" value="Actualizar"/> <?php } ?>
					<br><hr>
				</form><!-- Fin de formulario -->
				<!-- Inicio de listado de datos de usuario -->
				<table border='0' cellspacing='0' cellpadding='0' class="tblnormal">
					<th width="30">ID</th>
					<th width="180">Nomb./Raz.Soc.</th>
					<th width="100">DNI/RUC</th>
					<th width="110">Tlf./Cel.</th>
					<th width="250">Dirección</th>
					<th width="100">Lugar</th>
					<th width="90">Fecha</th>
					</tr>
				</table>
				<div style="height:250px; width:100%; overflow:auto;">
				<table border='0' cellspacing='0' cellpadding='0' class="tblnormal">
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
						$var8=$resul[8];
					?>
						<tr align='center'>
						<td width="30"><?php echo $var0 ?></td>
						<td width="180"><?php echo $var1 ?></td>
						<td width="100"><?php echo $var2 ?></td>
						<td width="110"><?php echo $var3 ?></td>
						<td width="250"><?php echo $var4 ?></td>
						<td width="100"><?php echo $var5 ?></td>
						<td width="90"><?php echo invFech($var8,"-");?></td>
						</tr>
					<?php
					}
					?>
				</table>
			</div><!--Fin de main-col-->
			<article class="piepag"><?php pie_pagina();?></article>
  </body>
</html>