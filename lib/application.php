<?php
	function __autoload( $str_class )
	{
		if ( file_exists( 'lib/'.$str_class.'.php' ) )
			require_once 'lib/'.$str_class.'.php';
	}
	
	class Application
	{
		/*
		 * Armazena o nome da classe controle.  
		 */
		protected $str_controller;
		
		/*
		 * Armazena o médodo de controle a ser executado.
		 */ 
		protected $str_action;
		
		/*
		 * Carrega os parêmetros passados   
		 */
		private function loadWay()
		{
			$this->str_controller = isset ( $_REQUEST['ctrl']   ) ? $_REQUEST['ctrl'] 	 : 'index';
		
			$this->str_action 	  = isset ( $_REQUEST['action'] ) ?  $_REQUEST['action'] : 'index';
		}
		
		/*
		 * Inicia a sessao e verifica se está logado
		 */
		private function section()
		{
			session_start();
			if ( $this->str_controller != 'section' )
			{
				if (!isset($_SESSION[ '_app_user' ]['logado'])) 
				{
      				$this->redirect('?ctrl=section&action=login');
   				}
			}
		}
		
		/*
		 * Verifica se é busca
		 */
		private function search()
		{			
			if( isset ( $_REQUEST['_busca_'] ) )
			{	
				$this->redirect('?ctrl=produto&action=listarProdutos&st_ser='.$_REQUEST['_busca_'] );
			}
		}
		
		/*
		 * Instancia controller 
		 */ 
		public function dispatch()
		{
			$this->loadWay();
			
			// Verifica se está logado ao sistema	
			$this->section();
			
			// Verifica se é busca
			$this->search();
			
			$str_ctrl_file = 'controller/'.$this->str_controller.'Ctrl.php';
	
			if( file_exists( $str_ctrl_file ) )
			   require_once $str_ctrl_file;
			else
				throw new Exception( 'Arquivo '.$str_ctrl_file.' não encontrado!' );
			
			$str_class = $this->str_controller.'Ctrl';
		    if( class_exists( $str_class ) )
				$o_class = new $str_class;
			else
				throw new Exception( 'Classe '.$str_class.' não existe no arquivo '.$str_ctrl_file );
			
			$str_method = $this->str_action.'Action'; 
			if( method_exists ( $o_class, $str_method ) )
				$o_class->$str_method();
			else
				throw new Exception( 'Método '.$str_method.' não existe na classe '.$str_class );
		}
		
		/*
		 * Redireciona a página, static pois pode ser acessado sem instanciar a classe 
		 */
		 public static function redirect ( $str_url )
		 {
		 	header( 'Location: ' .$str_url );
		 }
	}
   
?>