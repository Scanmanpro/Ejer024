<?php session_start();
include '../../model/cwebs.php';
$pagina="webs_view.php";
$msg="";
try {
	if (isset($_GET["op"])) {
		$obj = new CWebs();
		switch ($_GET["op"]) {
			case 1: //Insertar nueva categoria
                
				$obj->Insertar($_POST["web"]);
				if ($id<=0) {
					$msg="No se ha podido insertar la Web";
				}
				break;
			case 2: //Actualizar categoria

				$total = $obj->Actualizar($_POST["id"], $_POST["web"], $_POST["url_web"]);
				if ($total<=0) {
					$msg="No se ha podido actualizar la Web";
				}
				break;
			case 3: //Eliminar categoria
				$total = $obj->Eliminar($_GET["id"]);
				if ($total<=0) {
					$msg="No se ha podido eliminar la Web";
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