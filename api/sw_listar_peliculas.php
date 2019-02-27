<?php
header("Content-Type: text/html;charset=utf-8");
$status=0;
$respuesta=array();
try {
	$json = file_get_contents('php://input');
	if ($json) {
		$input = json_decode($json,true);
		//$filtro = $input["filtro"];
		//Realizar la consulta a la bbdd:
		include("../model/cpeliculas.php");
		$obj = new CPeliculas();
		$respuesta = $obj->ListarWS();
		$status=200;
	} else {
		throw new Exception("JSON null");
	}
} catch (Exception $e) {
	$status=500;
}
http_response_code($status);
echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
?>