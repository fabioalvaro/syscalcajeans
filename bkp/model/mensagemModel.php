<?php
    require_once ( 'lib/db.php' );
	require_once ( 'lib/functions.php' );
	
	class mensagemModel
	{
		private $int_id;
		private $int_idvendedor;
		private $dat_datainicio;
		private $dat_datafim;
		private $str_mensagem;
		private $boo_confleitura;
		
		// id bigserial NOT NULL
		public function setId( $int_id )
		{
			$this->int_id = $int_id;
		}
		
	    public function getId()
		{
			return $this->int_id;
		}
		
		// idvendedor integer
		public function setIdVendedor( $int_idvendedor )
		{
			$this->int_idvendedor = $int_idvendedor;
		}
		
	    public function getIdVendedor()
		{
			return $this->int_idvendedor;
		}
		
		// ddata_inicio date
		public function setDataIni( $dat_datainicio )
		{
			$this->dat_datainicio = $dat_datainicio;
		}
		
	    public function getDataIni()
		{
			return $this->dat_datainicio;
		}
		
  		// ddata_fim date
  		public function setDataFim( $dat_datafim )
		{
			$this->dat_datafim = $dat_datafim;
		}
		
	    public function getDataFim()
		{
			return $this->dat_datafim;
		}
		
  		// smensagem text
  		public function setMensagem( $str_mensagem )
		{
			$this->str_mensagem = $str_mensagem;
		}
		
	    public function getMensagem()
		{
			return $this->str_mensagem;
		}
		 
 		// sconfirmacao_leitura boolean
 		public function setConfLeitura( $boo_confleitura )
		{
			$this->boo_confleitura = $boo_confleitura;
		}
		
	    public function getConfLeitura()
		{
			return $this->boo_confleitura;
		}
		
		public function getMensagens() 
		{
 			$v_mensagens = array();
        	$str_sqlQuery    = "SELECT * 
        						FROM 
        							mensagem 
        						WHERE sconfirmacao_leitura = false and idvendedor = ".$_SESSION['_app_user']['id']." ";
			$str_sqlQuery.= " ORDER BY sconfirmacao_leitura, ddata_fim desc LIMIT 5 OFFSET 0;";
 
        	$o_db = new DB();
       		$o_db->connection();
			$o_db->executeQuery( $str_sqlQuery );
			
			while( $o_ret = $o_db->fetchObject() )
			{
				$o_mensagem = new MensagemModel();
				$o_mensagem->setId		   ( $o_ret->id );
				$o_mensagem->setIdVendedor ( $o_ret->idvendedor );
				$o_mensagem->setDataIni	   ( $o_ret->ddata_inicio );
				$o_mensagem->setDataFim	   ( $o_ret->ddata_fim );
				$o_mensagem->setMensagem   ( $o_ret->smensagem);
				$o_mensagem->setConfLeitura( $o_ret->sconfirmacao_leitura);
						
				array_push( $v_mensagens, $o_mensagem);
			}
						
        	$o_db->disconnect();
    		return $v_mensagens;
    	}
		
		public function getTotalMensagens( $dat_dataini, $dat_datafim, $boo_nao_lidas )
		{
			$str_dataini = Functions::dbdate ( $dat_dataini );
			$str_datafim = Functions::dbdate ( $dat_datafim );
			
        	$str_sqlQuery = "SELECT * 
        						FROM 
        							mensagem 
        					WHERE idvendedor = ".$_SESSION['_app_user']['id']." ";
							
			if($str_dataini <> '' )
				$str_sqlQuery.= " and ddata_fim >= '".$str_dataini."'" ;
			if($str_datafim <> '' )
				$str_sqlQuery.= " and ddata_fim <= '".$str_datafim."'" ;
			if( $boo_nao_lidas == true )
			   $str_sqlQuery.= " and sconfirmacao_leitura = false";
			
			$str_sqlQuery.= " ORDER BY sconfirmacao_leitura, ddata_fim desc;";
			
		    $o_db = new DB();
       		$o_db->connection();
			$o_db->executeQuery( $str_sqlQuery );
			$int_linhas = $o_db->numRows();
			
 			$o_db->disconnect();
    		return $int_linhas;
		}
		
		public function getMensagensPaginadas( $int_primeiroreg, $int_numporpagina, $dat_dataini, $dat_datafim, $boo_nao_lidas )
		{
			$str_dataini = Functions::dbdate ( $dat_dataini );
			$str_datafim = Functions::dbdate ( $dat_datafim );
			
			$v_mensagens = array();
			$str_sqlQuery = "SELECT * 
        						FROM 
        							mensagem 
        					WHERE idvendedor = ".$_SESSION['_app_user']['id']." ";
							
			if($str_dataini <> '' )
				$str_sqlQuery.= " and ddata_fim >= '".$str_dataini."'" ;
			if($str_datafim <> '' )
				$str_sqlQuery.= " and ddata_fim <= '".$str_datafim."'" ;
			if( $boo_nao_lidas == true )
			   $str_sqlQuery.= " and sconfirmacao_leitura = false";
			
			$str_sqlQuery.= " ORDER BY sconfirmacao_leitura, ddata_fim desc LIMIT " .$int_numporpagina. " OFFSET " . $int_primeiroreg.";";
			
			$o_db = new DB();
       		$o_db->connection();
			$o_db->executeQuery( $str_sqlQuery );
			
			while( $o_ret = $o_db->fetchObject() )
			{
				$o_mensagem = new MensagemModel();
				$o_mensagem->setId		   ( $o_ret->id );
				$o_mensagem->setIdVendedor ( $o_ret->idvendedor );
				$o_mensagem->setDataIni	   ( $o_ret->ddata_inicio );
				$o_mensagem->setDataFim	   ( $o_ret->ddata_fim );
				$o_mensagem->setMensagem   ( $o_ret->smensagem);
				$o_mensagem->setConfLeitura( $o_ret->sconfirmacao_leitura);
						
				array_push( $v_mensagens, $o_mensagem);
			}
						
        	$o_db->disconnect();
    		return $v_mensagens;
		}
		
		public function updateLida( $int_id, $boo_lida )
		{
			$str_sqlQuery  = "UPDATE mensagem SET sconfirmacao_leitura = ".$boo_lida." ";
			$str_sqlQuery .= "WHERE id = ".$int_id.";";
			$o_db = new DB();
       		$o_db->connection();
			$o_db->executeQuery( $str_sqlQuery );
			$o_db->disconnect();
		}
	}
?>