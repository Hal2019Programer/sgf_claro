<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
$ambito_busqueda="Todo";
$cadenasql=$_GET["v1"];
?>
<!DOCTYPE HTML>
<?php
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=archivo.xls");
?>
<html>
	<head><?php	pestanna_01($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Catálogo");?></head>
	<body>
		<div id="main-col2" style="padding:15px; margin-left:5px">
			<div style="font-size:10px"><?php nombre_comercial_empresa()?> : <?php echo gmdate("j F Y, g:i a",time()+3600*(-6+date("I")));?></div>
			<center><h2 style="color:#0A2C4F">Lista del catálogo</h2></center> 
			<?php
			$sql_catalogo= mysqli_query ($Conexion,$cadenasql) or die ("Error al traer los datos");
			tblanchovariable_01($Conexion,"margin-left:0px;",$sql_catalogo,$ambito_busqueda,
			"ID:id_cat:50:N",
			"Tipo:tipo_cat:70:N",
			"Clase:clase_cat:80:N",
			"Modelo:modelo_cat:85:N",
			"Marca:marca_cat:100:N",
			"Fecha:fechreg_cat:115:N",
			"Usuario:id_usr:160:valfield|usuarios|nomb_usr|id_usr",
			"Abreviado:abrv_cat:150:N");
			scroll_doble("div1", "div2");
			?>
		</div>
	</body>
</html>