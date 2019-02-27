<?php session_start();
include '../../model/canuncios.php';
$pagina="anuncios_view.php";
$msg="";
try {
	if (isset($_GET["op"])) {
		$obj = new CAnuncios();
		switch ($_GET["op"]) {
			case 1: //Insertar nuevo anuncio

				$id = $obj->Insertar($_POST["producto"], $_POST["precio"], $_POST["precio_alto"], $_POST["precio_chollo"], $_POST["categoria"], $_POST["foto"], $_POST["web"], $_SESSION["id"]);
				if ($id<=0) {
					$msg="No se ha podido insertar el anuncio";
				}
				break;
			case 2: //Actualizar anuncio

				$total = $obj->Actualizar($_POST["id"], $_POST["producto"], $_POST["precio"], $_POST["precio_alto"], $_POST["precio_chollo"], $_POST["id_categoria"], $_POST["foto"], $_POST["id_web"], $_SESSION["id"]);
				if ($total<=0) {
					$msg="No se ha podido actualizar el anuncio";
				}
				break;
			case 3: //Eliminar anuncio
				$total = $obj->Eliminar($_GET["id"]);
				if ($total<=0) {
					$msg="No se ha podido eliminar el anuncio";
				}
				break;
            case 4: //Contar anuncios por valoraciones
                
                $_SESSION['total'] = $obj->TotalAnuncios2();
                $_SESSION['chollo'] = $obj->TotalAnuncios2("where precio<=precio_chollo");
                $_SESSION['correcto'] = $obj->TotalAnuncios2("where precio>precio_chollo and precio<precio_alto");
                $_SESSION['caro'] = $obj->TotalAnuncios2("where precio>=precio_alto");
                $pagina="stats_view.php";
                break;
		}
	}
} catch (Exception $e) {
	$msg=$e->getMessage();
	echo $msg;
}

header("Location:$pagina?msg=$msg");
?>