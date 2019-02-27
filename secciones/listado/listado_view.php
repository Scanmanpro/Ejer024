<?php require "../header_listado.php" ?>
<div class="intranet_content">
	<h3 class="intranet_section_title">ANUNCIOS</h3>
	<div class="intranet_section_table">
		<p>Filtrar por categorias:</p>
		<form name="form_insert" method="post" action="listado_view.php">
			<div>
                <input type="text" name="cantidad" id="cantidad" hidden>
                <select name="categoria" id="categoria">
                    <option selected disabled>Categoria</option>
                    <!--Mostramos las categorias con nombres en un select-->
                    <?php
                        
                        include "../../model/ccategorias.php";
                        $cat = new CCategorias();
                        $infocat = $cat->Listar();
                        $total = $cat->TotalCategorias();

                        $i=0;
                        while (sizeof($infocat)>$i){
                        $id = $infocat[$i][0];
                        $cat->Cargar($id);
                        $categoria=-1;
                        if (isset($_POST["categoria"])){
                            $num_cat=$_POST["categoria"];
                            $num_items = sizeof($infocat);
                        }else{
                            $num_cat="";
                        }
                        ?>
                            <option <?php if ($num_cat==$cat->getID()){echo "selected ";}?> value="<?php echo $cat->getID(); ?>"><?php echo $cat->getCategoria(); ?></option>   
                        <?php
                        $i++;
                        }
                        ?>
                </select>
                <input type="submit" value="Filtrar"/>
                <a href="listado_view.php" ><input type="button" value="Ver todo"/></a>
            </div>
			<div>
				
			</div>
		</form>
		<p>Lista de anuncios</p>
		<?php 
		include "../../model/canuncios.php";
		//Comprobamos si se quiere editar una película:
		$p_edit_it = 0;
        //Para la paginación:
        $tam_pag=4;

		$obj = new CAnuncios();
		
        //Si he llegado la cantidad de objetos se asigna a $num_items sino se calcula
        if (isset($_POST["categoria"])){
            $num_cat=$_POST["categoria"];
            $condicion = "where id_categoria='$num_cat'";
            $num_items = $obj->TotalAnuncios2($condicion);

        }else{

            $num_items = $obj->TotalAnuncios2();
            

        }
            

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
        if (isset($_POST["categoria"])){
            $categoria = $_POST["categoria"];

            $condicat = "where id_categoria='$categoria'";
        }else{
            $condicat = "";
        }

		$info = $obj->ListarPaginado2($inicio, $tam_pag, $condicat);
       
		?>
        <!--Mostramos las webs con nombres-->
        <?php
            include "../../model/cwebs.php";
            $web = new CWebs();
        ?>
		<div style="padding:10px;">
			<table width="100%">
				<tr><td>FOTO</td>
                <td>PRODUCTO</td>
                <td>PRECIO</td>
                <td>CATEGORIA</td>
                <td>VALORACION</td>
                <td>WEB</td></tr>
				<?php for ($i=0;$i<count($info);$i++) {
					$p_id=$info[$i][0];	//Campo clave con el que distinguimos una categoria univocamente
					$web->Cargar($info[$i][8]);
                    $nWeb = $web->getWeb();
                    $cat->Cargar($info[$i][6]);
                   
				?>
					<tr class="info_peli">
						<td><img src="<?php echo $info[$i][1]; ?>" width="75"/></td>
						<td><?php echo $info[$i][2]; ?></td>
						<td><?php echo $info[$i][3]; ?></td>
                        <td><?php echo $cat->getCategoria(); ?></td>
						<td><?php echo $info[$i][7]; ?></td>
                        <td><a href="<?php echo $web->getUrl();?>" target="blank"><?php echo $web->getWeb(); ?></a></td>

						
					</tr>
					<?php } //If
				 //For?>
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
						<a href='listado_view.php?pag=$p'>$p</a>
						</span>";
					}

				} ?>
			</div>
			<?php } ?>
        
		</div>
	</div>

	<?php require "../footer.php" ?>