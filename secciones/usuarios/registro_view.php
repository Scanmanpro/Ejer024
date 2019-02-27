<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="../../css/css_intranet.css">
</head>
<body>
	<div class="content">
		<h1>REGISTRO</h1>
		<?php if (isset($_GET["msg"])) { ?>
			<div class='error'><?php echo $_GET["msg"]; ?></div>
		<?php }	?>
		<form name="validar" method="post" action="controller.php?op=2">
			Introduce tu nombre:<br/>
			<input type="text" name="nombre" placeholder="Nombre"><br/>
			Introduce tu email:<br/>
			<input type="text" name="email" placeholder="Email"><br/>
			Introduce tu password:<br/>
			<input type="text" name="password" value="1234" placeholder="Password"><br/>
			<p><input type="submit" value="Validar"></p>
		</form>
		<div>
			Ya tienes cuenta? <a href="login_view.php">Identifícate</a>
		</div>
	</div>
	
</body>
</html>