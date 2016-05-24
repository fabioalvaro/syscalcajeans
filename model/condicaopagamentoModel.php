<?php
	require_once ( 'lib/db.php' );
	
	class condicaopagamentoModel
    {
    	private $int_id;
		private $str_descricao;
		private $num_desconto;
		private $num_valor_pedido;
		
    	
    	// idcondicaopagamento NOT NULL
    	public function setId( $int_id )
		{
			$this->int_id = $int_id;
		}
		
	    public function getId()
		{
			return $this->int_id;
		}
		
  	    // sdescricao Size ( 40 )
  	    public function setDescricao( $str_descricao )
		{
			$this->str_descricao = $str_descricao;
		}
		
	    public function getDescricao()
		{
			return $this->str_descricao;
		}
		
  	    // ndesconto numeric(5,2)
  	    public function setDesconto( $num_desconto )
		{
			$this->num_desconto = $num_desconto;
		}
		
	    public function getDesconto()
		{
			return $this->num_desconto;
		}
		
  	    // nvalor_pedido numeric(15,2)
  	    public function setValor_Pedido( $num_valor_pedido )
		{
			$this->num_desconto = $num_valor_pedido;
		}
		
	    public function getValor_Pedido()
		{
			return $this->num_valor_pedido;
		}
		
		public function getCondicoesPagamento( $num_valor_total )
		{
			$v_condpag    = array();
			if( $num_valor_total > 0 )
			{ 
				$str_where = ' WHERE nvalor_pedido <= '.$num_valor_total.';';
			}
			else 
			{
				$str_where = ';';
			} 
			
        	$str_sqlQuery = 'SELECT * FROM condicaopagamento '.$str_where ;
 
        	$o_db = new DB();
       		$o_db->connection();
			$o_db->executeQuery( $str_sqlQuery );
			
			while( $o_ret = $o_db->fetchObject() )
			{
				$o_condpag = new condicaopagamentoModel();
				
				$o_condpag->setId		   ( $o_ret->id 		   );
				$o_condpag->setDescricao   ( $o_ret->sdescricao    );
				$o_condpag->setValor_Pedido( $o_ret->nvalor_pedido );
				$o_condpag->setDesconto    ( $o_ret->ndesconto     );	
				
				array_push( $v_condpag, $o_condpag );
			}	
			
        	$o_db->disconnect();
    		return $v_condpag;
		}
	}
?>