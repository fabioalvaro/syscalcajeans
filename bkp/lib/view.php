<?php
	/*
	 * Classe utilizada para renderizar os arquivos HTML
	 */
	class View
	{
		/*
		 * Armazena o conteúdo do HTML
		 */
		private $str_contents;
	
		/*
		 * Armazena o nome do arquivo de visualização
		 */
		private $str_view;
		
		/*
		 * Armazena os dados que devem ser exibidos ao renderizar o arquivo de visualização 
		 */
		private $v_params;
		
		function __construct( $str_view = null, $v_params = null )
		{
			if( $str_view != null )
				$this->setView( $str_view );
			$this->v_params = $v_params;	
		} 
		
		/*
		 * Define qual arquivo HTML será renderizado 
		 */
		public function setView( $str_view )
		{
			if( file_exists( $str_view ) )
				$this->str_view = $str_view;
			else
				throw new Exception( 'Arquivo View '. $str_view.' não encontrado!' );	
		}
		
		public function getView()
		{
			return $this->str_view;
		}
		
		/*
		 * Define os dados que devem ir para view 
		 */   
		public function setParams( Array $v_params )
		{
			$this->v_params = $v_params;	
		}
		
		public function getParams()
		{
			return $this->v_params;
		}
		
		/*
		 * Retetorna o conteúdo do arquivo de visualização
		 */ 
		public function getContents()
		{
			ob_start();
			if( isset($this->str_view ) )
				require_once $this->str_view;
			$this->str_contents = ob_get_contents();
			ob_end_clean();
			
			return $this->str_contents;	
		}
		
		/*
		 * Imprime o arquivo de visualização 
		 */ 
		public function showContents()
		{
			echo $this->getContents();
			exit;
		}
	}

?>