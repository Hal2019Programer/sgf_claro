<?php
include("library/funcionA.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Inicio de sesión</title>
		<meta charset="UTF-8" http-equiv="Content-Type" content="text/html"> 
		<link rel="stylesheet" type="text/css" href="estilos/estilo.css">
	</head>
	<body>
	<header><?php
		cabecera04(1,"Sistema de Gestión Comercial");?>
	</header>
		<form action="login.php" method="post"><br>
			<center>
					<header><h1 style="color:var(--color-azul-heli);">INICIAR SESIÓN</h1></header>
					<article class="bienvenidos">Bienvenidos</article>
					<section class="seccion">
						<table>
							<tr style="vertical-align:baseline;">
								<td><label style="color:red; font-weight:bold;">Usuario:</label></td>
								<td><input type="text" name="usuario" placeholder="Ingrese su usuario" size="30"></td>
								<td style="vertical-align:top;"><img src="imagenes/foto-perfil-2(a).png" style="width:35px; height:35px; margin-top:-1px;"></td>
							</tr>
							<tr style="vertical-align:baseline;">
								<td><label style="color:red; font-weight:bold;">Contraseña:&nbsp;</label></td>
								<td><input type="password" name="pass" maxlength="12" placeholder ="Ingrese su contraseña" size="30"></td>
								<td style="vertical-align:top;"><img src="imagenes/lock-24-512(a).png" style="width: 28px; height:28px; margin-top:2px;margin-left:4px;"></td>
							</tr>
						</table>
						<br>
						<input id="enviar" type="submit" value="Entrar" class="input_azul_heli">
						<input id="enviar" type="reset"  value="Limpiar" class="input_azul_heli">
					</section><br><br><br
			</center>
		</form>
	</body>
	<br>
	<footer id="footer">
		<article style="text-align:left; font-weight:bold; color:var(--color-azul-heli); margin-left:10px;">
			<?php echo razon_social_year;?>
		</article>
		<article>
			<a href="https://www.facebook.com"><img class="fc" src="imagenes/fc.png"></a>
		</article>
		<article>
			<a href="https://twitter.com"><img class="tw" src="imagenes/twitter.png"></a>
		</article>
		<article>
			<a href="https://www.youtube.com/channel/UCP74oUAv-VffjHNRdG8fBsA"><img class="you" src="imagenes/youtube.png"></a>
		</article>
		<article>
			<a href="https://plus.google.com/u/0/108056266145437364233"><img class="goo" src="imagenes/Black_GooglePlus_SquareIcon-300x300.png"></a>
		</article>
	</footer>
</html>