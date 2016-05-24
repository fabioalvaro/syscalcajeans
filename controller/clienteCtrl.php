<?php
	require_once ( 'lib/view.php' );
	require_once ( 'model/clienteModel.php' );
	
	class clienteCtrl
	{
		public function listAction()
		{
			$v_clientes = array();	
			$o_cliente  = new clienteModel();
			
			// Página Atual
			if( isset( $_REQUEST['in_pg'] ) )
			{
			   $int_pagina = $_REQUEST['in_pg'];
			} 
			else $int_pagina = 0;
			
			// Número de itens por página
			if( isset( $_REQUEST['in_npg'] ) )
			{
			   $int_numporpagina = $_REQUEST['in_npg'];
			} 
			else $int_numporpagina = 12;
			
			if( isset( $_REQUEST['st_ser'] ) )
			{
			   $str_busca = $_REQUEST['st_ser'];
			}
			else $str_busca = NULL;
			
			// Verifica se foi post da página
			if( count($_POST) > 0 )
			{  
			   $str_busca = $_REQUEST['str_busca'];
			   $int_pagina = 0;
			}

			// Define o número total de páginas
			$int_totalreg = $o_cliente->getTotalClientes( $str_busca );
			
			$v_clientes   = $o_cliente->getClientesPaginados( $int_pagina * $int_numporpagina , $int_numporpagina,
														 	  $str_busca );
			
			$qtd_clientes = count ( $v_clientes );
			
			// Define qual arquivo será utilizado na View
			$o_view = new View('view/listarClientes.phtml');
			 
			$o_view->setParams( array( 'v_clientes'  	  => $v_clientes,
									   'qtd_clientes' 	  => $qtd_clientes,
									   'str_busca'   	  => $str_busca,
									   'int_pagina'	      => $int_pagina,
									   'int_numporpagina' => $int_numporpagina,
									   'int_totalreg'     => $int_totalreg		 
									) );
			
			// Exibe
			$o_view->showContents();	
		}	
				
		public function editAction()
		{	
			$o_cliente = new clienteModel();
			
			if( isset( $_REQUEST['id_cli'] ) )
			{
				$int_id = $_REQUEST['id_cli'];	
			}
			else $int_id = $_SESSION['_app_user']['id']; 
			$o_cliente->load( $int_id );
			
			if( count($_POST) > 0 )
			{	
				$o_cliente->setNomeFantasia		 ( $_REQUEST['nomefantasia'] );
				$o_cliente->setContato			 ( $_REQUEST['contato'] );
				$o_cliente->setEmail			 ( $_REQUEST['email'] );
				$o_cliente->setInscricao		 ( $_REQUEST['inscricao'] );
				$o_cliente->setBairro			 ( $_REQUEST['bairro'] );
				$o_cliente->setFone				 ( $_REQUEST['fone'] );
				$o_cliente->setRazaoSocial		 ( $_REQUEST['razaosocial'] );
				$o_cliente->setUF				 ( $_REQUEST['uf'] );
				$o_cliente->setLogradouro		 ( $_REQUEST['logradouro'] );
				$o_cliente->setCidade			 ( $_REQUEST['cidade'] );
				$o_cliente->setCep				 ( $_REQUEST['cep'] );
				$o_cliente->setNumero			 ( $_REQUEST['numero'] );
				$o_cliente->setComplemento		 ( $_REQUEST['complemento'] );
				$o_cliente->setEntregaNumero	 ( $_REQUEST['e_numero'] );
				$o_cliente->setEntregaLogradouro ( $_REQUEST['e_logradouro'] );
				$o_cliente->setEntregaCidade	 ( $_REQUEST['e_cidade'] );
				$o_cliente->setEntregaBairro 	 ( $_REQUEST['e_bairro'] );
				$o_cliente->setEntregaCep		 ( $_REQUEST['e_cep'] );
				$o_cliente->setEntregaComplemento( $_REQUEST['e_complemento'] );
				
			   	$o_cliente->update();
				if( isset( $_REQUEST['id_cli'] ) )
				{
					Application::redirect('?ctrl=cliente&action=list');
				}
				else Application::redirect('?ctrl=index');
			}	
			
			$o_view = new View('view/cliente.phtml');
			$o_view->setParams( array( 'o_cliente' => $o_cliente ) );
			$o_view->showContents();
		}

		public function altsenhaAction()
		{
			$boo_erro = false;	
			$o_cliente = new clienteModel();
			$o_cliente->load( $_SESSION['_app_user']['id'] );
			
			if( count($_POST) > 0 )
			{
				
				if( $_REQUEST['senha'] == $_REQUEST['conf_senha'] )
				{		
					$o_cliente->setSenha( $_REQUEST['senha'] );
					$o_cliente->updateSenha();
					Application::redirect('?ctrl=index');
				}
				else 
				{
					$boo_erro = true;
				}
			}	
			
			$o_view = new View('view/altsenha.phtml');
			$o_view->setParams( array( 'o_cliente' => $o_cliente, 
									    'boo_erro' => $boo_erro	 ) );
			$o_view->showContents();
		}
	}
?>