<?php
include_once 'cbbdd.php';
class CPeliculas extends CBBDD {
	//Atributos de la clase
	private $mID;
	private $mTitulo;	
	private $mAnio;
	private $mVideo;
	private $mDesc;
	
	//Propiedades
	public function getID() {
		return $this->mID;
	}
	
	public function getTitulo() {
		return $this->mTitulo;
	}
	
	public function getAnio() {
		return $this->mAnio;
	}

	public function getVideo(){
		return $this->mVideo;
	}
	public function getDesc(){
		return $this->mDesc;
	}

	//Funciones de la clase
	public function __construct() {
		parent::__construct();
		$this->mID=0;
		$this->mTitulo="";
		$this->mAnio="";
		$this->mVideo="";
		$this->mDesc="";
	}
	
	//Inserta una nueva peli, devuelve su nuevo id si ok, 0 si no lo consigue: 
	public function Insertar($titulo, $anio, $video, $desc) {
		$id = 0;
		try {
			$sql="insert into peliculas (p_titulo, p_anio, p_video, p_desc) 
				values ('$titulo','$anio','$video','$desc')";
			$id = $this->CE($sql,true);
		}catch (Exception $e) {
			throw $e;
		}
		return $id;
	}
	
	//Actualiza una peli, devuelve el número de filas afectadas para saber si se ha actualizado o no: 
	public function Actualizar($id, $titulo, $anio, $video, $desc) {
		$total = 0;
		try {
			$sql="update peliculas set p_titulo='$titulo', p_anio='$anio', p_video='$video', p_desc='$desc' where p_id='$id'";
			$total = $this->CE($sql);
		}catch (Exception $e) {
			throw $e;
		}
		return $total;
	}
	
	//Elimina una peli, devuelve su nuevo id si ok, -1 si no lo consigue: 
	public function Eliminar($id) {
		$total = 0;
		try {
			$sql="delete from peliculas where p_id='$id'";
			$total = $this->CE($sql);
		}catch (Exception $e) {
			throw $e;
		}
		return $total;
	}

	public function TotalPeliculas(){
		$total = 0;
		try {
			$sql="Select count(*) as TOTAL from peliculas";
			$total = $this->CT($sql);
		} catch (Exception $e) {
			throw $e;
		}
		return $total;
	}
	
	public function ListarPaginado($inicio, $num_items) {
		return $this->Listar("limit $inicio,$num_items");
	}

	//Devuelve la lista de peliculas según la condición
	public function Listar($condicion="") {
		$info=array();
		try {
			$sql="Select * from peliculas where p_id>0 $condicion";
			if ($this->CS($sql)) {
				$i=0;
				while ($fila=$this->mDatos->fetch_assoc()){
					$info[$i][0]=$fila["p_id"];
					$info[$i][1]=$fila["p_titulo"];
					$info[$i][2]=$fila["p_anio"];
					$info[$i][3]=$fila["p_video"];
					$info[$i][4]=$fila["p_desc"];
					$i++;
				}
				$this->mDatos->close();
			}
		} catch (Exception $e) {
			//Me viene bien mientras desarrollo:
			throw new Exception($sql);
		}
		return $info;
	}
	
	//Carga en las propiedades los datos de una pelicula a partir de su ID
	public function Cargar($id) {
		try {
			$sql="Select * from peliculas where p_id=$id";
			if ($this->CS($sql)) {
				if ($fila=$this->mDatos->fetch_assoc()){
					$this->mID=$fila["p_id"];
					$this->mTitulo=$fila["p_titulo"];
					$this->mAnio=$fila["p_anio"];
					$this->mVideo=$fila["p_video"];
					$this->mDesc=$fila["p_desc"];
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
	
	//Devuelve la lista de peliculas
	public function ListarWS() {
		$lista=array();
		try {
			$sql="Select * from peliculas";
			if ($this->CS($sql)) {
				$i=0;
				while ($fila=$this->mDatos->fetch_assoc()){
					array_push($lista,$fila);
				}
				$this->mDatos->close();
			}
		} catch (Exception $e) {
			throw new Exception($sql);
		}
		return $lista;
	}
}
?>