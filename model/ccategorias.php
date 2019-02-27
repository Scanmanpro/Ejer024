<?php
include_once 'cbbdd.php';
class CCategorias extends CBBDD {
	//Atributos de la clase
	private $mID;
	private $mCategoria;	

	
	//Propiedades
	public function getID() {
		return $this->mID;
	}
	
	public function getCategoria() {
		return $this->mCategoria;
	}

	//Funciones de la clase
	public function __construct() {
		parent::__construct();
		$this->mID=0;
		$this->mCategoria="";
		
	}
	public function TotalCategorias(){
		$total = 0;
		try {
			$sql="Select count(*) as TOTAL from categorias";
			$total = $this->CT($sql);
		} catch (Exception $e) {
			throw $e;
		}
		return $total;
	}

	//Inserta un nuevo usuario, devuelve su nuevo id si ok, -1 si no lo consigue: 
	public function Insertar($categoria) {
		$id = 0;
		try {
			$sql="Select count(*) as TOTAL from categorias where categoria='$categoria'";
			$total = $this->CT($sql);
			if ($total>0) {
				throw new Exception("Categoria ya existente");
			}
			
			$sql="insert into categorias (categoria) 
			values ('$categoria')";
			$id = $this->CE($sql,true);

		}catch (Exception $e) {
			throw $e;
		}
		return $id;
	}

	public function Actualizar($id,$categoria) {
		$res = 0;
		try {
            
            $sql="Update categorias set categoria='$categoria' where id='$id'";
            $res = $this->CE($sql.false);
            
		} catch (Exception $e) {
			throw $e;
		}
		return $res;
	}
    public function ListarPaginado($inicio, $num_items) {
		return $this->Listar("limit $inicio,$num_items");
	}
    
    public function Eliminar($id) {
		$total = 0;
		try {
			$sql="delete from categorias where id='$id'";
			$total = $this->CE($sql);
		}catch (Exception $e) {
			throw $e;
		}
		return $total;
	}	

    
	//Devuelve la lista de usuarios según la condición
	public function Listar($condicion="") {
		$info=array();
		try {
			$sql="Select * from categorias where id>0 order by categoria $condicion";
			if ($this->CS($sql)) {
				$i=0;
				while ($fila=$this->mDatos->fetch_assoc()){
					$info[$i][0]=$fila["id"];
					$info[$i][1]=$fila["categoria"];
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
			$sql="Select * from categorias where id=$id";
			if ($this->CS($sql)) {
				if ($fila=$this->mDatos->fetch_assoc()){
                    $this->mID=$fila["id"];
                    $this->mCategoria=$fila["categoria"];
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