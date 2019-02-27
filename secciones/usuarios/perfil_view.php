<?php require "../header.php" ?>
<script>
var loadFile = function(event) {
    var output = document.getElementById('preview');
    output.src = URL.createObjectURL(event.target.files[0]);
  };
</script>
<style>
img[src=""] {
   display: none;
}
</style>
<div class="intranet_content">
	<h3 class="intranet_section_title">MI PERFIL</h3>
	<div class="intranet_section_table">
        <?php if (isset($_GET["msg"])) { ?>
			<div class="error"><?php echo $_GET["msg"]; ?></div>
		<?php }	?>
		<?php //Cargamos los datos del usuario actual:
		//Obtenemos de la session el id de usuario
		require "../../model/cusuarios.php";
		$obj = new CUsuarios();
		$obj->Cargar($_SESSION["id"]);

		//Mostramos un formulario para editar los datos actuales:
		?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<form name="form_editar" method="post" enctype="multipart/form-data" action="controller.php?op=5">
			<input type="hidden" name="id" value="<?php echo $obj->getID();?>"/>
			Tu nombre:<br/>
			<input type="text" name="nombre" value="<?php echo $obj->getNombre();?>"><br/>
			Tu email:<br/>
			<input type="text" name="email" value="<?php echo $obj->getMail();?>" disabled><br/>
            <p><input type="submit" value="Actualizar nombre"></p>
        </form>
        <form name"cambiar_password" method="post" enctype="multipart/form-data" action="controller.php?op=6">
			Tu password:<br/>
            <input type="text" name="password"><br/>
			<p><input type="submit" value="Actualizar password"></p>
		</form>
	</div>
</div>

<?php require "../footer.php" ?>