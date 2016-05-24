<?php
    require_once ( 'lib/db.php' );
	
    class gradeModel
    {
    	private $int_id;
		private $str_grade;
		private $int_qtd_prod;
		
    	// idgrade
    	public function setId( $int_id )
		{
			$this->int_id = $int_id;
		}
		
	    public function getId()
		{
			return $this->int_id;
		}
		
  		// sgrade Size ( 3 ) NOT NULL
  		public function setGrade( $str_grade )
		{
			$this->str_grade = $str_grade;
		}
		
	    public function getGrade()
		{
			return $this->str_grade;
		}
		
		// iquantidade
  		public function setQtdProd ( $int_qtd_prod )
		{
			$this->int_qtd_prod = $int_qtd_prod;
		}
		
	    public function getQtdProd()
		{
			return $this->int_qtd_prod;
		} 
		
		public function getGradesProduto( $int_idproduto )
		{	
			$v_grades     = array();
        	$str_sqlQuery = 'SELECT 
        					   pg.idgrade, 
        					   g.sgrade, 
        					   pg.iquantidade 
        					 FROM 
        					   produto_grade pg 
        					   JOIN grade g 
        					   ON g.id = pg.idgrade  
        					 WHERE  pg.idproduto = '.$int_idproduto;
 
        	$o_db = new DB();
       		$o_db->connection();
			$o_db->executeQuery( $str_sqlQuery );
			
			while( $o_ret = $o_db->fetchObject() )
			{
				$o_grade = new gradeModel();
				$o_grade->setId     ( $o_ret->idgrade );
				$o_grade->setGrade  ( $o_ret->sgrade );
				$o_grade->setQtdProd( $o_ret->iquantidade );
  								
				array_push( $v_grades, $o_grade );
			}	
			
        	$o_db->disconnect();
    		return $v_grades;
		}
		
		public function load( $int_id )
		{
			$str_sqlQuery = 'SELECT * FROM grade WHERE id = '.$int_id.';';	
			$o_db = new DB();
       		$o_db->connection();
			$o_db->executeQuery( $str_sqlQuery );
			$o_ret = $o_db->fetchObject();
			
			$this->setId    ( $o_ret->id );
			$this->setGrade ( $o_ret->sgrade );
			
			$o_db->disconnect();
			return $this;
		}
  			
    }
?>