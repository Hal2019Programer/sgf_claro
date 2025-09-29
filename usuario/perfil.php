<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
$id_per=$desc_per=$id_usr="";
$v_cat=$v_act=$v_zna="";
$v_categoria=$v_activo="";
$activo_listar_perfil = false;
$activo_verificar_perfil = false;
$id_acs_plantilla="";
//Datos iniciales para control de accesos de perfil
$resultado_perfil_accesos = Null; $datos = array();
cargar_datos_perfil($Conexion,$ident_usuario,"Perfil",$resultado_perfil_accesos,$datos,$categ_usuario,$nivel_usuario,$zona_usuario);
verificar_procesos_de_boton($resultado_perfil_accesos);
?>
<!DOCTYPE HTML>
<html>
	<head ><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Data de usuarios");?></head>
	<body>
		<div style="width:900px;">
			<?php cabecera04(0,"Gestión de Perfil"); menu02(); sl(1);?>
			<!--<center><h1 style="color:white; margin-block:auto;">Perfil de Usuarios</h1></center><hr>-->
			<?php
			$sql_perfil_nombres= mysqli_query ($Conexion,"SELECT * FROM perfil_nombres") or die ("Error al traer los datos de la tabla perfil_nombres.");
			if(isset($_POST["btnGrl"]))
			{
				$btn=$_POST["btnGrl"];
				if($btn=="Buscar")
				{
					$id_per=$_POST["txtbus"];
					if ($id_per<>"")
					{
						$resultado_nombres_perfil=consulta_nombres_perfil($Conexion,$id_per,$desc_per,$id_usr);
						if($resultado_nombres_perfil)
						{	
							$activo_listar_perfil=consulta_accesos_perfil($Conexion,$desc_per);
							if (!$activo_listar_perfil)
							{
								mensaje("No se encuentra los registros de accesos del perfil encontrado.");
							}
						}
						else { echo "<script> alert('No se encuentra el perfil buscado.'); location.href = 'perfil.php'; </script>"; }
					}
					else { echo "<script> alert('Falta el id para la búsqueda de registros.'); location.href = 'perfil.php'; </script>"; }
				}
				if($btn=="Agregar")
				{
					$desc_per=$_POST["txt_desc_per"];
					if (!empty($desc_per))
					{
						$consultar_perfil_nombres = verificar_nombre_de_perfil($Conexion,$desc_per);
						if (!$consultar_perfil_nombres)
						{
							$resultado_de_crear_perfil_nombres = crea_perfil_nombres($Conexion,$desc_per);
							if ($resultado_de_crear_perfil_nombres)
							{
								$resultado_de_copiar_perfil_accesos_plantilla = copiar_perfil_accesos_plantilla_a_perfil_accesos($Conexion,$desc_per);
								if ($resultado_de_copiar_perfil_accesos_plantilla)
								{
									mensaje("Se creó correctamente el perfil de accesos.");
								}
								$activo_listar_perfil=consulta_accesos_perfil($Conexion,$desc_per);
								$sql_perfil_nombres= mysqli_query ($Conexion,"SELECT * FROM perfil_nombres") or die ("Error al traer los datos de la tabla perfil_nombres.");
							}
						}
						else { mensaje("El nombre elegido ya existe en el registro de los perfiles."); }
					}
					else { mensaje("No existen datos para crear un nuevo registro de perfil de accesos."); }
				}
				if ($btn=="Modificar")
				{
					$desc_per=$_POST["txt_desc_per"];
					$id_per=$_POST["txt_id_per"];
					if (!empty($desc_per))
					{
						if (verificar_nombre_de_perfil($Conexion,$desc_per))
						{
							if(consulta_accesos_perfil($Conexion,$desc_per))
							{
								if (!empty($id_per))
								{
									actualizar_perfil_accesos($Conexion,$desc_per);
								}
								else { mensaje("No se ha cargado los registros del perfil seleccionado para la modificación."); }
							}
							else { mensaje("El nombre consultado no existe en el registro de los accesos del perfil."); }
						}
						else { mensaje("El nombre consultado no existe en el registro de nombres de perfil."); }
					}
					else { mensaje("No se encuentra el dato de la descripción del perfil para la modificación."); }
				}
				if($btn=="Actualizar")
				{
					echo "<script> location.href = 'perfil.php'; </script>";
				}
				if($btn=="Verificar")
				{
					$desc_per=$_POST["txt_desc_per"];
					$id_per=$_POST["txt_id_per"];
					if (!empty($desc_per))
					{
						$activo_verificar_perfil = true;
					}
					else { mensaje("No se encuentra el dato de la descripción del perfil para la verificación."); }
				}
				if($btn=="Actualizar Perfil Accesos")
				{
					$id_acs_plantilla=$_POST["txt_id_acs_perfil_accesos_plantilla"];
					$descrip_perfil=$_POST["txt_descrip_perfil"];
					if (!empty($id_acs_plantilla))
					{
						$resultado_actualizar=actualizar_perfil_accesos_con_perfil_accesos_plantilla($Conexion,$id_acs_plantilla,$descrip_perfil);
						if ($resultado_actualizar)
						{
							mensaje("Se agregó un registro como parte del proceso de actualización del perfil_accesos desde perfil_accesos_plantilla.");
						}
						else
						{
							mensaje("Se produjo un error al actualizar la tabla perfil_accesos.");
						}
					}
					else { mensaje("No se encuentra el id del perfil de accesos a la plantilla."); }
				}
			}
			?>
			<form name="perfil" action="" method="post">
				<span id="etq1">Buscar ID:&nbsp;</span><input type="text" name="txtbus" style="width:50px;"/>
				<?php if (activar_boton($datos,$resultado_perfil_accesos,"Buscar")) { ?> <input type="submit" name="btnGrl" value="Buscar"/> <?php } ?>
				<?php if (activar_boton($datos,$resultado_perfil_accesos,"Actualizar")) { ?><input type="submit" name="btnGrl" value="Actualizar"/> <?php } ?>
				<br><hr>
				<div style="background-color:white; padding:5px; color:black; font-weight:bold;">
					<?php spc(2);?><span id="etq5">ID:&nbsp;</span><input type="text" name="txt_id_per" style="background:rgb(189,195,184); width:60px" readonly=”readonly” value="<?php echo $id_per?>"/>&nbsp;
					<span id="etq5">Perfil:&nbsp;</span><input type="text" name="txt_desc_per" style="width:150px" value="<?php echo $desc_per?>"/>&nbsp;
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Agregar")) { ?><input type="submit" name="btnGrl" value="Agregar"/> <?php } ?>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Modificar")) { ?><input type="submit" name="btnGrl" value="Modificar"/> <?php } ?>
					<?php if (activar_boton($datos,$resultado_perfil_accesos,"Verificar")) { ?><input type="submit" name="btnGrl" value="Verificar"/> <?php } ?>
				</div><hr>
				<?php 
				if ($activo_listar_perfil)
				{
					listar_perfil_accesos($Conexion,$desc_per); ?><br><hr><?php
				} 
				if ($activo_verificar_perfil)
				{
					mostrar_resultados_verificacion($Conexion,$desc_per,$id_acs_plantilla);
					txtoculto("txt_id_acs_perfil_accesos_plantilla",$id_acs_plantilla);
					txtoculto("txt_descrip_perfil",$desc_per);
					
					if (!empty($id_acs_plantilla))
					{
						if (activar_boton($datos,$resultado_perfil_accesos,"Actualizar Perfil Accesos")) { ?><input type="submit" name="btnGrl" value="Actualizar Perfil Accesos"/> <?php }
					} ?><br><hr><?php
				} ?>
			</form>
			<center>
				<?php
				tblanchovariable($Conexion,"margin-left:0px;","height:210px",$sql_perfil_nombres,"tblnormal","Normal",
				"Id:id_per:100:N",
				"Nombre:desc_per:200:N",
				"Id Usuario:id_usr:100:N"); ?>
			</center>
		</div><div style="clear:both"></div>
		<article class="piepag">
			<?php pie_pagina();?><br><br>
		</article>		
	</body>
