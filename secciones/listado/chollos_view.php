<?php require "../header_listado.php" ?>
<div class="intranet_content">
    
	<h3 class="intranet_section_title">MEJORES CHOLLOS</h3>
	<div class="intranet_section_table">

		<?php
        include "../../model/cwebs.php";
        $web = new CWebs();

        include "../../model/ccategorias.php";
        $cat = new CCategorias();

		include "../../model/canuncios.php";

		$obj = new CAnuncios();

        $chollo = $obj->Chollo();
        

		?>

		<div style="padding:10px;">
			<table width="100%">
				<tr><td>FOTO</td>
                <td>PRODUCTO</td>
                <td>PRECIO</td>
                <td>CATEGORIA</td>
                <td>VALORACION</td>
                <td>WEB</td></tr>
                <tr>
				<?php 
                $infocat = $cat->Listar();
                
                $i=0;

                while (sizeof($chollo)>$i){
                    $id = $infocat[$i][0];
                    

                ?>
				<td><img src="<?php echo $chollo[$i][1]; ?>" width="75"/></td>
                <td><?php echo $chollo[$i][2]; ?></td>
				<td><?php echo $chollo[$i][3]; $w= $chollo[$i][8];?></td>
                <td><?php $cat->Cargar($id); echo $cat->getCategoria($id); ?></td>
                <td>CHOLLO</td>
                <td><a href="<?php $web->Cargar($w); echo $web->getUrl($w);?>" target="blank"><?php echo $web->getWeb($w); ?></a></td></tr><?php
                    
                    $i++; 
                } ?>

			</table>
		</div>

        <p align="center"><a href="../listado/listado_view.php">Volver</a>  </p>
		</div>
	</div>

	<?php require "../footer.php" ?>