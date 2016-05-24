<?php
    require_once ( 'lib/view.php' );
	require_once ( 'model/tituloModel.php' );
	require_once ( 'model/clienteModel.php' );
	
	class tituloCtrl
	{
		public function listAction()
		{
			$v_titulos = array();	
			$v_clientes = array();
			$o_titulo  = new tituloModel();
			
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
			else $dat_datafim = date("d/m/Y", strtotime("+30 days")); 
			
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
			$int_totalreg = $o_titulo->getTotalTitulos( $dat_dataini, $dat_datafim, $int_idcliente );
			
			$v_titulos    = $o_titulo->getTitulosPaginados( $int_pagina * $int_numporpagina , $int_numporpagina,
							                				$dat_dataini, $dat_datafim, $int_idcliente );
			
			$qtd_titulos = count ( $v_titulos );
			
			// Define qual arquivo será utilizado na View
			$o_view = new View('view/listarTitulos.phtml');
			 
			$o_view->setParams( array( 'v_titulos'   	  => $v_titulos,
									   'qtd_titulos' 	  => $qtd_titulos,
									   'dat_dataini' 	  => $dat_dataini,
									   'dat_datafim'	  => $dat_datafim,
									   'int_pagina'	 	  => $int_pagina,
									   'int_numporpagina' => $int_numporpagina,
									   'int_totalreg'     => $int_totalreg,
									   'v_clientes'		  => $v_clientes,
									   'int_idcliente'    => $int_idcliente		 
									) );
			
			// Exibe
			$o_view->showContents();	
		}
	}
?>