<?php
header("Content-Type: text/html;charset=utf-8");
$res=0;
$desc="";
$status=0;
try {
	$json = file_get_contents('php://input');
	if ($json) {
		$input = json_decode($json,true);
		$email = $input["email"];
		$pass = $input["pass"];
		//Realizar la consulta a la bbdd:

		include("../model/cusuarios.php");
		$obj = new CUsuarios();
		$res = $obj->Validar($email,$pass);
		if ($res==0) {
			throw new Exception("Login incorrecto");
		}
		$status=200;
		$desc="Login correcto";
	} else {
		throw new Exception("JSON null");
	}
} catch (Exception $e) {
	$status=451;
	$res=-1;
	$desc=$e->getMessage();
}
http_response_code($status);
$respuesta=array('res'=>$res,'desc'=>$desc);
echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
?>