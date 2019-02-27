<?php
include_once 'cbbdd.php';
class CWebs extends CBBDD {
	//Atributos de la clase
	private $mID;
	private $mWeb;
    private $mUrlWeb;

	
	//Propiedades
	public function getID() {
		return $this->mID;
	}
	
	public function getWeb() {

		return $this->mWeb;
	}
	public function getUrl() {

		return $this->mUrlWeb;
	}
	//Funciones de la clase
	public function __construct() {
		parent::__construct();
		$this->mID=0;
		$this->mWeb="";
        $this->mUrlWeb="";
		
	}
	public function TotalWebs(){
		$total = 0;
		try {
			$sql="Select count(*) as TOTAL from webs";
			$total = $this->CT($sql);
		} catch (Exception $e) {
			throw $e;
		}
		return $total;
	}

	//Inserta un nuevo usuario, devuelve su nuevo id si ok, -1 si no lo consigue: 
	public function Insertar($web,$url_web) {
		$id = 0;
		try {
			$sql="Select count(*) as TOTAL from webs where web='$web'";
			$total = $this->CT($sql);
			if ($total>0) {
				throw new Exception("La Web ya existente");
			}
			
			$sql="insert into webs (web,url_web) 
			values ('$web','$url_web')";
			$id = $this->CE($sql,true);

		}catch (Exception $e) {
			throw $e;
		}
		return $id;
	}

	public function Actualizar($id,$web,$url_web) {
		$res = 0;
		try {
            
            $sql="Update webs set web='$web', url_web='$url_web' where id='$id'";
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
            
			$sql="delete from webs where id='$id'";

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
			$sql="Select * from webs where id>0 order by web $condicion ";
			if ($this->CS($sql)) {
				$i=0;
				while ($fila=$this->mDatos->fetch_assoc()){
					$info[$i][0]=$fila["id"];
					$info[$i][1]=$fila["web"];
                    $info[$i][2]=$fila["url_web"];
					$i++;
				}
				$this->mDatos->close();
			}
		} catch (Exception $e) {
			throw new Exception($sql);
		}
		return $info;
	}
	//Devuelve la lista de webs según la condición
	public function Cargar($id) {
		try {
            
			$sql="Select * from webs where id=$id";
			if ($this->CS($sql)) {

				if ($fila=$this->mDatos->fetch_assoc()){
                    $this->mID=$fila["id"];
                    $this->mWeb=$fila["web"];
                    $this->mUrlWeb=$fila["url_web"];
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