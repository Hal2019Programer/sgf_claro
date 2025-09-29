<?php
include("../library/funcionA.php"); include("../library/funcionB.php"); include("../library/datos.php");
conexiondb($Conexion);
$datos_filtro = $_POST['id'];
if (empty($datos_filtro)) {
    $datos_filtro = '1';
} else {
    $datos_filtro = "CONCAT(nom_rzs_cli,dni_ruc_cli,tlfcel_cli) LIKE '%$datos_filtro%'";
}
cmbfieldJs_span("spn_id_cli","cmb_id_cli",$Conexion,"SELECT * FROM clientes WHERE ".$datos_filtro." ORDER BY id_cli DESC LIMIT 100","","onchange=mostrar_mensaje();","id_cli","nom_rzs_cli","dni_ruc_cli");
?>
