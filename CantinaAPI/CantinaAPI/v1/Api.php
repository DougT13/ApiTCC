<?php 


	require_once '../includes/DbOperation.php';

	function isTheseParametersAvailable($params){
	
		$available = true; 
		$missingparams = ""; 
		
		foreach($params as $param){
			if(!isset($_POST[$param]) || strlen($_POST[$param])<=0){
				$available = false; 
				$missingparams = $missingparams . ", " . $param; 
			}
		}
		
		
		if(!$available){
			$response = array(); 
			$response['error'] = true; 
			$response['message'] = 'Parameters ' . substr($missingparams, 1, strlen($missingparams)) . ' missing';
			
		
			echo json_encode($response);
			
		
			die();
		}
	}
	
	
	$response = array();
	

	if(isset($_GET['apicall'])){
		
		switch($_GET['apicall']){
	
			case 'createProdutos':
				
				isTheseParametersAvailable(array('NomeProduto','PrecoProduto','QtdeEstoque','Descricao'));
				
				$db = new DbOperation();
				
				$result = $db->createProdutos(
					$_POST['NomeProduto'],
					$_POST['PrecoProduto'],
					$_POST['QtdeEstoque'],
					$_POST['Descricao']
				);
				

			
				if($result){
					
					$response['error'] = false; 

					
					$response['message'] = 'Produto adicionado com sucesso';

					
					$response['produtos'] = $db->getProdutos();

				}else{

					
					$response['error'] = true; 

				
					$response['message'] = 'Algum erro ocorreu por favor tente novamente';
				}
				header('location: http://localhost/tcc_cantina/formulario.php');
				
				
			break; 
			
		
			case 'getProdutos':
				
				$db = new DbOperation();
				$response['error'] = false; 
				$response['message'] = 'Pedido concluído com sucesso';
				$response['produtos'] = $db->getProdutos();
			break;

			case 'selectProdutos':
				$id = $_GET['IDProduto'];
				$db = new DbOperation();
				$response['error'] = false; 
				$response['message'] = 'Pedido concluído com sucesso';
				$response['produtos'] = $db->selectProdutos($id);
			break; 
			
			
		
			case 'updateProdutos':
				isTheseParametersAvailable(array('IDProduto','NomeProduto','PrecoProduto','QtdeEstoque','Descricao'));
				$db = new DbOperation();
				$result = $db->updateProdutos(
					$_POST['IDProduto'],
					$_POST['NomeProduto'],
					$_POST['PrecoProduto'],
					$_POST['QtdeEstoque'],
					$_POST['Descricao']
				);
				
				if($result){
					$response['error'] = false; 
					$response['message'] = 'Produto atualizado com sucesso';
					$response['produtos'] = $db->getProdutos();
				}else{
					$response['error'] = true; 
					$response['message'] = 'Algum erro ocorreu por favor tente novamente';
				}
			break; 
			
			
			case 'deleteProdutos':

				
				if(isset($_GET['id'])){
					$db = new DbOperation();
					if($db->deleteProdutos($_GET['IDProduto'])){
						$response['error'] = false; 
						$response['message'] = 'Produto excluído com sucesso';
						$response['produtos'] = $db->getProdutos();
					}else{
						$response['error'] = true; 
						$response['message'] = 'Algum erro ocorreu por favor tente novamente';
					}
				}else{
					$response['error'] = true; 
					$response['message'] = 'Não foi possível deletar, forneça um id por favor';
				}
			break; 
		}
		
	}else{
		 
		$response['error'] = true; 
		$response['message'] = 'Chamada de API inválida';
	}
	

	echo json_encode($response);
	
	
