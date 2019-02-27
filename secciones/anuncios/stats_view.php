<?php require "../header.php" ?>
<div class="intranet_content">
	<h3 class="intranet_section_title">ESTADISTICAS</h3>
	<div class="intranet_section_table">

		<?php 
		include "../../model/canuncios.php";
		//Comprobamos si se quiere editar una película:

		

		?>

		<div style="padding:10px;">
			<table width="100%">
                <tr><td>TOTAL DE ANUNCIOS DISPONIBLES: <?php echo $_SESSION['total']; ?></td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr><td>Precio chollo: <?php echo $_SESSION['chollo']; ?></td></tr>
                <tr><td>Precio normal: <?php echo $_SESSION['correcto']; ?></td></tr>
                <tr><td>Precio alto: <?php echo $_SESSION['caro']; ?></td></tr>
                    
		</div>
	</div>

	<?php require "../footer.php" ?>