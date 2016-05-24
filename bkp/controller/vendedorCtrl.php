<?php
    require_once ( 'lib/view.php' );
	require_once ( 'model/vendedorModel.php' );
	
	class vendedorCtrl
	{	
		public function editAction()
		{	
			$o_vendedor = new vendedorModel();
			$o_vendedor->load( $_SESSION['_app_user']['id'] );
			
			if( count($_POST) > 0 )
			{	
				$o_vendedor->setRazaoSocial ( $_REQUEST['razaosocial']  );
				$o_vendedor->setEmail		  ( $_REQUEST['email'] );
				$o_vendedor->setFone		  ( $_REQUEST['fone']  );
			   	$o_vendedor->update();
				Application::redirect('?ctrl=index');
			}	
			
			$o_view = new View('view/vendedor.phtml');
			$o_view->setParams( array( 'o_vendedor' => $o_vendedor ) );
			$o_view->showContents();
		}

		public function altsenhaAction()
		{
			$boo_erro = false;	
			$o_vendedor = new vendedorModel();
			$o_vendedor->load( $_SESSION['_app_user']['id'] );
			
			if( count($_POST) > 0 )
			{
				if( $_REQUEST['senha'] == $_REQUEST['conf_senha'] )
				{		
					$o_vendedor->setSenha( $_REQUEST['senha'] );
					$o_vendedor->updateSenha();
					Application::redirect('?ctrl=index');
				}
				else 
				{
					$boo_erro = true;
				}
			}	
			
			$o_view = new View('view/altsenha.phtml');
			$o_view->setParams( array( 'o_vendedor' => $o_vendedor, 
									   'boo_erro' => $boo_erro	 ) );
			$o_view->showContents();
		}
	}
?>