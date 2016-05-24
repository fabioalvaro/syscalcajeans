<?php
	require_once ( 'lib/view.php' );
	require_once ( 'model/clienteModel.php' );
	require_once ( 'model/vendedorModel.php' );
	
	class sectionCtrl
	{	
		public function logoutAction()
		{
			session_start();
			// Cliente
			if( $_SESSION['_app_user']['tppessoa'] = 'cliente' )
			{
			   unset(  $_SESSION['_app_user']['logado'],
   					   $_SESSION['_app_user']['tppessoa'],
					   $_SESSION['_app_user']['id'],
					   $_SESSION['_app_user']['login'],
					   $_SESSION['_app_user']['razaosocial'],
					   $_SESSION['_app_user']['nomefantasia']
    		     );
			} 
			else if( $_SESSION['_app_user']['tppessoa'] = 'vendedor' ) // Vendedor
			{
				unset( $_SESSION['_app_user']['logado'],
   					   $_SESSION['_app_user']['tppessoa'],
					   $_SESSION['_app_user']['id'],
					   $_SESSION['_app_user']['login'],
					   $_SESSION['_app_user']['razaosocial']
    		    );
			} 
			//session_destroy();
			Application::redirect('?ctrl=section&action=login');
		}
		
		public function loginAction()
		{	
			if( isset( $_REQUEST['err_val'] ) )
			{
			   $boo_err_val = $_REQUEST['err_val'] == 'true';
			} 
			else $boo_err_val = false;   
							
			// Verifica se foi post da página
			if( count($_POST) > 0 )
			{	
				$boo_logou = false; 
				// Cliente -> CNPJ = 14, CPF = 11
				if( ( strlen($_POST['st_identificacao'] ) == 14 ) || 
					( strlen($_POST['st_identificacao'] ) == 11 ))
				{	
					$o_cliente = new ClienteModel();	
					
					$o_cliente->autenticar( $_POST['st_identificacao'], $_POST['st_senha'] );
					if ( ( $o_cliente->getId() != 0 ) && ( $o_cliente->getLogado() ) ) 
					{
   	 					session_start();	
   	 					$_SESSION['_app_user']['logado']       = true;
   					 	$_SESSION['_app_user']['tppessoa']     = 'cliente';
						$_SESSION['_app_user']['id']	       = $o_cliente->getId();
						$_SESSION['_app_user']['login']	       = $o_cliente->getCNPJ_CPF();
						$_SESSION['_app_user']['razaosocial']  = $o_cliente->getRazaoSocial();
						$_SESSION['_app_user']['nomefantasia'] = $o_cliente->getNomeFantasia();
						$boo_logou = true;
    					Application::redirect('?ctrl=index');
					}
					else
					{
					    $o_vendedor = new VendedorModel();	
					
						$o_vendedor->autenticar( $_POST['st_identificacao'], $_POST['st_senha'] );
						if ( ( $o_vendedor->getId() != 0 ) && ( $o_vendedor->getLogado() ) ) 
						{
   	 						session_start();	
   	 						$_SESSION['_app_user']['logado']       = true;
   					 		$_SESSION['_app_user']['tppessoa']     = 'vendedor';
							$_SESSION['_app_user']['id']	       = $o_vendedor->getId();
							$_SESSION['_app_user']['login']	       = $o_vendedor->getCNPJ_CPF();
							$_SESSION['_app_user']['razaosocial']  = $o_vendedor->getRazaoSocial();
							$boo_logou = true;
    						Application::redirect('?ctrl=index');
						}	
					}	 
					
					if ( !$boo_logou )
					{
						Application::redirect('?ctrl=section&action=login&err_val=true');
					}
				}
				else // Caso não encontre o vendedor e o cliente 
				{
					Application::redirect('?ctrl=section&action=login&err_val=true');   
				}
			}
				
			// Define qual arquivo será utilizado na View
			$o_view = new View('view/login.phtml');
			
			// Passando os dados para a View
			$o_view->setParams( array( 'err_val'  => $boo_err_val ) );
							
			// Exibe
			$o_view->showContents();			
		}
	}
?>