<?php
	/*
	 * Gerenciar o banco de dados
	 */
	require_once 'config.php';
	 
	class DB 
	{
		private $str_host;
		private $str_port;
		private $str_name;
		private $str_user;
		private $str_pass;
		private $con;
		private $result;
		public  $table;
			
		public function connection() 
		{
			$this->str_host = DB_HOST;
			$this->str_port = DB_PORT;
			$this->str_name = DB_NAME;
			$this->str_user = DB_USER;
			$this->str_pass = DB_PASS;
			
			$this->con = @pg_connect( 'host='.$this->str_host. ' port='.$this->str_port.
									  ' dbname='.$this->str_name. ' user='.$this->str_user.
									  ' password='.$this->str_pass );
			
			if( !$this->con )
				throw new Exception( 'Falha ao se conectar ao Banco de Dados '.@pg_last_error() );
		}
		
		public function executeQuery( $str_query = '' )
		{
			if( empty( $str_query ) )
				throw new Excepiton('Erro: Query não informada! ');
			
			unset( $this->result );

			$this->result = @pg_query( $this->con, $str_query );
			
			if( empty($this->result ) )
				throw new Exception( 'Falha ao executar a query: '.@pg_last_error($this->con ) );
			else return $this->result;
	  	}
		
		public function numRows()
		{
			return @pg_num_rows( $this->result );
		}
		
		public function fetchObject()
		{
		   return @pg_fetch_object ( $this->result );	
		}
		
		public function disconnect()
		{
			
			// Free resultset
			pg_free_result( $this->result );
				
			/*if( !@pg_close( $this->Con ) )
				throw new Exception('Falha ao se desconectar do Servidor Banco de Dados: '.pg_last_error() ); */
		}
	}
?>