<?php
    require_once ( 'lib/db.php' );
    
    class vendedorModel
    {		
		private $int_id;
		private $str_razaosocial;
		private $str_senha;
		private $str_email;
		private $str_fone;
		private $str_cnpj_cpf;
		private $int_idtabpreco;
		private $boo_logado;

  		// idvendedor NOT NULL
  		public function setId( $int_id )
		{
			$this->int_id = $int_id;
		}
		
	    public function getId()
		{
			return $this->int_id;
		}
		
  		// srazaosocial Size ( 50 ) NOT NULL
  		public function setRazaoSocial( $str_razaosocial )
		{
			$this->str_razaosocial = $str_razaosocial;
		}
	
		public function getRazaoSocial()
		{
			return $this->str_razaosocial;
		}
		
  		// ssenha Size ( 10 ) NOT NULL
  		public function setSenha( $str_senha )
		{
			$this->str_senha = $str_senha;
		}
	
		public function getSenha()
		{
			return $this->str_senha;
		}
  		// semail Size ( 100 ) NOT NULL
  		public function setEmail( $str_email )
		{
			$this->str_email = $str_email;			
		}
		
		public function getEmail()
		{
			return $this->str_email;	
		}
  		
  		// sfone Size ( 15 ) 
  		public function setFone( $str_fone )
		{
			$this->str_fone = $str_fone;			
		}
		
		public function getFone()
		{
			return $this->str_fone;	
		}
		
		// scnpj_cpf Size( 20 ) NOT NULL
  		public function setCNPJ_CPF( $str_cnpj_cpf )
		{
			$this->str_cnpj_cpf = $str_cnpj_cpf;			
		}
		
		public function getCNPJ_CPF()
		{
			return $this->str_cnpj_cpf;	
		}
		
		// idtabela_preco integer
  		public function setIdTabPreco( $int_idtabpreco )
  		{
  			$this->int_idtabpreco = $int_idtabpreco;
  		}
		
	    public function getIdTabPreco()
		{
			return $this->int_idtabpreco;
		}
		
		// Logado
		private function setLogado( $boo_logado )
		{
			$this->boo_logado = $boo_logado;			
		}
		
		public function getLogado()
		{
			return $this->boo_logado;	
		}
		
		public function autenticar ( $str_login, $str_senha )
		{
		    $str_hast_senha = sha1( $str_senha );	
		 	$str_sqlQuery   = "SELECT * 
		 					   FROM 
		 					       vendedor v 
		 					   WHERE 
		 					   	   v.scnpj_cpf = '$str_login' and ( v.ssenha = '$str_hast_senha' or v.ssenha is null );";
			 
			$o_db = new DB();
       		$o_db->connection();
			$o_db->executeQuery( $str_sqlQuery );
			
			If( $o_db->numRows() > 0 )
			{
				$o_ret = $o_db->fetchObject();
			
				$this->setId		  ( $o_ret->id );
				$this->setEmail		  ( $o_ret->semail );
				$this->setCNPJ_CPF	  ( $o_ret->scnpj_cpf );
				$this->setRazaoSocial ( $o_ret->srazaosocial  );
				$this->setLogado	  ( true );				
 				$o_db->disconnect();
			}
			else 
			{
				$this->setId( 0 );	
				$this->setLogado( false );	 
			}	
    		return $this;	
		}
		
		public function load( $int_id )
		{	
			$str_sqlQuery   = 'SELECT * FROM vendedor WHERE id = '.$int_id.';';
			$o_db = new DB();
       		$o_db->connection();
			$o_db->executeQuery( $str_sqlQuery );
			$o_ret = $o_db->fetchObject();
					
			$this->setId		  ( $o_ret->id );
			$this->setRazaoSocial ( $o_ret->srazaosocial  );
			$this->setEmail		  ( $o_ret->semail );
			$this->setFone		  ( $o_ret->sfone );
			$this->setCNPJ_CPF	  ( $o_ret->scnpj_cpf );
									
 			$o_db->disconnect();
    		return $this;
		}

		public function update()
		{
			$str_sqlQuery  = "UPDATE vendedor SET ";
			$str_sqlQuery .= "srazaosocial = '".trim( $this->getRazaoSocial() )."', ";
  			$str_sqlQuery .= "semail = '".trim( $this->getEmail() )."', ";
  			$str_sqlQuery .= "sfone = '".trim( $this->getFone() )."', ";
  			$str_sqlQuery .= "scnpj_cpf ='".trim( $this->getCNPJ_CPF() )."' ";
			$str_sqlQuery .= "WHERE id = ". $this->getId();
			
			$o_db = new DB();
       		$o_db->connection();
			$o_db->executeQuery( $str_sqlQuery );
			$o_db->disconnect(); 
		}
		
		public function updateSenha()
		{
			$str_sqlQuery  = "UPDATE vendedor SET ";
			$str_sqlQuery .= "ssenha ='".sha1( $this->getSenha() )."' ";
			$str_sqlQuery .= "WHERE id = ". $this->getId();	
			
			$o_db = new DB();
       		$o_db->connection();
			$o_db->executeQuery( $str_sqlQuery );
			$o_db->disconnect(); 
		}
    }
?>