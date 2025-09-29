<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
$ancho=950;
$id_cat=$tipo_cat=$clase_cat=$modelo_cat=$marca_cat=$fechreg_cat=$id_usr=$abrv_cat=$activo_cat=$v_filtro_activo_cat="";
$numreg=0;
$resultado_perfil_accesos = Null; $datos = array();
cargar_datos_perfil($Conexion,$ident_usuario,"Catálogo",$resultado_perfil_accesos,$datos,$categ_usuario,$nivel_usuario,$zona_usuario);
verificar_procesos_de_boton($resultado_perfil_accesos);
//Datos para cargar id de registro y buscar automaticamente
$variable_idLink="";
cargar_id_busqueda($variable_idLink);
?>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Catálogo");?></head>
	<body>
		<div style="width:1024px;">
			<?php cabecera04(0,"Gestión de Catálogo"); menu02(); sl(1);?>
			<!--<center><h1 style="margin-block:auto;">Lista del catálogo</h1></center><hr>-->
			<?php
			$sql= mysqli_query ($Conexion,"SELECT * FROM catalogo")	or die ("Error al traer los datos de catalogo.");
			$filas_catalogo=mysqli_num_rows($sql);
			$tabla=array(array()); obtener_matriz($sql,$tabla,$filas);
			date_default_timezone_set("America/Lima");
			if (empty($fechreg_cat)) $fechreg_cat=date("d-m-Y");
			if(isset($_POST["btnGrl"]))
			{
				$btn=$_POST["btnGrl"];
				$bus=$_POST["txtbus"];
				if($btn=="Buscar")
				{
					if ($bus<>"")
					{
						$numreg=busca_id($tabla,$filas,$bus);
						if($numreg>=0)
						{	
							mysqli_data_seek($sql, $numreg); 
							$resul=mysqli_fetch_array($sql,MYSQLI_ASSOC);
							$id_cat=$resul["id_cat"];
							$tipo_cat=$resul["tipo_cat"];
							$clase_cat=$resul["clase_cat"];
							$modelo_cat=$resul["modelo_cat"];
							$marca_cat=$resul["marca_cat"];
							$fechreg_cat=invFech($resul["fechreg_cat"],"-");
							$id_usr=$resul["id_usr"];
							$abrv_cat=$resul["abrv_cat"];
							$activo_cat=$resul["activo_cat"];
							echo "<input type='hidden' name='txt_opcion_buscar' id='txt_opcion_buscar' value='1'/>\n";
						}
						else
						{
							echo "<script> alert('No se encuentra el registro.'); </script>";
						}
					}
					else
					{
						echo "<script> alert('Falta el id para la búsqueda de registros.'); location.href = 'catalogo.php'; </script>";
					}
				}
				if($btn=="Filtrar")
				{
					$where_sql="";
					$filtro_sql="";
					$filtro_activo="";
					$filtro=$_POST["txtfiltro"];
					$filtro_activo_cat=$_POST["cmb_filtro_activo"];
					if (!empty($filtro) OR !empty($filtro_activo_cat))
					{
						if (!empty($filtro))
						{
							$separa_datos=explode(" ", $filtro);
							for ($i=0; $i<count($separa_datos); $i++)
							{
								$where_sql=$where_sql."tipo_cat LIKE '%$separa_datos[$i]%' OR";
								$where_sql=$where_sql." modelo_cat LIKE '%$separa_datos[$i]%' OR";
								$where_sql=$where_sql." clase_cat LIKE '%$separa_datos[$i]%' OR";
								$where_sql=$where_sql." marca_cat LIKE '%$separa_datos[$i]%'";
								$filtro_sql=$filtro_sql."(".$where_sql.") AND ";
								$where_sql="";
							}
						}
						if (!empty($filtro_activo_cat))
						{
							$filtro_activo=$where_sql."activo_cat='$filtro_activo_cat' AND ";
						}
						$filtro_sql=$filtro_sql.$filtro_activo;
						$filtro_sql="SELECT * FROM catalogo WHERE ".substr($filtro_sql,0,strlen($filtro_sql)-4);
						$sql=mysqli_query($Conexion,$filtro_sql)	or die ("Error al filtrar los datos de catalogo.");
					}
					$filas_catalogo=mysqli_num_rows($sql);
				}
				if($btn=="Agregar")
				{
					$idc=$_POST["txtid"];
					$tpc=$_POST["cmbtpc"];
					$clc=$_POST["cmbclc"];
					$mrc=$_POST["txtmrc"];
					$mdc=$_POST["txtmdc"];
					$activo_cat=$_POST["cmbact"];
					$fch=invFech($_POST["txtfch"],"-");
					if ($tpc<>"" && $clc<>"" && $mdc<>"" && !empty($mrc) && !empty($fch) && !empty($activo_cat))
					{
						$consulta_existentes="SELECT id_cat FROM catalogo WHERE tipo_cat='$tpc' AND clase_cat='$clc' AND marca_cat='$mrc' AND modelo_cat='$mdc'";
						$registros = mysqli_query($Conexion, $consulta_existentes) or die("Error al consultar datos de catalogo para productos existentes.");
						$cantidad = mysqli_num_rows($registros);
						if ($cantidad>0)
						{
							echo "<script> alert('El registro que intenta añadir ya existe.'); location.href = 'catalogo.php'; </script>";
						}
						else
						{
							mysqli_query ($Conexion,"INSERT INTO catalogo (tipo_cat, clase_cat, modelo_cat, marca_cat, fechreg_cat, id_usr, abrv_cat, activo_cat) VALUES ('".$tpc."','".$clc."','".$mdc."','".$mrc."','".$fch."','".$ident_usuario."','".$clc." ".$mdc." ".$mrc."','".$activo_cat."')") or die("Error al agregar datos a catalogo.");
							echo "<script> alert('Se insertó correctamente los datos.'); location.href = 'catalogo.php'; </script>";
						}
					}
					else
					{
						echo "<script> alert('No hay datos para agregar registros.'); location.href = 'catalogo.php'; </script>";
					}
				}
				if ($btn=="Modificar")
				{
					$idc=$_POST["txtid"];//id_cat
					$tpc=$_POST["cmbtpc"];//tipo_cat
					$clc=$_POST["cmbclc"];//clase_cat
					$mdc=$_POST["txtmdc"];//modelo_cat
					$mrc=$_POST["txtmrc"];//marca_cat
					$activo_cat=$_POST["cmbact"];
					$fch=$fch=invFech($_POST["txtfch"],"-");//fechreg_cat
					if ($tpc<>"" && $clc<>"" && $mdc<>"")
					{
						$cadena_sql = "UPDATE catalogo SET tipo_cat='$tpc', clase_cat='$clc', modelo_cat='$mdc', marca_cat='$mrc', fechreg_cat='$fch', id_usr='$ident_usuario', abrv_cat='$clc $mdc $mrc', activo_cat='$activo_cat' WHERE id_cat=$idc";
						mysqli_query($Conexion, $cadena_sql) or die("Error al modificar datos de catalogo.");
						echo "<script> alert('Se modificó correctamente los datos.'); location.href = 'catalogo.php'; </script>";
						$idc=$tpc=$clc=$mdc=$mrc=$fch="";
					}
					else
					{
						echo "<script> alert('No hay datos para modificar registros.'); location.href = 'catalogo.php'; </script>";
					}
				}
				if($btn=="Eliminar")
				{
					$nrg=$_POST["txtnumreg"];
					$id=$_POST["txtid"];
					if ($nrg<>"" && $id<>"")
					{
						$cadena_count_sql = "SELECT COUNT(*) FROM productos WHERE id_cat=$id";
						$rcb = mysqli_query($Conexion, $cadena_count_sql);
						$reg = mysqli_fetch_array($rcb);
						$cantidad = $reg[0];
						if ($cantidad>0)
						{
							echo "<script> alert('No se puede eliminar!, existen registros del catálogo en la tabla productos...'); location.href = 'catalogo.php'; </script>";
						}
						else
						{
							$cadena_sql = "DELETE FROM catalogo WHERE id_cat=$id";
							$rsb = mysqli_query($Conexion, $cadena_sql);
							echo "<script> alert('Borrado de registro efectuado, actualizando datos...'); location.href = 'catalogo.php'; </script>";
							$sql = mysqli_query ($Conexion,"SELECT * from catalogo") or die ("Error al traer los datos de catalogo.");
							$tabla=array(array());
							obtener_matriz($sql,$tabla,$filas);
						}
					}
					else
					{
						echo "<script> alert('No hay datos de registro para borrar'); location.href = 'catalogo.php'; </script>";
					}
				}
				if($btn=="Actualizar")
				{
					echo "<script> location.href = 'catalogo.php'; </script>";
				}
				if($btn=="Exportar")
				{
					exportar();
				}
			}
			else
			{
				echo "<input type='hidden' name='txt_opcion_buscar' id='txt_opcion_buscar' value='0'/>\n";
			}
			?>
			<form name="usuario" action="" method="post"><span id="etq2">Buscar ID:</span>
				<?php if (activar_boton($datos,$resultado_perfil_accesos,"Buscar")) { ?> <input type="text" name="txtbus"/>&nbsp;<input type="submit" name="btnGrl"  value="Buscar"/> <?php } ?>
				<input type="text" name="txtfiltro" placeholder="Grupo Tipo Modelo Marca"/>
				<?php cmbnormal("cmb_filtro_activo", $v_filtro_activo_cat, "S", "N");?>
				<?php if (activar_boton($datos,$resultado_perfil_accesos,"Filtrar")) { ?> <input type="submit" name="btnGrl" value="Filtrar"/> <?php } ?>
				<!--<input type="button" value="T" onclick="tamanno_ventana();">-->
				<br><hr>
				<input type="hidden" name="txtnumreg" value="<?php echo $numreg; ?>"/>
				<div>
					<div id="colizq" style=" float:left; width:30%;">
						<div><span id="etq4">ID:&nbsp;</span><input type="text" name="txtid" style="background:rgb(189, 195, 184); width:80px;" readonly="readonly" value="<?php echo $id_cat?>"/></div>
						<div><span id="etq4">Grupo:&nbsp;</span><?php 
						cmbfieldJs("div_select_grupo","cmbtpc",$Conexion,"SELECT desc_tipo_prosrv FROM tipo_prod_serv WHERE activo_tipo_prosrv='S'",$tipo_cat,"onchange=\"CambiarValor('cmbtpc','cmbclc','txtmrc','txtmdc','cmbact')\";","desc_tipo_prosrv");
						?></div>
						<div><span id="etq4">Tipo:&nbsp;</span><?php 
						cmbfieldJs("div_select_tipo","cmbclc",$Conexion,"SELECT desc_clase_prosrv FROM clase_prod_serv WHERE activo_clase_prosrv='S'",$clase_cat,"onchange=\"CambiarValor('cmbtpc','cmbclc','txtmrc','txtmdc','cmbact')\";","desc_clase_prosrv");
						?></div>
					</div>
					<div id="colder" style=" float:left; width:35%;">
						<div><span id="etq4">Marca:&nbsp;</span><input type="text" name="txtmrc" value="<?php echo $marca_cat?>" onchange="CambiarValor('cmbtpc','cmbclc','txtmrc','txtmdc','cmbact');"></div>
						<div><span id="etq4">Modelo:&nbsp;</span><input type="text" name="txtmdc" value="<?php echo $modelo_cat?>" onchange="CambiarValor('cmbtpc','cmbclc','txtmrc','txtmdc','cmbact');"></div>
						<div><span id="etq4">Fecha:&nbsp;</span><input type="text" name="txtfch"  value="<?php echo $fechreg_cat?>"/></div>
					</div>
					<div id="colders"  style=" float:left; width:35%;">
						<div><span id="etq4">Activo:</span><?php cmbNormJs("div_select_activo","cmbact", $activo_cat, "onchange=\"CambiarValor('cmbtpc','cmbclc','txtmrc','txtmdc','cmbact')\";", "S", "N");?></div>
					</div>
				</div>
				<div style="clear:both"></div>
				<hr>
				<div style="padding-left:10px;">
				<?php if (activar_boton($datos,$resultado_perfil_accesos,"Agregar")) { ?> <input type="submit" name="btnGrl" value="Agregar"/> <?php } ?>
				<?php if (activar_boton($datos,$resultado_perfil_accesos,"Modificar")) { ?> <input type="submit" name="btnGrl" value="Modificar"/> <?php } ?>
				<?php if (activar_boton($datos,$resultado_perfil_accesos,"Eliminar")) { ?> <input type="submit" name="btnGrl" value="Eliminar"/> <?php } ?>
				<?php if (activar_boton($datos,$resultado_perfil_accesos,"Actualizar")) { ?> <input type="submit" name="btnGrl" value="Actualizar"/> <?php } ?>
				<?php if ($ident_usuario==2 OR $ident_usuario==77) { ?> <input type="submit" name="btnGrl" value="Exportar"/> <?php } ?>
				</div>
				<br><hr>
			</form>
			<div id="lista_datos_catalogo">
				<?php
				echo "Cantidad de registros: ".$filas_catalogo;
				tblanchovariable_05($Conexion,"margin-left:10px;","height:210px;",$sql,"tblnormal","catalogo.php",
				"ID:id_cat:25:idLink|",
				"Grupo:tipo_cat:75:N",
				"Tipo:clase_cat:80:N",
				"Modelo:modelo_cat:170:N",
				"Marca:marca_cat:80:N",
				"Fecha:fechreg_cat:80:N",
				"Abreviado:abrv_cat:300:N",
				"Activo:activo_cat:45:N");
				?>
			</div>
		</div>
		<div style="clear:both"></div>
		<div class="piepag">
			<?php pie_pagina();?>
		</div>
	</body>
