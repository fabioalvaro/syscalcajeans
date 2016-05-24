<?php
    require_once ( 'model/produtoModel.php' );
	require_once ( 'model/gradeModel.php' );
	
	class carrinhoGradeModel
	{
		private $int_id_grade;
		private $str_descricao_grade;
		private $int_qtd;
		private $num_total;
		private $num_preco;
		
		// Id Grade
    	public function setIdGrade( $int_id_grade )
		{
			$this->int_id_grade = $int_id_grade;
		}
		
	    public function getIdGrade()
		{
			return $this->int_id_grade;
		}
		
		// Descrição Grade
    	public function setDecricaoGrade( $str_descricao_grade )
		{
			$this->str_descricao_grade = $str_descricao_grade;
		}
		
	    public function getDescricaoGrade()
		{
			return $this->str_descricao_grade;
		}
		
		// Quantidade Selecionada		
		public function setQtd( $int_qtd )
		{
			$this->int_qtd = $int_qtd;
		}
		
	    public function getQtd()
		{
			return $this->int_qtd;
		}
		
		// Preco 
		public function setPreco( $num_preco )
		{
			$this->num_preco = $num_preco;
		}
		
	    public function getPreco()
		{
			return $this->num_preco;
		}
		
		// Valor Total
		public function setValorTotal( $num_total )
		{
			$this->num_total = $num_total;
		}
		
	    public function getValorTotal()
		{
			return $this->num_total;
		}
		
	}
	
	class carrinhoModel
    {		
		private $int_id_prod;
		private $str_descricao_prod;
		private $str_referencia_prod;
		private $str_imagem_prod;
		private $num_preco_prod;
		private $int_qtd_total;
		private $num_val_total;
		private $v_grades;
		
		// Id Produto
    	public function setIdProd( $int_id_prod )
		{
			$this->int_id_prod = $int_id_prod;
		}
		
	    public function getIdProd()
		{
			return $this->int_id_prod;
		}
		
		// Descrição Produto
		public function setDescricaoProd( $str_descricao_prod )
		{
			$this->str_descricao_prod = $str_descricao_prod;
		}
		
	    public function getDescricaoProd()
		{
			return $this->str_descricao_prod;
		}
		
		// Referencia Produto
		public function setReferenciaProd( $str_referencia_prod )
		{
			$this->str_referencia_prod = $str_referencia_prod;
		}
		
	    public function getReferenciaProd()
		{
			return $this->str_referencia_prod;
		}
		
		// Imagem Produto
		public function setImagemProd( $str_imagem_prod )
		{
			$this->str_imagem_prod = $str_imagem_prod;
		}
		
	    public function getImagemProd()
		{
			return $this->str_imagem_prod;
		}
		
		// Preço Produto
		public function setPrecoProd( $num_preco_prod )
		{
			$this->num_preco_prod = $num_preco_prod;
		}
		
	    public function getPrecoProd()
		{
			return $this->num_preco_prod;
		}
		
		// Quantidade Total
		public function setQtdTotal( $int_qtd_total )
		{
			$this->int_qtd_total = $int_qtd_total;
		}
		
	    public function getQtdTotal()
		{
			return $this->int_qtd_total;
		}
		
		// Valor Total
		public function setValorTotal( $num_val_total )
		{
			$this->num_val_total = $num_val_total;
		}
		
	    public function getValorTotal()
		{
			return $this->num_val_total;
		}
		
		// Grades / Quantidades do Carrinho
		public function setGrades( $v_grades )
		{
			$this->v_grades = $v_grades;
		}
		
	    public function getGrades()
		{
			return $this->v_grades;
		}
		
		public function getCarrinho() 
		{
 			$v_carrinho = array();
			
			if( isset ( $_SESSION['_app_cart_'.$_SESSION['_app_user'] ['id'] ] ) )
			{
				foreach( $_SESSION['_app_cart_'.$_SESSION['_app_user'] ['id'] ] AS $id => $v_itens )
				{
					$o_carrinho 	  = new carrinhoModel();
					$o_produto  	  = new produtoModel();
			   		$o_produto->load( $id );
				
					$o_carrinho->setIdProd( $o_produto->getId() );
					$o_carrinho->setDescricaoProd ( $o_produto->getDescricao()  );
					$o_carrinho->setReferenciaProd( $o_produto->getReferencia() );
					$o_carrinho->setImagemProd	  ( $o_produto->getImagem()     );
				
					$num_preco_prod_ = $o_produto->getPreco();
				 
					// Carrinho Grades
					$v_carrinho_grades = array();	
					$int_qtd_total_ = 0;
			
					foreach( $v_itens AS $id_grade => $int_qtd )
					{
						$o_carrinho_grade = new carrinhoGradeModel();		
						$o_grade 		  = new gradeModel();
			   			$o_grade->load( $id_grade);
				
						$o_carrinho_grade->setIdGrade      ( $o_grade->getId() );
						$o_carrinho_grade->setDecricaoGrade( $o_grade->getGrade() );
						$o_carrinho_grade->setQtd		   ( $int_qtd );
						$o_carrinho_grade->setValorTotal   ( $int_qtd * $num_preco_prod_ );
						$o_carrinho_grade->setPreco   	   ( $num_preco_prod_ );
				
						$int_qtd_total_ = $int_qtd_total_ + $int_qtd;
					
						array_push( $v_carrinho_grades, $o_carrinho_grade );  
					}		
					// Fim - Carrinho Grades 
				
				 
					$num_val_total_ = $int_qtd_total_ * $num_preco_prod_;  
				
					$o_carrinho->setPrecoProd  ( $num_preco_prod_ );
					$o_carrinho->setQtdTotal   ( $int_qtd_total_    );
					$o_carrinho->setValorTotal ( $num_val_total_    );
					$o_carrinho->setGrades	   ( $v_carrinho_grades );
					array_push( $v_carrinho, $o_carrinho );
				}
			}
			
    		return $v_carrinho;
    	}
	}			
?>