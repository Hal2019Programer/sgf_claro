<?php
include("../library/funcionA.php"); include("../library/funcionB.php"); include("../library/datos.php");
conexiondb($Conexion);
//Recibir en la variable id, el dato o la cadena de datos desde XMLHttpRequest (Ajax)
$id_pro = $_POST['id'];
//Verifica si el producto tiene datos en la tabla productos
$consulta_producto=mysqli_query($Conexion,"SELECT tipo_cat, clase_cat, zona_pro, precio_pro FROM productos WHERE id_pro=$id_pro");
$precio="";
if (mysqli_num_rows($consulta_producto)>0)
{
	$resultado=mysqli_fetch_array($consulta_producto, MYSQLI_ASSOC);
	$campo=$resultado["tipo_cat"];
	//Verifica si el producto es Juego u otro
	if ($campo=="Juego")
	{
		//Verifica si hay datos de saldo en la tabla stock_juegos
		$zona=$resultado["zona_pro"];
		$resul_saldo_stkjg=mysqli_query($Conexion,"SELECT saldo_stkjg, min_stkjg FROM stock_juego WHERE zona_stkjg='$zona' ORDER BY id_stkjg DESC LIMIT 1");
		if (mysqli_num_rows($resul_saldo_stkjg)==0)
		{
			$saldo_stkjg=0;
			$mensaje="Sin saldo";
			$estado="Falso";
		}
		else
		{
			$datos_stock=mysqli_fetch_array($resul_saldo_stkjg,MYSQLI_ASSOC);
			$saldo_stkjg=$datos_stock["saldo_stkjg"];
			$min_stkjg=$datos_stock["min_stkjg"];
			if ($min_stkjg=="S")
			{
				$mensaje="El saldo es mínimo, debe recargarse antes de continuar. S/ ".$saldo_stkjg;
				$estado="Falso";
			}
			else
			{
				$mensaje="Saldo S/ ".$saldo_stkjg;
				$estado="Verdadero";
			}
		}
		$precio = $resultado["precio_pro"];
	}
	else
	{
		$mensaje="";
		$estado="Verdadero";
	}
}
else
{
	$mensaje="Sin datos del producto";
	$estado="Falso";
}
txtronstl("txt_mensaje_stock_juego", $mensaje, "height:20px;");
txtoculto("txt_estado_stock_juego", $estado);
txtoculto("txt_precio_juego", $precio);
?>