<?php
    require_once ( 'lib/db.php' );
	
    class pedidoitemModel
    {
    	private $int_id;
		private $int_idpedido;
		private $int_idvendedor;
		private $int_idproduto;
		private $str_produto;
		private $int_quantidade;
		private $str_grade;
		private $num_preco;
		private $int_qtdgrades;

		
    	// idr_pedido_item NOT NULL
    	public function setId( $int_id )
		{
			$this->int_id = $int_id;
		}
		
	    public function getId()
		{
			return $this->int_id;
		}
  		
  		// idr_pedido NOT NULL
  		public function setIdPedido( $int_idpedido )
		{
			$this->int_idpedido = $int_idpedido;
		}
		
	    public function getIdPedido()
		{
			return $this->int_idpedido;
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
		
  		// idproduto NOT NULL
  		public function setIdProduto( $int_idproduto )
		{
			$this->int_idproduto = $int_idproduto;
		}
		
	    public function getIdProduto()
		{
			return $this->int_idproduto;
		}
		
		// Produto Str
  		public function setProdutoStr( $str_produto )
		{
			$this->str_produto = $str_produto;
		}
		
	    public function getProdutoStr()
		{
			return $this->str_produto;
		}
  		
  		// iquantidade NOT NULL
  		public function setQuantidade( $int_quantidate )
		{
			$this->int_quantidade = $int_quantidate;
		}
		
	    public function getQuantidade()
		{
			return $this->int_quantidade;
		}
		
  		// sgrade Size ( 3 ) NOT NULL
  		public function setGrade( $str_grade )
		{
			$this->str_grade = $str_grade;
		}
		
	    public function getGrade()
		{
			return $this->str_grade;
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
		
		// Quantidade de Grades
  		public function setQtdGrades( $int_qtdgrades )
		{
			$this->int_qtdgrades = $int_qtdgrades;
		}
		
	    public function getQtdGrades()
		{
			return $this->int_qtdgrades;
		}
		
		public function Grava( $id, $id_pedido, $id_prod, $int_qtd, $str_grade, $num_preco )
		{			
			$str_sqlQuery = "INSERT INTO 
								r_pedido_item ( idr_pedido_item, idr_pedido, 
										   		idproduto, iquantidade, sgrade, npreco ) VALUES
    							( $id, $id_pedido, $id_prod, $int_qtd, '$str_grade', $num_preco );";
			
			echo $str_sqlQuery;
			$o_db = new DB();
       		$o_db->connection();
			$o_db->executeQuery( $str_sqlQuery );
			
 			$o_db->disconnect();
		}
		
		public function getItensPedido( $int_id )
		{		
			$v_itens 	  = array();
        	$str_sqlQuery = "SELECT pi.*, ";
        	$str_sqlQuery.= "( SELECT COUNT( piaux.* ) FROM r_pedido_item piaux WHERE piaux.idr_pedido = pi.idr_pedido and piaux.idproduto = pi.idproduto ) as qtd_grades, ";
			$str_sqlQuery.= "pr.sdescricao FROM r_pedido_item pi join produto pr on pr.id = pi.idproduto ";
        	$str_sqlQuery.=	"WHERE pi.idr_pedido = ".$int_id." ORDER BY pi.idproduto;";
			
        	$o_db = new DB();
       		$o_db->connection();
			$o_db->executeQuery( $str_sqlQuery );
			
			while( $o_ret = $o_db->fetchObject() )
			{
				$o_pedidoitem = new pedidoitemModel();
				$o_pedidoitem->setId         ( $o_ret->idr_pedido_item );
				$o_pedidoitem->setIdPedido   ( $o_ret->idr_pedido );
				$o_pedidoitem->setIdProduto  ( $o_ret->idproduto );
  				$o_pedidoitem->setQuantidade ( $o_ret->iquantidade );
 	 			$o_pedidoitem->setGrade      ( $o_ret->sgrade ); 
  				$o_pedidoitem->setPreco      ( $o_ret->npreco );
				$o_pedidoitem->setQtdGrades  ( $o_ret->qtd_grades );
				$o_pedidoitem->setProdutoStr ( $o_ret->sdescricao );
				
					
				array_push( $v_itens, $o_pedidoitem );
			}	
			
        	$o_db->disconnect();
    		return $v_itens;
		}
    }
?>