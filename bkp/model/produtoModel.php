<?php
	require_once ( 'lib/db.php' );
	require_once ( 'model/gradeModel.php' );
	require_once ( 'model/produtofotosModel.php' );
	
    class produtoModel
    {
    	private $int_id;
		private $int_idvendedor;
		private $str_referencia;
		private $str_descricao;
		private $int_idcolecao;
		private $num_preco;
		private $int_estoque;
		private $int_ativo;
		private $str_promocao;
		private $v_grades;
		private $str_imagem;
    	
    	// id NOT NULL
    	public function setId( $int_id )
		{
			$this->int_id = $int_id;
		}
		
	    public function getId()
		{
			return $this->int_id;
		}
		
  		// idvendedor NOT NULL
  		public function setIdVendedor( $int_idvendedor )
		{
			$this->int_idvendedor = $int_idvendedor;
		}
		
	    public function getIdVendedor()
		{
			return $this->int_idvendedor;
		}
		
  		// sreferencia Size ( 20 ) NOT NULL
  		public function setReferencia( $str_referencia )
		{
			$this->str_referencia = $str_referencia;
		}
		
	    public function getReferencia()
		{
			return $this->str_referencia;
		}
		
  		// sdescricao Size ( 50 ) NOT NULL
  		public function setDescricao( $str_descricao )
		{
			$this->str_descricao = $str_descricao;
		}
		
	    public function getDescricao()
		{
			return $this->str_descricao;
		}
		
 	 	// idcolecao NOT NULL
 	 	public function setIdColecao( $int_idcolecao )
		{
			$this->int_idcolecao = $int_idcolecao;
		}
		
	    public function getIdColecao()
		{
			return $this->int_idcolecao;
		}
		
  		// npreco numeric(15,2)
  		public function setPreco( $num_preco )
		{
			$this->num_preco = $num_preco;
		}
		
	    public function getPreco()
		{
			return $this->num_preco;
		}
		
  		// iestoque 
  		public function setEstoque( $int_estoque )
		{
			$this->int_estoque = $int_estoque;
		}
		
	    public function getestoque()
		{
			return $this->int_estoque;
		}
  		
  		// iativo DEFAULT 0
  		public function setAtivo( $int_ativo )
		{
			$this->int_ativo = $int_ativo;
		}
		
	    public function getAtivo()
		{
			return $this->int_ativo;
		}
		
  		// spromocao Size ( 1 ) DEFAULT 'N'
  		public function setPromocao( $str_promocao )
		{
			$this->str_promocao = $str_promocao;
		}
		
	    public function getPromocao()
		{
			return $this->str_promocao;
		}
		
	   // Vetor grades
  		public function setGrades( $v_grades )
		{
			$this->v_grades = $v_grades;
		}
		
	    public function getGrades()
		{
			return $this->v_grades;
		}
		
		// Imagem Principal
		public function setImagem( $str_imagem )
		{
			$this->str_imagem = $str_imagem;
		}
		
	    public function getImagem()
		{
			return $this->str_imagem;
		}
		
		public function getProdutos() 
		{
 			$v_produtos = array();
        	$str_sqlQuery    = "select * from produto order by sdescricao";
 
        	$o_db = new DB();
       		$o_db->connection();
			$o_db->executeQuery( $str_sqlQuery );
			
			while( $o_ret = $o_db->fetchObject() )
			{
				$o_produto = new produtoModel();
				$o_produto->setId( $o_ret->id );
				$o_produto->setReferencia( $o_ret->sreferencia );
  				$o_produto->setDescricao  ( $o_ret->sdescricao );
  				$o_produto->setIdColecao ( $o_ret->idcolecao   );
  				$o_produto->setPreco	 ( $o_ret->npreco 	   );
  				$o_produto->setEstoque	 ( $o_ret->iestoque    );	
  				$o_produto->setAtivo	 ( $o_ret->iativo	   );		
  				$o_produto->setPromocao  ( $o_ret->spromocao   );
				$o_produto->setPromocao  ( $o_ret->spromocao   );	
				$o_fotos = new produtofotosModel();
				$o_produto->setImagem ( $o_fotos->getFotoPrincipal( $o_produto->getId() ) );
				
				array_push( $v_produtos, $o_produto );
			}	
			
        	$o_db->disconnect();
    		return $v_produtos;
    	}
		 
    	public function getProdutosPaginados( $int_primeiroreg, $int_numporpagina, $str_busca, $int_tpser ) 
    	{
    		$v_produtos   = array();
        	$str_sqlQuery = "SELECT  id, sreferencia, sdescricao, 
        							  idcolecao, npreco, iativo, spromocao 
        					  FROM  produto 
        					  WHERE iativo = 0 and npreco > 0";
			
			switch( $int_tpser ) 
			{
    			case 1: // 1 - Masculino
     		 		$str_sqlQuery .= " and iddepartamento = 1";  
					break;		
    			case 2: // 2 - Feminino
       			 	$str_sqlQuery .= " and iddepartamento = 2";
					break;
    			case 3: // 3 - Infantil
        			$str_sqlQuery .= " and iddepartamento = 3";
					break;
				case 4: // 4 - Promoção
        			$str_sqlQuery .= " and spromocao = 'S'";
					break;
				case 5: // 5 - Saldo
        			$str_sqlQuery .= " and ssaldo = 'S'";
					break;
			}	
					
  			if ( $str_busca != NULL) 
  			{
            	$str_sqlQuery.=" and ( ( sdescricao  LIKE '%" .strtoupper ( $str_busca ). "%' ) or
            						   ( sreferencia LIKE '%" .strtoupper ( $str_busca ). "%' ) )";
        	}
        	 
			$str_sqlQuery.= " ORDER BY sdescricao LIMIT " .$int_numporpagina. " OFFSET " . $int_primeiroreg;
       	  		 
			$o_db = new DB();
       		$o_db->connection();
			$o_db->executeQuery( $str_sqlQuery );
			
			while( $o_ret = $o_db->fetchObject() )
			{
				$o_produto = new produtoModel();
				$o_produto->setId		 ( $o_ret->id );
				$o_produto->setReferencia( $o_ret->sreferencia );
  				$o_produto->setDescricao ( $o_ret->sdescricao  );
  				$o_produto->setIdColecao ( $o_ret->idcolecao   );
  				$o_produto->setPreco	 ( $o_ret->npreco 	   );
  				$o_produto->setAtivo	 ( $o_ret->iativo	   );		
  				$o_produto->setPromocao  ( $o_ret->spromocao   );
				
				$o_fotos = new produtofotosModel();
				$o_produto->setImagem (  $o_fotos->getFotoPrincipal(  $o_produto->getId() ) );
				
				$o_grade = new gradeModel();
				$o_produto->setGrades( $o_grade->getGradesProduto ( $o_produto->getId() ) );	
				
				array_push( $v_produtos, $o_produto );
			}
 			  
 			$o_db->disconnect();
		
    		return $v_produtos;
        }
    
 
    	public function getTotalProdutos( $str_busca, $int_tpser ) 
    	{
        	$str_sqlQuery = "SELECT  
        							id, sreferencia, sdescricao, 
        							idcolecao, npreco, iativo, spromocao 
        					  FROM  produto 
        					  WHERE iativo = 0 and npreco > 0";
							  	
			switch( $int_tpser ) 
			{
    			case 1: // 1 - Masculino
     		 		$str_sqlQuery .= " and iddepartamento = 1";  
					break;		
    			case 2: // 2 - Feminino
       			 	$str_sqlQuery .= " and iddepartamento = 2";
					break;
    			case 3: // 3 - Infantil
        			$str_sqlQuery .= " and iddepartamento = 3";
					break;
				case 4: // 4 - Promoção
        			$str_sqlQuery .= " and spromocao = 'S'";
					break;
				case 5: // 5 - Saldo
        			$str_sqlQuery .= " and ssaldo = 'S'";
					break;
			}
					
  			if ( $str_busca != NULL) 
  			{	
				$str_sqlQuery.=" and ( ( sdescricao  LIKE '%" .strtoupper ( $str_busca ). "%' ) or
            						   ( sreferencia LIKE '%" .strtoupper ( $str_busca ). "%' ) )";
        	}
				 
			$o_db = new DB();
       		$o_db->connection();
			$o_db->executeQuery( $str_sqlQuery );
			$int_linhas = $o_db->numRows();
			
 			$o_db->disconnect();
    		return $int_linhas;
    	}
		
		public function load( $int_id )
		{	
			$str_sqlQuery   = 'SELECT * FROM produto WHERE id = '.$int_id.';';
			$o_db = new DB();
       		$o_db->connection();
			$o_db->executeQuery( $str_sqlQuery );
			$o_ret = $o_db->fetchObject();
			
			$this->setId( $o_ret->id );
			$this->setReferencia( $o_ret->sreferencia );
  			$this->setDescricao ( $o_ret->sdescricao  );
  			$this->setIdColecao ( $o_ret->idcolecao   );
  			$this->setPreco	 	( $o_ret->npreco 	  );
  			$this->setEstoque	( $o_ret->iestoque    );	
  			$this->setAtivo	 	( $o_ret->iativo	  );		
  			$this->setPromocao  ( $o_ret->spromocao   );
  			$o_fotos = new produtofotosModel();
			$this->setImagem (  $o_fotos->getFotoPrincipal(  $this->getId() ) );
			
  			$o_grade = new gradeModel();
			$this->setGrades( $o_grade->getGradesProduto ( $this->getId() ) );	
						
 			$o_db->disconnect();
    		return $this;
		}
    }
?>