<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
conexiondb($Conexion);
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
verificar_codcpg_rvi($Conexion);
$desc_per=valfield($Conexion,"usuarios","desc_per","id_usr",$ident_usuario);
$sql_perfil_accesos  ="SELECT * FROM perfil_accesos WHERE descrip_perfil='$desc_per' AND activo_menu='S' GROUP BY descrip_menu, descrip_submenu ORDER BY orden_menu ASC, orden_submenu";
$resultado_perfil_accesos = mysqli_query ($Conexion,$sql_perfil_accesos) or die ("Error al traer los datos de consulta de perfil de accesos.");
$datos = ["id_usr" => $ident_usuario, "categ_usr" => $categ_usuario, "nivel_usr" => $nivel_usuario, "zona_usr" => $zona_usuario,	"desc_per" => $desc_per];
// Verificar y conectar a la base de datos 'sgf_claro'
/*$resultado_consulta_bd=mysqli_query($Conexion,"SELECT DATABASE()") or die("Error al consultar la base de datos de Claro.");
if (mysqli_num_rows($resultado_consulta_bd)>0) {
	$resultado=mysqli_fetch_array($resultado_consulta_bd, MYSQLI_ASSOC);
	$base_datos=$resultado["DATABASE()"];
	if ($base_datos!="sgf_claro")
		mensaje("La base de datos actual es: ".$base_datos.". Por favor, cambie a la base de datos 'sgf_claro'.");
	else
		mensaje("Conectado a la base de datos 'sgf_claro'."); }
else {
	mensaje("No se ha encontrado la base de datos 'sgf_claro'.");
}*/
?>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Menú");?></head>
	<body>
		<header><?php
			cabecera04(0,"Sistema de Gestión Comercial"); ?>
		</header>
		<div id="menu"><br>
			<ul class="nav"> <?php
			if (activar_menu($resultado_perfil_accesos,"Inicio",$datos))
			{ ?>				
				<li><a style='margin-left:15px;' href='menugeneral.php'>Inicio</a></li><?php
			}
			if (activar_menu($resultado_perfil_accesos,"Maestro",$datos))
			{ ?>				
				<li><a href='menugeneral.php'>Maestro</a>
					<ul> <?php 
					//activar_submenu($resultado_perfil_accesos,"Maestro","Usuarios","<li><a href='javascript:abrirventana();'>Usuarios</a></li>",$datos);
					activar_submenu($resultado_perfil_accesos,"Maestro","Usuarios","<li><a href='../usuario/usuarios.php'>Usuarios</a></li>",$datos);
					activar_submenu($resultado_perfil_accesos,"Maestro","Usuarios","<li><a href='../admin/catalogo.php'>Catálogo</a></li>",$datos);
					//activar_submenu($resultado_perfil_accesos,"Maestro","Catálogo","<li><a href='javascript:abrirventana1();'>Catálogo</a></li>",$datos);
					activar_submenu($resultado_perfil_accesos,"Maestro","Perfil","<li><a href='../usuario/perfil.php'>Perfil</a></li>",$datos);	?>
					</ul>
				</li><?php
			}
			if (activar_menu($resultado_perfil_accesos,"Comunicaciones",$datos,$datos))
			{ ?>				
				<li><a href='menugeneral.php'>Comunicaciones</a>
					<ul> <?php 
					//activar_submenu($resultado_perfil_accesos,"Comunicaciones","Planes","<li><a href='javascript:abrirventana2();'>Planes</a></li>",$datos);
					activar_submenu($resultado_perfil_accesos,"Comunicaciones","Planes","<li><a href='../admin/planes.php'>Planes</a></li>",$datos); ?> 
					</ul>
				</li><?php
			}
			if (activar_menu($resultado_perfil_accesos,"Procesos",$datos))
			{ ?>				
				<li><a href='menugeneral.php'>Procesos</a>
					<ul> <?php 
					activar_submenu($resultado_perfil_accesos,"Procesos","Anular Comprobantes","<li><a href='../admin/anularcp.php'>Anular Comprobantes</a></li>",$datos);
					activar_submenu($resultado_perfil_accesos,"Procesos","Mantenimiento de comprobantes","<li><a href='../admin/mantcomp.php'>Mantenimiento de comprobantes</a></li>",$datos);
					activar_submenu($resultado_perfil_accesos,"Procesos","Comprobantes electrónicos","<li><a href='../admin/archivosXML.php'>Comprobantes electrónicos (Facturador ONLINE)</a></li>",$datos);
					activar_submenu($resultado_perfil_accesos,"Procesos","Comprobantes enviados a SUNAT","<li><a href='../admin/comprobantes_enviados_a_SUNAT.php'>Comprobantes enviados a SUNAT</a></li>",$datos); ?>
					</ul>
				</li><?php
			}
			if (activar_menu($resultado_perfil_accesos,"Compras",$datos))
			{ ?>				
				<li><a href='menugeneral.php'>Compras</a>
					<ul> <?php
					activar_submenu($resultado_perfil_accesos,"Compras","Proveedor","<li><a href='../admin/proveedor.php'>Proveedor</a></li>",$datos);
					activar_submenu($resultado_perfil_accesos,"Compras","Caja Chica","<li><a href='cajachica.php'>Caja Chica</a></li>",$datos); ?>
					</ul>
				</li><?php
			}
			if (activar_menu($resultado_perfil_accesos,"Ventas",$datos))
			{ ?>					
				<li><a href='menugeneral.php'>Ventas</a>
					<ul> <?php
					activar_submenu($resultado_perfil_accesos,"Ventas","Cliente","<li><a href='../admin/clientes.php'>Cliente</a></li>",$datos);
					activar_submenu($resultado_perfil_accesos,"Ventas","Registro de Ventas","<li><a href='../admin/regventas.php'>Registro de Ventas</a></li>",$datos);
					activar_submenu($resultado_perfil_accesos,"Ventas","Ventas Caja","<li><a href='../admin/regvtacaja.php'>Ventas Caja</a></li>",$datos);
					activar_submenu($resultado_perfil_accesos,"Ventas","Pagos Diversos","<li><a href='../admin/pagosdiv.php'>Pagos Diversos</a></li>",$datos); ?>
					</ul>
				</li><?php
			}
			if (activar_menu($resultado_perfil_accesos,"Reporte",$datos))
			{ ?>				
				<li><a href='menugeneral.php'>Reporte</a>
					<ul> <?php 
					activar_submenu($resultado_perfil_accesos,"Reporte","Reporte de Ventas","<li><a href='../admin/reporte01.php'>Reporte de Ventas</a></li>",$datos);
					activar_submenu($resultado_perfil_accesos,"Reporte","Reporte de Caja","<li><a href='../admin/reporte02.php'>Reporte de Caja</a></li>",$datos);
					activar_submenu($resultado_perfil_accesos,"Reporte","Reporte de Productos","<li><a href='../admin/reporte03.php'>Reporte de Productos</a></li>",$datos);
					activar_submenu($resultado_perfil_accesos,"Reporte","Reporte de Transferencias","<li><a href='../admin/reporte04.php'>Reporte de Transferencias</a></li>",$datos);
					activar_submenu($resultado_perfil_accesos,"Reporte","Cuadre de Caja","<li><a href='../admin/cuadrecaja.php'>Cuadre de Caja</a></li>",$datos); ?>
					</ul>
				</li> <?php
			}
			if (activar_menu($resultado_perfil_accesos,"Almacén",$datos))
			{ ?>				
				<li><a href='menugeneral.php'>Almacén</a>
					<ul> <?php
					activar_submenu($resultado_perfil_accesos,"Almacén","Productos","<li><a href='../admin/productos.php'>Productos</a></li>",$datos);
					activar_submenu($resultado_perfil_accesos,"Almacén","Transferencias","<li><a href='../admin/transfprod.php'>Transferencias</a></li>",$datos);
					activar_submenu($resultado_perfil_accesos,"Almacén","Kardex","<li><a href='../admin/kardex.php'>Kardex</a></li>",$datos);
					activar_submenu($resultado_perfil_accesos,"Almacén","Saldo Juegos","<li><a href='../admin/gestion_stock_juego.php'>Saldo Juegos</a></li>",$datos);
					activar_submenu($resultado_perfil_accesos,"Almacén","Guía de Remisión","<li><a href='../admin/guia_remision.php'>Guía de Remisión</a></li>",$datos); ?>
					</ul>
				</li> <?php
			}
			if (activar_menu($resultado_perfil_accesos,"Salir",$datos))
			{ ?>				
				<li><a href='../cerrar_sesion.php'>Salir</a></li> <?php 
			} ?>				
			</ul>
		</div><br>
		<section>
			<table style="width:100%; height:500px; background-color:var(--color-azul-heli); border-radius:10px; border: thin solid white; margin-right:0px; padding:10px;">
				<tr>
					<td style="width:35%;">
						<a href="menugeneral.php">
							<section  style="width:500px; height:370px; float:left; text-align:justify; padding:10px; margin-top:35px;">
								<img style="width:500px; height:370px; margin-top:-10px; border-radius: 10px;" src="../imagenes/fondo_menu_01.png">
							</section>
						</a>
					</td>
					<td style="width:64%; vertical-align:top;">
						<article>
							<h2 style="color:white; margin-left:10px; font-size:32px;">Bienvenido <?php echo $names_usuario." ".$apellido_usuario." "; ?></h2>
						</article>
						<article class="textomenu" style="margin-left:10px; color:white; width:250px;">
							<br>
							<p>&#8226 <a href="http://www.ecositi.com.pe/" target="_blank" style="color:white; text-decoration:auto;">Página pricipal ECO SITI S.A.C</a></p>
							<p>&#8226 <a href="http://www.ecositi.com.pe/" target="_blank" style="color:white; text-decoration:auto;">Claro Home</a></p>
							<p>&#8226 <a href="http://www.ecositi.com.pe/cpanel/" target="_blank" style="color:white; text-decoration:auto;">Correo Institucional</a></p>
							<hr style ="color:white; margin-left:245px; margin-right:633px; height:120px; margin-top:-120px"></hr>
						</article>
						<article ID ="textomenu" style="color:white; -size:15px; margin-left:2px; margin-right:-10px">
							<br>
							<p><b>TELEFONOS :</b><br>900564390 / 907774886</p>
							<p><b>DIRECCIONES :</b><br>Jr. Progreso 256 - San Ramon - Chanchamayo</p>
						</article>
					</td>
				</tr>
			</table>
			<article class="piepag">
			<b>Copyright - Derechos reservados de <?php echo razon_social_empresa?> - 2025</b>
			</article>
		</section>
	</body>
