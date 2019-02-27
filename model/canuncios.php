<?php
include_once 'cbbdd.php';
class CAnuncios extends CBBDD {
	//Atributos de la clase
	private $mID;
	private $mProducto;	
	private $mPrecio;
    private $mPrecio_alto;
    private $mPrecio_chollo;
    private $mID_categoria;
    private $mURL_foto;
    private $mID_url_web;
    private $mValoracion;
    private $mID_usuario;
	private $WEB_ROOT="http://cursos.bymhost.com/anuncios";
	
	//Propiedades
	public function getID() {
		return $this->mID;
	}
	
	public function getProducto() {
		return $this->mProducto;
	}
	
	public function getPrecio() {
		return $this->mPrecio;
	}
    public function getPrecio_alto() {
		return $this->mPrecio_alto;
	}
    public function getPrecio_chollo() {
		return $this->mPrecio_chollo;
	}
    public function getID_categoria() {
		return $this->mID_categoria;
	}
    public function getURL_foto() {
		return $this->mURL_foto;
	}
    public function getID_url_web() {
		return $this->mID_url_web;
	}
    public function getID_usuario() {
		return $this->mID_usuario;
	}
    public function getValoracion() {
		return $this->mValoracion;
	}
	//Funciones de la clase
	public function __construct() {
		parent::__construct();
		$this->mID=0;
		$this->mProducto="";
		$this->mPrecio="";
        $this->mPrecio_alto="";
        $this->mPrecio_chollo="";
        $this->mID_categoria="";
        $this->mURL_foto="";
        $this->mValoracion="";
        $this->mID_url_web="";
        $this->mID_usuario="";
	}


	//Inserta un nuevo anuncio, devuelve su nuevo id si ok, -1 si no lo consigue: 
	public function Insertar($producto, $precio, $precio_alto, $precio_chollo, $ID_categoria, $URL_foto, $ID_url_web, $ID_usuario) {
		$id = 0;
		try {
			$sql="Select count(*) as TOTAL from anuncios where producto='$producto'";
			$total = $this->CT($sql);
			if ($total>0) {
				throw new Exception("Producto ya existente");
			}

			$sql="insert into anuncios (producto, precio, precio_alto, precio_chollo, id_categoria, id_urlweb, url_foto, id_usuario) 
			values ('$producto', '$precio', '$precio_alto', '$precio_chollo', '$ID_categoria', '$ID_url_web', '$URL_foto',  '$ID_usuario')";
			$id = $this->CE($sql,true);
			
		}catch (Exception $e) {
			throw $e;
		}
		return $id;
	}

	public function Actualizar($id, $producto, $precio, $precio_alto, $precio_chollo, $id_categoria, $url_foto, $id_urlweb, $id_usuario) {
		$res = 0;
		try {
            
            $sql="Update anuncios set producto='$producto', precio='$precio', precio_alto='$precio_alto', precio_chollo='$precio_chollo', id_categoria='$id_categoria', url_foto='$url_foto', id_urlweb='$id_urlweb', id_usuario='$id_usuario' where id='$id'";

            $res = $this->CE($sql.false);
            
		} catch (Exception $e) {
			throw $e;
		}
		return $res;
	}

    public function Eliminar($id) {
        $total = 0;
        try {
            $sql="delete from anuncios where id='$id'";
            $total = $this->CE($sql);
        }catch (Exception $e) {
            throw $e;
        }
        return $total;
    }
    