</html>
<script type="text/javascript">
	function CambiarValor(id_tag_grupo,id_tag_tipo,id_tag_marca,id_tag_modelo,id_tag_activo)
	{
		var opcion_buscar_activo = objId("txt_opcion_buscar").value;
		if (opcion_buscar_activo==="0")
		{
			var valor_grupo = objId(id_tag_grupo).options[objId(id_tag_grupo).selectedIndex].value;
			var valor_tipo=objName(id_tag_tipo)[0].value;
			var valor_marca=objName(id_tag_marca)[0].value;
			var valor_modelo=objName(id_tag_modelo)[0].value;;
			var valor_activo = objId(id_tag_activo).options[objId(id_tag_activo).selectedIndex].value;
			var dato = valor_grupo + "|" + valor_tipo + "|" + valor_marca + "|" + valor_modelo + "|" + valor_activo;
			muestraDatos("lista_datos_catalogo", dato, "catalogo.busca_grupo.php");
		}
	}
	function objId(ident_Id) { return document.getElementById(ident_Id); }
	function objName(ident_Id) { return document.getElementsByName(ident_Id); }
	function tamanno_ventana()
	{
		var windowWidth = window.innerWidth;
		var windowHeight = window.innerHeight;
		alert("Tamaño de ventana:\n" + "Ancho: " + windowWidth + "\n" + "Alto: " + windowHeight);
	}
</script>
<?php
inicializa_funcion_busca_datos_Ajax();
function exportar()
{
	$consulta="SELECT * FROM catalogo ORDER BY tipo_cat ASC, clase_cat ASC";?>
	<script type="text/javascript">
		cadena="<?php echo $consulta;?>";
		window.open("catalogo_e.php?v1="+cadena,"_blank");
	</script> <?php
}
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