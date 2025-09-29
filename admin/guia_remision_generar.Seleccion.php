<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
$ambito_busqueda="Normal";
muestraDatos_x_innerHTML_Js();
?>
<script>
	function enviar_datos(id_producto)
	{
		//window.opener ejecuta en la ventana padre ('guia_remision_generar.php') la función muestraDatos_x_innerHTML(id, cadena, archivo), 
		//donde carga el id del elemento de la ventana padre 'lista' (<div style="width:80%;" id="lista">) que es donde se va a recibir el
		//resultado del envío de datos mediante AJAX al archivo 'guia_remision_tmp.busca_producto.php', en este caso envia 'id_producto',
		//y en el archivo 'guia_remision_tmp.busca_producto.php' se procesa la consulta y se muestra mediante echo el resultado que se carga
		//en el <div id='lista'>
		window.opener.muestraDatos_x_innerHTML("lista", id_producto, "guia_remision_tmp.busca_producto.php");
		window.close();
	}
	function filtrar_lista()
	{
		id="tabla_seleccionProductos";
		var txt_desc=document.getElementById("txt_desc").value;
		var txt_imei=document.getElementById("txt_imei").value;
		var txt_icc=document.getElementById("txt_icc").value;
		var txt_zona=document.getElementById("txt_zona").value;
		var txt_tipo=document.getElementById("txt_tipo").value;
		var txt_clase=document.getElementById("txt_clase").value;
		var datos=txt_desc+":"+txt_imei+":"+txt_icc+":"+txt_zona+":"+txt_tipo+":"+txt_clase;
		muestraDatos_x_innerHTML(id,datos,"guia_remision_generar.Seleccion.Filtro.php")
	}
	function cerrar_ventana()
	{
		window.close();
	}
</script>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Seleccion Productos");?></head>
	<!--<body onblur="self.close()" >-->
	<!--<body onblur="cerrar_ventana()">-->
		<?php
		if (($categ_usuario=="Prog") OR ($categ_usuario=="Gern")) 
		{	
			$sql= mysqli_query ($Conexion,"SELECT * FROM productos WHERE activ_pro=1 ORDER BY id_pro DESC LIMIT 10") or die ("Error al traer los datos de productos."); 
		}
		else 
		{ 
			$sql= mysqli_query ($Conexion,"SELECT * FROM productos WHERE (activ_pro=1) AND (zona_pro='$zona_usuario') ORDER BY id_pro DESC LIMIT 10") or die ("Error al traer los datos de productos."); 
		}
		?>
		<div style="width:95%; padding:2%; margin-left:0.5%; margin-right:0.5%">
			<?php cabecera04(0,"Guía de Remisión - Selección de Productos");sl(1);?>
			<!--<h1><center>Selección de productos</center></h1><br>-->
			<form name="usuario" action="" method="post">
				<table border=1 class="tblreporte01" style="width:100%; border-collapse:collapse; border-color:RGB(200,200,240);">
					<tr>
						<th>Descripción</th>
						<th>IMEI</th>
						<th>ICC</th>
						<th>Zona</th>
						<th>Tipo</th>
						<th>Clase</th>
					</tr>
					<tr>
						<?php $styl01="width:100%; height:20px;"; ?>
						<td><?php txtNrStJs("txt_desc","","text","",$styl01,"onkeyup='filtrar_lista()';");?></td>
						<td><?php txtNrStJs("txt_imei","","text","",$styl01,"onkeyup='filtrar_lista()';");?></td>
						<td><?php txtNrStJs("txt_icc","","text","",$styl01,"onkeyup='filtrar_lista()';");?></td>
						<td><?php txtNrStJs("txt_zona","","text","",$styl01,"onkeyup='filtrar_lista()';");?></td>
						<td><?php txtNrStJs("txt_tipo","","text","",$styl01,"onkeyup='filtrar_lista()';");?></td>
						<td><?php txtNrStJs("txt_clase","","text","",$styl01,"onkeyup='filtrar_lista()';");?></td>
					</tr>
				</table><hr>
			</form>
			<div id="tabla_seleccionProductos">
			<?php tblanchovariable_06($Conexion,"margin-left:0px;","height:315px;",$sql,"tblreporte01","guia_remision_tmp.busca_producto.php",
				"ID:id_pro:50:idLink|",
				"Descripción:abrv_pro:196:N",
				"Imei:imei_pro:145:N",
				"Icc:icc_pro:145:N",
				"Zona Origen:zona_pro:100:N",
				"Tipo:tipo_cat:80:N",
				"Clase:clase_cat:90:N",
				"Fecha:fechreg_pro:80:invFech|",
				"Activo:activ_pro:60:N",
				"Precio:precio_pro:100:N",
				"Monto Actual:ultreg_pro:100:N"); ?>
			</div>
		</div>
	</body>
</html>

