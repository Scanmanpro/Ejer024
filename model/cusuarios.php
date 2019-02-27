<?php
include_once 'cbbdd.php';
class CUsuarios extends CBBDD {
	//Atributos de la clase
	private $mID;
	private $mNombre;	
    	private $mMail;
    private $mPassword;
	private $WEB_ROOT="http://cursos.bymhost.com/anuncios";
	
	//Propiedades
	public function getID() {
		return $this->mID;
	}
	
	public function getNombre() {
		return $this->mNombre;
	}
	
	public function getMail() {
		return $this->mMail;
	}
    public function getPassword() {
		return $this->mPassword;
	}
	//Funciones de la clase
	public function __construct() {
		parent::__construct();
		$this->mID=0;
		$this->mNombre="";
		$this->mMail="";
        $this->mPassword="";
	}

	public function ramdonString($longitudPass=8){
	    //Se define una cadena de caractares. Te recomiendo que uses esta.
		$cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
	    //Obtenemos la longitud de la cadena de caracteres
		$longitudCadena=strlen($cadena);

	    //Se define la variable que va a contener la contrasena
		$pass = "";

    	//Creamos la contrasena
		for($i=1 ; $i<=$longitudPass ; $i++){
        //Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
			$pos=rand(0,$longitudCadena-1);

        //Vamos formando la contrasena en cada iteraccion del bucle, anadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
			$pass .= substr($cadena,$pos,1);
		}
		return $pass;
	}

	private function enviarMail($to, $subject, $msg){
		$enviado = false;
		try {
			// compose headers
			$headers = "From: admin@cursos.bymhost.com\r\n";
			$headers .= "Reply-To: admin@cursos.bymhost.com\r\n";
			$headers .= "X-Mailer: PHP/".phpversion();
			// compose message
			//$message = wordwrap($msg, 70);
			//La función mail, envía el email y devuelve True / False:
			$enviado = mail($to, $subject, $msg, $headers);
		} catch (Exception $e) {
			throw $e;
		}
		return $enviado;
	}
	
	//Inserta un nuevo usuario, devuelve su nuevo id si ok, -1 si no lo consigue: 
	public function Insertar($nombre, $mail, $pass) {
		$id = 0;
		try {
			$sql="Select count(*) as TOTAL from usuarios where email='$mail'";
			$total = $this->CT($sql);
			if ($total>0) {
				throw new Exception("Mail ya existente");
			}
			$enc_pass=md5($pass);
			//El mail no existe, creamos el token aleatorio de confirmación:
			$reg_token = $this->ramdonString(30);
			//Insertamos el nuevo usuario con su token de confirmación:
			$sql="insert into usuarios (nombre, email, password, reg_token, reg_conf) 
			values ('$nombre','$mail','$enc_pass','$reg_token','1')";
			$id = $this->CE($sql,true);
			if ($id>0) {
				//Enviamos el mail para confirmar el registro:
				$subject = "AnuncioLand: Confirmación de registro";
				$link = $this->WEB_ROOT."/secciones/usuarios/controller.php?op=4&token=$reg_token";
				$message = "Para finalizar el registro es necesario confirmar su correo. Por favor, pulse el siguiente link: $link";
				if (!$this->enviarMail($mail,$subject,$message)) {
					throw new Exception("No se ha podido enviar mail con nuevo pass");
					
				}
			}
		}catch (Exception $e) {
			throw $e;
		}
		return $id;
	}

	public function Actualizar($id,$nombre) {
		$res = 0;
		try {
            
            $sql="Update usuarios set nombre='$nombre' where id='$id'";
            $res = $this->CE($sql.false);
            
		} catch (Exception $e) {
			throw $e;
		}
		return $res;
	}

    public function ActualizarPassword($id,$password) {
		$res = 0;
		try {
            
            $sql="Update usuarios set password='$password' where id='$id'";
            $res = $this->CE($sql.false);
            
		} catch (Exception $e) {
			throw $e;
		}
		return $res;    
    }
	public function confirmarRegistro($reg_token) {
        //================================
		$id = 0; //Poner a 0 de normal
        //================================
		try {
			//Comprobamos si el reg_token pertenece a algún usuario:
			$sql = "Select id from usuarios where reg_token='$reg_token'";
			if ($this->CS($sql)) {
				if ($fila=$this->mDatos->fetch_assoc()) { 	
					//Existe un usuario con ese reg_token pdte de confirmar:
					$id=$fila["id"];
				}
				$this->mDatos->close();
			}
			//Si tenemos un id de usuario, es que existe en la bbdd, lo damos por confirmado:
			if ($id>0) {
				$sql = "update usuarios set reg_conf='1' where id='$id'";
				$total = $this->CE($sql,false);
				if ($total<=0) {
					//No se ha podido dar por confirmado el registro:
					throw new Exception("No se ha podido confirmar su registro, por favor reintente");
				}
			}
		} catch (Exception $e) {
			throw $e;
		}
		return $id;
	}

	//Comprueba mail y clave. Si es correcto obtiene el id del usuario (us_id), llama a las funciones CargarDatos($id)
	//Si no es correcto devuelve 0:
	public function Validar($mail,$pass) {
		$this->mID = 0;
		try {
			$enc_pass = md5($pass);
			$sql="Select * from usuarios where email='$mail' and password='$enc_pass'";
            
			if ($this->CS($sql)) {

				if ($fila=$this->mDatos->fetch_assoc()) { 	
					//Login correcto, obtenemos el código y nombre:
					$this->mID=$fila["id"];
					$this->mNombre=$fila["nombre"];
                    $this->mPassword=md5 ($fila["password"]);
				}
				$this->mDatos->close();
			}
		} catch (Exception $e) {
			throw $e;
		}
		return $this->mID;
	}

	public function TotalUsuarios(){
		$total = 0;
		try {
			$sql="Select count(*) as TOTAL from usuarios";
			$total = $this->CT($sql);
		} catch (Exception $e) {
			throw $e;
		}
		return $total;
	}
	
	//Devuelve la lista de usuarios según la condición
	public function Listar($condicion="") {
		$info=array();
		try {
			$sql="Select * from usuarios where id>0 $condicion";
			if ($this->CS($sql)) {
				$i=0;
				while ($fila=$this->mDatos->fetch_assoc()){
					$info[$i][0]=$fila["id"];
					$info[$i][1]=$fila["nombre"];
					$info[$i][2]=$fila["email"];
					//$info[$i][3]=$fila["us_foto"];
					$i++;
				}
				$this->mDatos->close();
			}
		} catch (Exception $e) {
			throw new Exception($sql);
		}
		return $info;
	}
	
	//Devuelve la lista de usuarios según la condición
	public function Cargar($id) {
		try {
			$sql="Select * from usuarios where id=$id";
			if ($this->CS($sql)) {
				if ($fila=$this->mDatos->fetch_assoc()){
					$this->mID=$fila["id"];
					$this->mNombre=$fila["nombre"];
					$this->mMail=$fila["email"];
				}
				$this->mDatos->close();
			}
		} catch (Exception $e) {
			throw new Exception($sql);
		}
	}

	public function __destruct() { 
		try {

		} catch (Exception $e) {
			throw $e;
		}
	}

	
}
?>