<?php
    require_once ( 'lib/view.php' );
	require_once ( 'model/mensagemModel.php' );
	
	class mensagemCtrl
	{
		public function listAction()
		{
		    if( $_SESSION['_app_user']['tppessoa'] != 'vendedor' )
			{
				Application::redirect('?ctrl=index');
			}	
				
			$v_mensagens = array();	
			$o_mensagem  = new mensagemModel();
			
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
			else $dat_datafim = date("d/m/Y", strtotime("+30 days"));
			
			// Somente não lidos
			if ( isset( $_REQUEST['n_li'] ) )
				$boo_nao_lidas =  $_REQUEST['n_li'];  		
			else 
				$boo_nao_lidas =  true;
			 
			// Verifica se foi post da página
			if( count($_POST) > 0 )
			{
			   $dat_dataini   = $_REQUEST['dataini'];
			   $dat_datafim   = $_REQUEST['datafim'];
			   if( isset( $_REQUEST['nlidas'] ) )
			      $boo_nao_lidas = true;
			   else 
			   	  $boo_nao_lidas = false;
			   $int_pagina = 0;
			}

			// Define o número total de páginas
			$int_totalreg = $o_mensagem->getTotalMensagens( $dat_dataini, $dat_datafim, $boo_nao_lidas );
			
			$v_mensagens  = $o_mensagem->getMensagensPaginadas( $int_pagina * $int_numporpagina , $int_numporpagina,
							                					$dat_dataini, $dat_datafim, $boo_nao_lidas );
			
			$qtd_mensagens = count ( $v_mensagens );
			
			
			// Define qual arquivo será utilizado na View
			$o_view = new View('view/listarMensagens.phtml');
			 
			$o_view->setParams( array( 'v_mensagens'      => $v_mensagens,
									   'qtd_mensagens'    => $qtd_mensagens,
									   'dat_dataini'      =>$dat_dataini,
									   'dat_datafim'      =>$dat_datafim,
									   'int_pagina'	      => $int_pagina,
									   'int_numporpagina' => $int_numporpagina,
									   'int_totalreg'     => $int_totalreg,
									   'boo_nao_lidas'    => $boo_nao_lidas		 
									) );
			
			// Exibe
			$o_view->showContents();	
		}

		public function readAction()
		{
			if( $_SESSION['_app_user']['tppessoa'] != 'vendedor' )
			{
				Application::redirect('?ctrl=index');
			}
			
			if( isset( $_REQUEST['id_men'] ) && isset( $_REQUEST['b_l'] ) )
			{
			   $int_id   = $_REQUEST['id_men'];
			   $boo_lida = $_REQUEST['b_l'];
			   
			   $o_mensagem  = new mensagemModel();
			   $o_mensagem->updateLida( $int_id, $boo_lida );
			}
			
			if( isset( $_REQUEST['idx'] ) )
				Application::redirect('?ctrl=index');
			else
				Application::redirect('?ctrl=mensagem&action=list');
		}
	}
?>