</html>
<style type="text/css">
	table td 
	{
		/* background-color:rgb(200,200,230);*/
		padding-top:0;
		padding-bottom:0px;
		margin-top:0px;
		margin-bottom:0px;
		line-height:14px;
	}
</style>
<?php
function listar_perfil_accesos($Conexion,$desc_per)
{ 
	$sql_perfil_accesos = mysqli_query($Conexion,"SELECT * FROM perfil_accesos WHERE descrip_perfil='$desc_per' ORDER BY orden_menu ASC, orden_submenu ASC, orden_boton ASC") or die ("Error al traer los datos de la tabla perfil_accesos_plantilla.");
	$filas = mysqli_num_rows($sql_perfil_accesos);
	if($filas>0)
	{	?>
		<table style="color:black;"><?php
		while($resul = mysqli_fetch_array($sql_perfil_accesos,MYSQLI_ASSOC))
		{
			$id_acs_plantilla=$resul["id_acs_plantilla"];
			$descrip_menu=$resul["descrip_menu"];
			$activo_menu=$resul["activo_menu"];
			$orden_submenu=$resul["orden_submenu"];
			$descrip_submenu=$resul["descrip_submenu"];
			$activo_submenu=$resul["activo_submenu"];
			$descrip_boton=$resul["descrip_boton"];
			$activo_boton=$resul["activo_boton"];
			$chk_descrip_menu=$id_acs_plantilla."-"."activo_menu"."-".str_replace(" ","",$descrip_menu);
			$chk_descrip_submenu=$id_acs_plantilla."-"."activo_submenu"."-".str_replace(" ","",$descrip_submenu);
			$chk_descrip_boton=$id_acs_plantilla."-"."activo_boton"."-".str_replace(" ","",$descrip_boton);
			$color="background-color:rgb(220,220,250)";
			if ($orden_submenu % 2 == 0) { $color="background-color:rgb(200,200,230);"; }
			if ($orden_submenu % 3 == 0) { $color="background-color:rgb(180,180,210);"; } 
			if ($orden_submenu % 5 == 0) { $color="background-color:rgb(160,160,190);"; }?>
			<tr style="<?php echo $color;?>">
				<td><?php echo $descrip_menu;?></td>
				<td><input type="checkbox" name="<?php echo $chk_descrip_menu;?>" <?php if ($activo_menu=='S') {echo "checked";}?>></td>
				<td> <?php echo $descrip_submenu;?></td>
				<td><input type="checkbox" name="<?php echo $chk_descrip_submenu;?>" <?php if ($activo_submenu=='S') {echo "checked";}?>></td>
				<td> <?php echo $descrip_boton;?></td>
				<td><input type="checkbox" name="<?php echo $chk_descrip_boton;?>" <?php if ($activo_boton=='S'){echo "checked";}?>></td>
			</tr><?php
		}?>
		</table> <?php
	}
}
function consulta_nombres_perfil($Conexion,$id_per,&$desc_per,&$id_usr)
{
	$sql_buscar_nombres_perfil= mysqli_query($Conexion,"SELECT * FROM perfil_nombres WHERE id_per='$id_per'") or die ("Error al traer los datos de la tabla perfil_nombres.");
	$filas_nombres_perfil=mysqli_num_rows($sql_buscar_nombres_perfil);
	if($filas_nombres_perfil>0)
	{	
		$resul=mysqli_fetch_array($sql_buscar_nombres_perfil,MYSQLI_ASSOC);
		$desc_per=$resul["desc_per"];
		$id_usr=$resul["id_usr"];
		return true;
	}
	else
	{
		return false;
	}
}
function consulta_accesos_perfil($Conexion,$desc_per)
{
	$sql_buscar_accesos_perfil= mysqli_query($Conexion,"SELECT * FROM perfil_accesos WHERE descrip_perfil='$desc_per'") or die ("Error al traer los datos de la tabla perfil_accesos.");
	$filas_accesos_perfil=mysqli_num_rows($sql_buscar_accesos_perfil);
	if ($filas_accesos_perfil>0)
	{
		return true;
	}
	else
	{
		return false;
	}
}
function crea_perfil_nombres($Conexion,$desc_per)
{
	$sql_insertar_perfil_nombres = "INSERT INTO perfil_nombres SET desc_per='$desc_per'";
	$resultado_de_insertar_perfil_nombres = mysqli_query($Conexion, $sql_insertar_perfil_nombres) or die("Error al insertar datos en perfil_accesos.");
	return $resultado_de_insertar_perfil_nombres;
}

