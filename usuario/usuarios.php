<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
/* id_usr, nom_usr, pws_usr, nomb_usr, apel_usr, dni_usr, tlfcel_usr, direcc_usr, lugar_usr, fechreg_usr, categ_usr, nivel_usr, zona_usr, activ_usr */
$var0=$var1=$var2=$var3=$var4=$var5=$var6=$var7=$var8=$var9=$var10=$var11=$var12=$var13=$var15="";
$v_cat=$v_act=$v_zna="";
$v_categoria=$v_activo="";
//Datos iniciales para control de accesos de perfil
$resultado_perfil_accesos = Null; $datos = array();
cargar_datos_perfil($Conexion,$ident_usuario,"Usuarios",$resultado_perfil_accesos,$datos,$categ_usuario,$nivel_usuario,$zona_usuario);
verificar_procesos_de_boton($resultado_perfil_accesos);
$variable_idLink="";
cargar_id_busqueda($variable_idLink);
?>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Data de usuarios");?></head>
	<body>
		<div style="width:1024px;">
			<?php cabecera04(0,"Gestión de Usuarios"); menu02(); sl(1);?>
			<!--<center  ><h1 style="margin-block:auto;">Lista de Usuarios</h1></center><hr>-->
			<?php
			/* Inicio de busqueda de registros en base de datos */
			$sql= mysqli_query ($Conexion,"SELECT * FROM usuarios")	or die ("Error al traer los datos");
			$consulta_lista_usuarios = $sql;
			$tabla=array(array());obtener_matriz($sql,$tabla,$filas);
			/* isset determina si el botón bntGrl (asociado a Buscar, Nuevo, Modificar, Eliminar) esta definido o tiene valor NULL */
			
			if (empty($var5)) $var9=date("d-m-Y");
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
						$numreg=busca_id($tabla,$filas,$bus);
						if($numreg>=0)
						{	
							mysqli_data_seek($sql, $numreg); 
							$resul=mysqli_fetch_array($sql);
							$var0=$resul[0];//id_usr
							$var1=$resul[1];//nom_usr
							$var2=$resul[2];//pws_usr
							$var3=$resul[3];//nomb_usr
							$var4=$resul[4];//apel_usr
							$var5=$resul[5];//dni_usr
							$var6=$resul[6];//tlfcel_usr
							$var7=$resul[7];//direcc_usr
							$var8=$resul[8];//lugar_usr
							$var9=invFech($resul[9],"-");//fechreg_usr
							$var10=$resul[10];//categ_usr
							$var11=$resul[11];//nivel_usr
							$var12=$resul[12];//zona_usr
							$var13=$resul[13];//activ_usr
							$var15=$resul[15];//activ_usr
						}
						else
						{
							echo "<script> alert('No se encuentra el registro'); </script>";
						}
					}
					else
					{
						echo "<script> alert('Falta el id para la búsqueda de registros'); location.href = 'usuarios.php'; </script>";
					}
				}
				if($btn=="Agregar")
				{
					$id=$_POST["txtid"];
					$usr=$_POST["txtusr"];
					$pws=$_POST["txtpsw"];
					$nom=$_POST["txtnom"];
					$categ=$_POST["cmbcateg"];
					$niv=$_POST["cmbniv"];
					$apel=$_POST["txtapel"];
					$dni=$_POST["txtdni"];
					$tlf=$_POST["txttlf"];
					$direcc=$_POST["txtdirecc"];
					$lugar=$_POST["txtlugar"];
					$fechreg=invFech($_POST["txtfechreg"],"-");
					$zona=$_POST["cmbzona"];
					$activo=$_POST["cmbacu"];
					$desc_per=$_POST["cmbPerfil"];
					$cadena="INSERT INTO usuarios (nom_usr,	pws_usr, nomb_usr, categ_usr, nivel_usr, apel_usr, dni_usr, tlfcel_usr, direcc_usr, lugar_usr, fechreg_usr, zona_usr, activ_usr, desc_per) VALUES ('".$usr."','".$pws."','".$nom."','".$categ."','".$niv."','".$apel."','".$dni."','".$tlf."','".$direcc."','".$lugar."','".$fechreg."','".$zona."',".$activo.",'".$desc_per."')";
					if ($usr<>"" && $pws<>"" && $nom<>"" && $categ<>"" && $niv<>"" && $apel<>"" && $dni<>"" && $tlf<>"" && $direcc<>"" && $lugar<>"" && $fechreg<>"")
					{
						mysqli_query ($Conexion, $cadena) or die("Error al agregar datos");
						echo "<script> alert('Se insertó correctamente'); location.href = 'usuarios.php'; </script>";
						$id=$usr=$pws=$nom=$categ=$niv=$apel=$dni=$tlf=$direcc=$lugar=$fechreg=$zona="";
					}
					else
					{
						echo "<script> alert('No hay datos para agregar registros'); location.href = 'usuarios.php'; </script>";
					}
				}
				if ($btn=="Modificar")
				{
					$id=$_POST["txtid"]; //id_usr
					$usr=$_POST["txtusr"];//nom_usr
					$pws=$_POST["txtpsw"];//pws_usr
					$nom=$_POST["txtnom"];//nomb_usr
					$categ=$_POST["cmbcateg"];//categ_usr
					$niv=$_POST["cmbniv"];//niv_usr
					$apel=$_POST["txtapel"];//apel_usr
					$dni=$_POST["txtdni"];//dni_usr
					$tlf=$_POST["txttlf"];//tlf_usr
					$direcc=$_POST["txtdirecc"];//direcc_usr
					$lugar=$_POST["txtlugar"];//lugar_usr
					$fechreg=invFech($_POST["txtfechreg"],"-");//fechreg_usr
					$zona=$_POST["cmbzona"];//zona_usr
					$activo=$_POST["cmbacu"];//activ_usr
					$desc_per=$_POST["cmbPerfil"];
					$cadena_sql =  "UPDATE usuarios SET nom_usr='$usr', pws_usr='$pws', nomb_usr='$nom', categ_usr='$categ', nivel_usr='$niv' , apel_usr='$apel' , dni_usr='$dni' , tlfcel_usr='$tlf ' , direcc_usr='$direcc' , lugar_usr='$lugar' , fechreg_usr='$fechreg' , zona_usr='$zona' , activ_usr=$activo,  desc_per='$desc_per' WHERE id_usr=$id";
					if ($usr<>"" && $pws<>"" && $nom<>"" && $categ<>"" && $niv<>"" && $apel<>"")
					{
						mysqli_query($Conexion, $cadena_sql) or die("Error al modificar datos");
						echo "<script> alert('Se modificó correctamente los datos'); location.href = 'usuarios.php'; </script>";
						$id=$usr=$pws=$nom=$categ=$niv=$apel=$dni=$tlf=$direcc=$lugar=$fechreg=$zona="";
					}
					else
					{
						echo "<script> alert('No hay datos para modificar'); location.href = 'usuarios.php'; </script>";
					}
				}
				if($btn=="Eliminar")
				{
					$nrg=$_POST["txtnumreg"];
					$id=$_POST["txtid"];
					if ($nrg<>"" && $id<>"")
					{
						$cadena_sql = "DELETE FROM usuarios WHERE id_usr=$id";
						$rsb = mysqli_query($Conexion, $cadena_sql);
						echo "<script> alert('Borrado de registro efectuado, actualizando datos...'); location.href = 'usuarios.php'; </script>";
						$sql = mysqli_query ($Conexion,"SELECT * from usuarios") or die ("Error al traer los datos");
						$tabla=array(array());
						obtener_matriz($sql,$tabla,$filas);
					}
					else
					{
						echo "<script> alert('No hay datos de registro para borrar'); location.href = 'usuarios.php'; </script>";
					}
				}
				//---------------------------------------------- Filtrar ----------------------------------------------
				if ($btn=="Filtrar")
				{
					$v_categoria=$_POST["cmbcat"];$v_cat=$v_categoria;
					$v_activo=$_POST["cmbact"];$v_act=$v_activo;
					//Añadido x Juan (26-11-2018)
					$v_zona=$_POST["cmbzna"];$v_zna=$v_zona;
					//------------------------------------------
					$sql_where_filtro="";
					if (!empty($v_categoria)) $sql_where_filtro=$sql_where_filtro."(categ_usr='$v_categoria') AND ";
					if (!empty($v_activo)) $sql_where_filtro=$sql_where_filtro."(activ_usr='$v_activo') AND ";
					if (!empty($v_zona)) $sql_where_filtro=$sql_where_filtro."(zona_usr='$v_zona') AND ";
					$sql_where_filtro=trim($sql_where_filtro);
					$sql_where_filtro=substr($sql_where_filtro, 0, strlen($sql_where_filtro)-4);
					if (!empty($sql_where_filtro))
					{
						$sql_where_filtro="SELECT * FROM usuarios WHERE ".$sql_where_filtro;
						$sql = mysqli_query ($Conexion,$sql_where_filtro) or die ("Error al traer los datos de usuarios después de filtrar.");
						$consulta_lista_usuarios = $sql;
					}
				}
				if($btn=="Actualizar")
				{
					echo "<script> location.href = 'usuarios.php'; </script>";
				}
			}
			?>
			<!-- Inicio de formulario -->
			<form name="usuario" action="" method="post">
				<span id="etq1">Buscar ID:&nbsp;</span><input type="text" name="txtbus" style="width:70px; "/>
				<?php if (activar_boton($datos,$resultado_perfil_accesos,"Buscar")) { ?> <input type="submit" name="btnGrl"  value="Buscar"/> <?php } spc(2);?>
				<span id="etq1">Categoria:</span><?php cmbnormal("cmbcat", $v_cat, "Gern", "Prog", "Supr", "Vend", "Almc", "Caja"); ?>
				<span id="etq1">Zona:</span>
				<?php cmbfieldJs_span("spn_zona","cmbzna",$Conexion,"SELECT nomb_zna FROM zona WHERE activo_zna='S'",$v_zna,"","nomb_zna"); ?>
				<span id="etq5">Activo(S/N):</span><?php cmbnormal("cmbact", $v_act, "0", "1"); if (activar_boton($datos,$resultado_perfil_accesos,"Filtrar")) { btnnormal("btnGrl", "Filtrar"); } ?>
				<br><hr> <!-- Salto de linea y linea de división -->
				<input type="hidden" name="txtnumreg" value="<?php echo $numreg ?>"/>
				<div style="background:white; height:175px; padding: 5px 0px 5px 0px; color:black;">
					<div id="colizq" style="float:left; margin-left:5px; width:24%;">
						<div><span id="etq1" >ID:&nbsp;</span><input type="text" name="txtid" style="background:rgb(189, 195, 184); width:70px" readonly=”readonly” value="<?php echo $var0?>"/></div>
						<div><span id="etq1">Usuario:&nbsp;</span><input type="text" name="txtusr" style="width:130px" value="<?php echo $var1?>"/></div>
						<div><span id="etq1">Clave:&nbsp;</span><input type="text" name="txtpsw" style="width:130px" value="<?php echo $var2?>"/></div>	
						<div><span id="etq1">Nombre:&nbsp;</span><input type="text" name="txtnom" style="width:130px" value="<?php echo $var3?>"/></div>
					</div>
					<div id="colcent1" style="float:left; margin-left:5px; width:24%;">
						<div><span id="etq1">Apellido:&nbsp;</span><input type="text" name="txtapel"  style="width:130px"value="<?php echo $var4?>"/></div>
						<div><span id="etq1">DNI:&nbsp;</span><input type="text" name="txtdni" style="width:130px" value="<?php echo $var5?>"/></div>
						<div><span id="etq1">Telefono:&nbsp;</span><input type="text" name="txttlf" style="width:130px" value="<?php echo $var6?>"/></div>
					</div>
					<div id="colcent2" style=" float:left;margin-left:5px; width:24%;">
						<div><span id="etq1">Direccion:&nbsp;</span><input type="text" name="txtdirecc" style="width:130px" value="<?php echo $var7?>"/></div>
						<div><span id="etq1">Lugar:&nbsp;</span><input type="text" name="txtlugar"  style="width:130px"value="<?php echo $var8?>"/></div>
						<div><span id="etq1">Fecha:&nbsp;</span><input type="text" name="txtfechreg"style="width:130px"  value="<?php echo $var9?>"/></div>
					</div>
					<div id="colder" style=" float:right; margin-right:-70px; width:27%;">
						<div><span id="etq4">Categoria:&nbsp;</span><?php cmbnormal("cmbcateg", $var10, "Gern", "Prog", "Supr", "Vend", "Almc", "Caja");?></div>
						<div><span id="etq4">Nivel:&nbsp;</span><?php cmbnormal("cmbniv", $var11, "bas", "med", "sup", "tot");?></div>
						<div><span id="etq4">Zona:&nbsp;</span>
						<?php 
						//cmbnormal("cmbzona", $var12, "Total", "JUNCD05", "JUNDL39", "JUNDL43", "PRE_DL39", "PRE_DL43", "JUNCD12", "Almacen1", "Almacen2", "Almacen3", "Almacen4", "Almacen5", "JUNDA29");
						cmbfieldJs_span("spn_zona","cmbzona",$Conexion,"SELECT nomb_zna FROM zona WHERE activo_zna='S'",$var12,"","nomb_zna");
						?></div>
						<div><span id="etq4">Activo(S/N):&nbsp;</span><?php cmbnormal("cmbacu", $var13, "1", "0");?></div>
						<div><span id="etq4">Perfil:&nbsp;</span><?php cmbfield("cmbPerfil",$Conexion,"SELECT * FROM perfil_nombres",$var15,"desc_per");?></div>
					</div>
				</div>
				<div style="clear:both"></div>
				<hr>
				<?php if (activar_boton($datos,$resultado_perfil_accesos,"Agregar")) { ?> <input type="submit" name="btnGrl" value="Agregar"/> <?php } ?>
				<?php if (activar_boton($datos,$resultado_perfil_accesos,"Modificar")) { ?> <input type="submit" name="btnGrl" value="Modificar"/> <?php } ?>
				<?php if (activar_boton($datos,$resultado_perfil_accesos,"Eliminar")) { ?> <input type="submit" name="btnGrl" value="Eliminar"/> <?php } ?>
				<?php if (activar_boton($datos,$resultado_perfil_accesos,"Actualizar")) { ?> <input type="submit" name="btnGrl" value="Actualizar"/> <?php } ?>
				<br><hr>
			</form> <!-- Fin de formulario -->
			<div id="lista_usuarios"> <?php
				tblanchovariable_05($Conexion,"margin-left:10px;","height:210px;",$consulta_lista_usuarios,"tblnormal","usuarios.php",
				"ID:id_usr:28:idLink|",
				"Usuario:nom_usr:175:N",
				"Clave:pws_usr:80:N",
				"Nombres:nomb_usr:130:N",
				"Apellidos:apel_usr:130:N",
				"Categoría:categ_usr:65:N",
				"Nivel:nivel_usr:60:N",
				"Zona:zona_usr:75:N",
				"Activo:activ_usr:45:N",
				"Perfil:desc_per:105:N"); ?>
			</div>
		</div>
		<article class="piepag">
			<?php pie_pagina();?><br><br>
		</article>		
	</body>
</html>
<?php
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