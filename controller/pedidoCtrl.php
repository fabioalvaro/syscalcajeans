<?php
    require_once ( 'lib/view.php' );
	require_once ( 'model/produtoModel.php' );
	require_once ( 'model/carrinhoModel.php' );
	require_once ( 'model/condicaopagamentoModel.php' );
	require_once ( 'model/pedidoModel.php' );
	require_once ( 'model/clienteModel.php' );
	
	class pedidoCtrl
	{
		public function sendAction()
		{
			$o_pedido  = new pedidoModel();
			
			if( isset($_REQUEST['id_ped']) )
				$o_pedido->load( $_REQUEST[ 'id_ped' ] );
			
			Application::redirect('?ctrl=index');
		}	
					
		public function showAction()
		{
			$o_pedido  = new pedidoModel();
			
			if( isset($_REQUEST['id_ped']) )
				$o_pedido->load( $_REQUEST[ 'id_ped' ] );
			
			$o_view = new View('view/detalharPedido.phtml');
			$o_view->setParams( array( 'o_pedido' => $o_pedido ) );
			$o_view->showContents();
		}
				
		public function listAction()
		{
			$v_pedidos  = array();	
			$v_clientes = array();
			$o_pedido   = new pedidoModel();
			
			if( $_SESSION['_app_user']['tppessoa'] == 'vendedor' )
			{
				$o_cliente  = new clienteModel();
				$v_clientes = $o_cliente->getClientes(); 
			}
			
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
			
			// Data Inicial
			if ( isset( $_REQUEST['dt_i'] ) )
				 $dat_dataini = $_REQUEST['dt_i'];
			else $dat_dataini = date("d/m/Y", strtotime("-30 days"));
			
			// Data Final
			if ( isset( $_REQUEST['dt_i'] ) )
				 $dat_datafim = $_REQUEST['dt_f'];
			else $dat_datafim = date("d/m/Y");
			
			// Cliente
			if ( isset( $_REQUEST['id_cli'] ) )
				 $int_idcliente = $_REQUEST['id_cli'];
			else $int_idcliente = -1; 
			 
			// Verifica se foi post da página
			if( count($_POST) > 0 )
			{
			   $dat_dataini = $_REQUEST['dataini'];
			   $dat_datafim = $_REQUEST['datafim'];
			   if( isset( $_REQUEST['cliente'] ) )
			       $int_idcliente  = $_REQUEST['cliente'];
			   else $int_idcliente = -1; 
			   
			   $int_pagina = 0;
			}

			// Define o número total de páginas
			$int_totalreg = $o_pedido->getTotalPedidos( $dat_dataini, $dat_datafim, $int_idcliente );
			
			$v_pedidos = $o_pedido->getPedidosPaginados( $int_pagina * $int_numporpagina , $int_numporpagina,
														 $dat_dataini, $dat_datafim, $int_idcliente );
			
			$qtd_pedidos = count ( $v_pedidos );
			
			
			// Define qual arquivo será utilizado na View
			$o_view = new View('view/listarPedidos.phtml');
			 
			$o_view->setParams( array( 'v_pedidos'   	  => $v_pedidos,
									   'qtd_pedidos' 	  => $qtd_pedidos,
									   'dat_dataini' 	  => $dat_dataini,
									   'dat_datafim' 	  => $dat_datafim,
									   'int_pagina'	      => $int_pagina,
									   'int_numporpagina' => $int_numporpagina,
									   'int_totalreg'     => $int_totalreg,
									   'v_clientes'		  => $v_clientes,
									   'int_idcliente'   => $int_idcliente	 
									) );
			
			// Exibe
			$o_view->showContents();	
		}
		
		public function delitemcartAction()
		{
			$id_user	= intval ( $_SESSION['_app_user']['id']	); 
			
			if( isset( $_REQUEST['id_prod'] ) )
			{
			   $id_produto   = $_REQUEST['id_prod'];
			}
			
			unset($_SESSION['_app_cart_'.$id_user] [$id_produto]);
			
			Application::redirect('?ctrl=pedido&action=showcart');
		}
		
		
		public function showcartAction()
		{	
			$o_carrinho = new carrinhoModel();
			$v_carrinho = $o_carrinho->getCarrinho();
			
			
			// Define qual arquivo será utilizado na View
			$o_view = new View('view/carrinho.phtml');

			$o_view->setParams( array( 'v_carrinho' => $v_carrinho ) );
			
			// Exibe
			$o_view->showContents();
		}
		
		public function endcartAction()
		{
			$erro = '';	
			$o_carrinho = new carrinhoModel();
			$v_carrinho = $o_carrinho->getCarrinho();	
			
			$v_clientes = array();
			$o_pedido   = new pedidoModel();
			
			if( $_SESSION['_app_user']['tppessoa'] == 'vendedor' )
			{
				$o_cliente  = new clienteModel();
				$v_clientes = $o_cliente->getClientes(); 
			}
			
			$int_qtd_total = 0;
			$num_val_total = 0;
					
			foreach( $v_carrinho AS $o_carrinho )
			{
				$int_qtd_total = $int_qtd_total + $o_carrinho->getQtdTotal();  
				$num_val_total = $num_val_total + $o_carrinho->getValorTotal();  	
			}
			
			$o_condpag = new condicaopagamentoModel();
			$v_condpag = $o_condpag->getCondicoesPagamento( $num_val_total );
			
			// Verifica se foi post da página
			if( count($_POST) > 0 )
			{
    			$int_cliente = null;		
    			if( $_SESSION['_app_user']['tppessoa'] == 'vendedor' )
				{	
    	 		    if ( !isset( $_POST['cliente'] ) )
					{
						$erro = 'Selecione um cliente para finalizar o pedido.';
					}
					else
					{
						if( $_POST['cliente'] == -1 )
						{
							$erro = 'Selecione um cliente para finalizar o pedido.';
						}
						else 
						{
							$int_cliente  = $_POST['cliente'];
						}
					}
					$int_vendedor = $_SESSION['_app_user']['id'];	
				}
				else
				{
					$int_cliente  = $_SESSION['_app_user']['id'];
					$int_vendedor = null;
				} 	
				
						
				if( trim( $erro ) == '' )	
				{	
					$o_pedido = new pedidoModel();
				
					$o_pedido->Gravar( $v_carrinho, $_POST['condpag'], $_POST['obs'],
									   $int_qtd_total, $num_val_total, $int_cliente, $int_vendedor );
				
					$id_user = intval ( $_SESSION['_app_user']['id'] );
							  unset( $_SESSION['_app_cart_'.$id_user] ); 
				
					Application::redirect('?ctrl=index');
				}
			}
			
			// Define qual arquivo será utilizado na View
			$o_view = new View('view/finalizarPedido.phtml');

			$o_view->setParams( array( 'v_condpag'     => $v_condpag,
									   'int_qtd_total' => $int_qtd_total,
									   'num_val_total' => $num_val_total,
									   'v_clientes'    => $v_clientes,
									   'erro'		   => $erro
									 ) );
			
			// Exibe
			$o_view->showContents();
		}
		
		public function addcartAction()
		{
			$id_produto = intval ( $_REQUEST[ 'id_prod' ] );
			$id_user	= intval ( $_SESSION['_app_user']['id']	); // Pega o id do usuário para criação da session de pedido
			
			$o_produto  = new produtoModel();
			
			if( isset($_REQUEST[ 'id_prod' ]) )
			{
				$o_produto->load( $id_produto );
			}
			
			if( isset( $_REQUEST['edit'] ) )
			{
			   $boo_edicao = $_REQUEST['edit'] == 'true';
			} 
			else $boo_edicao = false;   
			
			
			// Verifica se foi post da página
			if( count($_POST) > 0 )
			{
				session_start();
				
				if (!isset( $_SESSION['_app_cart_'.$id_user] ))
				{
				   $_SESSION['_app_cart_'.$id_user] = array(); 
				}
				
				if( isset( $_SESSION['_app_cart_'.$id_user] [$id_produto] )) 
				{
					unset($_SESSION['_app_cart_'.$id_user] [$id_produto]);
				} 
				
				foreach( $o_produto->getGrades() AS $o_grade )
				{
					if( $o_grade->getQtdProd() > 0 )
				   	{
						$int_qtd_sel = $_POST['campo'.$o_grade->getId()]; // Quantidade selecionada
							
						if( $int_qtd_sel > 0 )
						{
							$_SESSION['_app_cart_'.$id_user ] [$id_produto] [$o_grade->getId()] = $int_qtd_sel;
						} 	 	 							
				  	 }
				}	
					
				//Incluir rotina para verificar se é edição caso seja voltar para o carrinho
				If ( $boo_edicao == true )
				{
				   Application::redirect('?ctrl=pedido&action=showcart');
				}  
				else
				{  
				   Application::redirect('?ctrl=produto&action=listarProdutos');
				}
			}
			
			$o_view = new View('view/addProduto.phtml');
			$o_view->setParams( array( 'o_produto' => $o_produto ) );
			$o_view->showContents();
		}
	}
?>