	public function TotalAnuncios($id){
		$total = 0;
		try {
			$sql="Select count(*) as TOTAL from anuncios where id_usuario='$id'";
			$total = $this->CT($sql);
		} catch (Exception $e) {
			throw $e;
		}
		return $total;
	}
	public function TotalAnuncios2($condicion=""){
		$total = 0;
		try {
			$sql="Select count(*) as TOTAL from anuncios $condicion";
			$total = $this->CT($sql);
            $_SESSION['cantidad'] = $total;
		} catch (Exception $e) {
			throw $e;
		}
		return $total;
	}
    public function ListarAnuncios($condicion){
        
		$info=array();
		try {
			$sql="Select * from anuncios  $condicion ";

			if ($this->CS($sql)) {
				$i=0;
                $valoracion=0;
				while ($fila=$this->mDatos->fetch_assoc()){
                    $info[$i][0]=$fila["id"];
                    $info[$i][1]=$fila["url_foto"];
					$info[$i][2]=$fila["producto"];
					$info[$i][3]=$fila["precio"];
                    $info[$i][4]=$fila["precio_alto"];
                    $info[$i][5]=$fila["precio_chollo"];
					$info[$i][6]=$fila["id_categoria"];
                    if ($info[$i][3]>=$info[$i][4]){
                        $valoracion="Caro";
                    }
                    if ($info[$i][3]<=$info[$i][5]){
                        $valoracion="Chollo";
                    }
                    if (($info[$i][3]>$info[$i][5]) && ($info[$i][3]<$info[$i][4])){
                        $valoracion="Normal";
                    }
                    $info[$i][7]=$valoracion;
                    $info[$i][8]=$fila["id_urlweb"];
                    $info[$i][9]=$fila["id_usuario"];
					$i++;
				}
				$this->mDatos->close();
			}
		} catch (Exception $e) {
			throw new Exception($sql);
		}
		return $info;
	}
    public function Chollo($condicion=""){
        
		$info=array();
		try {
			$sql="Select * from anuncios where precio<precio_chollo group by id_categoria order by precio asc";

			if ($this->CS($sql)) {
				$i=0;
                $valoracion=0;
				while ($fila=$this->mDatos->fetch_assoc()){
                    $info[$i][0]=$fila["id"];
                    $info[$i][1]=$fila["url_foto"];
					$info[$i][2]=$fila["producto"];
					$info[$i][3]=$fila["precio"];
                    $info[$i][4]=$fila["precio_alto"];
                    $info[$i][5]=$fila["precio_chollo"];
					$info[$i][6]=$fila["id_categoria"];
                    if ($info[$i][3]>=$info[$i][4]){
                        $valoracion="Caro";
                    }
                    if ($info[$i][3]<=$info[$i][5]){
                        $valoracion="Chollo";
                    }
                    if (($info[$i][3]>$info[$i][5]) && ($info[$i][3]<$info[$i][4])){
                        $valoracion="Normal";
                    }
                    $info[$i][7]=$valoracion;
                    $info[$i][8]=$fila["id_urlweb"];
                    $info[$i][9]=$fila["id_usuario"];
					$i++;
				}
				$this->mDatos->close();
			}
		} catch (Exception $e) {
			throw new Exception($sql);
		}
		return $info;
	}
    
    public function ListarPaginado($inicio, $num_items) {
		return $this->Listar("limit $inicio,$num_items");
	}
    public function ListarPaginado2($inicio, $num_items, $condicion="") {
		return $this->ListarAnuncios("$condicion order by id desc limit $inicio,$num_items ");
	}	
	//Devuelve la lista de usuarios según la condición
	public function Listar($condicion="") {
        $id = $_SESSION['id'];

		$info=array();
		try {
			$sql="Select * from anuncios where id_usuario='$id' ORDER BY id DESC $condicion";
			if ($this->CS($sql)) {
				$i=0;
                $valoracion=0;
				while ($fila=$this->mDatos->fetch_assoc()){
                    $info[$i][0]=$fila["id"];
                    $info[$i][1]=$fila["url_foto"];
					$info[$i][2]=$fila["producto"];
					$info[$i][3]=$fila["precio"];
                    $info[$i][4]=$fila["precio_alto"];
                    $info[$i][5]=$fila["precio_chollo"];
					$info[$i][6]=$fila["id_categoria"];
                    if ($info[$i][3]>=$info[$i][4]){
                        $valoracion="Caro";
                    }
                    if ($info[$i][3]<=$info[$i][5]){
                        $valoracion="Chollo";
                    }
                    if (($info[$i][3]>$info[$i][5]) && ($info[$i][3]<$info[$i][4])){
                        $valoracion="Normal";
                    }
                    $info[$i][7]=$valoracion;
                    $info[$i][8]=$fila["id_urlweb"];
					$i++;
				}
				$this->mDatos->close();
			}
		} catch (Exception $e) {
			throw new Exception($sql);
		}
		return $info;
	}
	
	//Devuelve la lista de anuncios según la condición
	public function Cargar($id) {
		try {
			$sql="Select * from anuncios where id=$id";
			if ($this->CS($sql)) {
				if ($fila=$this->mDatos->fetch_assoc()){
                    $this->mID=$fila["id"];
                    $this->mProducto=$fila["producto"];
                    $this->mPrecio=$fila["precio"];
                    $this->mPrecio_alto=$fila["precio_alto"];
                    $this->mPrecio_chollo=$fila["precio_chollo"];
                    $this->mID_categoria=$fila["id_categoria"];
                    $this->mID_url_web=$fila["id_urlweb"];
                    $this->mURL_foto=$fila["url_foto"];
                    $this->mURL_anuncio=$fila["url_anuncio"];
                    $this->mID_usuario=$fila["id_usuario"];
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