function copiar_perfil_accesos_plantilla_a_perfil_accesos($Conexion,$descrip_perfil)
{
	$sql_buscar_perfil_accesos_plantilla = mysqli_query($Conexion,"SELECT * FROM perfil_accesos_plantilla") or die ("Error al traer los datos de la tabla perfil_accesos_plantilla.");
	$filas_perfil_accesos_plantilla = mysqli_num_rows($sql_buscar_perfil_accesos_plantilla);
	if ($filas_perfil_accesos_plantilla>0)
	{
		while($resul=mysqli_fetch_array($sql_buscar_perfil_accesos_plantilla,MYSQLI_ASSOC))
		{
			//leer registro de perfil_accesos_plantilla
			$id_acs=$resul["id_acs"];
			$orden_menu=$resul["orden_menu"];
			$descrip_menu=$resul["descrip_menu"];
			$ruta_menu=$resul["ruta_menu"];
			$activo_menu=$resul["activo_menu"];
			$orden_submenu=$resul["orden_submenu"];
			$descrip_submenu=$resul["descrip_submenu"];
			$ruta_submenu=$resul["ruta_submenu"];
			$activo_submenu=$resul["activo_submenu"];
			$orden_boton=$resul["orden_boton"];
			$descrip_boton=$resul["descrip_boton"];
			$ruta_boton=$resul["ruta_boton"];
			$activo_boton=$resul["activo_boton"];
			//Insertar registro leido en perfil_accesos
			$sql_insertar_perfil_accesos = "INSERT INTO perfil_accesos SET 
			id_acs_plantilla='$id_acs',
			descrip_perfil='$descrip_perfil',
			orden_menu='$orden_menu',
			descrip_menu='$descrip_menu',
			ruta_menu='$ruta_menu',
			activo_menu='$activo_menu',
			orden_submenu='$orden_submenu',
			descrip_submenu='$descrip_submenu',
			ruta_submenu='$ruta_submenu',
			activo_submenu='$activo_submenu',
			orden_boton='$orden_boton',
			descrip_boton='$descrip_boton',
			ruta_boton='$ruta_boton',
			activo_boton='$activo_boton'";
			mysqli_query($Conexion, $sql_insertar_perfil_accesos) or die("Error al insertar datos en perfil_accesos.");
		}
		return true;
	}
	else
	{
		return false;
	}	
}
function verificar_nombre_de_perfil($Conexion,$desc_per)
{
	$sql_nombre_perfil = mysqli_query($Conexion,"SELECT * FROM perfil_nombres WHERE desc_per='$desc_per'") or die ("Error al traer los datos de la tabla perfil_nombres.");
	$filas_nombre_perfil = mysqli_num_rows($sql_nombre_perfil);
	if ($filas_nombre_perfil>0)
	{
		return true;
	}
	else
	{
		return false;
	}
}
function actualizar_perfil_accesos($Conexion,$desc_per)
{
	$sql_perfil_accesos = mysqli_query($Conexion,"SELECT * FROM perfil_accesos WHERE descrip_perfil='$desc_per' ORDER BY orden_menu ASC, orden_submenu ASC, orden_boton ASC") or die ("Error al traer los datos de la tabla perfil_accesos_plantilla.");
	$filas_perfil_accesos = mysqli_num_rows($sql_perfil_accesos);
	if($filas_perfil_accesos>0)
	{
		while($resul = mysqli_fetch_array($sql_perfil_accesos,MYSQLI_ASSOC))
		{
			$id_acs=$resul["id_acs"];
			$id_acs_plantilla=$resul["id_acs_plantilla"];
			$descrip_menu=$resul["descrip_menu"];
			$descrip_submenu=$resul["descrip_submenu"];
			$descrip_boton=$resul["descrip_boton"];
			$chk_activo_menu = isset($_POST[$id_acs_plantilla."-"."activo_menu"."-".str_replace(" ","",$descrip_menu)]) ? "S" : "N";
			$chk_activo_submenu = isset($_POST[$id_acs_plantilla."-"."activo_submenu"."-".str_replace(" ","",$descrip_submenu)]) ? "S" : "N";
			$chk_activo_boton = isset($_POST[$id_acs_plantilla."-"."activo_boton"."-".str_replace(" ","",$descrip_boton)]) ? "S" : "N";
			$sql_actualizar_perfil_accesos = "UPDATE perfil_accesos SET activo_menu='$chk_activo_menu', activo_submenu='$chk_activo_submenu', activo_boton='$chk_activo_boton' WHERE id_acs='$id_acs'";
			$resultado_actualizar_perfil_accessos = mysqli_query($Conexion, $sql_actualizar_perfil_accesos) or die("Error al modificar datos de perfil_accesos.");
		}
	}
	else { mensaje("No se encuentra los registros de accesos del perfil encontrado."); }
}
function mostrar_resultados_verificacion($Conexion,$perfil,&$id_acs_plantilla_encontrado)
{
	$sql_perfil_accesos_plantilla = mysqli_query($Conexion,"SELECT * FROM perfil_accesos_plantilla ORDER BY orden_menu ASC, orden_submenu ASC, orden_boton ASC") or die ("Error al traer los datos de la tabla perfil_accesos_plantilla.");
	$filas_perfil_accesos_plantilla = mysqli_num_rows($sql_perfil_accesos_plantilla);
	$sql_perfil_accesos_por_perfil = mysqli_query($Conexion,"SELECT * FROM perfil_accesos WHERE descrip_perfil='$perfil' ORDER BY orden_menu ASC, orden_submenu ASC, orden_boton ASC") or die ("Error al traer los datos de la tabla perfil_accesos.");
	$filas_perfil_accesos = mysqli_num_rows($sql_perfil_accesos_por_perfil);
	if ($filas_perfil_accesos_plantilla==$filas_perfil_accesos)
	{
		if ($filas_perfil_accesos_plantilla<>0)
		{
			// Revisa la igualdad de los datos de perfil_accesos_plantilla y los registros de perfil_accesos
			$contador_de_revision = 0;
			while($rs_perfil_accesos_plantilla = mysqli_fetch_array($sql_perfil_accesos_plantilla,MYSQLI_ASSOC))
			{
				$id_acs = $rs_perfil_accesos_plantilla["id_acs"];
				$descrip_menu = $rs_perfil_accesos_plantilla["descrip_menu"];
				$descrip_submenu = $rs_perfil_accesos_plantilla["descrip_submenu"];
				$descrip_boton = $rs_perfil_accesos_plantilla["descrip_boton"];
				mysqli_data_seek($sql_perfil_accesos_por_perfil,0);
				$contador_registro=0;
				while($rs_perfil_accesos_perfil = mysqli_fetch_array($sql_perfil_accesos_por_perfil,MYSQLI_ASSOC))
				{
					$id_acs_perfil=$rs_perfil_accesos_perfil["id_acs_plantilla"];
					$descrip_menu_perfil = $rs_perfil_accesos_plantilla["descrip_menu"];
					$descrip_submenu_perfil = $rs_perfil_accesos_plantilla["descrip_submenu"];
					$descrip_boton_perfil = $rs_perfil_accesos_plantilla["descrip_boton"];
					if ($id_acs==$id_acs_perfil AND $descrip_menu==$descrip_menu_perfil AND $descrip_submenu==$descrip_submenu_perfil AND $descrip_boton==$descrip_boton_perfil)
					{
						$contador_registro++;
						break;
					}
				}
				if ($contador_registro==0)
				{
					echo "El id ".$id_acs."->".$descrip_menu."->".$descrip_submenu."->".$descrip_boton." no es igual al encontrado en el registro del perfil de accesos. <br>";
					$contador_de_revision++;
				}
			}
			if ($contador_de_revision==0)
			{
				mensaje("La revisión no ha encontrado diferencias entre los registros del perfil maestro y el perfil de accesos.");
			}
			else
			{
				mensaje("La revisión ha encontrado diferencias entre los registros del perfil maestro y el perfil de accesos. Se recomienda verificar estos datos.");
			}
		}
		else
		{
			mensaje("El registro del perfil de accesos y la plantilla maestra están vacíos.");
		}
	}
	else
	{
		mensaje("Los registros del perfil de accesos son diferentes de la plantilla maestra.");
		// Revisa perfil_accesos_plantilla con registros de perfil_accesos
		if ($filas_perfil_accesos_plantilla>$filas_perfil_accesos)
		{
			while($rs_perfil_accesos_plantilla = mysqli_fetch_array($sql_perfil_accesos_plantilla,MYSQLI_ASSOC))
			{
				$id_acs_plantilla=$rs_perfil_accesos_plantilla["id_acs"];
				mysqli_data_seek($sql_perfil_accesos_por_perfil,0);
				$contador_registro=0;
				while($rs_perfil_accesos_perfil = mysqli_fetch_array($sql_perfil_accesos_por_perfil,MYSQLI_ASSOC))
				{
					$id_acs_perfil=$rs_perfil_accesos_perfil["id_acs_plantilla"];
					if ($id_acs_plantilla==$id_acs_perfil)
					{
						$contador_registro++;
						break;
					}
				}
				if ($contador_registro==0)
				{
					$descrip_menu = $rs_perfil_accesos_plantilla["descrip_menu"];
					$descrip_submenu = $rs_perfil_accesos_plantilla["descrip_submenu"];
					$descrip_boton = $rs_perfil_accesos_plantilla["descrip_boton"];
					echo "<b>El id ".$id_acs_plantilla." = ".$descrip_menu." -> ".$descrip_submenu." -> ".$descrip_boton."</b>, no se encuentra en el registro del perfil de accesos del perfil ".$perfil.". <br>";
					$id_acs_plantilla_encontrado=$id_acs_plantilla;
				}
			}
		}
		else
		{
			// Revisa perfil_accesos con registros de perfil_accesos_plantilla
			while($rs_perfil_accesos_perfil = mysqli_fetch_array($sql_perfil_accesos_por_perfil,MYSQLI_ASSOC))
			{
				$id_acs_perfil=$rs_perfil_accesos_perfil["id_acs_plantilla"];
				mysqli_data_seek($sql_perfil_accesos_plantilla,0);
				$contador_registro=0;
				while($rs_perfil_accesos_plantilla = mysqli_fetch_array($sql_perfil_accesos_plantilla,MYSQLI_ASSOC))
				{
					$id_acs_plantilla=$rs_perfil_accesos_plantilla["id_acs"];
					if ($id_acs_perfil==$id_acs_plantilla)
					{
						$contador_registro++;
						break;
					}
				}
				if ($contador_registro==0)
				{
					$descrip_menu = $rs_perfil_accesos_perfil["descrip_menu"];
					$descrip_submenu = $rs_perfil_accesos_perfil["descrip_submenu"];
					$descrip_boton = $rs_perfil_accesos_perfil["descrip_boton"];
					echo "El id ".$id_acs_perfil." = ".$descrip_menu." -> ".$descrip_submenu." -> ".$descrip_boton."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; no se encuentra en el registro del perfil maestro. <br>";
				}
			}
		}
	}
}
function actualizar_perfil_accesos_con_perfil_accesos_plantilla($Conexion,$id_acs_plantilla,$descrip_perfil)
{
	$sql_perfil_accesos_plantilla = mysqli_query($Conexion,"SELECT * FROM perfil_accesos_plantilla WHERE id_acs=$id_acs_plantilla") or die ("Error al traer los datos de la tabla perfil_accesos_plantilla.");
	$filas_perfil_accesos_plantilla = mysqli_num_rows($sql_perfil_accesos_plantilla);
	if($filas_perfil_accesos_plantilla>0)
	{
		$rs_perfil_accesos_plantilla = mysqli_fetch_array($sql_perfil_accesos_plantilla,MYSQLI_ASSOC);
		//Leer datos del registro de perfil_acceso_plantilla
		$id_acs = $rs_perfil_accesos_plantilla["id_acs"];
		$orden_menu = $rs_perfil_accesos_plantilla["orden_menu"];
		$descrip_menu = $rs_perfil_accesos_plantilla["descrip_menu"];
		$ruta_menu = $rs_perfil_accesos_plantilla["ruta_menu"];
		$activo_menu = $rs_perfil_accesos_plantilla["activo_menu"];
		$orden_submenu = $rs_perfil_accesos_plantilla["orden_submenu"];
		$descrip_submenu = $rs_perfil_accesos_plantilla["descrip_submenu"];
		$ruta_submenu = $rs_perfil_accesos_plantilla["ruta_submenu"];
		$activo_submenu = $rs_perfil_accesos_plantilla["activo_submenu"];
		$orden_boton = $rs_perfil_accesos_plantilla["orden_boton"];
		$descrip_boton = $rs_perfil_accesos_plantilla["descrip_boton"];
		$ruta_boton = $rs_perfil_accesos_plantilla["ruta_boton"];
		$activo_boton = $rs_perfil_accesos_plantilla["activo_boton"];
		//Insertar datos en perfil_accesos
		//echo $id_acs_plantilla,"|",$descrip_perfil,"<br>";
		//echo $id_acs, "|", $orden_menu, "|", $descrip_menu, "|", $ruta_menu, "|", $activo_menu, "|", $orden_submenu, "|", $descrip_submenu, "|", $ruta_submenu, "|", $activo_submenu, "|", $orden_boton, "|", $descrip_boton, "|", $ruta_boton , "|", $activo_boton, "<br>";
		$sql_insetar_perfil_accesos = "INSERT INTO perfil_accesos SET 
		id_acs_plantilla=$id_acs_plantilla,
		descrip_perfil='$descrip_perfil',
		orden_menu=$orden_menu, 
		descrip_menu='$descrip_menu', 
		ruta_menu='$ruta_menu', 
		activo_menu='$activo_menu', 
		orden_submenu=$orden_submenu, 
		descrip_submenu='$descrip_submenu', 
		ruta_submenu='$ruta_submenu', 
		activo_submenu='$activo_submenu', 
		orden_boton=$orden_boton, 
		descrip_boton='$descrip_boton', 
		ruta_boton='$ruta_boton', 
		activo_boton='$activo_boton'";
		$resultado_de_insertar_perfil_accesos = mysqli_query($Conexion, $sql_insetar_perfil_accesos) or die("Error al insertar datos en perfil_accesos.");
		return $resultado_de_insertar_perfil_accesos;
	}
}
?>