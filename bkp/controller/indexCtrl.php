<?php
	require_once ( 'lib/view.php' );
	require_once ( 'model/mensagemModel.php' );
	
	class indexCtrl
	{	
		/*
		 * Define o que deve ser executado quando nenhuma outra rotina for chamada
		 */
		public function indexAction()
		{
			$v_mensagens = array();		
			
			if( $_SESSION['_app_user']['tppessoa'] == 'vendedor' )
			{
				$o_mensagem   = new mensagemModel();
				$v_mensagens  = $o_mensagem->getMensagens(); 
			}	
				
			
			// Define qual arquivo seráutilizado na View
			$o_view = new View('view/index.phtml');
			
			$o_view->setParams( array( 'v_mensagens' => $v_mensagens ) );
					
			// Exibe
			$o_view->showContents();
		}
	}
?>