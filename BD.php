<?php

define("HOST","localhost");
define("USUARIO","root");
define("SENHA","");
define("BANCO","api auxbrasil");

class MySQL{
	
	private $connection;
	
	public function __construct(){
		$this->connection = new mysqli(HOST,USUARIO,SENHA,BANCO);
		$this->connection->set_charset("utf8");
	}
	public function __destruct(){
		mysqli_close($this->connection);
	}
	public function executa($sql){
		$result = $this->connection->query($sql);
		return $result;
	}
	public function consulta($sql){
		$result = $this->connection->query($sql);
		$item = array();
		$data = array();
		while($item = mysqli_fetch_array($result)){
			$data[] = $item;
		}
		return $data;
		}

    public function consultaCidade($sql){
        $resultado = $this->connection->query($sql);
        return mysqli_fetch_assoc($resultado);
        
        
    }

	}
?>
