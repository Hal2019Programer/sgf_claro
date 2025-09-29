<?php
include("../library/funcionA.php"); include("../library/funcionB.php"); include("../library/datos.php");
conexiondb($Conexion);
$dato = $_POST['id'];
$var2="";
cmbfieldJs_span("spn_busca_catalogo","cmb_busca_id_cat",$Conexion,"SELECT id_cat, tipo_cat, abrv_cat FROM catalogo WHERE activo_cat='S' AND abrv_cat LIKE '%$dato%'",$var2,"","id_cat","tipo_cat","abrv_cat");
?>