</html>
<script>
function abrirventana() 
{
  ancho=screen.width;
  alto=screen.height;
  izquierda=(ancho-950)/2-30;
  superior=(alto-450)/2-10;
  window.open("../usuario/usuarios.php", "", "width=950, height=450, left="+izquierda+", top="+superior+",  menubar=No, resizable=no status=no, scrollbars=No");//No usar toolbar=yes
}
</script>
<script>
function abrirventana1() 
{
  ancho=screen.width;
  alto=screen.height;
  izquierda=(ancho-952)/2;
  superior=((alto-640)/2)-10;
  window.open("../admin/catalogo.php", "", "width=952, height=640, left="+izquierda+", top="+superior+",  menubar=No, resizable=no status=no, scrollbars=No");//No usar toolbar=yes
}
</script>
<script>
function abrirventana2() 
{
  ancho=screen.width;
  alto=screen.height;
  izquierda=(ancho-950)/2-30;
  superior=(alto-450)/2-10;
  window.open("../admin/planes.php", "", "width=950, height=450, left="+izquierda+", top="+superior+",  menubar=No, resizable=no status=no, scrollbars=No");//No usar toolbar=yes
}
</script>
<script>
function abrirventana3() 
{
  ancho=screen.width;
  alto=screen.height;
  izquierda=(ancho-950)/2-30;
  superior=(alto-450)/2-10;
  window.open("../admin/proveedor.php", "", "width=950, height=450, left="+izquierda+", top="+superior+",  menubar=No, resizable=no status=no, scrollbars=No");//No usar toolbar=yes
}
</script>
<?php
function activar_sbm($Conexion,$ruta,$submenu_usuario,$categ_usuario,$nivel_usuario)
{
	if ($categ_usuario=="Prog" AND $nivel_usuario=="tot")
	{
		echo $ruta;
	}
	else
	{
		$consulta_sql_niveles="SELECT * FROM niveles WHERE submenu='$submenu_usuario' AND categoria='$categ_usuario' AND nivel='$nivel_usuario'";
		$resultado_sql_niveles=mysqli_query ($Conexion,$consulta_sql_niveles) or die ("Error al traer los datos de consulta de niveles.");
		if (mysqli_num_rows($resultado_sql_niveles)>0)
		{
			$r=mysqli_fetch_array($resultado_sql_niveles,MYSQLI_ASSOC);
			$submenu=$r["submenu"];
			$categoria=$r["categoria"];
			$nivel=$r["nivel"];
			echo $ruta;
		}
		else
		{
			// echo $consulta_sql_niveles;
			// mensaje("No se ha encontrado los registros.");
			// mensaje($consulta_sql_niveles);
		}
	}
}
function verificar_codcpg_rvi($Conexion)
{
	$resultado_regvtacaja_codcpg=mysqli_query($Conexion,"SELECT MAX(codcpg_rvi) AS ultimo_codcgp_regvtacaja FROM regvtacaja") or die ("Error al obtener el maximo valor de codcpg_rvi de regvtacaja.");
	if (mysqli_num_rows($resultado_regvtacaja_codcpg)>0)
	{
		$resultado=mysqli_fetch_array($resultado_regvtacaja_codcpg, MYSQLI_ASSOC);
		$ultimo_valor_codcpg_regvtacaja=$resultado["ultimo_codcgp_regvtacaja"];
		//mensaje($ultimo_valor_codcpg_regvtacaja);
	}
	$resultado_codcomprb_codcpg=mysqli_query($Conexion,"SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='".base_datos."' AND TABLE_NAME='codcomprb'") or die ("Error al consultar el ultimo valor de memoria de AUTO_INCREMENT de codcomprb.");
	if (mysqli_num_rows($resultado_codcomprb_codcpg)>0)
	{
		$resultado=mysqli_fetch_array($resultado_codcomprb_codcpg, MYSQLI_ASSOC);
		$ultimo_valor_codcpg_codcomprb=$resultado["AUTO_INCREMENT"];
		//mensaje($ultimo_valor_codcpg_codcomprb);
	}
	if ($ultimo_valor_codcpg_regvtacaja>$ultimo_valor_codcpg_codcomprb)
	{
		$nuevo_valor_autoincremento=$ultimo_valor_codcpg_regvtacaja+1;
		mysqli_query($Conexion,"ALTER TABLE codcomprb AUTO_INCREMENT=".$nuevo_valor_autoincremento) or die ("Error al actualizar la variable AUTO_INCREMENT en codcomprb.");
		mensaje("Actualizando el codigo de comprobante de caja.");
	}
}
function activar_menu($resultado_perfil_accesos,$menu,$datos)
{
	$id_usr = $datos["id_usr"];
	$categ_usr = $datos["categ_usr"];
	$nivel_usuario = $datos["nivel_usr"];
	$zona_usuario = $datos["zona_usr"];
	$desc_per = $datos["desc_per"];
	if ($id_usr==2 OR ($categ_usr=="Prog" AND $nivel_usuario=="tot") OR ($categ_usr=="Prog" AND $zona_usuario=="Total") OR $desc_per=="Total")
	{
		return true;
	}
	else
	{
		$registros_de_menu_activo=0;
		mysqli_data_seek($resultado_perfil_accesos,0);
		while($resul = mysqli_fetch_array($resultado_perfil_accesos,MYSQLI_ASSOC))
		{
			$descrip_menu=$resul["descrip_menu"];
			$activo_menu=$resul["activo_menu"];
			if ($descrip_menu=="$menu")
			{
				if ($activo_menu=="S")
				{
					$registros_de_menu_activo++;
				}
			}
		}
		if ($registros_de_menu_activo>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	// return true;
}
function activar_submenu($resultado_perfil_accesos,$menu,$submenu,$ruta,$datos)
{
	$id_usr = $datos["id_usr"];
	$categ_usr = $datos["categ_usr"];
	$nivel_usuario = $datos["nivel_usr"];
	$zona_usuario = $datos["zona_usr"];
	$desc_per = $datos["desc_per"];
	if ($id_usr==2 OR ($categ_usr=="Prog" AND $nivel_usuario=="tot") OR ($categ_usr=="Prog" AND $zona_usuario=="Total") OR $desc_per=="Total")
	{
		echo $ruta."\n";
	}
	else
	{
		mysqli_data_seek($resultado_perfil_accesos,0);
		while($resul = mysqli_fetch_array($resultado_perfil_accesos,MYSQLI_ASSOC))
		{
			$descrip_menu=$resul["descrip_menu"];
			$activo_menu=$resul["activo_menu"];
			$descrip_submenu=$resul["descrip_submenu"];
			$activo_submenu=$resul["activo_submenu"];
			if ($descrip_menu==$menu)
			{
				if ($activo_menu=="S")
				{
					if ($descrip_submenu==$submenu)
					{
						if ($activo_submenu=="S")
						{
							echo $ruta."\n";
							break;
						}
					}
				}
			}
		}
	}
}
?>