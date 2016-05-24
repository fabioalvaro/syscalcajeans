<?php
	require_once ( 'lib/db.php' );
	
	class produtofotosModel
	{
		private $int_id;
		private $int_idproduto;
		private $str_foto;
		private $int_sequencia;
		
		// id NOT NULL
    	public function setId( $int_id )
		{
			$this->int_id = $int_id;
		}
		
	    public function getId()
		{
			return $this->int_id;
		}
		
		// idproduto integer
    	public function setIdProduto( $int_idproduto )
		{
			$this->int_idproduto = $int_idproduto;
		}
		
	    public function getIdProduto()
		{
			return $this->int_idproduto;
		}
		
		// sfoto character varying(100)
		public function setFoto( $str_foto )
		{
			$this->str_foto = 'view/img/produto/'.$str_foto;
		}
		
	    public function getFoto()
		{
			return $this->str_foto;
		}

		// isequencia integer
		public function setSequencia( $int_sequencia )
		{
			$this->int_sequencia = $int_sequencia;
		}
		
	    public function getSequencia()
		{
			return $this->int_sequencia;
		}
		
		public function getFotos( $int_idproduto ) 
		{
 			$v_fotos = array();
        	$str_sqlQuery    = "SELECT * 
        						FROM 
        							produto_fotos 
        						WHERE idproduto = ".$int_idproduto." ORDER BY isequencia;";
 
        	$o_db = new DB();
       		$o_db->connection();
			$o_db->executeQuery( $str_sqlQuery );
			
			$int_count = 0;
			while( $o_ret = $o_db->fetchObject() )
			{
				$o_foto = new produtofotosModel();
				$o_foto->setId		 ( $o_ret->id );
				$o_foto->setIdProduto( $o_ret->idproduto );
				$o_foto->setFoto	 ( $o_ret->sfoto.'.jpg' );
				$o_foto->setSequencia( $o_ret->isequencia );
					
				array_push( $v_fotos, $o_foto );
				$int_count += 1;
			}	
			
			if( $int_count == 0 )
			{
				$o_foto = new produtofotosModel();
				$o_foto->setId		 ( 0 );
				$o_foto->setIdProduto( $int_idproduto );
				$o_foto->setFoto	 ( 'sem-img.png'  );
				$o_foto->setSequencia( 1 );
					
				array_push( $v_fotos, $o_foto );
			}
			
        	$o_db->disconnect();
    		return $v_fotos;
    	}
		
		public function getFotoPrincipal( $int_idproduto ) 
		{
        	$str_sqlQuery    = "SELECT * 
        						FROM 
        							produto_fotos 
        						WHERE idproduto = ".$int_idproduto." ORDER BY isequencia LIMIT 1;";
								
			$o_db = new DB();
       		$o_db->connection();
			$o_db->executeQuery( $str_sqlQuery );
		
			$int_count = 0;
			while( $o_ret = $o_db->fetchObject() )
			{	
				$this->setId		 ( $o_ret->id );
				$this->setIdProduto( $o_ret->idproduto );
				$this->setFoto	 ( $o_ret->sfoto.'.jpg' );
				$this->setSequencia( $o_ret->isequencia );
				
				$int_count += 1;
			}
			
			if( $int_count == 0 )
			{	
				$this->setId		 ( 0 );
				$this->setIdProduto( $int_idproduto );
				$this->setFoto	 ( 'sem-img.png'  );
				$this->setSequencia( 1 );
			}
							
 			$o_db->disconnect();
    		return $this->getFoto();
    	}
			
	}
?>