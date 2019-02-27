<?php
header("Content-Type: text/html;charset=utf-8");
$res=0;
$desc="";
$status=0;
try {
	$json = file_get_contents('php://input');
	if ($json) {
		$input = json_decode($json,true);
		$nombre = $input["nombre"];
		$email = $input["email"];
		$pass = $input["pass"];
		//Realizar la consulta a la bbdd:
		include("../model/cusuarios.php");
		$obj = new CUsuarios();
		$res = $obj->Insertar($nombre,$email,$pass);
		if ($res==0) {
			throw new Exception("No se ha podido insertar");
		}
		$status=200;
		$desc="Alta de usuario correcta";
	} else {
		throw new Exception("JSON null");
	}
} catch (Exception $e) {
	$status=500;
	$res=-1;
	$desc=$e->getMessage();
}
http_response_code($status);
$respuesta=array('res'=>$res,'desc'=>$desc);
echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
?>