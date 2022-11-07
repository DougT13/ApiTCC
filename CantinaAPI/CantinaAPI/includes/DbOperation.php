<?php
 
class DbOperation
{
    
    private $con;
 
 
    function __construct()
    {
  
        require_once dirname(__FILE__) . '/DbConnect.php';
 
     
        $db = new DbConnect();
 

        $this->con = $db->connect();
    }
	
	
	function createProdutos($NomeProduto, $PrecoProduto, $QtdeEstoque, $Descricao){
		$stmt = $this->con->prepare("INSERT INTO Produtos (NomeProduto, IDEstabelecimento, PrecoProduto, QtdeEstoque, Descricao) VALUES (?, 1, ?, ?, ?)");
		$stmt->bind_param("sdis", $NomeProduto, $PrecoProduto, $QtdeEstoque, $Descricao);
		if($stmt->execute())
			return true; 
		return false; 

		
	}

	function selectProdutos($id){
		$stmt = $this->con->prepare("SELECT IDProduto, NomeProduto, PrecoProduto, QtdeEstoque, Descricao FROM Produtos WHERE IDProduto = $id");
		$stmt->execute();
		$stmt->bind_result($id, $NomeProduto, $PrecoProduto, $QtdeEstoque, $Descricao);
		
		$produtos = array(); 
		
		while($stmt->fetch()){
			$produto  = array();
			$produto['IDProduto'] = $id; 
			$produto['NomeProduto'] = $NomeProduto; 
			$produto['PrecoProduto'] = $PrecoProduto; 
			$produto['QtdeEstoque'] = $QtdeEstoque; 
			$produto['Descricao'] = $Descricao; 
			
			array_push($produtos, $produto); 
			
	}
	return $produtos; 
}

		
	function getProdutos(){
		$stmt = $this->con->prepare("SELECT IDProduto, NomeProduto, PrecoProduto, QtdeEstoque, Descricao FROM Produtos");
		$stmt->execute();
		$stmt->bind_result($id, $NomeProduto, $PrecoProduto, $QtdeEstoque, $Descricao);
		
		$produtos = array(); 
		
		while($stmt->fetch()){
			$produto  = array();
			$produto['IDProduto'] = $id; 
			$produto['NomeProduto'] = $NomeProduto; 
			$produto['PrecoProduto'] = $PrecoProduto; 
			$produto['QtdeEstoque'] = $QtdeEstoque; 
			$produto['Descricao'] = $Descricao; 
			
			array_push($produtos, $produto); 
		}
		
		return $produtos; 
	}
	
	
	function updateProdutos($id, $NomeProduto, $PrecoProduto, $QtdeEstoque, $Descricao){
		$stmt = $this->con->prepare("UPDATE Produtos SET NomeProduto = ?, PrecoProduto = ?, QtdeEstoque = ?, Descricao = ? WHERE IDProduto = ?");
		$stmt->bind_param("sdisi", $NomeProduto, $PrecoProduto, $QtdeEstoque, $Descricao, $id);
		if($stmt->execute())
			return true; 
		return false; 
	} 
	
	
	function deleteProdutos($id){
		$stmt = $this->con->prepare("DELETE FROM Produtos WHERE IDProduto = ? ");
		$stmt->bind_param("i", $id);
		if($stmt->execute())
			return true; 
		
		return false; 
	}
}