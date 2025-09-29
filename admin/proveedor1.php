<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
$sql=mysqli_query($Conexion,"SELECT * FROM proveedores LIMIT 15");
if (isset($_GET['id'])) {
    $id_prv = $_GET['id'];
} else {
    $id_prv=null;
}
if (isset($_POST['botones'])) {
    $boton = $_POST['botones'];
    if ($boton == "Actualizar") {
        redireccion("proveedor1.php");
    }
}
?>
<style>
    .tabla1 {
        border: 1px solid rgb(0, 0, 0);
        border-collapse: collapse;
    }
    .tabla1 th {
        border: 1px solid rgb(0, 0, 0);
        background-color: rgb(0,0,0);
        color: rgb(255, 255, 255);
        text-align: center;
    }
    .tabla1 td {
        border: 1px solid rgb(0, 0, 0);
        text-align: center;
    }
</style>
<!DOCTYPE HTML>
<html>
	<body>
		<h1>Lista de Proveedores</h1>
        <form name="usuario" action="" method="post">
            <div><?php
            lblnorm("ID:",""); txtronstl("",$id_prv,"width:30px;"); spc(3); btnnormal("botones", "Actualizar"); ls();
            lblnorm("Nombre:",""); txtNrStJs("txt_nom_rzs_prv","","text",30,"width:300px;",""); spc(3);
            lblnorm("DNI/RUC:",""); txtNrStJs("txt_dni_ruc_prv","","text",11,"width:100px;",""); spc(3);
            lblnorm("Telf./Cel.:",""); txtNrStJs("txt_tlfcel_prv","","text",9,"width:90px;",""); spc(3);
            lblnorm("Dirección:",""); txtNrStJs("txt_direcc_prv","","text",15,"width:200px;",""); spc(3);
            lblnorm("Lugar:",""); txtNrStJs("txt_lug_prv","","text",15,"width:200px;",""); sl(1);
            lblnorm("Persona Contac.:",""); txtNrStJs("txt_prscont_prv","","text",15,"width:200px;",""); spc(3);
            lblnorm("Telf./Cel. Contac.:",""); txtNrStJs("txt_tlfcel_prscont_prv","","text",11,"width:90px;",""); spc(3);
            lblnorm("Fecha:",""); txtNrStJs("txt_fechreg_prv","","date",10,"width:100px;",""); spc(3);
            lblnorm("Usuario:",""); cmbfieldJs_span("spn_id_usr","cmb_id_usr",$Conexion,"SELECT * FROM usuarios WHERE activ_usr=1","","","id_usr","nomb_usr"); sl(1);?>
            </div><hr>
        </form>
        <?php
            tblanchovariable_05($Conexion,"","height:200px;",$sql,"tabla1","proveedor1.php",
            "ID:id_prv:50:idLink|",
            "Nombres:nom_rzs_prv:250:N",
            "DNI:dni_ruc_prv:80:N",
            "Telf.Cel:tlfcel_prv:85:N",
            "Dirección:direcc_prv:260:N",
            "Lugar:lug_prv:115:N",
            "Pers.Contac.:prscont_prv:115:N",
            "Telf.Cel.Contac.:tlfcel_prscont_prv:150:N",
            "Fecha:fechreg_prv:100:N",
            "Usuario:id_usr:110:N");?>
    </body>
</html>