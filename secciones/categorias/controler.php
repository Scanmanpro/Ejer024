<?php session_start();
include '../../model/ccategorias.php';
$pagina="categorias_view.php";
$msg="";
try {
	if (isset($_GET["op"])) {
		$obj = new CCategorias();
		switch ($_GET["op"]) {
			case 1: //Insertar nueva categoria
                
				$obj->Insertar($_POST["categoria"]);
				if ($id<=0) {
					$msg="No se ha podido insertar la categoria";
				}
				break;
			case 2: //Actualizar categoria

				$total = $obj->Actualizar($_POST["id"], $_POST["categoria"]);
				if ($total<=0) {
					$msg="No se ha podido actualizar la categoria";
				}
				break;
			case 3: //Eliminar categoria
				$total = $obj->Eliminar($_GET["id"]);
				if ($total<=0) {
					$msg="No se ha podido eliminar la categoria";
				}
				break;
            case 4: //Filtrar categoria
				$categoria = $_POST['categoria'];
                echo $categoria;exit;
				if ($total<=0) {
					$msg="No se ha podido eliminar la categoria";
				}
				break;
		}
	}
} catch (Exception $e) {
	$msg=$e->getMessage();
	echo $msg;
}
header("Location:$pagina?msg=$msg");
?>