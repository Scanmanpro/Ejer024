<?php require "../header.php" ?>
<div class="intranet_content">
	<h3 class="intranet_section_title">ANUNCIOS</h3>
	<div class="intranet_section_table">
		<p>Insertar una nuevo anuncio:</p>

		<form name="form_insert" method="post" action="controller.php?op=1">
			<div>
				<input type="text" name="producto" size="40" required placeholder="Nombre del producto">
				<input type="text" name="precio" size="8" required placeholder="Precio">
                <input type="text" name="precio_alto" size="8" required placeholder="Precio alto">
                <input type="text" name="precio_chollo" size="8" required placeholder="Precio chollo">

                <select name="categoria" id="categoria" required>
                    <option selected disabled>Categoria</option>
                    
                <!--Mostramos las categorias con nombres ordenado alfabeticamente-->
                <?php
                    include "../../model/ccategorias.php";
                    $cat = new CCategorias();
                    $infocat = $cat->Listar();
                    $i=0;
                    while (sizeof($infocat)>$i){
                    $cat->Cargar($infocat[$i][0]);?>
                    <option value="<?php echo $cat->getID(); ?>"><?php echo $cat->getCategoria(); ?></option>   
                <?php
                    $i++;
                }?>
                </select>
                
                <select name="web" id="web" required>
                    <option selected disabled>WEB</option>
                <!--Mostramos las categorias con nombres ordenado alfabeticamente-->
               
                <?php
                    include "../../model/cwebs.php";
                    $web = new CWebs();
                    $infoweb = $web->Listar();
                    $i=0;
                    while (sizeof($infoweb)>$i){
                    $web->Cargar($infoweb[$i][0]);?>
                    <option value="<?php echo $web->getID(); ?>"><?php echo $web->getWeb(); ?></option>   
                <?php
                    $i++;
                }?>
                </select><br>
                
                URL de la foto: <input type="text" name="foto">
                <input type="number" name="id_usuario" value="<?php $_SESSION[$id]?>" hidden>
                
            </div>
			<div>
				<input type="submit" value="Añadir"/>
			</div>
		</form>
		<p>Lista de anuncios</p>
		<?php 
		include "../../model/canuncios.php";
		//Comprobamos si se quiere editar una película:
		$p_edit_it = 0;
		if (isset($_GET["id"])) {
			$p_edit_it = $_GET["id"];
		}
		$obj = new CAnuncios();
		//Para la paginación:
		$tam_pag=4;
		$num_items = $obj->TotalAnuncios($_SESSION["id"]);
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
				<tr><td>FOTO</td><td>PRODUCTO</td><td>PRECIO</td>
                    <?php if (isset($_GET["id"])) {
                        echo ("<td>PRECIO ALTO</td><td>PRECIO CHOLLO</td>");
                    } ?>   
                    <td>CATEGORIA</td><td>VALORACION</td><td>WEB</td></tr>
				<?php for ($i=0;$i<count($info);$i++) {
					$p_id=$info[$i][0];	//Campo clave con el que distinguimos una pelicula univocamente
                    
					if ($p_id==$p_edit_it) { //Editamos directamente en la fila: ?>
						<form id="form_update" name="form_update" method="post" action="controller.php?op=2">
						    <input type="hidden" name="id" value="<?php echo $info[$i][0]; ?>"/>
                            <input type="hidden" name="foto" value="<?php echo $info[$i][1]; ?>"/>
						    <tr valign="top">

                            <td width="10%"><input type="text" name="foto" size=5 value="<?php echo $info[$i][1]; ?>" width="24"/></td>
							<td width="10%"><input type="text" name="producto" placeholder="Producto" value="<?php echo $info[$i][2]; ?>"/></td>
							<td width="5%"><input type="number" name="precio" style="width: 5em;" value="<?php echo $info[$i][3]; ?>"/></td>
							<td width="5%"><input type="number" name="precio_alto" style="width: 5em;" value="<?php echo $info[$i][4]; ?>"/></td>
							<td width="5%"><input type="number" name="precio_chollo" style="width: 5em;" value="<?php echo $info[$i][5]; ?>"/></td>
                            <td width="10%">
                              <select name="id_categoria" id="id_categoria">

                            <!--Mostramos las categorias con nombres-->
                            <?php
                            $j=0;
                                            
                            while (sizeof($infocat)>$j){
                                $id_cat = $infocat[$j][0];
                                  $cat->Cargar($id_cat);
                                  ?>
                                
                                <option <?php if ($info[$i][6]==$cat->getID()){ echo " selected "; }   ?>value="<?php echo $cat->getID(); ?>"><?php echo $cat->getCategoria();$j++;} ?></option>   
                                </select></td>
                            <td width="10%"><?php echo $info[$i][7]; ?></td>
                            <td width="10%">
                                
                            <select name="id_web" id="id_web">
                                <option selected disabled>WEB</option>
                            <!--Mostramos las webs con nombres-->
                            <?php
                            $j=0;
                                            
                            while (sizeof($infoweb)>$j){
                                $id_web = $infoweb[$j][0];
                                  $web->Cargar($id_web);
                                  ?>
                                
                                <option <?php if ($info[$i][8]==$web->getID()){ echo " selected "; }   ?>value="<?php echo $web->getID(); ?>"><?php echo $web->getWeb();$j++;} ?></option>   
                                </select></td>

						  <td width="1%"><a href="#" onclick="document.form_update.submit();" border="0"><img src="../../images/ic_save.png" width="24"/></a></td>
							<td width="1%"><a href="anuncios_view.php" border="0"><img src="../../images/ic_cancel.png" width="24"/></a></td>
						</tr>
						</form>
					<?php } else { ?>
					<tr class="info_peli">
						<td><img src="<?php echo $info[$i][1]; ?>" width="75"/></td>
                        <?php $cat->Cargar($info[$i][6]); ?>
                        <?php $web->Cargar($info[$i][8]); ?>
						<td><?php echo $info[$i][2]; ?></td>
						<td><?php echo $info[$i][3]; ?></td>
                        <td><?php echo $cat->getCategoria(); ?></td>
						<td><?php echo $info[$i][7]; ?></td>
                        <td><?php echo $web->getWeb(); ?></td>

						<td width="1%"><a href="anuncios_view.php<?php echo "?pag=$pag_act&id=" . $info[$i][0]; ?>" border="0"><img src="../../images/ic_edit.png" width="24"/></a></td>
						<td width="1%"><a href="controller.php?op=3<?php echo "?pag=$pag_act&id=" . $info[$i][0]; ?>" border="0"><img src="../../images/ic_delete.png" width="24"/></a></td>
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
						<a href='anuncios_view.php?pag=$p'>$p</a>
						</span>";
					}

				} ?>
			</div>
			<?php } ?>
		</div>
	</div>

	<?php require "../footer.php" ?>