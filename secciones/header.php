<?php session_start(); 
//Comprobar si existe una variable de session con us_id:
if (!isset($_SESSION["id"])) {
	header("Location:../usuarios/login_view.php?msg=Login necesario");
}
?>
<HTML>
<HEAD>
	<link rel="stylesheet" href="../../css/css_intranet.css">
</HEAD>
<BODY>
	<div class="intranet_header">
		<?php
		//Recogemos de la url, el nombre del usuario validado:
		$us_nombre = $_SESSION["nombre"];
		?>
		
		<div class="intranet_header_menu">
			<a href="../intranet/intranet_view.php">Inicio</a>
			<a href="../anuncios/anuncios_view.php">Anuncios</a>
            <a href="../categorias/categorias_view.php">Categorias</a>
            <a href="../webs/webs_view.php">Webs</a>
            <a href="../anuncios/controller.php?op=4">Estadisticas</a>
		</div>
		<div class="intranet_header_links">
			<a href="../usuarios/perfil_view.php">Ver mi perfil de usuario</a>
			<a href="../unlogin.php">Salir</a>
		</div>
	</div>