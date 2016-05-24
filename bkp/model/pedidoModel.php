<?php
    require_once ( 'lib/db.php' );
	require_once ( 'lib/functions.php' );
	require_once ( 'model/pedidoitemModel.php' );
    
    class pedidoModel
    {
    	private $int_id;
		private $int_idvendedor;
		private $int_idcliente;
		private $dat_data;
		private $str_transmitido;
		private $str_obs;
		private $num_valor;
		private $int_idcondicaopagamento;
		private $str_email_enviado;
		private $str_importado;
		private $int_pecas;
		private $v_itens;
		private $str_condpag;
		private $str_cnpj_cpfcli;
		private $str_razaosociacli;
		
    	// idr_pedido NOT NULL
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
		
  		// idcliente integer
  		public function setIdCliente( $int_idcliente )
		{
			$this->int_idcliente = $int_idcliente;			
		}
		
		public function getIdCliente()
		{
			return $this->int_idcliente;	
		}
		
  		// ddata NOT NULL
  		public function setData( $dat_data )
		{
			$this->dat_data = $dat_data;			
		}
		
		public function getData()
		{
			return $this->dat_data;	
		}
		
  		// stransmitido Size ( 1 )
  		public function setTransmitido( $str_transmitido )
		{
			$this->str_transmitido = $str_transmitido;			
		}
		
		public function getTransmitido()
		{
			return $this->str_transmitido;	
		}
		 
  		// sobs text
  		public function setObs( $str_obs )
		{
			$this->str_obs = $str_obs;			
		}
		
		public function getObs()
		{
			return $this->str_obs;	
		}
		
  		// nvalor numeric(15,2)
  		public function setValor( $num_valor )
		{
			$this->num_valor = $num_valor;			
		}
		
		public function getValor()
		{
			return $this->num_valor;	
		}
		
  		// idcondicaopagamento 
  		public function setIdCondicaopagamento( $int_idcondicaopagamento )
		{
			$this->int_idcondicaopagamento = $int_idcondicaopagamento;			
		}
		
		public function getIdCondicaopagamento()
		{
			return $this->int_idcondicaopagamento;	
		}
		
  		// semail_enviado Size ( 1 )
  		public function setEmail_Enviado( $str_email_enviado )
		{
			$this->str_email_enviado = $str_email_enviado;			
		}
		
		public function getEmail_Enviado()
		{
			return $this->str_email_enviado;	
		}
		
  	    // simportado Size ( 1 ) DEFAULT 'N'
  	    public function setImportado( $str_importado )
		{
			$this->str_importado = $str_importado;			
		}
		
		public function getImportado()
		{
			return $this->str_importado;	
		}
  	    
  		// ipecas DEFAULT 0
  		public function setPecas( $int_pecas )
		{
			$this->int_pecas = $int_pecas;			
		}
		
		public function getPecas()
		{
			return $this->int_pecas;	
		}
		
		// Vetor de Itens
  		public function setItens( $v_itens )
		{
			$this->v_itens = $v_itens;
		}
		
	    public function getItens()
		{
			return $this->v_itens;
		}
		
		// Cond. Pag. Str
  		public function setCondPagStr( $str_condpag )
		{
			$this->str_condpag = $str_condpag;			
		}
		
		public function getCondPagStr()
		{
			return $this->str_condpag;	
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
		
		public function getTotalPedidos ( $dat_dataini, $dat_datafim, $int_idcli )
		{	
			$str_dataini = Functions::dbdate ( $dat_dataini );
			$str_datafim = Functions::dbdate ( $dat_datafim );
			
			$str_sqlQuery = "SELECT p.*, c.idrepresentante, c.srazaosocial, c.scnpj_cpf FROM r_pedido p JOIN cliente c ON c.id = p.idcliente "; 
			
			if( $_SESSION['_app_user']['tppessoa'] == 'vendedor' )
			{
				$str_sqlQuery .= "WHERE ( ( c.idrepresentante =".$_SESSION['_app_user']['id']." ) ";
				$str_sqlQuery .= "or p.idvendedor =".$_SESSION['_app_user']['id']." ) ";	
				
				if( $int_idcli != -1 )
				{
					$str_sqlQuery .= "and p.idcliente =".$int_idcli." ";
				} 	
			}
			else
			{
				$str_sqlQuery .= "WHERE p.idcliente =".$_SESSION['_app_user']['id']." ";	
			} 
        	
			if($str_dataini <> '' )
				$str_sqlQuery.= " and p.ddata >= '".$str_dataini."'" ;
			if($str_datafim <> '' )
				$str_sqlQuery.= " and p.ddata <= '".$str_datafim."'" ;
			$str_sqlQuery.= " ORDER BY p.ddata desc;";
			
		    $o_db = new DB();
       		$o_db->connection();
			$o_db->executeQuery( $str_sqlQuery );
			$int_linhas = $o_db->numRows();
			
 			$o_db->disconnect();
    		return $int_linhas;	
		}
		
		public function getPedidosPaginados( $int_primeiroreg, $int_numporpagina, $dat_dataini, $dat_datafim, $int_idcli ) 
    	{
			$v_pedidos    = array();
				
			$str_dataini = Functions::dbdate ( $dat_dataini );
			$str_datafim = Functions::dbdate ( $dat_datafim );
			
			$str_sqlQuery = "SELECT p.*, c.idrepresentante, c.srazaosocial, c.scnpj_cpf FROM r_pedido p JOIN cliente c ON c.id = p.idcliente "; 
			
			if( $_SESSION['_app_user']['tppessoa'] == 'vendedor' )
			{
				$str_sqlQuery .= "WHERE ( ( c.idrepresentante =".$_SESSION['_app_user']['id']." ) ";
				$str_sqlQuery .= "or p.idvendedor =".$_SESSION['_app_user']['id']." ) ";	
				
				if( $int_idcli != -1 )
				{
					$str_sqlQuery .= "and p.idcliente =".$int_idcli." ";
				} 	
			}
			else
			{
				$str_sqlQuery .= "WHERE p.idcliente =".$_SESSION['_app_user']['id']." ";	
			} 
        	
			if($str_dataini <> '' )
				$str_sqlQuery.= " and p.ddata >= '".$str_dataini."'" ;
			if($str_datafim <> '' )
				$str_sqlQuery.= " and p.ddata <= '".$str_datafim."'" ;
			$str_sqlQuery.= " ORDER BY p.ddata desc LIMIT " .$int_numporpagina. " OFFSET " . $int_primeiroreg.";";
			
        	$o_db = new DB();
       		$o_db->connection();
			$o_db->executeQuery( $str_sqlQuery );
			
			while( $o_ret = $o_db->fetchObject() )
			{
				$o_pedido = new pedidoModel();
				$o_pedido->setId   ( $o_ret->id );
				$o_pedido->setData ( $o_ret->ddata );
				$o_pedido->setValor( $o_ret->nvalor );
				$o_pedido->setObs  ( $o_ret->sobs );
				$o_pedido->setPecas( $o_ret->ipecas ); 
				$o_pedido->setRazaoSocialCli ( $o_ret->srazaosocial );
				$o_pedido->setCNPJ_CPFCli 	 ( $o_ret->scnpj_cpf );
									
				array_push( $v_pedidos, $o_pedido );
			}	
			
        	$o_db->disconnect();
    		return $v_pedidos;
		}
		
		public function getPedidos( $dat_dataini, $dat_datafim )
		{
			$v_pedidos    = array();
				
			$str_dataini = Functions::dbdate ( $dat_dataini );
			$str_datafim = Functions::dbdate ( $dat_datafim );
			
			
        	$str_sqlQuery = "SELECT * FROM r_pedido WHERE idcliente =".$_SESSION['_app_user']['id']." ";
			if($str_dataini <> '' )
				$str_sqlQuery.= " and ddata >= '".$str_dataini."'" ;
			if($str_datafim <> '' )
				$str_sqlQuery.= " and ddata <= '".$str_datafim."'" ;
			$str_sqlQuery.= " ORDER BY ddata desc;";
			 				
        	$o_db = new DB();
       		$o_db->connection();
			$o_db->executeQuery( $str_sqlQuery );
			
			while( $o_ret = $o_db->fetchObject() )
			{
				$o_pedido = new pedidoModel();
				$o_pedido->setId   ( $o_ret->id );
				$o_pedido->setData ( $o_ret->ddata );
				$o_pedido->setValor( $o_ret->nvalor );
				$o_pedido->setObs  ( $o_ret->sobs );
				$o_pedido->setPecas( $o_ret->ipecas ); 
									
				array_push( $v_pedidos, $o_pedido );
			}	
			
        	$o_db->disconnect();
    		return $v_pedidos;
		}
		
		public function Gravar( $v_carrinho, $int_condpag, $str_obs, $int_qtd_total, $num_val_total, $id_cliente, $id_vendedor )
		{
				
			if ( $id_vendedor == null ) 
			{
				$str_sqlQuery = "INSERT INTO 
								r_pedido ( ddata, stransmitido, 
										   sobs, nvalor, idcondicaopagamento, 
										   semail_enviado, simportado, ipecas,
										   idcliente ) VALUES
    							( current_date, 'N', '$str_obs', $num_val_total, $int_condpag, 
    							  'N', 'N', $int_qtd_total , $id_cliente );";
			}
			else 
			{		
				$str_sqlQuery = "INSERT INTO 
								r_pedido ( ddata, stransmitido, 
										   sobs, nvalor, idcondicaopagamento, 
										   semail_enviado, simportado, ipecas,
										   idcliente, idvendedor  ) VALUES
    							( current_date, 'N', '$str_obs', $num_val_total, $int_condpag, 
    							  'N', 'N', $int_qtd_total , $id_cliente, $id_vendedor );";
			}
			
			$o_db = new DB();
       		$o_db->connection();
			$o_db->executeQuery( $str_sqlQuery );
			
			$o_db->executeQuery( "SELECT MAX( id ) AS id FROM r_pedido;" );
			$o_ret     = $o_db->fetchObject();
			$id_pedido = $o_ret->id;
			
			$id = 0;
			foreach( $v_carrinho AS $o_carrinho )
			{
				$id = $id + 1;
				foreach( $o_carrinho->getGrades() AS $o_carrinhoGrade )
				{	
					$o_pedidoitem = new pedidoitemModel();
					$o_pedidoitem->Grava( $id, $id_pedido, $o_carrinho->getIdProd(), $o_carrinhoGrade->getQtd(),
										  $o_carrinhoGrade->getDescricaoGrade(), $o_carrinhoGrade->getPreco() );
				}	
			}
			
 			$o_db->disconnect();
		} 
		
		public function load( $int_id )
		{	
			$str_sqlQuery   = "SELECT p.*, cp.sdescricao, c.srazaosocial, c.scnpj_cpf FROM r_pedido p ";
			$str_sqlQuery  .= "JOIN condicaopagamento cp ON cp.id = p.idcondicaopagamento JOIN cliente c ON c.id = p.idcliente ";
			$str_sqlQuery  .= "WHERE p.id = ".$int_id.";";
			  
			$o_db = new DB();
       		$o_db->connection();
			$o_db->executeQuery( $str_sqlQuery );
			$o_ret = $o_db->fetchObject();
			
			$this->setId         ( $o_ret->id );
			$this->setData       ( $o_ret->ddata );
			$this->setValor      ( $o_ret->nvalor );
			$this->setObs        ( $o_ret->sobs );
			$this->setPecas      ( $o_ret->ipecas );
			$this->setIdVendedor ( $o_ret->idvendedor ); 
			$this->setTransmitido( $o_ret->stransmitido );
			$this->setIdCondicaopagamento( $o_ret->idcondicaopagamento );						
			$this->setEmail_Enviado( $o_ret->semail_enviado );
			$this->setImportado    ( $o_ret->simportado );		
			$this->setIdCliente    ( $o_ret->idcliente );
			$this->setCondPagStr( $o_ret->sdescricao );		
			$this->setRazaoSocialCli ( $o_ret->srazaosocial );
			$this->setCNPJ_CPFCli 	 ( $o_ret->scnpj_cpf );
			
						  						
  			$o_pedidoitem = new pedidoitemModel();
			$this->setItens( $o_pedidoitem->getItensPedido ( $this->getId() ) );	
						
 			$o_db->disconnect();
    		return $this;
		}
    }
?>