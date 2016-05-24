<?php
    require_once ( 'lib/db.php' );
	require_once ( 'lib/functions.php' );
	
	class tituloModel
	{
		private $int_id;
		private $int_idcliente;
		private $str_documento;
		private $str_boleto;
		private $dat_emissao;
		private $dat_vencimento;
		private $dat_recebimento;
		private $num_valor;
		private $str_cnpj_cpfcli;
		private $str_razaosociacli;
		
		// idtitulos integer NOT NULL,
		public function setId( $int_id )
		{
			$this->int_id = $int_id;
		}
		
	    public function getId()
		{
			return $this->int_id;
		}
		
  		// idcliente integer NOT NULL
  		public function setIdCliente( $int_idcliente )
		{
			$this->int_idcliente = $int_idcliente;
		}
		
	    public function getIdCliente()
		{
			return $this->int_idcliente;
		}
		
  		// sdocumento character varying(30) NOT NULL
  		public function setDocumento( $str_documento )
		{
			$this->str_documento = $str_documento;
		}
		
	    public function getDocumento()
		{
			return $this->str_documento;
		}
		
  		// sboleto character varying(20)
  		public function setBoleto( $str_boleto )
		{
			$this->str_boleto = $str_boleto;
		}
		
	    public function getBoleto()
		{
			return $this->str_boleto;
		}
		
  		// demissao date
  		public function setDtEmissao( $dat_emissao )
		{
			$this->dat_emissao = $dat_emissao;
		}
		
	    public function getDtEmissao()
		{
			return $this->dat_emissao;
		}
		
  		// dvencimento date
  		public function setDtVencimento( $dat_vencimento )
		{
			$this->dat_vencimento = $dat_vencimento;
		}
		
	    public function getDtVencimento()
		{
			return $this->dat_vencimento;
		}
		
  		// drecebimento date,
  		public function setDtRecebimento( $dat_recebimento )
		{
			$this->dat_recebimento = $dat_recebimento;
		}
		
	    public function getDtRecebimento()
		{
			return $this->dat_recebimento;
		}
		
  		// nvalor numeric(15,2) DEFAULT 0
  		public function setValor( $num_valor )
		{
			$this->num_valor = $num_valor;
		}
		
	    public function getValor()
		{
			return $this->num_valor;
		}
		
		// CNPJ / CPF Cliente
  		public function setCNPJ_CPFCli( $str_cnpj_cpfcli )
		{
			$this->str_cnpj_cpfcli = $str_cnpj_cpfcli;			
		}
		
		public function getCNPJ_CPFCli()
		{
			return $this->str_cnpj_cpfcli;	
		}
		
		// Razão Social Cliente
  		public function setRazaoSocialCli( $str_razaosocialcli )
		{
			$this->str_razaosociacli = $str_razaosocialcli;			
		}
		
		public function getRazaoSocialCli()
		{
			return $this->str_razaosociacli;	
		}
  	
		public function getTitulos()
		{
			$v_titulos 	  = array();
        	$str_sqlQuery = "SELECT * 
        						FROM 
        							titulos 
        					WHERE idcliente = ".$_SESSION['_app_user']['id'].";";
 
        	$o_db = new DB();
       		$o_db->connection();
			$o_db->executeQuery( $str_sqlQuery );
			
			while( $o_ret = $o_db->fetchObject() )
			{
				$o_titulo = new TituloModel();		
				$o_titulo->setId		   ( $o_ret->idtitulos   );
				$o_titulo->setIdCliente	   ( $o_ret->idcliente   );
				$o_titulo->setBoleto	   ( $o_ret->sboleto     );
				$o_titulo->setDtEmissao	   ( $o_ret->demissao    );
				$o_titulo->setDtVencimeto  ( $o_ret->dvencimento );
				$o_titulo->setDtRecebimento( $o_ret->drecebimento);
				$o_titulo->setValor		   ( $o_ret->nvalor      );
				$o_titulo->setDocumento    ( $o_ret->sdocumento  );
				array_push( $v_titulos, $o_titulo);
			}
						
        	$o_db->disconnect();
    		return $v_titulos;
		}
		
		public function getTotalTitulos ( $dat_dataini, $dat_datafim, $int_idcli )
		{	
			$str_dataini = Functions::dbdate ( $dat_dataini );
			$str_datafim = Functions::dbdate ( $dat_datafim );
			
        	$str_sqlQuery = "SELECT t.*, c.srazaosocial, c.scnpj_cpf FROM titulos t JOIN cliente c on c.id = t.idcliente "; 
        				
			if( $_SESSION['_app_user']['tppessoa'] == 'vendedor' )
			{
				$str_sqlQuery .= "WHERE ( c.idrepresentante =".$_SESSION['_app_user']['id']." ) ";
				
				if( $int_idcli != -1 )
				{
					$str_sqlQuery .= "and t.idcliente =".$int_idcli." ";
				} 	
			}
			else
			{
				$str_sqlQuery .= "WHERE t.idcliente =".$_SESSION['_app_user']['id']." ";	
			}
							
			if($str_dataini <> '' )
				$str_sqlQuery.= " and dvencimento >= '".$str_dataini."'" ;
			if($str_datafim <> '' )
				$str_sqlQuery.= " and dvencimento <= '".$str_datafim."'" ;
			$str_sqlQuery.= " ORDER BY dvencimento desc;";
			
		    $o_db = new DB();
       		$o_db->connection();
			$o_db->executeQuery( $str_sqlQuery );
			$int_linhas = $o_db->numRows();
			
 			$o_db->disconnect();
    		return $int_linhas;	
		}
		
		public function getTitulosPaginados( $int_primeiroreg, $int_numporpagina, $dat_dataini, $dat_datafim,  $int_idcli ) 
    	{
			$v_titulos    = array();
				
			$str_dataini = Functions::dbdate ( $dat_dataini );
			$str_datafim = Functions::dbdate ( $dat_datafim );
			
			$str_sqlQuery = "SELECT t.*, c.srazaosocial, c.scnpj_cpf FROM titulos t JOIN cliente c on c.id = t.idcliente ";
			
			if( $_SESSION['_app_user']['tppessoa'] == 'vendedor' )
			{
				$str_sqlQuery .= "WHERE ( c.idrepresentante =".$_SESSION['_app_user']['id']." ) ";
				
				if( $int_idcli != -1 )
				{
					$str_sqlQuery .= "and t.idcliente =".$int_idcli." ";
				} 	
			}
			else
			{
				$str_sqlQuery .= "WHERE t.idcliente =".$_SESSION['_app_user']['id']." ";	
			}
							
			if($str_dataini <> '' )
				$str_sqlQuery.= " and dvencimento >= '".$str_dataini."'" ;
			if($str_datafim <> '' )
				$str_sqlQuery.= " and dvencimento <= '".$str_datafim."'" ;
			$str_sqlQuery.= " ORDER BY dvencimento desc LIMIT " .$int_numporpagina. " OFFSET " . $int_primeiroreg.";";
			
        	$o_db = new DB();
       		$o_db->connection();
			$o_db->executeQuery( $str_sqlQuery );
			
			while( $o_ret = $o_db->fetchObject() )
			{
				$o_titulo = new TituloModel();		
				$o_titulo->setId		    ( $o_ret->idtitulos   );
				$o_titulo->setIdCliente	    ( $o_ret->idcliente   );
				$o_titulo->setBoleto	    ( $o_ret->sboleto     );
				$o_titulo->setDtEmissao	    ( $o_ret->demissao    );
				$o_titulo->setDtVencimento  ( $o_ret->dvencimento );
				$o_titulo->setDtRecebimento ( $o_ret->drecebimento);
				$o_titulo->setDocumento     ( $o_ret->sdocumento  );
				$o_titulo->setValor		    ( $o_ret->nvalor      );
				$o_titulo->setRazaoSocialCli( $o_ret->srazaosocial );
				$o_titulo->setCNPJ_CPFCli 	( $o_ret->scnpj_cpf );
				
				array_push( $v_titulos, $o_titulo);
			}
						
        	$o_db->disconnect();
    		return $v_titulos;
		}
	}
	
?>