<?php require "../header.php" ?>
<div class="intranet_content">
	<h3 class="intranet_section_title">Webs</h3>
	<div class="intranet_section_table">
		<p>Insertar una nueva web:</p>
		<form name="form_insert" method="post" action="controler.php?op=1">
			<div>
				<input type="text" name="web" size="30" required placeholder="Web">
                <input type="text" name="url_web" required size="30" placeholder="Url_web">
				<input type="submit" value="Añadir"/>
			</div>
		</form>
		<p>Lista de Webs</p>
		<?php 
		include "../../model/cwebs.php";
		//Comprobamos si se quiere editar una película:
		$p_edit_it = 0;
		if (isset($_GET["id"])) {
			$p_edit_it = $_GET["id"];
		}
		$obj = new CWebs();
		//Para la paginación:
		$tam_pag=4;
		$num_items = $obj->TotalWebs();

		//Comprobamos si hay que paginar:
		if ($num_items>$tam_pag) {
			//Obtenemos de la url en que página estoy:
			if (isset($_GET["pag"])) {
				$pag_act = $_GET["pag"];
			} else {
				$pag_act=1;
			}
			//Calculamos cuantas páginas hay:
			$num_pags = ceil($num_items / $tam_pag);
			//Según la página en la que estamos cargarmos las pelis:
			$inicio = ($pag_act-1)*$tam_pag;
		} else {
			$inicio=0;
		}
		$info = $obj->ListarPaginado($inicio, $tam_pag);

		?>
		<div style="padding:10px;">
			<table width="100%">
				<tr><td>WEB</td><td>URL</td><td></td><td></td></tr>
				<?php for ($i=0;$i<count($info);$i++) {
                    
					$p_id=$info[$i][0];	//Campo clave con el que distinguimos una web univocamente
					if ($p_id==$p_edit_it) { //Editamos directamente en la fila: ?>
						<form id="form_update" name="form_update" method="post" action="controler.php?op=2">
						<tr valign="top">

							<input hidden type="text" name="id" value="<?php echo $info[$i][0]; ?>"/>
							<td width="5%"><input type="text" name="web" value="<?php echo $info[$i][1]; ?>"/></td>
                            <td width="5%"><input type="text" name="url_web" value="<?php echo $info[$i][2]; ?>"/></td>

							<td width="1%"><a href="#" onclick="document.form_update.submit();" border="0"><img src="../../images/ic_save.png" width="24"/></a></td>
							<td width="1%"><a href="webs_view.php" border="0"><img src="../../images/ic_cancel.png" width="24"/></a></td>
						</tr>
						</form>
					<?php } else { ?>
					<tr class="info_peli">

                        <td><?php echo $info[$i][1]; ?></td>
                        <td><?php echo $info[$i][2]; ?></td>
						<td width="1%"><a href="webs_view.php?id=<?php echo $info[$i][0]; ?>" border="0"><img src="../../images/ic_edit.png" width="24"/></a></td>
						<td width="1%"><a href="controler.php?op=3&id=<?php echo $info[$i][0]; ?>" border="0"><img src="../../images/ic_delete.png" width="24"/></a></td>
					</tr>
					<?php } //If
				} //For?>
			</table>
		</div>
		<!-- Paginación -->
		<?php //Comprobamos si hay que paginar:
		if ($num_items>$tam_pag) {
			?>
			<div style="width:20%; margin: auto;">
				<?php for ($p=1;$p<=$num_pags;$p++) { 
					if ($p==$pag_act) {
						echo "<span style='margin:2px;'>$p</span>";
					} else {
							//Formato link:
						echo "<span style='margin:2px;'>
						<a href='webs_view.php?pag=$p'>$p</a>
						</span>";
					}

				} ?>
			</div>
			<?php } ?>
		</div>
	</div>

	<?php require "../footer.php" ?><!doctype html>
