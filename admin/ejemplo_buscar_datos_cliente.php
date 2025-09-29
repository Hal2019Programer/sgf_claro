<?php
include("../library/funcionA.php"); include("../library/funcionB.php"); include("../library/datos.php");
conexiondb($Conexion);
$id_cli = $_GET['id'];
$consulta_datos_cliente=mysqli_query($Conexion,"SELECT * FROM clientes WHERE id_cli='$id_cli'");
if (mysqli_num_rows($consulta_datos_cliente)>0)
{
	$rs=mysqli_fetch_array($consulta_datos_cliente,MYSQLI_ASSOC);
	$id_cli=$rs["id_cli"];
	$nom_rzs_cli=$rs["nom_rzs_cli"];
    $dni_ruc_cli=$rs["dni_ruc_cli"];
    $direcc_cli=$rs["direcc_cli"];
    $tlfcel_cli=$rs["tlfcel_cli"];
}?>
<span>Id.Cliente:</span><input type="text" name="txt_id_cli" id="txt_id_cli" value="<?php echo $id_cli; ?>" style="width:50px;"><br>
<span>Nombre/Razón Social:</span><input type="text" name="txt_nom_rzs_cli" id="txt_nom_rzs_cli" value="<?php echo $nom_rzs_cli; ?>" style="width:300px;"><br>
<span>DNI/RUC:</span><input type="text" name="txt_dni_ruc_cli" id="txt_dni_ruc_cli" value="<?php echo $dni_ruc_cli; ?>" style="width:150px;"><br>
<span>Dirección:</span><input type="text" name="txt_direcc_cli" id="txt_direcc_cli" value="<?php echo $direcc_cli; ?>" style="width:300px;"><br>
<span>Teléfono:</span><input type="text" name="txt_telcel_cli" id="txt_telcel_cli" value="<?php echo $tlfcel_cli; ?>" style="width:150px;"><br>
