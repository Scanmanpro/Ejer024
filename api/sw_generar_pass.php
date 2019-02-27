<?php 
include '../model/cusuarios.php';
header("content-Type: text/html;carset=utf-8");
$res=0;
$desc="";
$status=0;
try{
	$json = file_get_contents('php://input');
	if ($json){
		$input=json_decode($json,true);
		$email=$input["email"];
		
		$obj = new CUsuarios();
		$desc=$obj->Generar_Pass($email);
		$res=1;
		$status=200;
	}else{
		throw new Exception("JSON null");
	}
}catch (Exception $e){
	$status=451;
	$res=-1;
	$desc=$e->getMessage();
}

http_response_code($status);
$respuesta=array('res'=>$res,'desc'=>$desc);
echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
?>