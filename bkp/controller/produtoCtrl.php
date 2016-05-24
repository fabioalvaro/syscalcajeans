<?php
	require_once ( 'model/produtoModel.php' );
	require_once ( 'lib/view.php' );
	

	class produtoCtrl
	{
		public function detalharAction()
		{
			$o_produto = new produtoModel();
			
			if( isset($_REQUEST['id_prod']) )
				$o_produto->load( $_REQUEST[ 'id_prod' ] );
			
			$o_view = new View('view/detalharProduto.phtml');
			$o_view->setParams( array( 'o_produto' => $o_produto ) );
			$o_view->showContents();
		}	
		
		public function listarProdutosAction()
		{
				
			$o_produto = new produtoModel();
			 
			// Página Atual
			if( isset( $_REQUEST['in_pg'] ) )
			{
			   $int_pagina = $_REQUEST['in_pg'];
			} 
			else $int_pagina = 0;
			
			// Menu ativo e pesquisa
			if( isset( $_REQUEST['in_tpser'] ) )
			{
			   $int_menuativo = $_REQUEST['in_tpser'];
			} 
			else $int_menuativo = 0;
			
			// String de busca
			if ( isset( $_REQUEST['st_ser'] ) )
				 $str_busca = $_REQUEST['st_ser'];
			else $str_busca = Null;
			
			// Número de itens por página
			if( isset( $_REQUEST['in_npg'] ) )
			{
			   $int_numporpagina = $_REQUEST['in_npg'];
			} 
			else $int_numporpagina = 16;
			
			// Define o número total de páginas
			$int_totalprod = $o_produto->getTotalProdutos( $str_busca, $int_menuativo );
			$boo_temprod   = ( $int_totalprod > 0 ); 			
			
			// Listando os produtos cadastrados ppaginados
			$v_produtos = $o_produto->getProdutosPaginados(  $int_pagina * $int_numporpagina , $int_numporpagina, $str_busca, $int_menuativo );
		
			// Define qual arquivo seráutilizado na View
			$o_view = new View('view/listarProduto.phtml');
		
			// Passando os dados para a View
			$o_view->setParams( array(  'v_produtos'    => $v_produtos, 
										'boo_temprod'   => $boo_temprod, 
										'int_totalprod' => $int_totalprod,
										'int_menuativo' => $int_menuativo, 
										'int_pagina'	=> $int_pagina,
										'int_numporpagina' => $int_numporpagina,
										'str_busca' 	   => $str_busca	) );
			
			// Exibe
			$o_view->showContents();
		}			
	}
?>