<?php  
	require_once ( 'lib/db.php' );
	    
    class clienteModel 
    {		
    	private $int_id;
		private $str_razaosocial;
		private $str_cnpj_cpf;
		private $str_inscricao;
		private $str_logradouro;
		private $str_numero;
		private $str_bairro;
		private $str_cidade;
		private $str_uf;
		private $str_complemento;
		private $str_nomefantasia;
		private $str_contato;
		private $str_email;
		private $str_novo;
		private $int_ativo;
		private $int_idrepresentante;
		private $str_fone;
		private $str_cep;
		private $str_entrega_logradouro;
		private $str_entrega_numero;
		private $str_entrega_bairro;
		private $str_entrega_cidade;
		private $str_entrega_cep;
		private $str_entrega_complemento;
		private $str_senha;  
		private $boo_logado;
					
		// id NOT NULL
	    public function setId( $int_id )
		{
			$this->int_id = $int_id;
		}
		
	    public function getId()
		{
			return $this->int_id;
		}
		
		// srazaosocial Size( 100 ) NOT NULL
		public function setRazaoSocial( $str_razaosocial )
		{
			$this->str_razaosocial = $str_razaosocial;
		}
	
		public function getRazaoSocial()
		{
			return $this->str_razaosocial;
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
  		
  		// sinscricao Size ( 20 ) NOT NULL
  		public function setInscricao( $str_inscricao )
		{
			$this->str_inscricao = $str_inscricao;			
		}
		
		public function getInscricao()
		{
			return $this->str_inscricao;	
		}
		
  		// slogradouro Size ( 100 ) NOT NULL
  		public function setLogradouro( $str_logradouro )
		{
			$this->str_logradouro = $str_logradouro;			
		}
		
		public function getLogradouro()
		{
			return $this->str_logradouro;	
		}
		
  		// snumero Size ( 20 ) NOT NULL
  		public function setNumero( $str_numero )
		{
			$this->str_numero = $str_numero;			
		}
		
		public function getNumero()
		{
			return $this->str_numero;	
		}
  		
  		// sbairro Size ( 50 ) NOT NULL
  		public function setBairro( $str_bairro )
		{
			$this->str_bairro = $str_bairro;			
		}
		
		public function getBairro()
		{
			return $this->str_bairro;	
		}
		
  		// scidade Size ( 50 ) NOT NULL
  		public function setCidade( $str_cidade )
		{
			$this->str_cidade = $str_cidade;			
		}
		
		public function getCidade()
		{
			return $this->str_cidade;	
		}
		
  		// suf Size ( 2 ) NOT NULL
  		public function setUF( $str_uf )
		{
			$this->str_uf = $str_uf;			
		}
		
		public function getUF()
		{
			return $this->str_uf;	
		}
		
  		// scomplemento Size ( 50 )
  		public function setComplemento( $str_complemento )
		{
			$this->str_complemento = $str_complemento;			
		}
		
		public function getComplemento()
		{
			return $this->str_complemento;	
		}
		
  		// snomefantasia Size ( 100 )
  		public function setNomeFantasia( $str_nomefantasia )
		{
			$this->str_nomefantasia = $str_nomefantasia;			
		}
		
		public function getNomeFantasia()
		{
			return $this->str_nomefantasia;	
		}
		
  		// scontato Size ( 50 )
  		public function setContato( $str_contato )
		{
			$this->str_contato = $str_contato;			
		}
		
		public function getContato()
		{
			return $this->str_contato;	
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
		
  		// snovo Size ( 1 ) NOT NULL
  		public function setNovo( $str_novo )
		{
			$this->str_novo = $str_novo;			
		}
		
		public function getNovo()
		{
			return $this->str_novo;	
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
		
  		// idrepresentante DEFAULT 0
  		public function setIdRepresentante( $int_idrepresentante )
		{
			$this->int_idrepresentante = $int_idrepresentante;			
		}
		
		public function getIdRepresentante()
		{
			return $this->int_idrepresentante;	
		}
		
  		// sfone Size ( 20 )
  		public function setFone( $str_fone )
		{
			$this->str_fone = $str_fone;			
		}
		
		public function getFone()
		{
			return $this->str_fone;	
		}
		
  		// scep Size ( 8 )	
		public function setCep( $str_cep )
		{
			$this->str_cep = $str_cep;			
		}
		
		public function getCep()
		{
			return $this->str_cep;	
		}	
		
		// sentrega_logradouro Size ( 100 ) 
  		public function setEntregaLogradouro( $str_entrega_logradouro )
		{
			$this->str_entrega_logradouro = $str_entrega_logradouro;			
		}
						
		public function getEntregaLogradouro()
		{
			return $this->str_entrega_logradouro;	
		}
		
  		// snumero Size ( 20 ) NOT NULL
  		public function setEntregaNumero( $str_entrega_numero )
		{
			$this->str_entrega_numero = $str_entrega_numero;			
		}
		
		public function getEntregaNumero()
		{
			return $this->str_entrega_numero;	
		}
  		
  		// sbairro Size ( 50 ) NOT NULL
  		public function setEntregaBairro( $str_entrega_bairro )
		{
			$this->str_entrega_bairro = $str_entrega_bairro;			
		}
		
		public function getEntregaBairro()
		{
			return $this->str_entrega_bairro;	
		}
		
  		// scidade Size ( 50 ) NOT NULL
  		public function setEntregaCidade( $str_entrega_cidade )
		{
			$this->str_entrega_cidade = $str_entrega_cidade;			
		}
		
		public function getEntregaCidade()
		{
			return $this->str_entrega_cidade;	
		}
		
  		// scomplemento Size ( 50 )
  		public function setEntregaComplemento( $str_entrega_complemento )
		{
			$this->str_entrega_complemento = $str_entrega_complemento;			
		}
		
		public function getEntregaComplemento()
		{
			return $this->str_entrega_complemento;	
		}
		
    	// scep Size ( 8 )	
		public function setEntregaCep( $str_entrega_cep )
		{
			$this->str_entrega_cep = $str_entrega_cep;			
		}
		
		public function getEntregaCep()
		{
			return $this->str_entrega_cep;	
		}
		
		// ssenha Size ( 100 ) Not Null	
		public function setSenha( $str_senha )
		{
			$this->str_senha = $str_senha;			
		}
		
		public function getSenha()
		{
			return $this->str_senha;	
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
		 					       cliente c 
		 					   WHERE 
		 					   	   c.scnpj_cpf = '$str_login' and ( c.ssenha = '$str_hast_senha' or c.ssenha is null );";
			 
			$o_db = new DB();
       		$o_db->connection();
			$o_db->executeQuery( $str_sqlQuery );
			
			If( $o_db->numRows() > 0 )
			{
				$o_ret = $o_db->fetchObject();
			
				$this->setId( $o_ret->id );
				$this->setRazaoSocial ( $o_ret->srazaosocial  );
				$this->setNomeFantasia( $o_ret->snomefantasia );
				$this->setCNPJ_CPF( $o_ret->scnpj_cpf );
				$this->setEmail( $o_ret->semail );
			
				$this->setLogado( true );
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
			$str_sqlQuery   = 'SELECT * FROM cliente WHERE id = '.$int_id.';';
			$o_db = new DB();
       		$o_db->connection();
			$o_db->executeQuery( $str_sqlQuery );
			$o_ret = $o_db->fetchObject();
			
			$this->setId			( $o_ret->id );
			$this->setNomeFantasia	( $o_ret->snomefantasia );
			$this->setContato		( $o_ret->scontato );
			$this->setCNPJ_CPF		( $o_ret->scnpj_cpf );
			$this->setIdRepresentante	( $o_ret->idrepresentante );
			$this->setEmail			( $o_ret->semail );
			$this->setInscricao		( $o_ret->sinscricao );
			$this->setBairro		( $o_ret->sbairro );
			$this->setFone			( $o_ret->sfone );
			$this->setRazaoSocial	( $o_ret->srazaosocial );
			$this->setUF			( $o_ret->suf );
			$this->setLogradouro	( $o_ret->slogradouro );
			$this->setCidade		( $o_ret->scidade );
			$this->setCep			( $o_ret->scep );
			$this->setNumero		( $o_ret->snumero );
			$this->setComplemento	( $o_ret->scomplemento );
			$this->setSenha			( $o_ret->ssenha );
			$this->setNovo			( $o_ret->snovo );
			$this->setEntregaNumero	( $o_ret->sentrega_numero );
			$this->setEntregaLogradouro( $o_ret->sentrega_logradouro );
			$this->setEntregaCidade	( $o_ret->sentrega_cidade );
			$this->setEntregaBairro ( $o_ret->sentrega_bairro );
			$this->setEntregaCep	( $o_ret->sentrega_cep );
			$this->setEntregaComplemento( $o_ret->sentrega_complemento );
			$this->setAtivo			( $o_ret->iativo );
									
 			$o_db->disconnect();
    		return $this;
		}

		public function update()
		{
			$str_sqlQuery  = "UPDATE cliente SET ";
			$str_sqlQuery .= "snomefantasia ='".trim( $this->getNomeFantasia() )."', ";
			$str_sqlQuery .= "scontato ='".trim( $this->getContato() )."', ";
			$str_sqlQuery .= "scnpj_cpf ='".trim( $this->getCNPJ_CPF() )."', ";
			$str_sqlQuery .= "semail ='".trim( $this->getEmail() )."', ";
			$str_sqlQuery .= "sinscricao ='".trim( $this->getInscricao() )."', ";
			$str_sqlQuery .= "sbairro ='".trim( $this->getBairro() )."', ";
			$str_sqlQuery .= "srazaosocial ='".trim( $this->getRazaoSocial() )."', ";
			$str_sqlQuery .= "sfone ='".trim( $this->getFone() )."', ";
			$str_sqlQuery .= "suf ='".trim( $this->getUF() ) ."', ";
			$str_sqlQuery .= "slogradouro ='".trim( $this->getLogradouro() )."', ";
			$str_sqlQuery .= "scidade ='".trim( $this->getCidade() )."', ";
			$str_sqlQuery .= "scep ='".trim( $this->getCep() )."', ";
			$str_sqlQuery .= "snumero ='".trim( $this->getNumero() )."', ";
			$str_sqlQuery .= "scomplemento ='".trim( $this->getComplemento() )."', ";
			$str_sqlQuery .= "sentrega_numero ='".trim( $this->getEntregaNumero() )."', ";
			$str_sqlQuery .= "sentrega_logradouro ='".trim( $this->getEntregaLogradouro() )."', ";
			$str_sqlQuery .= "sentrega_cidade ='".trim( $this->getEntregaCidade() )."', ";
			$str_sqlQuery .= "sentrega_bairro ='".trim( $this->getEntregaBairro() )."', ";
			$str_sqlQuery .= "sentrega_cep ='".trim( $this->getEntregaCep() )."', ";
			$str_sqlQuery .= "sentrega_complemento ='".trim( $this->getEntregaComplemento() )."' ";
			$str_sqlQuery .= "WHERE id = ". $this->getId();
			
			$o_db = new DB();
       		$o_db->connection();
			$o_db->executeQuery( $str_sqlQuery );
			$o_db->disconnect(); 
		}
		
		public function updateSenha()
		{
			$str_sqlQuery  = "UPDATE cliente SET ";
			$str_sqlQuery .= "ssenha ='".sha1( $this->getSenha() )."' ";
			$str_sqlQuery .= "WHERE id = ". $this->getId();	
			
			$o_db = new DB();
       		$o_db->connection();
			$o_db->executeQuery( $str_sqlQuery );
			$o_db->disconnect(); 
		}
		
		public function getTotalClientes ( $str_busca )
		{	
			$str_sqlQuery  = "SELECT * FROM cliente ";
			$str_sqlQuery .= "WHERE idrepresentante = ".$_SESSION['_app_user']['id']." ";
			
			if ( $str_busca != NULL) 
  			{
            	$str_sqlQuery.=" and ( ( srazaosocial  LIKE '%" .strtoupper ( $str_busca ). "%' ) or
            						   ( scnpj_cpf     LIKE '%" .strtoupper ( $str_busca ). "%' ) )";
        	}
			
			$str_sqlQuery.= " ORDER BY srazaosocial;";
			
		    $o_db = new DB();
       		$o_db->connection();
			$o_db->executeQuery( $str_sqlQuery );
			$int_linhas = $o_db->numRows();
			
 			$o_db->disconnect();
    		return $int_linhas;	
		}
		
		public function getClientesPaginados( $int_primeiroreg, $int_numporpagina, $str_busca ) 
    	{
			$v_clientes    = array();
			
			$str_sqlQuery  = "SELECT * FROM cliente ";
			$str_sqlQuery .= "WHERE idrepresentante = ".$_SESSION['_app_user']['id']." ";
			
			if ( $str_busca != NULL) 
  			{
            	$str_sqlQuery.=" and ( ( srazaosocial  LIKE '%" .strtoupper ( $str_busca ). "%' ) or
            						   ( scnpj_cpf     LIKE '%" .strtoupper ( $str_busca ). "%' ) )";
        	}
			
			$str_sqlQuery.= " ORDER BY srazaosocial LIMIT " .$int_numporpagina. " OFFSET " . $int_primeiroreg.";";
			 
			
        	$o_db = new DB();
       		$o_db->connection();
			$o_db->executeQuery( $str_sqlQuery );
			
			while( $o_ret = $o_db->fetchObject() )
			{
				$o_cliente = new ClienteModel();		
				$o_cliente->setId				 ( $o_ret->id );
				$o_cliente->setNomeFantasia		 ( $o_ret->snomefantasia );
				$o_cliente->setContato			 ( $o_ret->scontato );
				$o_cliente->setCNPJ_CPF			 ( $o_ret->scnpj_cpf );
				$o_cliente->setIdRepresentante	 ( $o_ret->idrepresentante );
				$o_cliente->setEmail			 ( $o_ret->semail );
				$o_cliente->setInscricao		 ( $o_ret->sinscricao );
				$o_cliente->setBairro			 ( $o_ret->sbairro );
				$o_cliente->setFone			 	 ( $o_ret->sfone );
				$o_cliente->setRazaoSocial		 ( $o_ret->srazaosocial );
				$o_cliente->setUF				 ( $o_ret->suf );
				$o_cliente->setLogradouro		 ( $o_ret->slogradouro );
				$o_cliente->setCidade			 ( $o_ret->scidade );
				$o_cliente->setCep				 ( $o_ret->scep );
				$o_cliente->setNumero			 ( $o_ret->snumero );
				$o_cliente->setComplemento		 ( $o_ret->scomplemento );
				$o_cliente->setSenha			 ( $o_ret->ssenha );
				$o_cliente->setNovo				 ( $o_ret->snovo );
				$o_cliente->setEntregaNumero	 ( $o_ret->sentrega_numero );
				$o_cliente->setEntregaLogradouro ( $o_ret->sentrega_logradouro );
				$o_cliente->setEntregaCidade	 ( $o_ret->sentrega_cidade );
				$o_cliente->setEntregaBairro 	 ( $o_ret->sentrega_bairro );
				$o_cliente->setEntregaCep		 ( $o_ret->sentrega_cep );
				$o_cliente->setEntregaComplemento( $o_ret->sentrega_complemento );
				$o_cliente->setAtivo			 ( $o_ret->iativo );
									
				array_push( $v_clientes, $o_cliente);
			}
						
        	$o_db->disconnect();
    		return $v_clientes;
		}

		public function getClientes() 
    	{
			$v_clientes    = array();
			
			$str_sqlQuery  = "SELECT * FROM cliente ";
			$str_sqlQuery .= "WHERE idrepresentante = ".$_SESSION['_app_user']['id']." ";
			$str_sqlQuery .= "ORDER BY srazaosocial;";
			
        	$o_db = new DB();
       		$o_db->connection();
			$o_db->executeQuery( $str_sqlQuery );
			
			while( $o_ret = $o_db->fetchObject() )
			{
				$o_cliente = new ClienteModel();		
				$o_cliente->setId				 ( $o_ret->id );
				$o_cliente->setNomeFantasia		 ( $o_ret->snomefantasia );
				$o_cliente->setContato			 ( $o_ret->scontato );
				$o_cliente->setCNPJ_CPF			 ( $o_ret->scnpj_cpf );
				$o_cliente->setIdRepresentante	 ( $o_ret->idrepresentante );
				$o_cliente->setEmail			 ( $o_ret->semail );
				$o_cliente->setInscricao		 ( $o_ret->sinscricao );
				$o_cliente->setBairro			 ( $o_ret->sbairro );
				$o_cliente->setFone			 	 ( $o_ret->sfone );
				$o_cliente->setRazaoSocial		 ( $o_ret->srazaosocial );
				$o_cliente->setUF				 ( $o_ret->suf );
				$o_cliente->setLogradouro		 ( $o_ret->slogradouro );
				$o_cliente->setCidade			 ( $o_ret->scidade );
				$o_cliente->setCep				 ( $o_ret->scep );
				$o_cliente->setNumero			 ( $o_ret->snumero );
				$o_cliente->setComplemento		 ( $o_ret->scomplemento );
				$o_cliente->setSenha			 ( $o_ret->ssenha );
				$o_cliente->setNovo				 ( $o_ret->snovo );
				$o_cliente->setEntregaNumero	 ( $o_ret->sentrega_numero );
				$o_cliente->setEntregaLogradouro ( $o_ret->sentrega_logradouro );
				$o_cliente->setEntregaCidade	 ( $o_ret->sentrega_cidade );
				$o_cliente->setEntregaBairro 	 ( $o_ret->sentrega_bairro );
				$o_cliente->setEntregaCep		 ( $o_ret->sentrega_cep );
				$o_cliente->setEntregaComplemento( $o_ret->sentrega_complemento );
				$o_cliente->setAtivo			 ( $o_ret->iativo );
									
				array_push( $v_clientes, $o_cliente);
			}
						
        	$o_db->disconnect();
    		return $v_clientes;
		}
    }
?>